-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2022 at 09:15 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peculyn`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `sn` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `prod_id` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'true',
  `order_id` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`sn`, `user_id`, `prod_id`, `quantity`, `status`, `order_id`) VALUES
(1, 'fb95c3c1d', 'L0920ROPs', '2', 'true', ''),
(2, 'fb95c3c1d', '0oDklA3', '2', 'true', ''),
(3, 'fb95c3c1d', '08iLK3bb', '2', 'true', ''),
(137, 'c4b6b25d8', '9OpKG72k', '1', 'true', ''),
(138, 'c4b6b25d8', 'G39jn1J', '1', 'true', ''),
(139, 'c4b6b25d8', 'O0hJ0P', '1', 'true', ''),
(156, '752c1cf8d', '0oDklA3', '3', 'true', ''),
(157, '752c1cf8d', '8Oih2O0L', '5', 'true', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `sn` int(25) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `order_id` varchar(400) NOT NULL,
  `item_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `qty` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`sn`, `user_id`, `order_id`, `item_id`, `status`, `qty`) VALUES
(3, 'c4b6b25d8', 'id16210179002758073550000008254', 'G39jn1J', 'pending', 3),
(4, 'c4b6b25d8', 'id16210179002758073550000008254', 'N89skO0As', 'pending', 1),
(5, 'c4b6b25d8', 'id162101876357315374599999995553', 'G39jn1J', 'pending', 3),
(6, 'c4b6b25d8', 'id162101876357315374599999995553', 'N89skO0As', 'pending', 1),
(7, 'c4b6b25d8', 'id16210215447518159599999999045', 'Y87bi2', 'pending', 1),
(8, 'c4b6b25d8', 'id16210215447518159599999999045', '9OpKG72k', 'pending', 1),
(9, 'c4b6b25d8', 'id16210215447518159599999999045', '8Oih2O0L', 'pending', 1),
(10, 'c4b6b25d8', 'id16210215447518159599999999045', 'L0920ROPs', 'pending', 2),
(11, 'c4b6b25d8', 'id16215299341768421549999984563', 'O0hJ0P', 'pending', 1),
(12, 'c4b6b25d8', 'id16215299341768421549999984563', '9OpKG72k', 'pending', 1),
(13, 'c4b6b25d8', 'id16215299341768421549999984563', 'G39jn1J', 'pending', 1),
(14, 'b76bc6782', 'id162163624732721820000000006985', '8Oih2O0L', 'pending', 3),
(15, 'b76bc6782', 'id162163624732721820000000006985', '9OpKG72k', 'pending', 1),
(16, 'b76bc6782', 'id162163624732721820000000006985', 'Y87bi2', 'pending', 1),
(17, 'b76bc6782', 'id162163624732721820000000006985', 'O0hJ0P', 'pending', 2),
(18, 'e9d2e51a1', 'id16227223254884992999999958556', 'L092nuOPs', 'pending', 2),
(19, 'e9d2e51a1', 'id16227223254884992999999958556', 'N89skO0As', 'pending', 1),
(20, 'e9d2e51a1', 'id16227223254884992999999958556', 'K0Ol21sW', 'pending', 6),
(21, 'e9d2e51a1', 'id16227223254884992999999958556', '9OpKG72k', 'pending', 1),
(22, 'e9d2e51a1', 'id16227223254884992999999958556', 'L0920ROPs', 'pending', 112),
(23, 'e9d2e51a1', 'id16227223254884992999999958556', 'O0hJ0P', 'pending', 1),
(24, 'e9d2e51a1', 'id16227223254884992999999958556', '8Oih2O0L', 'pending', 5),
(25, 'e9d2e51a1', 'id16227223254884992999999958556', 'Y87bi2', 'pending', 16);

-- --------------------------------------------------------

--
-- Table structure for table `products_all`
--

