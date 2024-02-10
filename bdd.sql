-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 10 fév. 2024 à 12:28
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
-- Base de données : `marvel_fans`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `published_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `characters`
--

CREATE TABLE `characters` (
  `character_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `comics_appeared_in` int(11) DEFAULT NULL,
  `superpowers` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `posted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
  `option_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`option_id`, `question_id`, `option_text`, `is_correct`) VALUES
(89, 1, 'Wanda Maximoff', 1),
(90, 1, 'Natasha Romanoff', 0),
(91, 1, 'Monica Rambeau', 0),
(92, 1, 'Carol Danvers', 0),
(93, 2, 'La Pierre de l\'Esprit', 1),
(94, 2, 'La Pierre du Temps', 0),
(95, 2, 'La Pierre de l\'Espace', 0),
(96, 2, 'La Pierre de la Réalité', 0),
(97, 3, 'Pietro Maximoff', 1),
(98, 3, 'Victor Maximoff', 0),
(99, 3, 'John Maximoff', 0),
(100, 3, 'Tony Stark', 0),
(101, 4, 'Stephen Strange', 1),
(102, 4, 'Stephen Vincent', 0),
(103, 4, 'Steven Rogers', 0),
(104, 4, 'Stephen Vincent Strange', 0),
(105, 5, 'L’Œil d’Agamotto', 1),
(106, 5, 'Le Sceptre', 0),
(107, 5, 'Le Tesseract', 0),
(108, 5, 'Le Mjolnir', 0),
(109, 6, 'L’Ancien', 1),
(110, 6, 'Wong', 0),
(111, 6, 'Baron Mordo', 0),
(112, 6, 'Karl Mordo', 0),
(113, 7, 'Tony Stark', 1),
(114, 7, 'Steve Rogers', 0),
(115, 7, 'Bruce Banner', 0),
(116, 7, 'Peter Parker', 0),
(117, 8, 'Robert Downey Jr.', 1),
(118, 8, 'Chris Evans', 0),
(119, 8, 'Mark Ruffalo', 0),
(120, 8, 'Tom Holland', 0),
(121, 9, 'James Rhodes', 1),
(122, 9, 'Clint Barton', 0),
(123, 9, 'Scott Lang', 0),
(124, 9, 'Sam Wilson', 0),
(125, 10, 'Stark Industries', 1),
(126, 10, 'Pym Technologies', 0),
(127, 10, 'Oscorp Industries', 0),
(128, 10, 'Hammer Industries', 0),
(129, 11, 'Captain America', 1),
(130, 11, 'Black Widow', 0),
(131, 11, 'Hulk', 0),
(132, 11, 'Hawkeye', 0),
(133, 12, 'Obadiah Stane', 1),
(134, 12, 'Loki', 0),
(135, 12, 'Ultron', 0),
(136, 12, 'Thanos', 0),
(137, 13, 'Thor', 1),
(138, 13, 'The Dark World', 0),
(139, 13, 'Ragnarok', 0),
(140, 13, 'Love and Thunder', 0),
(141, 14, 'Frigga', 1),
(142, 14, 'Sif', 0),
(143, 14, 'Jane Foster', 0),
(144, 14, 'Hela', 0);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`post_id`, `topic_id`, `user_id`, `content`, `created_at`) VALUES
(3, 5, 17, 'bonjour\r\n', '2024-01-07 19:30:46'),
(4, 6, 17, 'Bonjour tout le monde \r\n', '2024-01-07 19:37:05'),
(5, 9, 17, 'RAYANEE', '2024-02-09 15:35:05');

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `correct_answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`question_id`, `quiz_id`, `question_text`, `correct_answer`) VALUES
(1, 1, 'Quel est le vrai nom de la Sorcière Rouge?', 'Wanda Maximoff'),
(2, 1, 'Avec quel Infinity Stone les pouvoirs de Wanda sont-ils liés?', 'La Pierre de l’Esprit'),
(3, 1, 'Qui est le frère jumeau de Wanda Maximoff?', 'Pietro Maximoff'),
(4, 2, 'Quel est le vrai nom de Doctor Strange?', 'Stephen Strange'),
(5, 2, 'Quel objet Doctor Strange utilise-t-il pour manipuler le temps?', 'L’Œil d’Agamotto'),
(6, 2, 'Qui est l’ancien mentor de Doctor Strange?', 'L’Ancien'),
(7, 3, 'Quelle est l\'identité secrète d\'Iron Man?', 'Tony Stark'),
(8, 3, 'Quel acteur joue Iron Man dans l\'Univers Cinématographique Marvel?', 'Robert Downey Jr.'),
(9, 3, 'Quel est le nom du meilleur ami d\'Iron Man, qui devient aussi War Machine?', 'James Rhodes'),
(10, 3, 'Quel est le nom de l\'entreprise fondée par la famille Stark?', 'Stark Industries'),
(11, 4, 'Quel autre Avenger partage une grande amitié avec Thor?', 'Captain America'),
(12, 4, 'Qui est le principal méchant dans le premier film de Thor?', 'Obadiah Stane'),
(13, 4, 'Dans quel film Thor apparaît-il pour la première fois dans l\'Univers Cinématographique Marvel?', 'Thor'),
(14, 4, 'Comment s\'appelle la mère de Thor?', 'Frigga');

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `quiz_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `difficulty` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`quiz_id`, `title`, `description`, `difficulty`, `image_path`, `created_at`) VALUES
(1, 'Le Monde de Wanda Maximoff', 'Découvrez l’histoire et les pouvoirs de Wanda Maximoff, la Sorcière Rouge.', 'Moyen', 'public/images/wanda.png', '2024-01-13 14:17:33'),
(2, 'Les Mystères de Doctor Strange', 'Plongez dans l’univers mystique de Doctor Strange et son parcours.', 'Difficile', 'public/images/strange.png', '2024-01-13 14:17:33'),
(3, 'L’Épopée d’Iron Man', 'Explorez les aventures et l’évolution technologique de Tony Stark, alias Iron Man.', 'Moyen', 'public/images/tony.png', '2024-01-28 12:35:47'),
(4, 'Les Légendes de Thor', 'Voyagez à travers les mythes et les batailles de Thor, le Dieu du Tonnerre.', 'Difficile', 'public/images/thor.png', '2024-01-28 12:35:47');

