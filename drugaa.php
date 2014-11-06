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
                    url: "http://gaudeamus.hr/mobile/post_snimanje.php",
                    cache: false,
                    data: formData,
                    success: onSuccess
                });
  
                return false;
            });
    });
</script>

<?php
error_reporting(0);
    $firstName = $_POST['x'];
//Baza i username i password
$baza = "gaudeam_knex2013";
$korisnik = "gaudeam_knex";
$lozinka = "@00886726@";
$spoj = mysql_connect("localhost","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA 003 - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");

$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA 002 - Baza nije pronadena na serveru!</span>");


$check = mysql_query("SELECT * FROM korisnici WHERE x = '".$_POST['x']."'")or die(mysql_error());
$in=mysql_fetch_array($check);
$idk = $in['x'];
$prava_postavke =$in['prava'];
//$razred = $in['status'];
//echo $razred;
include_once "postavke.php";
include "funkcije.php";	
$bt= $in['vjezbe'];
//echo $bt;
/*if ($bt!="")
	{
		$opop = mysql_query("select * from korisnici where x = $bt");
		//echo $opop;
		$mi = mysql_fetch_array($opop);
		$razred= $mi['status'];
		echo $razred;
	}*/
if ($idk!="")
	{
		$razred=razred($idk);
		//znaci da je korisnik u bazi, no provjeri je li to ucenik?
		$pr = prava_korisnik_id($idk);
		if ($pr=="1" or $pr=="4") //e sad je to ucenik
			{	
				if ($prava_postavke=="1" or $prava_postavke=="4")
				echo "";
				else
				{
				echo "<a href=admin.php class=podnaslovi><img src=images/povratak.png border=0 title=Povratak alt=Povratak></a>";
				//prebacivanje na drugog ucenika
				if ($prava_postavke=="3" or $prava_postavke=="2")
				{
					echo "<form name=form_slanje id=form1 method=post action='admin.php?p=ucenik&m=nastava&drop=1' style='float:right; margin-right:25px; margin-top:5px;' >";
					echo "<select name=idk id=idk class=drugi_ucenik onChange='this.form.submit()'>";
     				//daj mi ostale iz njegovog razreda
					$ab_ucenici="SELECT x,puno,replace(replace(replace(replace(replace(puno,'&#268;','Cxx'),'Š','Sx'),'&#381;','Zx'),'&#272;','Dx'),'&#262;','Cx') sortiraj FROM korisnici where status='$razred' ORDER BY sortiraj ASC";
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
				//ako je razrednik onda ubaci da je procitano
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
				}
				$punom = puno_ime($idk);
				//slika korisnika??
				$slika_korisnika = slika_korisnika($idk);
				$adresa_korisnika = adresa_korisnika($idk);
				$info = info_korisnika($idk);
				$infon = explode(":::",$info);
				if ($slika_korisnika!="")
				{
					$filename="doc/fotke/korisnici/$slika_korisnika";
					if (file_exists($filename)) 
						$slika = $filename;
						else
						$slika = "images/nepoznati_user.png";
				}
				
			if ($prava_postavke=="1" or $prava_postavke=="4") //ako su ucenik ili roditelj neka vide konzultacije
			/*echo "<table id=tablica_lijevoc><tr class=alt><td width=45><img src=$slika border=0 align=left></td><td>Prezime i ime: $punom<br>Dan, mjesec i godina ro&#273;enja: $infon[2]<br>Adresa: $adresa_korisnika<br>Telefon: $infon[0]<br><a href=admin.php?p=kal&m=opa&idk=$idk&razred=$razred rel=icon10>Osobni plan aktivnosti</a><br><a href=admin.php?p=konzultacije&m=nastava rel=icon3>Konzultacije</a></td><td>Mjesto i dr&#382;ava ro&#273;enja: $infon[3]<br>Dr&#382;avljanstvo: $infon[4]<br>Narodnost: $infon[5]<br>Ime i prezime majke: $infon[6]<br>Ime i prezime oca: $infon[7]</td> </tr></table>";*/
			echo "<div id='showmenu'><ul id=ucenik><li><img src=$slika /></li><li><p>Korisnik: $punom</p><p>Adresa: $adresa_korisnika</p><p>Telefon: $infon[0]</p></li>
			</ul>
			<div class='menu' style='display: none;'>
				
			</div></div><div style=clear:both></div>";
			else
			echo "<table id=tablica_lijevoc><tr class=alt><td width=45><img src=$slika border=0 align=left></td><td>Prezime i ime: $punom<br>Dan, mjesec i godina ro&#273;enja: $infon[2]<br>Adresa: $adresa_korisnika<br>Telefon: $infon[0]<br><a href=admin.php?p=kal&m=opa&idk=$idk&razred=$razred rel=icon10>Osobni plan aktivnosti</a><br><a href=admin.php?p=napomena&m=nastava&idk=$idk rel=icon2>Napomena o u&#269;eniku</a><a href=admin.php?p=vise_ucenika&m=nastava&idk=$idk rel=icon2>Sve ocjene</a></td><td>Mjesto i dr&#382;ava ro&#273;enja: $infon[3]<br>Dr&#382;avljanstvo: $infon[4]<br>Narodnost: $infon[5]<br>Ime i prezime majke: $infon[6]<br>Ime i prezime oca: $infon[7]</td> </tr></table>";
			
				echo "<ul id=predmeti>";
				//pronadi sve dostupne predmete razreda i ispiši ih, a na klik se otvaraju detalji o svakom predmetu
				if ($prava_postavke=="4")
				{
					$tmp_raz=ucenik_rod($idk);
					$razred=razred($tmp_raz);
					$idk=$tmp_raz;
				}
				$a="SELECT ime,id,replace(replace(replace(replace(replace(ime,'&#268;','Cxx'),'&Scaron;','Sx'),'&#381;','Zx'),'&#272;','Dx'),'&#262;','Cx') sortiraj FROM conf_predmeta where asst='$razred' ORDER BY sortiraj ASC";	
				//echo $a;
				$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>Greška prilikom upita u predmeta!</span>");
				$c = mysql_num_rows($rez);
				
				if ($c=="0")
					echo "Trenutno nema predmeta za $razred!";
				else
					{ 
					$bojko = "";
					//echo $c;
					$brojim=0; 
					while ($re = mysql_fetch_array($rez))
					{
						$ukupno=0;
						$preskoci=0;
						$puno_ime = $re["ime"]; $upok=0; //echo "tu $upok";
						//echo $puno_ime; 
						$id = $re["id"];
						//pogledaj je li taj ucenik i u jednom izvještaju tog predmeta? $idk je ucenikov id
						if ($prava_postavke=="1" or $prava_postavke=="4")
						$ab = "select unosi,pogledao from izvjestaji where pripadnost = $id order by id asc "; 
						else
						$ab = "select unosi,pogledao from izvjestaji where pripadnost = $id order by id desc ";
						//složi ga asc jer nam samo zadnji treba za provjeru je li roditelj/ucenik pogledao
						//echo $ab;
						$rezb = mysql_query($ab) or die("<span class=podnaslovi_crveni>Greška prilikom upita u bazu izvjestaja!</span>");
						while ($reb = mysql_fetch_array($rezb))
						{
							$unosi = $reb["unosi"]; 
							$tko_pogledao_izvjestaj = $reb["pogledao"]; //echo "cc  $tko_pogledao_izvjestaj";
							//if ($unosi=="1399548623")
							//echo "la $tko_pogledao_izvjestaj";
							
							$ac="select id from izvjestaj$unosi where ucenik=$idk";	
							$rezc = mysql_query($ac) or die("<span class=podnaslovi_crveni>Greška prilikom upita u predmeta!</span>");
							$cc = mysql_num_rows($rezc);
							if ($cc>0)
							$ukupno++;
						}
						//echo "$ukupno<br>";
						//fotka predmeta
						$ime_za_fotku="";$fajl=""; $slikapredmeta="";
						$ime_za_fotku = stripos($puno_ime," ");
						if ($ime_za_fotku===false)
						$ime_za_fotku=$puno_ime;
						else
						$ime_za_fotku = substr($puno_ime,0,$ime_za_fotku);
						$ime_za_fotku = strtolower($ime_za_fotku);
						$ime_za_fotku = str_replace("&#269;","c",$ime_za_fotku);
						$ime_za_fotku = str_replace("&#263;","c",$ime_za_fotku);
						$ime_za_fotku = str_replace("&#382;","z",$ime_za_fotku);
						$ime_za_fotku = str_replace("&scaron;","s",$ime_za_fotku);
						$ime_za_fotku = str_replace("š","s",$ime_za_fotku);
						$ime_za_fotku = str_replace("&#273;","d",$ime_za_fotku);
						$fajl="images/$ime_za_fotku.png"; //gdje je fotka?
						//echo $fajl;
						if(file_exists($fajl))
						$slikapredmeta = "$ime_za_fotku.png";
						else
						$slikapredmeta = "nepoznati_predmet.png";
						//ima li novih izvještaja koje roditelj ili dijete nisu vidjeli?
							$upok=0;
							//echo "$tko_pogledao_izvjestaj \n";
							if ($tko_pogledao_izvjestaj!="")
							{
								$tpi=explode(",",$tko_pogledao_izvjestaj);
								if (is_array($tpi))
								{
									foreach ($tpi as $tp)
									{
										if ($tp!="")
										{
											if ($tp==$user)
											{
												//echo "$tp - $user";
												$upok=1;
											}
										}
									}
								}
							}
									//echo " $upok";
						if ($ukupno!="0")
						{
							$ha=$brojim%4;
							if ($ha =="0")
							{
								echo "<tr ".$bojko.">";	
							}
						//ima li komentara roditelja na uspjeh? ako ima neka pocrveni. ako je zadnji id upisani u postovima razlicit od profesorovog onda pocrveni
						
							$ar = "select tko,id,pogledao,razrednik from forum_postovi where prip = 'u-$idk-$id' order by moze desc limit 0,1";
	 				     	//echo "$ar";
							//echo $prava_postavke; 
							$zadnji_pisao="";
							$rezr = mysql_query($ar) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja tablice postova za predmet!</span>");
							
					  		$broj_zadnjih = mysql_num_rows($rezr);
							if ($upok=="0") //znaci ima izvještaja koje roditelji i ucenici nisu pogledali
							{ 
								if ($prava_postavke=="3" or $prava_postavke=="2")
								echo "";
								else {
								$broj_zadnjih =1; $preskoci=1; }
							}
							
							//echo "$broj_zadnjih - $zadnji_user";
							/*if ($prava_postavke=="3" or $prava_postavke=="2") //admin i nastavnik nikada ne preskacu!
							$preskoci=0;*/
							$id_pisma ="";
							if ($broj_zadnjih!="0")
							{
								if ($preskoci !="1")
								{
								while ($rer=mysql_fetch_array($rezr))
								{
									
									
									$zadnji_pisao = $rer["tko"];
									$id_pisma = $rer['id'];
									$pogledao = $rer["pogledao"];
									$raz=$rer["razrednik"];
								}
								
							//profesor tog predmeta je user i ako je zadnji pisao != $usrer ofarbaj sve to crveno
							//echo "njah $zadnji_pisao";
							$jelirazrednik = 0;
							$zadnji_user=explode(",",$pogledao);
								if ($jelirazrednik>0)
									{
										if ($user==$raz)
										$zadnji_pisao=$user;
									}
								else
									{
										foreach ($zadnji_user as $zu)
										{
											if ($zu==$user)
											$zadnji_pisao=$user;
										}
									}
								
								}
							
							//echo "la $tko_pogledao_izvjestaj";
							
							if ($prava_postavke=="1" or $prava_postavke=="4" or $prava_postavke=="3" or $prava_postavke=="2") //ako su ucenici ili roditelji samo crveni i nepregledane izvještaje
							{
								if ($preskoci=="1") 
								{
									if ($upok!="1")	
									//OVDJE MI NE RADI EHO OD ID-A			
									echo "<li><a onclick=SendTo_$id(); href=http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id&citao=$id_pisma><img src='images/$slikapredmeta'><br><font color=red>$puno_ime</a></font></li><script language='javascript'>
   function SendTo_$id(){
       window.location=\"http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id\"
    }
</script>";			
									else
									echo "<li><a href=http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id class=highlightit><img src=images/$slikapredmeta><br>$puno_ime</a></li>";
								}
								else 
								{
									if ($zadnji_pisao!=$user)				
									echo "<li><a href=http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id&citao=$id_pisma class=highlightit><img src=images/$slikapredmeta><br><font color=red>$puno_ime</a></font></li>";			
									else
									//OVDJE NEGDJE JE GREŠKA
									echo "<li><a onclick=SendTo_$id(); href=http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id><img src='images/$slikapredmeta'><br>$puno_ime</a></li><script language='javascript'>
   function SendTo_$id(){
        window.location=\"http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id\"
    }
</script>";
								}
							}
							else
							{									
								if ($zadnji_pisao!=$user)				
									echo "<li><a href=http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id&citao=$id_pisma class=highlightit><img src=images/$slikapredmeta><br><font color=red>$puno_ime</a></font></li>";			
								else
									echo "<li><a href=http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id class=highlightit><img src=images/$slikapredmeta><br>$puno_ime</a></li>";
							} 
						}
						else
						//NI OVDJE NE RADI EHO OD ID-A
							echo "$id<li><a onclick=SendTo(); href=http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id><img src='images/$slikapredmeta'><br>$puno_ime</a></li><script language='javascript'>
   function SendTo(){
       window.location=\"http://gaudeamus.hr/mobile/treca.html?p=ucenik_detalji&m=nastava&idk=$idk&razred=$razred&pred=$id\"
    }
</script>";
								$brojim++;
						}
					}
					echo "</ul>";	
					}
			}
		else
			echo "<span class=podnaslovi>Uneseni korisnik nije u&#269;enik!</span>";
	echo "<div style=clear:both></div>";
	
	$prava_kor = $in['prava'];
	
	$a = "select * from forum_postovi where prip = 'u-$idk' order by id desc";
//echo $a;

echo "<ul id=postovi>";
//mysql_query("SET NAMES 'utf8'");ako stavimo ovdje onda stari postovi rade dobro a mob ne, bez ovoga mob radi dobro a stari ne prikazuju š i ž znakove
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
					echo "<li id='$pt_id'><span><img src=$slika width=40 border=0><p>$pt_tko<br>$pt_kada</p></li><div style=clear:both></div><li class='$pt_id' style='display: none;'><p>$pt_opis</p></span></li><script>
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
		include "post.php";
        
}
mysql_close($spoj);
?>