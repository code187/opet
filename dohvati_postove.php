<?php 
error_reporting(0);
$user = filter_var($_POST["user"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
include("postavke_read.php");
include("funkcije.php");

//sanitize post value
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$prava_kor = prava_korisnik_id($user);



//throw HTTP error if page number is not valid
if(!is_numeric($page_number)){
    header('HTTP/1.1 500 Invalid page number!');
    exit();
}

//get current starting point of records
$item_per_page = 5;
$position = ($page_number * $item_per_page);


//Limit our results within a specified range.
if ($prava_kor=="1") //ucenik
$a = "select * from forum_postovi where prip = 'u-$idk' and (tko_smije='' or tko_smije='1' or tko_smije='4') order by id desc LIMIT $position, $item_per_page";
elseif ($prava_kor=="4") //roditelj
$a = "select * from forum_postovi where prip = 'u-$idk' and (tko_smije='' or tko_smije='1' or tko_smije='3') order by id desc LIMIT $position, $item_per_page";
else
$a = "select * from forum_postovi where prip = 'u-$idk' order by id desc LIMIT $position, $item_per_page";
//echo $a;
$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja tablice postova!</span>");
while ($re = mysql_fetch_array($rez))
				{	
					$pt_id = $re["id"]; 
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
					echo "<li ".$bojko.">";	
					$pt_mozel = $pt_tko;
					$pt_tko = puno_ime($pt_tko);
					$slika_korisnika=slika_korisnika($pt_mozel);
					if ($slika_korisnika!="")
					{
						$filename="../../doc/fotke/korisnici/$slika_korisnika";
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
					echo "<li id='$pt_id'><span><img src=$slika width=40 border=0><p>$pt_tko<br>$pt_kada</p></li><div style=clear:both></div><li class='$pt_id' style='display: none;'><p>$pt_opis</p></span></li><script>
 $(document).ready(function() {
        $('#$pt_id').click(function() {
                $('.$pt_id').slideToggle('fast');
        });
		//var mak=<?php echo $red_idova[0]; ?>;
		//$('#'+mak+').show();
    });
</script></li>";
					else
						echo "<li id='$pt_id'><span><img src=$slika width=40 border=0><p>$pt_tko<br>$pt_kada</p></li><div style=clear:both></div><li class='$pt_id' style='display: none;'><p>$pt_opis</p></span></li><script>
 $(document).ready(function() {
        $('#$pt_id').click(function() {
                $('.$pt_id').slideToggle('fast');
        });
		//var mak=<?php echo $red_idova[0]; ?>;
		//$('#'+mak+').show();
    });
</script></li>";
				}
?>
<SCRIPT LANGUAGE="JavaScript">
$('.jsonic').editable('moduli/nastava/snimi_post_brzo.php?user=<?php echo $user; ?>', { 
         submit    : 'OK',
		 onblur   : 'submit',
         tooltip   : 'Unutar sat vremena od objave komentara imate pravo na izmjenu.',
		callback: function(value, settings) {
      	var retval = escape(value);
        return retval;
    }
			});
		
</script>          