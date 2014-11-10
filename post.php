<?php


if ($predmet!="")
{
	$sesija_id = session_id();
	$link ="download.php?id_br=$predmet&s=$sesija_id target=_blank";
	$tmp_p="<a href=$link>Prilo&#382;eni dokument</a>";
	$sazetak="$sazetak||||$tmp_p";
	//omoguci da ucenik i roditelj vide taj fajl + user
	$ucenik_u=$idk;
	$roditelj_u = roditelj($idk);
	$nadi=":::";
	$pos = strpos($roditelj_u, $nadi);
	//echo "laa $roditelj_u";
	$t_rod = explode(":::",$roditelj_u);
	foreach ($t_rod as $t)
		{
			if ($t!="")
			$rod_total .= "$rod_total,$t,";
		}
				//dodaj usera da je pogledao te dokumente
					//ima li tog usera??
				$af = "select id,pregled from doc where id='$predmet'";
				$rezf = mysql_query($af) or die("<span class=podnaslovi_crveni>GRESKA: Pozivanja tablice za pregled dokumenata!</span>");
				$cf = mysql_num_rows($rezf);
				if ($cf!=0) 
				{ 
				while ($ref = mysql_fetch_array($rezf))
					{
						$pregled = $ref["pregled"];
						$op = strpos ($pregled,",$user,");	
						if ($op===false)
							{
								$a_test = "update doc set pregled=CONCAT(pregled,',$user,') where id = '$predmet'";
								$rez_test = mysql_query($a_test) or die("query neispravan");
							}
						$op2 = strpos ($pregled,",$ucenik_u,");	
						if ($op2===false)
							{
								$a_test = "update doc set pregled=CONCAT(pregled,',$ucenik_u,') where id = '$predmet'";
								$rez_test = mysql_query($a_test) or die("query neispravan");
							}
						$op3 = strpos ($pregled,",$rod_total,");	
						if ($op3===false)
							{
								$a_test = "update doc set pregled=CONCAT(pregled,',$rod_total,') where id = '$predmet'";
								$rez_test = mysql_query($a_test) or die("query neispravan");
							}
					}
				}
}
//snimi post
if ($ak=="2")
	{ 
		//mlati li netko po refreshu?
		//dvije minute ne može stisnuti refresh
		//$compare = $compare + 300 ;
		//echo "proba $nastavnik $predmet";
		$zaprovjeru = $compare-3;
		$a = "select * from forum_postovi where prip='u-$idk' and moze>=$zaprovjeru;";
		//echo $a;
		$rezaa = mysql_query($a) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja tablice kategorija foruma!</span>");
		$imali = mysql_num_rows($rezaa);
		if ($imali =="0")
		{
			if ($sazetak!="")
				{
					//datum
					$datumic = date("j.m.Y"); $tx = date("H:i:s");
					$skupa = "$datumic - $tx";
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
$poredba = date('U');
$bojko = "";
		//tko smije vidjeti naš komentar?
		$item_per_page = 5; //broj postova po otkrivanju
		if ($prava_postavke=="1") //ucenik
	  $a = "select * from forum_postovi where prip = 'u-$idk' and (tko_smije='' or tko_smije='1' or tko_smije='4') order by id desc";
	  elseif ($prava_postavke=="4") //roditelj
	   $a = "select * from forum_postovi where prip = 'u-$idk' and (tko_smije='' or tko_smije='1' or tko_smije='3') order by id desc";
	   else
	   $a = "select * from forum_postovi where prip = 'u-$idk' order by id desc";
	  //echo $a;
	  $rez = mysql_query($a) or die("<span class=podnaslovi_crveni>GREŠKA: pozivanja tablice postova!</span>");
	  //prebrojimo postove za load more
	  $broj_postova_total = mysql_num_rows($rez);
	  
	  $total_pages = ceil($broj_postova_total/$item_per_page); 
	  
	  ?>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function() {
    var track_click = 1; //track user click on "load more" button, righ now it is 0 click
    var total_pages = <?php echo $total_pages; ?>;	
	$('.results').load("http://gaudeamus.hr/mobile/dohvati_postove.php?user=<?php echo $user; ?>&idk=<?php echo $idk; ?>", {'page':track_click}, function() {track_click++;});
    $(".load_more").click(function (e) { //user clicks on button
        $(this).hide(); //hide load more button on click
        $('.animation_image').show(); //show loading image
        if(track_click <= total_pages) //user click number is still less than total pages
        {
            //post page number and load returned data into result element
            $.post('dohvati_postove.php?user=<?php echo $user; ?>&idk=<?php echo $idk; ?>',{'page': track_click}, function(data) {
           
                $(".load_more").show(); //bring back load more button
               
                $("#postovi").append(data); //append data received from server
               
                //scroll page smoothly to button id
                $("html, body").animate({scrollTop: $("#load_more_button").offset().top}, 500);
               
                //hide loading image
                $('.animation_image').hide(); //hide loading image once data is received
   
                track_click++; //user click increment on load button
           
            }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                alert(thrownError); //alert with HTTP error
                $(".load_more").show(); //bring back load more button
                $('.animation_image').hide(); //hide loading image once data is received
            });     
            if(track_click >= total_pages-1) //compare user click with page number
            {
                //reached end of the page yet? disable load button
                $(".load_more").attr("disabled", "disabled");
            }
         }
         
        });
});
</script>
<br>

<div align="center">
<button class="load_more" id="load_more_button">Stariji komentari</button>
<div class="animation_image" style="display:none;"><img src="images/ajax-loader.gif"></div>
</div>
    </table><br />
    <form  method="post" name="nasaforma" id="nasaforma" autocomplete="off" >
    
    <table align=center cellpadding=1 cellspacing=0 border=0 ><tr><td align="center"> 
	<?php if ($prava_postavke=="2" or $prava_postavke=="3") { ?>  Komentar smiju vidjeti:&nbsp;<select name="dozvole" id="dozvole">
      <option value="1" style="background-color:<?php echo "#ffffff"; ?>;">Svi</option>
      <option value="2" style="background-color:<?php echo "#8ec6e9"; ?>;">Samo nastavnik</option>
      <option value="4" style="background-color:<?php echo "#ebf6ad"; ?>;">Samo u&#269;enik</option>
      <option value="3" style="background-color:<?php echo "#f2d4b4"; ?>;">Nastavnik i roditelj</option>
    </select> <?php } ?>
    <?php if ($prava_postavke=="4") { ?>  Komentar smiju vidjeti:&nbsp;<select name="dozvole" id="dozvole">
      <option value="1" style="background-color:<?php echo "#ffffff"; ?>;">Svi</option>
      <option value="3" style="background-color:<?php echo "#f2d4b4"; ?>;">Nastavnik i roditelj</option>
    </select> <?php } ?>
    <input type="hidden" name="user" id="user" value="<?php echo $user; ?>"  /><input type="hidden" name="ak" id="ak" value="2"  /><input type="hidden" id="x" value="<?php echo $user; ?>"  /><input type="hidden" id="idk" name="idk" value="<?php echo $idk; ?>"  /><input type="hidden" name="predmet" id="predmet" value="<?php echo $predmet; ?>"  /><input type="hidden" id="compare" name="compare" value="<?php echo $poredba; ?>"  /><input name="proslijedi" alt="Odaberite za objavu komentara na sve predmete u&#269;enika" title="Odaberite za objavu komentara na sve predmete u&#269;enika" type="checkbox" value="1" />
    Proslijedi za sve nastavnike/predmete<br /><br />
    <textarea name="sazetak" cols="40" rows="5" class="area" id="sazetak"></textarea>
      <!--odabir povezanog dokumenta-->
      <?php if ($prava_postavke=="3" or $prava_postavke=="2")
	  { ?><br />
      Prilo&#382;eni dokument:&nbsp;<select name="nastavnik" id="nastavnik" class="formbutton2">
      <option value=''>Odabir...</option>
	<?php
	echo "<option value=1502>Nastavni&#269;ki dokumenti</option>";
	$af = "select id,ime from doc_kategorije where pripadnost like '1502%'";
	$rezf = mysql_query($af) or die("<span class=podnaslovi_crveni>GRESKA: Pozivanja tablice za pregled podkategorija!</span>");
	$cf = mysql_num_rows($rezf);
	if ($cf!=0) 
		{ 
		while ($ref = mysql_fetch_array($rezf))
			{
				$id_podkat = $ref["id"];
				$ime_podkat = $ref["ime"]; 
				echo "<option value='a_$id_podkat'>-- $ime_podkat</option>";
				//a ima li podkategorija toga??
				$afc = "select id,ime from doc_kategorije where pripadnost = 'a_$id_podkat' ";
				$rezfc = mysql_query($afc) or die("<span class=podnaslovi_crveni>GRESKA: Pozivanja tablice za pregled podkategorija!</span>");
				$cfc = mysql_num_rows($rezfc);
				if ($cfc!=0) 
				{ 
					while ($refa = mysql_fetch_array($rezfc))
					{
						$id_podkata = $refa["id"];
						$ime_podkata = $refa["ime"]; 
						echo "<option value='a_$id_podkata'>---- $ime_podkata</option>";
					}
				}
			}
		}
	?>
        </select>
        <select name="predmet" id="predmet" class="formbutton2">
                        </select><img src='images/delete1.png' border=0 title="Obri&scaron;i" alt="Obri&scaron;i" id=obr> 
               <?php } ?>  
               <!--kraj povezanog dokumenta-->      
      <br />
      <input type="button" value="Po&scaron;alji" id="posaljime" />
       
</td></tr></table></form>
