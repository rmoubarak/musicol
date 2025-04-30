<?php

class CoursCollectif extends Cours
{
    private string $libelle;
    private ?int $ageMaxi; // l'age Maxi n'est pas obligatoire
    private int $nbPlacesMaxi;

    /**
     * CoursCollectif constructor.
     * @param int $id
     * @param int $ageMini
     * @param string $libelle
     * @param ?int $ageMaxi
     * @param int $nbPlacesMaxi
     */
    public function __construct(int $id, int $ageMini, string $libelle, ?int $ageMaxi, int $nbPlacesMaxi)
    {
        parent::__construct($id, $ageMini);
        $this->libelle = $libelle;
        $this->ageMaxi = $ageMaxi;
        $this->nbPlacesMaxi = $nbPlacesMaxi;
    }

    /**
     * retourne le libelle du cours
     * @return string
     */
    public function getLibelle() : string
    {
        return $this->libelle;
    }

    /**
     * Retourne l'âge maximum pour participer au cours.
     *
     * @return int|null
     */
    public function getAgeMaxi(): ?int
    {
        return $this->ageMaxi;
    }

    /**
     * retourne le nombre de places de ce cours
     * @return int
     */
    public function getNbPlacesMaxi() : int
    {
        return $this->nbPlacesMaxi;
    }
}
