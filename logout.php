<?php
//error_reporting(0);

//Baza i username i password
$baza = "gaudeam_knex";
$korisnik = "gaudeam_knex";
$lozinka = "@00886726@";



$spoj = mysql_connect("localhost","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA 003 - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");

$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA 002 - Baza nije pronadena na serveru!</span>");

$check = mysql_query("SELECT * FROM korisnici WHERE x = '".$_POST['x']."'")or die(mysql_error());
$in=mysql_fetch_array($check);
$idk = $in['x'];
$prava_postavke =$in['prava'];
$sesija=$in['sesija'];
//echo $sesija;
if ($sesija<=1){
$sesija_duze = "UPDATE korisnici SET sesija = '3'  WHERE x = '".$_POST['x']."'";
}
		else{
			
		$sesi_duze = "UPDATE korisnici SET sesija = '0'  WHERE x = '".$_POST['x']."'";
}
?>
<html>
<head>
<title>Gaudeam Knex</title>
<meta http-equiv="refresh" content="1; URL=http://gaudeamus.hr/mobile/index.html">
<meta name="keywords" content="gaudeamus knex">
</head>
<body>

</body>
</html>