<?php
// chargement des ressources
require $_SERVER['DOCUMENT_ROOT'] .  "/include/autoload.php";

// Création du jeton d'accès
// Jeton::creer();

Erreur::bloquerVisiteur();

// chargement de l'interface
$titre = "Consulter les cours d'une journée";
$musicol = new Musicol(new Select());
$data = json_encode($musicol->getLesJours());

$head = <<<EOD
<script>
    let data = $data;
</script>
EOD;

// chargement des composants spécifiques
$head .= file_get_contents("https://verghote.github.io/composant/jquery.html");

// chargement de l'interface
require RACINE . "/include/interface.php";