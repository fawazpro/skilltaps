-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `cat` varchar(100) NOT NULL,
  `cat_code` int(11) NOT NULL,
  PRIMARY KEY (`cat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `category` (`cat`, `cat_code`) VALUES
('Technology',	21);

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `user_id` varchar(15) NOT NULL,
  `fname` tinytext NOT NULL,
  `lname` tinytext NOT NULL,
  `sex` varchar(6) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(240) NOT NULL,
  `password` tinytext NOT NULL,
  `paid` binary(1) NOT NULL,
  `ref_id` varchar(15) NOT NULL,
  `address` mediumtext NOT NULL,
  `c_wallet` int(11) NOT NULL,
  `p_wallet` int(11) NOT NULL,
  `bank` varchar(220) NOT NULL,
  `acc_name` varchar(220) NOT NULL,
  `acc_num` varchar(11) NOT NULL,
  `tranx` longtext NOT NULL,
  `clearance` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `customers` (`user_id`, `fname`, `lname`, `sex`, `phone`, `email`, `password`, `paid`, `ref_id`, `address`, `c_wallet`, `p_wallet`, `bank`, `acc_name`, `acc_num`, `tranx`, `clearance`, `created_at`, `updated_at`, `deleted_at`) VALUES
('SH2478',	'Fawaz',	'Ibraheem',	'm',	'08108097322',	'fawaz@gmail.com',	'jkhihi',	UNHEX('01'),	'',	'21jkln',	2250,	5250,	'',	'',	'',	'',	1,	'2020-10-06 19:55:24',	'2020-10-11 03:18:11',	'0000-00-00 00:00:00'),
('SH2b793',	'Fawaz',	'Ibrahhem',	'm',	'07061811568',	'fawazisib@gmail.com',	'b1535e3d967fb53881888de8f4286b58de54d23a',	UNHEX('31'),	'SH2478',	'wkfpem ',	2000,	188000,	'Zenith Bank',	'Fawaz Ibraheem',	'2048634157',	'',	11,	'2020-10-11 03:18:07',	'2020-10-23 01:41:57',	'0000-00-00 00:00:00'),
('SH33e25',	'Fawaz',	'Ibraheem',	'm',	'08108097322',	'fawazpro27@gmail.com',	'b1535e3d967fb53881888de8f4286b58de54d23a',	UNHEX('31'),	'SH2478',	'21, Ajegunle',	2250,	5250,	'',	'',	'',	'',	1,	'2020-10-06 13:55:37',	'2020-10-06 13:55:42',	'0000-00-00 00:00:00'),
('SH4c02a',	'Faaw',	'Ibrah',	'm',	'07008979789',	'fawazis@gmail.com',	'b1535e3d967fb53881888de8f4286b58de54d23a',	UNHEX('31'),	'SH2b793',	'jpoj',	0,	0,	'',	'',	'',	'',	1,	'2020-10-11 03:19:20',	'2020-10-11 03:19:23',	'0000-00-00 00:00:00'),
('SH71d4e',	'Terry',	'Noah',	'm',	'08062784601',	'princenoah2013@gmail.com',	'7c4a8d09ca3762af61e59520943dc26494f8941b',	UNHEX('31'),	'SH2b793',	'AJegunle Sagamu',	0,	0,	'',	'',	'',	'',	1,	'2020-10-13 08:12:12',	'2020-10-13 08:12:36',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) NOT NULL,
  `orders` longtext NOT NULL,
  `status` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `notif` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `orders` (`order_id`, `user_id`, `orders`, `status`, `type`, `notif`, `created_at`, `updated_at`, `deleted_at`) VALUES
(21,	'SH2b793',	'[{\"name\":\"Web Hosting - Midi\",\"price\":16000,\"count\":1,\"total\":\"16000.00\"}]',	'Pending',	'p',	1,	'2020-10-22 04:16:05',	'2020-10-23 04:28:54',	'0000-00-00 00:00:00'),
(22,	'SH2b793',	'[{\"name\":\"Web Hosting - Mini\",\"price\":8000,\"count\":2,\"total\":\"16000.00\"},{\"name\":\"Web Hosting - Midi\",\"price\":16000,\"count\":1,\"total\":\"16000.00\"}]',	'Completed',	'p',	1,	'2020-10-22 04:19:04',	'2020-10-24 01:34:22',	'0000-00-00 00:00:00'),
(23,	'SH2b793',	'[{\"name\":\"Web Hosting - Mini\",\"price\":8000,\"count\":2,\"total\":\"16000.00\"},{\"name\":\"Web Hosting - Midi\",\"price\":16000,\"count\":1,\"total\":\"16000.00\"}]',	'Completed',	'p',	1,	'2020-10-22 04:35:03',	'2020-10-23 04:21:29',	'0000-00-00 00:00:00'),
(24,	'SH2b793',	'2500',	'Completed',	'c',	1,	'2020-10-22 11:04:35',	'2020-10-23 04:34:07',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` int(11) NOT NULL,
  `p_category` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `details` longtext NOT NULL,
  `seller` tinytext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`cat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `products` (`id`, `name`, `price`, `image`, `p_category`, `category`, `details`, `seller`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Web Hosting - Mini',	8000,	3,	'Services',	'Technology',	'<div>\n<h2>Web Hosting Midi</h2>\n<div>Lorem&nbsp;ipsum&nbsp;dolor,&nbsp;sit&nbsp;amet&nbsp;consectetur&nbsp;adipisicing&nbsp;elit.&nbsp;Deleniti&nbsp;asperiores&nbsp;officiis&nbsp;reiciendis&nbsp;voluptate,&nbsp;libero&nbsp;officia&nbsp;labore&nbsp;ex&nbsp;nobis,&nbsp;voluptatem&nbsp;maiores&nbsp;atque&nbsp;quae&nbsp;delectus&nbsp;beatae&nbsp;dicta&nbsp;quaerat!&nbsp;Veritatis&nbsp;mollitia&nbsp;modi&nbsp;tempora&nbsp;voluptate&nbsp;reprehenderit&nbsp;laudantium&nbsp;quisquam&nbsp;quis&nbsp;doloribus&nbsp;ut,&nbsp;sed&nbsp;corporis.&nbsp;Asperiores,&nbsp;assumenda&nbsp;nemo&nbsp;harum&nbsp;dicta&nbsp;vel&nbsp;dolorem&nbsp;perspiciatis,&nbsp;iste,&nbsp;sunt&nbsp;nulla&nbsp;quasi&nbsp;qui&nbsp;dolores!&nbsp;</div>\n<div><img src=\"http://localhost/admin.master.terry/uploads/skillhubb/originals/1cb0c074-481a-4a71-8d2c-66eb792806d2.png\" alt=\"Intro1\" /></div>\n<div>Beatae&nbsp;facere&nbsp;deserunt&nbsp;veritatis&nbsp;iure&nbsp;voluptatum&nbsp;tenetur&nbsp;quisquam&nbsp;laboriosam&nbsp;corrupti,&nbsp;dicta&nbsp;quis,&nbsp;quibusdam&nbsp;repellendus&nbsp;exercitationem&nbsp;quasi&nbsp;voluptas&nbsp;possimus&nbsp;aliquid&nbsp;sint&nbsp;aperiam&nbsp;debitis&nbsp;nisi&nbsp;modi.&nbsp;Alias,&nbsp;architecto&nbsp;dolores&nbsp;rem&nbsp;animi&nbsp;sed&nbsp;nesciunt&nbsp;culpa&nbsp;voluptatum&nbsp;cumque&nbsp;veniam,&nbsp;ipsam&nbsp;recusandae&nbsp;adipisci&nbsp;ut&nbsp;voluptatibus?&nbsp;Ea&nbsp;iusto&nbsp;saepe&nbsp;explicabo&nbsp;alias&nbsp;similique&nbsp;dolore?</div>\n</div>',	'SH2b793',	'2020-10-11 09:44:17',	'2020-10-11 09:44:17',	'0000-00-00 00:00:00'),
(2,	'Web Hosting - Midi',	16000,	1,	'Services',	'Technology',	'',	'SH2b793',	'2020-10-11 09:52:48',	'2020-10-11 09:52:48',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `profit`;
CREATE TABLE `profit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` varchar(15) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  CONSTRAINT `profit_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customers` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `profit` (`id`, `customer`, `amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'SH33e25',	3500,	'2020-10-06 13:55:42',	'2020-10-06 13:55:42',	'0000-00-00 00:00:00'),
(2,	'SH2b793',	3500,	'2020-10-11 03:18:11',	'2020-10-11 03:18:11',	'0000-00-00 00:00:00'),
(3,	'SH4c02a',	3500,	'2020-10-11 03:19:23',	'2020-10-11 03:19:23',	'0000-00-00 00:00:00'),
(4,	'SH71d4e',	3500,	'2020-10-13 08:12:36',	'2020-10-13 08:12:36',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(8) NOT NULL,
  `f_name` tinytext NOT NULL,
  `l_name` tinytext NOT NULL,
  `sex` varchar(6) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `password` text NOT NULL,
  `ref_id` varchar(8) NOT NULL,
  `level` int(11) NOT NULL,
  `d_lines` text NOT NULL,
  `paid` bit(1) NOT NULL,
  `upgrade_wallet` int(11) NOT NULL,
  `pending_wallet` int(11) NOT NULL,
  `p_wallet` int(11) NOT NULL,
  `c_wallet` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `user_id`, `f_name`, `l_name`, `sex`, `address`, `email`, `phone`, `password`, `ref_id`, `level`, `d_lines`, `paid`, `upgrade_wallet`, `pending_wallet`, `p_wallet`, `c_wallet`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'SH67401',	'Fawaz',	'Ibraheem',	'',	'',	'fawazpro27@gmail.com',	'08108097322',	'b1535e3d967fb53881888de8f4286b58de54d23a',	'alpha',	3,	'{\"L1\":[2],\"L2\":[3,3,3],\"L3\":[4]}',	CONV('1', 2, 10) + 0,	12500,	125,	0,	0,	'0000-00-00 00:00:00',	'2020-09-19 03:58:41',	'0000-00-00 00:00:00'),
