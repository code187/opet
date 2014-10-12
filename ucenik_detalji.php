<script type="text/javascript">
$(document).ready(function() {
  $('div.mjeseci> div').hide();
  $('div.mjeseci> h3').click(function() {
 var $nextDiv = $(this).next();
 var $visibleSiblings = $nextDiv.siblings('div:visible');
 if ($visibleSiblings.length ) {
   $visibleSiblings.slideUp('fast', function() {
  $nextDiv.slideToggle('fast');
   });
 } else {
    $nextDiv.slideToggle('fast');
 }
  });
   //mjeseci od 1 - 12
	$('#10').show(); 
  
});
</script>
<script>
    	function GetUrlValue(VarSearch){
    var SearchString = window.location.search.substring(1);
    var VariableArray = SearchString.split('&');
    for(var i = 0; i < VariableArray.length; i++){
        var KeyValuePair = VariableArray[i].split('=');
        if(KeyValuePair[0] == VarSearch){
            return KeyValuePair[1];
        }
    }
}
    </script>
<script>
 $(document).ready(function() {
        $('#showmenu').click(function() {
                $('.menu').slideToggle("fast");
        });
    });
</script>
<?php
error_reporting(0);
	$p=$_POST['p'];
	$m=$_POST['m'];
	$idk= $_POST['idk'];
    $firstName = $_POST['x'];
	$pred= $_POST['pred'];
	$razred= $_POST['razred'];
	$cita= $_POST['citao'];
	$citao=str_replace("undefined"," ",$cita);
//Baza i username i password
$baza = "gaudeam_knex2013";
$korisnik = "gaudeam_knex";
$lozinka = "@00886726@";

$spoj = mysql_connect("localhost","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA 003 - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");

$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA 002 - Baza nije pronadena na serveru!</span>");


$check = mysql_query("SELECT * FROM korisnici WHERE x = $idk")or die(mysql_error());
$in=mysql_fetch_array($check);
 //Gives error if user dosen't exist
