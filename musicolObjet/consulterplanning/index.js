"use strict";

/* global data */

// Récupération de la balise <table id='lesLignes'>
let lesLignes = document.getElementById('lesLignes');

// alimentation de la balise <span id='annee'>
let dateJour = new Date();
document.getElementById('annee').innerText = dateJour.getFullYear();

for (const element of data) {
    let tr = lesLignes.insertRow();
    tr.insertCell().innerText = element.jour;
    tr.insertCell().innerText = element.lesCours;
}