CREATE TABLE `products_all` (
  `sn` int(25) NOT NULL,
  `unique_key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL,
  `old_price` double(10,2) NOT NULL,
  `short_desc` varchar(300) NOT NULL,
  `category` varchar(255) NOT NULL,
  `in_stock` int(255) NOT NULL,
  `img_1` varchar(255) NOT NULL,
  `img_2` varchar(255) NOT NULL,
  `img_3` varchar(255) NOT NULL,
  `img_4` varchar(255) NOT NULL,
  `img_5` varchar(255) NOT NULL,
  `long_desc` text NOT NULL,
  `reviews` int(255) NOT NULL,
  `purchases` varchar(255) NOT NULL,
  `date_added` varchar(255) NOT NULL,
  `measurement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_all`
--

INSERT INTO `products_all` (`sn`, `unique_key`, `name`, `price`, `old_price`, `short_desc`, `category`, `in_stock`, `img_1`, `img_2`, `img_3`, `img_4`, `img_5`, `long_desc`, `reviews`, `purchases`, `date_added`, `measurement`) VALUES
(13, 'n922i22898989x128922d', 'Tomatoes', 300.00, 390.00, 'sd', 'vegetables', 100000, '../assets/images/vegetables/tomato.png', '../assets/images/vegetables/tomato.png', '../assets/images/vegetables/tomato.png', '../assets/images/vegetables/tomato.png', '../assets/images/vegetables/tomato.png', 'ld', 1, '0', '8/05/2021', 'Piece'),
(17, 'n365209574626cd317863a9379573174', 'Chicken Gizzard', 2000.00, 2150.00, 'sd', 'protein', 100000, '../assets/images/protein/gizzard.png', '../assets/images/protein/gizzard2.png', '../assets/images/protein/gizzard3.png', '../assets/images/protein/gizzard.png', '../assets/images/protein/gizzard2.png', 'ld', 1, '0', '8/05/2021', 'Kg'),
(18, 'n823923j238f8823k23kd23092', 'Broiler', 1700.00, 1950.00, 'sd', 'protein', 1000000, '../assets/images/protein/broiler.png', '../assets/images/protein/broiler.png', '../assets/images/protein/broiler.png', '../assets/images/protein/broiler.png', '../assets/images/protein/broiler.png', 'ld', 1, '0', '8/05/2021', 'Kg'),
(19, 'n09823iqwjsioei893398373c', 'Chicken Gizzard', 2000.00, 2150.00, 'sd', 'protein', 100000, '../assets/images/protein/turkey.png', '../assets/images/protein/gizzard2.png', '../assets/images/protein/gizzard3.png', '../assets/images/protein/gizzard.png', '../assets/images/protein/gizzard2.png', 'ld', 1, '0', '8/05/2021', 'Kg'),
(20, 'n093j32j2309u238u32010912', 'Broiler', 1700.00, 1950.00, 'sd', 'protein', 1000000, '../assets/images/protein/chicken-wing.png', '../assets/images/protein/broiler.png', '../assets/images/protein/broiler.png', '../assets/images/protein/broiler.png', '../assets/images/protein/broiler.png', 'ld', 1, '0', '8/05/2021', 'Kg'),
(21, 'n8383y389qg8x8989yw89x9x9w', 'Women clothes', 3000.00, 3700.00, 'sd', 'protein', 1000000, '../assets/images/protein/p5.jpeg', '../assets/images/protein/frozen-chicken.png', '../assets/images/protein/frozen-chicken.png', '../assets/images/protein/frozen-chicken.png', '../assets/images/protein/frozen-chicken.png', 'ld', 1, '0', '8/05/2021', 'Kg'),
(33, 'n365209574626cd317863a9379576174', 'Vintage Hermes', 10000.00, 2000.00, 'This is a classic Vintage Hermes shirt for the classic man', 'men', 1, '../assets/images/men/p10.jpeg', '../assets/images/men/p10.jpeg', '../assets/images/men/p10.jpeg', '../assets/images/men/p10.jpeg', '../assets/images/men/p10.jpeg', '', 1, '0', '30/04/2022', 'none'),
(34, 'n728242289626cd5d0243d8289032274', 'Vintage Polo', 11000.00, 2000.00, 'This is a classic Vintage Polo shirt for the classic man', 'men', 2, '../assets/images/men/p15.jpeg', '../assets/images/men/p15.jpeg', '../assets/images/men/p15.jpeg', '../assets/images/men/p15.jpeg', '../assets/images/men/p15.jpeg', '', 1, '0', '30/04/2022', 'none'),
(35, 'n2024958862626cd655a1b07715641736', 'Ralph Lauren', 4000.00, 2000.00, 'This is a classic Ralph Lauren shirt for the classic man', 'men', 3, '../assets/images/men/p13.jpeg', '../assets/images/men/p13.jpeg', '../assets/images/men/p13.jpeg', '../assets/images/men/p13.jpeg', '../assets/images/men/p13.jpeg', '', 1, '0', '30/04/2022', 'none'),
(36, 'n1833334592626cd6ba53f29663750095', 'Track Suit', 4500.00, 6000.00, 'Nice women track suit', 'women', 11, '../assets/images/women/p1.jpeg', '../assets/images/women/p1.jpeg', '../assets/images/women/p1.jpeg', '../assets/images/women/p1.jpeg', '../assets/images/women/p1.jpeg', '', 1, '0', '30/04/2022', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `site_name` varchar(25) NOT NULL,
  `sn` int(11) NOT NULL,
  `site_title` text NOT NULL,
  `paystack_s_key` varchar(400) NOT NULL,
  `site_logo` varchar(50) NOT NULL,
  `site_address` text NOT NULL,
  `site_number` varchar(25) NOT NULL,
  `site_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`site_name`, `sn`, `site_title`, `paystack_s_key`, `site_logo`, `site_address`, `site_number`, `site_email`) VALUES
