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
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous">
    </script>
EOD;


// chargement de l'interface
require RACINE . "/include/interface.php";