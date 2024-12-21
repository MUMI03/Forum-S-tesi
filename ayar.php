<?php
$host="localhost";
$dbname="DisplayCardCenter";
$charset="utf8";
$root="root";
$password="";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset;",$root,$password);
}catch (PDOException $error){
    echo $error->getMessage();
}

//CSRF token
if ($_SESSION){
    if (!isset($_POST["_token"])){
        $_SESSION["_token"]=md5(time().rand(0,99999999));
    }
}