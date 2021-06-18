<?php

$dbServerName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "cars_test";
$connect = mysqli_connect($dbServerName,$dbUsername,$dbPassword,$dbName);

$name = $_POST["name"];
$description = $_POST["description"];
$price = $_POST["price"];
$manufacturer = $_POST["manufacturer"];
$model = $_POST["model"];
$mileage = $_POST["mileage"];
$horsepower = $_POST["horsepower"];
$built = $_POST["built"];
$enginecc = $_POST["enginecc"];
$fuel = $_POST["fueltype"];
$transmission = $_POST["transmission"];
$doors = $_POST["doors"];
$emissions = $_POST["emissions"];
$color = $_POST["color"];
$picture = "placeholder";

$sql = "INSERT INTO `cars_for_sale` (`car_id`, `name`, `description`, `price`, `manufacturer`, `model`, `mileage`, 
       `horsepower`, `built`, `engine_cc`, `fuel_type`, `transmission`, `number_of_doors`, `emission_standard`, `color`,
       `picture`) VALUES (NULL, '$name', '$description', '$price', '$manufacturer', '$model', '$mileage', '$horsepower', 
       '$built', '$enginecc','$fuel', '$transmission', '$doors', '$emissions', '$color', '$picture');";

$stmt = $connect->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

echo "SUCCESSFULLY UPLOADED CAR";

$sql = "SELECT car_id FROM cars_for_sale ORDER BY car_id DESC LIMIT 1";
$stmt = $connect->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$carID = $result->fetch_assoc();


$id = $carID["car_id"];

extract($_POST);
$error=array();
$extension=array("jpeg","jpg","png","gif");

$carindex = 0;

foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name) {
    $file_name=$_FILES["files"]["name"][$key];
    $file_tmp=$_FILES["files"]["tmp_name"][$key];
    $ext=pathinfo($file_name,PATHINFO_EXTENSION);

    if(in_array($ext,$extension)) {
        if(!file_exists("uploads/".$file_name)) {
            move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"./images/".$file_name);
            $insert = "INSERT INTO `pictures`(`id`, `path`, `car_id`) VALUES (NULL,'$file_name','$id');";
            $statement = $connect->prepare($insert);
            $statement->execute();
            $result = $statement->get_result();

            if($carindex==0){
                $temp = "./images/".$file_name;

                $update = "UPDATE cars_for_sale SET picture = '$temp' WHERE car_id = '$id';";
                $carindex++;
                $statement = $connect->prepare($update);
                $statement->execute();
                $result = $statement->get_result();
                echo $result;
            }
        }
        else {
            $filename=basename($file_name,$ext);
            $newFileName=$filename.time().".".$ext;
            move_uploaded_file($file_tmp=$_FILES["files"]["tmp_name"][$key],"./images/".$newFileName);
            $sql = "INSERT INTO `pictures`(`id`, `path`, `car_id`) VALUES (NULL,'$newFileName','$id');";
            $stmt = $connect->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if($carindex==0){
                $temp = "./images/".$newFileName;

                $update = "UPDATE cars_for_sale SET picture = '$temp' WHERE car_id = '$id';";
                $carindex++;
                $statement = $connect->prepare($update);
                $statement->execute();
                $result = $statement->get_result();
                echo $result;
            }

        }
    }
    else {
        array_push($error,"$file_name, ");
    }

    exit();
}







