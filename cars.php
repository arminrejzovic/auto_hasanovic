<?php
$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "cars_test";

$CarsList = array();

$connection = mysqli_connect($dbServerName,$dbUsername,$dbPassword,$dbName);


$sqlStatement = "SELECT * FROM cars_for_sale;";
$query = mysqli_query($connection,$sqlStatement);
while ($car = mysqli_fetch_assoc($query)){
    array_push($CarsList,$car);
}

echo json_encode($CarsList);