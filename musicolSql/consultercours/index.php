<?php
// chargement des ressources
require $_SERVER['DOCUMENT_ROOT'] .  "/include/autoload.php";

Jeton::creer();

// chargement de l'interface
$titre = "Consulter les cours d'une journée";

// Instancier la classe Musicol

// Récupérer les jours dans le format json


// Transmisssion des données à l'interface
$head = <<<EOD
<script>
   
</script>
EOD;

// chargement des composants spécifiques
$head .= file_get_contents("https://verghote.github.io/composant/jquery.html");

// chargement de l'interface
require RACINE . "/include/interface.php";