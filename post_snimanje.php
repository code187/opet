<?php
error_reporting(0);
include_once "postavke_read.php";
include "funkcije.php";
$sazetak=$_POST['sazetak'];
echo "lccaca $sazetak";
//$sazetak=mysql_real_escape_string($sazetak);
//echo "baaaa!";
//snimi post
if ($ak=="2")
	{ 
	//echo "#laaaa";
		//mlati li netko po refreshu?
		//dvije minute ne može stisnuti refresh
		//$compare = $compare + 300 ;
		//echo "proba $nastavnik $predmet";
		$zaprovjeru = $compare-3;
		$a = "select * from forum_postovi where prip='u-$idk' and moze>=$zaprovjeru;";
		//echo $a;
		$rezaa = mysql_query($a) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja tablice kategorija foruma!</span>");
		$imalie = mysql_num_rows($rezaa);
		if ($imalie=="0")
		{ echo "lalall $sazetak";
			if ($sazetak!="")
				{
					//datum
					$datumic = date("j.m.Y"); $tx = date("H:i:s");
					echo $skupa = "$datumic - $tx";
					if ($proslijedi=="1") //svim nastavnicima koji imaju tog ucenika dodaj komentar
					{
						$uc_razred=razred($idk);
						$ap="SELECT *,replace(replace(replace(replace(replace(ime,'&#268;','Cxx'),'&Scaron;','Sx'),'&#381;','Zx'),'&#272;','Dx'),'&#262;','Cx') sortiraj FROM conf_predmeta where asst='$uc_razred' ORDER BY sortiraj ASC";	
						$rezpp = mysql_query($ap) or die("<span class=podnaslovi_crveni>Greška prilikom upita u predmeta!</span>");
						$cpp = mysql_num_rows($rezpp);
						if ($cpp!="0")
						{ 
							$brojim=0; 
							while ($repp = mysql_fetch_array($rezpp))
							{
								$ukupno=0;
								$id = $repp["id"]; //id predmeta
								//pogledaj je li taj ucenik i u jednom izvještaju tog predmeta? $idk je ucenikov id
								$ab = "select * from izvjestaji where pripadnost = $id";
								$rezb = mysql_query($ab) or die("<span class=podnaslovi_crveni>Greška prilikom upita u bazu izvjestaja!</span>");
								while ($reb = mysql_fetch_array($rezb))
								{
									$unosi = $reb["unosi"]; 
									$ac="select id from izvjestaj$unosi where ucenik=$idk";	
									$rezc = mysql_query($ac) or die("<span class=podnaslovi_crveni>Greška prilikom upita u bazu izvjeszaja predmeta!</span>");
									$cc = mysql_num_rows($rezc);
									if ($cc>0) //ima ucenika u barem jednom izvještaju znaci da tom nastavniku treba prosljedena informacija
									$ukupno++;
								}
								if ($ukupno!="0")
								{
									$upit_snimi="insert into forum_postovi (opis,prip,tko,kada, moze, tko_smije) values ('$sazetak', 'u-$idk-$id','$user','$skupa','$compare','$dozvole');";
										$rs=mysql_query($upit_snimi) or die("<span class=podnaslovi_crveni>Greška prilikom upisa u bazu postova foruma!</span>");
										$ock=1;
								}
							}
							if ($ock=="1")
							{
								echo "<b>Komentar uspješno objavljen kao komentar na svim predmetima u&#269;enika!</b><br>";
								zapis ("$user","412-u-$idk");
							}
						}

					}
					$upit_snimi="insert into forum_postovi (opis,prip,tko,kada, moze, tko_smije) values ('$sazetak', 'u-$idk','$user','$skupa','$compare','$dozvole');";
					//echo $upit_snimi;
					$rs=mysql_query($upit_snimi) or die("<span class=podnaslovi_crveni>Greška prilikom upisa u bazu postova foruma!</span>");
					echo "<b>Komentar uspješno poslan!</b><br>";
					zapis ("$user","403-u-$idk");
				}
		}
		else
		echo "<b>Ne dozvoljeno ponavljanje postanja!</b><br>";
	}
//standardni ispis
