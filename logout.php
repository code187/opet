<?php
//error_reporting(0);

//Baza i username i password
$baza = "gaudeam_knex2013";
$korisnik = "gaudeam_knex";
$lozinka = "@00886726@";

echo $_POST['x'];

$spoj = mysql_connect("localhost","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA 003 - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");

$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA 002 - Baza nije pronadena na serveru!</span>");

$sesija_duze = "UPDATE korisnici SET sesija = '0'  WHERE x = '".$_POST['x']."'";
						
						$ses_rez = mysql_query($sesija_duze) or die("<span class=podnaslovi_crveni>GRESKA: Nemoguce resetirati sesiju za korisnika</span>");
						echo "<b>Uspješno ste odjavljeni.</b><br><br>";

?>
<html>
<head>
<title>Gaudeam Knex</title>
<meta http-equiv="refresh" content="0; URL=http://gaudeamus.hr/mobile/index.html">
<meta name="keywords" content="gaudeamus knex">
</head>
<body>

</body>
</html>