-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 03:45 AM
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
-- Database: `pliris`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id_number` bigint(11) NOT NULL,
  `active_status_id` int(11) NOT NULL DEFAULT 1,
  `first_name` text NOT NULL,
  `middle_initial` varchar(1) NOT NULL,
  `last_name` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id_number`, `active_status_id`, `first_name`, `middle_initial`, `last_name`, `email`, `password`) VALUES
(999999999, 1, 'Bryan', 'A', 'Tamayo', 'bryan@gmail.com', '$2y$10$wVL6Zfh651X2dlhEzvFu5u/Y7P4j5TGiSOVZA/uizGrzO1HCy2RmO'),
(2023300076, 1, 'Nhem Day', 'G', 'Aclo', 'aclonhemday@gmail.com', '$2y$10$CVxtCY23xTkk3kV0h1Ym8.C6USOTmna99008FB8.IxRhmco0amI0i'),
(2023309879, 2, 'Chris', 'H', 'Toylo', 'chris@gmail.com', '$2y$10$5xLIzK8eFlXIzM1jcrSO2uOnDheP14d/yeacFuUjy2JaCln3QQiUO'),
(2023345345, 1, 'Errol', 'G', 'Dionson', 'ulollolskie@gmail.com', '$2y$10$ByuVxd7gUSCup8VkBSebOuNNqxqkA1UaxX.Y1RHJGZA2MfpwmvQsO'),
(2023367257, 1, 'Miyong', 'T', 'Sabuero', 'aclonhemday@gmail.com', '$2y$10$qvtVK42fHjvjGPQJtvzOV.6.SzJ/Tmg37nUVowW3TbfwQoZFaWjXS'),
(2023376897, 1, 'Kim Adam', 'K', 'Blacer', 'kimadam@gmail.com', '$2y$10$ngJ0vP2yT7lEG99uOzuvDueyRYHIPHaeJnlcnrbnspQo54txkwjAC'),
(2023390698, 1, 'Jaysa', 'J', 'Laguea', 'ulollolskie@gmail.com', '$2y$10$Ppj8rvM2xT.jincvdSjafuuQ2Fya1Okb5cZRr1pxHlOHexja8fG3G'),
(2023627838, 2, 'miyong', '', 'Aclo', 'ilove@gmail.com', '$2y$10$wsbqrSPBSolX2JtPxwxUwuus8Wc1BUxCRYk9vKzaNefcqDuyNJTQ2'),
(2023786347, 1, 'Mark', 'H', 'Libut', 'mark@gmail.com', '$2y$10$JW3UhQO5Fv.dZcfiUN1squ4xBLbG3KJu.JvGjDsaIFXa.GfE8HVry');

-- --------------------------------------------------------

--
-- Table structure for table `active_status`
--

CREATE TABLE `active_status` (
  `active_status_id` int(11) NOT NULL,
  `active_stat` enum('active','deleted') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `active_status`
--

INSERT INTO `active_status` (`active_status_id`, `active_stat`) VALUES
(1, 'active'),
(2, 'deleted');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `active_status_id` int(11) NOT NULL DEFAULT 1,
  `item_name` varchar(100) NOT NULL,
  `item_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `active_status_id`, `item_name`, `item_quantity`) VALUES
(15, 1, 'Calibration Weight', 1),
(18, 1, 'Conductivity of solutions Apparatus', 5),
(19, 1, 'Metal Pocket Compass', 2),
(20, 1, 'Triple Beam Balance', 2),
(21, 1, 'Calorometer', 2),
(22, 1, 'Electronic Multicolor Dynamic Trolly', 4),
(23, 1, 'Plano Phantom Pro Tackle Box', 1),
(24, 1, 'U-Shape Magnet', 3),
(25, 1, 'Decade Resistance Box', 4),
(26, 1, 'Electrostatic System', 4),
(27, 1, 'Sip Wire Rheostat Variable', 4),
(28, 1, 'Multimeter', 1),
(29, 1, 'Smart Timer', 1),
(30, 1, 'Centesimal Meter', 1),
(31, 1, 'Hookes Law', 1),
(32, 1, 'Electroscope', 1),
(33, 1, 'Density Set with  Overflow Can', 1),
(35, 1, 'Induction Coil', 3),
(36, 1, 'Force Table', 4),
(39, 1, 'Ammeter', 1),
(40, 2, 'Balco Meter Tulay', 0),
(78, 2, '', 0),
(79, 2, 'aatest2', 0),
(80, 2, 'aatest2', 0),
(81, 2, 'aatest2', 0),
(82, 2, 'aatest2', 0),
(83, 2, 'aatest2', 0),
(84, 2, 'aatest2', 0),
(85, 2, 'atry', 1),
(86, 2, 'atry', 1),
(87, 2, 'atry', 0),
(88, 2, 'atry', 0),
(89, 2, 'atry', 0),
(97, 2, 'Balco Meter Tulay', 0),
(98, 1, 'Balco Meter Bridge', 1),
(112, 2, 'saga', 5),
(113, 2, 'aa', 34),
(114, 2, 'addddd', 23),
(115, 2, 'awsdfg', 78);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `id_number` bigint(11) NOT NULL,
  `notification_status_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `id_number`, `notification_status_id`, `created_at`, `message`) VALUES
