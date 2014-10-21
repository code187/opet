<script language="javascript">
   function nazad(){
       window.location='http://gaudeamus.hr/mobile/druga.html'
    }
</script>
<script>
 $(document).ready(function() {
	  function onSuccess()
        {
           location.reload();
		}
        $('#showmenu').click(function() {
                $('.menu').slideToggle("fast");
        });
		$("#posaljime").click(function(){
  
                var formData = $("#nasaforma").serialize();
  
                $.ajax({
                    type: "POST",
                    url: "http://gaudeamus.hr/mobile/post_snimanje_predmeti.php",
                    cache: false,
                    data: formData,
                    success: onSuccess
                });
  
                return false;
            });
    });
</script>
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
	$citao= $_POST['citao'];
	//$citao=str_replace('undefined','nula',$cita);
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
echo $citao;

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
					echo "<span class=nazad><a onclick='nazad(); return false;'' href=http:gaudeamus.hr/mobile/druga.html><img src=images/povratak.png border=0 title=Povratak alt=Povratak><br /></a></span>";
					else					
					echo "<span class=nazad><a onclick='nazad(); return false;'' href=http://gaudeamus.hr/mobile/druga.html><img src=images/povratak.png border=0 title=Povratak alt=Povratak><br /></a></span>";
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
							if ($citao!="")
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
        <td width="34%" align="center">&nbsp;</td>
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
    <span class="podnaslovi"><h2>Bilje&scaron;ke</h2></span>
    <table id="tablica_mjesci" cellpadding="0" cellspacing="0">

  <tr >
    <td><!-- ispisati sve mjesece i otvoriti tekuci ostali su ispod zatvoreni poredani od rujna do lipnja -->
