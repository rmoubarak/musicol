<?php

class Tranche
{
    private int $id;
    private int $quotientMin;
    private string $libelle;
    private array $lesTarifs;  // Tableau associatif clé : idTypeCours (1 ou 2)  valeur montant //   SortedDictionary<TypeCours, int> lesTarifs;

    /**
     * Tranche constructor.
     * @param int $id
     * @param string $libelle
     * @param int $unQuotientMin
     */
    public function __construct(int $id, string $libelle, int $unQuotientMin)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->quotientMin = $unQuotientMin;
        $this->lesTarifs = [];
    }

    /**
     * retourne l'id de la tranche
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * retourne la borme minimale de la tranche ex:  251
     * @return int
     */
    public function getQuotientMin() : int
    {
        return $this->quotientMin;
    }

    /**
     * retourne le libellé de la tranche ex  : 251 à 424
     * @return string
     */
    public function getLibelle() : string
    {
        return $this->libelle;
    }

    /**
     * retourne le tableau contenant les deux tarifs (cours individuel et cours collectif) pour la tranche
     * @return array
     */
    public function getLesTarifs() : array
    {
        return $this->lesTarifs;
    }

    /**
     * Ajoute un tarif dans le tableau associatif lesTarifs
     * @param int $idTypeCours
     * @param int $montant
     */
    public function ajouterTarif(int $idTypeCours, int $montant) : void
    {
        $this->lesTarifs[$idTypeCours] = $montant;
    }
}

