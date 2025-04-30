<?php
// chargement des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// chargement des données
$titre = "Les tarifs";

// chargement des objets Tranche et TypeCours
$musicol = new Passerelle(new Select());
$lesTranches = $musicol->getLesTranches();
$lesTypesCours = $musicol->getLesTypesCours();

// génération du tableau contenant les tarifs : éléments composés de 3 propriétés : 1 pour la tranche 'libelle' + 1 par type de cours  'le libellé du type de cours'
// Pour la première ligne (0) les données viennent des objets typeCours et la tranche est 'EXT'
// La première cellule de la première ligne (indice 0) contient une valeur fixe : EXT
$ligne['libelle'] = "EXT";

// les 2 autres cellules de cette première ligne contiennent les prix extérieurs de chaque type de cours
// Remplissage des prix extérieurs pour chaque type de cours
foreach($lesTypesCours as $unTypeCours) {
    $typeCoursLibelle = $unTypeCours->getLibelle();
    $prixExterieur = $unTypeCours->getPrixExterieur();
    $ligne[$typeCoursLibelle] = $prixExterieur;
}

$lesLignes[] = $ligne;

// pour les autres lignes (1 à n) la première cellule est alimentée par le libellé de l'objet tranche
// les 2 autres cellules doivent contenir le montant des tarifs de la tranche
foreach($lesTranches as $uneTranche) {
    $ligne['libelle'] = $uneTranche->getLibelle();
    // parcours des tarifs de la tranche stockés dans un tableau associatif clé : id du type de cours, valeur : tarif
    foreach ($uneTranche->getLesTarifs() as $idTypeCours => $unMontant) {
        $ligne[$lesTypesCours[$idTypeCours]->getLibelle()] = $unMontant;
    }
    $lesLignes[] = $ligne;
}

// Utilisation d’options JSON_UNESCAPED_UNICODE et JSON_UNESCAPED_SLASHES pour générer un JSON plus propre à injecter côté client
// sans double échappement ou caractères Unicode encodés (é devient é et non \u00e9).
$data = json_encode($lesLignes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

$head = <<<EOD
<script>
    let data = $data;
</script>
EOD;

// chargement de l'interface
require RACINE . "/include/interface.php";