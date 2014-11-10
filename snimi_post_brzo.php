<?php 
include("postavke_read.php");
include("funkcije.php");

if(isset($_POST['id'])) 
	{	
		$status=$_POST['id'];
		$value=$_POST['value'];
 		if(strlen($status) > 0) 
			{	
				//u statusu je broj i ime polja
				$value = charset_decode_utf_8 ($value);
				/*$value = str_replace("&#352;","Š",$value);
				$value = str_replace("&#353;","š",$value);
				$value = str_replace("&#381;","Ž",$value);
				$value = str_replace("&#382;","ž",$value);*/
				$value=mysql_real_escape_string($value);
				$a_test = "update forum_postovi set `opis`='$value' where id=$status";
				//echo $a_test;
				$rez_test = mysql_query($a_test) or die("Ne dozvoljeni znakovi u polju. Javite se na info@ofir.hr!");
				$value=trim($value);
				echo $value;
			}
			
	}
	else
	echo "Neovlašten pristup!";
?>
                
               
               