('Peculyn', 1, 'Peculyn International Super Store', 'sk_test_a7ed4b38d1dba46790f08ee86c240e2b98fa725a', 'assets/images/logo.jpg', 'Shop 9, Along Eneka road by Igwuruta market after pipeline, Port-Harcourt, Nigeria.', '+234 813 338 1982', 'support@peeculyn.com');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `sn` int(25) NOT NULL,
  `tran_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `date_init` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `date_finished` varchar(255) NOT NULL DEFAULT '',
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `payment_date` varchar(25) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`sn`, `tran_id`, `email`, `amount`, `order_id`, `date_init`, `payment_status`, `date_finished`, `user_id`, `name`, `number`, `address1`, `address2`, `payment_date`) VALUES
(7, '09c9dc3fe84d928dc8f02c6dbdc25020', 'chucreates@gmail.com', 3151.98, 'id162163624732721820000000006985', '21/05/2021', 'paid', '', 'b76bc6782', 'Joseph Chu', '08166685033', 'East west road Alakahia', '', '21/05/2021 06:32:17pm'),
(8, 'e944fef10c848185f64194c22bdee73d', 'okealex22@gmail.com', 12850.99, 'id16227223254884992999999958556', '03/06/2021', 'paid', '', 'e9d2e51a1', 'Blessing Oke', '07034481413', '20 marcel Ananugu street along Amaechi road rumuosi', 'Flat 1', '03/06/2021 08:15:22am');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `sn` int(25) NOT NULL,
  `unique_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL DEFAULT '',
  `lastName` varchar(255) NOT NULL DEFAULT '',
  `number` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `address2` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  `terms` varchar(255) NOT NULL DEFAULT '',
  `is_admin` varchar(25) NOT NULL DEFAULT '',
  `joined` varchar(25) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`sn`, `unique_id`, `email`, `password`, `firstName`, `lastName`, `number`, `address`, `address2`, `country`, `state`, `terms`, `is_admin`, `joined`) VALUES
(5, '34a38508f', 'igwechujoseph@gmail.com', '4ce9792f2871988864761ef032ce09646333c81667d5d3360a82d7c47411c0b46846437ac5e304880fb5d7510d0af3d7af5a666a1f0459df1e04d1a8683bbe13', '', '', '', '', '', '', '', '', '', ''),
(6, 'c4b6b25d8', 'palmerbideconcepts@gmail.com', '4b0ab7b94e92a4f175774a4ad8a9a8c4d273671086ef091a689d63d3752a53ba043a1daf6204c9d4043b24bb42e18903029b43acd5efeabf7f368c26d532ab6e', 'palmer', 'bide', '08166685033', 'east-west road', 'Abuja', 'Nigeria', 'Rivers', 'checked', 'yes', ''),
(7, 'a1de9d57a', 'preshi5656@gmail.com', '6c6e66058bd18c21926ce35b02bfcc514f1e73e68da5292c3eb01114759afd2ebd7c210cd1f5fce07a7ebaa21dd002421c51658dc95091388472abf5bac4664b', '', '', '', '', '', '', '', '', '', ''),
(8, 'b76bc6782', 'chucreates@gmail.com', '4b0ab7b94e92a4f175774a4ad8a9a8c4d273671086ef091a689d63d3752a53ba043a1daf6204c9d4043b24bb42e18903029b43acd5efeabf7f368c26d532ab6e', 'Joseph', 'Chu', '08166685033', 'East west road Alakahia', '', 'Nigeria', 'Rivers', 'checked', '', ''),
(9, 'e9d2e51a1', 'okealex22@gmail.com', '61dd978915bb2369630f6ccf975eabd16170af10b2061ac4b14693187136ef8aa0ec128bdfe27f9ecfa14a4eb27cdcc49e693711de91cdf9303eb92960a93d12', '', '', '', '', '', '', '', '', '', ''),
(10, '752c1cf8d', 'nn@nn.co', 'a49a34734c9c3765253179a66bf7c8dcb5a6f19d4ca40a2cf9a4d12b0a8528c84552718aceee35b0f02be2db54118d094160e2c27be3c71673ce8a05560fe7dd', '', '', '', '', '', '', '', '', 'yes', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `products_all`
--
ALTER TABLE `products_all`
  ADD PRIMARY KEY (`sn`),
  ADD UNIQUE KEY `unique` (`unique_key`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`sn`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`sn`),
  ADD UNIQUE KEY `tran_id` (`tran_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`sn`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `sn` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products_all`
--
ALTER TABLE `products_all`
  MODIFY `sn` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `sn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `sn` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `sn` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
