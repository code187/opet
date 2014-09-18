<?php
    $firstName = $_POST['x'];

//Baza i username i password
$baza = "gaudeam_knex2013";
$korisnik = "gaudeam_knex";
$lozinka = "@00886726@";

$spoj = mysql_connect("localhost","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA 003 - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");

$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA 002 - Baza nije pronadena na serveru!</span>");


$check = mysql_query("SELECT * FROM korisnici WHERE x = '".$_POST['x']."'")or die(mysql_error());

 //Gives error if user dosen't exist

 
 $info = mysql_fetch_array( $check );	
 
echo json_encode($info);
?>