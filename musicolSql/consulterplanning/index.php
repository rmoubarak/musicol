<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/autoload.php';

// Récupération pour chaque cours planifié du libellé du jour et du libellé du cours
// Le libellé du cours correspond soit à celui du cours pour un cours collectif, soit à l'intitulé de l'instrument pour un cours individuel (idTypeCours = 1)

// chargement des données
$titre = "Planning des cours";

// Instancier la classe Musicol

// Récupérer le planning dans le format json

// Transmisssion des données à l'interface
$head = <<<EOD
<script>
   
</script>
EOD;

// chargement de l'interface
require RACINE . "/include/interface.php";


