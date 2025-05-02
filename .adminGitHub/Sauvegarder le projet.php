<?php
// 🟢 Ce script automatise l'ajout, le commit, le push, et la synchronisation Git avec contrôle de sécurité

// 📅 Définir le fuseau horaire à utiliser pour les dates
date_default_timezone_set('Europe/Paris');

// 📁 Se déplacer dans le répertoire racine du projet (un niveau au-dessus du dossier où ce script est situé)
chdir(__DIR__ . '/..');

// 🔄 Synchroniser les informations locales avec le dépôt distant sans fusionner les modifications
echo "🔄 Vérification du dépôt distant...\n";

// Exécute la commande 'git fetch' pour récupérer les informations du dépôt distant sans changer les fichiers locaux
exec('git fetch');

// 🔢 Vérifier si des commits distants sont en attente d'intégration dans le dépôt local
exec('git rev-list HEAD..origin/main --count', $diffCount);  // Compare la branche locale à la branche distante
$nbCommitsDistant = (int) $diffCount[0];  // Récupère le nombre de commits manquants dans le dépôt local

// 📢 Si des commits distants sont en attente, on interrompt le processus
if ($nbCommitsDistant > 0) {
    // Alerte l'utilisateur qu'il y a des commits distants non récupérés
    echo "❌ Le dépôt distant contient $nbCommitsDistant commit(s) non récupéré(s).\n";
    // Invite à restaurer les commits distants avant de faire un commit local
    echo "🛑 Annulation du commit : veuillez lancer Restaurer le projet.php d'abord.\n";
    exit(1);  // Arrête l'exécution du script pour éviter un commit risqué
}

// ✅ Si aucun commit distant n'est en attente, on continue le processus de commit

// Génère la date et l'heure actuelles pour le message de commit
$date = date('d/m/Y à H:i');

// Crée un message de commit détaillant la date et l'heure
$commitMessage = "Dernière sauvegarde le $date";

// 🟡 Ajout des fichiers modifiés
echo "🟡 Ajout des fichiers modifiés\n";
// Ajoute tous les fichiers modifiés au staging area (préparation pour le commit)
exec('git add .');

// 🟡 Commit des modifications avec le message horodaté
echo "🟡 Commit des modifications : $commitMessage\n";
// Effectue le commit avec le message horodaté
exec("git commit -m \"$commitMessage\"");

// 🟡 Push vers le dépôt distant
echo "🟡 Push vers le dépôt distant\n";
// Effectue le push vers le dépôt distant (c’est ici qu’on pousse les changements)
exec('git push');

// ✅ Sauvegarde terminée avec succès
echo "✅ Sauvegarde terminée avec succès le $date\n";
