
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL COMMENT 'fk type_id',
  `user_id` int(11) NOT NULL COMMENT 'fk user_id',
  `document_cover` int(11) DEFAULT NULL COMMENT 'fk file_id',
  `name` varchar(255) COLLATE utf8_unicode_ci,
  `description` varchar(255) COLLATE utf8_unicode_ci,
  `other_details` varchar(255) COLLATE utf8_unicode_ci,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `user_id` (`user_id`),
  KEY `document_cover` (`document_cover`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `documents` (`type_id`, `user_id`, `document_cover`, `name`, `published`) VALUES
('1', '3', '2', 'Frogs', '1');

-- --------------------------------------------------------

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = Active, 0 = Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- contains dont work well if there is a foreign key constant at null
INSERT INTO `files` (`name`, `path`, `status`) VALUES
('', '', '0'),
('frog.jpg', 'Files/', '1');

-- --------------------------------------------------------

DROP TABLE IF EXISTS `document_types`;
CREATE TABLE IF NOT EXISTS `document_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `document_types` (`type`) VALUES
('text');
-- ('photo_album');

-- --------------------------------------------------------

DROP TABLE IF EXISTS `text_documents`;
CREATE TABLE IF NOT EXISTS `text_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL COMMENT 'fk document_id',
  `text` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `text_documents` (`document_id`, `text`) VALUES
('1', "A frog is any member of a diverse and largely carnivorous group of short-bodied, tailless amphibians composing the order Anura (Ancient Greek ἀν-, without + οὐρά, tail). The oldest fossil 'proto-frog' appeared in the early Triassic of Madagascar, but molecular clock dating suggests their origins may extend further back to the Permian, 265 million years ago. Frogs are widely distributed, ranging from the tropics to subarctic regions, but the greatest concentration of species diversity is in tropical rainforests. There are approximately 4,800 recorded species, accounting for over 85% of extant amphibian species. They are also one of the five most diverse vertebrate orders.

The body plan of an adult frog is generally characterized by a stout body, protruding eyes, cleft tongue, limbs folded underneath, and the absence of a tail. Besides living in fresh water and on dry land, the adults of some species are adapted for living underground or in trees. The skins of frogs are glandular, with secretions ranging from distasteful to toxic. Warty species of frog tend to be called toads but the distinction between frogs and toads is based on informal naming conventions concentrating on the warts rather than taxonomy or evolutionary history. Frogs' skins vary in colour from well-camouflaged dappled brown, grey and green to vivid patterns of bright red or yellow and black to advertise toxicity and warn off predators.

Frogs typically lay their eggs in water. The eggs hatch into aquatic larvae called tadpoles that have tails and internal gills. They have highly specialized rasping mouth parts suitable for herbivorous, omnivorous or planktivorous diets. The life cycle is completed when they metamorphose into adults. A few species deposit eggs on land or bypass the tadpole stage. Adult frogs generally have a carnivorous diet consisting of small invertebrates, but omnivorous species exist and a few feed on fruit. Frogs are extremely efficient at converting what they eat into body mass. They are an important food source for predators and part of the food web dynamics of many of the world's ecosystems. The skin is semi-permeable, making them susceptible to dehydration, so they either live in moist places or have special adaptations to deal with dry habitats. Frogs produce a wide range of vocalizations, particularly in their breeding season, and exhibit many different kinds of complex behaviours to attract mates, to fend off predators and to generally survive.

Frogs are valued as food by humans and also have many cultural roles in literature, symbolism and religion. Frog populations have declined significantly since the 1950s. More than one third of species are considered to be threatened with extinction and over 120 are believed to have become extinct since the 1980s.[1] The number of malformations among frogs is on the rise and an emerging fungal disease, chytridiomycosis, has spread around the world. Conservation biologists are working to understand the causes of these problems and to resolve them. ");

-- --------------------------------------------------------

-- DROP TABLE IF EXISTS `photo_album_documents`;
-- CREATE TABLE IF NOT EXISTS `document_types` (
--   `id` int(11) NOT NULL AUTO_INCREMENT,
--   `photos` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
--   PRIMARY KEY (`id`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `interactive_methods`;
CREATE TABLE IF NOT EXISTS `interactive_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `interactive_methods` (`method`) VALUES
('view'),
('like'),
('dislike'),
('favorite');

-- --------------------------------------------------------

DROP TABLE IF EXISTS `interactions`;
CREATE TABLE IF NOT EXISTS `interactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'This is so we can have many interactions of the same kind (doc, user, method)',
  `document_id` int(11) NOT NULL COMMENT 'PF documents(id)',
  `user_id` int(11) NOT NULL COMMENT 'PF users(id)',
  `interactiveMethod_id` int(11) NOT NULL COMMENT 'PF interactive_methods(id)',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`),
  KEY `user_id` (`user_id`),
  KEY `interactiveMethod_id` (`interactiveMethod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL COMMENT 'fk Roles(role_code)',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Les mot de passes devraient être 123',
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`role`, `username`, `email`, `password`, `verified`) VALUES
('visitor', '', '', '', 0),
('admin', 'Admin', 'admin@gmail.com', '$2y$10$ONneUhzLKfpWoiKMeFi0au7/wxcqV/6CyTsAzCAWDF.XkdWqGMkRm', 1),
('creator', 'justin', 'justin@gmail.com', '$2y$10$ONneUhzLKfpWoiKMeFi0au7/wxcqV/6CyTsAzCAWDF.XkdWqGMkRm', 1);

-- --------------------------------------------------------

DROP TABLE IF EXISTS `email_verifications`;
CREATE TABLE IF NOT EXISTS `email_verifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'fk user(id)',
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

ALTER TABLE `documents`
  ADD CONSTRAINT `FK_document_type` FOREIGN KEY (`type_id`) REFERENCES `document_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_document_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_document_file` FOREIGN KEY (`document_cover`) REFERENCES `files` (`id`) ON UPDATE CASCADE;

ALTER TABLE `interactions`
  ADD CONSTRAINT `FK_interaction_document` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_interaction_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_interaction_interactivemethod` FOREIGN KEY (`interactiveMethod_id`) REFERENCES `interactive_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `text_documents`
  ADD CONSTRAINT `FK_textdocument_document` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `email_verifications`
  ADD CONSTRAINT `FK_verification_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