(765, 2023300076, 2, '2024-12-04 13:59:23', 'Return reminder: Calorometer is due for return on 2024-12-04 13:50:00'),
(766, 999999999, 2, '2024-12-04 14:03:30', 'Item shortage alert: Balco Meter Tulay has only 0 remaining in stock'),
(767, 2023300076, 2, '2024-12-04 14:08:14', 'Your reservation_status item Calorometer with the quantity of 2 is disapproved at Dec-04-2024 07:08:14:am. Please return the item/items or you can approach the moderator Mr/Maam: Bryan Tamayo.'),
(768, 2023300076, 2, '2024-12-04 14:10:29', 'Your reservation_status item Calorometer with the quantity of 2 is disapproved at Dec-04-2024 07:10:29:am. Please return the item/items or you can approach the moderator Mr/Maam: Bryan Tamayo.'),
(769, 2023300076, 2, '2024-12-04 14:11:23', 'Your reservation for 2 Calorometer(s) has been approved at Dec-04-2024 07:11:23:am'),
(770, 2023300076, 2, '2024-12-07 18:55:50', 'Your return for 5 Calorometer(s) has been approved. Please return the item/items or you can approach the moderator Mr/Maam: Bryan Tamayo.'),
(771, 2023300076, 2, '2024-12-07 19:36:24', 'Your return for 2 Calorometer(s) has been approved.'),
(772, 2023300076, 2, '2024-12-07 19:36:25', 'Your return for 1 Ammeter(s) has been approved.'),
(773, 2023300076, 2, '2024-12-07 19:36:25', 'Your return for 5 Calorometer(s) has been approved.'),
(774, 2023300076, 2, '2024-12-07 19:36:25', 'Your return for 1 Balco Meter Bridge(s) has been approved.'),
(775, 2023300076, 2, '2024-12-07 19:43:37', 'Return reminder: Calorometer is due for return on 2024-12-07 12:00:00'),
(776, 2023300076, 2, '2024-12-07 19:43:49', 'Return reminder: Calibration Weight is due for return on 2024-12-07 12:00:00'),
(777, 2023300076, 2, '2024-12-07 19:47:38', 'Return reminder: Centesimal Meter is due for return on 2024-12-07 12:00:00'),
(778, 2023300076, 2, '2024-12-07 19:52:32', 'Return reminder: Balco Meter Bridge is due for return on 2024-12-07 12:00:00'),
(779, 2023300076, 2, '2024-12-07 19:54:13', 'Return reminder: Ammeter is due for return on 2024-12-07 12:00:00'),
(780, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Ammeter is due for return on 2024-12-08 22:43:00'),
(781, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Calibration Weight is due for return on 2024-12-08 22:43:00'),
(782, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Calorometer is due for return on 2024-12-08 22:43:00'),
(783, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Decade Resistance Box is due for return on 2024-12-08 22:43:00'),
(784, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Centesimal Meter is due for return on 2024-12-08 22:43:00'),
(785, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Conductivity of solutions Apparatus is due for return on 2024-12-08 22:43:00'),
(786, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Force Table is due for return on 2024-12-08 22:43:00'),
(787, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Metal Pocket Compass is due for return on 2024-12-08 22:43:00'),
(788, 2023300076, 2, '2024-12-09 11:35:47', 'Return reminder: Smart Timer is due for return on 2024-12-08 22:43:00'),
(789, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Ammeter is due for return on 2024-12-08 22:43:00'),
(790, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Calibration Weight is due for return on 2024-12-08 22:43:00'),
(791, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Calorometer is due for return on 2024-12-08 22:43:00'),
(792, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Decade Resistance Box is due for return on 2024-12-08 22:43:00'),
(793, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Centesimal Meter is due for return on 2024-12-08 22:43:00'),
(794, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Conductivity of solutions Apparatus is due for return on 2024-12-08 22:43:00'),
(795, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Force Table is due for return on 2024-12-08 22:43:00'),
(796, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Metal Pocket Compass is due for return on 2024-12-08 22:43:00'),
(797, 2023300076, 2, '2024-12-11 08:40:54', 'Return reminder: Smart Timer is due for return on 2024-12-08 22:43:00'),
(798, 999999999, 2, '2024-12-11 13:29:04', 'Item shortage alert: Ammeter has only 0 remaining in stock'),
(799, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Sip Wire Rheostat Variable is due for return on 2024-12-11 13:46:00'),
(800, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Plano Phantom Pro Tackle Box is due for return on 2024-12-11 13:46:00'),
(801, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Multimeter is due for return on 2024-12-11 13:46:00'),
(802, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Electrostatic System is due for return on 2024-12-11 13:46:00'),
(803, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Induction Coil is due for return on 2024-12-11 13:46:00'),
(804, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Electronic Multicolor Dynamic Trolly is due for return on 2024-12-11 13:46:00'),
(805, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Triple Beam Balance is due for return on 2024-12-11 13:46:00'),
(806, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: U-Shape Magnet is due for return on 2024-12-11 13:46:00'),
(807, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Hookes Law is due for return on 2024-12-11 13:46:00'),
(808, 2023300076, 2, '2024-12-11 13:46:00', 'Return reminder: Density Set with  Overflow Can is due for return on 2024-12-11 13:46:00'),
(809, 2023300076, 2, '2024-12-11 13:51:53', 'Return reminder: Balco Meter Bridge is due for return on 2024-12-11 13:50:00'),
(810, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Calorometer is due for return on 2024-12-11 13:50:00'),
(811, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Ammeter is due for return on 2024-12-11 13:50:00'),
(812, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Balco Meter Bridge is due for return on 2024-12-11 13:50:00'),
(813, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Calibration Weight is due for return on 2024-12-11 13:50:00'),
(814, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Centesimal Meter is due for return on 2024-12-11 13:50:00'),
(815, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Decade Resistance Box is due for return on 2024-12-11 13:50:00'),
(816, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Conductivity of solutions Apparatus is due for return on 2024-12-11 13:50:00'),
(817, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Force Table is due for return on 2024-12-11 13:50:00'),
(818, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Electrostatic System is due for return on 2024-12-11 13:50:00'),
(819, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Induction Coil is due for return on 2024-12-11 13:50:00'),
(820, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Electronic Multicolor Dynamic Trolly is due for return on 2024-12-11 13:50:00'),
(821, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Metal Pocket Compass is due for return on 2024-12-11 13:50:00'),
(822, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Sip Wire Rheostat Variable is due for return on 2024-12-11 13:50:00'),
(823, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Smart Timer is due for return on 2024-12-11 13:46:00'),
(824, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Plano Phantom Pro Tackle Box is due for return on 2024-12-11 13:46:00'),
(825, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Multimeter is due for return on 2024-12-11 13:46:00'),
(826, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Triple Beam Balance is due for return on 2024-12-11 13:46:00'),
(827, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: U-Shape Magnet is due for return on 2024-12-11 13:46:00'),
(828, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Hookes Law is due for return on 2024-12-11 13:46:00'),
(829, 2023300076, 2, '2024-12-13 09:44:50', 'Return reminder: Density Set with  Overflow Can is due for return on 2024-12-11 13:46:00'),
(830, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Calorometer is due for return on 2024-12-11 13:50:00'),
(831, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Ammeter is due for return on 2024-12-11 13:50:00'),
(832, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Balco Meter Bridge is due for return on 2024-12-11 13:50:00'),
(833, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Calibration Weight is due for return on 2024-12-11 13:50:00'),
(834, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Centesimal Meter is due for return on 2024-12-11 13:50:00'),
(835, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Decade Resistance Box is due for return on 2024-12-11 13:50:00'),
(836, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Conductivity of solutions Apparatus is due for return on 2024-12-11 13:50:00'),
(837, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Force Table is due for return on 2024-12-11 13:50:00'),
(838, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Electrostatic System is due for return on 2024-12-11 13:50:00'),
(839, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Induction Coil is due for return on 2024-12-11 13:50:00'),
(840, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Electronic Multicolor Dynamic Trolly is due for return on 2024-12-11 13:50:00'),
(841, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Metal Pocket Compass is due for return on 2024-12-11 13:50:00'),
(842, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Sip Wire Rheostat Variable is due for return on 2024-12-11 13:50:00'),
(843, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Smart Timer is due for return on 2024-12-11 13:46:00'),
(844, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Plano Phantom Pro Tackle Box is due for return on 2024-12-11 13:46:00'),
(845, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Multimeter is due for return on 2024-12-11 13:46:00'),
(846, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Triple Beam Balance is due for return on 2024-12-11 13:46:00'),
(847, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: U-Shape Magnet is due for return on 2024-12-11 13:46:00'),
(848, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Hookes Law is due for return on 2024-12-11 13:46:00'),
(849, 2023300076, 2, '2024-12-14 19:25:15', 'Return reminder: Density Set with  Overflow Can is due for return on 2024-12-11 13:46:00'),
(850, 2023300076, 2, '2024-12-14 20:06:11', 'Your return for 1 Ammeter(s) has been approved.'),
(851, 2023300076, 2, '2024-12-14 20:06:11', 'Your return for 1 Calibration Weight(s) has been approved.'),
(852, 2023300076, 2, '2024-12-14 20:06:11', 'Your return for 2 Calorometer(s) has been approved.'),
(853, 2023300076, 2, '2024-12-14 20:06:11', 'Your return for 2 Decade Resistance Box(s) has been approved.'),
(854, 2023300076, 2, '2024-12-14 20:06:12', 'Your return for 1 Centesimal Meter(s) has been approved.'),
(855, 2023300076, 2, '2024-12-14 20:06:12', 'Your return for 2 Conductivity of solutions Apparatus(s) has been approved.'),
(856, 2023300076, 2, '2024-12-14 20:06:12', 'Your return for 3 Force Table(s) has been approved.'),
(857, 2023300076, 2, '2024-12-14 20:06:13', 'Your return for 2 Metal Pocket Compass(s) has been approved.'),
(858, 2023300076, 2, '2024-12-14 20:06:13', 'Your return for 1 Smart Timer(s) has been approved.'),
(859, 2023300076, 2, '2024-12-14 20:06:13', 'Your return for 2 Calorometer(s) has been approved.'),
(860, 2023300076, 2, '2024-12-14 20:06:14', 'Your return for 1 Ammeter(s) has been approved.'),
(861, 2023627838, 2, '2024-12-14 21:59:27', 'Your return for 4 Conductivity of solutions Apparatus(s) has been approved.'),
(862, 2023300076, 2, '2024-12-14 23:14:01', 'Your return for 2 Conductivity of solutions Apparatus(s) has been approved. Please return the item/items or you can approach the moderator Mr/Maam: Bryan Tamayo.'),
(863, 2023627838, 2, '2024-12-15 16:37:39', 'Your return for 1 Calibration Weight(s) has been approved.'),
(864, 2023627838, 2, '2024-12-15 16:37:45', 'Your return for 3 Conductivity of solutions Apparatus(s) has been approved. Please return the item/items or you can approach the moderator Mr/Maam: Bryan Tamayo.'),
(865, 2023627838, 2, '2024-12-15 16:40:30', 'Your return for 2 Decade Resistance Box(s) has been approved.'),
(866, 2023627838, 2, '2024-12-15 17:12:22', 'Return reminder: Ammeter is due for return on 2024-12-14 23:40:00'),
(867, 2023300076, 2, '2024-12-16 23:15:54', 'Your return for 2 Conductivity of solutions Apparatus(s) has been approved.'),
(868, 2023627838, 1, '2024-12-16 23:15:55', 'Your return for 3 Conductivity of solutions Apparatus(s) has been approved.'),
(869, 2023627838, 1, '2024-12-16 23:15:56', 'Your return for 1 Ammeter(s) has been approved. Please return the item/items or you can approach the moderator Sir/Maam: Bryan Tamayo or you can contact him/her at bryan@gmail.com.'),
(870, 2023627838, 1, '2024-12-16 23:40:37', 'Your return for 1 Ammeter(s) has been approved.'),
(871, 2023300076, 2, '2024-12-16 23:40:37', 'Your return for 2 Calorometer(s) has been approved.'),
(872, 2023300076, 2, '2024-12-16 23:40:38', 'Your return for 2 Conductivity of solutions Apparatus(s) has been approved.'),
(873, 2023300076, 2, '2024-12-16 23:40:38', 'Your return for 3 Induction Coil(s) has been approved.'),
(874, 2023300076, 2, '2024-12-16 23:40:38', 'Your return for 2 Electronic Multicolor Dynamic Trolly(s) has been approved.'),
(875, 2023300076, 2, '2024-12-16 23:40:39', 'Your return for 1 Electroscope(s) has been approved.'),
(876, 2023300076, 2, '2024-12-16 23:40:39', 'Your return for 2 Electrostatic System(s) has been approved.'),
(877, 2023300076, 2, '2024-12-16 23:40:40', 'Your return for 2 Force Table(s) has been approved.'),
(878, 2023300076, 2, '2024-12-16 23:40:40', 'Your return for 2 Metal Pocket Compass(s) has been approved.'),
(879, 2023300076, 2, '2024-12-16 23:40:40', 'Your return for 1 Multimeter(s) has been approved.'),
(880, 2023300076, 2, '2024-12-16 23:40:40', 'Your return for 1 Plano Phantom Pro Tackle Box(s) has been approved.'),
(881, 2023300076, 2, '2024-12-16 23:40:41', 'Your return for 2 Triple Beam Balance(s) has been approved.'),
(882, 2023300076, 2, '2024-12-16 23:40:41', 'Your return for 2 U-Shape Magnet(s) has been approved.'),
(883, 2023300076, 2, '2024-12-16 23:40:42', 'Your return for 3 Decade Resistance Box(s) has been approved.'),
(884, 2023300076, 2, '2024-12-16 23:40:42', 'Your return for 1 Density Set with  Overflow Can(s) has been approved.'),
(885, 2023300076, 2, '2024-12-16 23:40:42', 'Your return for 3 Force Table(s) has been approved.'),
(886, 2023300076, 2, '2024-12-16 23:40:43', 'Your return for 2 Metal Pocket Compass(s) has been approved.'),
(887, 2023300076, 2, '2024-12-16 23:40:43', 'Your return for 1 Plano Phantom Pro Tackle Box(s) has been approved.'),
(888, 2023300076, 2, '2024-12-16 23:40:44', 'Your return for 3 Sip Wire Rheostat Variable(s) has been approved. Please return the item/items or you can approach the moderator Sir/Maam: Bryan Tamayo or you can contact him/her at bryan@gmail.com.'),
(889, 2023300076, 2, '2024-12-16 23:40:44', 'Your return for 1 Smart Timer(s) has been approved. Please return the item/items or you can approach the moderator Sir/Maam: Bryan Tamayo or you can contact him/her at bryan@gmail.com.'),
(890, 2023300076, 2, '2024-12-16 23:40:45', 'Your return for 1 Triple Beam Balance(s) has been approved.'),
(891, 2023300076, 2, '2024-12-16 23:40:45', 'Your return for 2 U-Shape Magnet(s) has been approved.'),
(892, 2023300076, 2, '2024-12-16 23:41:18', 'Your return for 3 Sip Wire Rheostat Variable(s) has been approved.'),
(893, 2023300076, 2, '2024-12-16 23:41:19', 'Your return for 1 Smart Timer(s) has been approved.'),
(894, 2023300076, 2, '2024-12-16 23:50:03', 'Your return for 4 Conductivity of solutions Apparatus(s) has been approved.'),
(895, 2023300076, 2, '2024-12-16 23:50:03', 'Your return for 3 Conductivity of solutions Apparatus(s) has been approved.'),
(896, 2023300076, 2, '2024-12-16 23:50:04', 'Your return for 4 Conductivity of solutions Apparatus(s) has been approved.'),
(912, 2023300076, 2, '2024-12-17 09:29:32', 'Your return for 1 Decade Resistance Box(s) has been approved.'),
(913, 2023300076, 2, '2024-12-17 09:29:33', 'Your return for 3 Conductivity of solutions Apparatus(s) has been approved.'),
(914, 2023309879, 1, '2024-12-17 16:22:59', 'Your return for 2 Calorometer(s) has been approved.'),
(915, 2023309879, 1, '2024-12-17 16:23:00', 'Your return for 1 Balco Meter Bridge(s) has been approved.'),
(916, 2023309879, 1, '2024-12-17 16:23:03', 'Your return for 1 Calibration Weight(s) has been approved. Please return the item/items or you can approach the moderator Sir/Maam: Bryan Tamayo or you can contact him/her at bryan@gmail.com.'),
(917, 2023309879, 1, '2024-12-17 16:23:29', 'Your return for 1 Calibration Weight(s) has been approved.'),
(918, 999999999, 2, '2024-12-17 17:06:53', 'Your return for 2 Calorometer(s) has been approved.'),
(919, 999999999, 2, '2024-12-17 17:06:54', 'Your return for 3 Conductivity of solutions Apparatus(s) has been approved.'),
(920, 999999999, 2, '2024-12-17 17:06:55', 'Your return for 2 Electronic Multicolor Dynamic Trolly(s) has been approved.'),
(921, 2023300076, 2, '2025-01-01 09:16:00', 'Your return for 1 Calibration Weight(s) has been approved. Please return the item/items or you can approach the moderator Sir/Maam: Bryan Tamayo or you can contact him/her at bryan@gmail.com.'),
(922, 2023300076, 2, '2025-01-28 22:05:43', 'Your return for 1 Calibration Weight(s) has been approved.'),
(923, 2023300076, 2, '2025-01-28 22:05:46', 'Your return for 1 Ammeter(s) has been approved.'),
(924, 2023300076, 2, '2025-01-28 22:05:46', 'Your return for 1 Balco Meter Bridge(s) has been approved.'),
(925, 2023300076, 2, '2025-01-28 22:05:47', 'Your return for 4 Electronic Multicolor Dynamic Trolly(s) has been approved.'),
(926, 999999999, 2, '2025-01-28 22:05:47', 'Your return for 1 Balco Meter Bridge(s) has been approved. Please return the item/items or you can approach the moderator Sir/Maam: Bryan Tamayo or you can contact him/her at bryan@gmail.com.'),
(927, 999999999, 2, '2025-01-28 22:05:47', 'Your return for 1 Calibration Weight(s) has been approved. Please return the item/items or you can approach the moderator Sir/Maam: Bryan Tamayo or you can contact him/her at bryan@gmail.com.'),
(928, 999999999, 2, '2025-01-28 22:05:48', 'Your return for 2 Calorometer(s) has been approved.'),
(929, 999999999, 2, '2025-01-28 22:05:58', 'Your return for 1 Balco Meter Bridge(s) has been approved.'),
(930, 999999999, 2, '2025-01-28 22:05:59', 'Your return for 1 Calibration Weight(s) has been approved.'),
(931, 2023300076, 2, '2025-01-30 13:06:17', 'Return reminder: Ammeter is due for return on 2025-01-29 23:50:00'),
(932, 2023300076, 2, '2025-01-30 13:06:17', 'Return reminder: Balco Meter Bridge is due for return on 2025-01-29 23:50:00'),
(933, 2023300076, 2, '2025-01-30 13:06:17', 'Return reminder: Conductivity of solutions Apparatus is due for return on 2025-01-29 23:50:00'),
(934, 2023300076, 2, '2025-02-15 22:19:35', 'Return reminder: Ammeter is due for return on 2025-01-29 23:50:00'),
(935, 2023300076, 2, '2025-02-15 22:19:35', 'Return reminder: Balco Meter Bridge is due for return on 2025-01-29 23:50:00'),
(936, 2023300076, 2, '2025-02-15 22:19:35', 'Return reminder: Conductivity of solutions Apparatus is due for return on 2025-01-29 23:50:00'),
(937, 2023300076, 1, '2025-02-17 15:23:48', 'Return reminder: Ammeter is due for return on 2025-01-29 23:50:00'),
(938, 2023300076, 1, '2025-02-17 15:23:48', 'Return reminder: Balco Meter Bridge is due for return on 2025-01-29 23:50:00'),
(939, 2023300076, 1, '2025-02-17 15:23:48', 'Return reminder: Conductivity of solutions Apparatus is due for return on 2025-01-29 23:50:00'),
(940, 2023300076, 1, '2025-02-22 15:08:41', 'Return reminder: Ammeter is due for return on 2025-02-17 19:24:00'),
(941, 2023300076, 1, '2025-02-22 15:08:41', 'Return reminder: Balco Meter Bridge is due for return on 2025-02-17 19:24:00'),
(942, 2023300076, 1, '2025-02-24 21:09:25', 'Return reminder: Ammeter is due for return on 2025-02-17 19:24:00'),
(943, 2023300076, 1, '2025-02-24 21:09:25', 'Return reminder: Balco Meter Bridge is due for return on 2025-02-17 19:24:00'),
(944, 2023300076, 1, '2025-02-24 21:09:25', 'Return reminder: Decade Resistance Box is due for return on 2025-02-22 20:08:00'),
(945, 999999999, 1, '2025-03-05 10:43:43', 'Your return for 1 Calibration Weight(s) has been approved.'),
(946, 2023300076, 1, '2025-03-05 10:43:44', 'Your return for 2 Conductivity of solutions Apparatus(s) has been approved.'),
(947, 2023300076, 1, '2025-03-05 10:43:45', 'Your return for 4 Decade Resistance Box(s) has been approved.'),
(948, 2023300076, 1, '2025-03-05 10:43:45', 'Your return for 1 Ammeter(s) has been approved.'),
(949, 2023300076, 1, '2025-03-05 10:43:46', 'Your return for 1 Ammeter(s) has been approved.');

-- --------------------------------------------------------

--
-- Table structure for table `notification_status`
--

CREATE TABLE `notification_status` (
  `notification_status_id` int(11) NOT NULL,
  `notif_status` enum('seen','not_seen') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_status`
--

INSERT INTO `notification_status` (`notification_status_id`, `notif_status`) VALUES
(1, 'not_seen'),
(2, 'seen');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `record_id` int(11) NOT NULL,
  `reserve_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`record_id`, `reserve_id`) VALUES
(135, 575),
(136, 576),
(137, 577),
(138, 578),
(139, 579),
(140, 615),
(141, 616),
(142, 617),
(143, 618),
(144, 619),
(145, 620),
(146, 621),
(147, 622),
(148, 623),
(149, 624),
(150, 625),
(154, 683),
(151, 685),
(152, 686),
(155, 687),
(153, 688),
(156, 689),
(157, 690),
(158, 691),
(159, 692),
(160, 693),
(161, 694),
(162, 695),
(163, 696),
(164, 697),
(165, 698),
(166, 699),
(167, 700),
(168, 701),
(169, 702),
(170, 703),
(171, 704),
(172, 705),
(173, 706),
(176, 707),
(177, 708),
(174, 709),
(175, 710),
(178, 711),
(179, 712),
(180, 713),
(196, 736),
(197, 737),
(198, 738),
(199, 739),
(200, 740),
(201, 741),
(202, 742),
(203, 743),
(204, 744),
(205, 744),
(206, 745),
(207, 746),
(208, 747),
(210, 748),
(211, 749),
(209, 750),
(215, 751),
(213, 753),
(216, 754),
(214, 759),
(212, 762);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reserve_id` int(11) NOT NULL,
  `id_number` bigint(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity_reserved` int(11) NOT NULL,
  `scheduled_reserve_datetime` datetime NOT NULL,
  `scheduled_return_datetime` datetime NOT NULL,
  `returned_datetime` datetime DEFAULT NULL,
  `reservation_status_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reserve_id`, `id_number`, `item_id`, `quantity_reserved`, `scheduled_reserve_datetime`, `scheduled_return_datetime`, `returned_datetime`, `reservation_status_ID`) VALUES
(575, 2023300076, 21, 2, '2024-12-04 13:47:00', '2024-12-04 13:50:00', '2024-12-04 14:11:04', 3),
(576, 2023300076, 21, 2, '2024-12-07 17:45:00', '2024-12-07 20:45:00', '2024-12-07 19:36:21', 3),
(577, 2023300076, 39, 1, '2024-12-07 19:00:00', '2024-12-07 21:00:00', '2024-12-07 19:36:20', 3),
(578, 2023300076, 21, 5, '2024-12-07 19:00:00', '2024-12-07 21:00:00', '2024-12-07 19:36:20', 3),
(579, 2023300076, 98, 1, '2025-01-07 19:00:00', '2025-01-13 21:00:00', '2024-12-07 19:36:20', 3),
(615, 2023300076, 39, 1, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:52', 3),
(616, 2023300076, 15, 1, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:50', 3),
(617, 2023300076, 21, 2, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:50', 3),
(618, 2023300076, 25, 2, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:51', 3),
(619, 2023300076, 30, 1, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:51', 3),
(620, 2023300076, 18, 2, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:51', 3),
(621, 2023300076, 36, 3, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:51', 3),
(622, 2023300076, 19, 2, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:52', 3),
(623, 2023300076, 29, 1, '2024-12-08 19:43:00', '2024-12-08 22:43:00', '2024-12-11 09:40:52', 3),
(624, 2023300076, 21, 2, '2024-12-04 13:47:00', '2024-12-11 13:50:00', '2024-12-14 20:04:41', 3),
(625, 2023300076, 39, 1, '2024-12-04 13:47:00', '2024-12-11 13:50:00', '2024-12-14 20:04:41', 3),
(683, 2023300076, 18, 2, '2024-12-14 20:40:00', '2024-12-14 23:39:00', '2024-12-16 23:15:27', 3),
(685, 2023627838, 18, 4, '2024-12-14 22:00:00', '2024-12-14 23:40:00', '2024-12-14 21:58:36', 3),
(686, 2023627838, 15, 1, '2024-12-14 22:00:00', '2024-12-14 23:40:00', '2024-12-14 22:53:53', 3),
(687, 2023627838, 18, 3, '2024-12-14 22:00:00', '2024-12-14 23:40:00', '2024-12-16 23:15:28', 3),
(688, 2023627838, 25, 2, '2024-12-14 22:00:00', '2024-12-14 23:40:00', '2024-12-14 22:53:57', 3),
(689, 2023627838, 39, 1, '2024-12-14 22:00:00', '2024-12-14 23:40:00', '2024-12-16 23:17:21', 3),
(690, 2023300076, 21, 2, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:09', 3),
(691, 2023300076, 18, 2, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:10', 3),
(692, 2023300076, 35, 3, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:11', 3),
(693, 2023300076, 22, 2, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:11', 3),
(694, 2023300076, 32, 1, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:12', 3),
(695, 2023300076, 26, 2, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:13', 3),
(696, 2023300076, 36, 2, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:13', 3),
(697, 2023300076, 19, 2, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:14', 3),
(698, 2023300076, 28, 1, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:14', 3),
(699, 2023300076, 23, 1, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:14', 3),
(700, 2023300076, 20, 2, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:15', 3),
(701, 2023300076, 24, 2, '2024-12-16 23:59:00', '2024-12-17 01:40:00', '2024-12-16 23:40:15', 3),
(702, 2023300076, 25, 3, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:40:16', 3),
(703, 2023300076, 33, 1, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:40:16', 3),
(704, 2023300076, 36, 3, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:40:16', 3),
(705, 2023300076, 19, 2, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:40:17', 3),
(706, 2023300076, 23, 1, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:40:17', 3),
(707, 2023300076, 27, 3, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:41:05', 3),
(708, 2023300076, 29, 1, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:41:06', 3),
(709, 2023300076, 20, 1, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:40:18', 3),
(710, 2023300076, 24, 2, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:40:18', 3),
(711, 2023300076, 18, 4, '2024-12-17 03:59:00', '2024-12-17 07:40:00', '2024-12-16 23:49:57', 3),
(712, 2023300076, 18, 3, '2024-12-17 08:59:00', '2024-12-17 10:40:00', '2024-12-16 23:49:57', 3),
(713, 2023300076, 18, 4, '2024-12-17 10:59:00', '2024-12-17 11:40:00', '2024-12-16 23:49:58', 3),
(736, 2023300076, 25, 1, '2024-12-17 14:00:00', '2024-12-17 16:40:00', '2024-12-17 09:29:02', 3),
(737, 2023300076, 18, 3, '2024-12-17 13:00:00', '2024-12-17 15:40:00', '2024-12-17 09:29:02', 3),
(738, 2023309879, 21, 2, '2024-12-17 17:22:00', '2024-12-17 18:22:00', '2024-12-17 16:22:42', 3),
(739, 2023309879, 98, 1, '2024-12-17 17:22:00', '2024-12-17 18:22:00', '2024-12-17 16:22:43', 3),
(740, 2023309879, 15, 1, '2024-12-17 17:22:00', '2024-12-17 18:22:00', '2024-12-17 16:23:20', 3),
(741, 999999999, 21, 2, '2024-12-17 18:00:00', '2024-12-17 20:00:00', '2024-12-17 17:05:44', 3),
(742, 999999999, 18, 3, '2024-12-17 18:00:00', '2024-12-17 20:00:00', '2024-12-17 17:05:45', 3),
(743, 999999999, 22, 2, '2024-12-17 18:00:00', '2024-12-17 20:00:00', '2024-12-17 17:05:45', 3),
(744, 2023300076, 15, 1, '2025-01-01 10:00:00', '2025-01-01 11:00:00', '2025-01-28 22:05:13', 3),
(745, 2023300076, 39, 1, '2025-01-01 10:00:00', '2025-01-01 11:00:00', '2025-01-01 09:15:19', 3),
(746, 2023300076, 98, 1, '2025-01-01 10:00:00', '2025-01-01 11:00:00', '2025-01-01 09:15:20', 3),
(747, 2023300076, 22, 4, '2025-01-01 10:00:00', '2025-01-01 11:00:00', '2025-01-01 09:15:20', 3),
(748, 999999999, 98, 1, '2025-01-29 22:00:00', '2025-01-30 11:00:00', '2025-01-28 22:05:53', 3),
(749, 999999999, 15, 1, '2025-01-29 22:00:00', '2025-01-30 11:00:00', '2025-01-28 22:05:53', 3),
(750, 999999999, 21, 2, '2025-01-29 22:00:00', '2025-01-30 11:00:00', '2025-01-28 22:05:13', 3),
(751, 2023300076, 39, 1, '2025-01-29 21:50:00', '2025-01-29 23:50:00', '2025-02-17 15:26:21', 3),
(752, 2023300076, 98, 1, '2025-01-29 21:50:00', '2025-01-29 23:50:00', '2025-02-17 15:26:21', 2),
(753, 2023300076, 18, 2, '2025-01-29 21:50:00', '2025-01-29 23:50:00', '2025-02-17 15:26:21', 3),
(754, 2023300076, 39, 1, '2025-01-31 15:10:00', '2025-01-31 19:10:00', '2025-02-17 15:26:22', 3),
(755, 999999999, 39, 1, '2025-02-17 11:50:00', '2025-02-17 12:50:00', '2025-02-17 08:51:15', 2),
(756, 999999999, 98, 1, '2025-02-17 11:50:00', '2025-02-17 12:50:00', '2025-02-17 08:51:16', 2),
(757, 2023300076, 39, 1, '2025-02-17 17:24:00', '2025-02-17 19:24:00', '2025-03-05 10:23:30', 2),
(758, 2023300076, 98, 1, '2025-02-17 17:24:00', '2025-02-17 19:24:00', '2025-03-05 10:23:32', 2),
(759, 2023300076, 25, 4, '2025-02-22 16:08:00', '2025-02-22 20:08:00', '2025-03-05 10:23:33', 3),
(760, 999999999, 39, 1, '2025-03-06 16:08:00', '2025-03-07 20:08:00', '2025-03-05 10:23:11', 2),
(761, 999999999, 98, 1, '2025-03-06 16:08:00', '2025-03-07 20:08:00', '2025-03-05 10:23:12', 2),
(762, 999999999, 15, 1, '2025-03-06 16:08:00', '2025-03-07 20:08:00', '2025-03-05 10:23:16', 3);

-- --------------------------------------------------------

--
-- Table structure for table `reservation_status`
--

CREATE TABLE `reservation_status` (
  `reservation_status_ID` int(11) NOT NULL,
  `reservation_stat` enum('disapproved','pending_return','approved','reserving') NOT NULL DEFAULT 'reserving'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_status`
--

INSERT INTO `reservation_status` (`reservation_status_ID`, `reservation_stat`) VALUES
(1, 'reserving'),
(2, 'pending_return'),
(3, 'approved'),
(4, 'disapproved');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id_number`) USING BTREE,
  ADD KEY `account_status` (`active_status_id`);

--
-- Indexes for table `active_status`
--
ALTER TABLE `active_status`
  ADD PRIMARY KEY (`active_status_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `item_status` (`active_status_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notification_status` (`notification_status_id`),
  ADD KEY `notification_id_number` (`id_number`);

--
-- Indexes for table `notification_status`
--
ALTER TABLE `notification_status`
  ADD PRIMARY KEY (`notification_status_id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `reserve` (`reserve_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reserve_id`),
  ADD KEY `id` (`item_id`),
  ADD KEY `reservation_status` (`reservation_status_ID`),
  ADD KEY `reservation_id_number` (`id_number`);

--
-- Indexes for table `reservation_status`
--
ALTER TABLE `reservation_status`
  ADD PRIMARY KEY (`reservation_status_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id_number` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23525557678;

--
-- AUTO_INCREMENT for table `active_status`
--
ALTER TABLE `active_status`
  MODIFY `active_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=950;

--
-- AUTO_INCREMENT for table `notification_status`
--
ALTER TABLE `notification_status`
  MODIFY `notification_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reserve_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=763;

--
-- AUTO_INCREMENT for table `reservation_status`
--
ALTER TABLE `reservation_status`
  MODIFY `reservation_status_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `account_status` FOREIGN KEY (`active_status_id`) REFERENCES `active_status` (`active_status_id`) ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `item_status` FOREIGN KEY (`active_status_id`) REFERENCES `active_status` (`active_status_id`) ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notification_id_number` FOREIGN KEY (`id_number`) REFERENCES `accounts` (`id_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_status` FOREIGN KEY (`notification_status_id`) REFERENCES `notification_status` (`notification_status_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `reserve` FOREIGN KEY (`reserve_id`) REFERENCES `reservations` (`reserve_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `id` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_id_number` FOREIGN KEY (`id_number`) REFERENCES `accounts` (`id_number`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_status` FOREIGN KEY (`reservation_status_ID`) REFERENCES `reservation_status` (`reservation_status_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
