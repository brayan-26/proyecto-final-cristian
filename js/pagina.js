const slider = document.getElementById("slider");
const images = document.querySelectorAll(".img");
let contador = 1;
const intervalo = 2000;

setInterval(function () {
    let porcentaje = (contador % images.length) * - 25;
    slider.style.transform = "translateX(" + porcentaje + "%)";
    contador++;
}, intervalo);
