<?php 
//Smajlici
$patterns = array("/:\)/", "/:D/", "/:p/", "/:P/", "/:\(/", "/:\-\)/", "/:\-\D/");
$replacements = array("<a href=# rel=sm1></a>", "<a href=# rel=sm2></a>", "<a href=# rel=sm3></a>", "<a href=# rel=sm3></a>", "<a href=# rel=sm4></a>","<a href=# rel=sm1></a>","<a href=# rel=sm2></a>");

/* Funkcije za KNEX softver...*/

function ime_nastavnik ($varijabla)
//Funckija koja vraca puno ime profesora
			{
				$a_korisnik_puno = "select nastavnik from abeceda where id = $varijabla";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja punog imena korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_puno = $re_korisnik_puno["nastavnik"];
						return $ispis_puno;
					}
			}

function puno_ime ($varijabla)
//Funckija koja vraca kako je puno ime korisniku
			{
				$a_korisnik_puno = "select puno from korisnici where x = $varijabla";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja punog imena korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_puno = $re_korisnik_puno["puno"];
						return $ispis_puno;
					}
			}
function mentor ($varijabla)
//Funckija koja vraca kako je puno ime korisniku
			{
				$a_korisnik_puno = "select mentor from korisnici where x = $varijabla";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja punog imena korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_puno = $re_korisnik_puno["mentor"];
						return $ispis_puno;
					}
			}
function user_ime ($varijabla)
//Funckija koja vraca kako je username korisnika
			{
				$a_korisnik_puno = "select korisnik from korisnici where x = $varijabla";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja punog imena korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_puno = $re_korisnik_puno["korisnik"];
						return $ispis_puno;
					}
			}
function slika_korisnika ($varijabla)
//Funckija koja vraca filename fotke
			{
				$a_korisnik_puno = "select kazna from korisnici where x = $varijabla";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja punog imena korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_puno = $re_korisnik_puno["kazna"];
						return $ispis_puno;
					}
			}
function adresa_korisnika ($varijabla)
//Funckija koja vraca adresu korisnika
			{
				$a_korisnik_puno = "select sms from korisnici where x = $varijabla";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja punog imena korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_puno = $re_korisnik_puno["sms"];
						return $ispis_puno;
					}
			}
function info_korisnika ($varijabla)
//Funckija koja vraca ostale informacije o korisniku
			{
				$a_korisnik_puno = "select spol,rodjenje,md,drz,nar,ipm,ipo,mobitel from korisnici where x = $varijabla";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja punog imena korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
							$spol=$re_korisnik_puno["spol"];
							$rodjenje=$re_korisnik_puno["rodjenje"];
							$md=$re_korisnik_puno["md"];
							$drz=$re_korisnik_puno["drz"];
							$nar=$re_korisnik_puno["nar"];
							$ipm=$re_korisnik_puno["ipm"];
							$ipo=$re_korisnik_puno["ipo"];
							$mob=$re_korisnik_puno["mobitel"];
							$ispis_puno="$mob:::$spol:::$rodjenje:::$md:::$drz:::$nar:::$ipm:::$ipo";
							return $ispis_puno;
					}
			}
function id_korisnik ($varijabla)
//Funckija koja id korisnika po usernameu
			{
				$a_korisnik_puno = "select x from korisnici where korisnik = '$varijabla'";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_id = $re_korisnik_puno["x"];
						return $ispis_id;
					}
			}
function puno_korisnik ($varijabla)
//Funckija koje puno ime korisnika po usernameu
			{
				$a_korisnik_puno = "select puno from korisnici where korisnik = '$varijabla'";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_id = $re_korisnik_puno["puno"];
						return $ispis_id;
					}
			}
