<?php

class Instrument
{
    private int $id;
    private string $intitule;

    /**
     * Instrument constructor.
     * @param int $id
     * @param string $unIntitule
     */
    public function __construct(int $id, string $unIntitule)
    {
        $this->id = $id;
        $this->intitule = $unIntitule;
    }

    /**
     * retourne le libellé de l'instrument
     * @return string
     */
    public function getIntitule() : string
    {
        return $this->intitule;
    }
}

