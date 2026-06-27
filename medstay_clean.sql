SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

/*!40101 SET NAMES utf8mb4 */;

-- Drop existing tables so this imports cleanly
DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `contact_messages`;
DROP TABLE IF EXISTS `properties`;

-- --------------------------------------------------------
-- Table structure for table `properties`
-- --------------------------------------------------------

CREATE TABLE `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `beds` int(11) NOT NULL,
  `baths` int(11) NOT NULL,
  `sqm` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `properties` (`id`, `title`, `location`, `type`, `beds`, `baths`, `sqm`, `price`, `rating`, `badge`, `image`) VALUES
(1, 'Modern City Apartment with Balcony', 'Beirut, Lebanon', 'Apartment', 2, 1, 75, 120, 4.9, 'featured', 'prop1.jpg'),
(2, 'Glass Penthouse, Panoramic City Views', 'Beirut, Lebanon', 'Apartment', 3, 2, 150, 280, 5.0, 'featured', 'prop2.jpg'),
(3, 'Curved Balcony Studio, Old Town Views', 'Beirut, Lebanon', 'Studio', 1, 1, 60, 95, 4.7, 'new', 'prop3.jpg'),
(4, 'Luxury Riad with Moroccan Lanterns', 'Marrakech, Morocco', 'Riad', 4, 3, 200, 350, 4.9, 'featured', 'prop4.jpg'),
(5, 'Traditional Kasbah Villa, Palm Garden', 'Marrakech, Morocco', 'Villa', 5, 4, 400, 480, 4.8, 'popular', 'prop5.jpg'),
(6, 'Artisan Yurt with Outdoor Kitchen', 'Rural Morocco', 'Yurt', 1, 1, 40, 85, 4.9, 'unique', 'prop6.jpg'),
(7, 'Stargazer Yurt — Milky Way Views', 'Rural Morocco', 'Yurt', 1, 1, 35, 110, 5.0, 'unique', 'prop7.jpg'),
(8, 'Heritage Suite with Private Dining', 'Marrakech, Morocco', 'Riad', 2, 2, 120, 220, 4.9, 'featured', 'prop8.jpg'),
(9, 'Rustic Stone Villa, Arched Windows', 'Rural Lebanon', 'Villa', 3, 2, 160, 165, 4.7, 'popular', 'prop9.jpg');

-- --------------------------------------------------------
-- Table structure for table `bookings`
-- --------------------------------------------------------

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `guest_name` varchar(100) NOT NULL,
  `guest_email` varchar(100) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Table structure for table `contact_messages`
-- --------------------------------------------------------

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `inquiry_type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS = 1;
