-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.4.10-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных shop
CREATE DATABASE IF NOT EXISTS `shop` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `shop`;

-- Дамп структуры для таблица shop.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `eng_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.categories: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
REPLACE INTO `categories` (`id`, `name`, `eng_name`) VALUES
	(2, 'Женское', 'women'),
	(3, 'Аксессуары', 'accessories'),
	(4, 'Игрушки', 'toys'),
	(6, 'Мужское', 'men');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Дамп структуры для таблица shop.delivery_types
CREATE TABLE IF NOT EXISTS `delivery_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.delivery_types: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `delivery_types` DISABLE KEYS */;
REPLACE INTO `delivery_types` (`id`, `name`) VALUES
	(1, 'Самовывоз'),
	(2, 'Курьерная доставка');
/*!40000 ALTER TABLE `delivery_types` ENABLE KEYS */;

-- Дамп структуры для таблица shop.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `second_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `delivery_type_id` int(11) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `house` varchar(50) DEFAULT NULL,
  `flat` varchar(50) DEFAULT NULL,
  `payment_type_id` int(11) NOT NULL,
  `comment_` text DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_price` float DEFAULT NULL,
  `delivery_price` float DEFAULT NULL,
  `order_status_id` int(11) DEFAULT 2,
  `order_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `delivery_type_id` (`delivery_type_id`),
  KEY `payment_type_id` (`payment_type_id`),
  KEY `product_id` (`product_id`),
  KEY `order_status_id` (`order_status_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`delivery_type_id`) REFERENCES `delivery_types` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_type_id`) REFERENCES `payment_types` (`id`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`order_status_id`) REFERENCES `order_statuses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.orders: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
REPLACE INTO `orders` (`id`, `first_name`, `second_name`, `last_name`, `phone`, `email`, `delivery_type_id`, `city`, `street`, `house`, `flat`, `payment_type_id`, `comment_`, `product_id`, `product_price`, `delivery_price`, `order_status_id`, `order_date`) VALUES
	(1, 'Сергей', 'Владимирович', 'Астахов', '+79780597755', 'astakhov.sergey@gmail.com', 2, 'г. Санкт-Петербург', 'пр. Невский', '52', '40', 1, 'Добрый день! Просьба доставить к парадной. Спасибо', 27, 8000, 0, 1, '2020-05-12 20:40:01'),
	(2, 'Валентина', NULL, 'Григорьева', '+79615516240', 'murzilka.val@mail.ru', 1, NULL, NULL, NULL, NULL, 1, NULL, 27, 8000, 0, 2, '2020-05-12 20:41:50');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Дамп структуры для таблица shop.order_statuses
CREATE TABLE IF NOT EXISTS `order_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.order_statuses: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `order_statuses` DISABLE KEYS */;
REPLACE INTO `order_statuses` (`id`, `name`) VALUES
	(1, 'Выполнено'),
	(2, 'Не выполнено');
/*!40000 ALTER TABLE `order_statuses` ENABLE KEYS */;

-- Дамп структуры для таблица shop.pages_access
CREATE TABLE IF NOT EXISTS `pages_access` (
  `role_id` int(11) DEFAULT NULL,
  `page_name` varchar(50) NOT NULL,
  KEY `role_id` (`role_id`),
  CONSTRAINT `pages_access_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.pages_access: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `pages_access` DISABLE KEYS */;
REPLACE INTO `pages_access` (`role_id`, `page_name`) VALUES
	(1, 'products'),
	(1, 'orders'),
	(2, 'orders'),
	(1, 'add');
/*!40000 ALTER TABLE `pages_access` ENABLE KEYS */;

