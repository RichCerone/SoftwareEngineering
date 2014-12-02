<?php session_start(); ?>
<!DOCTYPE HTML>
<!--Author: Richard Cerone-->
<!--Import JQuery-->
<!--testing-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>


<?php

if ($_SESSION['loggedIn'] == true)
{ ?>
<head>
    <!--Import CSS Style Sheet-->
    <link rel="stylesheet" type="text/css" href="./adminPanel.css">
    <!--Import Font Style-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<html>
    <!--Title-->

    <body>
	
<div class="container">
    <div class="right">

				<!--Align Buttons On top of each other-->
		<p>
			<!--Upload Map Button-->
			<div id="uploadMap">
				<input type="submit" class="button" id="uploadMap" value="Upload A New Map">
			</div>
			<!--Manage Map Button-->
			<div id="manageMap">
				<input type="submit" class="button" id="manageMap" value="Manage Maps">
			</div>
			<div id="logout">
				<input type="submit" class="button" id="logout" value="Logout">
			</div>
		</p>
	</div>
    <div class="left"  id="portal">
	

	</div>
</div>
<?php }
else
{
echo "You are not logged in";
}
?>

    <!--This script listens to each button and displays the specific page when clicked.-->
    <script>
         $("#uploadMap").click(function() 
            {
                $("#portal").load("uploadMaps.php"); //Load updateMap.php into portal.
            });
         $("#manageMap").click(function()
            {
                $("#portal").load("manageMaps.php"); //Load manageMaps.php into portal.                    
            });
		$("#logout").click(function()
		{
			window.location.href = "./logoutScript.php";
		});
    </script>
</html>