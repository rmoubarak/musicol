"use strict";

/* global data */

// alimentation de la balise <span id='annee'>
let dateJour = new Date();
document.getElementById('annee').innerText = dateJour.getFullYear();

// affichage des tarifs
let lesLignes = document.getElementById('lesLignes');
for (let ligne of data) {
    let tr = lesLignes.insertRow();
    tr.style.textAlign = "center";
    tr.insertCell().innerText = ligne.libelle;
    tr.insertCell().innerText = ligne['Cours individuel'];
    tr.insertCell().innerText = ligne['Cours collectif'];
}
