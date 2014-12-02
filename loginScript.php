<?php
//Author: Richard Cerone and Daniel Read
//Include database connection.
include "./db.php";
session_start();
//Pull admin login credentials from the database.
/*$result = mysqli_query($connect, "SELECT * FROM login WHERE username = '".
                       $_POST['username']."' AND password = '".$_POST['password']."' LIMIT 1");
	*/				   
if (($_POST['username'] == "mark") && ($_POST['password'] == "systems"))
{

    //$row = mysqli_fetch_assoc($result); //Fetch row info recieved from database.
    $success = true; //Login successful.
    $message = "login successful"; //Load string for user to recieve.
	$_SESSION['loggedIn'] = true;
}
else
{
    $success = false; //Login failed.
    $message = "Invalid username or password. Please try again."; 
}
	
	

//Load data into array.
$arr = array(
    "success" => $success,
    "message" => $message
);

echo json_encode($arr); //Use json to pass all the info back to login.
?>