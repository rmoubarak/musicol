"use strict";

/* global data */

// Récupération de la zone affichant les tarifs
let lesLignes = document.getElementById('lesLignes');

// alimentation de la balise <span id='annee'>
let dateJour = new Date();
document.getElementById('annee').innerText = dateJour.getFullYear()

// affichage des tarifs

