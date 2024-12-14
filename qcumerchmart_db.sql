-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 11:43 AM
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
-- Database: `qcumerchmart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `last_login`, `last_logout`) VALUES
(1, 'admin', 'admin123', '2024-12-13 01:48:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `image_url` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `product_name`, `price`, `quantity`, `total`, `image_url`, `created_at`) VALUES
(1, 6, 4, 'T - Shirts', 250.00, 5, 1250.00, 'http://localhost:8000/assets/images/t-shirt.png', '2024-11-19 11:02:18'),
(2, 6, 5, 'QCU ID Lace', 50.00, 10, 500.00, 'http://localhost:8000/assets/images/bcs.PNG', '2024-11-19 11:05:17');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `product_name`, `price`, `image_url`, `created_at`) VALUES
(12, 17, 1, 'Bachelor of Science Computer Science (BCS)', 75.00, 'http://localhost:8000/assets/images/bcs.PNG', '2024-12-05 08:19:23'),
(13, 17, 2, 'Bachelor of Early Childhood Education (BECED)', 75.00, 'http://localhost:8000/assets/images/beced.PNG', '2024-12-05 08:29:54'),
(14, 17, 3, 'Bachelor of Science in Information Systems (BIS)', 75.00, 'http://localhost:8000/assets/images/bis.PNG', '2024-12-05 08:32:40'),
(21, 1, 2, 'Tumblers (Red)', 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 10:15:18'),
(22, 18, 2, 'Tumblers (Red)', 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-13 07:05:23'),
(23, 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:05:25'),
(24, 18, 4, 'Bachelor of Science in Management Accounting (BSMA)', 75.00, 'http://localhost:8000/uploads/product_67569cc76d70c2.80101398.PNG', '2024-12-13 07:05:26'),
(25, 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 07:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `image_url` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `claim_date` datetime DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `payment_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `product_id`, `product_name`, `price`, `quantity`, `total`, `image_url`, `order_date`, `claim_date`, `status`, `payment_id`) VALUES
(41, NULL, 1, 3, 'Bachelor of Science Computer Science (BCS)', 75.00, 5, 375.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-10 08:51:03', NULL, 'Pending', 'PAY202412100951033388'),
(42, NULL, 1, 14, 'P.E Shirt', 250.00, 4, 1000.00, '../uploads/product_6756a1928f62c5.33368374.png', '2024-12-10 08:51:03', NULL, 'Pending', 'PAY202412100951033388'),
(43, NULL, 1, 2, 'Tumbler Red', 250.00, 9, 2250.00, '../uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 08:57:25', NULL, 'Pending', 'PAY202412100957255040'),
(44, 'ORD675811b9645b2', 1, 2, 'Tumblers (Red)', 250.00, 4, 1000.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 10:02:33', NULL, 'Paid', 'PAY202412101102338881'),
(45, 'ORD675812d9981f8', 1, 18, 'Male Pants', 470.00, 4, 1880.00, 'http://localhost:8000/uploads/product_6756a2884826f7.79784606.png', '2024-12-10 10:07:21', NULL, 'Paid', 'PAY202412101107214632'),
(46, 'ORD6758148e528b9', 1, 2, 'Tumblers (Red)', 250.00, 3, 750.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 10:14:38', NULL, 'Paid', 'PAY202412101114382401'),
(47, 'ORD675814ba624fc', 1, 2, 'Tumblers (Red)', 250.00, 5, 1250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 10:15:22', NULL, 'Paid', 'PAY202412101115225302'),
(49, 'ORD202412101117086627662931', 1, 2, 'Tumblers (Red)', 250.00, 5, 1250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 10:17:08', NULL, 'Paid', 'PAY202412101117087957'),
(50, 'ORD6758153db0695', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-10 10:17:33', NULL, 'Pending', 'PAY202412101117337140'),
(62, 'ORD67581f9041136', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-10 11:01:36', NULL, 'Pending', 'PAY202412101201363900'),
(63, 'ORD67581f9d77cdf', 1, 2, 'Tumblers (Red)', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:01:49', NULL, 'Pending', 'PAY202412101201493631'),
(64, 'ORD67581fa8e552b', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-10 11:02:00', NULL, 'Pending', 'PAY202412101202009870'),
(65, 'ORD67581fac5fc9e', 1, 2, 'Tumblers (Red)', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:02:04', NULL, 'Pending', 'PAY202412101202047271'),
(66, 'ORD67581fb25c79e', 1, 2, 'Tumblers (Red)', 250.00, 8, 2000.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:02:10', NULL, 'Pending', 'PAY202412101202102186'),
(68, 'ORD675821cbaa7b6', 1, 2, 'Tumblers (Red)', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:11:07', NULL, 'Pending', 'PAY202412101211072693'),
(69, 'ORD675821cee007c', 1, 2, 'Tumblers (Red)', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:11:10', NULL, 'Pending', 'PAY202412101211106422'),
(72, 'ORD67582272ae2b9', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-10 11:13:54', NULL, 'Pending', 'PAY202412101213547021'),
(73, 'ORD675822a92892b', 1, 2, 'Tumblers (Red)', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:14:49', NULL, 'Pending', 'PAY202412101214498063'),
(75, 'ORD6758259fab87c', 1, 19, 'Jacket (Black)', 600.00, 1, 600.00, 'http://localhost:8000/uploads/product_6756a310aa2f59.85803338.png', '2024-12-10 11:27:27', NULL, 'Paid', 'PAY202412101227271883'),
(81, 'ORD675827e293f4e', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-10 11:37:06', NULL, 'Paid', 'PAY202412101237068018'),
(86, 'ORD6758285619f28', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-10 11:39:02', NULL, 'Paid', 'PAY202412101239021190'),
(87, 'ORD202412109574', 1, 2, 'Tumbler Red', 250.00, 6, 1500.00, '../uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:40:26', NULL, 'Paid', 'PAY17338308268738'),
(88, 'ORD202412109656', 1, 2, 'Tumbler Red', 250.00, 6, 1500.00, '../uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:41:04', NULL, 'Paid', 'PAY17338308641420'),
(89, 'ORD202412102030', 1, 2, 'Tumbler Red', 250.00, 4, 1000.00, '../uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:41:29', NULL, 'Paid', 'PAY17338308898204'),
(90, 'ORD6758293211d03', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-10 11:42:42', NULL, 'Paid', 'PAY202412101242424546'),
(91, 'ORD67582b31bb98c', 1, 2, 'Tumblers (Red)', 250.00, 4, 1000.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:51:13', NULL, 'Paid', 'PAY202412101251136766'),
(92, 'ORD67582c8b244e1', 1, 2, 'Tumblers (Red)', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 11:56:59', NULL, 'Paid', 'PAY202412101256594802'),
(93, 'ORD202412107022', 1, 3, 'Bachelor of Science Computer Science (BCS)', 75.00, 2, 150.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-10 11:59:39', NULL, 'Paid', 'PAY17338319798780'),
(94, 'ORD67582d82d449e', 1, 2, 'Tumblers (Red)', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 12:01:06', NULL, 'Pending', 'PAY202412101301068036'),
(95, 'ORD67582dc16a443', 1, 2, 'Tumblers (Red)', 250.00, 55, 13750.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 12:02:09', NULL, 'Pending', 'PAY202412101302094621'),
(96, 'ORD6758833d03f59', 1, 2, 'Tumblers (Red)', 250.00, 100, 25000.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-10 18:06:53', NULL, 'Paid', 'PAY202412101906537539'),
(97, 'ORD675883d84008f', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-10 18:09:28', NULL, 'Pending', 'PAY202412101909286784'),
(98, 'ORD67588422530ce', 1, 14, 'P.E Shirt', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_6756a1928f62c5.33368374.png', '2024-12-10 18:10:42', NULL, 'Paid', 'PAY202412101910426075'),
(99, 'ORD202412101911240058679922', 1, 14, 'P.E Shirt', 250.00, 1, 250.00, 'http://localhost:8000/uploads/product_6756a1928f62c5.33368374.png', '2024-12-10 18:11:24', NULL, 'Paid', 'PAY202412101911241276'),
(100, 'ORD6758ea4ced146', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-11 01:26:36', NULL, 'Paid', 'PAY202412110226363351'),
(101, 'ORD202412110227355729972665', 1, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-11 01:27:35', NULL, 'Ready for pickup', 'PAY202412110227354860'),
(102, 'ORD675bdb3250616', 18, 2, 'Tumblers (Red)', 250.00, 100, 25000.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-13 06:58:58', NULL, 'Paid', 'PAY202412130758586523'),
(103, 'ORD675bdcdca8de0', 18, 2, 'Tumblers (Red)', 250.00, 20, 5000.00, 'http://localhost:8000/uploads/product_675654da3989a2.18568684.PNG', '2024-12-13 07:06:04', NULL, 'Paid', 'PAY202412130806041560'),
(104, 'ORD675bddc7ae17a', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:09:59', NULL, 'Paid', 'PAY202412130809597498'),
(105, 'ORD675be36317fbd', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:33:55', NULL, 'Pending', 'PAY202412130833552119'),
(106, 'ORD675be38193cdf', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:34:25', NULL, 'Pending', 'PAY202412130834258037'),
(107, 'ORD675be39013cb2', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:34:40', NULL, 'Pending', 'PAY202412130834402704'),
(108, 'ORD675be39a60d8c', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:34:50', NULL, 'Pending', 'PAY202412130834501741'),
(110, 'ORD202412130835083261898121', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:35:08', NULL, 'Paid', 'PAY202412130835082883'),
(111, 'ORD675be4551c68e', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:37:57', NULL, 'Pending', 'PAY202412130837571790'),
(112, 'ORD202412130839031543878235', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 07:39:03', NULL, 'Paid', 'PAY202412130839036834'),
(113, 'ORD675be5bad1621', 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 07:43:54', NULL, 'Pending', 'PAY202412130843549274'),
(114, 'ORD202412130844026432545574', 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 07:44:02', NULL, 'Paid', 'PAY202412130844027124'),
(115, 'ORD675be60835aa7', 18, 6, 'Bachelor of Science in Information Systems (BIS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569e2a5db551.81571066.PNG', '2024-12-13 07:45:12', NULL, 'Pending', 'PAY202412130845129081'),
(116, 'ORD202412130848273441989079', 18, 6, 'Bachelor of Science in Information Systems (BIS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569e2a5db551.81571066.PNG', '2024-12-13 07:48:27', NULL, 'Paid', 'PAY202412130848273938'),
(117, 'ORD675be7a9995cf', 18, 4, 'Bachelor of Science in Management Accounting (BSMA)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569cc76d70c2.80101398.PNG', '2024-12-13 07:52:09', NULL, 'Pending', 'PAY202412130852099352'),
(118, 'ORD202412130852165160259642', 18, 4, 'Bachelor of Science in Management Accounting (BSMA)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569cc76d70c2.80101398.PNG', '2024-12-13 07:52:16', NULL, 'Paid', 'PAY202412130852166875'),
(119, 'ORD675bec3a80449', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:11:38', NULL, 'Pending', 'PAY202412130911389461'),
(120, 'ORD202412130911462275306036', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:11:46', NULL, 'Pending', 'PAY202412130911461751'),
(121, 'ORD675becb93af9f', 18, 8, 'Bachelor of Science Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:13:45', NULL, 'Pending', 'PAY202412130913456494'),
(123, 'ORD202412130913578402449687', 18, 8, 'Bachelor of Science Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:13:57', NULL, 'Pending', 'PAY202412130913576215'),
(124, 'ORD675bee45c9c38', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:20:21', NULL, 'Pending', 'PAY202412130920212328'),
(125, 'ORD202412130920290801018614', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:20:29', NULL, 'Pending', 'PAY202412130920295240'),
(126, 'ORD675bee8717001', 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 08:21:27', NULL, 'Pending', 'PAY202412130921278657'),
(127, 'ORD202412130921365733382698', 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 08:21:36', NULL, 'Pending', 'PAY202412130921362127'),
(128, 'ORD675bf2a67bf21', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 2, 150.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:39:02', NULL, 'Pending', 'PAY202412130939028631'),
(129, 'ORD202412130939098731328531', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 2, 150.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:39:09', NULL, 'Paid', 'PAY202412130939098750'),
(130, 'ORD675bf31a9d2bf', 18, 4, 'Bachelor of Science in Management Accounting (BSMA)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569cc76d70c2.80101398.PNG', '2024-12-13 08:40:58', NULL, 'Pending', 'PAY202412130940584173'),
(131, 'ORD202412130941052530704296', 18, 4, 'Bachelor of Science in Management Accounting (BSMA)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569cc76d70c2.80101398.PNG', '2024-12-13 08:41:05', NULL, 'Paid', 'PAY202412130941053399'),
(132, 'ORD675bf3a0a76f8', 18, 7, 'Bachelor of Early Childhood Education (BECED)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569f13208980.41388595.PNG', '2024-12-13 08:43:12', NULL, 'Pending', 'PAY202412130943122420'),
(133, 'ORD202412130943228858783407', 18, 7, 'Bachelor of Early Childhood Education (BECED)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569f13208980.41388595.PNG', '2024-12-13 08:43:22', NULL, 'Paid', 'PAY202412130943223618'),
(134, 'ORD675bf3bad575d', 18, 4, 'Bachelor of Science in Management Accounting (BSMA)', 75.00, 2, 150.00, 'http://localhost:8000/uploads/product_67569cc76d70c2.80101398.PNG', '2024-12-13 08:43:38', NULL, 'Pending', 'PAY202412130943386620'),
(135, 'ORD202412130943459067294263', 18, 4, 'Bachelor of Science in Management Accounting (BSMA)', 75.00, 2, 150.00, 'http://localhost:8000/uploads/product_67569cc76d70c2.80101398.PNG', '2024-12-13 08:43:45', NULL, 'Paid', 'PAY202412130943453545'),
(136, 'ORD675bf405148a3', 18, 8, 'Bachelor of Science Computer Science (BCS)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:44:53', NULL, 'Pending', 'PAY202412130944538851'),
(137, 'ORD202412130945023587605619', 18, 8, 'Bachelor of Science Computer Science (BCS)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 08:45:02', NULL, 'Paid', 'PAY202412130945021926'),
(138, 'ORD675bf527da6ee', 18, 7, 'Bachelor of Early Childhood Education (BECED)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569f13208980.41388595.PNG', '2024-12-13 08:49:43', NULL, 'Pending', 'PAY202412130949433459'),
(139, 'ORD202412130949530467827053', 18, 7, 'Bachelor of Early Childhood Education (BECED)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569f13208980.41388595.PNG', '2024-12-13 08:49:53', NULL, 'Paid', 'PAY202412130949534365'),
(140, 'ORD675bf558f1c7f', 18, 11, 'Bachelor of Science in Industrial Engineering (BSIE)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_6756a036cd9a36.55822817.PNG', '2024-12-13 08:50:32', NULL, 'Pending', 'PAY202412130950323276'),
(141, 'ORD202412130950428870279861', 18, 11, 'Bachelor of Science in Industrial Engineering (BSIE)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_6756a036cd9a36.55822817.PNG', '2024-12-13 08:50:42', NULL, 'Paid', 'PAY202412130950429085'),
(142, 'ORD202412131818', 17, 3, 'Bachelor of Science Computer Science (BCS)', 75.00, 30, 2250.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-13 08:57:15', NULL, 'Pending', 'PAY17340802354897'),
(143, 'ORD202412134713', 17, 3, 'Bachelor of Science Computer Science (BCS)', 75.00, 30, 2250.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-13 08:58:23', NULL, 'Pending', 'PAY17340803036732'),
(144, 'ORD202412136217', 17, 3, 'Bachelor of Science Computer Science (BCS)', 75.00, 30, 2250.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-13 09:00:29', NULL, 'Pending', 'PAY17340804293221'),
(145, 'ORD202412136805', 17, 3, 'Bachelor of Science Computer Science (BCS)', 75.00, 30, 2250.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-13 09:01:06', NULL, 'Pending', 'PAY17340804665159'),
(146, 'ORD202412138861', 17, 3, 'Bachelor of Science Computer Science (BCS)', 75.00, 30, 2250.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-13 09:02:07', NULL, 'Pending', 'PAY17340805274775'),
(148, 'ORD202412131002381888519200', 17, 3, 'Bachelor of Science Computer Science (BCS)', 75.00, 30, 2250.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-13 09:02:38', NULL, 'Paid', 'PAY202412131002386400'),
(149, 'ORD675bf97d5cbed', 17, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 09:08:13', NULL, 'Pending', 'PAY202412131008135771'),
(150, 'ORD202412131008271449054900', 17, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 09:08:27', NULL, 'Paid', 'PAY202412131008276380'),
(151, 'ORD675bf9d2727a6', 18, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 5, 375.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 09:09:38', NULL, 'Pending', 'PAY202412131009388125'),
(152, 'ORD202412131009494623075019', 18, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 5, 375.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 09:09:49', NULL, 'Paid', 'PAY202412131009492966'),
(153, 'ORD675bfab67aaea', 18, 19, 'Jacket (Black)', 600.00, 3, 1800.00, 'http://localhost:8000/uploads/product_6756a310aa2f59.85803338.png', '2024-12-13 09:13:26', NULL, 'Pending', 'PAY202412131013261036'),
(154, 'ORD202412131013330416103643', 18, 19, 'Jacket (Black)', 600.00, 3, 1800.00, 'http://localhost:8000/uploads/product_6756a310aa2f59.85803338.png', '2024-12-13 09:13:33', NULL, 'Paid', 'PAY202412131013335247'),
(155, 'ORD675bfb6c28bf4', 18, 19, 'Jacket (Black)', 600.00, 1, 600.00, 'http://localhost:8000/uploads/product_6756a310aa2f59.85803338.png', '2024-12-13 09:16:28', NULL, 'Pending', 'PAY202412131016285436'),
(156, 'ORD202412131016355368809623', 18, 19, 'Jacket (Black)', 600.00, 1, 600.00, 'http://localhost:8000/uploads/product_6756a310aa2f59.85803338.png', '2024-12-13 09:16:35', NULL, 'Paid', 'PAY202412131016354456'),
(157, 'ORD675bfbd3828af', 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 5, 375.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 09:18:11', NULL, 'Pending', 'PAY202412131018118416'),
(158, 'ORD202412131018175388429884', 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 5, 375.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 09:18:17', NULL, 'Paid', 'PAY202412131018174981'),
(159, 'ORD675bff0473765', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 3, 225.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 09:31:48', NULL, 'Pending', 'PAY202412131031489080'),
(160, 'ORD202412131031591803115476', 18, 3, 'Bachelor of Science in Computer Science (BCS)', 75.00, 3, 225.00, 'http://localhost:8000/uploads/product_67569f53364787.30492816.PNG', '2024-12-13 09:31:59', NULL, 'Pending', 'PAY202412131031599444'),
(161, 'ORD675bff1937bb1', 18, 9, 'Bachelor of Science in Information Technology (BSIT)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569fb1816d59.50711803.PNG', '2024-12-13 09:32:09', NULL, 'Pending', 'PAY202412131032095179'),
(162, 'ORD202412131032159826763095', 18, 9, 'Bachelor of Science in Information Technology (BSIT)', 75.00, 4, 300.00, 'http://localhost:8000/uploads/product_67569fb1816d59.50711803.PNG', '2024-12-13 09:32:15', NULL, 'Paid', 'PAY202412131032153272'),
(163, 'ORD675c0002763d2', 18, 13, 'NSTP Shirt', 250.00, 4, 1000.00, 'http://localhost:8000/uploads/product_6756a1213beec2.83624615.png', '2024-12-13 09:36:02', NULL, 'Pending', 'PAY202412131036026724'),
(164, 'ORD202412131036117373597341', 18, 13, 'NSTP Shirt', 250.00, 4, 1000.00, 'http://localhost:8000/uploads/product_6756a1213beec2.83624615.png', '2024-12-13 09:36:11', NULL, 'Paid', 'PAY202412131036116248'),
(165, 'ORD675c01256f1de', 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 3, 225.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 09:40:53', NULL, 'Pending', 'PAY202412131040534187'),
(166, 'ORD202412131041006119017402', 18, 5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, 3, 225.00, 'http://localhost:8000/uploads/product_67569da8188136.71205525.PNG', '2024-12-13 09:41:00', NULL, 'Paid', 'PAY202412131041005677'),
(167, 'ORD675c01b06012f', 18, 15, 'CBAA Shirt', 199.00, 4, 796.00, 'http://localhost:8000/uploads/product_6756a1ffdec678.71267709.png', '2024-12-13 09:43:12', NULL, 'Pending', 'PAY202412131043127993'),
(168, 'ORD202412131043184145265147', 18, 15, 'CBAA Shirt', 199.00, 4, 796.00, 'http://localhost:8000/uploads/product_6756a1ffdec678.71267709.png', '2024-12-13 09:43:18', NULL, 'Paid', 'PAY202412131043187565'),
(169, 'ORD675c01df2ff67', 18, 17, 'Male Polo', 470.00, 3, 1410.00, 'http://localhost:8000/uploads/product_6756a2593dd7d9.05310333.png', '2024-12-13 09:43:59', NULL, 'Pending', 'PAY202412131043591027'),
(170, 'ORD202412131044080809769316', 18, 17, 'Male Polo', 470.00, 3, 1410.00, 'http://localhost:8000/uploads/product_6756a2593dd7d9.05310333.png', '2024-12-13 09:44:08', NULL, 'Paid', 'PAY202412131044083940'),
(171, 'ORD675c02beeb00c', 18, 11, 'Bachelor of Science in Industrial Engineering (BSIE)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_6756a036cd9a36.55822817.PNG', '2024-12-13 09:47:42', NULL, 'Pending', 'PAY202412131047424889'),
(172, 'ORD202412131047495167091149', 18, 11, 'Bachelor of Science in Industrial Engineering (BSIE)', 75.00, 1, 75.00, 'http://localhost:8000/uploads/product_6756a036cd9a36.55822817.PNG', '2024-12-13 09:47:49', NULL, 'Paid', 'PAY202412131047499219'),
(173, 'ORD675c03827b67f', 18, 14, 'P.E Shirt', 250.00, 2, 500.00, 'http://localhost:8000/uploads/product_6756a1928f62c5.33368374.png', '2024-12-13 09:50:58', NULL, 'Pending', 'PAY202412131050582851'),
(174, 'ORD202412131051085420054038', 18, 14, 'P.E Shirt', 250.00, 2, 500.00, 'http://localhost:8000/uploads/product_6756a1928f62c5.33368374.png', '2024-12-13 09:51:08', NULL, 'Paid', 'PAY202412131051089020'),
(175, 'ORD675c040d8c0f4', 18, 18, 'Male Pants', 470.00, 1, 470.00, 'http://localhost:8000/uploads/product_6756a2884826f7.79784606.png', '2024-12-13 09:53:17', NULL, 'Pending', 'PAY202412131053175562'),
(176, 'ORD202412131053239664306697', 18, 18, 'Male Pants', 470.00, 1, 470.00, 'http://localhost:8000/uploads/product_6756a2884826f7.79784606.png', '2024-12-13 09:53:23', NULL, 'Paid', 'PAY202412131053239668'),
(177, 'ORD675c05a175199', 18, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 2, 150.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 10:00:01', NULL, 'Pending', 'PAY202412131100014728'),
(178, 'ORD202412131101018516551631', 18, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 2, 150.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 10:01:01', NULL, 'Paid', 'PAY202412131101016734'),
(179, 'ORD675c065f24f97', 18, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 2, 150.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 10:03:11', NULL, 'Pending', 'PAY202412131103113243'),
(180, 'ORD202412131103178620717340', 18, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 2, 150.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 10:03:17', NULL, 'Paid', 'PAY202412131103173734'),
(181, 'ORD675c06e7b7dc9', 18, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 5, 375.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 10:05:27', NULL, 'Pending', 'PAY202412131105278018'),
(182, 'ORD202412131105328568224671', 18, 10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, 5, 375.00, 'http://localhost:8000/uploads/product_67569ffedacad5.92496251.PNG', '2024-12-13 10:05:32', NULL, 'Paid', 'PAY202412131105326348');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_type` enum('GCash','Maya') NOT NULL DEFAULT 'GCash',
  `payment_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `user_id`, `payment_type`, `payment_number`, `created_at`) VALUES
(17, 1, 'GCash', NULL, '2024-12-10 08:51:03'),
(18, 1, 'GCash', NULL, '2024-12-10 08:57:25'),
(19, 1, 'GCash', NULL, '2024-12-10 10:17:08'),
(20, 1, '', NULL, '2024-12-10 18:11:24'),
(21, 1, 'GCash', NULL, '2024-12-11 01:27:35'),
(22, 18, 'GCash', NULL, '2024-12-13 07:35:08'),
(23, 18, '', NULL, '2024-12-13 07:39:03'),
(24, 18, '', NULL, '2024-12-13 07:44:02'),
(25, 18, '', NULL, '2024-12-13 07:48:27'),
(26, 18, '', NULL, '2024-12-13 07:52:16'),
(27, 18, '', NULL, '2024-12-13 08:11:46'),
(28, 18, '', NULL, '2024-12-13 08:13:37'),
(29, 18, '', NULL, '2024-12-13 08:13:57'),
(30, 18, '', NULL, '2024-12-13 08:19:40'),
(31, 18, '', NULL, '2024-12-13 08:20:29'),
(32, 18, 'GCash', NULL, '2024-12-13 08:21:36'),
(33, 18, 'GCash', NULL, '2024-12-13 08:39:09'),
(34, 18, 'GCash', NULL, '2024-12-13 08:41:05'),
(35, 18, 'GCash', NULL, '2024-12-13 08:43:22'),
(36, 18, '', NULL, '2024-12-13 08:43:45'),
(37, 18, 'GCash', NULL, '2024-12-13 08:45:02'),
(38, 18, '', NULL, '2024-12-13 08:49:53'),
(39, 18, 'GCash', NULL, '2024-12-13 08:50:42'),
(40, 17, 'GCash', NULL, '2024-12-13 09:02:38'),
(41, 17, 'GCash', NULL, '2024-12-13 09:08:27'),
(42, 18, 'GCash', NULL, '2024-12-13 09:09:49'),
(43, 18, 'GCash', NULL, '2024-12-13 09:13:33'),
(44, 18, '', NULL, '2024-12-13 09:16:35'),
(45, 18, 'GCash', NULL, '2024-12-13 09:18:17'),
(46, 18, '', NULL, '2024-12-13 09:31:59'),
(47, 18, '', NULL, '2024-12-13 09:32:00'),
(48, 18, '', NULL, '2024-12-13 09:32:15'),
(49, 18, '', NULL, '2024-12-13 09:36:11'),
(50, 18, '', NULL, '2024-12-13 09:41:00'),
(51, 18, 'GCash', NULL, '2024-12-13 09:43:18'),
(52, 18, 'GCash', NULL, '2024-12-13 09:44:08'),
(53, 18, 'GCash', NULL, '2024-12-13 09:47:49'),
(54, 18, 'GCash', NULL, '2024-12-13 09:51:08'),
(55, 18, 'GCash', NULL, '2024-12-13 09:53:23'),
(56, 18, 'GCash', NULL, '2024-12-13 10:01:01'),
(57, 18, 'GCash', NULL, '2024-12-13 10:03:17'),
(58, 18, 'GCash', NULL, '2024-12-13 10:05:32');

-- --------------------------------------------------------

--
-- Table structure for table `pending_orders`
--

CREATE TABLE `pending_orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `image_url`, `created_at`, `category`, `description`, `stock_quantity`) VALUES
(1, 'Tumbler Violet', 250.00, '../uploads/product_67565263363751.16010069.PNG', '2024-12-09 02:13:55', 'tumblers', 'The QCU TUMBLER collection features a colorful selection of durable, functional water bottles, emphasizing variety, quality, and style.', 0),
(2, 'Tumbler Red', 250.00, '../uploads/product_675654da3989a2.18568684.PNG', '2024-12-09 02:24:26', 'tumblers', 'The QCU TUMBLER collection features a colorful selection of durable, functional water bottles, emphasizing variety, quality, and style.', 0),
(3, 'Bachelor of Science Computer Science (BCS)', 75.00, '../uploads/product_67569c456c5ef7.63875461.PNG', '2024-12-09 07:29:09', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 11),
(4, 'Bachelor of Science in Management Accounting (BSMA)', 75.00, '../uploads/product_67569cc76d70c2.80101398.PNG', '2024-12-09 07:31:19', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 86),
(5, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 75.00, '../uploads/product_67569da8188136.71205525.PNG', '2024-12-09 07:35:04', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 81),
(6, 'Bachelor of Science in Information Systems (BIS)', 75.00, '../uploads/product_67569e2a5db551.81571066.PNG', '2024-12-09 07:37:14', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.\r\n', 98),
(7, 'Bachelor of Early Childhood Education (BECED)', 75.00, '../uploads/product_67569f13208980.41388595.PNG', '2024-12-09 07:41:07', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 84),
(8, 'Bachelor of Science Computer Science (BCS)', 75.00, '../uploads/product_67569f53364787.30492816.PNG', '2024-12-09 07:42:11', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 91),
(9, 'Bachelor of Science in Information Technology (BSIT)', 75.00, '../uploads/product_67569fb1816d59.50711803.PNG', '2024-12-09 07:43:45', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 92),
(10, 'Bachelor of Science in Electronics Engineering (BSECE)', 75.00, '../uploads/product_67569ffedacad5.92496251.PNG', '2024-12-09 07:45:02', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 64),
(11, 'Bachelor of Science in Industrial Engineering (BSIE)', 75.00, '../uploads/product_6756a036cd9a36.55822817.PNG', '2024-12-09 07:45:58', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 96),
(12, 'Bachelor of Science in Accountancy (BSA)', 75.00, '../uploads/product_6756a0a5a60160.67885630.PNG', '2024-12-09 07:47:49', 'lace', 'The QCU Merch Lanyard collection combines style and durability, offering functional and fashionable lanyards for everyday or special use.', 100),
(13, 'NSTP Shirt', 250.00, '../uploads/product_6756a1213beec2.83624615.png', '2024-12-09 07:49:53', 'college', 'The QCU NSTP T-shirt is a durable, breathable, and stylish green shirt with a patriotic red, white, and blue logo.', 92),
(14, 'P.E Shirt', 250.00, '../uploads/product_6756a1928f62c5.33368374.png', '2024-12-09 07:51:46', 'pe', 'The QCU P.E. T-Shirt is a durable, breathable yellow shirt designed for comfort, visibility, and team spirit during workouts.', 89),
(15, 'CBAA Shirt', 199.00, '../uploads/product_6756a1ffdec678.71267709.png', '2024-12-09 07:53:35', 'college', 'The QCU Merch Uniform is a versatile blue shirt with a stylish design, suitable for both casual and professional settings, offering modern aesthetics and quality.', 92),
(16, 'Female Blouse', 470.00, '../uploads/product_6756a2323aa864.81991127.png', '2024-12-09 07:54:26', 'college', 'The QCU Merch Uniform is a versatile blue shirt with a stylish design, suitable for both casual and professional settings, offering modern aesthetics and quality.', 100),
(17, 'Male Polo', 470.00, '../uploads/product_6756a2593dd7d9.05310333.png', '2024-12-09 07:55:05', 'college', 'The QCU Merch Uniform is a versatile blue shirt with a stylish design, suitable for both casual and professional settings, offering modern aesthetics and quality.', 94),
(18, 'Male Pants', 570.00, '../uploads/product_6756a2884826f7.79784606.png', '2024-12-09 07:55:52', 'college', 'The QCU Merch Uniform is a versatile blue shirt with a stylish design, suitable for both casual and professional settings, offering modern aesthetics and quality.', 98),
(19, 'Jacket (Black)', 600.00, '../uploads/product_6756a310aa2f59.85803338.png', '2024-12-09 07:58:08', 'jackets', 'This stylish jacket, with its prominent logo and sleek design, offers comfort, durability, and versatility for casual or semi-formal occasions, blending fashion with functionality.', 91);

-- --------------------------------------------------------

--
-- Table structure for table `student_numbers`
--

CREATE TABLE `student_numbers` (
  `id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_numbers`
--

INSERT INTO `student_numbers` (`id`, `student_number`, `created_at`, `user_id`) VALUES
(1, '23-2387', '2024-12-05 06:48:33', 0),
(2, '23-2375', '2024-12-05 06:48:33', 0),
(3, '23-2382', '2024-12-05 06:48:33', 0),
(4, '23-2347', '2024-12-05 06:48:33', 0),
(5, '23-2352', '2024-12-05 06:48:33', 0),
(6, '23-2449', '2024-12-05 06:48:33', 0),
(7, '23-2450', '2024-12-05 06:48:33', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `verification_status` tinyint(2) NOT NULL COMMENT '0=no,1yes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `first_name`, `last_name`, `email`, `phone`, `password`, `verify_token`, `verification_status`, `created_at`, `student_number`) VALUES
(1, 'adamnuevo662', 'Adam', 'Nuevo', 'adamnuevo66@gmail.com', '09159617070', 'Qcu@2024merchmart2', '317d0ff178e21f9a75234124e513fac4', 1, '2024-11-10 10:18:21', '23-2449'),
(3, 'adamnuevo66', NULL, NULL, 'adamnuevo666@gmail.com', '', '12345', '62d02a353e0fa975574540ff92040848', 0, '2024-11-10 10:40:22', NULL),
(4, 'adamnuevo6662', NULL, NULL, 'adamnuevo66666@gmail.com', '', '12345', '4e89cd9dacb9296022ddebe0d2e946bf', 0, '2024-11-10 10:57:29', NULL),
(5, 'adamnuevo6622', NULL, NULL, 'adamnuevo6266@gmail.com', '', '1234', '4e39556578c019984e8b79379dee4aca', 0, '2024-11-10 10:58:17', NULL),
(6, 'adamnuevo66', NULL, NULL, 'adamnuevo28@gmail.com', '', '12345', '887a89955e1d7446c6c8464547712520', 1, '2024-11-10 11:42:37', NULL),
(7, 'adamnuevo662', NULL, NULL, 'adamnuevo6666@gmail.com', '', '123456789po', '07be3151a1bcb8b05ece563bbba2a800', 0, '2024-11-14 12:26:31', NULL),
(8, 'Adammmmmmmmmmm', NULL, NULL, 'adamnuevo62266@gmail.com', '', '123456', '5150b004f7dca1c73eed6ae3e931292f', 0, '2024-11-17 09:51:15', NULL),
(9, 'angelonigga', NULL, NULL, 'angelopan3s@gmail.com', '', '123456789', '5e96cb960630312f24577d4303d14657', 1, '2024-11-19 16:22:51', NULL),
(10, 'adadad', NULL, NULL, 'adamnuevo622666@gmail.com', '', 'adadada', '291bfe83e3be43a487dd9d72b9c7105f', 0, '2024-11-26 07:25:54', NULL),
(11, 'adamnuevo6622', NULL, NULL, 'hanscodm33@gmail.com', '', '123123', 'c66ffb1d4ab00e9748a27ec7053c1b94', 0, '2024-11-26 07:28:28', NULL),
(12, 'titiii', NULL, NULL, 'paraiso.maryfaye.carag@gmail.com', '', 'Ahahah@123', 'aa0592ca24d60e037441fa5dfe8f18cf', 0, '2024-11-26 07:38:23', NULL),
(13, 'adamnuevo662222', NULL, NULL, 'adamnuevo6226@gmail.com', '', '$2y$10$QeqtJo68btjSFYJYbgB1MO8g9vCpdNuStCPxUjk2JF88B9aWrCsmC', '199c6ad4405831cf3fd7aff298fda0c8', 0, '2024-12-05 07:18:52', NULL),
(14, 'adamnuevo6622222', NULL, NULL, 'adamnuevo66222@gmail.com', '', 'Qcu@2024merchmart1', '9530f559c6ebc5aa3a28e33cc1d6d34b', 0, '2024-12-05 07:21:26', NULL),
(17, 'Torioo', 'Vincent', 'Torio', 'vincenttorio07@gmail.com', '09159617070', 'Qcu@2024merchmart2', '3bb8fa72a1d6ed10ab108045d6ef1e7e', 1, '2024-12-05 08:11:41', '23-2450'),
(18, 'Hanscodm3', 'Hans', 'Codm', 'hanscodm3@gmail.com', '09159617070', 'Qcu@2024merchmart1', '516375ace4f3eb12835f0cdea5276e41', 1, '2024-12-13 06:38:21', '23-2441');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_product` (`user_id`,`product_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_favorites_user` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_numbers`
--
ALTER TABLE `student_numbers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_number` (`student_number`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `pending_orders`
--
ALTER TABLE `pending_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `student_numbers`
--
ALTER TABLE `student_numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `fk_favorites_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `fk_payment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
