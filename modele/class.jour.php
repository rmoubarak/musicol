<?php
class Jour implements JsonSerializable {

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'libelle' => $this->getLibelle(),
            'lesCours' => $this->getLesCours()
        ];
    }

    protected int $id;
    protected string $libelle;
    protected array $lesCours;

    /**
     * Constructeur
     * @param int $id
     * @param string $libelle
     */
    public function __construct(int $id, string $libelle)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->lesCours = [];
    }

    /**
     * Accesseur sur l'id du jour
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Accesseur sur le libellé du jour
     * @return string
     */
    public function getLibelle() : string
    {
        return $this->libelle;
    }

    /**
     * Accesseur sur le tableau des cours
     * @return array
     */
    public function getLesCours(): array
    {
        return $this->lesCours;
    }

    /**
     * Renvoie vrai si le cours a lieu le jour passé en paramètre
     * @param $cours Cours
     * @return bool
     */
    public function ajouterCours(Cours $cours): void
    {
            $this->lesCours[] = $cours;
    }

    /**
     * Supprime l'objet Cours passé en paramètre dans le tableau lesCours
     * @param $cours Cours
     */
    public function supprimerCours(Cours $cours): void
    {
        //  récupération de l'indice de l'objet dans le tableau
        $indice = array_search($cours, $this->lesCours);
        if ($indice !== false) {
            // Suppression de l'objet dans le tableau
            unset($this->lesCours[$indice]);
        }
    }
}
