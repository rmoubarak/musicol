<?php
// chargement des ressources
require $_SERVER['DOCUMENT_ROOT'] . '/include/autoload.php';

// contrôle d'accès
Jeton::verifier();

// Vérification des paramètres attendus
if (!isset($_POST['idJour'])) {
   Erreur::envoyerReponse("Paramètres manquant", "global");
}

// récupération des paramètres
$idJour = $_POST['idJour'];

// Contrôle de la validité de l'id
if (!is_numeric($idJour)) {
   Erreur::envoyerReponse("L'id du jour doit être un entier", "global");
}
// compris entre 1 et 6
if ($idJour < 1 || $idJour > 6) {
   Erreur::envoyerReponse("L'id du jour doit être compris entre 1 et 6", "global");
}

$musicol = new Musicol(new Select());
echo json_encode($musicol->getLesCours($idJour));

