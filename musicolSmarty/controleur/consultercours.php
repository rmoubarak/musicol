<?php
// chargement des ressources
require $_SERVER['DOCUMENT_ROOT'] .  "/include/autoload.php";

// chargement de l'interface
$titre = "Consulter les cours d'une journée";

// récupération du planning dans un tableau associatif dont la clé est l'id du jour
// Ce tableau contient des objets 'Jour'
// Chaque objet Jour contient un id, un libellé et un tableau à index numérique contenant les objets Cours
$musicol = new Passerelle(new Select());
$lePlanning = json_encode($musicol->getLePlanning());
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Smarty\Smarty;
$vue = new Smarty();
$vue->assign('lePlanning', $lePlanning);
$vue->display('../vue/lescours.tpl');$vue->display('../vue/lescours.tpl');


