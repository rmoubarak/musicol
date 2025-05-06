"use strict";

/* global data */

// Récupération de la zone affichant les tarifs
let lesLignes = document.getElementById('lesLignes');

// alimentation de la balise <span id='annee'>
let dateJour = new Date();
document.getElementById('annee').innerText = dateJour.getFullYear();

// affichage des tarifs
for (let ligne of data) {
    let tr = lesLignes.insertRow();
    tr.style.textAlign = "center";
    tr.insertCell().innerText = ligne.libelle;
    tr.insertCell().innerText = ligne['Cours individuel'];
    tr.insertCell().innerText = ligne['Cours collectif'];
}
