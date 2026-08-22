-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 17 أبريل 2026 الساعة 10:12
-- إصدار الخادم: 8.0.41
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wecrochet`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admin`
--

CREATE TABLE `admin` (
  `A_ID` int NOT NULL,
  `A_UserName` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `A_Password` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `A_Email` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admin`
--

INSERT INTO `admin` (`A_ID`, `A_UserName`, `A_Password`, `A_Email`) VALUES
(1, 'Zakiyah_admin', 'Z_12345', '2240005958@iau.edu.sa');

-- --------------------------------------------------------

--
-- بنية الجدول `products`
--

CREATE TABLE `products` (
  `P_ID` int NOT NULL,
  `P_Name` varchar(255) NOT NULL,
  `P_Price` decimal(10,2) NOT NULL,
  `P_Stock` int NOT NULL,
  `P_Image` varchar(255) DEFAULT NULL,
  `P_Description` text,
  `P_Category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `products`
--

INSERT INTO `products` (`P_ID`, `P_Name`, `P_Price`, `P_Stock`, `P_Image`, `P_Description`, `P_Category`) VALUES
(1, 'Cute Fox Doll', 45.00, 20, 'fox.jpg', 'Premium handmade crochet fox crafted with high-quality yarn, featuring a soft texture and charming design. Perfect as a gift or decorative piece.', 'Crochet Toys'),
(2, 'Crochet Owl', 40.00, 100, 'owl.jpg', 'Adorable handcrafted owl made with precision stitching and soft materials, designed to bring warmth and personality to any space.', 'Crochet Toys'),
(3, 'Lion Plush Toy', 55.00, 90, 'lion.jpg', 'Lion handmade crochet toy with soft yarn and detailed mane, suitable for decoration and gifts.', 'Crochet Toys'),
(4, 'Blue Dinosaur Toy', 60.00, 80, 'dinosaur.jpg', 'Cute handmade crochet dinosaur with a friendly look and neat details, perfect for children and toy collections.', 'Crochet Toys'),
(5, 'Giraffe Doll', 48.00, 70, 'giraffe.jpg', 'Handmade crochet giraffe with a soft texture and attractive pattern, ideal for gifting and room decoration.', 'Crochet Toys'),
(6, 'Daisy Crochet Bouquet', 120.00, 30, 'daisy.jpg', 'Charming handmade daisy crochet bouquet featuring soft white petals and vibrant yellow centers, designed to add a fresh and elegant touch to any occasion.', 'Crochet Flowers'),
(7, 'Blue Rose Crochet Bouquet', 140.00, 20, 'blue_roses.jpg', 'Stylish handcrafted bouquet with deep blue crochet roses and delicate white flowers, offering a modern and sophisticated decorative piece.', 'Crochet Flowers'),
(8, 'Pink Floral Crochet Bouquet', 150.00, 30, 'pink_flowers.jpg', 'Romantic pink crochet flower arrangement made with high-quality yarn, perfect for gifts, celebrations, and special moments.', 'Crochet Flowers'),
(9, 'Lavender Luxury Bouquet', 130.00, 20, 'lavender.jpg', 'Premium lavender crochet bouquet with detailed craftsmanship and elegant wrapping, ideal for weddings and luxury gifting.', 'Crochet Flowers'),
(10, 'Sunflower Mixed Bouquet', 140.00, 20, 'sunflower.jpg', 'Bright sunflower crochet bouquet combined with soft pastel flowers, creating a cheerful and artistic handmade arrangement.', 'Crochet Flowers');

-- --------------------------------------------------------

--
-- بنية الجدول `reviews`
--

CREATE TABLE `reviews` (
  `R_ID` int NOT NULL,
  `P_ID` int NOT NULL,
  `R_Name` varchar(100) NOT NULL,
  `R_Rating` tinyint NOT NULL,
  `R_Comment` text,
  `R_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `O_ID` int NOT NULL,
  `O_Name` varchar(100) NOT NULL,
  `O_Phone` varchar(30) NOT NULL,
  `O_Address` varchar(255) NOT NULL,
  `O_City` varchar(100) NOT NULL,
  `O_PaymentMethod` varchar(50) NOT NULL,
  `O_Total` decimal(10,2) NOT NULL,
  `O_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `order_items`
--

CREATE TABLE `order_items` (
  `OI_ID` int NOT NULL,
  `O_ID` int NOT NULL,
  `P_ID` int NOT NULL,
  `OI_Name` varchar(255) NOT NULL,
  `OI_Price` decimal(10,2) NOT NULL,
  `OI_Quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`A_ID`),
  ADD UNIQUE KEY `A_ID` (`A_ID`,`A_UserName`,`A_Password`,`A_Email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`P_ID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`R_ID`),
  ADD KEY `P_ID` (`P_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`O_ID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OI_ID`),
  ADD KEY `O_ID` (`O_ID`),
  ADD KEY `P_ID` (`P_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `P_ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `R_ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `O_ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OI_ID` int NOT NULL AUTO_INCREMENT;

--
-- قيود الجدول `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`P_ID`) REFERENCES `products` (`P_ID`) ON DELETE CASCADE;

--
-- قيود الجدول `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`O_ID`) REFERENCES `orders` (`O_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`P_ID`) REFERENCES `products` (`P_ID`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
