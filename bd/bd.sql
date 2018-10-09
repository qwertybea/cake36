
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
('1', '3', '2', 'Frogs', '1'),
('1', '4', '3', 'Trees', '1');

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
('frog.jpg', 'Files/', '1'),
('trees.jpg', 'Files/', '1');

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

Frogs are valued as food by humans and also have many cultural roles in literature, symbolism and religion. Frog populations have declined significantly since the 1950s. More than one third of species are considered to be threatened with extinction and over 120 are believed to have become extinct since the 1980s.[1] The number of malformations among frogs is on the rise and an emerging fungal disease, chytridiomycosis, has spread around the world. Conservation biologists are working to understand the causes of these problems and to resolve them. "),
('2', 'I think that I shall never see
A poem lovely as a tree.

A tree whose hungry mouth is prest
Against the earth’s sweet flowing breast;

A tree that looks at God all day,
And lifts her leafy arms to pray;

A tree that may in Summer wear
A nest of robins in her hair;

Upon whose bosom snow has lain;
Who intimately lives with rain.

Poems are made by fools like me,
But only God can make a tree.');

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

INSERT INTO `interactions` (`document_id`, `user_id`, `interactiveMethod_id`) VALUES
('2', '1', '1'),
('2', '1', '1'),
('2', '1', '1'),
('2', '1', '1'),
('2', '1', '1'),
('2', '1', '1');

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

-- Les mot de passes devraient être 123
INSERT INTO `users` (`role`, `username`, `email`, `password`, `verified`) VALUES
('visitor', '', '', '', 0),
('admin', 'Admin', 'admin@gmail.com', '$2y$10$ONneUhzLKfpWoiKMeFi0au7/wxcqV/6CyTsAzCAWDF.XkdWqGMkRm', 1),
('creator', 'wikipedia', 'wiki@gmail.com', '$2y$10$ONneUhzLKfpWoiKMeFi0au7/wxcqV/6CyTsAzCAWDF.XkdWqGMkRm', 1),
('creator', 'Joyce_Kilmer', 'JK@gmail.com', '$2y$10$ONneUhzLKfpWoiKMeFi0au7/wxcqV/6CyTsAzCAWDF.XkdWqGMkRm', 1);

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

-- --------------------------------------------------------
DROP TABLE IF EXISTS `i18n`;
CREATE TABLE IF NOT EXISTS `i18n` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`) VALUES
('fr_CA', 'documentTypes', 1, 'type', 'Texte'),
('zh_CN', 'documentTypes', 1, 'type', '文本'),
('fr_CA', 'documents', 1, 'name', 'Grenouilles'),
('zh_CN', 'documents', 1, 'name', '青蛙'),
('fr_CA', 'documents', 2, 'name', 'Arbres'),
('zh_CN', 'documents', 2, 'name', '树木'),
('fr_CA', 'textDocuments', 1, 'text', 'Les anoures, Anura, sont un ordre d\'amphibiens. C\'est un groupe, diversifié et principalement carnivore, d\'amphibiens sans queue comportant notamment des grenouilles et des crapauds. Le plus ancien fossile de « proto-grenouille » a été daté du début du Trias à Madagascar, mais la datation moléculaire suggère que leur origine pourrait remonter au Permien, il y a 265 Ma. Les anoures sont largement distribués dans le monde, des tropiques jusqu\'aux régions subarctiques, mais la plus grande concentration d\'espèces se trouve dans les forêts tropicales. Il y a environ 4 800 espèces d\'anoures recensées, représentant plus de 85 % des espèces d\'amphibiens existantes. Il est l\'un des cinq ordres de vertébrés les plus diversifiés.

L\'anoure adulte a communément un corps robuste et sans queue, des yeux exorbités, une langue bifide, des membres repliés sous le reste du corps, prêts pour des bonds à bonne distance. Vivant ordinairement en eau douce et sur le sol, certaines espèces vivent, au stade adulte, sous terre ou dans les arbres. La peau des grenouilles est glandulaire, avec des sécrétions lui donnant un mauvais goût ou la rendant toxique. Certaines espèces, appelées par convention crapauds, ont une peau dite verruqueuse dont les renflements contiennent des toxines glandulaires ; mais par la taxinomie et la phylogénie, certains crapauds sont plus proches des grenouilles que des autres crapauds. La couleur de la peau des grenouilles varie du marron tacheté, gris et vert, propices au mimétisme, à des motifs vifs de rouge ou jaune et noir signalant aux prédateurs leur toxicité.

Les œufs que ces amphibiens pondent dans l\'eau, donnent des larves aquatiques appelées têtards possédant des pièces buccales adaptées à un régime herbivore, omnivore ou planctonophage. Quelques espèces déposent leurs œufs sur terre ou n\'ont pas de stade larvaire. Les grenouilles adultes ont généralement un régime carnivore à base de petits invertébrés, mais il existe des espèces omnivores et certaines mangent des fruits. Les grenouilles sont extrêmement efficaces pour convertir ce qu\'elles mangent en biomasse formant une ressource alimentaire majeure pour des prédateurs secondaires, leur donnant ainsi le rôle de clé de voûte du réseau trophique d\'un grand nombre d\'écosystèmes de la planète.

Leur peau semi-perméable les rendant sensibles à la déshydratation, leur habitat est le plus souvent humide, mais certains ont connu une profonde adaptation à des habitats secs. Les grenouilles ont une riche gamme de cris et chants, en particulier à l\'époque de la reproduction, ainsi qu\'une large palette de comportements sophistiqués pour communiquer entre eux ou se débarrasser d\'un prédateur.

Les populations de grenouilles ont considérablement diminué partout dans le monde depuis les années 1950. Plus d\'un tiers des espèces sont considérées comme menacées d\'extinction et plus de 120 sont soupçonnées d\'avoir disparu depuis les années 1980. Le nombre de malformations chez les grenouilles est à la hausse et une maladie fongique émergente, la chytridiomycose, s\'est propagée dans le monde entier. Les spécialistes de la conservation des espèces cherchent les causes de ces problèmes. Les grenouilles sont consommées par les humains et ont aussi une place notable dans la culture à travers la littérature, le symbolisme et la religion.'),
('zh_CN', 'textDocuments', 1, 'text', '无尾目（学名：Anura）是属于两生纲的动物，成体基本无尾，卵一般产于水中，孵化成蝌蚪，用鰓呼吸，经过变态，成体主要用肺呼吸，但多数皮肤也有部分呼吸功能。无尾目是生物从水中走上陆地的第一步，比其他两生纲生物要先进，虽然多数已经可以离开水生活，但繁殖仍然离不开水，卵需要在水中经过变态才能成长。因此不如爬行纲动物先进，爬行纲动物已经可以完全离开水生活。'),
('fr_CA', 'textDocuments', 2, 'text', 'Je pense que je ne verrais jamais,
Un poème aussi beau qu’un arbre.

Un arbre dont la bouche affamée se presse
Contre les entrailles douces et généreuses de la terre;

Un arbre qui sans répit contemple Dieu,
Et étend ses bras de feuilles en prière;

Un arbre qui en été peut porter
Un nid d’oiseaux dans ses cheveux;

La neige se couche dans son sein;
Et il connaît l’intimité de la pluie.

Les poèmes sont écrits par des idiots comme moi,
Mais Dieu seul peut créer un arbre.'),
('zh_CN', 'textDocuments', 2, 'text', '我想我永远不会看到
一首可爱的诗作为一棵树。

一棵饥肠辘辘的树
对着地球甜美流动的乳房;

一棵树，整天看着上帝，
并举起她多叶的手臂祈祷;

可能在夏天穿的树
她头发里有一群知更鸟;

他的怀抱已经落下了;
谁与雨密切相处。

诗歌是由像我这样的傻瓜制作的，
但只有上帝才能造树。');

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

ALTER TABLE `i18n`
  ADD UNIQUE KEY `I18N_LOCALE_FIELD` (`locale`,`model`,`foreign_key`,`field`),
  ADD KEY `I18N_FIELD` (`model`,`foreign_key`,`field`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

