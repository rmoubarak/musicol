<?php
// 🟢 Ce script synchronise le dépôt personnel avec le dépôt du professeur (attention, destructive!)

// 📁 1. Aller à la racine du projet (un niveau au-dessus du script)
chdir(__DIR__ . '/..');

// 🟠 2. Afficher un avertissement à l'utilisateur
echo "⚠️  ATTENTION : cette opération va écraser toutes les modifications locales !\n";
echo "Elle va forcer le projet à refléter exactement le contenu du dépôt du professeur (upstream/main).\n";
echo "Souhaites-tu vraiment continuer ? (oui/non) : ";
$handle = fopen("php://stdin", "r");
$confirmation = trim(fgets($handle));
fclose($handle);

// ❌ Si l'utilisateur annule, on sort
if (strtolower($confirmation) !== 'oui') {
    echo "❌ Opération annulée par l'utilisateur.\n";
    exit;
}

// ✅ Si confirmé, on continue avec les commandes Git
echo "🟡 Étape 1 : Récupération des dernières mises à jour du dépôt du professeur (git fetch upstream)\n";
exec('git fetch upstream');

echo "🟡 Étape 2 : Réinitialisation complète sur upstream/main (git reset --hard upstream/main)\n";
exec('git reset --hard upstream/main');

echo "🟡 Étape 3 : Push forcé vers le dépôt personnel (git push -f origin main)\n";
exec('git push -f origin main');

echo "✅ Synchronisation terminée avec succès.\n";
echo "Le projet a été réinitialisé pour refléter le dépôt du professeur.\n";
exit;