-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2012 at 12:57 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `justfastfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user_email`, `user_password`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `category_detail` text NOT NULL,
  `category_status` varchar(25) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `type_id`, `category_name`, `category_detail`, `category_status`) VALUES
(7, 12, 'Chicken Burger', '', 'active'),
(8, 3, 'Burgers', '', 'active'),
(9, 3, 'Chicken', '', 'active'),
(10, 3, ' Salads', '', 'active'),
(11, 3, 'Kids Menu', '', 'active'),
(12, 3, ' Milkshakes', '', 'active'),
(13, 3, 'Side Orders', '', 'active'),
(14, 3, ' Desserts ', '', 'active'),
(15, 3, 'Ice Cream', '', 'active'),
(16, 3, 'Soft Drinks', '', 'active'),
(17, 2, ' Buckets', '', 'active'),
(18, 2, ' Deluxe Boneless Box ', '', 'active'),
(19, 2, ' Family Feast ', '', 'active'),
(20, 2, ' Mains - Burgers ', '', 'active'),
(21, 2, ' Meals ', '', 'active'),
(22, 2, ' Singles ', '', 'active'),
(23, 2, ' Salads ', '', 'active'),
(24, 2, ' Kids Menu ', '', 'active'),
(25, 2, ' Extra Portions', '', 'active'),
(26, 2, ' Sauces ', '', 'active'),
(27, 2, ' Side Orders', '', 'active'),
(28, 2, 'Soft Drinks ', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `chat_staff`
--

CREATE TABLE IF NOT EXISTS `chat_staff` (
  `cs_id` int(11) NOT NULL AUTO_INCREMENT,
  `cs_name` varchar(25) NOT NULL,
  `cs_status` varchar(25) NOT NULL,
  `cs_online_status` varchar(25) NOT NULL,
  PRIMARY KEY (`cs_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `chat_staff`
--

INSERT INTO `chat_staff` (`cs_id`, `cs_name`, `cs_status`, `cs_online_status`) VALUES
(1, 'Offline', 'active', 'offline'),
(2, 'Online', 'active', 'online'),
(3, 'Busy', 'active', 'busy');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(25) NOT NULL,
  `f_email` varchar(50) NOT NULL,
  `f_feed` text NOT NULL,
  `f_order` text NOT NULL,
  `f_status` varchar(25) NOT NULL,
  `f_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`f_id`, `f_name`, `f_email`, `f_feed`, `f_order`, `f_status`, `f_date_added`) VALUES
(2, 'bhbb', 'gfg@cd.cc', '', 'bbn', '', '2012-09-24 05:35:53'),
(4, 'sdasd', 'asargodha@gmail.com', 'ddd s &nbsp;fd f d &nbsp; &nbsp;sf dfdf dsf sd f sf sf s f sdf s f sddf sf s f sdf sd fsd fsddfsd f sdf sfs f sdfs fs f s fs f sfs f s f sfs &nbsp;f sf sf sf sf sdfs f s ffsd f sd', 'dssd', 'post', '2012-09-19 07:27:13'),
(5, 'sdsd', 'da@sd.dsd', 'dhasgdhasd asdasd andbad ansdbas dnasbdas dnabs d ad asvdasdabda sdzdvasdassd as dasdbas das davsd asd assdbas da sd', 'd asdbasd as dass da sd adas das d', 'post', '2012-09-19 03:45:03'),
(6, 'Awais', 'asa@s.ss', 'This is test', 'sd', 'post', '2012-09-19 14:55:46'),
(7, 'M Awais', 'gfg@cd.cc', 'Also a test feedback..Website is so good .', 'sd', 'post', '2012-09-19 15:02:32'),
(8, 'Awais', 'asa@s.ss', 'gs s fs fs fs f s fs faf sf s  f sfsbjfsfbsdf sdf  sf s dfsbfs df s fsd fdsfsdf sdf dsf sdfhsfh sdfsfkhsdfhdsfhsd fsdhfsdf sdf sd fds fds fsdf sd fsd f s fsd fsdf sd fsdf gs s fs fs fs f s fs faf sf s  f sfsbjfsfbsdf sdf  sf s dfsbfs df s fsd fdsfsdf sdf dsf sdfhsfh sdfsfkhsdfhdsfhsd fsdhfsdf sdf sd fds fds fsdf sd fsd f s fsd fsdf sd fsdf gs s fs fs fs f s fs faf sf s  f sfsbjfsfbsdf sdf  sf s dfsbfs df s fsd fdsfsdf sdf dsf sdfhsfh sdfsfkhsdfhdsfhsd fsdhfsdf sdf sd fds fds fsdf sd fsd f s fsd ', '', 'post', '2012-09-19 15:07:22'),
(9, 'ddd', 'GHh@ddd.dd', 'sdsd', '', 'pending', '2012-09-22 03:29:31'),
(10, 'Awais', 'awais@awais.awais', 'hahhahaha\r\nhahhahaha', '', 'post', '2012-09-22 06:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_pass`
--

CREATE TABLE IF NOT EXISTS `forgot_pass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vcode` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `type` varchar(25) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `forgot_pass`
--

INSERT INTO `forgot_pass` (`id`, `vcode`, `email`, `type`, `date_added`) VALUES
(6, '285796d08aa4a2a63542b4c4aefe422ca71a225248', 'awais@test.com', 'user', '2012-10-02 03:37:36'),
(7, '1130468152a0d96b0284dedc54563cc9c024e05e24983377676', 'awaiskhan88172@yahoo.com', 'user', '2012-10-05 10:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_name` varchar(250) NOT NULL,
  `item_price` varchar(25) NOT NULL,
  `item_in_stock` varchar(25) NOT NULL,
  `item_details` text NOT NULL,
  `item_subitem_price` varchar(25) NOT NULL,
  `item_status` varchar(25) NOT NULL,
  `item_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `type_id`, `category_id`, `item_name`, `item_price`, `item_in_stock`, `item_details`, `item_subitem_price`, `item_status`, `item_date_added`) VALUES
(3, 3, 2, 'Name', '3.07', '14', 'Details', '', 'active', '2012-09-11 01:26:21'),
(4, 3, 3, 'New Item1', '10', '10', 'Details', '', 'active', '2012-09-08 17:43:55'),
(5, 2, 2, 'New4', '7.06', '71', '', '', 'active', '2012-09-11 01:28:18'),
(7, 3, 8, 'McChickenâ„¢ Sandwich', '3.09', '20', 'Contains carefully boned chicken breast meat in a light batter coating\r\n             ', '0.00', 'active', '2012-10-10 01:23:27'),
(8, 3, 8, 'Big Mac â„¢ ', '3.09', '20', 'Two pure beef patties with an unbeatable sauce, lettuce, onions, pickle, cheese and seasame seed bun\r\n             ', '', 'active', '2012-10-06 11:15:45'),
(10, 3, 8, 'Quarter Pounder with Cheese', '3.09', '20', 'Our burgers are made from 100% pure beef with a pinch of salt; tasty enough not to need additives or flavourings\r\n             ', '', 'active', '2012-10-06 11:18:48'),
(11, 3, 8, 'Filet-O-Fish â„¢', '3.09', '20', '100% Icelandic and Norwegian Cod or New Zealand Hoki fillet in a crisp breadcrumb coating\r\n             ', '', 'active', '2012-10-06 11:19:46'),
(12, 3, 8, 'Cheeseburger', '1.25', '20', 'Made from 100% pure beef with a pinch of salt; tasty enough not to need additives or flavourings\r\n             ', '', 'active', '2012-10-06 11:20:40'),
(13, 3, 8, 'DOUBLE Cheeseburger', '1.89', '20', '', '', 'active', '2012-10-06 11:21:18'),
(14, 3, 8, 'Hamburger', '1.17', '20', 'Made from 100% pure beef with a pinch of salt; tasty enough not to need additives or flavourings\r\n             ', '', 'active', '2012-10-06 11:21:55'),
(15, 3, 8, 'Chicken Legend - with Spicy Tomato Salsa', '3.75', '20', 'The Chicken Legend features our new crispy, tasty chicken breast fillet \r\nin a rustic roll with Batavia lettuce and choice of spicy Tomato Salsa \r\nor delicious Cool Mayo. Chicken Legend permanently replaces the Chicken \r\nPremiere.\r\n             ', '', 'active', '2012-10-06 11:22:30'),
(16, 3, 9, 'Chicken McNuggets â„¢ 6 pieces', '3.09', '20', 'The only meat used in our new Chicken McNuggets is tasty chicken breast. This new recipe is also 30% lower in salt\r\n             ', '', 'active', '2012-10-06 11:24:04'),
(17, 3, 9, 'Chicken McNuggets â„¢ 9 pieces', '3.50', '20', 'The only meat used in our new Chicken McNuggets is tasty chicken breast. This new recipe is also 30% lower in salt\r\n             ', '', 'active', '2012-10-06 11:24:49'),
(18, 3, 9, 'Chicken McNuggetsâ„¢ 20 pieces', '5.25', '20', 'The only meat used in our new Chicken McNuggets is tasty chicken breast. This new recipe is also 30% lower in salt\r\n             ', '', 'active', '2012-10-06 11:25:21'),
(19, 3, 9, 'Chicken Selects 3 Pieces', '3.65', '20', 'And one of Sour Cream and Chive Sauce, Smoked BBQ Sauce or Sweet Chilli Sauce)\r\n             ', '', 'active', '2012-10-06 11:25:58'),
(20, 3, 9, 'Chicken Selects 5 Pieces', '4.95', '20', 'And any two pots of Sour Cream and Chive Sauce, Smoked BBQ Sauce or Sweet Chilli Sauce)\r\n             ', '', 'active', '2012-10-06 11:27:00'),
(21, 3, 10, 'Chicken & Bacon Salad', '4.49', '20', 'Tasty warm Grilled Chicken or Crispy Chicken with four pieces of bacon, with Balsamic or Ceasar Dressing.\r\n             ', '', 'active', '2012-10-06 11:28:35'),
(22, 3, 10, 'Garden Side Salad', '1.50', '20', 'Mixed salad* with carrot and cherry tomatoes served with balsamic dressing. *salad leaves may vary\r\n             ', '', 'active', '2012-10-06 11:29:12'),
(23, 3, 11, 'Cheeseburger Happy meal', '3.00', '20', 'served with either small fries, carrot sticks or a Fruit Bag, and a \r\nchoice of small drink ( Fruitshoot, Juice, Water or Milk) and a toy.\r\n             ', '', 'active', '2012-10-06 11:30:10'),
(24, 3, 11, 'Hamburger Happy meal', '3.00', '20', 'served with either small fries, carrot sticks or a Fruit Bag, and a \r\nchoice of small drink ( Fruitshoot, Juice, Water or Milk) and a toy.\r\n             ', '', 'active', '2012-10-06 11:30:39'),
(25, 3, 11, 'Chicken McNuggets â„¢ Happy meal (4 pieces)', '3.00', '20', 'served with either small fries, carrot sticks or a Fruit Bag, and a \r\nchoice of small drink ( Fruitshoot, Juice, Water or Milk) and a toy.\r\n             ', '', 'active', '2012-10-06 11:31:14'),
(26, 3, 11, 'Fish Finger Happy meal (3 pieces)', '3.00', '20', 'served with either small fries, carrot sticks or a Fruit Bag, and a \r\nchoice of small drink ( Fruitshoot, Juice, Water or Milk) and a toy.\r\n             ', '', 'active', '2012-10-06 11:31:49'),
(27, 3, 12, 'Strawberry Milkshake - Medium', '1.89', '20', '', '', 'active', '2012-10-06 11:32:24'),
(28, 3, 12, 'Strawberry Milkshake - Large', '2.45', '20', '', '', 'active', '2012-10-06 11:32:55'),
(29, 3, 12, 'Chocolate Milkshake - Medium', '1.89', '20', '', '', 'active', '2012-10-06 11:33:15'),
(30, 3, 12, 'Chocolate Milkshake - Large', '2.45', '20', '', '', 'active', '2012-10-06 11:33:38'),
(31, 3, 12, 'Banana Milkshake - Medium', '1.89', '20', '', '', 'active', '2012-10-06 11:34:12'),
(32, 3, 9, 'Banana Milkshake - Large', '2.45', '20', '', '', 'active', '2012-10-06 11:34:40'),
(33, 3, 12, 'Starburst Milkshake - Medium', '1.99', '20', '<br>', '', 'active', '2012-10-06 11:35:09'),
(34, 3, 12, 'Starburst Milkshake - Large', '2.45', '20', '', '', 'active', '2012-10-06 11:35:38'),
(35, 3, 13, 'Small Fries', '1.25', '20', '', '', 'active', '2012-10-06 11:36:46'),
(36, 3, 13, 'Medium Fries', '1.55', '20', '<br>', '', 'active', '2012-10-06 11:37:17'),
(37, 3, 12, 'Large Fries', '1.85', '20', '', '', 'active', '2012-10-06 11:37:39'),
(38, 3, 14, 'Blueberry Muffin', '1.65', '20', 'Made from free-range eggs and contain no artificial colours or preservatives and no hydrogenated fats.\r\n             ', '', 'active', '2012-10-06 11:38:28'),
(39, 3, 14, 'Double Chocolate muffin', '1.65', '20', 'Made from free-range eggs and contain no artificial colours or preservatives and no hydrogenated fats.\r\n             ', '', 'active', '2012-10-06 11:39:18'),
(40, 3, 14, 'Hot Apple Pie', '1.35', '20', '', '', 'active', '2012-10-06 11:39:59'),
(41, 3, 14, 'Sugar Donut', '1.35', '20', 'Light and sweet sugar - coated donut. Made from free-range eggs and \r\ncontain no artificial colours or preservatives and no hydrogenated fats.\r\n             ', '', 'active', '2012-10-06 11:41:49'),
(42, 3, 14, 'Belgian Bliss Brownie', '1.89', '20', 'Indulgent Belgian Bliss Brownie made with rich Belgian chocolate. Made \r\nfrom free-range eggs and contain no artificial colours or preservatives \r\nand no hydrogenated fats.\r\n             ', '', 'active', '2012-10-06 11:42:21'),
(43, 3, 14, 'Sundae', '1.89', '20', 'Choose from plain, Strawberry or Toffee.<br>\r\nIf no choice is made with the order, the restaurant will pick a flavour at random\r\n             ', '', 'active', '2012-10-06 11:43:09'),
(44, 3, 15, 'McFlurry', '1.69', '20', 'Plain, Smarties, Dairy Milk, Crunchie or kitkat.<br>\r\nIf no choice is made with the order, the restaurant will pick a flavour at random', '', 'active', '2012-10-06 11:44:16'),
(45, 3, 16, 'Coke (1.5 Ltr)', '2.40', '20', '', '', 'active', '2012-10-06 11:46:20'),
(46, 3, 16, 'Diet Coke (1.5 Ltr) ', '2.40', '20', '', '', 'active', '2012-10-06 11:47:43'),
(47, 3, 16, 'Tango Orange (1.5 Ltr)', '2.40', '20', '', '', 'active', '2012-10-06 11:48:33'),
(48, 3, 16, '7up (1.5 Ltr)', '2.30', '20', '', '', 'active', '2012-10-06 11:48:58'),
(49, 3, 4, 'PURE APPLE JUICE (DIMES)', '1.70', '20', 'Dimes Premium 100% FRUIT JUICE, produced WITHOUT using any ADDITIVES \r\nwith a fruit ratio of 100% brings you together with the indispensable \r\nflavors for a healthy life!\r\n             ', '', 'active', '2012-10-06 11:51:15'),
(50, 3, 4, 'PURE ORANGE JUICE (DIMES)', '1.70', '20', 'Dimes Premium 100% FRUIT JUICE, produced WITHOUT using any ADDITIVES \r\nwith a fruit ratio of 100% brings you together with the indispensable \r\nflavors for a healthy life!\r\n             ', '', 'active', '2012-10-06 14:55:22'),
(51, 3, 4, 'PURE PINEAPPLE JUICE (DIMES)', '1.70', '20', 'Dimes Premium 100% FRUIT JUICE, produced WITHOUT using any ADDITIVES \r\nwith a fruit ratio of 100% brings you together with the indispensable \r\nflavors for a healthy life!\r\n             ', '', 'active', '2012-10-06 14:55:56'),
(52, 3, 4, 'PURE GRAPE JUICE (DIMES)', '1.70', '20', '100% Pure Fruit Juice<br>\r\nDimes Premium 100% FRUIT JUICE, produced WITHOUT using any ADDITIVES \r\nwith a fruit ratio of 100% brings you together with the indispensable \r\nflavors for a healthy life!\r\n             ', '', 'active', '2012-10-06 14:56:38'),
(53, 3, 4, 'MANGO JUCE (DIMES) ', '1.70', '20', 'Dimes Premium FRUIT JUICE\r\n             ', '', 'active', '2012-10-06 14:57:15'),
(54, 3, 13, 'Large Fries', '1.89', '20', '', '', 'active', '2012-10-07 08:28:55'),
(55, 2, 17, '6 Piece Variety Bucket', '17.50', '20', '6 Pieces chicken, 4 mini breast fillets, 4 fries, regular popcorn chicken and 2 dips\r\n             ', '0.00', 'active', '2012-10-10 12:35:31'),
(56, 2, 17, '10 Piece Variety Bucket', '20.65', '20', '10 Pieces chicken, 4 mini breast fillets, 4 fries, regular popcorn chicken and dips\r\n             ', '', 'active', '2012-10-07 08:39:44'),
(57, 2, 17, '8 pc. Bargain Bucket', '13.95', '20', '8pcs and 4 fries\r\n             ', '', 'active', '2012-10-07 08:40:15'),
(58, 2, 17, '10 Piece Bargain Bucket', '15.95', '20', '10pcs and 4 fries\r\n             ', '', 'active', '2012-10-07 08:40:52'),
(59, 2, 17, '12 Piece Bargain Bucket', '17.95', '20', '12pcs and 4 fries\r\n             ', '', 'active', '2012-10-07 08:41:35'),
(60, 2, 17, '16 Piece Bargain Bucket', '22.00', '20', '16pcs and 6 fries\r\n             ', '', 'active', '2012-10-07 08:42:08'),
(61, 2, 17, '8pc Deluxe Boneless Box', '16.95', '20', '8pc Mini breast fillets, 2 reg. popcorn chicken, 4 chips, 2 large sides, 1.5 ltr bottle\r\n             ', '', 'active', '2012-10-07 08:43:09'),
(62, 2, 17, '12pc. Deluxe Boneless Box', '20.65', '20', '12 Mini breast fillets, 2 reg. popcorn chicken, 4 chips, 2 large sides, 1.5 ltr bottle\r\n             ', '', 'active', '2012-10-07 08:43:42'),
(63, 2, 17, '8 Piece Family Feast', '17.95', '20', '8pc. Chicken, 4 fries, 2 large sides, 1.5ltr bottle drink\r\n             ', '', 'active', '2012-10-07 08:44:31'),
(64, 2, 17, '12 Piece Family Feast', '22.50', '20', '12pc. Chicken, 4 fries, 2 large sides, 1.5ltr bottle drink\r\n             ', '', 'active', '2012-10-07 08:45:27'),
(65, 2, 17, 'Fillet Burger', '4.25', '20', 'Add 25p if with cheese\r\n             ', '', 'active', '2012-10-07 08:46:09'),
(66, 2, 8, 'Zinger Burger', '4.25', '20', 'Add 25p if with cheese\r\n             ', '', 'active', '2012-10-07 08:46:45'),
(67, 2, 8, 'Fillet Tower Burger', '4.95', '20', '', '', 'active', '2012-10-07 08:47:15'),
(68, 2, 8, 'Zinger Tower Burger', '4.95', '20', '', '', 'active', '2012-10-07 08:47:40'),
(69, 2, 8, 'Mini Fillet with Cheese', '2.25', '20', '', '', 'active', '2012-10-07 08:48:18'),
(70, 2, 21, '2 Piece Colonel''s Meal', '4.95', '20', 'with drink &amp; fries - go large add 65p\r\n             ', '', 'active', '2012-10-07 08:49:21'),
(71, 2, 21, '3 Piece Colonel''s Meal', '6.55', '20', 'with drink &amp; fries - go large add 65p\r\n             ', '', 'active', '2012-10-07 08:50:16'),
(72, 2, 21, '2 Piece Variety Meal', '6.55', '20', '2 pcs chicken, 2 hot wings, 1 crispy strip, fries - go large add 65p\r\n             ', '', 'active', '2012-10-07 08:51:11'),
(73, 2, 21, 'Mini Variety Meal', '3.00', '20', '', '', 'active', '2012-10-07 08:51:52'),
(74, 2, 21, '6 Hotwings Meal', '5.75', '20', '', '', 'active', '2012-10-07 08:52:21'),
(75, 2, 21, 'Fillet Meal', '5.65', '20', 'With fries &amp; drink - GO LARGE ADD 65P, WITH CHEESE ADD 20P\r\n             ', '', 'active', '2012-10-07 08:53:02'),
(76, 2, 21, 'Zinger Meal', '4.95', '20', 'With fries &amp; drink - GO LARGE ADD 65P, WITH CHEESE ADD 20P\r\n             ', '', 'active', '2012-10-07 08:53:38'),
(77, 2, 21, 'Fillet Tower Meal', '6.00', '20', 'With fries &amp; drink - GO LARGE ADD 65P\r\n             ', '', 'active', '2012-10-07 08:54:59'),
(78, 2, 21, 'Zinger Tower Meal', '6.00', '20', 'With fries &amp; drink - GO LARGE ADD 65P\r\n             ', '', 'active', '2012-10-07 08:55:53'),
(79, 2, 21, 'Wicked Zinger Meal', '6.75', '20', 'Add 40p if tower up and 40p if go large\r\n             ', '', 'active', '2012-10-07 08:56:41'),
(80, 2, 21, 'Fully Loaded Fillet Meal', '6.75', '20', 'With fries, 1 pc chicken, side &amp; drink - GO LARGE ADD 65p, TOWER UP ADD 75p\r\n             ', '', 'active', '2012-10-07 08:57:18'),
(81, 2, 21, 'Wicked Zinger Meal - with 2 hot wings', '7.25', '20', 'With fries, 2 hot wings, side &amp; drink - GO LARGE ADD 65P, TOWER UP ADD 75P\r\n             ', '', 'active', '2012-10-07 08:57:54'),
(82, 2, 21, 'Regular Popcorn Meal', '4.65', '20', 'With fries &amp; drink - GO LARGE 65P\r\n             ', '', 'active', '2012-10-07 08:58:23'),
(83, 2, 21, 'Large Popcorn Meal', '5.65', '20', 'With fries &amp; drink - GO LARGE 65P\r\n             ', '', 'active', '2012-10-07 08:58:53'),
(84, 2, 21, 'Toasted Twister Meal', '6.25', '20', '', '', 'active', '2012-10-07 08:59:16'),
(85, 2, 21, 'Salsa Toasted Twister Meal', '6.25', '20', '<br>', '', 'active', '2012-10-07 09:00:03'),
(86, 2, 21, 'Boneless Banquet', '7.50', '20', '3 mini breast fillets, small popcorn chicken, dip, side, fries &amp; drink - GO LARGE ADD 65P\r\n             ', '', 'active', '2012-10-07 09:01:28'),
(87, 2, 21, 'Big Daddy Meal', '7.65', '20', 'With large fries, 1 pc chicken, large side &amp; large drink\r\n             ', '', 'active', '2012-10-07 09:02:08'),
(88, 2, 21, 'Snack Box - 1 Piece Chicken', '2.55', '20', 'extra large fries with 1 piece of chicken\r\n             ', '', 'active', '2012-10-07 09:02:40'),
(89, 2, 21, 'Snack Box - Mini Fillet', '2.65', '20', 'extra large fries with 1 mini fillet\r\n             ', '', 'active', '2012-10-07 09:03:09'),
(90, 2, 21, 'Snack Box - Popcorn Chicken', '3.50', '20', 'extra large fries with popcorn chicken\r\n             ', '', 'active', '2012-10-07 09:03:41'),
(91, 2, 21, 'Snack Box - Hot Wings', '2.95', '20', 'extra large fries with 2 hot wings\r\n             ', '', 'active', '2012-10-07 09:04:13'),
(92, 2, 21, 'Snack Box - Hot Wings', '2.95', '20', 'extra large fries with 2 hot wings\r\n             ', '', 'active', '2012-10-07 19:26:02'),
(93, 2, 22, 'Toasted Twister', '4.65', '20', '', '', 'active', '2012-10-07 19:35:34'),
(94, 2, 22, 'Salsa Twister', '4.65', '20', '', '', 'active', '2012-10-07 19:36:58'),
(95, 2, 22, 'Mini Fillet', '2.00', '20', '', '', 'active', '2012-10-07 19:38:52'),
(96, 2, 22, 'Small Popcorn ', '2.25', '20', '', '', 'active', '2012-10-07 19:40:37'),
(97, 2, 22, 'Regular Popcorn', '2.95', '20', '', '', 'active', '2012-10-07 19:41:05'),
(98, 2, 22, 'Large Popcorn', '4.65', '20', '', '', 'active', '2012-10-07 19:41:50'),
(99, 2, 22, '	Hotwings (3)', '2.25', '20', '', '', 'active', '2012-10-07 19:42:46'),
(100, 2, 10, 'Side Salad', '1.65', '20', '', '', 'active', '2012-10-07 19:43:26'),
(101, 2, 10, 'Zinger Salad', '4.75', '20', '', '', 'active', '2012-10-07 19:44:02'),
(102, 2, 10, 'Original Salad', '4.65', '20', '', '', 'active', '2012-10-07 19:44:43'),
(103, 2, 11, 'Kids Meal', '4.50', '20', '', '', 'active', '2012-10-07 19:45:15'),
(104, 2, 25, 'Go large option (add with meals to go large)', '0.65', '20', 'Please tell us which meal to go large\r\n             ', '', 'active', '2012-10-07 19:51:54'),
(105, 2, 25, 'Tower up option (add with meals to tower up)', '0.65', '20', 'Please tell us which meal to tower up\r\n             ', '', 'active', '2012-10-07 19:52:35'),
(106, 2, 26, 'sauce / dips', '0.50', '20', 'choose from mayo, ketchup, bbq sauce\r\n             ', '', 'active', '2012-10-07 19:54:11'),
(107, 2, 13, 'Corn (1)', '1.85', '20', '', '', 'active', '2012-10-07 19:55:38'),
(108, 2, 13, 'Regular Fries', '1.85', '20', '', '', 'active', '2012-10-07 19:56:07'),
(109, 2, 27, 'Large Fries', '2.10', '20', '', '', 'active', '2012-10-07 19:56:35'),
(110, 2, 27, '1 piece chicken only', '2.50', '20', '', '', 'active', '2012-10-07 19:57:12'),
(111, 2, 27, '2pc. Chicken only', '3.50', '20', '', '', 'active', '2012-10-07 19:58:02'),
(112, 2, 27, '3pc. Chicken only', '4.65', '20', '', '', 'active', '2012-10-07 19:59:07'),
(113, 2, 27, 'Regular side', '1.50', '20', 'Coleslaw, Beans or Gravy\r\n             ', '', 'active', '2012-10-07 19:59:55'),
(114, 2, 24, 'Kids Meal', '4.50', '20', '', '', 'active', '2012-10-07 20:02:30'),
(115, 2, 28, 'Coke (1.5 Ltr)', '2.40', '20', '', '', 'active', '2012-10-07 20:04:02'),
(116, 2, 28, 'Diet Coke (1.5 Ltr)', '2.40', '20', '', '', 'active', '2012-10-07 20:04:41'),
(117, 2, 20, 'Fillet Burger', '4.25', '20', 'Add 25p if with cheese\r\n             ', '', 'active', '2012-10-07 20:06:09'),
(118, 2, 20, 'Zinger Burger', '4.25', '20', 'Add 25p if with cheese\r\n             ', '', 'active', '2012-10-07 20:07:30'),
(119, 2, 20, 'Fillet Tower Burger', '4.95', '20', '', '', 'active', '2012-10-07 20:08:15'),
(120, 2, 20, 'Zinger Tower Burger', '4.95', '20', '', '', 'active', '2012-10-07 20:09:12'),
(121, 2, 20, 'Mini Fillet with Cheese', '2.25', '20', '', '', 'active', '2012-10-07 20:09:51'),
(122, 2, 23, 'Side Salad', '1.65', '20', '', '', 'active', '2012-10-07 20:11:27'),
(123, 2, 23, 'Zinger Salad', '4.65', '20', '', '', 'active', '2012-10-07 20:12:50'),
(124, 2, 23, 'Original Salad', '4.75', '20', '', '', 'active', '2012-10-07 20:13:44'),
(125, 2, 19, '8 Piece Family Feast', '17.95', '20', '8pc. Chicken, 4 fries, 2 large sides, 1.5ltr bottle drink\r\n             ', '', 'active', '2012-10-07 20:14:58'),
(127, 2, 19, '12 Piece Family Feast', '22.50', '20', '12pc. Chicken, 4 fries, 2 large sides, 1.5ltr bottle drink\r\n             ', '', 'active', '2012-10-07 20:17:21'),
(128, 2, 18, '8pc Deluxe Boneless Box', '16.95', '20', '8pc Mini breast fillets, 2 reg. popcorn chicken, 4 chips, 2 large sides, 1.5 ltr bottle\r\n             ', '', 'active', '2012-10-07 20:19:26'),
(129, 2, 18, '12pc. Deluxe Boneless Box', '20.65', '20', '12 Mini breast fillets, 2 reg. popcorn chicken, 4 chips, 2 large sides, 1.5 ltr bottle\r\n             ', '', 'active', '2012-10-07 20:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `join_restaurant`
--

CREATE TABLE IF NOT EXISTS `join_restaurant` (
  `j_id` int(11) NOT NULL AUTO_INCREMENT,
  `j_type_id` int(25) NOT NULL,
  `j_name` varchar(25) NOT NULL,
  `j_email` varchar(100) NOT NULL,
  `j_phoneno` varchar(25) NOT NULL,
  `j_address` text NOT NULL,
  `j_city` varchar(100) NOT NULL,
  `j_postcode` varchar(25) NOT NULL,
  `j_rest_name` varchar(100) NOT NULL,
  `j_status` varchar(10) NOT NULL,
  `j_password` varchar(250) NOT NULL,
  `j_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`j_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `join_restaurant`
--

INSERT INTO `join_restaurant` (`j_id`, `j_type_id`, `j_name`, `j_email`, `j_phoneno`, `j_address`, `j_city`, `j_postcode`, `j_rest_name`, `j_status`, `j_password`, `j_date_added`) VALUES
(2, 11, 'Muhammad khan', 'awaiskhan88172@yahoo.com', '923347534039', 'Street No 1 House No 19 49 Tail', 'Sargodha', 'PO1 1HH', 'KFC', 'active', '226a1e228232035e83ca68ac5b71f533', '2012-09-29 11:21:44'),
(3, 12, 'Muhammad Awais', 'partner@domain.com', '923347534039', 'UK Str No 12', 'UK', 'PO1 1HH', 'Apna Dara', 'active', '95c2c15ebb3bb3e3f4a94d6cfca71899', '2012-09-29 11:44:42');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_city` text NOT NULL,
  `location_postcode` text NOT NULL,
  `location_menu_id` varchar(100) NOT NULL,
  `location_status` varchar(25) NOT NULL,
  `location_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_city`, `location_postcode`, `location_menu_id`, `location_status`, `location_date_added`) VALUES
(5, 'North End, Portsmouth', '{"PO2 0BH":{"E":"464895","N":"102097"}}', '2', 'active', '2012-10-06 09:33:44'),
(6, 'Commercial Road', '{"PO1 1HH":{"E":"464387","N":"100689"}}', '2', 'active', '2012-10-06 09:34:19'),
(7, 'London Road, Portsmouth', '{"PO2 0LN":{"E":"464947","N":"102081"}}', '3', 'active', '2012-10-06 09:33:12'),
(8, 'portsmouth', '{"PO1 1HH":{"E":"464387","N":"100689"}}', '6', 'active', '2012-09-26 02:55:30'),
(9, 'San Antonio', '{"PO4 8SL":{"E":"465825","N":"99959"}}', '6', 'active', '2012-09-26 03:39:09'),
(10, 'San Antonio', '{"PO5 4PY":{"E":"464677","N":"99809"}}', '6', 'active', '2012-09-26 03:58:57'),
(11, 'North Harbour', '{"PO6 4SR":{"E":"463648","N":"105532"}}', '2', 'active', '2012-10-06 09:49:18'),
(12, 'Gosport', '{"PO12 1RR":{"E":"461694","N":"99815"}}', '2', 'active', '2012-10-06 09:49:40'),
(13, 'Drayton', '{"PO6 2EH":{"E":"466958","N":"105628"}}', '2', 'active', '2012-10-06 09:50:05'),
(14, 'Havant', '{"PO9 1HH":{"E":"471380","N":"106438"}}', '2', 'active', '2012-10-06 09:50:26'),
(15, 'Waterloovilll', '{"PO8 8ER":{"E":"469330","N":"111570"}}', '2', 'active', '2012-10-06 09:50:44'),
(16, 'Isle of Wight', '{"PO33 2LN":{"E":"459242","N":"92847"}}', '2', 'active', '2012-10-06 09:51:26'),
(17, 'Commercial Road, Portsmouth', '{"PO1 4BJ":{"E":"464349","N":"100749"}}', '3', 'active', '2012-10-06 09:52:06'),
(18, 'Portsmouth Ocean Retail Park', '{"PO3 5NP":{"E":"466669","N":"102495"}}', '3', 'active', '2012-10-06 09:52:37'),
(19, 'Cosham', '{"PO6 2SW":{"E":"465558","N":"104740"}}', '3', 'active', '2012-10-06 09:52:59'),
(20, 'Fratton Way, Southsea', '{"PO4 8SL":{"E":"465825","N":"99959"}}', '3', 'active', '2012-10-06 09:53:28'),
(21, 'Gosport', '{"PO12 1DR":{"E":"462183","N":"99883"}}', '3', 'active', '2012-10-06 09:53:52'),
(22, 'New Gate Lane, Fareham', '{"PO14 1TZ":{"E":"457353","N":"104216"}}', '3', 'active', '2012-10-06 09:54:27'),
(23, 'Fareham', '{"PO16 0AB":{"E":"457798","N":"106243"}}', '3', 'active', '2012-10-06 09:54:49'),
(24, 'Havant', '{"PO9 1ER":{"E":"471606","N":"106269"}}', '3', 'active', '2012-10-06 09:55:08'),
(25, 'Waterloovilll', '{"PO7 7DU":{"E":"468332","N":"109468"}}', '3', 'active', '2012-10-06 09:55:25'),
(26, 'Commercial Road', '{"PO1 1HH":{"E":"464387","N":"100689"}}', '14', 'active', '2012-10-08 06:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `menu_type`
--

CREATE TABLE IF NOT EXISTS `menu_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(250) NOT NULL,
  `type_picture` varchar(250) NOT NULL,
  `type_phoneno` varchar(100) NOT NULL,
  `type_time` varchar(25) NOT NULL,
  `type_notes` text NOT NULL,
  `type_charges` varchar(25) NOT NULL,
  `type_steps` varchar(25) NOT NULL,
  `type_opening_hours` text NOT NULL,
  `type_category` varchar(25) NOT NULL,
  `type_is_delivery` varchar(25) NOT NULL,
  `type_special_offer` text NOT NULL,
  `type_status` varchar(25) NOT NULL,
  `type_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `menu_type`
--

INSERT INTO `menu_type` (`type_id`, `type_name`, `type_picture`, `type_phoneno`, `type_time`, `type_notes`, `type_charges`, `type_steps`, `type_opening_hours`, `type_category`, `type_is_delivery`, `type_special_offer`, `type_status`, `type_date_added`) VALUES
(2, 'KFC', 'item_1349428287.jpg', '', '45', 'New menu added', '1.45', '4', '{"Sunday":{"From":"11:00 ","To":"22:00 "},"Monday":{"From":"00:00 ","To":"00:00 "},"Tuesday":{"From":"00:00 ","To":"00:00 "},"Wednesday":{"From":"00:00 ","To":"00:00 "},"Thursday":{"From":"11:00 ","To":"22:00 "},"Friday":{"From":"00:00 ","To":"00:00 "},"Saturday":{"From":"00:00 ","To":"00:00 "}}', 'takeaway', 'yes', '{"pound":"12.00","off":"15.00"}', 'active', '2012-10-11 10:45:08'),
(3, 'McDonalds', 'item_1349517508.png', '', '45', '', '1.27', '3', '{"Sunday":{"From":"11:00 ","To":"22:00 "},"Monday":{"From":"","To":""},"Tuesday":{"From":"","To":""},"Wednesday":{"From":"","To":""},"Thursday":{"From":"","To":""},"Friday":{"From":"","To":""},"Saturday":{"From":"","To":""}}', 'fastfood', 'yes', '', 'active', '2012-10-11 10:01:17'),
(6, 'Apna Dara', 'item_1349949811.png', '', '45', '', '2.80', '4', '{"Sunday":{"From":"11:00 ","To":"22:00 "},"Monday":{"From":"11:00 ","To":"22:00 "},"Tuesday":{"From":"","To":""},"Wednesday":{"From":"","To":""},"Thursday":{"From":"","To":""},"Friday":{"From":"","To":""},"Saturday":{"From":"","To":""}}', 'takeaway', 'yes', '', 'active', '2012-10-11 10:03:31'),
(7, 'Chinese Tea', 'item_1348882035.jpg', '', '45 ', 'Fully Licensed Cafe and Delicious Chinese Cuisine Takeaway!', '2.80', '4', '{"Sunday":{"From":"11:00 ","To":"22:00 "},"Monday":{"From":"","To":""},"Tuesday":{"From":"","To":""},"Wednesday":{"From":"","To":""},"Thursday":{"From":"","To":""},"Friday":{"From":"","To":""},"Saturday":{"From":"","To":""}}', 'fastfood', 'yes', '', 'active', '2012-10-11 10:01:05'),
(14, 'Subway', 'item_1349642166.jpg', '', '45', '', '1.27', '4', '{"Sunday":{"From":"11:00 ","To":"22:00 "},"Monday":{"From":"","To":""},"Tuesday":{"From":"","To":""},"Wednesday":{"From":"","To":""},"Thursday":{"From":"","To":""},"Friday":{"From":"","To":""},"Saturday":{"From":"","To":""}}', 'fastfood', 'yes', '', 'active', '2012-10-11 10:02:21'),
(15, 'Burger King', 'item_1349642784.jpg', '', '45', '', '3.69', '4', '{"Sunday":{"From":"11:00 ","To":"22:00 "},"Monday":{"From":"","To":""},"Tuesday":{"From":"","To":""},"Wednesday":{"From":"","To":""},"Thursday":{"From":"","To":""},"Friday":{"From":"","To":""},"Saturday":{"From":"","To":""}}', 'fastfood', 'yes', '', 'active', '2012-10-09 13:48:10'),
(16, 'Chicken Cottage', 'item_1349643188.jpg', '', '45', '', '3.96', '4', '{"Sunday":{"From":"11:00 ","To":"22:00 "},"Monday":{"From":"","To":""},"Tuesday":{"From":"","To":""},"Wednesday":{"From":"","To":""},"Thursday":{"From":"","To":""},"Friday":{"From":"","To":""},"Saturday":{"From":"","To":""}}', 'fastfood', 'yes', '', 'active', '2012-10-11 10:00:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_user_id` int(24) NOT NULL,
  `order_rest_id` int(11) NOT NULL,
  `order_rest_type` varchar(100) NOT NULL,
  `order_delivery_type` varchar(250) NOT NULL,
  `order_transaction_id` varchar(250) NOT NULL,
  `order_transaction_details` text NOT NULL,
  `order_payment_type` varchar(25) NOT NULL,
  `order_total` varchar(100) NOT NULL,
  `order_details` text NOT NULL,
  `order_postcode` text NOT NULL,
  `order_address` text NOT NULL,
  `order_note` text NOT NULL,
  `order_phoneno` varchar(100) NOT NULL,
  `order_status` varchar(25) NOT NULL,
  `order_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_user_id`, `order_rest_id`, `order_rest_type`, `order_delivery_type`, `order_transaction_id`, `order_transaction_details`, `order_payment_type`, `order_total`, `order_details`, `order_postcode`, `order_address`, `order_note`, `order_phoneno`, `order_status`, `order_date_added`) VALUES
(2, 1, 0, '', '', '', '', '', '7.06', '{"5":{"ID":"5","QTY":"1","NAME":"New4","TOTAL":7.06},"TOTAL":7.06}', '{"po5 4py":{"E":"464677","N":"99809"}}', '', '', '', 'complete', '2012-09-20 14:53:20'),
(3, 1, 0, '', '', '', '', '', '20.13', '{"5":{"ID":"5","QTY":"1","NAME":"New4","TOTAL":7.06},"TOTAL":20.13,"3":{"ID":"3","QTY":"1","NAME":"Name","TOTAL":3.07},"4":{"ID":"4","QTY":"1","NAME":"New Item1","TOTAL":10}}', '{"po5 4ln":{"E":"464687","N":"99960"}}', '', '', '', 'complete', '2012-09-20 14:53:10'),
(4, 1, 0, '', '', '', '', '', '109.2', '{"6":{"ID":"6","QTY":"3","NAME":"Test Sandwitch","TOTAL":109.2},"TOTAL":109.2}', '{"BH1 1AF":{"E":"409182","N":"91527"}}', '', '', '', 'complete', '2012-09-16 10:08:07'),
(5, 1, 0, '', '', '', '', '', '131.64', '{"TOTAL":10,"4":{"ID":"4","QTY":"1","NAME":"New Item1","TOTAL":10}}', '{"po5 4py":{"E":"464677","N":"99809"}}', '', '', '', 'complete', '2012-09-17 12:06:31'),
(7, 1, 0, '', '', '', '', '', '10.13', '{"5":{"ID":"5","QTY":"1","NAME":"New4","TOTAL":7.06},"TOTAL":10.13,"3":{"ID":"3","QTY":"1","NAME":"Name","TOTAL":3.07}}', '{"po5 4py":{"E":"464677","N":"99809"}}', 'House No 19 ST # 1 49 Tail  Sargodha', '', '', 'complete', '2012-09-20 17:13:35'),
(8, 1, 0, '', '', '', '', '', '13.07', '{"4":{"ID":"4","QTY":"1","NAME":"New Item1","TOTAL":10},"TOTAL":13.07,"3":{"ID":"3","QTY":"1","NAME":"Name","TOTAL":3.07}}', '{"po5 4py":{"E":"464677","N":"99809"}}', 'House No 19 ST # 1 49 Tail  Sargodha', '', '', 'complete', '2012-09-21 01:29:00'),
(12, 1, 0, '', '', '', '', '', '10.13', '{"5":{"ID":"5","QTY":"1","NAME":"New4","TOTAL":7.06},"TOTAL":10.13,"3":{"ID":"3","QTY":"1","NAME":"Name","TOTAL":3.07}}', '{"po5 4py":{"E":"464677","N":"99809"}}', 'Demo Testing  Demo', '', '', 'assign', '2012-10-01 12:24:26'),
(13, 1, 0, '', '', '', '', '', '10.13', '{"5":{"ID":"5","QTY":"1","NAME":"New4","TOTAL":7.06},"TOTAL":10.13,"3":{"ID":"3","QTY":"1","NAME":"Name","TOTAL":3.07}}', '{"po5 4py":{"E":"464677","N":"99809"}}', 'Demo Testing  Demo', '', '', 'assign', '2012-10-01 12:24:26'),
(14, 1, 0, '', '', '', '', '', '10.13', '{"5":{"ID":"5","QTY":"1","NAME":"New4","TOTAL":7.06},"TOTAL":10.13,"3":{"ID":"3","QTY":"1","NAME":"Name","TOTAL":3.07}}', '{"po5 4py":{"E":"464677","N":"99809"}}', 'Demo Testing  Demo', '', '', 'assign', '2012-10-01 12:24:26'),
(15, 1, 3, '', '', '3HK54834JL1838333', '', 'paypal', '9.08', '{"38":{"ID":"38","QTY":"1","NAME":"Blueberry Muffin","TOTAL":1.65},"TOTAL":6.54,"39":{"ID":"39","QTY":"1","NAME":"Double Chocolate muffin","TOTAL":1.65},"40":{"ID":"40","QTY":"1","NAME":"Hot Apple Pie","TOTAL":1.35},"42":{"ID":"42","QTY":"1","NAME":"Belgian Bliss Brownie","TOTAL":1.89}}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing', '', '', 'complete', '2012-10-12 08:07:09'),
(18, 1, 3, 'fastfood', '', '42471914Y1447125X', '{"TRANSACTIONID":"42471914Y1447125X","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d13T05%3a59%3a35Z","CORRELATIONID":"5b08a9ac98271","ACK":"Success","VERSION":"76%2e0","BUILD":"3719653","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"42471914Y1447125X","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d13T05%3a59%3a30Z","AMT":"12%2e30","FEEAMT":"0%2e62","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '12.3', '{"TOTAL":8.49,"16":{"ID":"16","QTY":"1","NAME":"Chicken McNuggets u2122 6 pieces","TOTAL":3.09},"24":{"ID":"24","QTY":"1","NAME":"Hamburger Happy meal","TOTAL":3},"45":{"ID":"45","QTY":"1","NAME":"Coke (1.5 Ltr)","TOTAL":2.4}}', '{"PO2 0DZ":{"E":"465892","N":"102276"}}', 'Demo Testing, PO2 0DZ', 'I am waiting for good delivery service ....', '123467', 'assign', '2012-10-13 06:02:40'),
(19, 1, 3, 'fastfood', '', '7SM41514563345028', '{"TRANSACTIONID":"7SM41514563345028","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d13T14%3a54%3a47Z","CORRELATIONID":"5ed525a347d1d","ACK":"Success","VERSION":"76%2e0","BUILD":"3719653","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"7SM41514563345028","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d13T14%3a52%3a40Z","AMT":"14%2e94","FEEAMT":"0%2e71","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '14.94', '{"39":{"ID":"39","QTY":"1","NAME":"Double Chocolate muffin","TOTAL":1.65},"TOTAL":11.13,"11":{"ID":"11","QTY":"1","NAME":"Filet-O-Fish u2122","TOTAL":3.09},"44":{"ID":"44","QTY":"1","NAME":"McFlurry","TOTAL":1.69},"48":{"ID":"48","QTY":"1","NAME":"7up (1.5 Ltr)","TOTAL":2.3},"46":{"ID":"46","QTY":"1","NAME":"Diet Coke (1.5 Ltr) ","TOTAL":2.4}}', '{"PO2 0DZ":{"E":"465892","N":"102276"}}', 'Demo Testing, PO2 0DZ', 'do it  ASAP', '123467', 'assign', '2012-10-13 15:27:08'),
(20, 1, 3, 'fastfood', '', '50K89105170228640', '{"TRANSACTIONID":"50K89105170228640","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d14T01%3a08%3a34Z","CORRELATIONID":"1aee1d0aac9e3","ACK":"Success","VERSION":"76%2e0","BUILD":"3719653","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"50K89105170228640","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d14T01%3a08%3a30Z","AMT":"6%2e88","FEEAMT":"0%2e43","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '6.88', '{"27":{"ID":"27","QTY":"1","NAME":"Strawberry Milkshake - Medium","TOTAL":1.89},"TOTAL":4.34,"28":{"ID":"28","QTY":"1","NAME":"Strawberry Milkshake - Large","TOTAL":2.45}}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'assign', '2012-10-21 03:30:56'),
(21, 1, 3, 'fastfood', '{"type":"delivery","time":"ASAP"}', '0YB27971MY7591724', '{"TRANSACTIONID":"0YB27971MY7591724","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d15T04%3a04%3a02Z","CORRELATIONID":"c4e22887ce5ef","ACK":"Success","VERSION":"76%2e0","BUILD":"3719653","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"0YB27971MY7591724","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d15T04%3a03%3a57Z","AMT":"53%2e04","FEEAMT":"2%2e00","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '53.04', '{"11":{"ID":"11","QTY":2,"NAME":"Filet-O-Fish u2122","TOTAL":6.18},"TOTAL":49.23,"12":{"ID":"12","QTY":2,"NAME":"Cheeseburger","TOTAL":2.5},"13":{"ID":"13","QTY":2,"NAME":"DOUBLE Cheeseburger","TOTAL":3.78},"14":{"ID":"14","QTY":"1","NAME":"Hamburger","TOTAL":1.17},"15":{"ID":"15","QTY":"1","NAME":"Chicken Legend - with Spicy Tomato Salsa","TOTAL":3.75},"66":{"ID":"66","QTY":"1","NAME":"Zinger Burger","TOTAL":4.25},"67":{"ID":"67","QTY":"1","NAME":"Fillet Tower Burger","TOTAL":4.95},"68":{"ID":"68","QTY":"1","NAME":"Zinger Tower Burger","TOTAL":4.95},"69":{"ID":"69","QTY":"1","NAME":"Mini Fillet with Cheese","TOTAL":2.25},"8":{"ID":"8","QTY":2,"NAME":"Big Mac u2122 ","TOTAL":6.18},"7":{"ID":"7","QTY":2,"NAME":"McChickenu2122 Sandwich","TOTAL":6.18},"10":{"ID":"10","QTY":"1","NAME":"Quarter Pounder with Cheese","TOTAL":3.09}}', '{"PO2 0DZ":{"E":"465892","N":"102276"}}', 'Demo Testing, PO2 0DZ', '', '123467', 'to_confirm', '2012-10-15 04:04:04'),
(22, 1, 3, 'fastfood', '{"type":"delivery","time":"ASAP"}', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T12%3a47%3a45Z","CORRELATIONID":"767b193fe2940","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'to_confirm', '2012-10-22 12:47:45'),
(23, 1, 3, 'fastfood', '"{"type":"delivery","time":"ASAP"}"', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T12%3a49%3a16Z","CORRELATIONID":"c29c0e5681530","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'to_confirm', '2012-10-22 12:49:15'),
(24, 1, 3, 'fastfood', '""{\\"type\\":\\"delivery\\",\\"time\\":\\"ASAP\\"}""', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T12%3a53%3a24Z","CORRELATIONID":"5a011e9473996","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'to_confirm', '2012-10-22 12:53:23'),
(25, 1, 3, 'fastfood', '""\\"{\\\\\\"type\\\\\\":\\\\\\"delivery\\\\\\",\\\\\\"time\\\\\\":\\\\\\"ASAP\\\\\\"}\\"""', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T12%3a56%3a18Z","CORRELATIONID":"75206cd6d3d64","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'to_confirm', '2012-10-22 12:56:21'),
(26, 1, 3, 'fastfood', '""\\"\\\\\\"{\\\\\\\\\\\\\\"type\\\\\\\\\\\\\\":\\\\\\\\\\\\\\"delivery\\\\\\\\\\\\\\",\\\\\\\\\\\\\\"time\\\\\\\\\\\\\\":\\\\\\\\\\\\\\"ASAP\\\\\\\\\\\\\\"}\\\\\\"\\"""', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T12%3a57%3a12Z","CORRELATIONID":"b1ff6f413f84a","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'to_confirm', '2012-10-22 12:57:14'),
(27, 1, 3, 'fastfood', '""\\"\\\\\\"\\\\\\\\\\\\\\"{\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"type\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"delivery\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"time\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"ASAP\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"}\\\\\\\\\\\\\\"\\\\\\"\\"""', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T13%3a09%3a45Z","CORRELATIONID":"9588927f3","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'to_confirm', '2012-10-22 13:09:46'),
(28, 1, 3, 'fastfood', '""\\"\\\\\\"\\\\\\\\\\\\\\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"{\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"type\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"delivery\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\",\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"time\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T13%3a20%3a32Z","CORRELATIONID":"ef2f79b01ac10","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'assign', '2012-10-22 15:40:59'),
(29, 1, 3, 'fastfood', '""\\"\\\\\\"\\\\\\\\\\\\\\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"{\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"type\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\":\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T13%3a26%3a27Z","CORRELATIONID":"edfeb1a929884","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'to_confirm', '2012-10-22 13:26:28'),
(30, 1, 3, 'fastfood', '""\\"\\\\\\"\\\\\\\\\\\\\\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\"{\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\', '5F412723NJ3123639', '{"TRANSACTIONID":"5F412723NJ3123639","PAYMENTSTATUS":"Completed","SUCCESS":{"RECEIVEREMAIL":"awaisk_1349926600_biz%40yahoo%2ecom","RECEIVERID":"SK5AR4UEHWCRU","EMAIL":"mawais_1350019051_per%40yahoo%2ecom","PAYERID":"ZF3KFYWGCSSUW","PAYERSTATUS":"verified","COUNTRYCODE":"GB","SHIPTONAME":"Muhammad%20Awais","SHIPTOSTREET":"1%20Main%20Terrace","SHIPTOCITY":"Wolverhampton","SHIPTOSTATE":"West%20Midlands","SHIPTOCOUNTRYCODE":"GB","SHIPTOCOUNTRYNAME":"United%20Kingdom","SHIPTOZIP":"W12%204LQ","ADDRESSOWNER":"PayPal","ADDRESSSTATUS":"Confirmed","SALESTAX":"0%2e00","SHIPAMOUNT":"0%2e00","SHIPHANDLEAMOUNT":"0%2e00","TIMESTAMP":"2012%2d10%2d21T13%3a29%3a41Z","CORRELATIONID":"b43696dae8781","ACK":"Success","VERSION":"76%2e0","BUILD":"3926908","FIRSTNAME":"Muhammad","LASTNAME":"Awais","TRANSACTIONID":"5F412723NJ3123639","TRANSACTIONTYPE":"expresscheckout","PAYMENTTYPE":"instant","ORDERTIME":"2012%2d10%2d21T12%3a47%3a40Z","AMT":"19%2e44","FEEAMT":"0%2e86","TAXAMT":"0%2e00","CURRENCYCODE":"GBP","PAYMENTSTATUS":"Completed","PENDINGREASON":"None","REASONCODE":"None","PROTECTIONELIGIBILITY":"Eligible","PROTECTIONELIGIBILITYTYPE":"ItemNotReceivedEligible%2cUnauthorizedPaymentEligible","L_QTY0":"1","L_TAXAMT0":"0%2e00","L_CURRENCYCODE0":"GBP"}}', 'paypal', '19.44', '{"44":{"ID":"44","QTY":10,"NAME":"McFlurry","TOTAL":16.9},"TOTAL":16.9}', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'Demo Testing, PO5 4PY', '', '123467', 'to_confirm', '2012-10-22 13:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE IF NOT EXISTS `rating` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_rest_id` int(11) NOT NULL,
  `r_user_id` int(11) NOT NULL,
  `r_order_id` int(11) NOT NULL,
  `r_details` text NOT NULL,
  `r_message` text NOT NULL,
  `r_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`r_id`, `r_rest_id`, `r_user_id`, `r_order_id`, `r_details`, `r_message`, `r_date_added`) VALUES
(1, 3, 1, 9, '{"Quality":"10","Service":"10","Value":"10","Delivery":"10"}', 'Good!', '2012-09-30 03:19:00'),
(2, 3, 1, 1, '{"Quality":"10","Service":"7","Value":"9","Delivery":"2"}', 'I have received late..', '2012-09-30 03:47:41'),
(3, 2, 1, 8, '{"Quality":"1","Service":"2","Value":"3","Delivery":"4"}', 'Not Good', '2012-09-30 03:47:51'),
(4, 3, 1, 7, '{"Quality":"10","Service":"10","Value":"10","Delivery":"1"}', 'I have enjoyed.', '2012-09-30 03:48:00'),
(5, 2, 1, 3, '{"Quality":"10","Service":"10","Value":"10","Delivery":"10"}', 'Excellent!! .. Fantastic!!..', '2012-09-30 03:49:43'),
(6, 3, 1, 15, '{"Quality":"10","Service":"10","Value":"10","Delivery":"10"}', 'Very Good!', '2012-10-14 12:10:18'),
(7, 0, 1, 2, '{"Quality":"10","Service":"10","Value":"10","Delivery":"10"}', 'Very Fast Delivery... And Good', '2012-10-14 12:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_auto_order` varchar(25) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `min_rest_distence` varchar(25) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`setting_id`, `setting_auto_order`, `admin_email`, `min_rest_distence`) VALUES
(1, 'on', 'awaiskhan88172@yahoo.com', '7');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `slider_id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_type` varchar(100) NOT NULL,
  `slider_picture` varchar(250) NOT NULL,
  `slider_status` varchar(25) NOT NULL,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `slider_type`, `slider_picture`, `slider_status`) VALUES
(26, 'left', 'item_1349430319.png', 'active'),
(27, 'left', 'item_1349430345.png', 'active'),
(29, 'left', 'item_1349430373.jpg', 'active'),
(30, 'left', 'item_1349430383.png', 'active'),
(31, 'left', 'item_1349430507.jpg', 'active'),
(32, 'left', 'item_1349430526.jpg', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_email` varchar(250) NOT NULL,
  `staff_name` varchar(250) NOT NULL,
  `staff_password` varchar(250) NOT NULL,
  `staff_address` text NOT NULL,
  `staff_phoneno` varchar(100) NOT NULL,
  `staff_postcode` text NOT NULL,
  `staff_status` varchar(25) NOT NULL,
  `staff_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_email`, `staff_name`, `staff_password`, `staff_address`, `staff_phoneno`, `staff_postcode`, `staff_status`, `staff_date_added`) VALUES
(3, 'asargodha1@gmail.com', 'Staff Name1', '1353924288', '', '923347534031', '{"BH1 1AF":{"E":"409182","N":"91527"}}', 'active', '2012-09-16 06:33:08'),
(4, 'site@domain.com', 'GuyNo1', '6a830af9f303e421bd81d316b57dc6d5', '', '87790083', '{"PO5 4PY":{"E":"464677","N":"99809"}}', 'active', '2012-09-16 06:34:49'),
(6, 'staff@domain.com', 'Awais2', '81dc9bdb52d04dc20036dbd8313ed055', 'House 19 St 12', '34342242', '{"PO5 4LN":{"E":"464687","N":"99960"}}', 'active', '2012-10-02 03:31:11');

-- --------------------------------------------------------

--
-- Table structure for table `staff_order`
--

CREATE TABLE IF NOT EXISTS `staff_order` (
  `staff_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_order_staff_id` int(14) NOT NULL,
  `staff_order_order_id` int(14) NOT NULL,
  `staff_order_status` varchar(25) NOT NULL,
  `staff_order_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `staff_order`
--

INSERT INTO `staff_order` (`staff_order_id`, `staff_order_staff_id`, `staff_order_order_id`, `staff_order_status`, `staff_order_date_added`) VALUES
(1, 4, 1, 'complete', '2012-09-16 10:02:33'),
(2, 4, 2, 'complete', '2012-09-16 10:05:06'),
(3, 4, 3, 'complete', '2012-09-16 10:05:06'),
(4, 3, 4, 'complete', '2012-09-16 10:08:07'),
(5, 4, 5, 'complete', '2012-09-17 12:06:31'),
(6, 6, 3, 'complete', '2012-09-20 16:49:58'),
(7, 6, 2, 'complete', '2012-09-20 16:49:58'),
(8, 6, 7, 'complete', '2012-09-20 17:13:35'),
(9, 6, 8, 'complete', '2012-09-21 01:29:53'),
(10, 6, 8, 'complete', '2012-09-21 01:29:00'),
(11, 6, 9, 'complete', '2012-09-21 01:35:14'),
(12, 6, 10, 'assign', '2012-10-01 12:24:09'),
(13, 4, 11, 'assign', '2012-10-01 12:24:26'),
(14, 4, 12, 'assign', '2012-10-01 12:24:26'),
(15, 4, 13, 'assign', '2012-10-01 12:24:26'),
(16, 4, 14, 'assign', '2012-10-01 12:24:26'),
(17, 4, 15, 'complete', '2012-10-12 08:07:09'),
(18, 4, 16, 'complete', '2012-10-12 08:07:45'),
(19, 4, 17, 'complete', '2012-10-12 08:08:16'),
(20, 6, 18, 'assign', '2012-10-13 06:02:40'),
(21, 6, 19, 'assign', '2012-10-13 15:27:32'),
(22, 6, 20, 'assign', '2012-10-14 01:15:21'),
(23, 6, 21, 'to_confirm', '2012-10-15 04:04:04'),
(24, 4, 22, 'to_confirm', '2012-10-22 12:47:45'),
(25, 4, 23, 'to_confirm', '2012-10-22 12:49:15'),
(26, 4, 24, 'to_confirm', '2012-10-22 12:53:23'),
(27, 4, 25, 'to_confirm', '2012-10-22 12:56:21'),
(28, 4, 26, 'to_confirm', '2012-10-22 12:57:14'),
(29, 4, 27, 'to_confirm', '2012-10-22 13:09:46'),
(30, 4, 28, 'assign', '2012-10-22 15:40:59'),
(31, 4, 29, 'to_confirm', '2012-10-22 13:26:28'),
(32, 4, 30, 'to_confirm', '2012-10-22 13:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(250) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_phoneno` varchar(250) NOT NULL,
  `user_address` text NOT NULL,
  `user_address_1` text NOT NULL,
  `user_city` varchar(250) NOT NULL,
  `user_post_code` varchar(250) NOT NULL,
  `user_dob` varchar(100) NOT NULL,
  `user_hear` varchar(100) NOT NULL,
  `user_status` varchar(25) NOT NULL,
  `user_date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `user_password`, `user_email`, `user_phoneno`, `user_address`, `user_address_1`, `user_city`, `user_post_code`, `user_dob`, `user_hear`, `user_status`, `user_date_added`) VALUES
(1, 'M Awais', '81dc9bdb52d04dc20036dbd8313ed055', 'awais@test.com', '123467', 'Demo Testing', 'Demo Testing 1', 'Demo', 'po5 4py', '23-07-1991', 'Friend', 'active', '2012-10-02 03:08:20'),
(5, 'name', 's', 'awaiskhan88172@yahoo.com', '923347534039', 'Street No 1 House No 19 49 Tail', '1', 'Sargodha', '40100', '', '', 'non-active', '2012-09-17 01:16:31'),
(6, 'name', '03c7c0ace395d80182db07ae2c30f034', 'awaiskhan88172@yahoo.com', '923347534039', 'Street No 1 House No 19 49 Tail', '1', 'Sargodha', '40100', '', '', 'active', '2012-09-06 18:19:06'),
(7, 'xx', '202cb962ac59075b964b07152d234b70', 'asargodha@gmail.com', '923347534039', 'Street No 1 House No 19 49 Tail', '1', 'Sargodha', '40100', '', '', 'active', '2012-10-02 03:33:01'),
(8, 'c', '4a8a08f09d37b73795649038408b5f33', 'asargodhas@gmail.com', '923347534039', 'Street No 1 House No 19 49 Tail', '1', 'Sargodha', '40100', '', '', 'active', '2012-09-07 01:19:07'),
(9, 'xx', '9336ebf25087d91c818ee6e9ec29f8c1', 'awais@test1.com', '6767', '18975 Marbach Lane', '', 'San Antonio', 'RH1 1AA', '', '', 'active', '2012-09-16 10:15:56'),
(10, 'asaSS', 'c51b57a703ba1c5869228690c93e1701', 'SDASDAS@yahoo.com', '923347534039', 'Street No 1 House No 19 49 Tail', '1', 'Sargodha', 'po5 4py', '', '', 'active', '2012-10-05 10:59:16'),
(11, 'dsdasd', '9336ebf25087d91c818ee6e9ec29f8c1', 'awaiskhsdasdasan88172@yahoo.com', '923347534039', 'Street No 1 House No 19 49 Tail', '1', 'Sargodha', 'po5 4py', '', '', 'active', '2012-10-05 11:05:15'),
(12, 'Ade', '194d50205f3aaefcb4c4bba99d13f32a', 'bwoodlt@yahoo.com', '07896592291', '17 blackfriars road', '', 'Portsmouth', 'PO5 4LN', '', '', 'active', '2012-10-08 16:10:37');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
