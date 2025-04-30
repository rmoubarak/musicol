SET default_storage_engine=InnoDb;

drop database if exists musicol;

create database musicol;

use musicol;


create Table Instrument (    
	id int,
	intitule varchar (50) not null,
	constraint pk_Instrument primary key (id)
);

create Table TypeCours (    
	id int,
	libelle varchar (50) not null,
    prixExterieur int not null,
	constraint pk_TypeCours primary key (id)
);

create table Cours (
	id int not null AUTO_INCREMENT,
	libelle VARCHAR(50) null ,
	ageMini int not null,
	ageMaxi int NULL,
	nbPlaces int NULL,
	idInstrument int NULL,
	idTypeCours int not null,
	constraint pk_Cours PRIMARY KEY (id),
	constraint fk_Cours_Instruments foreign key (idInstrument) references Instrument (id),
	constraint fk_Cours_TypeCours foreign key (idTypeCours) references TypeCours (id)
);

create Table Tranche (    
	id int,
	quotientMin int not null,
    libelle varchar(25) not null,
	constraint pk_Tranche primary key (id)
);

create Table Tarif (
	idTypeCours int,
	idTranche int,
	montant int,
	constraint pk_Tarif primary key (idTypeCours, idTranche),
	constraint fk_Tarif_TypeCours foreign key (idTypeCours) references TypeCours (id),
	constraint fk_Tarif_Tranche foreign key (idTranche) references Tranche (id)
);

create table Jour (
	id int not null,
    libelle varchar(8),
    Constraint pk_Jour primary key (id)
);

create table Planning(
	idJour int not null,
    idCours int not null,
    Constraint pk_Planning primary key (idJour, idCours),
	Constraint fk_Planning_Jour foreign key (idJour) references Jour (id),
	constraint fk_Planning_Cours foreign key (idCours) references  Cours (id)
);





