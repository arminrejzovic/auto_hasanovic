<?php

$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "cars_test";
$connect = mysqli_connect($dbServerName,$dbUsername,$dbPassword,$dbName);

$name = $_POST["name"];
$mail = $_POST["mail"];
$subject = $_POST["subject"];
$message = $_POST["message"];

if (strlen($message)<20){
    header("Location: ./Kontakt.html#shortmessage");
    exit();
}

$sql = "INSERT INTO `messages`(`message_id`, `name`, `email`, `subject`, `message`) 
VALUES (NULL,'$name','$mail','$subject','$message');";
$statement = $connect->prepare($sql);
$statement->execute();
$result = $statement->get_result();

header("Location: ./Kontakt.html#success");
exit();