<div class="mjeseci">
	<?php 
	mysql_query('set names utf8');
	$bris_mj = array("kolovoz","rujan","listopad","studeni","prosinac","sije&#269;anj", "velja&#269;a","o&#382;ujak","travanj","svibanj","lipanj","srpanj");
	$bris = array(8,9,10,11,12,1,2,3,4,5,6,7);
    //$br_mj=0;
	foreach ($bris_mj as $mjes)
	{
		echo "<h3 class=rub id=icon8>$mjes</h3>";
		$boj_mj = $bris[$br_mj];
		if ($biljeska[$boj_mj]=="")
		$biljeska[$boj_mj] = "<p>U ovom mjesecu trenutno nema bilje&scaron;ki.</p>";
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
$prava_kor = $in['prava'];
	mysql_query('set names utf8');
	$a = "select * from forum_postovi where prip = 'u-$idk-$pred' order by id desc";
	//echo $a;
echo "<ul id=postovi>";
$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja tablice postova!</span>");

while ($re = mysql_fetch_array($rez))
				{	
					$pt_id = $re["id"]; 
					$red_idova[]=$re["id"];
					$pt_tko = $re["tko"];
					$post_at = $pt_tko;
					$pt_opis = $re["opis"];
					$pt_kada=$re["kada"];
					$tko_sm=$re["tko_smije"];
					$automatika = $re["automatika"];
					$pt_kratki_datum=$re["moze"];
					//nastavnik - color="#8ec6e9"
					//ucenik - bgcolor=#F6F6F6
					//nastavnik i roditelj - f2d4b4
					if ($tko_sm=="2") //nastavnik
					$bojko="bgcolor=#8ec6e9";
					elseif ($tko_sm=="3") //nastavnik i roditelj
					$bojko="bgcolor=#f2d4b4";
					elseif ($tko_sm=="4") //ucenik
					$bojko="bgcolor=#ebf6ad";
					else
					{
						if ($bojko=="class=alt") {$bojko="";} else {$bojko="class=alt";}
					}
					echo "<tr ".$bojko.">";	
					$pt_mozel = $pt_tko;
					$pt_tko = puno_ime($pt_tko);
					$slika_korisnika=slika_korisnika($pt_mozel);
					if ($slika_korisnika!="")
					{
						$filename="doc/fotke/korisnici/$slika_korisnika";
						if (file_exists($filename)) 
							$slika = "doc/fotke/korisnici/$slika_korisnika";
							else
							$slika = "images/nepoznati_user.png";
					}
					$datumic = date("j.m.Y");
					$danas=explode(" - ",$pt_kada);
					if ($danas[0] == $datumic)
					$pt_kada="Danas - $danas[1]";
					if ($prava_kor=="3")
					$ispis_ured = "<a href=admin.php?p=ucenik&m=nastava&ak=7&idic=$pt_id&idk=$idk&razred=$razred><img src='images/delete1.png' border=0 title=Obri&scaron;i alt=Obri&scaron;i></a>";
					else 
					{
						//razrednik smije brisati auto komentare
						$razrednik=razrednik($user);
						if ($razrednik!="0" and $automatika!="0")
						{
							$ispis_ured = "<a href=admin.php?p=ucenik&m=nastava&ak=7&idic=$pt_id&idk=$idk&razred=$razred><img src='images/delete1.png' border=0 title=Obri&scaron;i alt=Obri&scaron;i></a>";
						}
						else
						$ispis_ured ="";
					}
					$pt_opis=nl2br($pt_opis);
					$nadi="||||";
					$pos = strpos($pt_opis, $nadi);
					if ($pos!==false)
					{
						$tklik = explode("||||",$pt_opis);
						$ses = explode("&s=",$tklik[1]);
						$to = explode("target=_blank",$ses[1]); // tu je sada sesija
						$ns = session_id();
						$tfinal = "$ses[0]&s=$ns target=_blank>Prilo&#382;eni dokument</a>";
						$pt_opis = "$tklik[0]</div><div class=nista>$tfinal";
					}
					//ako nije prošlo 1h od objave posta - omoguci njegovo uredivanje
					$sada_kratko = date("U");
					$postovo_kratko = $pt_kratki_datum + 3600; //unutar sat vremena
					if ($sada_kratko<$postovo_kratko and $user==$post_at)
					$pt_opis="<div class=jsonic id='$pt_id'>$pt_opis</div>";
					$pt_opis = str_replace("š","&scaron;",$pt_opis);
					$pt_opis = str_replace("Š","&Scaron;",$pt_opis);
					$pt_opis = str_replace("ž","&#382;",$pt_opis);
					$pt_opis = str_replace("Ž","&#382;",$pt_opis);
					$pt_tko = str_replace("š","&scaron;",$pt_tko);
					$pt_tko = str_replace("Š","&Scaron;",$pt_tko);
					$pt_tko = str_replace("ž","&#382;",$pt_tko);
					$pt_tko = str_replace("Ž","&#382;",$pt_tko);
					//dodaj donji border kada su drugacije ofarbani
					
					if ($tko_sm=="2" or $tko_sm=="3" or $tko_sm=="4") //nastavnik
					echo "<td align=left valign=middle width=70% height=25 style='border-bottom:1px solid #b9b9b9;'>$pt_opis</td><td valign=top width=10% style='border-bottom:1px solid #b9b9b9;'>$pt_kada</td><td style='border-bottom:1px solid #b9b9b9;'><img src=$slika width=30 border=0 align=left><br>&nbsp;$pt_tko &nbsp;&nbsp;$ispis_ured</td></tr>";
					else
					echo "<li class='ppredmet' id='$pt_id'><img src=$slika width=40 border=0>$pt_tko<br>$pt_kada</li><div style=clear:both></div><li class='$pt_id' style='display: none;'><p>$pt_opis</p></li><script>
 $(document).ready(function() {
        $('#$pt_id').click(function() {
                $('.$pt_id').slideToggle('fast');
        });
		//var mak=<?php echo $red_idova[0]; ?>;
		//$('#'+mak+').show();
    });
</script>";
				}
			echo "</ul>";
	//postovi korisnika
	include "post_predmeti.php";
						 }}
		/*	}
		else
			echo "<b>Uneseni korisnik nije u&#269;enik!</b>";
	}
	else
	echo "<b>GREŠKA u sustavu ili ne ovlašteni ulaz!</b>";*/
mysql_close($spoj);
?>