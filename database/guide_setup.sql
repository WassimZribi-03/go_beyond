-- Create guide table
CREATE TABLE IF NOT EXISTS `guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `language` varchar(50),
  `price` decimal(10,2),
  `category` varchar(100),
  `region` varchar(100),
  `country` varchar(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert guide data
INSERT INTO `guide` (`id`, `title`, `description`, `language`, `price`, `category`, `region`, `country`) VALUES
(1, 'Historical Tour of Carthage', 'Explore the ancient ruins of Carthage with an experienced guide.', 'English', 120, 'History', 'Tunis', 'Tunisia'),
(2, 'Desert Safari in Douz', 'A thrilling desert safari experience in the heart of the Tunisian Sahara.', 'French', 150, 'Adventure', 'Douz', 'Tunisia'),
(3, 'Cultural Tour of Tunis Medina', 'Discover the vibrant culture and history of Tunis Medina with a local guide.', 'Arabic', 80, 'Culture', 'Tunis', 'Tunisia'),
(4, 'Beach Tour in Hammamet', 'Relax and enjoy a beach day with a guided tour along the beautiful beaches of Hammamet.', 'English', 100, 'Leisure', 'Hammamet', 'Tunisia'),
(5, 'Trekking in the Atlas Mountains', 'Join a guided trek through the stunning Atlas Mountains in Tunisia.', 'French', 130, 'Adventure', 'Kasserine', 'Tunisia'),
(6, 'Guided Tour of El Djem Amphitheater', 'Visit the famous Roman amphitheater in El Djem, one of the best-preserved in the world.', 'English', 110, 'History', 'Mahdia', 'Tunisia'),
(7, 'Tunisia Wine Tasting Tour', 'Enjoy a guided wine tasting experience in the vineyards of Tunisia.', 'English', 160, 'Gastronomy', 'Cap Bon', 'Tunisia'),
(8, 'Night Tour of Tunis', 'Explore the city of Tunis by night with a local guide, visiting key landmarks illuminated under the stars.', 'Arabic', 90, 'Culture', 'Tunis', 'Tunisia');

-- Create disponibilites_guides table
CREATE TABLE IF NOT EXISTS `disponibilites_guides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `available_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `id_guide` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_guide` (`id_guide`),
  CONSTRAINT `fk_guide` FOREIGN KEY (`id_guide`) REFERENCES `guide` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert disponibilites_guides data
INSERT INTO `disponibilites_guides` (`id`, `available_date`, `start_time`, `end_time`, `id_guide`, `status`) VALUES
(1, '2024-07-10', '09:00:00', '12:00:00', 1, 1),
(2, '2024-07-11', '14:00:00', '17:00:00', 1, 1),
(3, '2024-07-12', '09:00:00', '12:00:00', 2, 1),
(4, '2024-07-13', '15:00:00', '18:00:00', 2, 1),
(5, '2024-07-14', '08:00:00', '11:00:00', 3, 1),
(6, '2024-07-15', '14:00:00', '17:00:00', 3, 1),
(7, '2024-07-16', '10:00:00', '13:00:00', 4, 1),
(8, '2024-07-17', '13:00:00', '16:00:00', 4, 0),
(9, '2024-07-18', '07:00:00', '10:00:00', 5, 1),
(10, '2024-07-19', '08:00:00', '11:00:00', 5, 1);

-- Create reservations table
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_id` int(11) NOT NULL,
  `disponibility_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert reservations data
INSERT INTO `reservations` (`id`, `guide_id`, `disponibility_id`, `user_id`) VALUES
(3, 1, 5, 20),
(4, 1, 20, 17),
(5, 1, 20, 18),
(6, 1, 26, 21); 