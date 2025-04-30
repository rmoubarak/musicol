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

$head = <<<EOD
<script>
    let lePlanning = $lePlanning;
</script>
EOD;

// chargement de l'interface
require RACINE . "/include/interface.php";