-- Дамп структуры для таблица shop.payment_types
CREATE TABLE IF NOT EXISTS `payment_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.payment_types: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `payment_types` DISABLE KEYS */;
REPLACE INTO `payment_types` (`id`, `name`) VALUES
	(1, 'Наличные'),
	(2, 'Банковской картой');
/*!40000 ALTER TABLE `payment_types` ENABLE KEYS */;

-- Дамп структуры для таблица shop.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `img_folder` varchar(255) NOT NULL,
  `is_new` tinyint(4) DEFAULT 0,
  `on_sale` tinyint(4) DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.products: ~22 rows (приблизительно)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
REPLACE INTO `products` (`id`, `name`, `price`, `img_folder`, `is_new`, `on_sale`, `is_active`) VALUES
	(27, 'Стич', 8000, '/img/products/5eb3f579b445b.png', 1, 0, 1),
	(28, 'Енотик', 9000, '/img/products/5eb43c2db5a70.jpg', 1, 0, 1),
	(29, 'Зайка', 15000, '/img/products/5eb4014f00497.jpg', 0, 1, 1),
	(30, 'Котик', 18000, '/img/products/5eb40b556621c.jpg', 0, 0, 1),
	(31, 'Летучая мышка', 10000, '/img/products/5eb40b6974538.jpg', 1, 0, 1),
	(32, 'Треуголка', 5000, '/img/products/5eb40b7975127.jpg', 0, 1, 1),
	(33, 'Медвежонок', 17000, '/img/products/5eb40baea4986.jpg', 1, 1, 1),
	(34, 'Акула', 25000, '/img/products/5eb40bcaebf18.jpg', 1, 0, 1),
	(35, 'Акулка', 10000, '/img/products/5eb40bd8a8f46.jpg', 0, 1, 0),
	(36, 'Совушка', 8000, '/img/products/5eb40d496fbc8.jpg', 1, 0, 1),
	(37, 'Обезьянка', 23000, '/img/products/5eb40d5ea0484.jpg', 1, 0, 1),
	(38, 'Пингвинчик', 16000, '/img/products/5eb40d6e5edc5.jpg', 0, 1, 1),
	(39, 'Панда', 21000, '/img/products/5eb40d7e8f5c0.jpg', 1, 0, 1),
	(40, 'Собачка', 10000, '/img/products/5eb481564fb9a.jpg', 1, 0, 1),
	(41, 'Слоник', 10000, '/img/products/5eb818a175c43.jpg', 1, 0, 1),
	(42, 'Крыска', 18000, '/img/products/5eb818b05f977.jpg', 0, 1, 1),
	(43, 'Дельфинчик', 16000, '/img/products/5eb81926bf605.jpg', 0, 0, 1),
	(44, 'Кролик', 17000, '/img/products/5eb8194439943.jpg', 1, 1, 1),
	(45, 'Лемурчик', 14000, '/img/products/5eb81973c06df.jpg', 1, 0, 1),
	(47, 'Чебурашка', 15000, '/img/products/5ebae0da52ddd.jpg', 0, 0, 1),
	(48, 'Ослик', 17000, '/img/products/5eba895ba4df5.jpg', 1, 0, 1),
	(49, 'Лисичка', 16000, '/img/products/5ebadafa1d1fe.jpg', 1, 0, 1),
	(50, 'Слонёнок Дамбо', 18000, '/img/products/5ebae099952b3.jpeg', 1, 0, 1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Дамп структуры для таблица shop.product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  KEY `product_id` (`product_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_category_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `product_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.product_category: ~41 rows (приблизительно)
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
REPLACE INTO `product_category` (`product_id`, `category_id`) VALUES
	(27, 4),
	(29, 2),
	(29, 4),
	(30, 3),
	(30, 4),
	(32, 3),
	(32, 4),
	(32, 6),
	(33, 2),
	(33, 4),
	(35, 3),
	(35, 4),
	(36, 4),
	(37, 3),
	(37, 4),
	(39, 2),
	(39, 4),
	(31, 4),
	(31, 6),
	(28, 2),
	(28, 3),
	(40, 3),
	(40, 4),
	(41, 2),
	(41, 4),
	(42, 3),
	(42, 4),
	(43, 4),
	(44, 2),
	(44, 3),
	(44, 4),
	(45, 2),
	(45, 4),
	(38, 3),
	(38, 4),
	(48, 2),
	(48, 4),
	(49, 2),
	(49, 4),
	(34, 4),
	(50, 3),
	(50, 4),
	(47, 4);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;

-- Дамп структуры для таблица shop.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.roles: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
REPLACE INTO `roles` (`id`, `name`) VALUES
	(1, 'Администратор'),
	(2, 'Оператор');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Дамп структуры для таблица shop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
REPLACE INTO `users` (`id`, `name`, `email`, `password`) VALUES
	(3, 'Администратор', 'admin@diploma.ru', '$2y$10$6YFwynS3tvYbOEeTUlJdTuXJJW2hmw0rMHZZDvibPajGJeVbK1KyW'),
	(4, 'Оператор', 'operator@diploma.ru', '$2y$10$oJ6GwhR4yY.GsrWUYC3UE.Xa76sVpsw6teWsLSTeailjfft5HPXva');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Дамп структуры для таблица shop.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы shop.user_role: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
REPLACE INTO `user_role` (`user_id`, `role_id`) VALUES
	(3, 1),
	(4, 2);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