-- --------------------------------------------------------

--
-- Structure de la table `results`
--

CREATE TABLE `results` (
  `result_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `quiz_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `results`
--

INSERT INTO `results` (`result_id`, `user_id`, `quiz_id`, `score`, `quiz_date`) VALUES
(1, 17, 3, 400, '2024-02-10 11:28:07'),
(2, 17, 1, 100, '2024-02-08 13:27:31'),
(3, 17, 2, 200, '2024-02-10 11:26:12'),
(4, 17, 4, 400, '2024-02-10 11:28:22');

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `movie_series_title` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `rating` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`review_id`, `movie_series_title`, `review`, `rating`, `user_id`, `created_at`) VALUES
(7, 'Wand', 'blabla', 3, 17, '2024-01-07 19:30:18'),
(8, 'End game', 'Franchement c\'etait guez', 4, 17, '2024-01-07 19:36:30'),
(9, 'Selim vs SKG sur rust', 'guez', 4, 17, '2024-01-08 17:16:54'),
(10, 'Wand', 'rara', 5, 17, '2024-01-08 18:30:32'),
(11, 'Iron man 4', 'pas fou', 3, 17, '2024-02-08 13:30:06'),
(12, 'Test', 'rararar', 5, 17, '2024-02-09 15:35:30');

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`topic_id`, `title`, `user_id`, `created_at`) VALUES
(5, 'Lol', 17, '2024-01-07 19:30:41'),
(6, 'Wanda vs Wonderwoman', 17, '2024-01-07 19:36:59'),
(7, 'On va parler du downfall de l\'ARS', 17, '2024-01-08 17:17:09'),
(8, 'razra', 17, '2024-01-08 18:30:46'),
(9, 'Rayane', 17, '2024-02-09 15:35:01');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0,
  `avatar_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `created_at`, `is_admin`, `avatar_path`) VALUES
(17, 'Rayane', 'Salahabed3@gmail.com', '$2y$10$ZapTLpz.EXcdszDTilo6QOqI6W9bSUPK7onDsYJJ54LTF4Qwn8RFq', '2024-01-07 19:29:19', 1, 'public/images/Ironman.png'),
(19, 'Slimane95210', 'rayaneabed@gmail.com', '$2y$10$WCCcaSzKXl/GjsqP8O377eHi3QC4wRj3MlgRen9pWqYfkTGIG7OCm', '2024-01-28 12:43:50', 0, 'public/images/Captainamerica.png'),
(20, 'Raniny', 'salahabed033@gmail.com', '$2y$10$.MZ8AWJkCy/yrOqgas5WPuYmio1CRH1P0blXbZLl8E8NHkfReSFmy', '2024-02-09 15:37:53', 0, 'public/images/Ironman.png'),
(21, 'rzarzara', 'popo@gmail.com', '$2y$10$BF2zJgIT4wlCBCSONVRg5u3ABjZ4SObfmF01xP.UZQ8eq1022Bu3m', '2024-02-09 23:42:49', 0, ''),
(22, 'popo@gmail.com', 'portehaciz55@gmail.com', '$2y$10$wfg2i/WnTKq8Cx6.2Ny6sO.mp3G5ObppuvD3ji74cD9.PsKoH2Zdi', '2024-02-09 23:46:58', 0, ''),
(23, 'AZRAZRZARZAR', 'REATRA@GMAIL.COM', '$2y$10$EtvavoaG7BWZNT.IEdch7eLsRTE4spyr9Tys.QXT7zi5zCCsMaONS', '2024-02-09 23:51:37', 0, ''),
(24, 'Salahabed333@gmail.com', 'Salahabed333@gmail.com', '$2y$10$RpjlFqy3vimPz7AFKVO9aOlXiB0iJmsbq3fotoQkzz4ivjqMSxxly', '2024-02-10 00:20:16', 0, 'public/images/Venom.png'),
(25, 'Salahabed333@gmail.com', 'Salahabed333@gmail.com', '$2y$10$QKUV7U36OJKWqKpbj/w1T.xx0XCq76WW8/FHHgmEkzyLM3OAzNE66', '2024-02-10 00:20:25', 0, 'public/images/Venom.png'),
(26, 'Salahabed333@gmail.com', 'Salahabed333@gmail.com', '$2y$10$b0nsOIYjII4enhbYwDL02e8DWhMmLhmYe0vMoO2HGNBRqJt0.O/AW', '2024-02-10 00:21:27', 0, 'public/images/Captainamerica.png'),
(27, 'blabla', 'portehacizz@gmail.com', '$2y$10$XMjWCLJdCO7QM7l55b3rCeHf7/NnIoolKlIUBHme.EztPXLf0tB.W', '2024-02-10 00:28:00', 0, 'public/images/Wolverine.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`character_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `posts_ibfk_1` (`topic_id`),
  ADD KEY `posts_ibfk_2` (`user_id`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Index pour la table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `characters`
--
ALTER TABLE `characters`
  MODIFY `character_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `options`
--
ALTER TABLE `options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `results`
--
ALTER TABLE `results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`);

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Contraintes pour la table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`quiz_id`);

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
