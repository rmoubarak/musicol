<?php
declare(strict_types=1);

/**
 * Classe permettant de journaliser automatiquement tout événement dans des fichiers log.
 * Aucun fichier de configuration requis : les journaux sont créés à la demande.
 * Le répertoire .log est automatiquement créé s’il n’existe pas.
 *
 * @author Guy Verghote
 * @version 2.0.0
 * @date 30/04/2025
 */

class Journal
{
    /**
     * Nom du dossier de journalisation relatif à la racine du projet
     */
    const REPERTOIRE = '/.log';

    /**
     * Retourne le chemin complet vers un fichier journal donné.
     * Crée le répertoire .log s’il n’existe pas.
     * @param string $nom Nom du journal (sans extension)
     * @return string Chemin absolu du fichier log
     */
    private static function getChemin(string $nom): string
    {
        $racine = $_SERVER['DOCUMENT_ROOT'] ?? getcwd(); // Compatible CLI
        $repertoire = $racine . self::REPERTOIRE;

        // Créer le répertoire s’il n’existe pas
        if (!is_dir($repertoire)) {
            mkdir($repertoire, 0775, true);
        }

        return "$repertoire/$nom.log";
    }

    /**
     * Retourne la liste des journaux existants sous forme de tableau associatif.
     * Les clés sont les noms sans extension, les valeurs sont des labels lisibles.
     * @return array<string, string> [ 'evenement' => 'Journal evenement', ... ]
     */
    public static function getListe(): array
    {
        $racine = $_SERVER['DOCUMENT_ROOT'] ?? getcwd();
        $repertoire = $racine . self::REPERTOIRE;

        // Création du répertoire si besoin
        if (!is_dir($repertoire)) {
            mkdir($repertoire, 0775, true);
        }

        // Recherche des fichiers .log
        $fichiers = glob($repertoire . '/*.log');
        $liste = [];

        foreach ($fichiers as $fichier) {
            $nomComplet = basename($fichier);             // ex: "erreur.log"
            $nomSansExt = pathinfo($nomComplet, PATHINFO_FILENAME); // ex: "erreur"
            $label = 'Journal ' . $nomSansExt;            // tu peux personnaliser ici
            $liste[$nomSansExt] = $label;
        }

        return $liste;
    }


    /**
     * Enregistre un événement dans le journal spécifié (créé à la volée)
     * @param string $evenement Description de l’événement
     * @param string $journal Nom du journal (par défaut 'evenement')
     */
    public static function enregistrer(string $evenement, string $journal = 'evenement'): void
    {
        $fichier = self::getChemin($journal);
        $date = date('d/m/Y H:i:s');
        $script = $_SERVER['SCRIPT_NAME'] ?? 'CLI';
        $ip = self::getIp();

        $file = fopen($fichier, 'a');
        if (flock($file, LOCK_EX)) {
            fwrite($file, "$date;$evenement;$script;$ip\n");
            flock($file, LOCK_UN);
        }
        fclose($file);
    }

    /**
     * Retourne les événements du journal sous forme de tableau
     * Chaque ligne est un tableau indexé : [date, événement, script, ip]
     * @param string $journal Nom du journal
     * @return array<int, array{0:string,1:string,2:string,3:string}>
     */
    public static function getLesEvenements(string $journal = 'evenement'): array
    {
        $fichier = self::getChemin($journal);

        if (!file_exists($fichier)) {
            return []; // Journal vide ou inexistant
        }

        $lignes = file($fichier, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lignes = array_reverse($lignes);

        $lesLignes = [];
        foreach ($lignes as $ligne) {
            $lesLignes[] = explode(';', $ligne);
        }

        return $lesLignes;
    }

    /**
     * Supprime un journal (fichier .log) donné
     * @param string $nom Nom du journal
     */
    public static function supprimer(string $nom): void
    {
        $fichier = self::getChemin($nom);
        if (file_exists($fichier)) {
            unlink($fichier);
        }
    }

    /**
     * Retourne la meilleure estimation de l’adresse IP du client (ou 'CLI')
     * @return string
     */
    public static function getIp(): string
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return 'CLI';
        }
    }
}
