<?php
// 🟢 Ce script automatise l'ajout, le commit, le push, et la synchronisation Git

date_default_timezone_set('Europe/Paris');

// 📁 1. Aller à la racine du projet (un niveau au-dessus du dossier où se trouve ce script)
chdir(__DIR__ . '/..');

// 📆 2. Génération de la date au format souhaité (ex : 25/04/2025 à 14:30)
$date = date('d/m/Y à H:i');

// 🧾 3. Construction du message de commit avec date et heure
$commitMessage = "Dernière sauvegarde le $date";

// ➕ 4. Ajouter tous les fichiers modifiés au staging area
echo "🟡 Étape 1 : Ajout des fichiers modifiés (git add .)\n";
exec('git add .');

// ✅ 5. Commit avec un message horodaté
echo "🟡 Étape 2 : Commit des modifications avec le message : \"$commitMessage\"\n";
exec("git commit -m \"$commitMessage\"");

// 🚀 6. Push vers le dépôt GitHub de l'étudiant (remote origin)
echo "🟡 Étape 3 : Push vers le dépôt distant (git push)\n";
exec('git push');

// 🎉 8. Fin du script
echo "✅ Sauvegarde terminée avec succès le $date\n";

exit;