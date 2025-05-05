<?php
// La page erreur/index.php est appelée en cas de détection d'une erreur,
// elle doit charger ses propres ressources.
session_start();
// Définition d'une constante indiquant la racine du site
define('RACINE', $_SERVER['DOCUMENT_ROOT']);

// récupération des informations sur l'erreur
$message = isset($_SESSION['erreur']['message']) ? $_SESSION['erreur']['message'] : 'Erreur inconnue';
// destruction de la variable de session
unset($_SESSION['erreur']);
?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Erreur</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid d-flex flex-column p-0 h-100">
    <main>
        <div class="card mx-auto text-center mt-3" style="width: 32rem;">
            <div class="card-header bg-white">
                <strong>Avertissement</strong>
            </div>
            <div class="card-body">
                <p id='message' class="fs-6 text-danger"><?= $message ?></p>
            </div>
            <div class="card-footer text-center bg-white">
                <a href="/" class="mx-3 text-decoration-underline text-primary">
                    Revenir à la page d'accueil
                </a>
            </div>
        </div>
    </main>
</div>
</body>
</html>

