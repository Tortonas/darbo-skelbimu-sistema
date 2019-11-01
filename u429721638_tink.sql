-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2019 at 03:21 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u429721638_tink`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `description` varchar(1000) NOT NULL,
  `text` text NOT NULL,
  `salary` int(11) DEFAULT NULL,
  `valid_till` date NOT NULL,
  `fk_user` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `hidden` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `title`, `description`, `text`, `salary`, `valid_till`, `fk_user`, `type`, `hidden`) VALUES
(1, 'Petras Petriukas', 'Esu C# programuotojas. Ieskau praktikos.', 'Esu C# programuotojas. Ieskau praktikos.', 500, '2019-11-15', 3, 1, 0),
(2, 'Hostinger', 'Firma Hostinger iesko Customer Success Agent pozicijos darbuotoju', 'Firma Hostinger iesko Customer Success Agent pozicijos darbuotoj?', 500, '2019-12-14', 3, 2, 0),
(4, 'Devbridge', 'Firma Devbridge iesko Java programuotojo pozicijos darbuotojo', 'Firma Devbridge iesko Java programuotojo pozicijos darbuotojo', 3000, '2019-12-06', 3, 2, 0),
(5, 'Valymas24', 'Firma Valymas iesko valytoju', 'Firma Valymas iesko valytoju.', 700, '2019-11-30', 3, 2, 0),
(6, 'Jonas Jonaitis', 'Esu profesionalus virÄ—jas. IeÅ¡kau Å¡efo pozicijos.', 'Turiu daug metu patirties.', 700, '2020-01-01', 3, 1, 0),
(8, 'Adform', 'Adform ieÅ¡ko SEO specialisto.', 'Adform iesko SEO specialisto. 10 metu patirties.', 1000, '2020-01-01', 3, 2, 0),
(9, 'Unity', 'UAB `Unity` ieÅ¡ko QA specialisto.', 'UAB `Unity` ieÅ¡ko QA specialisto. BÅ«tina 3 metÅ³ patirtis bei automatiniÅ³ testÅ³ raÅ¡ymas.', 600, '2020-01-01', 6, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ad_comments`
--

CREATE TABLE `ad_comments` (
  `id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `fk_ad` int(11) NOT NULL,
  `date` date NOT NULL,
  `fk_user` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_comments`
--

INSERT INTO `ad_comments` (`id`, `text`, `fk_ad`, `date`, `fk_user`) VALUES
(1, 'Sveiki, galbut noretumete prisijungti prie Devbridge?', 1, '2019-11-01', 1),
(2, 'Dar domintu prisijungti prie adform?', 1, '2019-11-01', 3),
(3, 'Turiu 2 metÅ³ patirtÄ¯. AtsiunÄiau CV.', 8, '2019-11-01', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ad_views`
--

CREATE TABLE `ad_views` (
  `id` int(11) NOT NULL,
  `fk_ad` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_views`
--

INSERT INTO `ad_views` (`id`, `fk_ad`, `fk_user`) VALUES
(1, 1, 3),
(2, 1, 5),
(3, 2, 1),
(4, 8, 1),
(5, 4, 1),
(13, 9, 6),
(14, 9, 5),
(15, 8, 5),
(16, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `first_name` varchar(1000) NOT NULL,
  `last_name` varchar(1000) NOT NULL,
  `role` int(11) NOT NULL,
  `verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `role`, `verified`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$VvGwE6JQJLlwKFuY9YuSz.vLnpMAfnQoKAsyJMdoC2vzENrsSSCIW', 'Ponas', 'Administratorius', 3, 1),
(3, 'user', 'user@user.com', '$2y$10$vSRyak5Tt5tvG2LdkDWUzOoxhITpE4o5/rf9d9ieKsdDGd.k6kEEu', 'Petras', 'Jonaitis', 1, 1),
(4, 'user2', 'user2@gmail.com', '$2y$10$m4ABVQKj3EVtAs9m1u8g..kQg0I5DgHNDkGdSbh/J3bCCTxd/SRjO', 'Jonas', 'Darbietis', 1, 0),
(5, 'mod', 'mod@mod.com', '$2y$10$SwHRI2iQgOoHAkQV6QJ62.50IvJwUpVbq6qkRIqqtUr.BEkKvX.Be', 'Geras', 'Kontrolerius', 2, 1),
(6, 'valentinas', 'valentinas@kasteckis.lt', '$2y$10$g0RRJHvHqo4I3CJo2JaWReAaV6329aE.I.XcfhgFFifsAnRrfQpqi', 'Valentinas', 'Kasteckis', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ads_fk0` (`fk_user`);

--
-- Indexes for table `ad_comments`
--
ALTER TABLE `ad_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_comments_fk0` (`fk_ad`),
  ADD KEY `fk_user` (`fk_user`);

--
-- Indexes for table `ad_views`
--
ALTER TABLE `ad_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ad_views_fk0` (`fk_ad`),
  ADD KEY `ad_views_fk1` (`fk_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ad_comments`
--
ALTER TABLE `ad_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ad_views`
--
ALTER TABLE `ad_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_fk0` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `ad_comments`
--
ALTER TABLE `ad_comments`
  ADD CONSTRAINT `ad_comment_fk1` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ad_comments_fk0` FOREIGN KEY (`fk_ad`) REFERENCES `ads` (`id`);

--
-- Constraints for table `ad_views`
--
ALTER TABLE `ad_views`
  ADD CONSTRAINT `ad_views_fk0` FOREIGN KEY (`fk_ad`) REFERENCES `ads` (`id`),
  ADD CONSTRAINT `ad_views_fk1` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
