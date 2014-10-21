<?php 
/* Postavka za Sofa softver...*/

//Naziv projekta, stranice, tvrtke za koju je sofa prilagodena

$projekt = "KNEX - sustav za potporu u obrazovanju";
$web = "http://www.gaudeamus.hr/knex";
$prilagodeno = "Gimnazija Gaudeamus, Osijek";

//Uvijek uzmi varijable koje se nude :)

foreach( $_POST as $key => $value ) {
     $$key = $value;
}
foreach( $_GET as $key => $value ) {
     $$key = $value;
}
$user = $_POST['x'];

//Baza i username i password
$baza = "gaudeam_web";
$korisnik = "loop";
$lozinka = "code187";

//Postavke uploada slike za vijesti
$upload= "800";  //u kb
$vrsta = "image/pjpeg"; //koji format slike
$sirina = "200px"; //koliko px širine je potrebno za vijesti
$direk = "doc/fotke"; //u koji folder stavljaš fotke za vijesti u folderu BACK


//Spajanje na bazu
$spoj = mysql_connect("localhost","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA 003 - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");
$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA 002 - Baza nije pronadena na serveru!</span>");

//provjeri prava korisnika
$upis = "select * from korisnici where x='$user'";
$rezultat = mysql_query($upis) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja usera iz tablice za provjeru prava</span>");
$brojim = mysql_num_rows($rezultat);
if ($brojim =="0") {
$upis = "select * from korisnici where korisnik='$user'";
$rezultat = mysql_query($upis) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja usera iz tablice za provjeru prava</span>");
}
while ($repa = mysql_fetch_array($rezultat))
		{
			$prava_postavke = $repa["prava"];
			$korisnik_post = $repa["korisnik"];
			$korisnik_puno = $repa["puno"];
			$brojickorisnika = $repa["x"];
			$ispunjene_ankete = $repa["ank"];
			$stara_sesija = $repa["sesija"];
			$kazna = $repa["kazna"];
			$razred_sada = $repa["status"];
			$raspored_ucenika = $repa["raspored"];
		}

//a koliko dugo je braco logiran - aj daj mu 15min a onda leti vanka...
//svakim klikom braco produži sesiju za 15min
//ako je sesija manja od 15min (900sec) ok, ako je više baj baj :)
		
		//provjera je li dobro napravljen log out
		//echo $stara_sesija;
	
	/*if ($kazna !="0") //usporedi vremena
		{	
			if ($kazna < $provera) 
			$kazna = "0";
			else
			echo "Prilikom vaše zadnje prijave na sustav niste napravili odjavu vašeg korisnickog racuna. Sustav vam je onemogucio pristup na 5min.";
			session_destroy();
			die();
		}	*/
	//if ($kazna =="0")
		//{
		$provera = date('U');
		if ($stara_sesija !="0")
			{	
				if ($stara_sesija < $provera)
					{
						
						$kor = $user;
						unset($user);
				
						$sesija_duze = "UPDATE korisnici SET sesija = '0'  WHERE x = '$brojickorisnika'";
						
						$ses_rez = mysql_query($sesija_duze) or die("<span class=podnaslovi_crveni>GRESKA: Nemoguce resetirati sesiju za korisnika</span>");
						echo "<b>Prilikom zadnje prijave niste ispravno napravili odjavu iz sustava! Radi sigurnosti vaših podataka uvijek napravite odjavu.<br>Izvršite prijavu na KNEX sustav ponovno...</b><br><br>";

					}
						
				else
					{
						$nova = date('U') + "9000";
						$sesija_duze = "UPDATE korisnici SET sesija = '$nova'  WHERE x = '$user'";
						$ses_rez = mysql_query($sesija_duze) or die("<span class=podnaslovi_crveni>GRESKA: Nemoguce produljiti sesiju za korisnika</span>");
					}
			}
		else
			{
				$nova = date(U) + "9000";
				$sesija_duze = "UPDATE korisnici SET sesija = '$nova'  WHERE x = '$user'";
				$ses_rez = mysql_query($sesija_duze) or die("<span class=podnaslovi_crveni>GRESKA: Nemoguce produljiti sesiju za korisnika</span>");
			}
		//}

//Provjera sesije ako nije odmah prekini!
if ($user=="")
	{
		echo "Neovlašteni pristup ili istekla sesija! Molimo prijavite se na sustav pomo&#263;u forme!<br><br><a href=index.php>Ponovna prijava</a>";
		unset($user);
		//$istek = date(U)+"300"; //5min kazne da se ne loguješ
		$sesija_duze = "UPDATE korisnici SET sesija = '0'  WHERE x = '$brojickorisnika'";
		$ses_rez = mysql_query($sesija_duze) or die("<span class=podnaslovi_crveni>GRESKA: Nemoguce resetirati sesiju za korisnika</span>");
		//$sesija_duze = "UPDATE korisnici SET kazna = '$istek'  WHERE x = '$kor'";
		//$ses_rez = mysql_query($sesija_duze) or die("GRESKA: Nemoguce dodati kaznu za korisnika");
		exit();
	}

//Postavke uploada seminara, i svega ostalog!!
$upis_conf = "select * from conf_all where id=1";
$rezultat_conf = mysql_query($upis_conf) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja tablice konfiguracije!</span>");
while ($repa_conf = mysql_fetch_array($rezultat_conf))
		{
			$upload_seminar = $repa_conf["max_up"];
			$sveuc = $repa_conf["sveuc"];
			$fax = $repa_conf["fax"];
			$logo = $repa_conf["logo"];
			$maliic = $repa_conf["mailizvjestaj"];
			$broj_razreda_knex = $repa_conf["razredi"];
		}
