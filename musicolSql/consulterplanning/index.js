"use strict";

/* global data */

// récupération de la zone affichant les cours
let lesLignes = document.getElementById('lesLignes');

// alimentation de la balise <span id='annee'>
let dateJour = new Date();
document.getElementById('annee').innerText = dateJour.getFullYear();

// affichage des cours

