<?php
echo"<div id='midd'>
	<h3>Poštovani, aplikacija je trenutno namjenjena za učenike i roditelje.</h3><br />
    <h4><a onclick='logout()' href='http://gaudeamus.hr/mobile/logout.php'>Povratak</a></h4></div>";
?>
<script>
 function logout() {
 var x =sessionStorage.getItem("x");	
	 var x =sessionStorage.getItem("x");
	
    $.post("http://gaudeamus.hr/mobile/logout.php",
    {
   	
		x:x
		
	 },
    function(data,status){
		var x=document.getElementById("naslov");
      	//alert(data);
		//alert;
		$("#tijelo").html(data);
		//data = jQuery.parseJSON(data);
		console.log(data);
		//alert(data.puno);
		 
        $("#naslov").text(data.puno);
		
    });
 }

</script>