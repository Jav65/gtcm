<?php

$servername = "localhost";
$username = "gtcm";
$password = "gtcmmarves";
$dbname = "gtcm";

// Create connection
try{
    $conn = new mysqli($servername, $username, $password, $dbname);
    //echo var_dump($conn), "<br><br>";
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}catch(Exception $e){
    include "popup.html";
    $text = 'Server not found!';
    echo "<script> text = '$text'; showPopup(true,text);</script>";
}


?>