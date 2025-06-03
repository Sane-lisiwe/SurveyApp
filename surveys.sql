-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 11:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surveydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `likes_pizza` tinyint(1) DEFAULT 0,
  `likes_pasta` tinyint(1) DEFAULT 0,
  `likes_pap_and_wors` tinyint(1) DEFAULT 0,
  `likes_other` tinyint(1) DEFAULT 0,
  `rating_movies` int(11) NOT NULL CHECK (`rating_movies` between 1 and 5),
  `rating_radio` int(11) NOT NULL CHECK (`rating_radio` between 1 and 5),
  `rating_eat_out` int(11) NOT NULL CHECK (`rating_eat_out` between 1 and 5),
  `rating_tv` int(11) NOT NULL CHECK (`rating_tv` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `full_name`, `email`, `date_of_birth`, `contact_number`, `age`, `likes_pizza`, `likes_pasta`, `likes_pap_and_wors`, `likes_other`, `rating_movies`, `rating_radio`, `rating_eat_out`, `rating_tv`, `created_at`) VALUES
(1, 'Sanelisiwe Khumalo', 'sanelisiwekhumalo.com', '2002-11-23', '0792093110', 34, 1, 0, 1, 0, 4, 3, 5, 2, '2025-05-29 21:00:50'),
(2, 'Siyamthanda Khumalo', 'siyamthandakhumalo.com', '2005-05-11', '0712345678', 39, 1, 1, 0, 0, 5, 4, 4, 3, '2025-05-29 21:00:50'),
(3, 'Sfiso Ndlovu', 'sfisondlovu.com', '2000-12-10', '0714007084', 24, 0, 1, 1, 1, 3, 2, 3, 4, '2025-05-29 21:00:50'),
(4, 'Ntandokazi Mavimbela', 'ntandokazi@gmail.com', '2008-07-22', '0792983110', 16, 1, 0, 0, 0, 1, 5, 2, 2, '2025-05-29 21:10:33'),
(5, 'Nqobile Nkutha', 'sanelisiwe1123@gmail.com', '2015-11-20', '0792983110', 10, 1, 0, 1, 0, 5, 4, 3, 1, '2025-05-29 21:18:12'),
(6, 'Rose Nkutha', 'sanelisiwe1123@gmail.com', '2002-06-19', '0792983110', 23, 0, 1, 0, 0, 5, 2, 2, 4, '2025-05-29 21:19:07'),
(7, 'Gift Ndlovu', 'giftndlovu@gmail.com', '1998-08-22', '0792983110', 27, 1, 1, 0, 0, 1, 3, 3, 1, '2025-06-02 23:24:39'),
(8, 'Gugulethu Khumalo', 'gugulethu012@gmail.com', '1999-03-07', '0792983110', 26, 1, 0, 0, 1, 1, 2, 1, 2, '2025-06-02 23:36:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
