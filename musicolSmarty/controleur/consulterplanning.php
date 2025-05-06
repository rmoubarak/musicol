<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/autoload.php';

// Récupération pour chaque cours planifié du libellé du jour et du libellé du cours
// Le libellé du cours correspond soit à celui du cours pour un cours collectif, soit à l'intitulé de l'instrument pour un cours individuel (idTypeCours = 1)

// chargement des données
$titre = "Planning des cours";
// récupération de l'objet planning
$musicol = new Passerelle(new Select());
$lePlanning = $musicol->getLePlanning();

// Construction du tableau des lignes à envoyer au client
$lesLignes = [];
foreach ($lePlanning as $jour) {
    // Récupération de tous les libellés des cours du jour courant
    $lesCours = [];
    foreach ($jour->getLesCours() as $cours) {
        $lesCours[] = $cours->getLibelle();
    }
    // Concaténation propre avec implode (plus élégant que substr)
    $ligne = [
        'jour' => $jour->getLibelle(),
        'lesCours' => implode(', ', $lesCours)
    ];
    $lesLignes[] = $ligne;
}

// préparation de la vue en lui transmettant les paramètres attendus : l'année et un tableau contenant les lignes à afficher
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Smarty\Smarty;
$vue = new Smarty();
$vue->assign('annee', date(('Y')));
$vue->assign('lePlanning', $lesLignes);
$vue->display('../vue/leplanning.tpl');



