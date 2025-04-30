"use strict";
/* global lePlanning */

// récupération de la zone de liste
let idJour = document.getElementById('idJour');
// récupération de la zone affichant les cours
let lesLignes = document.getElementById('lesLignes');


// Alimentation de la zone de liste des jours
// Utilisation de Object.values pour obtenir un tableau des valeurs de l'objet lePlanning
for (let jour of Object.values(lePlanning)) {
    idJour.add(new Option(jour.libelle, jour.id));
}

// affichage des cours du premier jour
afficherLesCours(1);

// gestion de l'événement change sur la zone de liste
idJour.onchange = function() {
    afficherLesCours(idJour.value);
};

/*
 Afficher les cours du jour sélectionné
 */
function afficherLesCours(idJour) {
    // effacer les cours précédents
    lesLignes.innerHTML = '';
    for (let cours of lePlanning[idJour].lesCours) {
        lesLignes.insertRow().insertCell().innerText = cours.libelle;
    }
}
