<?php
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

//Baza i username i password
$baza = "gaudeam_knex2013";
$korisnik = "gaudeam_knex";
$lozinka = "@00886726@";

$spoj = mysql_connect("gaudeamus.hr","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA 003 - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");

$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA 002 - Baza nije pronadena na serveru!</span>");


$check = mysql_query("SELECT * FROM korisnici WHERE korisnik = '".$_POST['firstName']."'")or die(mysql_error());

 //Gives error if user dosen't exist

 $check2 = mysql_num_rows($check);

 if ($check2 == 0) {

 		echo 'That user does not exist in our database. Please try again';

 				}

 while($info = mysql_fetch_array( $check )) 	

 {

 $_POST['lastName'] = stripslashes($_POST['lastName']);

 	$info['lozinka'] = stripslashes($info['lozinka']);

 	$_POST['lastName'] = md5($_POST['lastName']);



 //gives error if the password is wrong

 	if ($_POST['lastName'] != $info['lozinka']) {

 		die('Incorrect password, please try again.');

 	}
	else 

 { 

 echo "1"; 

 } 

 }  
?>