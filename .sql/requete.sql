use musicol;

-- Afficher 'Ext', le prix extérieur pour un cours individuel et le prix extérieur pour un cours collectif

-- Solution 1 : Requête croisée

Select 'EXT',
       sum(if(id = 1, prixExterieur, 0)) as coursIndividuel,
       sum(if(id = 2, prixExterieur, 0)) as coursCollectif
from typecours;

-- Solution 2 : regroupement de requête retournat une seule valeur

Select 'EXT'                                              as libelle,
       (select prixExterieur from typeCours where id = 1) as coursIndividuel,
       (select prixExterieur from typeCours where id = 2) as coursCollectif;

-- résultat attendu : EXT,417,209

-- Afficher Pour chaque tranche, le libellé, le montant du tarif pour un cours individuel et le montant du tarif pour un cours collectif
-- utilisation d'une requête croisée avec regroupement

-- l'utilisation de la fonction group_concat permet de regrouper les valeurs d'une colonne
Select tranche.libelle, group_concat(montant)
from tarif
         join tranche on tarif.idTranche = tranche.id
group by tranche.id;

/*
 0 à 250,"60,30"
251 à 425,"96,48"
426 à 680,"126,63"
681 à 935,"192,96"
936 à 1800,"282,141"
1801 et supérieur,"330,165"
 */

-- ce n'est pas le résultat attendu car il n'y a pas de séparation entre les valeurs
-- il faut donc utiliser la fonction if pour récupérer les valeurs de chaque type de cours

Select tranche.libelle,
       if(tarif.idTypeCours = 1, montant, 0) as CoursIndividuel,
       if(tarif.idTypeCours = 2, montant, 0) as CoursCollectif
from tarif
         join tranche on tarif.idTranche = tranche.id
group by tranche.libelle;

/*
 0 à 250,60,0
251 à 425,96,0
426 à 680,126,0
681 à 935,192,0
936 à 1800,282,0
1801 et supérieur,330,0
 */

-- problème sur la 3ème colonne toujours à 0
-- il faut donc utiliser la fonction sum pour additionner les valeurs de chaque type de cours

Select tranche.libelle,
       sum(if(tarif.idTypeCours = 1, montant, 0)) as CoursIndividuel,
       sum(if(tarif.idTypeCours = 2, montant, 0)) as CoursCollectif
from tarif
         join tranche on tarif.idTranche = tranche.id
group by tranche.libelle;

-- résultat attendu
/*
 0 à 250,60,30
251 à 425,96,48
426 à 680,126,63
681 à 935,192,96
936 à 1800,282,141
1801 et supérieur,330,165

 */

-- Union des deux requêtes

Select 'EXT'                                              as libelle,
       (select prixExterieur from typeCours where id = 1) as coursIndividuel,
       (select prixExterieur from typeCours where id = 2) as coursCollectif
Union
Select tranche.libelle,
       sum(if(tarif.idTypeCours = 1, montant, 0)) as CoursIndividuel,
       sum(if(tarif.idTypeCours = 2, montant, 0)) as CoursCollectif
from tarif
         join tranche on tarif.idTranche = tranche.id
group by tranche.libelle;

-- résultat attendu
/*
 EXT,417,209
 0 à 250,60,30
251 à 425,96,48
426 à 680,126,63
681 à 935,192,96
936 à 1800,282,141
1801 et supérieur,330,165

 */


-- Afficher l'ensemble des cours : libellé du jour et libellé du cours

-- Difficulté : Le libellé du cours correspond à celui du cours pour un cours collectif et à l'intitulé de l'instrument pour un cours individuel
-- solution : Utilisation de la structure conditionnel if pour récupérer le libellé correspondant au cours

Select jour.libelle                             as libelleJour,
       if(cours.idTypeCours = 2, cours.libelle,
          (select instrument.intitule
           from instrument
           where id = cours.idInstrument)) as libelleCours
from planning
         join cours on planning.idCours = cours.id
         join jour on planning.idJour = jour.id
order by jour.id;


-- Résultat attendu
/*
Lundi,Batterie
Lundi,Guitare
Lundi,Violon
Mardi,Batterie
Mardi,Violon
Mardi,Atelier jazz
Mercredi,Piano
Mercredi,Violon
Mercredi,Batterie en duo
Jeudi,Piano
Jeudi,Guitare
Jeudi,Violon
Jeudi,Guitare en duo
Vendredi,Batterie
Vendredi,Piano
Vendredi,Violon
Vendredi,Guitare en duo
Samedi,Violon
Samedi,Batterie en duo
Samedi,Guitare en duo
 */


-- Afficher l'ensemble des cours regroupés par journée

-- résultat attendu
/*
Jeudi,"Piano, Guitare, Violon, Guitare en duo"
Lundi,"Batterie, Guitare, Violon"
Mardi,"Batterie, Violon, Atelier jazz"
Mercredi,"Piano, Violon, Batterie en duo"
Samedi,"Violon, Batterie en duo, Guitare en duo"
Vendredi,"Batterie, Piano, Violon, Guitare en duo"


 */

Select jour.libelle                                                          as libelleJour,
       group_concat(if(cours.idTypeCours = 2, cours.libelle,
                       (select instrument.intitule
                        from instrument
                        where id = cours.idInstrument)) SEPARATOR ", ") as libelleCours
from planning
         join cours on planning.idCours = cours.id
         join jour on planning.idJour = jour.id
group by jour.libelle;


-- libellé des cours d'une journée dont l'id est passé en paramètre
-- Difficulté : Le libellé du cours correspond à celui du cours pour un cours collectif et à l'intitulé de l'instrument pour un cours individuel
-- solution : Utilisation de la structure conditionnel if pour récupérer le libellé correspondant au cours

Select if(cours.idTypeCours = 2, cours.libelle,
          (select instrument.intitule
           from instrument
           where id = cours.idInstrument)) as libelle
from cours
         join planning on planning.idCours = cours.id
where idJour = :id

-- résultat attendu avec id = 1
/*
 Batterie
Guitare
Violon
 */
