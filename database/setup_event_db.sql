-- Create event database
CREATE DATABASE IF NOT EXISTS event;
USE event;

-- Create categorievent table
CREATE TABLE IF NOT EXISTS `categorievent` (
  `id_categ` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` varchar(255) NOT NULL,
  `disponibilite` int(11) NOT NULL,
  `organisateur` varchar(100) NOT NULL,
  PRIMARY KEY (`id_categ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert initial category data
INSERT INTO `categorievent` (`id_categ`, `categorie`, `disponibilite`, `organisateur`) VALUES
(1001, 'Festival International de Carthage', 10000, 'Ministère des Affaires Culturelles'),
(1002, 'Conférence TIC Tunis', 1500, 'Tunisian IT Association'),
(1003, 'Salon de l''Agriculture SIAT', 3000, 'Agence de Promotion des Investissements Agricoles'),
(1004, 'Festival du Sahara à Douz', 8000, 'Association du Festival International du Sahara'),
(1005, 'Journées Cinématographiques de Carthage (JCC)', 5000, 'Centre National du Cinéma et de l''Image');

-- Create gestionevent table
CREATE TABLE IF NOT EXISTS `gestionevent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_start` datetime NOT NULL,
  `place` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `capacity` int(11) NOT NULL,
  `id_categ` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_categ`) REFERENCES `categorievent`(`id_categ`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert initial event data
INSERT INTO `gestionevent` (`id`, `title`, `description`, `date_start`, `place`, `price`, `capacity`, `id_categ`) VALUES
(20001, 'Concert d''ouverture du Festival de Carthage', 'Un concert d''ouverture exceptionnel avec des artistes internationaux.', '2024-07-20 20:00:00', 'Théâtre Antique de Carthage', 80, 5000, 1001),
(20002, 'Salon International de l''Agriculture SIAT', 'Exposition des innovations agricoles et rencontre avec les professionnels.', '2024-10-15 09:00:00', 'Parc des Expositions du Kram', 10, 3000, 1003),
(20003, 'Projection spéciale des JCC', 'Projection de films primés lors des Journées Cinématographiques de Carthage.', '2024-11-01 18:00:00', 'Cité de la Culture, Tunis', 15, 500, 1005),
(20004, 'Conférence TechWorld Tunis', 'Une conférence sur les nouvelles technologies et startups en Tunisie.', '2024-09-10 10:00:00', 'Hôtel Laico Tunis', 50, 1200, 1002),
(20005, 'Compétition de Courses de Chameaux', 'Un événement traditionnel dans le cadre du Festival du Sahara à Douz.', '2024-12-25 08:00:00', 'Douz, Tunisie', 0, 800, 1004); 