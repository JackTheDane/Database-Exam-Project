-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Vært: 127.0.0.1
-- Genereringstid: 31. 05 2018 kl. 12:17:57
-- Serverversion: 10.1.30-MariaDB
-- PHP-version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbexam`
--

-- --------------------------------------------------------

--
-- Stand-in-struktur for visning `all_product_data`
-- (Se nedenfor for det aktuelle view)
--
CREATE TABLE `all_product_data` (
`iId` bigint(20) unsigned
,`sName` varchar(60)
,`iNumberInStore` smallint(5) unsigned
,`rPrice` double unsigned
,`sDescription` text
,`sImgPath` varchar(100)
);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `cities`
--

CREATE TABLE `cities` (
  `iId` mediumint(8) UNSIGNED NOT NULL,
  `iZipCode` smallint(5) UNSIGNED NOT NULL,
  `sName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `cities`
--

INSERT INTO `cities` (`iId`, `iZipCode`, `sName`) VALUES
(1, 3300, 'Frederiksværk'),
(2, 3390, 'Hundested'),
(7, 2820, 'Gentofte'),
(9, 2800, 'Lyngby'),
(11, 2300, 'København S'),
(17, 2630, 'Taastrup');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `products`
--

CREATE TABLE `products` (
  `iId` bigint(20) UNSIGNED NOT NULL,
  `sName` varchar(60) NOT NULL,
  `iNumberInStore` smallint(5) UNSIGNED NOT NULL,
  `rPrice` double UNSIGNED NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `products`
--

INSERT INTO `products` (`iId`, `sName`, `iNumberInStore`, `rPrice`, `isActive`) VALUES
(24, 'Boots - brown', 2, 599.95, 1),
(25, 'Bow tie', 30, 450, 0),
(26, 'Fine shoes', 29, 49, 0),
(27, 'Dress w. shoes combo', 30, 299, 0),
(28, 'Dress', 29, 999, 1),
(29, 'Polo shirt - green', 30, 349, 1),
(30, 'T-shirt - red', 30, 149, 1),
(31, 'Cap - green', 29, 299.95, 1),
(32, 'Handbag', 30, 695, 1),
(33, 'Striped bag', 30, 599.95, 1),
(34, 'Belt', 30, 95, 0),
(35, 'Blazer - green', 30, 850, 1),
(36, 'Small handbag', 30, 499.95, 1),
(37, 'Purple dress', 30, 645, 1),
(38, 'Summer hat', 30, 250, 1),
(39, 'Bowler hat', 30, 699, 1),
(40, 'Hoodie', 30, 230, 1),
(41, 'Formal dress', 30, 899.95, 1),
(42, 'Polo shirt - striped', 30, 299.95, 1),
(43, 'Formal shirt', 30, 499, 1),
(44, 'T-shirt with bear', 30, 159, 1),
(45, 'Formal shoes', 25, 699, 1),
(46, 'Undershirt', 29, 149, 1),
(47, 'Slippers - blue', 30, 345, 1),
(48, 'Shorts - orange', 30, 299, 1),
(49, 'Skirt - green', 30, 199.95, 1),
(50, 'Skirt - blue', 30, 299.95, 1),
(51, 'Sneakers', 30, 399, 1),
(52, 'Sweater - red', 30, 350, 1),
(53, 'Top hat', 30, 999.95, 1),
(54, 'Jeans - blue', 30, 459.95, 1),
(55, 'Underwear - pink', 30, 395, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `product_categories`
--

CREATE TABLE `product_categories` (
  `iId` smallint(5) UNSIGNED NOT NULL,
  `sName` varchar(20) NOT NULL,
  `isActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `product_categories`
--

INSERT INTO `product_categories` (`iId`, `sName`, `isActive`) VALUES
(3, 'Shoes', 1),
(4, 'Dresses', 1),
(5, 'Shirts', 1),
(6, 'Hats', 1),
(7, 'Accessories', 1),
(8, 'Underwear', 1),
(9, 'Jackets', 1),
(10, 'Skirts', 1),
(11, 'Formal', 1),
(12, 'Bags', 1),
(13, 'Pants', 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `product_category_relationship`
--

CREATE TABLE `product_category_relationship` (
  `iProductId` bigint(20) UNSIGNED NOT NULL,
  `iCategoryId` smallint(5) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `product_category_relationship`
--

INSERT INTO `product_category_relationship` (`iProductId`, `iCategoryId`) VALUES
(27, 3),
(27, 4),
(26, 3),
(24, 3),
(28, 4),
(29, 5),
(30, 5),
(32, 7),
(32, 12),
(31, 6),
(33, 7),
(33, 12),
(35, 9),
(35, 11),
(36, 7),
(36, 11),
(36, 12),
(37, 4),
(37, 11),
(38, 6),
(39, 6),
(39, 11),
(40, 5),
(41, 4),
(41, 11),
(42, 5),
(43, 5),
(43, 11),
(44, 5),
(45, 3),
(45, 11),
(46, 8),
(47, 3),
(48, 13),
(49, 10),
(50, 10),
(51, 3),
(52, 5),
(53, 6),
(53, 11),
(54, 13),
(55, 8),
(34, 7);

-- --------------------------------------------------------

--
-- Stand-in-struktur for visning `product_category_relationships_with_names`
-- (Se nedenfor for det aktuelle view)
--
CREATE TABLE `product_category_relationships_with_names` (
`iProductId` bigint(20) unsigned
,`iCategoryId` smallint(5) unsigned
,`sName` varchar(20)
);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `product_descriptions`
--

CREATE TABLE `product_descriptions` (
  `iId` bigint(20) UNSIGNED NOT NULL,
  `iProductId` bigint(20) UNSIGNED NOT NULL,
  `sDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `product_descriptions`
--

INSERT INTO `product_descriptions` (`iId`, `iProductId`, `sDescription`) VALUES
(3, 24, 'A set of brown leather boots. Perfect for long walks in the forests or in the mountains. Available in many sizes.'),
(4, 25, 'A dress not meant to be on the main site.'),
(23, 26, ''),
(24, 28, 'A lovely purple dress'),
(25, 33, 'A nice bag for long walks.'),
(28, 29, ''),
(29, 30, 'Mmm... Donuts...'),
(30, 31, ''),
(33, 32, 'A nice purse for casual use.'),
(37, 36, 'A great handbag for both formal and casual use.'),
(38, 37, 'Lovely dress'),
(39, 38, 'To keep the sun off your face'),
(40, 39, 'Great for formal use'),
(41, 40, 'Orange hoodie, great for winters'),
(42, 43, 'A great shirt for looking dapper.'),
(43, 48, 'Great for summers'),
(44, 53, 'Its like magic!'),
(45, 55, 'Comfortable and supportive.'),
(47, 34, '');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `product_images`
--

CREATE TABLE `product_images` (
  `iId` bigint(20) UNSIGNED NOT NULL,
  `iProductId` bigint(20) UNSIGNED NOT NULL,
  `sImgPath` varchar(100) NOT NULL COMMENT 'Path relative to the "product_images" folder'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `product_images`
--

INSERT INTO `product_images` (`iId`, `iProductId`, `sImgPath`) VALUES
(5, 24, 'prod24_5b0420b2e03a1.png'),
(6, 25, 'prod25_5b05a57113475.png'),
(8, 26, 'prod26_5b05a960273c1.png'),
(9, 28, 'prod28_5b071a02087f5.png'),
(10, 29, 'prod29_5b07ca5ba842e.png'),
(11, 30, 'prod30_5b07ca730baa2.png'),
(12, 31, 'prod31_5b07ca8703eea.png'),
(13, 32, 'prod32_5b07ca947fab0.png'),
(14, 33, 'prod33_5b0fa75c7a24f.png'),
(15, 34, 'prod34_5b0fa95d177f3.png'),
(16, 35, 'prod35_5b0fa97df0c1e.png'),
(17, 36, 'prod36_5b0fa9a60774e.png'),
(18, 37, 'prod37_5b0fa9ed71303.png'),
(19, 38, 'prod38_5b0faa138e228.png'),
(20, 39, 'prod39_5b0faa2a04a77.png'),
(21, 40, 'prod40_5b0faa477fb3b.png'),
(22, 41, 'prod41_5b0faa597837f.png'),
(23, 42, 'prod42_5b0faa876a75e.png'),
(24, 43, 'prod43_5b0faaa9549cd.png'),
(25, 44, 'prod44_5b0faac120b00.png'),
(26, 45, 'prod45_5b0faae5583d1.png'),
(27, 46, 'prod46_5b0faaf3727e0.png'),
(28, 47, 'prod47_5b0fab092d9aa.png'),
(29, 48, 'prod48_5b0fab1dd3daa.png'),
(30, 49, 'prod49_5b0fab35aaef9.png'),
(31, 50, 'prod50_5b0fab514db40.png'),
(32, 51, 'prod51_5b0fab61794d2.png'),
(33, 52, 'prod52_5b0fab7938432.png'),
(34, 53, 'prod53_5b0fab95cf76e.png'),
(35, 54, 'prod54_5b0fabac93d49.png'),
(36, 55, 'prod55_5b0fabd340a59.png');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE `users` (
  `iId` bigint(20) UNSIGNED NOT NULL,
  `sFirstName` varchar(20) NOT NULL,
  `sLastName` varchar(20) NOT NULL,
  `sEmail` varchar(50) NOT NULL,
  `sPassword` varbinary(255) NOT NULL,
  `sAddress` varchar(50) NOT NULL COMMENT 'The street and street number of the user',
  `iCityId` mediumint(8) UNSIGNED NOT NULL COMMENT 'Id for the city lookup table',
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`iId`, `sFirstName`, `sLastName`, `sEmail`, `sPassword`, `sAddress`, `iCityId`, `isAdmin`, `isActive`) VALUES
(22, 'Martin', 'Petersen', 'a@a.com', 0x24327924313024727a556e6e542e5650745578414d5732396c6935762e37632e5a484e6a3369735569443652522e33426c6c59754467355047483661, 'Random place 20', 2, 1, 1),
(23, 'Other', 'User', 't@u.com', 0x24327924313024757253497a38506c584a67357575376b38326c72477563495757532e672e5649795273682f676c57526377796a686873616e315561, 'Test st. 3', 2, 0, 1),
(24, 'Kim', 'Larsen', 'b@a.com', 0x2432792431302446693543796b2f75647a54634d4d4c36535779654a2e4d6a2f65423076584a2e712f6f797637344835424e74306d4172624169554f, 'Park ave 29', 2, 0, 1),
(25, 'Elisabeth', 'Test', 'e@t.com', 0x243279243130244b34432f534b62673558464b58385a7769586575504f645a576541784465375547495930656c4f752e754e3559494d652e59664e47, 'Test st. 3', 1, 0, 1),
(27, 'Lars', 'Larsen', 'la@la.com', 0x243279243130244e474b68774256524d3246444164636a6d645750362e716541335a554166635132384a72592e353678596f50786c37744a786b3336, 'Test st. 3', 1, 0, 0);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user_order_history`
--

CREATE TABLE `user_order_history` (
  `iId` bigint(20) UNSIGNED NOT NULL,
  `iUserId` bigint(20) UNSIGNED NOT NULL,
  `iProductId` bigint(20) UNSIGNED NOT NULL,
  `rAmountPaid` double NOT NULL,
  `dTimeOfPurchase` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `user_order_history`
--

INSERT INTO `user_order_history` (`iId`, `iUserId`, `iProductId`, `rAmountPaid`, `dTimeOfPurchase`) VALUES
(4, 25, 24, 599, '2018-05-30 17:25:26'),
(5, 25, 24, 599, '2018-05-30 17:25:59'),
(6, 25, 24, 599, '2018-05-30 17:27:50'),
(7, 25, 24, 599, '2018-05-30 17:27:52'),
(8, 22, 24, 599, '2018-05-30 17:28:57'),
(9, 22, 24, 599, '2018-05-30 17:30:04'),
(10, 22, 24, 599, '2018-05-30 17:30:21'),
(11, 22, 24, 599, '2018-05-30 17:30:23'),
(12, 22, 24, 599, '2018-05-30 17:30:30'),
(13, 22, 24, 599, '2018-05-30 17:39:17'),
(14, 22, 24, 599, '2018-05-30 17:39:18'),
(15, 22, 28, 999, '2018-05-30 17:39:26'),
(16, 22, 24, 599, '2018-05-30 17:43:05'),
(17, 22, 24, 599, '2018-05-30 17:50:20'),
(18, 22, 31, 299, '2018-05-31 07:32:34'),
(19, 22, 28, 999, '2018-05-31 10:54:51'),
(20, 22, 46, 149, '2018-05-31 10:59:54'),
(21, 22, 28, 999, '2018-05-31 12:06:51');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `user_wishlist`
--

CREATE TABLE `user_wishlist` (
  `iId` bigint(20) UNSIGNED NOT NULL,
  `iUserId` bigint(20) UNSIGNED NOT NULL,
  `iProductId` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `user_wishlist`
--

INSERT INTO `user_wishlist` (`iId`, `iUserId`, `iProductId`) VALUES
(36, 23, 31),
(37, 23, 28),
(39, 23, 24),
(40, 25, 24),
(43, 22, 24),
(45, 22, 31),
(46, 22, 37),
(47, 22, 51),
(53, 22, 36),
(55, 22, 33),
(57, 22, 32);

-- --------------------------------------------------------

--
-- Struktur for visning `all_product_data`
--
DROP TABLE IF EXISTS `all_product_data`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `all_product_data`  AS  select `products`.`iId` AS `iId`,`products`.`sName` AS `sName`,`products`.`iNumberInStore` AS `iNumberInStore`,`products`.`rPrice` AS `rPrice`,`product_descriptions`.`sDescription` AS `sDescription`,`product_images`.`sImgPath` AS `sImgPath` from ((`products` left join `product_descriptions` on((`products`.`iId` = `product_descriptions`.`iProductId`))) left join `product_images` on((`products`.`iId` = `product_images`.`iProductId`))) where (`products`.`isActive` = 1) ;

-- --------------------------------------------------------

--
-- Struktur for visning `product_category_relationships_with_names`
--
DROP TABLE IF EXISTS `product_category_relationships_with_names`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_category_relationships_with_names`  AS  select `product_category_relationship`.`iProductId` AS `iProductId`,`product_category_relationship`.`iCategoryId` AS `iCategoryId`,`product_categories`.`sName` AS `sName` from (`product_category_relationship` left join `product_categories` on(((`product_category_relationship`.`iCategoryId` = `product_categories`.`iId`) and (`product_categories`.`isActive` = 1)))) ;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`iId`),
  ADD UNIQUE KEY `iZipCode` (`iZipCode`),
  ADD UNIQUE KEY `sName` (`sName`);

--
-- Indeks for tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`iId`);

--
-- Indeks for tabel `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`iId`);

--
-- Indeks for tabel `product_category_relationship`
--
ALTER TABLE `product_category_relationship`
  ADD KEY `iProductId` (`iProductId`),
  ADD KEY `iCategoryId` (`iCategoryId`);

--
-- Indeks for tabel `product_descriptions`
--
ALTER TABLE `product_descriptions`
  ADD PRIMARY KEY (`iId`),
  ADD UNIQUE KEY `iProductId_2` (`iProductId`),
  ADD KEY `iProductId` (`iProductId`);

--
-- Indeks for tabel `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`iId`),
  ADD UNIQUE KEY `iProductId_2` (`iProductId`),
  ADD KEY `iProductId` (`iProductId`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iId`),
  ADD UNIQUE KEY `sEmail` (`sEmail`),
  ADD KEY `iCityId` (`iCityId`);

--
-- Indeks for tabel `user_order_history`
--
ALTER TABLE `user_order_history`
  ADD PRIMARY KEY (`iId`),
  ADD KEY `iUserId` (`iUserId`),
  ADD KEY `iProductId` (`iProductId`);

--
-- Indeks for tabel `user_wishlist`
--
ALTER TABLE `user_wishlist`
  ADD PRIMARY KEY (`iId`),
  ADD KEY `iUserId` (`iUserId`),
  ADD KEY `iProductId` (`iProductId`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `cities`
--
ALTER TABLE `cities`
  MODIFY `iId` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tilføj AUTO_INCREMENT i tabel `products`
--
ALTER TABLE `products`
  MODIFY `iId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Tilføj AUTO_INCREMENT i tabel `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `iId` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tilføj AUTO_INCREMENT i tabel `product_descriptions`
--
ALTER TABLE `product_descriptions`
  MODIFY `iId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Tilføj AUTO_INCREMENT i tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `iId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `iId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tilføj AUTO_INCREMENT i tabel `user_order_history`
--
ALTER TABLE `user_order_history`
  MODIFY `iId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tilføj AUTO_INCREMENT i tabel `user_wishlist`
--
ALTER TABLE `user_wishlist`
  MODIFY `iId` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `product_category_relationship`
--
ALTER TABLE `product_category_relationship`
  ADD CONSTRAINT `product_category_relationship_ibfk_1` FOREIGN KEY (`iCategoryId`) REFERENCES `product_categories` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_category_relationship_ibfk_2` FOREIGN KEY (`iProductId`) REFERENCES `products` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `product_descriptions`
--
ALTER TABLE `product_descriptions`
  ADD CONSTRAINT `product_descriptions_ibfk_1` FOREIGN KEY (`iProductId`) REFERENCES `products` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`iProductId`) REFERENCES `products` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`iCityId`) REFERENCES `cities` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `user_order_history`
--
ALTER TABLE `user_order_history`
  ADD CONSTRAINT `user_order_history_ibfk_1` FOREIGN KEY (`iUserId`) REFERENCES `users` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_order_history_ibfk_2` FOREIGN KEY (`iProductId`) REFERENCES `products` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `user_wishlist`
--
ALTER TABLE `user_wishlist`
  ADD CONSTRAINT `user_wishlist_ibfk_1` FOREIGN KEY (`iUserId`) REFERENCES `users` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_wishlist_ibfk_2` FOREIGN KEY (`iProductId`) REFERENCES `products` (`iId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
