<?php

$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "cars_test";
$connection = mysqli_connect($dbServerName,$dbUsername,$dbPassword,$dbName);

foreach ($_POST as $post){

    $resultArray = array();

    $int = intval($post);

    //CAR ITSELF

    $sql = "SELECT * FROM cars_for_sale WHERE car_id=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $int);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();
    $resultArray["car"] = $car;

    //PICTURES

    $sql2 = "SELECT * FROM pictures WHERE car_id=$int";
    $pictures = array();

    $query = mysqli_query($connection,$sql2);
    while ($picture = mysqli_fetch_assoc($query)){
        array_push($pictures,$picture);
    }


    $resultArray["pictures"] = $pictures;

    echo json_encode($resultArray);

}
