-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 09:28 AM
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
(2, 6, 5, 'QCU ID Lace', 50.00, 10, 500.00, 'http://localhost:8000/assets/images/bcs.PNG', '2024-11-19 11:05:17'),
(15, 1, 1, 'QCU Lanyard', 70.00, 2, 140.00, 'http://localhost:8000/assets/images/IMG_0052.PNG', '2024-11-28 11:44:05'),
(16, 1, 2, 'Bachelor of Early Childhood Education (BECED)', 70.00, 5, 350.00, 'http://localhost:8000/assets/images/beced.PNG', '2024-11-28 11:47:35'),
(17, 1, 11, 'Jacket', 50.00, 1, 50.00, 'http://localhost:8000/assets/images/jacket.png', '2024-11-28 11:47:43'),
(18, 1, 12, 'CBAA Shirt', 199.00, 1, 199.00, 'http://localhost:8000/assets/images/cbaa.png', '2024-11-29 11:04:45');

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
(1, 1, 1, 'Bachelor of Science Computer Science (BCS)', 70.00, 'http://localhost:8000/assets/images/bcs.PNG', '2024-11-28 10:23:08'),
(2, 1, 2, 'Bachelor of Early Childhood Education (BECED)', 70.00, 'http://localhost:8000/assets/images/beced.PNG', '2024-11-28 10:37:12'),
(3, 1, 3, 'Bachelor of Science in Information Systems (BIS)', 70.00, 'http://localhost:8000/assets/images/bis.PNG', '2024-11-28 10:42:23'),
(4, 1, 4, 'Bachelor of Science in Accountancy (BSA)', 70.00, 'http://localhost:8000/assets/images/bsa.PNG', '2024-11-28 10:42:25'),
(5, 1, 6, 'Bachelor of Science in Electronics Engineering (BSECE)', 70.00, 'http://localhost:8000/assets/images/bsece.PNG', '2024-11-28 10:42:28'),
(6, 1, 11, 'Jacket', 50.00, 'http://localhost:8000/assets/images/jacket.png', '2024-11-28 11:08:46'),
(7, 1, 12, 'CBAA Shirt', 199.00, 'http://localhost:8000/assets/images/cbaa.png', '2024-11-28 11:08:48'),
(8, 1, 10, 'Bachelor of Science in Management Accounting (BSMA)', 70.00, 'http://localhost:8000/assets/images/bsma.PNG', '2024-11-28 11:08:50'),
(9, 1, 9, 'Bachelor of Science in Information Technology (BSIT)', 70.00, 'http://localhost:8000/assets/images/bsit.PNG', '2024-11-29 09:10:10'),
(10, 1, 8, 'Bachelor of Science in Industrial Engineering (BSIE)', 70.00, 'http://localhost:8000/assets/images/bsie.PNG', '2024-11-29 09:10:15'),
(11, 1, 7, 'Bachelor of Science in Entrepreneurship (BSENTREP)', 70.00, 'http://localhost:8000/assets/images/bsentrep.PNG', '2024-11-29 09:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `image_url` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `claim_date` datetime DEFAULT NULL,
  `status` enum('Pending','Ready for pickup','Claimed','Cancelled') DEFAULT 'Pending'
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,  -- This is the username
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verify_token` varchar(255) DEFAULT NULL,
  `verification_status` tinyint(2) NOT NULL COMMENT '0=no,1yes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `phone`, `password`, `verify_token`, `verification_status`, `created_at`) VALUES
(1, 'adamnuevo662', 'adamnuevo66@gmail.com', '09159617070', 'Qcu@2024merchmart1', '317d0ff178e21f9a75234124e513fac4', 1, '2024-11-10 10:18:21'),
(2, 'adamnuevo66', 'hanscodm3@gmail.com', '', '12345', 'b9cd048c47cf2834d77dda5ca43e266b', 0, '2024-11-10 10:39:26'),
(3, 'adamnuevo66', 'adamnuevo666@gmail.com', '', '12345', '62d02a353e0fa975574540ff92040848', 0, '2024-11-10 10:40:22'),
(4, 'adamnuevo6662', 'adamnuevo66666@gmail.com', '', '12345', '4e89cd9dacb9296022ddebe0d2e946bf', 0, '2024-11-10 10:57:29'),
(5, 'adamnuevo6622', 'adamnuevo6266@gmail.com', '', '1234', '4e39556578c019984e8b79379dee4aca', 0, '2024-11-10 10:58:17'),
(6, 'adamnuevo66', 'adamnuevo28@gmail.com', '', '12345', '887a89955e1d7446c6c8464547712520', 1, '2024-11-10 11:42:37'),
(7, 'adamnuevo662', 'adamnuevo6666@gmail.com', '', '123456789po', '07be3151a1bcb8b05ece563bbba2a800', 0, '2024-11-14 12:26:31'),
(8, 'Adammmmmmmmmmm', 'adamnuevo62266@gmail.com', '', '123456', '5150b004f7dca1c73eed6ae3e931292f', 0, '2024-11-17 09:51:15'),
(9, 'angelonigga', 'angelopan3s@gmail.com', '', '123456789', '5e96cb960630312f24577d4303d14657', 1, '2024-11-19 16:22:51'),
(10, 'adadad', 'adamnuevo622666@gmail.com', '', 'adadada', '291bfe83e3be43a487dd9d72b9c7105f', 0, '2024-11-26 07:25:54'),
(11, 'adamnuevo6622', 'hanscodm33@gmail.com', '', '123123', 'c66ffb1d4ab00e9748a27ec7053c1b94', 0, '2024-11-26 07:28:28'),
(12, 'titiii', 'paraiso.maryfaye.carag@gmail.com', '', 'Ahahah@123', 'aa0592ca24d60e037441fa5dfe8f18cf', 0, '2024-11-26 07:38:23');

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
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
