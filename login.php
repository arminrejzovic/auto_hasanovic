<?php

    $username = $_POST["admin"];
    $password = $_POST["password"];

    $dbServerName = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "cars_test";
    $connect = mysqli_connect($dbServerName,$dbUsername,$dbPassword,$dbName);

    if(!$connect){
        die("Neuspješno spajanje sa bazom podataka: ".mysqli_connect_error());
    }

    if(empty($username)||empty($password)){
        header("Location: ./index.html#empty");
        exit();
    }

    if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        header("Location: ./index.html#invalidusername");
        exit();
    }

    $sql = "SELECT * FROM administrators WHERE username = ?;";
    $statement = mysqli_stmt_init($connect);

    if(!mysqli_stmt_prepare($statement,$sql)){
        header("Location: ./index.html#statementfailed");
        exit();
    }

    mysqli_stmt_bind_param($statement,"s",$username);
    mysqli_stmt_execute($statement);
    $data = mysqli_stmt_get_result($statement);

    if($row = mysqli_fetch_assoc($data)){

        if(password_verify($password,$row["password"])){
            header("Location: ./dashboard.php#admin");
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            exit();
        }
        else{
            header("Location: ./index.html#wrongpass");
            exit();
        }

    }
    /*
    else{
        $sql = "INSERT INTO administrators(username,password) VALUES (?,?);";
        $statement = mysqli_stmt_init($connect);

        if(!mysqli_stmt_prepare($statement,$sql)){
            header("Location: ./index.html#statementfailed");
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($statement,"ss",$username,$hashedPassword);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close($statement);
        header("Location: ./index.html#addedUser");
        exit();
    }*/