<?php
date_default_timezone_set('Europe/Paris');
chdir(__DIR__ . '/..');

// 1. Synchroniser avec le dépôt distant sans fusionner
echo "🔄 Vérification du dépôt distant...\n";
exec('git fetch');

// 2. Vérifier si des commits distants sont en attente
exec('git rev-list HEAD..origin/main --count', $diffCount);
$nbCommitsDistant = (int) $diffCount[0];

if ($nbCommitsDistant > 0) {
    echo "❌ Le dépôt distant contient $nbCommitsDistant commit(s) non récupéré(s).\n";
    echo "🛑 Annulation du commit : veuillez lancer Restaurer le projet.php d'abord.\n";
    exit(1);
}

// 3. Aucun commit distant en attente → commit autorisé
$date = date('d/m/Y à H:i');
$commitMessage = "Dernière sauvegarde le $date";

echo "🟡 Ajout des fichiers modifiés\n";
exec('git add .');

echo "🟡 Commit des modifications : $commitMessage\n";
exec("git commit -m \"$commitMessage\"");

echo "🟡 Push vers le dépôt distant\n";
exec('git push');

echo "✅ Sauvegarde terminée avec succès le $date\n";
