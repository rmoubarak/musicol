<?php

class Passerelle
{
    /*
     * La classe Passerelle est responsable de la création des objets métier à partir des données de la base de données.
     * Elle associe les données d’une table à des propriétés d’objets (et parfois même à des objets imbriqués, comme dans le cas des Cours liés à Instrument, ou des Tranches contenant des tarifs).
     * Elle centralise la logique d’accès et de construction d’objets
     * Elle joue donc le rôle d'un ORM (Object Relational Mapping) minimaliste
     */

    // instance d'un objet de la classe Select assurant l'exécution des requêtes SQL de récupération des données
    private Select $select;

    /**
     * Constructeur de la classe Passerelle.
     * Initialise la connexion à la base de données via un objet Select.
     *
     * @param Select $select
     */
    public function __construct(Select $select)
    {
        $this->select = $select;
    }

    /**
     * Parcourt la table typeCours pour générer les objets TypeCours
     * Retourne les types de cours dans un tableau associatif
     *     clé = identifiant du type de cours
     *     valeur = objet de la classe TypeCours
     * @return array<int, TypeCours> Tableau associatif : id => TypeCours
     */
    public function getLesTypesCours(): array
    {
        $lesLignes = $this->select->getRows("select id, libelle, prixExterieur from typeCours");
        $lesTypesCours = [];
        foreach ($lesLignes as ['id' => $id, 'libelle' => $libelle, 'prixExterieur' => $prixExterieur]) {
            $lesTypesCours[$id] = new TypeCours($id, $libelle, $prixExterieur);
        }
        return $lesTypesCours;
    }

    /**
     * Parcourt la table tranche et de la table Tarif afin de générer les objets Tranche
     * Retourne les objets Tranche dans un tableau associatif
     *     clé = identifiant de la tranche
     *     valeur = objet de la classe Tranche
     * @return array<int, Tranche>
     * Chaque Tranche contient en interne un tableau de tarifs indexés par idTypeCours
 */
    public function getLesTranches(): array
    {
        // lecture de la table tranche pour créer les objets Tranches
        $sql = <<<EOD
           Select id, quotientMin, libelle 
           from tranche;
EOD;
        // Exécution de la requête SQL pour récupérer les lignes
        $lesLignes = $this->select->getRows($sql);

        // Création des objets Tranche stockés dans un tableau associatif $lesTranches
        $lesTranches = [];
        foreach ($lesLignes as ['id' => $id, 'libelle' => $libelle, 'quotientMin' => $quotientMin]) {
            $lesTranches[$id] = new Tranche($id, $libelle, $quotientMin);
        }

        // lecture de la table tarif pour ajouter les tarifs dans les objets Tranche
        $sql = <<<EOD
            Select idTypeCours, idTranche, montant 
            from tarif;
EOD;
        // Exécution de la requête SQL pour récupérer les lignes
        $lesLignes = $this->select->getRows($sql);

        // parcourir les tarifs pour les ajouter dans les objets Tranche
        foreach ($lesLignes as ['idTypeCours' => $idTypeCours, 'idTranche' => $idTranche, 'montant' => $montant]) {
            $lesTranches[$idTranche]->ajouterTarif($idTypeCours, $montant);
        }
        return $lesTranches;
    }

    /**
     * Génération d'un tableau associatif contenant des objets Instrument, la clé du tableau est l'id de l'instrument
     * @return array
     */
    public function getLesInstruments(): array {
        // création des objets Instrument à partir de la table instrument
        $sql = <<<EOD
            Select id, intitule
            from instrument;
EOD;
        // Exécution de la requête SQL pour récupérer les lignes
        $lesLignes = $this->select->getRows($sql);
        // création des objets Instrument
        $lesInstruments = [];
        foreach ($lesLignes as ['id' => $id, 'intitule' => $intitule]) {
            $lesInstruments[$id] = new Instrument($id, $intitule);
        }
        return $lesInstruments;
    }


    /**
     * Génération d'un tableau associatif contenant des objets Cours, la clé du tableau est l'id du cours
     * @return array
     */
    public function getLesCours(): array
    {
        // Récupération des objets Instrument
        $lesInstruments = $this->getLesInstruments();

        // création des objets Cours à partir de la table Cours
        $sql = <<<EOD
         Select id, libelle,ageMini, ageMaxi, nbPlaces, idInstrument, idTypeCours 
          from Cours;
EOD;
        // Exécution de la requête SQL pour récupérer les lignes
        $lesLignes = $this->select->getRows($sql);

        // création des Objets CoursCollectif et CoursIndividuel
        $lesCours = [];
        foreach ($lesLignes as ['id' => $id,
                 'libelle' => $libelle,
                 'ageMini' => $ageMini,
                 'ageMaxi' => $ageMaxi,
                 'nbPlaces' => $nbPlaceMaxi,
                 'idInstrument' => $idInstrument,
                 'idTypeCours' => $idTypeCours]) {
            // Cours individuel ?
            if ($idTypeCours == 1) {
                $lesCours[$id] = new CoursIndividuel($id, $ageMini, $lesInstruments[$idInstrument]);
            } else {
                $lesCours[$id] = new CoursCollectif($id, $ageMini, $libelle, $ageMaxi, $nbPlaceMaxi);
            }
        }

        return $lesCours;
    }

    /**
     * Génération d'un tableau associatif contenant des objets Jour, la clé du tableau est l'id du jour
     * un objet Jour contient un tableau d'objets Cours
     *
     * @return array
     */
    public function getLePlanning(): array
    {
        // tableaux associatifs intermédiaires stockant les objets Jour, Instrument et Cours nécessaire pour la constitution de l'objet Planning
        // la clé correspond à l'id de l'objet

        // Alimentation initiale du planning par des objets Jour
// création d'un tableau associatif contenant les jours de la semaine
        // la clé est l'id du jour et la valeur est un objet de la classe Jour

        $sql = <<<EOD
            Select id, libelle 
            from jour
            order by id;
EOD;
        // Exécution de la requête SQL pour récupérer les lignes
        $lesLignes = $this->select->getRows($sql);

        // création des objets Jour
        $lePlanning = [];
        foreach ($lesLignes as ['id' => $id, 'libelle' => $libelle]) {
            $lePlanning[$id] = new Jour($id, $libelle);
        }

        // Récupération des objets Cours
        $lesCours = $this->getLesCours();

        // Ajout des séances de chaque cours par lecture de la table planning

        $sql = <<<EOD
            Select idCours, idJour 
            from Planning;
EOD;

        // Exécution de la requête SQL pour récupérer les lignes
        $lesLignes = $this->select->getRows($sql);

        foreach ($lesLignes as ['idCours' => $idCours, 'idJour' => $idJour]) {
            // récupération de l'objet Cours correspondant
            $cours = $lesCours[$idCours];
            // récupération de l'objet Jour correspondant
            $jour = $lePlanning[$idJour];

            // ajout de l'objet Jour dans l'objet Cours qui entraine l'ajout de l'objet Cours dans l'objet Jour (relation bidirectionnelle)
            $cours->ajouterJour($jour);

        }
        return $lePlanning;
    }
}

