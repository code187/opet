<script type="text/javascript" src="js/jquery.jSuggest.1.0.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.js"></script>
<script type="text/javascript"> 
var user = <?php echo $user; ?>;
var prava = <?php echo $prava_postavke; ?>;
$(function(){
if ((prava=="2") || (prava=="3"))
{
	$("#sazetakkkk").jSuggest({
		url: "moduli/nastava/komentari.php?user="+user,
		type: "GET",
		data: "niz",
		autoChange: false
	}); return false;
}

})   

</script>
<SCRIPT LANGUAGE="JavaScript">
var user = <?php echo $user; ?>;
$(function() {
$('.jsonic').bind('keydown', function(evt) {
if(evt.keyCode==9) {
$(this).find("input").blur();
var nextBox='';
var idx = $(".jsonic").index(this);
if ($(".jsonic").index(this) == ($(".jsonic").length-1)) {
idx = 0;
nextBox=$(".jsonic:first");
} else {
idx = idx+1;
nextBox=$(this).next(".jsonic");
}
$('.jsonic:eq('+idx+')').trigger('click')
return false;
};
})


$('.jsonic').editable('moduli/nastava/snimi_post_brzo.php?user=<?php echo $user; ?>', { 
         submit    : 'OK',
		 onblur   : 'submit',
         tooltip   : 'Unutar sat vremena od objave komentara imate pravo na izmjenu.',
		callback: function(value, settings) {
      	var retval = escape(value);
        return retval;
    }
			});
		   });
</script>
<SCRIPT LANGUAGE="JavaScript">
<!-- Original: wsabstract.com -->

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->
<!-- Promjene by Milan Puvaca, 2006. -->
<!-- Begin
function checkrequired(which) {
var pass=true;
if (document.images) {
for (i=0;i<which.length;i++) {
var tempobj=which.elements[i];
if (tempobj.title.substring(0,8)=="req") {
if (((tempobj.type=="text"||tempobj.type=="textarea")&&
tempobj.value=='')||(tempobj.type.toString().charAt(0)=="s"&&
tempobj.selectedIndex==0)) {
pass=false;
break;
         }
      }
   }
}
if (!pass) {
shortFieldName=tempobj.name.substring(8,30).toUpperCase();
alert("Sva polja moraju biti popunjena!");
return false;
}
else
return true;
}
//  End -->
</script>
<script type="text/javascript">

  
jQuery(document).ready(function(){
     $('#nastavnik').change(function(){           
        var optionValue = jQuery("select[name='nastavnik']").val();   
		$('#predmet').empty('');   
        jQuery.ajax({
            type: "GET",
            url: "moduli/nastava/dd_predmet.php",
            data: "user="+"<?php echo $user; ?>"+"&id="+optionValue,
            success: function(response){
                jQuery("#predmet").append(response);
            }
        });
    });
	$('#obr').click(function() {
		$('#predmet').empty('');
		$('#nastavnik').val('');
	});
});
  
</script>
<?php
$sazetak="";
$predmet="";
$ak="";
$sazetak=mysql_real_escape_string($sazetak);
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
if ($ak=="7")
{
	//brisanje posta
	$a = "select * from forum_postovi where id = $idic order by id asc";
	$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>GRE�KA: pozivanja tablice postova foruma!</span>");
	while ($re = mysql_fetch_array($rez))
		{
			$pta_tko = $re["tko"];
		}
		if ($pta_tko == $user or $prava_postavke=="3")
			{
				$a = "delete from forum_postovi where id = $idic";
				$rez = mysql_query($a) or die("<span class=podnaslovi_crveni>GRE�KA: brisanja postova foruma!</span>");
				echo "<b>Komentar uspje�no obrisan!</b><br>";
			}
}
//snimi post
if ($ak=="2")
	{ 
		//mlati li netko po refreshu?
		//dvije minute ne mo�e stisnuti refresh
		//$compare = $compare + 300 ;
		//echo "proba $nastavnik $predmet";
		$zaprovjeru = $compare-3;
		$a = "select * from forum_postovi where prip='u-$idk' and moze>=$zaprovjeru;";
		//echo $a;
		$rezaa = mysql_query($a) or die("<span class=podnaslovi_crveni>GRE�KA: pozivanja tablice kategorija foruma!</span>");
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
						$rezpp = mysql_query($ap) or die("<span class=podnaslovi_crveni>Gre�ka prilikom upita u predmeta!</span>");
						$cpp = mysql_num_rows($rezpp);
						if ($cpp!="0")
						{ 
							$brojim=0; 
							while ($repp = mysql_fetch_array($rezpp))
							{
								$ukupno=0;
								$id = $repp["id"]; //id predmeta
								//pogledaj je li taj ucenik i u jednom izvje�taju tog predmeta? $idk je ucenikov id
								$ab = "select * from izvjestaji where pripadnost = $id";
								$rezb = mysql_query($ab) or die("<span class=podnaslovi_crveni>Gre�ka prilikom upita u bazu izvjestaja!</span>");
								while ($reb = mysql_fetch_array($rezb))
								{
									$unosi = $reb["unosi"]; 
									$ac="select id from izvjestaj$unosi where ucenik=$idk";	
									$rezc = mysql_query($ac) or die("<span class=podnaslovi_crveni>Gre�ka prilikom upita u bazu izvjeszaja predmeta!</span>");
									$cc = mysql_num_rows($rezc);
									if ($cc>0) //ima ucenika u barem jednom izvje�taju znaci da tom nastavniku treba prosljedena informacija
									$ukupno++;
								}
								if ($ukupno!="0")
								{
									$upit_snimi="insert into forum_postovi (opis,prip,tko,kada, moze, tko_smije) values ('$sazetak', 'u-$idk-$id','$user','$skupa','$compare','$dozvole');";
										$rs=mysql_query($upit_snimi) or die("<span class=podnaslovi_crveni>Gre�ka prilikom upisa u bazu postova foruma!</span>");
										$ock=1;
								}
							}
							if ($ock=="1")
							{
								echo "<b>Komentar uspje�no objavljen kao komentar na svim predmetima u&#269;enika!</b><br>";
								zapis ("$user","412-u-$idk");
							}
						}

					}
					$upit_snimi="insert into forum_postovi (opis,prip,tko,kada, moze, tko_smije) values ('$sazetak', 'u-$idk','$user','$skupa','$compare','$dozvole');";
					//echo $upit_snimi;
					$rs=mysql_query($upit_snimi) or die("<span class=podnaslovi_crveni>Gre�ka prilikom upisa u bazu postova foruma!</span>");
					echo "<b>Komentar uspje�no poslan!</b><br>";
					zapis ("$user","403-u-$idk");
				}
		}
		else
		echo "<b>Ne dozvoljeno ponavljanje postanja!</b><br>";
	}
