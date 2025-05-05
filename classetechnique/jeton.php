<?php
declare(strict_types=1);

/**
 * Classe Jeton : ensemble de méthodes statiques concernant les opérations sur des fichiers et des répertoires
 *
 * @Author : Guy Verghote
 * @Version 2025.2
 * @Date : 03/05/2025
 */
class Jeton {

    /**
     * Création d'un jeton de vérification sécurisé
     * @param int $dureeVie Durée de vie du jeton en secondes (par défaut 300 secondes)
     * @return void
     */
    public static function creer(int $dureeVie = 300) {
        if ($dureeVie <= 1) {
            $dureeVie = 300; // Valeur par défaut si la durée est trop faible
        }

        // 1. Générer un jeton sécurisé (256 bits)
        $token = bin2hex(random_bytes(32));

        // 2. Calculer l'expiration du jeton (côté serveur)
        $expires = time() + $dureeVie;

        // 3. Stocker le jeton et sa date d'expiration dans la session PHP
        $_SESSION['token'] = [
            'value' => $token,
            'expires' => $expires
        ];

        // 4. Envoyer un cookie avec le jeton (uniquement la valeur, pas l'expiration logique)
        setcookie('token', $token, [
            'expires' => $expires, // Le navigateur supprimera le cookie après cette date
            'path' => '/',
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', // HTTPS obligatoire
            'httponly' => true,    // Le cookie n'est pas accessible en JavaScript
            'samesite' => 'Strict' // Protection CSRF
        ]);
    }

    /**
     * Vérifie si le jeton reçu via le cookie est valide
     * @return bool
     */
    public static function verifier() {
        // 1. Vérifier que le jeton existe côté serveur
        if (!isset($_SESSION['token'])) {
            Erreur::envoyerReponse("Jeton manquant côté serveur.", 'global');
            return false;
        }

        // 2. Récupérer le jeton envoyé par le navigateur (via cookie)
        $token = $_COOKIE['token'] ?? null;

        if ($token === null) {
            Erreur::envoyerReponse("Jeton manquant.", 'global');
            return false;
        }

        // 3. Comparer la valeur du cookie avec celle en session
        if ($_SESSION['token']['value'] !== $token) {
            Erreur::envoyerReponse("Jeton invalide.", 'global');
            return false;
        }

        // 4. Vérifier l'expiration du jeton
        if ($_SESSION['token']['expires'] < time()) {
            Erreur::envoyerReponse("Jeton expiré.", 'global');
            return false;
        }

        // Jeton valide
        return true;
    }
}