$direk_seminar = "doc"; //u koji folder stavljaš seminare folderu BACK


		//napraviti korisnika, admin, super user
	if ($prava_postavke == "1")
		{
		if ($m=="seminar" or $m=="korisnici" or $m=="vjezbe" or $m=="kolokvij" or $m=="" or $m=="conf" or $m=="pm" or $m=="dokumenti" or $m=="chat" or $m=="forum"or $m=="chat/room" or $m=="natjecaji" or $m=="vijesti" or $m=="nastava" or $m=="kalendar" or $m=="opa" ) //ovlašteni folderi
			{
				if ($p=="uploadsem" or $p=="uploadsem1" or $p=="uv1" or $p=="uv2" or $p=="pregled" or $p=="provjeriju" or $p=="prijava" or $p=="urediga_korisnik" or $p=="prijava" or $p=="" or $p=="seminari" or $p=="pm" or $p=="pm_pisi" or $p=="pm_nova" or $p=="pm_citaj" or $p=="detalji_prof" or $p=="detalji" or $p=="doc" or $p=="up" or $p=="up1" or $p=="detalji_asst" or $p=="chat" or $p=="index" or $p=="soba_nova" or $p=="forum" or $p=="kategorije" or $p=="post" or $p=="kategorija_nova" or $p=="kategorija_uredi" or $p=="dodaj2" or $p=="natjecaji" or $p=="donatori" or $p=="ops1" or $p=="arhiva" or $p=="ucenik" or $p=="ucenik_detalji" or $p=="kal" or $p=="ocjene_plan" or $p=="konzultacije"  or $p=="ispuni_izostanke1" or $p=="up_up" or $p=="up1_up") //ovlašteni fajlovi 
					{
						echo ""; 
					}
				else
					{
					echo "<b>Nemate pravo pristupa na ovaj dio sustava!</b>" ;
					die;
					}
			}
			else
				{
				echo "<b>Nemate pravo pristupa na ovaj dio sustava!</b>" ;
				die;
				}
		}
	if ($prava_postavke =="1" or $prava_postavke =="2" or $prava_postavke =="4"  ) //nadi gdje sve studnet sudjeluje :)
		{	
		if ($prava_postavke=="1") //ucenik
			{
				$upit = "select * from conf_predmeta where seminar=1 and asst='$razred_sada'";
			}
		elseif($prava_postavke=="2") //nastavnik
			$upit = "select * from conf_predmeta where seminar=1 and (profesor like '%$user%' or profesor like '$user%')";
		elseif($prava_postavke=="4") //roditelj
		{
			//nadi koji je razred dijete
			$upit = "select * from korisnici where x=$brojickorisnika";
			//echo $upit;
			$rekoh = mysql_query($upit) or die("<span class=podnaslovi_crveni>GREŠKA: tražnje postavki</span>");
					while ($repac = mysql_fetch_array($rekoh))
					{
						$dijete = $repac["vjezbe"];
					}
			$a_korisnik_puno1 = "select * from korisnici where x = $dijete";
			//echo $a_korisnik_puno1;
			$rez_korisnik_puno1 = mysql_query($a_korisnik_puno1) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja razreda djeteta!</span>");
			while ($re_korisnik_puno1 = mysql_fetch_array($rez_korisnik_puno1))
				{
					$ispis_id1 = $re_korisnik_puno1["status"];
					$razred_djeteta=$ispis_id1;
				}
			$upit = "select * from conf_predmeta where seminar=1 and asst='$ispis_id1'";
		}
		//echo $upit;
			$rezultat_pred = mysql_query($upit) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja predmeta iz conf_predmeti</span>");
			$rez_count = mysql_num_rows($rezultat_pred); //ima li ga u predmetu
			if ($rez_count>0)
				{
					$brojim_predmete=0;
					while ($repa_pred = mysql_fetch_array($rezultat_pred))
					{
						//$brojim_predmete=$rez_count; //ako ima zbroj sa ostalima 
						$predmet_svi = $repa_pred["broj_ispita"];
						$id_predmeta = $repa_pred["id"];
						$niz_predmeta[$brojim_predmete] = $id_predmeta;
						$niz_predmeta_broj[$brojim_predmete] = $predmet_svi;
						$brojim_predmete++;
					}
				}		
			
		}		
	/*if ($prava_postavke =="2") //nadi gdje sve profesor smije :) upisano isto u niz
		{
			$brojim_predmete=0;
			$upit_pred_miki = "select * from conf_predmeta where napravio = '$brojickorisnika'";
			$rezultat_pred_miki = mysql_query($upit_pred_miki) or die("GREŠKA: pozivanja predmeta iz conf_predmeti za profesora");
			while ($repa_pred = mysql_fetch_array($rezultat_pred_miki))
				{
					$brojim_predmete++; //ako ima zbroj sa ostalima
					$predmet_svi = $repa_pred["broj_ispita"];
					$id_predmeta = $repa_pred["id"];
					$niz_predmeta[$brojim_predmete] = $id_predmeta;
					$niz_predmeta_broj[$brojim_predmete] = $predmet_svi;
							
							
				}
		}			*/
?>