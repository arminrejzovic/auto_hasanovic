let carLink = window.location.hash.substring(1);

let carID = parseInt(carLink);

/*let ajax = new XMLHttpRequest();
let method = "GET";
let url = "cars.php";
let async = true;

ajax.open(method,url,async);
ajax.send();


ajax.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200){
        let cars = JSON.parse(this.responseText);
        displayCar(cars[carID-1]);
    }
};*/


const xhr = new XMLHttpRequest();

xhr.open("POST","car.php");
xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xhr.send(`carID=${carID}`);

xhr.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200){
        let car = JSON.parse(this.responseText);
        displayCar(car.car);
        createGallery(car.pictures);
    }
};


function displayCar(car) {
    document.getElementById("name").textContent = car.name;

    if(car.price !=0){
        document.getElementById("price").textContent = car.price + " KM";
    }
    else document.getElementById("price").textContent = "Po dogovoru";

    document.getElementById("manufacturer").textContent = car.manufacturer;
    document.getElementById("model").textContent = car.model;
    document.getElementById("mileage").textContent = car.mileage + " km"
    document.getElementById("year-built").textContent = car.built + ".";
    document.getElementById("horsepower").textContent = car.horsepower + " KS/" + (car.horsepower/1.341).toFixed(0) + " KW";
    document.getElementById("volume").textContent = car.engine_cc;
    document.getElementById("fuel").textContent = car.fuel_type;
    document.getElementById("transmission").textContent = car.transmission;
    document.getElementById("doors").textContent = car.number_of_doors;
    document.getElementById("emission").textContent = car.emission_standard;
    document.getElementById("color").textContent = car.color;
    document.getElementById("description").textContent = car.description;
}


function createGallery (pictures){
    console.log(pictures);
    var currentIndex = 0;
    document.getElementById("pictures").style.background = `url(./images/${pictures[0].path}) no-repeat`;
    document.getElementById("pictures").style.backgroundSize= "contain";
    document.getElementById("pictures").style.backgroundPosition= "center";

    document.getElementById("left-nav").onclick = function () {

        if(currentIndex>0){
            document.getElementById("pictures").style.background = `url(./images/${pictures[currentIndex-1].path}) no-repeat`;
            document.getElementById("pictures").style.backgroundSize= "contain";
            document.getElementById("pictures").style.backgroundPosition= "center";
            currentIndex--;
        }
    }

    document.getElementById("right-nav").onclick = function () {
        if(currentIndex<pictures.length){
            document.getElementById("pictures").style.background = `url(./images/${pictures[currentIndex+1].path}) no-repeat`;
            document.getElementById("pictures").style.backgroundSize= "contain";
            document.getElementById("pictures").style.backgroundPosition= "center";
            currentIndex++
        }
    }
}
