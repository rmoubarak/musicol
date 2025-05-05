"use strict";

import {
    afficherErreur,
    afficherErreurSaisie,
} from 'https://verghote.github.io/composant/fonction.min.js';

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
async function afficherLesCours(id) {
    const formData = new FormData();
    formData.append("idJour", id);
    try {
        const response = await fetch("ajax/getlescours.php", {
            method: "POST",
            body: formData
        });
        if (!response.ok) {
            throw new Error("Erreur HTTP : " + response.status);
        }
        const data = await response.json();
        if (data.error) {
            for (const key in data.error) {
                const message = data.error[key];
                if (key === 'system') {
                    afficherErreur('Une erreur inattendue est survenue');
                } else if (key === 'global') {
                    afficherErreur(message);
                } else {
                    afficherErreurSaisie(key, message);
                }
            }
        } else {
            lesLignes.innerHTML = "";
            for (let cours of data) {
                lesLignes.insertRow().insertCell().innerText = cours.libelle;
            }
        }
    } catch (error) {
        afficherErreur('Une erreur imprévue est survenue');
        console.error("Détail de l'erreur :", error);
    }
}
