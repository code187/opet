<?php 

foreach( $_POST as $key => $value ) {
     $$key = $value;
}
foreach( $_GET as $key => $value ) {
     $$key = $value;
}
//Baza i username i password
$baza = "gaudeam_web";
$korisnik = "loop";
$lozinka = "code187";

//lokalno
/*
$baza = "knex08";
$korisnik = "root";
$lozinka = "12051985";
*/


//Spajanje na bazu
$spoj = mysql_connect("localhost","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA 003 - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");
$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA 002 - Baza nije pronadena na serveru!</span>");


$upis_conf = "select * from conf_all where id=1";
$rezultat_conf = mysql_query($upis_conf) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja tablice konfiguracije!</span>");
while ($repa_conf = mysql_fetch_array($rezultat_conf))
		{
			$sveuc = $repa_conf["sveuc"];
			$fax = $repa_conf["fax"];
			$logo = $repa_conf["logo"];
			$sazetak = $repa_conf["projekt"];
			$text = $repa_conf["impresum"];
			$maliic = $repa_conf["mailizvjestaj"];
			$broj_razreda_knex = $repa_conf["razredi"];
		}

//podaci o korisniku koji nam trebaju
if ($user!="")
{
	$user=mysql_real_escape_string($user);
$upis = "select * from korisnici where x='$user'";
$rezultat = mysql_query($upis) or die("query neispravan");
while ($re = mysql_fetch_array($rezultat))
		{
		$ispunjene_ankete = $re["ank"];
		$korisnik_post=$re["korisnik"];
		}
//jel upiso jerkicevu anketu?? a? 
$upis101 = "select * from jerko where user='$korisnik_post'";
$rezultat101 = mysql_query($upis101) or die("query neispravan");
$cf = mysql_num_rows($rezultat101);
}
//mysql_close($spoj);
?>