-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2021 at 01:48 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logiranje`
--

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `forum_id` int(11) NOT NULL,
  `forum_naziv` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `forum_opis` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `forum_naziv`, `forum_opis`) VALUES
(1, 'Vinogradarstvo', 'Ovo je forum posvećen korisnicima za razmjenu znanja o vinogradarstvu.'),
(2, 'Voćarstvo', 'Ovo je forum posvećen korisnicima za razmjenu znanja o voćarstvu.'),
(3, 'Vrtlarstvo', 'Ovo je forum posvećen korisnicima za razmjenu znanja o vrtlarstvu.');

-- --------------------------------------------------------

--
-- Table structure for table `forum_post`
--

CREATE TABLE `forum_post` (
  `post_id` int(11) NOT NULL,
  `post_naslov` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `post_autor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_body` text COLLATE utf8_unicode_ci NOT NULL,
  `post_tip` enum('o','r') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'o',
  `op_id` int(11) NOT NULL,
  `forum_naziv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forum_id` int(11) DEFAULT NULL,
  `post_vrijeme` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `forum_post`
--

INSERT INTO `forum_post` (`post_id`, `post_naslov`, `post_autor`, `post_body`, `post_tip`, `op_id`, `forum_naziv`, `forum_id`, `post_vrijeme`) VALUES
(2, 'Prvi post', 'Saša', 'Ovo je moj prvi post', 'o', 1, 'Prvi forum', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE `komentari` (
  `komentar_id` int(11) NOT NULL,
  `komentar_autor` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `komentar_text` text COLLATE utf8_unicode_ci NOT NULL,
  `komentar_vrijeme` date NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `komentari`
--

INSERT INTO `komentari` (`komentar_id`, `komentar_autor`, `komentar_text`, `komentar_vrijeme`, `post_id`) VALUES
(1, 'Sa&scaron;a', 'Ovo je prvi komentar', '0000-00-00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `korisnik` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lozinka` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prava` int(11) DEFAULT NULL,
  `vrijeme_reg` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnik`, `lozinka`, `avatar`, `prava`, `vrijeme_reg`, `dob`) VALUES
(1, 'Sa&scaron;a', '$2y$10$jusMhLi7spJCrxzz7lHBPesLyqDfLkgocTZ/2CeTYRWZvN7LbhpI6', 'Saša_jpg1.jpg', NULL, NULL, NULL),
(2, 'Matija', '$2y$10$j5x7EPIOzOwt2GF2FYO35OUdYa1CkMMKBHZh3nCMyYJifocnMu4Qm', 'WIN_20201210_15_52_24_Pro.jpg', NULL, NULL, NULL),
(3, 'admin', '$2y$10$jusMhLi7spJCrxzz7lHBPesLyqDfLkgocTZ/2CeTYRWZvN7LbhpI6', '124449019_3785568441475883_6085900675387424954_n0.jpg', 1111111111, NULL, NULL),
(4, 'DraftyCypres4', '$2y$10$JFW1am4RmYAN5t.x2nUBeOD1KrLUyFbWv40EXUHGrcqq7OWK36lWC', 'download0.jpg', NULL, NULL, NULL),
(5, 'Saša123', '$2y$10$PO5OhRT96jVZWlMm.qi3uOPlTz.CnUpY.aQ3kNeOOzs.SbJzB94gC', 'hudasasa.jpg', NULL, NULL, NULL),
(6, 'Marija', '$2y$10$jusMhLi7spJCrxzz7lHBPesLyqDfLkgocTZ/2CeTYRWZvN7LbhpI6', 'download0.jpg', NULL, '26.02.2021', '18.03.2000'),
(7, 'Marko', '$2y$10$jusMhLi7spJCrxzz7lHBPesLyqDfLkgocTZ/2CeTYRWZvN7LbhpI6', 'download0.jpg', NULL, '26.02.2021', '18.03.2000'),
(8, 'Andrija', '$2y$10$RJpEuDKnCsBUELsaKJmKiOcYk88dpl/tiJ6muHhR4nOaYQIawAjwy', 'image_2021-04-29_150325.png', NULL, '29.04.2021', '1999-04-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`forum_id`);

--
-- Indexes for table `forum_post`
--
ALTER TABLE `forum_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `komentari`
--
ALTER TABLE `komentari`
  ADD PRIMARY KEY (`komentar_id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `forum_post`
--
ALTER TABLE `forum_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `komentari`
--
ALTER TABLE `komentari`
  MODIFY `komentar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
