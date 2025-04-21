-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 14 avr. 2025 à 16:20
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `entremoucheurs`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `is_flagged` tinyint(1) DEFAULT NULL,
  `spot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `media_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `credit` varchar(255) NOT NULL,
  `type` enum('image','video') NOT NULL DEFAULT 'image',
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `spot_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`media_id`, `file_path`, `credit`, `type`, `uploaded_at`, `updated_at`, `spot_id`) VALUES
(5, 'spot_67f3c052008b69.95911304.jpg', 'Quang Nguyen Vinh / Pexels', 'image', '2025-04-07 14:08:50', '2025-04-07 14:08:50', 14),
(6, 'spot_67f3c4fc4a32f8.36485453.jpg', 'Ian Turnell / Pexels', 'image', '2025-04-07 14:28:44', '2025-04-07 14:28:44', 15),
(7, 'spot_67f3d39b3f1620.69846012.jpg', 'Lisa / Pexels', 'image', '2025-04-07 15:31:07', '2025-04-07 15:31:07', 16),
(8, 'spot_67f518ca0293d6.54408208.jpg', 'Mabel Amber / Zifeng Xia / Pexels', 'image', '2025-04-08 14:38:34', '2025-04-08 14:38:34', 17),
(9, 'spot_67f518ca02fbf9.46096377.jpg', 'Mabel Amber / Zifeng Xia / Pexels', 'image', '2025-04-08 14:38:34', '2025-04-08 14:38:34', 17),
(10, 'spot_67f51beb5cc430.81435722.jpg', 'Mark Stebnicki / Pexels', 'image', '2025-04-08 14:51:55', '2025-04-08 14:51:55', 18),
(11, 'spot_67f51d0397a793.26804304.jpg', 'János Csatlós / Pexels', 'image', '2025-04-08 14:56:35', '2025-04-08 14:56:35', 19),
(12, 'spot_67f51df8b957d1.80432736.jpg', 'Matteo Badini / Pexels', 'image', '2025-04-08 15:00:40', '2025-04-08 15:00:40', 20),
(13, 'spot_67f51ed1bce8a8.17683427.jpg', 'Dom Gould / Pexels', 'image', '2025-04-08 15:04:17', '2025-04-08 15:04:17', 21),
(14, 'spot_67f51ff8420cb5.21049445.jpg', 'Josh Hild', 'image', '2025-04-08 15:09:12', '2025-04-08 15:09:12', 22),
(15, 'spot_67f52134ec2ed4.76068676.jpg', 'Dominik Gawlik / Pexels', 'image', '2025-04-08 15:14:28', '2025-04-08 15:14:28', 23),
(16, 'spot_67f5220209f582.15888883.jpg', 'Arti Kh / Pexels', 'image', '2025-04-08 15:17:54', '2025-04-08 15:17:54', 24),
(17, 'spot_67f522bd3665f9.66371329.jpg', 'Marta Wave / Pexels', 'image', '2025-04-08 15:21:01', '2025-04-08 15:21:01', 25),
(18, 'spot_67f5234918d0b9.06975263.jpg', 'Masood Aslami / Pexels', 'image', '2025-04-08 15:23:21', '2025-04-08 15:23:21', 26),
(19, 'spot_67f52459bbf408.23468306.jpg', 'Rafael Minguet Delgado / Pexels', 'image', '2025-04-08 15:27:53', '2025-04-08 15:27:53', 27),
(20, 'spot_67f525740c0d81.28209516.jpg', 'Enric Cruz López / Diego Murcia / KSPhoto / Pexels', 'image', '2025-04-08 15:32:36', '2025-04-08 15:32:36', 28),
(21, 'spot_67f525740c7529.50424493.jpg', 'Enric Cruz López / Diego Murcia / KSPhoto / Pexels', 'image', '2025-04-08 15:32:36', '2025-04-08 15:32:36', 28),
(22, 'spot_67f525740cb304.12057886.jpg', 'Enric Cruz López / Diego Murcia / KSPhoto / Pexels', 'image', '2025-04-08 15:32:36', '2025-04-08 15:32:36', 28);

-- --------------------------------------------------------

--
-- Structure de la table `spot`
--

CREATE TABLE `spot` (
  `spot_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `department` varchar(100) NOT NULL,
  `latitude` decimal(10,6) NOT NULL,
  `longitude` decimal(10,6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `spot`
--

INSERT INTO `spot` (`spot_id`, `name`, `description`, `department`, `latitude`, `longitude`, `created_at`, `updated_at`, `user_id`) VALUES
(14, 'Les Saumons de la Laïta', 'La laïta propose un super cadre pour la pêche du saumon atlantique. On y trouve de beaux spécimens, le courant est modéré. Possibilité de pique niquer en bord de rivière.', 'Morbihan', 47.841190, -3.533343, '2025-04-07 14:08:49', '2025-04-08 11:29:51', 7),
(15, 'Les Berges de la Loue', 'Un spot en pleine nature, parfait pour la pêche à la mouche. Courant léger, truites farouches et ombres communs abondants. À éviter les week-ends trop fréquentés.', 'Doubs', 47.068652, 5.864220, '2025-04-07 14:28:44', '2025-04-07 14:33:40', 9),
(16, 'Les Remous de Cesson', 'Un bras discret de la Vilaine, aux eaux calmes mais profondes. Parfait pour les mouches sèches au lever du soleil. Accessible à pied, idéal pour les amateurs de pêche urbaine.', 'Ille-et-Vilaine', 48.044245, -1.768653, '2025-04-07 15:31:07', '2025-04-07 15:31:07', 9),
(17, 'Les Cascades de la Dourbie', 'Nichée entre gorges et plateaux, la Dourbie abrite des truites fario vives et méfiantes. L’eau y est claire, les lancers précis récompensés. Idéal pour les amateurs de pêche en torrent.', 'Aveyron', 44.063255, 3.301158, '2025-04-08 14:38:34', '2025-04-08 14:46:19', 10),
(18, 'Les Remous de la Seille', 'Cette rivière lente et sinueuse accueille de beaux chevaines et des vandoises. Les coups du soir sont fabuleux, notamment en été quand les insectes virevoltent en surface.', 'Jura', 46.657410, 5.259638, '2025-04-08 14:51:55', '2025-04-08 14:51:55', 11),
(19, 'Les Radiers du Lot', 'Le Lot, large et majestueux, cache sous ses radiers des truites solides et quelques ombres sur les zones calmes. Magnifique au lever du jour.', 'Lot', 44.535007, 1.973290, '2025-04-08 14:56:35', '2025-04-08 14:56:35', 12),
(20, 'Les Rochers de la Têt', 'Torrent de montagne, la Têt offre des eaux fraîches et limpides. Idéale pour pêcher la truite en petite nymphe ou sèche dans ses vasques rocheuses.', 'Pyrénées-Orientales', 42.634778, 2.442497, '2025-04-08 15:00:40', '2025-04-08 15:00:40', 13),
(21, 'Les Veines de la Loue', 'Spot emblématique de la pêche à la mouche. Des truites fario magnifiques et des ombres puissants dans une rivière cristalline, technique mais mythique.', 'Doubs', 47.008599, 5.563565, '2025-04-08 15:04:17', '2025-04-08 15:04:17', 14),
(22, 'Le Méandre de la Gervanne', 'Petite rivière vive aux eaux froides, la Gervanne est un terrain de jeu délicat. Truites discrètes mais présentes dans chaque courant.', 'Drôme', 44.812259, 5.180965, '2025-04-08 15:09:12', '2025-04-08 15:09:12', 15),
(23, 'Les Plats de l’Ain', 'Grande rivière du Jura, idéale pour la nymphe à l’espagnole. De beaux ombres s\'y promènent entre les herbiers, avec aussi de très belles farios.', 'Ain', 46.294162, 5.579391, '2025-04-08 15:14:28', '2025-04-08 15:14:28', 16),
(24, 'Les Ombres de la Risle', 'Courant lent, eaux froides et présence régulière d’ombres. Les herbiers abritent aussi des truites malignes. Spot normand paisible et efficace.', 'Eure', 49.103351, 0.747859, '2025-04-08 15:17:54', '2025-04-08 15:17:54', 17),
(25, 'Les Berges de la Vézère', 'Courants marqués et berges boisées : on y traque les truites au fil de l’eau. En été, les éclosions de sedges sont spectaculaires.', 'Corrèze', 45.260821, 1.455295, '2025-04-08 15:21:01', '2025-04-08 15:21:01', 18),
(26, 'Les Gorges de la Cère', 'Belle rivière montagnarde avec des truites robustes. Accès parfois sportif, mais les zones calmes abritent des poissons méfiants.', 'Cantal', 44.977185, 2.157683, '2025-04-08 15:23:21', '2025-04-08 15:23:21', 18),
(27, 'Les Sources de l’Alagnon', 'Affluent de l’Allier, l’Alagnon est discret mais regorge de truites fario sur ses zones hautes. Idéal pour les amateurs de pêche légère.', 'Haute-Loire', 45.222199, 3.108343, '2025-04-08 15:27:53', '2025-04-08 15:27:53', 19),
(28, 'Les Herbiers de la Sorgue', 'La Sorgue est limpide, technique, magnifique. Pêcher à vue dans les herbiers est une vraie leçon de finesse. Truites méditerranéennes au look sauvage.', 'Vaucluse', 43.961859, 5.002919, '2025-04-08 15:32:36', '2025-04-08 15:32:36', 19);

-- --------------------------------------------------------

--
-- Structure de la table `_user`
--

CREATE TABLE `_user` (
  `user_id` int(11) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `_user`
--

INSERT INTO `_user` (`user_id`, `pseudo`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(3, 'SuperAdmin', 'admin@demo.com', '$2y$10$KJJWIAZe78auw3GYZD6tDOxruYlRAVYtW8kDZB1zD5aqzil.uex5i', 'admin', '2025-03-29 12:46:30', '2025-03-29 12:46:30'),
(6, 'Voiture', 'vroovroom@gmail.com', '$2y$10$G5JjrpQvzKZdhjjiTSWglOxShEGdAKSHbRht0y/wDwV2.92eZgsqS', 'user', '2025-03-31 12:02:05', '2025-03-31 15:32:57'),
(7, 'DAGREATEST', 'maxencegiard@goat.com', '$2y$10$zzaVrYSrrtYjNxUEw1XhB.Jlg6NEtAPUvNTKF.RwwLf8DiEA..c1S', 'user', '2025-03-31 16:25:16', '2025-04-14 10:55:22'),
(8, 'Lol', 'max@test.com', '$2y$10$jQxrQjj6EdlJEpz6ijCoF.oeud5HCObcoqE5/HodMABLy0.lCclXO', 'user', '2025-04-01 08:42:53', '2025-04-01 08:43:45'),
(9, 'Pol le Poulpe', 'test@demo.com', '$2y$10$rgRuUaNBfknxkOB1xM8eceXpCgr1akejetY60vGaXgz2S8SamCpiS', 'user', '2025-04-07 14:23:17', '2025-04-09 11:25:23'),
(10, 'AlineD', 'aline.durand@example.com', '$2y$10$UgHZRlFRGP43GCyK8QvVZeK07yxtU3x/s4SazWSDkXCrOTlJJO3Ne', 'user', '2025-04-08 14:25:39', '2025-04-08 14:25:39'),
(11, 'MaxiFish', 'maxime.lefevre@example.com', '$2y$10$adF1MqC9QB0tJEmqk86bwu5yS6f6lekauGAcNcnefBvmnwtBHKGZu', 'user', '2025-04-08 14:44:14', '2025-04-08 14:44:14'),
(12, 'Clairette', 'claire.bernard@example.com', '$2y$10$TJdPL0xP/T1fCcpsZmMVEOtOeV4GYWRYX0W8MpqV62R3RNZsDZ20.', 'user', '2025-04-08 14:53:19', '2025-04-08 14:53:19'),
(13, 'JulienD', 'julien.dupont@example.com', '$2y$10$b7gmi8ce8f4EDRHaXHTzOe9SOiLMg39gVBXGygKcSjhLsFwV6c5um', 'user', '2025-04-08 14:57:34', '2025-04-08 14:57:34'),
(14, 'Rochette', 'emma.roche@example.com', '$2y$10$QHbDYmkcvWZFx2aee0Q7FOwPI4mwKkgQvwgTJFU30ltMNoJpgB416', 'user', '2025-04-08 15:02:00', '2025-04-08 15:02:00'),
(15, 'LuluMouche', 'lucas.martin@example.com', '$2y$10$wVS1uN0MEoVFhCk0AT8o9.wYNkOCyFZ2lpH7EtGsTOQFMbSPt0dzy', 'user', '2025-04-08 15:06:16', '2025-04-08 15:06:16'),
(16, 'LauMore', 'laura.moreau@example.com', '$2y$10$Zywb9AqAw8sEkFfiZIUiquNhf8LimVMceMEpzJuVZciwpTZz02mA6', 'user', '2025-04-08 15:12:04', '2025-04-08 15:12:04'),
(17, 'TomPêche', 'thomas.petit@example.com', '$2y$10$uDr1hffCdwPnC3hwm.aOueI1cBMBpeg.fRJTwykgLSvjfYzHufr7S', 'user', '2025-04-08 15:15:29', '2025-04-08 15:15:29'),
(18, 'CamTruite', 'camille.blanc@example.com', '$2y$10$.B4Ij3IkptveKasVMYHroOXtsw4J24gMf5KpyRQc.0XDvRaqY0xMS', 'user', '2025-04-08 15:18:47', '2025-04-08 15:18:47'),
(19, 'NicoF', 'nicolas.faure@example.com', '$2y$10$TzuBYqj9ftcdENF2QEeHnOnDGYDNt5.TnqwBwVDHoolnp2KmyWPTK', 'user', '2025-04-08 15:25:12', '2025-04-08 15:25:12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `spot_id` (`spot_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `spot_id` (`spot_id`);

--
-- Index pour la table `spot`
--
ALTER TABLE `spot`
  ADD PRIMARY KEY (`spot_id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `_user`
--
ALTER TABLE `_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `pseudo` (`pseudo`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `spot`
--
ALTER TABLE `spot`
  MODIFY `spot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `_user`
--
ALTER TABLE `_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_spot` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`spot_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `_user` (`user_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `fk_media_spot` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`spot_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `spot`
--
ALTER TABLE `spot`
  ADD CONSTRAINT `fk_spot_user` FOREIGN KEY (`user_id`) REFERENCES `_user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
