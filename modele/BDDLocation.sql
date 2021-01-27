--
-- Base de données :  `loueur`
--
-- --------------------------------------------------------


--
-- Structure de la table Entreprise
--

CREATE TABLE Entreprise (
  IdEnt int PRIMARY KEY NOT NULL  AUTO_INCREMENT,
  nomEnt VARCHAR(15) NOT NULL,
  mdpEnt VARCHAR(1000) NOT NULL,
  mailEnt VARCHAR(30) NOT NULL,
  typeEnt VARCHAR(30) NOT NULL 
);




--
-- Contenu de la table Entreprise
--
INSERT INTO Entreprise (nomEnt, mdpEnt, mailEnt, typeEnt) VALUES ('rootL', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785','root@gmail.com','Loueur');
INSERT INTO Entreprise (nomEnt, mdpEnt, mailEnt, typeEnt) VALUES ('rootE', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785','root@gmail.fr','Entreprise');
-- ---------------------------------------------------------







-- ---------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE Voiture (
  IdVoiture int PRIMARY KEY NOT NULL  AUTO_INCREMENT,
  IdL int NOT NULL,
  NomVoiture VARCHAR(30) NOT NULL,
  CaractVoiture VARCHAR(50) NOT NULL,
  LocationVoiture VARCHAR(30) NOT NULL,
  Photo VARCHAR(100) NOT NULL,
  Valeur int NOT NULL
);

ALTER TABLE VOITURE
ADD FOREIGN KEY (IdL) REFERENCES ENTREPRISE(IdEnt);

--
-- Contenu de la table `voiture`
--

INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Toyota 86 Trueno',	'{"moteur":"essence","vitesse":"manuelle"}', '2', 'src/voitures/trueno86.png',30);
INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Peugeot 208', '{"moteur":"essence","vitesse":"automatique"}' , '2', 'src/voitures/peugeot208.png',35);
INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Renaut Captur', '{"moteur":"essence","vitesse":"automatique"}','Disponible', 'src/voitures/renautCaptur.png',40);
INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Renaut Clio', '{"moteur":"essence","vitesse":"automatique"}','2', 'src/voitures/renaut_clio.jpg',25);
;INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Citroen C3', '{"moteur":"essence","vitesse":"automatique"}','Disponible', 'src/voitures/citroen_c3.jpg',30);
INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Dacia Sandero', '{"moteur":"essence","vitesse":"automatique"}','Disponible', 'src/voitures/Dacia_Sandero.jpg',32);
INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Peugeot 3008', '{"moteur":"essence","vitesse":"automatique"}','Disponible', 'src/voitures/Peugeot_3008.jpg',34);
INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Peugeot 2008', '{"moteur":"essence","vitesse":"automatique"}','Disponible', 'src/voitures/Peugeot2008.png',33);
INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Peugeot 308', '{"moteur":"essence","vitesse":"automatique"}','Disponible', 'src/voitures/Peugeot308.png',28);
INSERT INTO Voiture (IdL, NomVoiture, CaractVoiture, LocationVoiture, Photo, Valeur) VALUES 
(1, 'Renaut Twingo', '{"moteur":"essence","vitesse":"automatique"}','Disponible', 'src/voitures/Renaut_Twingo.jpg',10);

-- --------------------------------------

--
-- Structure de la table `facturation`
--

CREATE TABLE Facturation (
  IdFacture int PRIMARY KEY NOT NULL  AUTO_INCREMENT,
  IdE int NOT NULL,
  IdL int NOT NULL,
  IdV int NOT NULL,
  DateD DATE NOT NULL, 
  DateF DATE,
  Etat VARCHAR(20) NOT NULL DEFAULT 'Non-regle' 
);

ALTER TABLE FACTURATION
ADD FOREIGN KEY (IdE) REFERENCES ENTREPRISE(IdEnt);
ALTER TABLE FACTURATION
ADD FOREIGN KEY (IdL) REFERENCES ENTREPRISE(IdEnt);



--
-- Contenu de la table `facturation`
--

INSERT INTO Facturation (IdE, IdL, IdV, dateD, dateF, Etat) VALUES
(2, 1, 2, DATE '2018-12-03', DATE '2018-12-24', 'Regle');
INSERT INTO Facturation (IdE, IdL, IdV, dateD, dateF, Etat) VALUES
(2, 1, 3, DATE '2017-10-06', DATE '2017-11-27','Regle');
INSERT INTO Facturation (IdE, IdL, IdV, dateD) VALUES
(2, 1, 1, DATE '2020-01-01');
INSERT INTO Facturation (IdE, IdL, IdV, dateD) VALUES
(2, 1, 2, DATE '2001-12-20');
INSERT INTO Facturation (IdE, IdL, IdV, dateD) VALUES
(2, 1, 4, DATE '2020-11-01');