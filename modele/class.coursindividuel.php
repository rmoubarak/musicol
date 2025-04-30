<?php
class CoursIndividuel extends Cours{

    private Instrument $instrument;

    /**
     * CoursIndividuel constructor.
     * @param int $id
     * @param int $ageMini
     * @param Instrument $instrument
     */

    public function __construct(int $id, int $ageMini, Instrument $instrument)
    {
        parent::__construct($id, $ageMini);
        $this->instrument = $instrument;
    }

    /**
     * Retourne l'objet Instrument
     * @return Instrument
     */

    public function getInstrument() : Instrument {
        return $this->instrument ;
    }

    /**
     * Retourne le libellé du cours qui correspond au libellé de l'instrument
     * @return string
     */
    public function getLibelle() :  string {
        return $this->instrument->getIntitule();
    }
}