-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 08:34 PM
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
-- Database: `ikeh_furniture`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'FiziAdminGacor', 'mhafizfenaldhie2904@gmail.com', '$2y$10$MsbzivJCtYdHNlLXO9ohQ.X6oHAYukBZMIY//Ex2IrgPTC2OUHfXm', '2024-11-30 15:10:03'),
(2, 'Remon2', 'remon@gmail.com', '$2y$10$NhIyp6zzpGUJhdRqZP9Tk.6kI1bKp/NEecNEOIUemhyrOzVbxc7mG', '2024-11-30 15:10:34');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `furniture_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `furniture_id`, `quantity`) VALUES
(86, 10, 5, 1),
(87, 10, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `furniture`
--

CREATE TABLE `furniture` (
  `furniture_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `furniture`
--

INSERT INTO `furniture` (`furniture_id`, `name`, `description`, `price`, `stock`, `image`) VALUES
(1, 'Modern Sofa', 'A comfortable modern sofa with a sleek design, perfect for any living room.', 1500.00, 1493, 'modern_sofa1.jpg'),
(2, 'Classic Wooden Chair', 'A sturdy wooden chair made from high-quality oak wood.', 200.00, 87, 'classic_wooden_chair1.jpg'),
(3, 'Glass Coffee Table', 'A minimalist glass coffee table with a steel frame.', 350.00, 1678, 'glass_coffee_table1.jpg'),
(4, 'Luxury King Bed', 'A luxurious king-sized bed with a memory foam mattress.', 2500.00, 4, 'luxury_king_bed1.jpg'),
(5, 'Bookshelf', 'A modern bookshelf with 5 shelves, made from durable materials.', 180.00, 17, 'bookshelf1.jpg'),
(6, 'Leather Recliner', 'A premium leather recliner, offering the ultimate in comfort and style.', 1200.00, 7, 'leather_recliner1.jpg'),
(7, 'Dining Table Set', 'A complete dining table set with 6 chairs, made from polished wood.', 1800.00, 12, 'dining_table_set1.jpg'),
(8, 'Office Desk', 'A sleek office desk with a smooth finish and ample storage space.', 750.00, 18, 'office_desk1.jpg'),
(9, 'Accent Chair', 'A stylish accent chair with soft upholstery and a contemporary design.', 500.00, 14, 'accent_chair1.jpg'),
(10, 'Wardrobe', 'A large wooden wardrobe with sliding doors and ample storage for clothes.', 1300.00, 8, 'wardrobe1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_amount` decimal(15,2) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `is_deleted`) VALUES
(44, 10, '2024-12-01 00:37:50', 1500.00, 0),
(45, 10, '2024-12-01 00:38:26', 1500.00, 0),
(46, 10, '2024-12-01 01:13:30', 1500.00, 0),
(53, 10, '2024-12-02 11:05:18', 2400.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_details_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `furniture_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_details_id`, `order_id`, `furniture_id`, `quantity`, `price`) VALUES
(54, 44, 1, 1, 1500.00),
(55, 45, 1, 1, 1500.00),
(56, 46, 1, 1, 1500.00),
(70, 53, 9, 4, 500.00),
(71, 53, 2, 2, 200.00);

-- --------------------------------------------------------

--
-- Stand-in structure for view `order_summary`
-- (See below for the actual view)
--
CREATE TABLE `order_summary` (
`Order ID` int(11)
,`Customer Name` varchar(100)
,`Furniture Name` varchar(100)
,`Quantity` int(11)
,`Price` decimal(15,2)
,`Order Date` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE `shipment` (
  `shipment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `shipment_date` datetime DEFAULT current_timestamp(),
  `delivery_status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipment`
--

INSERT INTO `shipment` (`shipment_id`, `order_id`, `address`, `shipment_date`, `delivery_status`) VALUES
(7, 44, '', '2024-12-01 00:37:50', 'Delivered'),
(8, 45, '', '2024-12-01 00:38:26', 'Shipped'),
(9, 46, '', '2024-12-01 01:13:30', 'Confirmed'),
(20, 53, '', '2024-12-02 11:05:18', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`, `phone`, `created_at`) VALUES
(10, 'Fizi', 'mhafizfenaldhie2904@gmail.com', '$2y$10$2V2nuBTlK3roXvMZBQz/mOGfg3DHoS5mIAKUWF2J1ApTOeTKucq/S', 'Jl. Raja Isa, Bisa Asri 1 Blok B1', '081267658409', '2024-10-28 19:02:17'),
(15, 'rayhanAP', 'rap@gmail.com', '$2y$10$mTDGX3At92UhwP6Y4ga9wePrGaa/kFw0W35aed89dlwxoUdJOrpg.', 'Jl. Raja Isa, Bisa Asri 1 Blok B1', '081267658408', '2024-12-02 11:09:32');

-- --------------------------------------------------------

--
-- Structure for view `order_summary`
--
DROP TABLE IF EXISTS `order_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `order_summary`  AS SELECT `o`.`order_id` AS `Order ID`, `u`.`name` AS `Customer Name`, `f`.`name` AS `Furniture Name`, `d`.`quantity` AS `Quantity`, `d`.`price` AS `Price`, `o`.`order_date` AS `Order Date` FROM (((`orders` `o` join `users` `u` on(`o`.`user_id` = `u`.`id`)) join `order_details` `d` on(`o`.`order_id` = `d`.`order_id`)) join `furniture` `f` on(`d`.`furniture_id` = `f`.`furniture_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `furniture_id` (`furniture_id`);

--
-- Indexes for table `furniture`
--
ALTER TABLE `furniture`
  ADD PRIMARY KEY (`furniture_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_details_id`),
  ADD KEY `idx_order_id` (`order_id`),
  ADD KEY `idx_furniture_id` (`furniture_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`shipment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `furniture`
--
ALTER TABLE `furniture`
  MODIFY `furniture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipment`
--
ALTER TABLE `shipment`
  MODIFY `shipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`furniture_id`) REFERENCES `furniture` (`furniture_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`furniture_id`) REFERENCES `furniture` (`furniture_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `shipment`
--
ALTER TABLE `shipment`
  ADD CONSTRAINT `shipment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
