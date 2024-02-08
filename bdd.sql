-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 28 jan. 2024 à 13:46
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
(1, 1, 'Wanda Romanoff', 0),
(2, 1, 'Wanda Maximoff', 1),
(3, 1, 'Wanda Pym', 0),
(4, 1, 'Wanda Stark', 0),
(5, 2, 'La Pierre de l’Espace', 0),
(6, 2, 'La Pierre de l’Esprit', 1),
(7, 2, 'La Pierre de Réalité', 0),
(8, 2, 'La Pierre du Pouvoir', 0),
(9, 3, 'Pietro Maximoff', 1),
(10, 3, 'John Maximoff', 0),
(11, 3, 'Tony Stark', 0),
(12, 3, 'Victor Maximoff', 0),
(13, 4, 'Steven Rogers', 0),
(14, 4, 'Stephen Strange', 1),
(15, 4, 'Tony Stark', 0),
(16, 4, 'Bruce Banner', 0),
(17, 5, 'Le Sceptre', 0),
(18, 5, 'L’Œil d’Agamotto', 1),
(19, 5, 'La Cape de Lévitation', 0),
(20, 5, 'Le Mjolnir', 0),
(21, 6, 'Wong', 0),
(22, 6, 'L’Ancien', 1),
(23, 6, 'Baron Mordo', 0),
(24, 6, 'Dormammu', 0),
(41, 11, 'Hulk', 1),
(42, 11, 'Ant-Man', 0),
(43, 11, 'Black Widow', 0),
(44, 11, 'Hawkeye', 0),
(45, 12, 'Loki', 1),
(46, 12, 'Hela', 0),
(47, 12, 'Malekith', 0),
(48, 12, 'Laufey', 0),
(49, 13, 'Iron Man 2', 0),
(50, 13, 'Thor', 1),
(51, 13, 'The Avengers', 0),
(52, 13, 'Captain America: The First Avenger', 0),
(53, 14, 'Frigga', 1),
(54, 14, 'Sif', 0),
(55, 14, 'Jane Foster', 0),
(56, 14, 'Freya', 0);

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
(1, 4, 16, 'grthsryj', '2024-01-07 18:40:54'),
(2, 3, 16, 'zaadz', '2024-01-07 18:49:42'),
(3, 5, 17, 'bonjour\r\n', '2024-01-07 19:30:46'),
(4, 6, 17, 'Bonjour tout le monde \r\n', '2024-01-07 19:37:05');

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
(11, 3, 'Quelle est l\'identité secrète d\'Iron Man?', ''),
(12, 3, 'Quel acteur joue Iron Man dans l\'Univers Cinématographique Marvel?', ''),
(13, 3, 'Quel est le nom du meilleur ami d\'Iron Man, qui devient aussi War Machine?', ''),
(14, 3, 'Quel est le nom de l\'entreprise fondée par la famille Stark?', ''),
(15, 4, 'Quel autre Avenger partage une grande amitié avec Thor?', ''),
(16, 4, 'Qui est le principal méchant dans le premier film de Thor?', ''),
(17, 4, 'Dans quel film Thor apparaît-il pour la première fois dans l\'Univers Cinématographique Marvel?', ''),
(18, 4, 'Comment s\'appelle la mère de Thor?', '');

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
(5, 'Avengers : Endgame', 'Grave nul', 1, 16, '2024-01-07 18:47:13'),
(6, 'Iron man 3', 'Pas ouf', 2, 16, '2024-01-07 18:48:08'),
(7, 'Wand', 'blabla', 3, 17, '2024-01-07 19:30:18'),
(8, 'End game', 'Franchement c\'etait guez', 4, 17, '2024-01-07 19:36:30'),
(9, 'Selim vs SKG sur rust', 'guez', 4, 17, '2024-01-08 17:16:54'),
(10, 'Wand', 'rara', 5, 17, '2024-01-08 18:30:32');

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
(1, 'avengers', 16, '2024-01-07 17:42:03'),
(2, 'zizi', 16, '2024-01-07 17:46:15'),
(3, 'iop', 16, '2024-01-07 17:50:45'),
(4, 'hetrhrt', 16, '2024-01-07 18:40:51'),
(5, 'Lol', 17, '2024-01-07 19:30:41'),
(6, 'Wanda vs Wonderwoman', 17, '2024-01-07 19:36:59'),
(7, 'On va parler du downfall de l\'ARS', 17, '2024-01-08 17:17:09'),
(8, 'razra', 17, '2024-01-08 18:30:46');

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
(16, 'bibot', 'bibot@gmail.com', '$2y$10$7NGkZLzfrS8bCpzUGD0B7eUqByXFA7R.SdDPDmhRZd95gI.wSxw6S', '2024-01-07 17:23:20', 0, 'public/ironman.png'),
(17, 'Rayane', 'salahabed3@gmail.com', '$2y$10$WUS4cluwFHoFF4Qco3XlpuKU/qEz.zjDTvciPQ16DKUUXr1G8o9tC', '2024-01-07 19:29:19', 0, 'public/spiderman.png'),
(18, 'Flash_le_plus_rapide', 'cesmoilemeilleur@gmail.com', '$2y$10$H1pGfUcnrgBKagj9cLBD.eeJBDewr4AOaC84H2iIv4Qrfg5D8EDXK', '2024-01-07 19:35:30', 0, 'public/the-flash.png'),
(19, 'Slimane95210', 'rayaneabed@gmail.com', '$2y$10$WCCcaSzKXl/GjsqP8O377eHi3QC4wRj3MlgRen9pWqYfkTGIG7OCm', '2024-01-28 12:43:50', 0, 'public/images/Captainamerica.png');

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
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
