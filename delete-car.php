<?php
$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "cars_test";
$connect = mysqli_connect($dbServerName,$dbUsername,$dbPassword,$dbName);

foreach ($_POST as $post){
    $sql = "DELETE FROM `cars_for_sale` WHERE car_id=$post"; // SQL with parameters
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $deleteImages = "DELETE FROM pictures WHERE car_id = $post";
    $statement = $connect->prepare($deleteImages);
    $statement->execute();
    $end = $statement->get_result();

    echo "Uspješno poništen automobil sa ID brojem: ".$post;
}