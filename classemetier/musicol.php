<?php
declare(strict_types=1);

// Classe permettant l'accès aux données de la base musicol

class Musicol {

    // instance d'un objet Select
    private Select $select;

    /**
     * Constructeur de la classe.
     *
     * Initialise l'objet avec une instance de la classe 'Select', utilisée pour exécuter
     * les requêtes SQL et récupérer les résultats sous forme de tableau associatif.
     *
     * Cette approche favorise l'injection de dépendance, en séparant la logique de requêtage
     * (dans 'Select') de la logique métier (dans 'Musicol'). Cela rend la classe plus testable
     * et découplée du moteur d’accès aux données (ex. : PDO direct).
     *
     * @param Select $select Instance du gestionnaire d'accès aux données (abstraction autour de PDO).
     */
    public function __construct(Select $select)
    {
        $this->select = $select;
    }

    /**
     * Récupère les tarifs des cours en fonction des tranches et du type de cours.
     *
     * La requête retourne un tableau indexé numériquement
     * Chaque ligne du tableau contient un tableau associatif contenant les clés suivantes :
     *     'libelle' : libellé de la tranche ou 'EXT' pour les tarifs extérieurs
     *     'coursIndividuel' : montant du tarif pour le cours individuel
     *     'coursCollectif' : montant du tarif pour le cours collectif
     *
     * - Une première ligne spécifique avec le libellé "EXT", où les tarifs sont extraits
     *   directement depuis la table 'typeCours', pour représenter les prix extérieurs.
     * - Les lignes suivantes représentent les tranches tarifaires définies dans la table 'tranche',
     *   avec un tarif par type de cours (individuel ou collectif), obtenu via un 'SUM' conditionnel.
     *
     * Cette méthode est utilisée pour afficher la grille tarifaire par tranche.
     *
     * @return array<int, array{libelle: string, coursIndividuel: string, coursCollectif: string}>
     * @throws Exception Si une erreur survient lors de la requête, elle est gérée par Erreur::envoyerReponse().
     */
    public function getlesTarifs() : array {
        $sql = <<<EOD
           
           
EOD;
        try {
            return $this->select->getRows($sql);
        } catch (Exception $e) {
            Erreur::envoyerReponse($e->getMessage(), 'global');
        }
    }

    /**
     * Récupère l'organisation hebdomadaire des cours à partir de la table 'planning'.
     *
     * Cette méthode retourne un tableau indexé numériquement
     * Chaque ligne du tableau contient un tableau associatif contenant les clés suivantes :
     *        'jour' : le libéllé du jour ('lundi', 'mardi', etc.)
     *        'lesCours' : une liste concaténée des cours programmés à cette date (séparés par une virgule).
     *
     * Le libellé des cours dépend de leur type :
     * - Pour les cours collectifs ('idTypeCours = 2'), on affiche directement le libellé du cours.
     * - Pour les cours individuels, on affiche le nom de l'instrument associé.
     *
     * La fonction 'GROUP_CONCAT' permet d'agréger les cours par jour avec une séparation par virgule.
     * Le résultat est regroupé par identifiant de jour ('jour.id'), et inclut le libellé du jour
     * (ex: Lundi, Mardi, etc.).
     *
     * @return array<int, array{jour: string, lesCours: string}>
     * @throws Exception En cas d'erreur SQL ou de connexion, une réponse formatée est retournée via Erreur::envoyerReponse().
     *
     *  Exemple de sortie :
     *  [
     *    ['jour' => 'Lundi', 'lesCours' => 'Piano, Violon, Solfège'],
     *    ['jour' => 'Mardi', 'lesCours' => 'Guitare, Batterie']
     *  ]
     */

    public function getLePlanning() : array {
        $sql = <<<EOD
           
           
EOD;
        try {
            return $this->select->getRows($sql);
        } catch (Exception $e) {
            Erreur::envoyerReponse($e->getMessage(), 'global');
        }
    }

    /**
     * Récupère les jours de la semaine à partir de la table 'jour'.
     *
     *  Cette méthode retourne un tableau indexé numériquement
     *  Chaque ligne du tableau contient un tableau associatif contenant les clés suivantes :
     *       'id' : identifiant du jour (1, 2, etc.)
     *       'libelle' : nom du jour ('lundi', 'mardi', etc.)
     *  Elle est utilisée pour afficher les jours disponibles dans l'application.
     *
     * @return array<int, array{id: int, libelle: string}>
     * @throws Exception En cas d'erreur SQL ou de connexion, une réponse formatée est retournée via Erreur::envoyerReponse().
     */
    public function getLesJours() : array
    {
        $sql = "Select id, libelle from jour;";
        try {
            return $this->select->getRows($sql);
        } catch (Exception $e) {
            Erreur::envoyerReponse($e->getMessage(), 'global');
        }
    }


    // Récupération des cours de la journée dont l'idJour est transmis en paramètre
    // On a besoin simplement du libellé du cours, mais ce dernier correspond soit à l'intitulé de l'instrument, soit au libelle du cours
    // On peut trouver la requête qui peut renvoyer ce résultat en utilisant la structure conditionnelle if

    /**
     * Récupère les cours programmés pour un jour spécifique.
     *
     * Cette méthode retourne un tableau indexé numériquement.
     *  Chaque ligne du tableau contient un tableau associatif contenant la clé 'libelle'
     *
     * la valeur de la clé 'libelle' dépend du type de cours :
     *
     * - Pour les cours collectifs ('idTypeCours = 2'), on affiche le libellé du cours.
     * - Pour les cours individuels, on affiche le nom de l'instrument associé.
     *
     * @param int $idJour Identifiant du jour pour lequel on souhaite récupérer les cours.
     *
     * @return array<int, array{libelle: string}>
     * @throws Exception En cas d'erreur SQL ou de connexion, une réponse formatée est retournée via Erreur::envoyerReponse().
     */
    public function getLesCours(int $idJour) : array {

        $sql = <<<EOD


EOD;
        $select = new Select();
        try {
            return $this->select->getRows($sql, ['id' => $idJour]);
        } catch (Exception $e) {
            Erreur::envoyerReponse($e->getMessage(), 'global');
        }
    }
}