include "postavke.php";
include "funkcije.php";
$idk = $in['x']; 
//echo $citao;
if ($idk!="")
	{
		$razred=razred($idk);
		//znaci da je korisnik u bazi, no provjeri je li to ucenik?
		$pr = prava_korisnik_id($idk);
		if ($pr=="1") //e sad je to ucenik
			{	
				$razrednik=razrednik($user);
				if ($razrednik=="0" and $prava_postavke=="2")
				{
					//je li mentor?
					$jeli_mentor="select * from korisnici where x=$user and mentor like '%$idk%';";
					$rezu_mentor = mysql_query($jeli_mentor) or die("<span class=podnaslovi_crveni>Greška prilikom upita ovlasti mentora!</span>");
					$cu_mentor = mysql_num_rows($rezu_mentor); 
					if ($cu_mentor!="0")
					echo "<span class=nazad><a onclick='nazad(); return false;'' href=druga.html><img src=images/povratak.png border=0 title=Povratak alt=Povratak><br /></a></span>";
					else					
					echo "<span class=nazad><a onclick='nazad(); return false;'' href=druga.html><img src=images/povratak.png border=0 title=Povratak alt=Povratak><br /></a></span>";
				}
				else
				{
					if ($idk!="nula")
					{
					if ($razrednik == $razred or $prava_postavke=="3")
					echo "<span class=nazad><a onclick='nazad(); return false;'' href=druga.html><img src=images/povratak.png border=0 title=Povratak alt=Povratak><br /></a></span>";
					else
					echo "<span class=nazad><a onclick='nazad(); return false;'' href=druga.html><img src=images/povratak.png border=0 title=Povratak alt=Povratak><br /></a></span>";
					}
					else
					echo "<span class=nazad><a onclick='nazad(); return false;' href=druga.html><img src=images/povratak.png border=0 title=Povratak alt=Povratak><br /></a></span>";
				}
				//prebacivanje na drugog ucenika
				if ($prava_postavke=="3" or $prava_postavke=="2")
				{
					echo "<form name=form_slanje id=form1 method=post action='admin.php?p=ucenik_detalji&m=nastava&drop=1&pred=$pred' style='float:right; margin-right:25px; margin-top:5px;' >";
					echo "<select name=idk id=idk class=drugi_ucenik onChange='this.form.submit()'>";
     				//daj mi ostale iz njegovog razreda
					$ab_ucenici="SELECT *,replace(replace(replace(replace(replace(puno,'&#268;','Cxx'),'Š','Sx'),'&#381;','Zx'),'&#272;','Dx'),'&#262;','Cx') sortiraj FROM korisnici where status='$razred' ORDER BY sortiraj ASC";
					//echo $ab_ucenici;
					$rezb_ucenici = mysql_query($ab_ucenici) or die("<span class=podnaslovi_crveni>Greška prilikom upita u bazu korisnika!</span>");
					while ($reb_ucenici = mysql_fetch_array($rezb_ucenici))
						{
							$uc_iz_razreda = $reb_ucenici["x"]; 
							$ime_kolege = puno_ime($uc_iz_razreda);
							if ($idk == $uc_iz_razreda) 
							$sel = "selected=selected";
							else
							$sel="";
							echo "<option value=$uc_iz_razreda $sel>$ime_kolege</option>";
						}
     				 echo "</select></form>"; 
				}
				
				$is_broj = oznaka_predmeta ($pred);
				$jeliprofesor = profesor_predmet ($is_broj);
				/*if ($jeliprofesor>0)
					{
						if ($jeliprofesor==$user)
						{*/
							if ($citao!="undefined")
							{
								$a="select id from forum_postovi where id=$citao and pogledao like '%$user%';";
								echo $a;
								$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom upita izvještaja!1</span>");
								$c = mysql_num_rows($rez);
								if ($c=="0") {
								$a="update forum_postovi set pogledao=concat(pogledao,',$user,') where prip='u-$idk-$pred' and id='$citao' order by moze desc ";	
								//echo $a;
								$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom azuriranja tkoje zadnji vidio post!</span>");
								}
								//ako su roditelj ili ucenik provjeri ima li ih kod izvještaja?
								if ($prava_postavke=="1" or $prava_postavke=="4")
								{
									$au="select id from izvjestaji where pripadnost=$pred and pogledao not like '%$user%';";
									//echo $au;
									$rezu = mysql_query($au) or die("<span class=podnaslovi_crveni>Greška prilikom upita pregleda izvještaja!</span>");
									$cu = mysql_num_rows($rezu); //echo "n $cu";
									if ($cu!="0") 
									{
										$ap="update izvjestaji set pogledao=concat(pogledao,',$user,') where pripadnost='$pred'";	
										//echo $ap;
										$rezp = mysql_query($ap) or die("<span class=podnaslovi_crveni>Greška prilikom azuriranja tkoje zadnji vidio post!</span>");
									}
								}
							}
							else
							{
								
									$au="select id from izvjestaji where pripadnost=$pred and pogledao not like '%$user%';";
									//echo $au;
									$rezu = mysql_query($au) or die("<span class=podnaslovi_crveni>Greška prilikom upita pregleda izvještaja!</span>");
									$cu = mysql_num_rows($rezu); //echo "n $cu";
									if ($cu!="0") 
									{
										$ap="update izvjestaji set pogledao=concat(pogledao,',$user,') where pripadnost='$pred'";	
										//echo $ap;
										$rezp = mysql_query($ap) or die("<span class=podnaslovi_crveni>Greška prilikom azuriranja tkoje zadnji vidio post!</span>");
									}
								$drop=1;
								if ($drop==1)
								{
									$a="select id from forum_postovi where prip='u-$idk-$pred' and pogledao not like '%$user%';";
									//echo $a;
									$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom upita izvještaja!</span>");
									$c = mysql_num_rows($rez);
									if ($c!="0") 
										{
											$a="update forum_postovi set pogledao=concat(pogledao,',$user,') where prip='u-$idk-$pred' order by moze desc";	
											$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom azuriranja tkoje zadnji vidio post!</span>");
										}
								}
							}
						/*}
					}*/
				$jelirazrednik = razrednik ($user);
				if ($jelirazrednik>0)
					{
						if ($jelirazrednik==$razred)
						{
							if ($citao!="")
							{
								$a="update forum_postovi set pogledao='$user' where prip='u-$idk' and id='$citao' order by moze desc ";	
								//echo $a;
								$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom azuriranja tkoje zadnji vidio post!</span>");
							}
							else
							{
								if ($drop==1)
								{
									$a="update forum_postovi set pogledao='$user' where prip='u-$idk' order by moze desc limit 1";	
								//echo $a;
								$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom azuriranja tkoje zadnji vidio post!</span>");	
								}
							}
						}
					}
				//ima li predložene ocjene?
				$a="select pl_oc from conf_predmeta where id=$pred";	
				$rezd = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom upita ocjene!</span>");
				$cd = mysql_num_rows($rezd);
				if ($cd=="0")
					echo "<span class=podnaslovi_crveni>Trenutno nema planirane ocjene! Greška predmeta?</span>";
				else
					{ 
						while ($re = mysql_fetch_array($rezd))
						{   $pl_oc = $re["pl_oc"];
							$pos = strpos($pl_oc, $idk);
							//pokupi napomenu iz baze
							$query = "select ime from conf_predmeta where id=$pred";
							$izlaz = mysql_query($query);
							while ($rec = mysql_fetch_array($izlaz))
							{
									$napomena = $rec["ime"];
							}
							if ($pos === false) {
 	   						$ocjena = "nije upisana";
							if ($napomena!="")
								echo "<span class=podnaslovi><h3>$napomena</h3><br /><p>Planirana ocjena: $ocjena</p></span><br><br>";
							else
								echo "<span class=podnaslovi><h3>$napomena</h3><br /><p>Planirana ocjena: $ocjena</p></span><br><br>";
							}
							else 
							{
								$niz = json_decode($pl_oc);
								$ocjena = $niz->{"$idk"};
								if ($napomena!="")
								echo "<span class=podnaslovi><h3>$napomena</h3><br /><p>Planirana ocjena: $ocjena</p></span><br><br>";
								else
								echo "<span class=podnaslovi><h3>$napomena</h3><br /><p>Planirana ocjena: $ocjena</p></span><br><br>";
							}
						}
					}
				//pronadi sve dostupne predmete razreda i ispiši ih, a na klik se otvaraju detalji o svakom predmetu
				$a="select * from izvjestaji where pripadnost=$pred order by datum asc;";	
				//echo $a;
				$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom upita izvještaja!</span>");
				$c = mysql_num_rows($rez);
				if ($c=="0")
					echo "Trenutno nema izvještaja za $pred_ime!";
				else
					{ 
						//ima izvještaja i sada iz svakoga trebamo pokupiti što kaže za našeg ucenika
						$bojko = "";$j=0;
						while ($re = mysql_fetch_array($rez))
						{
							$brojim=0;  $samo_bilj=0; $niz=0; $imakuc=0;
							$unos = $re["unosi"];
							$niz_unosa[$j]="$unos";
							$j++;
							$datum = $re["datum"];
							$datum_izvj = $datum;
							$datum= date("d.m.Y", $datum);
							$naziv = $re["naziv"];
							$elementi = $re["element"];	
							$uk=$re["uk"];
							$ukb=$re["ukb"];	
							$napomene = $re["napomene"];	
							 $el_predmeta = elementi_razred($pred); //elementi predmeta
							 $el_predmeta = explode("//",$el_predmeta);
							 if (is_array($el_predmeta))
								$ok_el = 1;
								 else {
								 echo "<span class=podnaslovi>Još nisu uneseni elementi ocjenjivanja za ovaj predmet.</span>"; die(); }	  
							  //postoji li uopce taj ucenik u izvještaju? ako ne nemoj mu ni prikazati bilješku!
							  $kuc="select ucenik, mjesec_izvjestaja from izvjestaj$unos where ucenik=$idk";
							  //echo $kuc;
							  $kucc = mysql_query($kuc) or die("<span class=podnaslovi_crveni>Greška prilikom upita ucenika u izvjestajima!</span>");
							  $imakuc = mysql_num_rows($kucc); 
							  while ($mljac = mysql_fetch_array($kucc))
							  	{
									$mj_iz = $mljac["mjesec_izvjestaja"];	
								}
								//echo "laaaa $mj_iz";
								//$biljeska = "";
							  if ($imakuc>0)
							  {
							  	$biljeska[$mj_iz] .= "<tr style=border:none;><td align=left valign=top style=border:none;><b>$datum:</b></td><td align=left valign=top style=border:none;>$naziv";
							 	$napomene = str_replace("<br>","",$napomene);
							  	
							  	$result = mysql_query("SHOW columns from izvjestaj$unos");
							 	$c_res = mysql_num_fields($result);
							 	$c_res=$c_res-3;
							 	while ($ref = mysql_fetch_array($result))
							  	{
									$field = $ref["Field"];	
									//$field = charset_decode_utf_8($field);
									if ($field == "id" or $field == "ucenik" or $field == "mjesec_izvjestaja")
									{
										echo "";
									}
									else
									{
									//ako polje nije u bazi elementi onda ga samo ubaci u biljesku
									//$field = charset_decode_utf_8($field);
									//$field_njah = htmlentities($field);
									$field_njah = html_entity_decode($field);
									//ako zatreba - ovdje promjeni da se opet ne prikazuje ocjena iz rubirke u bilješci!
									//$bgc="select * from elementi where izvjestaj=$unos and polje='$field_njah'";
									//echo $bgc;
									//$rezbgc = mysql_query($bgc) or die("Greška prilikom upita elemenata!");
									//$c_njahc = mysql_num_rows($rezbgc);
									//echo "$bgc - $c_njahc<br>";
									//if ($c_njahc =="0")
									//{
										//$biljeska .= " - $field";
										
										$bg="select `$field` from izvjestaj$unos where ucenik = $idk";
											$rezbg = mysql_query($bg) or die("<span class=podnaslovi_crveni>Greška prilikom upita izvještaja$unos sss!</span>");
							  				while ($refs = mysql_fetch_array($rezbg))
												{
													//polje je uk
													if ($uk=="1")
													$biljeska[$mj_iz] .="; $field ($refs[$field])";
													else
													$biljeska[$mj_iz] .="; $refs[$field]";
												}
									//}
									}
								} 
								if ($ukb=="1")
							  	$biljeska[$mj_iz] .=" ($napomene)";
								$biljeska[$mj_iz] .="</td></tr>"; }
						}
					}
						
							
						
						?>
<table id="tablica_lijevoc2">
      <tr class="alt">
        <td width="34%" align="center" >&nbsp;</td>
        <td width="6%" align="center"><p align="center">9.</p></td>
        <td width="6%"  align="center"><p align="center">10.</p></td>
        <td width="6%" align="center"><p align="center">11.</p></td>
        <td width="6%" align="center"><p align="center">12.</p></td>
        <td width="6%" align="center"><p align="center">1.</p></td>
        <td width="6%" align="center"><p align="center">2.</p></td>
        <td width="6%" align="center"><p align="center">3.</p></td>
        <td width="6%" align="center"><p align="center">4.</p></td>
        <td width="6%" align="center"><p align="center">5.</p></td>
        <td width="6%" align="center"><p align="center">6.</p></td>
        <td width="6%" align="center"><p align="center">7.</p></td>
      </tr>
      <?php //ima elemenata
	  if ($ok_el=="1")
	  	{
			$counti=0;
			$nizele = count($el_predmeta);
			$nizele--; //smanji za jedan prazan element
			if ($nizele > 5)
			$kolikobroj = 6;
			else
			$kolikobroj = 5;
			while ($counti < $kolikobroj)
			{
					$brojims = $counti+1; $ocjena_ispis="";
					echo "<tr><td>$el_predmeta[$counti]</td>";
					$bris = array(9,10,11,12,1,2,3,4,5,6,7);
					foreach ($bris as $bri) //svaki mjesec
					{
						$ocjena_ispis="";
						//sort($niz_unosa);
						foreach ($niz_unosa as $unos) //svaki izvjestaj
						{
							$bg="select id,polje from elementi where izvjestaj=$unos and ime=$brojims";
							//echo "$unos<br>";
							$rezbg = mysql_query($bg) or die("<span class=podnaslovi_crveni>Greška prilikom upita elemenata u popisu izvjestaja!</span>");
							$c_njah = mysql_num_rows($rezbg);
							//echo "$c_njah<br>";
							if ($c_njah!="0")
							{
								while ($refs = mysql_fetch_array($rezbg))
								$polje =$refs["polje"];
								if ($polje!="")
								{
									$polje = charset_decode_utf_8($polje);
									
									$bg="select `$polje`,mjesec_izvjestaja,ucenik from izvjestaj$unos where ucenik=$idk and mjesec_izvjestaja=$bri;";
									//echo "$bg<br>";
									
									$rezbg = mysql_query($bg) or die("<span class=podnaslovi_crveni>Greška prilikom upita elemenata u izvjestaju!</span>");
									
									while ($refs = mysql_fetch_array($rezbg))
									$ocjena_ispis .="$refs[$polje],";
								}
						
							}
						}
						if ($ocjena_ispis=="")
						$ocjena_ispis="&nbsp;";
						else //smajliji
							$ocjena_ispis = preg_replace($patterns, $replacements, $ocjena_ispis);
							
						echo "<td>$ocjena_ispis</td>";
						$bri++;
					}
					
					echo "</tr>"; //echo $nizele;
				$counti++;
			}
		}
		?>
    
    </table>
    <span class="podnaslovi"><h4>Bilje&scaron;ke</h4></span>
    <table id="tablica_mjesci" cellpadding="0" cellspacing="0">

  <tr >
    <td><!-- ispisati sve mjesece i otvoriti tekuci ostali su ispod zatvoreni poredani od rujna do lipnja -->
<div class="mjeseci">
	<?php 
	mysql_query('set names utf8');
	$bris_mj = array("kolovoz","rujan","listopad","studeni","prosinac","sije&#269;anj", "velja&#269;a","ožujak","travanj","svibanj","lipanj","srpanj");
	$bris = array(8,9,10,11,12,1,2,3,4,5,6,7);
    //$br_mj=0;
	foreach ($bris_mj as $mjes)
	{
		echo "<h3 class=rub id=icon8>$mjes</h3>";
		$boj_mj = $bris[$br_mj];
		if ($biljeska[$boj_mj]=="")
		$biljeska[$boj_mj] = "U ovom mjesecu trenutno nema bilje&scaron;ki.";
		//smajliji
		$biljeska[$boj_mj] = preg_replace($patterns, $replacements, $biljeska[$boj_mj]);
		echo "<div id=$boj_mj class=rub><table border=0 width=100% cellpadding=0 cellspacing=0 style=border:none;>$biljeska[$boj_mj]</table></div>";
		$br_mj++;
	}
	
	?>
    </div></td>
  </tr>
</table>

<?php
	//postovi korisnika
						 }}
		/*	}
		else
			echo "<b>Uneseni korisnik nije u&#269;enik!</b>";
	}
	else
	echo "<b>GREŠKA u sustavu ili ne ovlašteni ulaz!</b>";*/
?>