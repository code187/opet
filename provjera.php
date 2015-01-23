<?php

	session_start();
	$_SESSION['varname'] = $_SERVER['HTTP_REFERER'];
	

    $email = $_POST['email'];
    $pass = $_POST['pass'];

//Baza i username i password
$baza = "kmaccess_sale";
$korisnik = "kmaccess_sc";
$lozinkab = "OF9002089ir.";

$spoj = mysql_connect("localhost","$korisnik","$lozinka") or die ("<span class=podnaslovi_crveni>GREŠKA - Vaše korisnicko ime ili lozinka za bazu su neispravni!</span>");

$baza = mysql_select_db("$baza", $spoj) or die("<span class=podnaslovi_crveni>GREŠKA - Baza nije pronadena na serveru!</span>");


$check = mysql_query("SELECT * FROM korisnici WHERE korisnik = '".$_POST['email']."'")or die(mysql_error());

 //Gives error if user dosen't exist

 $check2 = mysql_num_rows($check);

 if ($check2 == 0) {

 		echo 'GREŠKA - Vaše korisnicko ime ili lozinka su neispravni!';

 				}

 while($info = mysql_fetch_array( $check )) 	

 {

 $_POST['pass'] = stripslashes($_POST['pass']);

 	$info['lozinka'] = stripslashes($info['lozinka']);

 	$_POST['pass'] = md5($_POST['pass']);



 //gives error if the password is wrong

 	if ($_POST['pass'] != $info['lozinka']) {

 		die('Pogrešno korisničko ime ili lozinka.');
 	}
	else 

 { 
echo $info['x'];


 } 

 }  
 ?>