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
                Vous n'avez pas les droits suffisants pour accéder à cette page.
            </p>
            <hr>
            <p style="text-align: justify;">
                Rappel de la loi : article 323-1 du code pénal français
            </p>
            <p style="text-align: justify;">
                Le fait d'accéder ou de se maintenir, frauduleusement, dans tout ou partie d'un système de traitement
                automatisé de données est puni de deux ans d'emprisonnement et de 60 000 euros d'amende.
                Lorsqu'il en est résulté soit la suppression ou la modification de données contenues dans le système,
                soit
                une altération du fonctionnement de ce système, la peine est de trois ans d'emprisonnement et de 100 000
                euros d'amende.
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