(2,	'SH56891',	'Fawz',	'Ibraheem',	'',	'',	'fawazisib@gmail.com',	'08108097322',	'b1535e3d967fb53881888de8f4286b58de54d23a',	'SH67401',	2,	'{\"L1\":[3,3,5,5,5],\"L2\":[4]}',	CONV('1', 2, 10) + 0,	0,	125,	21000,	9000,	'2020-09-12 19:32:06',	'2020-09-27 00:22:59',	'0000-00-00 00:00:00'),
(3,	'SH34587',	'Fawwazun',	'Ibraheem',	'',	'',	'faazz@sgm.ng',	'08108097322',	'b1535e3d967fb53881888de8f4286b58de54d23a',	'SH56891',	2,	'{\"L1\":[4,4]}',	CONV('0', 2, 10) + 0,	0,	0,	0,	0,	'2020-09-15 03:00:00',	'2020-09-19 03:58:41',	'0000-00-00 00:00:00'),
(4,	'',	'Faaz',	'Ibrahim',	'',	'',	'sgmmallng@gmail.com',	'08033519155',	'b1535e3d967fb53881888de8f4286b58de54d23a',	'SH34587',	1,	'',	CONV('0', 2, 10) + 0,	0,	0,	0,	0,	'2020-09-19 03:58:03',	'2020-09-19 03:58:19',	'0000-00-00 00:00:00'),
(5,	'8acbc',	'AbdQayyum',	'Ibraheem',	'm',	'21, Ajegunle Street Sagamu',	'abdulqayyumibraheem@gmail.com',	'08139381306',	'b1535e3d967fb53881888de8f4286b58de54d23a',	'SH56891',	1,	'',	CONV('1', 2, 10) + 0,	0,	0,	0,	0,	'2020-09-19 12:45:17',	'2020-09-27 00:22:58',	'0000-00-00 00:00:00');

-- 2020-10-24 15:40:59