//standardni ispis
$poredba = date('U');
$bojko = "";
		//tko smije vidjeti na� komentar?
		$item_per_page = 5; //broj postova po otkrivanju
		if ($prava_postavke=="1") //ucenik
	  $a = "select * from forum_postovi where prip = 'u-$idk' and (tko_smije='' or tko_smije='1' or tko_smije='4') order by id desc";
	  elseif ($prava_postavke=="4") //roditelj
	   $a = "select * from forum_postovi where prip = 'u-$idk' and (tko_smije='' or tko_smije='1' or tko_smije='3') order by id desc";
	   else
	   $a = "select * from forum_postovi where prip = 'u-$idk' order by id desc";
	  //echo $a;
	  $rez = mysql_query($a) or die("<span class=podnaslovi_crveni>GRE�KA: pozivanja tablice postova!</span>");
	  //prebrojimo postove za load more
	  $broj_postova_total = mysql_num_rows($rez);
	  
	  $total_pages = ceil($broj_postova_total/$item_per_page); 
	  ?>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function() {
    var track_click = 0; //track user click on "load more" button, righ now it is 0 click
    var total_pages = <?php echo $total_pages; ?>;	
	$('.results').load("dohvati_postove.php?user=<?php echo $user; ?>&idk=<?php echo $idk; ?>", {'page':track_click}, function() {track_click++;});
    $(".load_more").click(function (e) { //user clicks on button
        $(this).hide(); //hide load more button on click
        $('.animation_image').show(); //show loading image
        if(track_click <= total_pages) //user click number is still less than total pages
        {
            //post page number and load returned data into result element
            $.post('dohvati_postove.php?user=<?php echo $user; ?>&idk=<?php echo $idk; ?>',{'page': track_click}, function(data) {
           
                $(".load_more").show(); //bring back load more button
               
                $(".results").append(data); //append data received from server
               
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
<table id=tablica_lijevop><tr class=alt><td width=70%><b><p align=center>Komentar</p></b></td><td width="10%"><b><p align=center>Vrijeme</p></b></td><td><b><p align=center>Po�iljatelj</p></b></td></tr></table>
<table id=tablica_lijevop class="results"></table>

<div align="center">
<button class="load_more" id="load_more_button">Stariji komentari</button>
<div class="animation_image" style="display:none;"><img src="images/ajax-loader.gif"></div>
</div>
    </table><br />
    <form action="admin.php?p=ucenik&amp;m=nastava&amp;ak=2&idk=<?php echo "$idk&razred=$razred"; ?>" method="post" name="popupform" autocomplete="off" onsubmit="MM_validateForm('sazetak','','R');return document.MM_returnValue">
    <table width=95%  align=center cellpadding=1 cellspacing=0 border=0 ><tr><td align="center"> 
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
    <input type="hidden" id="user" value="<?php echo $user; ?>"  /><input type="hidden" id="compare" name="compare" value="<?php echo $poredba; ?>"  /><input name="proslijedi" alt="Odaberite za objavu komentara na sve predmete u&#269;enika" title="Odaberite za objavu komentara na sve predmete u&#269;enika" type="checkbox" value="1" />
    Proslijedi za sve nastavnike/predmete<br /><br />
    <textarea name="sazetak" cols="70" rows="0" class="area" id="sazetak"></textarea>
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
      <input type="submit" value="Po&scaron;alji" />
</td></tr></table></form>
