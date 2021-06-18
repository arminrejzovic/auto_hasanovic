<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
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

    $messages = array();
    $sql = "SELECT * FROM messages;";
    $exe = mysqli_query($connection,$sql);

    while ($message = mysqli_fetch_assoc($exe)){
        array_push($messages,$message);
    }

    ?>

    <!doctype html>
    <html lang="bs">
    <head>
        <meta charset="UTF-8">
        <title>Auto Hasanović | Admin</title>
        <link href="dashboard-style.css" type="text/css" rel="stylesheet">
        <link rel="icon" href="./images/logo.jpg">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="dashboard.js"></script>
    </head>
    <body>


    <header>
        <img src="images/logo.jpg" alt="logo">
        <?php echo "<h1> Dobrodošao nazad, ".$_SESSION['username']."</h1>" ?>
    </header>

    <h1 class="titlebar">Dodaj novi oglas</h1>

    <div id="insert">
        <form action="upload-car.php" method="post" enctype="multipart/form-data">

            <div id="first-half">
                <label for="name">Ime Automobila/Oglasa</label>
                <input required type="text" name="name" id="name">
                <label for="description">Opis</label>
                <textarea name="description" id="description"></textarea>
                <label for="manufacturer">Proizvođač</label>
                <input required type="text" name="manufacturer" id="manufacturer">
                <label for="model">Model</label>
                <input required name="model" id="model" type="text">
                <label for="mileage">Kilometraža</label>
                <input required id="mileage" name="mileage" type="number" min="1" max="500000">
                <label for="horsepower">Snaga Motora (KS)</label>
                <input required type="number" name="horsepower" id="horsepower" min="0" max="500">
                <label for="built">Godište</label>
                <input required type="number" name="built" id="built" min="1900" max="2030" value="2000">
            </div>

            <div id="second-half">
                <label for="enginecc">Zapremina motora</label>
                <input required type="number" name="enginecc" id="enginecc" step="0.1" min="0">
                <label for="fueltype">Vrsta Goriva</label>
                <input required type="text" name="fueltype" id="fueltype">
                <label for="transmission">Transmisija</label>
                <input required type="text" name="transmission" id="transmission">
                <label for="doors">Broj Vrata</label>
                <input required type="number" name="doors" id="doors" min="2" max="10">
                <label for="emissions">Emisioni Standard</label>
                <input required type="text" name="emissions" id="emissions">
                <label for="color">Boja</label>
                <input required type="text" name="color" id="color">

                <label for="price">Cijena (za 'Po Dogovoru' unesite 0)</label>
                <input required type="number" name="price" id="price" min="0" max="250000">

                <label for="pictures">Slike:</label>
                <input type="file" name="files[]" multiple/>

                <input type="submit" value="Objavi" name="submit" id="submit">
            </div>
        </form>
    </div>

    <h1 class="titlebar">Aktivni Oglasi</h1>

    <div id="delete">
        <table>
            <tr>
                <th>Car ID</th>
                <th>Ime</th>
                <th>Cijena</th>
                <th>Poništi</th>
            </tr>
        <?php

        foreach ($CarsList as $car){
            echo "<tr>";
            echo "<td class='carID'>".$car["car_id"]."</td>";
            echo "<td class='name'>".$car["name"]."</td>";
            if($car["price"]!=0) echo "<td class='price'>".$car["price"]."</td>";
            else echo "<td class='price'>Po Dogovoru</td>";
            echo "<td class='delete' onclick=deleteCar(this)><button>DELETE</button></td>";
            echo "</tr>";
        }
        ?>
        </table>

        <script>
            function deleteCar(button) {
                let parent = button.parentNode;
                let n = parent.getElementsByClassName("carID");
                let carID = parseInt(n[0].textContent);

                console.log(carID);

                const xhr = new XMLHttpRequest();

                xhr.open("POST","delete-car.php");
                xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                xhr.send(`carID=${carID}`);

                xhr.onreadystatechange = function () {
                    if(this.readyState == 4 && this.status == 200){
                        alert(this.responseText);
                        location.reload();
                    }
                };

            }
        </script>
    </div>

    <h1 class="titlebar">Poruke</h1>

    <div id="messages">
        <table>
            <tr>
                <th>Message ID</th>
                <th>Ime</th>
                <th>Email</th>
                <th>Svrha</th>
                <th>Poruka</th>
            </tr>
            <?php

            foreach ($messages as $m){
                echo "<tr>";
                echo "<td class='messageID'>".$m["message_id"]."</td>";
                echo "<td class='name'>".$m["name"]."</td>";
                echo "<td class='email'>".$m["email"];
                echo "<td class='subject'>".$m["subject"];
                echo "<td class='message'>".$m["message"];
                echo "</tr>";
            }
            ?>
        </table>

    </div>

    </body>
    </html>



<?php }
else {
    echo "Niste registrovani";
}

