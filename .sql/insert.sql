use musicol;

SET SQL_SAFE_UPDATES = 0;
SET FOREIGN_KEY_CHECKS = 0;

delete from planning;
delete from jour;
delete from tarif;
delete from instrument;
delete from cours;
delete from tranche;
delete from typecours;

insert into typecours(id, libelle, prixExterieur) values
(	1, 'Cours individuel', 417), (2, 'Cours collectif', 209);

insert into instrument (id, intitule) values 
	(1, 'Batterie'), 
    (2,'Piano'),
    (3,'Guitare'),
    (4,'Violon'),
    (5,'Flûte traversière'),
    (6,'Harpe'); 

insert into cours (id, libelle, ageMini, ageMaxi, nbPlaces, idInstrument, idTypeCours) VALUES 
	(1, null, 8, NULL, NULL, 1, 1),
	(2, null, 5, NULL, NULL, 2, 1),
	(3, null, 8, NULL, NULL, 3, 1),
	(4, null, 7, 10, NULL, 4, 1),
	(5, null, 16, NULL, NULL, 4, 1),
	(11, 'Atelier jazz', 12, NULL, 10, NULL, 2),
    (12, 'Batterie en duo', 12, null, 2, null, 2),
    (13, 'Guitare en duo', 12, null, 4, null, 2);

insert into tranche(id, quotientMin, libelle) values 
	(1, 0, '0 à 250'),
    (2, 251, '251 à 425'),
    (3, 426, '426 à 680'),
    (4, 681, '681 à 935'),
    (5, 936, '936 à 1800'),
    (6, 1801, '1801 et supérieur' );
	
insert into tarif (idTypeCours, idTranche, montant) VALUES
	(1, 1, 60),(1, 2, 96),(1, 3, 126),(1, 4, 192),(1, 5, 282),(1, 6, 330),
	(2, 1, 30),(2, 2, 48),(2, 3, 63), (2, 4, 96),(2, 5, 141),(2, 6, 165); 

insert into jour (id, libelle) values
	(1, 'Lundi'),
    (2, 'Mardi'),
    (3, 'Mercredi'),
    (4, 'Jeudi'),
    (5, 'Vendredi'),
    (6, 'Samedi');
    
insert into planning (idCours, idJour) values
	(1, 1), (1, 2), (1, 5),
    (2, 3), (2, 4), (2, 5),
    (3, 1), (3, 4),
    (4, 6), 
    (5, 1), (5, 2), (5, 3), (5, 4), (5, 5),
    (11, 2),
    (12, 3), (12, 6),
    (13, 4), (13, 5), (13, 6);