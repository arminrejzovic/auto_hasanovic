let ajax = new XMLHttpRequest();
let method = "GET";
let url = "cars.php";
let async = true;

ajax.open(method,url,async);
ajax.send();


ajax.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200){
        let cars = JSON.parse(this.responseText);

        loadcars(cars);
    }
};


function loadcars(cars) {
    document.getElementById("main").innerHTML = `
    ${cars.map(function (car) {
      return `
      <div class="card">
        <img class="card-image" src="${car.picture}" alt="car">
        <div class="card-description">
            <h2 class="name">${car.name}</h2>
            <p class="mileage">${car.mileage + " km"}</p>
            <p class="year">${car.built}. godište</p>
            <h3 class="price">${car.price==0 ? "Po Dogovoru" : car.price + " KM"}</h3>
            <button onclick=openCar(this)>Saznaj Više</button>
            <p class="hidden" style="visibility: hidden">${car.car_id}</p>
        </div>
    </div>
      `  
    })}
    <p class="results">${cars.length} od ${cars.length} rezultata</p>
    `
}


function openCar(button) {
    let parent = button.parentNode;
    let n = parent.getElementsByClassName("hidden");
    window.open("Auto.html#"+n[0].textContent,"_self");
}