function zapis ($useric,$ispis)
//Funckija zapisa u log
			{
				$ip10 = getenv("REMOTE_ADDR");
				$t = strtotime("now");
				//$tx = date("H:i");
				//$korisnik_zalog = id_korisnik($useric);
				//$useric=puno_ime($korisnik_zalog);
				$upitic10="insert into log (tko, ip, sta, sve) values ('$useric', '$ip10', '$ispis', '$t')";
				//echo $upitic10;
				$rsic10=mysql_query($upitic10) or die("<span class=podnaslovi_crveni>GREŠKA 047: Nemogu upisati log u tablicu!</span>");
			}			
function prava_korisnik_id ($varijabla)
//Funckija koja prava korisnika po idu
			{
				$a_korisnik_puno = "select prava from korisnici where x = '$varijabla'";
				$rez_korisnik_puno = mysql_query($a_korisnik_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id korisnika!</span>");
				while ($re_korisnik_puno = mysql_fetch_array($rez_korisnik_puno))
					{
						$ispis_prava = $re_korisnik_puno["prava"];
						return $ispis_prava;
					}
			}

function ime_predmeta ($varijabla)
//Funckija koja vraca ime predmeta
			{
				if ($varijabla != "oba")
				{
				$a_predmet_puno = "select ime from conf_predmeta where id = $varijabla";
				//echo $a_predmet_puno;
				$rez_predmet_puno = mysql_query($a_predmet_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja imena predmeta!</span>");
				while ($re_predmet_puno = mysql_fetch_array($rez_predmet_puno))
					{
						$ispis_predmet = $re_predmet_puno["ime"];
						return $ispis_predmet;
					}
				}
			}
function razred_predmeta ($varijabla)
//Funckija koja vraca koji je razred predmeta
			{
				if ($varijabla != "oba")
				{
				$a_predmet_puno = "select asst from conf_predmeta where id = $varijabla";
				//echo $a_predmet_puno;
				$rez_predmet_puno = mysql_query($a_predmet_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja imena predmeta!</span>");
				while ($re_predmet_puno = mysql_fetch_array($rez_predmet_puno))
					{
						$ispis_predmet = $re_predmet_puno["asst"];
						return $ispis_predmet;
					}
				}
			}
function izvjestaj ($varijabla)
//Funckija koja vraca naziv izvjestaja
			{

				$a_izv_puno = "select naziv,datum,razred,unosi from izvjestaji where id = $varijabla";
				//echo $a_predmet_puno;
				$rez_predmet_puno = mysql_query($a_izv_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja izvjestaja!</span>");
				while ($re_predmet_puno = mysql_fetch_array($rez_predmet_puno))
					{
						$ispis_predmet = $re_predmet_puno["naziv"];
						$ispis_datum = $re_predmet_puno["datum"];
						$razred = $re_predmet_puno["razred"];
						$unos = $re_predmet_puno["unosi"];
						$zajedno = "$ispis_predmet:::$ispis_datum:::$razred:::$unos";
						return $zajedno;
					}
				}
function ime_predmeta2 ($varijabla)
//Funckija koja vraca ime predmeta prema broju ispita
			{
				$prov = substr ($varijabla,0,1);
				//echo $prov;
				if ($prov =="a")
					{
						$upiti = substr ($varijabla,2);
						$a_predmet_puno = "select ime from doc_kategorije where id = $upiti";
						$rez_predmet_puno = mysql_query($a_predmet_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja imena kategorije!</span>");
						while ($re_predmet_puno = mysql_fetch_array($rez_predmet_puno))
							{
								$ispis_predmet = $re_predmet_puno["ime"];
								return $ispis_predmet;
							}
					}
				else
				{
				
				if ($varijabla == "oba" or $varijabla == "1500" or $varijabla == "1501" or $varijabla == "1502")
				{
					if ($varijabla =="1500")
					$ispis_predmeta = "Zajedni&#269;ki dokumenti";
					else
						{
							if ($varijabla =="1501")
							$ispis_predmeta = "Privatni dokumenti";
							else
							{
								if ($varijabla =="1502")
								$ispis_predmeta = "Nastavni&#269;ki dokumenti";
							}
						}					
					return $ispis_predmeta;
				}
				else
				{
				$a_predmet_puno = "select ime from conf_predmeta where broj_ispita = $varijabla";
				//echo $a_predmet_puno;
				$rez_predmet_puno = mysql_query($a_predmet_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja imena predmeta!</span>");
				while ($re_predmet_puno = mysql_fetch_array($rez_predmet_puno))
					{
						$ispis_predmet = $re_predmet_puno["ime"];
						return $ispis_predmet;
					}
				}
			} }
function grupe_predmeta ($varijabla)
//Funckija koja vraca broj grupa unutar predmeta
			{
				$a_predmet_puno = "select grupe from conf_predmeta where id = $varijabla";
				$rez_predmet_puno = mysql_query($a_predmet_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja imena predmeta!</span>");
				while ($re_predmet_puno = mysql_fetch_array($rez_predmet_puno))
					{
						$grupe_predmet = $re_predmet_puno["grupe"];
						return $grupe_predmet;
					}
			}
function oznaka_predmeta ($varijabla)
//Funckija koja vraca broj grupa unutar predmeta
			{
				$a_predmet_puno = "select broj_ispita from conf_predmeta where id = $varijabla";
				$rez_predmet_puno = mysql_query($a_predmet_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja imena predmeta!</span>");
				while ($re_predmet_puno = mysql_fetch_array($rez_predmet_puno))
					{
						$oznaka = $re_predmet_puno["broj_ispita"];
						return $oznaka;
					}
			}
			
function baza_redovi($upit) {
//Funkcija prebrojavanja redova iz SELECT upita 
	return mysql_num_rows($upit);
}

function razrednik ($varijabla)
//Funckija koja vraca 0 ili razred kojem je user razrednik
			{
				$a_korisnik_puno1 = "select jmbag from korisnici where x = '$varijabla'";
				//echo $a_korisnik_puno1;
				$rez_korisnik_puno1 = mysql_query($a_korisnik_puno1) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id razrednika!</span>");
				while ($re_korisnik_puno1 = mysql_fetch_array($rez_korisnik_puno1))
					{
						$ispis_id1 = $re_korisnik_puno1["jmbag"];
						return $ispis_id1;
					}
			}
function razred ($varijabla)
//Funckija koja vraca razred ucenika
			{
				$a_korisnik_puno1 = "select status from korisnici where x = '$varijabla'";
				//echo $a_korisnik_puno1;
				$rez_korisnik_puno1 = mysql_query($a_korisnik_puno1) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id razrednika!</span>");
				while ($re_korisnik_puno1 = mysql_fetch_array($rez_korisnik_puno1))
					{
						$ispis_id1 = $re_korisnik_puno1["status"];
						return $ispis_id1;
					}
			}
function ucenik_rod ($varijabla)
//Funckija koja vraca ucenika ciji je korisnik roditelj
			{
				$a_korisnik_puno1 = "select vjezbe from korisnici where x = '$varijabla'";
				//echo $a_korisnik_puno1;
				$rez_korisnik_puno1 = mysql_query($a_korisnik_puno1) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id razrednika!</span>");
				while ($re_korisnik_puno1 = mysql_fetch_array($rez_korisnik_puno1))
					{
						$ispis_id1 = $re_korisnik_puno1["vjezbe"];
						return $ispis_id1;
					}
			}
function roditelj ($varijabla)
			//Funckija koja vraca tko je roditelj za usera? - dodati još negdje ako zatreba
			{
				$a_korisnik_puno1 = "select x from korisnici where vjezbe = '$varijabla'";
				//echo $a_korisnik_puno1;
				$rez_korisnik_puno1 = mysql_query($a_korisnik_puno1) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id razrednika!</span>");
				while ($re_korisnik_puno1 = mysql_fetch_array($rez_korisnik_puno1))
					{
						$ispis_id1 = $re_korisnik_puno1["x"];
						$ispisx .= ":::$ispis_id1"; 
						return $ispisx;
					}
			}
function predmet_razred ($varijabla)
//Funckija koja koji je razred varijabla predmeta (broj ispita)
			{
				$a_korisnik_puno1 = "select asst from conf_predmeta where broj_ispita = '$varijabla'";
				//echo $a_korisnik_puno1;
				$rez_korisnik_puno1 = mysql_query($a_korisnik_puno1) or die("GREŠKA pozivanja id razrednika!");
				while ($re_korisnik_puno1 = mysql_fetch_array($rez_korisnik_puno1))
					{
						$ispis_id1 = $re_korisnik_puno1["asst"];
						return $ispis_id1;
					}
			}
function profesor_predmet ($varijabla)
//Funckija koja koji je profesor varijabla predmeta
			{
				$a_korisnik_puno1 = "select profesor from conf_predmeta where broj_ispita = '$varijabla'";
				//echo $a_korisnik_puno1;
				$rez_korisnik_puno1 = mysql_query($a_korisnik_puno1) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id razrednika!</span>");
				while ($re_korisnik_puno1 = mysql_fetch_array($rez_korisnik_puno1))
					{
						$ispis_id1 = $re_korisnik_puno1["profesor"];
						return $ispis_id1;
					}
			}
function elementi_razred ($varijabla)
//Funckija koja koji je razred varijabla predmeta (broj ispita)
			{
				$a_korisnik_puno1 = "select oprofesoru from conf_predmeta where id = '$varijabla'";
				//echo $a_korisnik_puno1;
				$rez_korisnik_puno1 = mysql_query($a_korisnik_puno1) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja id razrednika!</span>");
				while ($re_korisnik_puno1 = mysql_fetch_array($rez_korisnik_puno1))
					{
						$ispis_id1 = $re_korisnik_puno1["oprofesoru"];
						return $ispis_id1;
					}
			}
function elementi_izvjestaja ($varijabla)
//Funckija koja vraca naziv izvjestaja
			{

				$a_izv_puno = "select element from izvjestaji where id = $varijabla";
				//echo $a_predmet_puno;
				$rez_predmet_puno = mysql_query($a_izv_puno) or die("<span class=podnaslovi_crveni>GREŠKA pozivanja izvjestaja!</span>");
				while ($re_predmet_puno = mysql_fetch_array($rez_predmet_puno))
					{
						$ispis_predmet = $re_predmet_puno["element"];
						$zajedno = "$ispis_predmet";
						return $zajedno;
					}
				}

//provjera koji predmet braco smije slušati
if ($prava_postavke !="")
{
	if ($prava_postavke != "1")
		{
			if ($prava_postavke != "4")
			{
			if ($prava_postavke=="2")
			$a_prava = "select * from conf_predmeta where napravio = $user order by id desc";
			elseif ($prava_postavke=="3")
			$a_prava = "select * from conf_predmeta order by id desc";
			//echo $a_prava;
			$rez_prava = mysql_query($a_prava) or die("$prava_postavke Greškaasg prilikom upita u bazu konfiguracije predmeta!");
			$c_prava = mysql_num_rows($rez_prava);	
			}
		}
}	


function broj_pm($user) {
//funkcija provjere PM poruka - broj novih
			$a_pm = "select id from pm where kome='$user' and procitano='0'";
			$rez_pm = mysql_query($a_pm) or die("<span class=podnaslovi_crveni>Greška prilikom upita u PM tablicu!</span>");
			$broj_redova = baza_redovi($rez_pm);
			return $broj_redova;
}



function slanje_pm($user,$kome,$sto,$naslov) {
//funkcija slanja PM poruka
			$t = date("j.n.Y");
			$tx = date("H:i");
			$upitic10="insert into pm (tko, kome, sto, procitano, kada,naslov) values ('$user', '$kome', '$sto', '0', '$t u $tx','$naslov')";
			//echo $upitic10;
			$rez_pm = mysql_query($upitic10) or die("<span class=podnaslovi_crveni>Greška prilikom upisa u PM tablicu!</span>");
			$valja = "Vaša poruka je uspješno poslana!";
			return $valja;
}

function str_replace_count($search,$replace,$subject,$times) {
//funkcija zamjene samo jednom
    $subject_original=$subject;
    $len=strlen($search);   
    $pos=0;
    for ($i=1;$i<=$times;$i++) {
        $pos=strpos($subject,$search,$pos);
       
        if($pos!==false) {               
            $subject=substr($subject_original,0,$pos);
            $subject.=$replace;
            $subject.=substr($subject_original,$pos+$len);
            $subject_original=$subject;
        } else {
            break;
        }
    }
    return($subject);
}

//funkcije chata
/*preuzeto sa http://css-tricks.com/chat2/ 
prilagodba: Milan Puvaca, Ofir d.o.o. - veljaca 2011. */
//functions
function checkVar($var)
{
	$var = str_replace("\n", " ", $var);
	$var = str_replace(" ", "", $var);
	if(isset($var) && !empty($var) && $var != '')
	{
		return true;
	}
	else
	{
		return false;	
	}
}
function hasData($query)
{	$rows = mysql_query($query)or die("somthing is wrong");
	$results = mysql_num_rows($rows);
	if($results == 0)
	{
		return false;  
	}
	else
	{
		return true;  
	}
}
function isAjax()
	{
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
		{
	     	return true; 
		}	
		else
		{
			return false;
		}
		
	}

function cleanInput($data)
	{
		// http://svn.bitflux.ch/repos/public/popoon/trunk/classes/externalinput.php
		// +----------------------------------------------------------------------+
		// | Copyright (c) 2001-2006 Bitflux GmbH                                 |
		// +----------------------------------------------------------------------+
		// | Licensed under the Apache License, Version 2.0 (the "License");      |
		// | you may not use this file except in compliance with the License.     |
		// | You may obtain a copy of the License at                              |
		// | http://www.apache.org/licenses/LICENSE-2.0                           |
		// | Unless required by applicable law or agreed to in writing, software  |
		// | distributed under the License is distributed on an "AS IS" BASIS,    |
		// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      |
		// | implied. See the License for the specific language governing         |
		// | permissions and limitations under the License.                       |
		// +----------------------------------------------------------------------+
		// | Author: Christian Stocker <chregu@bitflux.ch>                        |
		// +----------------------------------------------------------------------+
		//
		// Kohana Modifications:
		// * Changed double quotes to single quotes, changed indenting and spacing
		// * Removed magic_quotes stuff
		// * Increased regex readability:
		//   * Used delimeters that aren't found in the pattern
		//   * Removed all unneeded escapes
		//   * Deleted U modifiers and swapped greediness where needed
		// * Increased regex speed:
		//   * Made capturing parentheses non-capturing where possible
		//   * Removed parentheses where possible
		//   * Split up alternation alternatives
		//   * Made some quantifiers possessive

		// Fix &entity\n;
		$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		// Remove javascript: and vbscript: protocols
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

		do
		{
			// Remove really unwanted tags
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		}
		while ($old_data !== $data);

		return $data;
	}

function charset_decode_utf_8 ($string) {
      /* Only do the slow convert if there are 8-bit characters - najbolja skripta za HR slova i konverziju u SQL :) */
    if (! preg_match("[\200-\237]", $string) and ! preg_match("[\241-\377]", $string))
        return $string;
    // decode three byte unicode characters
    $string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/e",       
    "'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'",   
    $string);
    // decode two byte unicode characters
    $string = preg_replace("/([\300-\337])([\200-\277])/e",
    "'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'",
    $string);
    return $string;
} 
function zamjeni_nazad($sta) {
//funkcija mjenjanja tocke i zareza u ocjeni nazad na HR
		setlocale(LC_MONETARY, "no_NO");
		$tfa= money_format("%!.2n", $sta);
		return $tfa;
}

		 ?>