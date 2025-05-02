<?php
// 🔄 restaurer.php — Sauvegarde automatique locale puis mise à jour du dépôt depuis GitHub

date_default_timezone_set('Europe/Paris');

// 📁 1. Se placer à la racine du projet (un niveau au-dessus de ce script)
chdir(__DIR__ . '/..');

echo "🟡 Étape 1 : Vérification de modifications locales\n";

// 🧾 2. Vérification d'éventuelles modifications (staged, unstaged ou fichiers non suivis)
exec('git status --porcelain', $output);

if (count($output) > 0) {
    // 📆 3. Génération horodatée uniquement si nécessaire
    $date = date('d/m/Y à H:i');
    $commitMessage = "Sauvegarde automatique avant restauration le $date";

    echo "💾 Modifications détectées → commit automatique\n";
    exec('git add .');
    exec("git commit -m \"$commitMessage\"");
    echo "✅ Sauvegarde locale effectuée avec le message : \"$commitMessage\"\n";
} else {
    echo "🔹 Aucun changement local à sauvegarder\n";
}

// 🔃 4. Récupération des mises à jour distantes (sans créer de commit de fusion)
echo "🔁 Étape 2 : Rebase depuis le dépôt distant (git pull --rebase)\n";
exec('git pull --rebase');

// ✅ 5. Fin du processus
$date = date('d/m/Y à H:i');
echo "✅ Mise à jour terminée à $date\n";
