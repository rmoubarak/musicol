<?php

class TypeCours
{
    // membres privés
    private int $id;
    private string $libelle;
    private int $prixExterieur;

    /**
     * TypeCours constructor.
     * @param int $id
     * @param string $libelle
     * @param int $unPrixExterieur
     */
    public function __construct(int $id, string $libelle, int $unPrixExterieur)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->prixExterieur = $unPrixExterieur;
    }


    /**
     * retourne l'id du type de cours
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * retourne le prix extérieur pour ce type de cours
     * @return int
     */
    public function getPrixExterieur() : int
    {
        return $this->prixExterieur;
    }

    /**
     * retourne le libelle du type de cours
     * @return string
     */
    public function getLibelle() : string
    {
        return $this->libelle;
    }
}
