<?php
// chargement des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";


// chargement des données

$titre = "Les tarifs";
// Instancier la classe Musicol

// Récupérer les tarifs


// Transmisssion des données à l'interface
$head = <<<EOD
<script>

</script>
EOD;

// chargement de l'interface
require RACINE . "/include/interface.php";