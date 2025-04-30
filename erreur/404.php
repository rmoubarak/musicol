<!DOCTYPE HTML>
<html lang="fr">
<head>
    <title>Erreur</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    // chargement du composant bootstrap
    echo file_get_contents('https://verghote.github.io/composant/bootstrap.html');
    ?>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="container-fluid d-flex flex-column p-0 h-100">
    <main>
        <div class="formulaire text-center mt-3" style="width: 32rem;">
            <p class="erreur">
                La page demandée n'existe pas.
            </p>
            <hr>
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
