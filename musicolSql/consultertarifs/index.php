<?php
// chargement des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";


// chargement des données
$titre = "Les tarifs";
$musicol = new Musicol(new Select());
$data = json_encode($musicol->getlesTarifs());

$head = <<<EOD
<script>
    let data = $data;
</script>
EOD;

// chargement de l'interface
require RACINE . "/include/interface.php";