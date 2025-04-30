<?php

abstract class Cours implements JsonSerializable
{

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'libelle' => $this->getLibelle(),
            'ageMini' => $this->ageMini,
            'lesJours' => fn() => array_map(
                fn($jour) => $jour->jsonSerialize(),
                $this->lesJours
            )
        ];
    }

    protected int $id;
    protected int $ageMini;
    protected array $lesJours;

    // constructeur

    /**
     * Cours constructor.
     * @param int $id
     * @param int $ageMini
     */
    public function __construct(int $id, int $ageMini)
    {
        $this->id = $id;
        $this->ageMini = $ageMini;
        $this->lesJours = [];
    }

    /**
     * Renvoie vrai si le cours a lieu le jour passé en paramètre
     * @param $jour Jour
     * @return bool
     */
    public function aLieuLeJour(Jour $jour) : bool
    {
        return in_array($jour, $this->lesJours);
    }

    /**
     * Ajoute les objets Jour passés en paramètre dans le tableau lesJours
     */
    public function ajouterJour(): void
    {
        $lesArguments = func_get_args();
        foreach ($lesArguments as $jour) {
            $this->lesJours[] = $jour;
            // mise à jour de la liste des cours du jour bidirectionnalité)
            $jour->ajouterCours($this);
        }
    }

    /**
     * Supprime l'objet Jour passé en paramètre dans le tableau lesJours
     * @param $jour Jour
     */
    public function supprimerJour(Jour $jour): void
    {
        //  récupération de l'indice de l'objet dans le tableau
        $indice = array_search($jour, $this->lesJours);
        if ($indice !== false) {
            // Suppression de la référence de ce cours dans le jour (bidirectionnalité)
            $jour->supprimerCours($this);
            // Suppression de l'objet dans le tableau
            unset($this->lesJours[$indice]);
        }
    }

    /**
     * Méthode abstraite qui devra être définie dans chaque classe dérivée
     * @return string
     */
    protected abstract function getLibelle(): string;
}
