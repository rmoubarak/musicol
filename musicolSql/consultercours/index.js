"use strict";

import {
    afficherErreur,
    afficherErreurSaisie
} from 'https://verghote.github.io/composant/fonction.js';

/* global data */

// récupération de la zone de liste
let idJour = document.getElementById('idJour');
// récupération de la zone affichant les cours
let lesLignes = document.getElementById('lesLignes');

// Alimentation de la zone de liste des jours
for (let jour of data) {
    idJour.add(new Option(jour.libelle, jour.id));
}

// affichage des cours du premier jour
afficherLesCours(idJour.value);

// gestion de l'événement click sur la zone de liste
idJour.onchange = () => afficherLesCours(idJour.value);

/*
 afficher les cours du jour sélectionné
 */
function afficherLesCours(id) {
    $.ajax({
        url: "ajax/getlescours.php",
        method: 'post',
        data: {idJour: id},
        dataType: "json",
        success: (data) => {
            if (data.error) {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        afficherErreur('Une erreur inattendue est survenue');
                    } else if (key === 'global') {
                        afficherErreur(message);
                    } else  {
                        afficherErreurSaisie(key, message );
                    }
                }
            } else {
                lesLignes.innerHTML = "";
                for (let cours of data) {
                    lesLignes.insertRow().insertCell().innerText = cours.libelle;
                }
            }
        },
        error: reponse => {
            afficherErreur('Une erreur imprévue est survenue');
            console.log(reponse.responseText);
        }
    });
}
