<?php
// chargement des ressources
require $_SERVER['DOCUMENT_ROOT'] .  "/include/autoload.php";

// Création du jeton d'accès
Jeton::creer();


// chargement de l'interface
$titre = "Consulter les cours d'une journée";
$musicol = new Musicol(new Select());
$data = json_encode($musicol->getLesJours());

$head = <<<EOD
    <script>
        let data = $data;
    </script>

EOD;


// chargement de l'interface
require RACINE . "/include/interface.php";