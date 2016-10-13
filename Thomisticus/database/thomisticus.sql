-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: 01-Out-2016 às 15:30
-- Versão do servidor: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thomisticus`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `authors`
--

CREATE TABLE `authors` (
	`id`   INT(11)      NOT NULL,
	`name` VARCHAR(100) NOT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 17
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `authors`
--

INSERT INTO `authors` (`id`, `name`) VALUES
	(6, 'Ambler, Scott'),
	(3, 'Austen, Jane'),
	(15, 'Clarke'),
	(13, 'Cockburn, Alistair'),
	(5, 'Doyle, Arthur Conan'),
	(10, 'Fowler, Martin'),
	(16, 'Fox, Karen'),
	(8, 'Hunt, Andrew'),
	(4, 'Joyce, James'),
	(14, 'Kotler, Philip'),
	(11, 'Leffingwell, Dean'),
	(1, 'Rohmer, Sax'),
	(7, 'Sadalage, Pramodkumar'),
	(9, 'Thomas, David'),
	(2, 'Whitman, Walt'),
	(12, 'Widrig, Don');

-- --------------------------------------------------------

--
-- Estrutura da tabela `books`
--

CREATE TABLE `books` (
	`id`            INT(11)      NOT NULL,
	`title`         VARCHAR(100) NOT NULL,
	`isbn`          VARCHAR(100) DEFAULT NULL,
	`price_cost`    FLOAT        NOT NULL,
	`price_sale`    FLOAT        NOT NULL,
	`stock`         INT(11)      NOT NULL,
	`call_number`   VARCHAR(100) NOT NULL,
	`edition`       VARCHAR(100) NOT NULL,
	`volume`        VARCHAR(100) DEFAULT NULL,
	`publish_place` VARCHAR(100) DEFAULT NULL,
	`publish_date`  DATE         DEFAULT NULL,
	`abstract`      TEXT,
	`notes`         TEXT,
	`id_publisher`  INT(11)      NOT NULL,
	`id_collection` INT(11)      DEFAULT NULL,
	`id_author`     INT(11)      NOT NULL,
	`id_category`   INT(11)      NOT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 13
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `books`
--

INSERT INTO `books` (`id`, `title`, `isbn`, `price_cost`, `price_sale`, `stock`, `call_number`, `edition`, `volume`, `publish_place`, `publish_date`, `abstract`, `notes`, `id_publisher`, `id_collection`, `id_author`, `id_category`)
VALUES
	(1, 'Tales of Secret Egypt', '849228485048', 100, 150, 25, 'T833 R345', '1', '1', 'New York', '2012-07-02',
	 'Some abstract here', 'Some notes here', 1, 1, 1, 1),
	(2, 'Leaves of Grass', '23424635645', 100, 150, 25, 'L234 W724', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 1, 1, 2, 2),
	(3, 'Pride and Prejudice', '29293038483', 100, 150, 25, 'P937 A942', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 1, 1, 3, 3),
	(4, 'Ulysses', '029298389395654', 100, 150, 25, 'U938 J935', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 2, 1, 4, 4),
	(5, 'The Adventures of Sherlock Holmes', '0289302949423', 100, 150, 25, 'T938 D729', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 2, 1, 5, 5),
	(6, 'Refactoring Databases: Evolutionary Database Design', '978-0321293534', 100, 150, 25, 'R938 A838', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 2, 1, 6, 6),
	(7, 'The Pragmatic Programmer: From Journeyman to Master', '978-0201616224', 100, 150, 25, 'P938', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 3, 1, 8, 7),
	(8, 'UML Distilled: A Brief Guide to the Standard Object Modeling Language', '978-0321193681', 100, 150, 25, 'U938 F947', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 3, 1, 10, 7),
	(9, 'Managing Software Requirements: A Use Case Approach', '978-0321122476', 100, 150, 25, 'M873 L738', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 3, 1, 11, 5),
	(10, 'Writing Effective Use Cases', '978-0201702255', 100, 150, 25, 'W837 C836', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 1, 1, 13, 3),
	(11, 'Marketing for Health Care Organizations', '978-0135575628', 100, 150, 25, 'M838 K893', '1', '1', 'New York', '2012-07-02', 'Some abstract here', 'Some notes here', 3, 1, 14, 2),
	(12, 'Strategic Marketing for Educational Institutions', 'S938 K938', 100, 150, 25, 'S938 K938', '1', '1', 'New York',
	     '2012-07-02', 'Some abstract here', 'Some notes here', 1, 1, 14, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `books_orders`
--

CREATE TABLE `books_orders` (
	`id`       INT(11) NOT NULL,
	`quantity` FLOAT DEFAULT '1',
	`price`    FLOAT   NOT NULL,
	`id_book`  INT(11) NOT NULL,
	`id_order` INT(11) NOT NULL
)
	ENGINE = InnoDB
	DEFAULT CHARSET = utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
	`id`   INT(11)      NOT NULL,
	`name` VARCHAR(100) NOT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 17
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
	(16, 'Administration'),
	(3, 'Biology'),
	(2, 'Computing'),
	(11, 'Databases'),
	(1, 'Education'),
	(14, 'Health'),
	(6, 'History'),
	(15, 'Marketing'),
	(12, 'Modeling'),
	(5, 'Physics'),
	(9, 'Police'),
	(10, 'Programming'),
	(4, 'Psicology'),
	(7, 'Romance'),
	(13, 'Software requirements'),
	(8, 'Tales');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cities`
--

CREATE TABLE `cities` (
	`id`       INT(11)      NOT NULL,
	`name`     VARCHAR(100) NOT NULL,
	`id_state` INT(11)      NOT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 5
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `cities`
--

INSERT INTO `cities` (`id`, `name`, `id_state`) VALUES
	(1, 'São Paulo', 1),
	(2, 'Rio de Janeiro', 2),
	(3, 'Porto Alegre', 3),
	(4, 'Belo Horizonte', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `collections`
--

CREATE TABLE `collections` (
	`id`          INT(11)      NOT NULL,
	`description` VARCHAR(100) NOT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 2
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `collections`
--

INSERT INTO `collections` (`id`, `description`) VALUES
	(1, 'Cool Books Yeah!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
	`id`          INT(11) NOT NULL,
	`id_user`     INT(11) NOT NULL,
	`order_date`  DATE    NOT NULL,
	`value`       FLOAT        DEFAULT NULL,
	`discount`    FLOAT        DEFAULT NULL,
	`final_value` FLOAT   NOT NULL,
	`notes`       VARCHAR(100) DEFAULT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 16
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `order_date`, `value`, `discount`, `final_value`, `notes`) VALUES
	(1, 1, '2012-07-02', 100, 0, 100, ''),
	(2, 2, '2012-07-02', 150, 0, 150, ''),
	(3, 3, '2012-07-02', 140, 0, 140, ''),
	(4, 4, '2012-07-02', 1120, 0, 1120, ''),
	(5, 5, '2012-07-02', 1410, 0, 1410, ''),
	(6, 6, '2012-07-02', 1410, 0, 1410, ''),
	(7, 7, '2012-07-02', 1012, 0, 1012, ''),
	(8, 8, '2012-07-02', 10123, 0, 10123, ''),
	(9, 9, '2012-07-02', 140, 0, 140, ''),
	(10, 10, '2012-07-02', 11420, 0, 11420, ''),
	(11, 1, '2012-11-10', 1120, 0, 1120, ''),
	(12, 1, '2013-06-21', 12530, 0, 12530, ''),
	(13, 2, '2013-08-30', 100, 0, 100, ''),
	(14, 1, '2013-10-14', 500, 0, 500, ''),
	(15, 3, '2014-11-04', 600, 0, 600, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `publishers`
--

CREATE TABLE `publishers` (
	`id`    INT(11)      NOT NULL,
	`name`  VARCHAR(100) NOT NULL,
	`site`  VARCHAR(100) DEFAULT NULL,
	`email` VARCHAR(100) DEFAULT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 4
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `publishers`
--

INSERT INTO `publishers` (`id`, `name`, `site`, `email`) VALUES
	(1, 'Gutemberg project', '', ''),
	(2, 'Addison-Wesley', '', ''),
	(3, 'Prentice Hall', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `states`
--

CREATE TABLE `states` (
	`id`   INT(11)      NOT NULL,
	`name` VARCHAR(100) NOT NULL,
	`uf`   CHAR(2)      NOT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 5
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `states`
--

INSERT INTO `states` (`id`, `name`, `uf`) VALUES
	(1, 'São Paulo', 'SP'),
	(2, 'Rio de Janeiro', 'RJ'),
	(3, 'Rio Grande do Sul', 'RS'),
	(4, 'Minas Gerais', 'MG');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usergroups`
--

CREATE TABLE `usergroups` (
	`id`          INT(11)      NOT NULL,
	`name`        VARCHAR(100) NOT NULL,
	`description` TEXT
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 5
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `usergroups`
--

INSERT INTO `usergroups` (`id`, `name`, `description`) VALUES
	(1, 'Administrator', 'System Administrator'),
	(2, 'Librarian', ''),
	(3, 'Operator', ''),
	(4, 'Client', 'Every kind of client');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
	`id`           INT(11)      NOT NULL,
	`name`         VARCHAR(100) NOT NULL,
	`birthdate`    DATE         NOT NULL,
	`address`      VARCHAR(100) DEFAULT NULL,
	`phone_number` VARCHAR(100) NOT NULL,
	`email`        VARCHAR(100) NOT NULL,
	`login`        VARCHAR(100) NOT NULL,
	`password`     VARCHAR(100) NOT NULL,
	`registration` DATE         DEFAULT NULL,
	`id_city`      INT(11)      NOT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 12
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `birthdate`, `address`, `phone_number`, `email`, `login`, `password`, `registration`, `id_city`)
VALUES
	(1, 'Ayrton Senna', '1970-03-21', 'Rua Bento Gonçalves, 123', '9393-7474', 'ayrton.senna@gmail.com', 'ayrton',
	 'senna', '2012-07-02', 1),
	(2, 'Alain Prost', '1955-02-24', 'Rua Avelino Tallini, 171', '9374-3739', 'alain.prost@gmail.com', 'alain', 'prost', '2012-07-02', 2),
	(3, 'Gerhard Berger', '1959-08-27', 'Rua Benjamin Constant, 123', '9384-4729', 'gerhard.berger@gmail.com', 'gerhard', 'berger', '2012-07-02', 3),
	(4, 'Thierry Boutsen', '1957-07-13', 'Rua Júlio de Castilhos, 848', '9383-4748', 'thierry.boutsen@gmail.com', 'thierry', 'boutsen', '2012-07-02', 1),
	(5, 'Michele Alboreto', '1956-12-23', 'Rua Alberto Torres, 123', '8404-2827', 'michele.alboreto@gmail.com', 'michele', 'alboreto', '2012-07-02', 1),
	(6, 'Nelson Piquet', '1952-08-17', 'Rua Bento Gonçalves, 837', '8364-3733', 'nelson.piquet@gmail.com', 'nelson', 'piquet', '2012-07-02', 1),
	(7, 'Ivan Capelli', '1963-05-24', 'Rua Alberto Pasqualini, 939', '9473-0273', 'ivan.capelli@gmail.com', 'ivan', 'capelli', '2012-07-02', 1),
	(8, 'Derek Warwick', '1954-08-27', 'Rua Júlio de Castilhos, 837', '7492-8302', 'derek.warwick@gmail.com', 'derek', 'warwick', '2012-07-02', 1),
	(9, 'Nigel Mansell', '1953-08-08', 'Rua Benjamin Constant, 938', '7492-8278', 'nigel.mansell@gmail.com', 'nigel', 'mansell', '2012-07-02', 1),
	(10, 'Alessandro Nannini', '1959-07-07', 'Rua Alberto Pasqualini, 837', '7492-4729', 'alessandro.nannini@gmail.com', 'alessandro', 'nannini', '2012-07-02', 3),
	(11, 'Igor Moraes', '1996-05-02', 'Condomínio Entre Lagos', '9999-9999', 'igor.sgm@gmail.com', 'admin', 'admin', '2016-09-19', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_usergroup_map`
--

CREATE TABLE `user_usergroup_map` (
	`id`       INT(11) NOT NULL,
	`id_user`  INT(11) NOT NULL,
	`id_group` INT(11) NOT NULL
)
	ENGINE = InnoDB
	AUTO_INCREMENT = 12
	DEFAULT CHARSET = utf8;

--
-- Extraindo dados da tabela `user_usergroup_map`
--

INSERT INTO `user_usergroup_map` (`id`, `id_user`, `id_group`) VALUES
	(1, 1, 4),
	(2, 2, 4),
	(3, 3, 4),
	(4, 4, 4),
	(5, 5, 4),
	(6, 6, 4),
	(7, 7, 4),
	(8, 8, 4),
	(9, 9, 4),
	(10, 10, 4),
	(11, 11, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `author_id_idx` (`id`),
	ADD KEY `author_name_idx` (`name`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `book_id_idx` (`id`),
	ADD KEY `collection_id` (`id_collection`),
	ADD KEY `author_id` (`id_author`),
	ADD KEY `publisher_id` (`id_publisher`),
	ADD KEY `book_title_idx` (`title`),
	ADD KEY `book_ibfk_5_idx` (`id_category`);

--
-- Indexes for table `books_orders`
--
ALTER TABLE `books_orders`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `item_id_idx` (`id`),
	ADD KEY `book_id` (`id_book`),
	ADD KEY `item_sale_ibfk_2_idx` (`id_order`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `city_id_idx` (`id`),
	ADD KEY `city_name_idx` (`name`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `city_id_idx` (`id`),
	ADD KEY `city_name_idx` (`name`),
	ADD KEY `city_idfk_1_idx` (`id_state`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `collection_id_idx` (`id`),
	ADD KEY `collection_description_idx` (`description`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `loan_id_idx` (`id`),
	ADD KEY `member_id` (`id_user`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `publisher_id_idx` (`id`),
	ADD KEY `publisher_name_idx` (`name`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `city_id_idx` (`id`),
	ADD KEY `city_name_idx` (`name`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
	ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `member_id_idx` (`id`),
	ADD KEY `city_id` (`id_city`),
	ADD KEY `member_name_idx` (`name`);

--
-- Indexes for table `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY `category_id_idx` (`id`),
	ADD KEY `user_group_ibfk_1_idx` (`id_user`),
	ADD KEY `user_group_ibfk_2_idx` (`id_group`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 17;
--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 13;
--
-- AUTO_INCREMENT for table `books_orders`
--
ALTER TABLE `books_orders`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 17;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 2;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 16;
--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 4;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 12;
--
-- AUTO_INCREMENT for table `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
	MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT,
	AUTO_INCREMENT = 12;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `books`
--
ALTER TABLE `books`
	ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `authors` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
	ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`id_collection`) REFERENCES `collections` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
	ADD CONSTRAINT `books_ibfk_4` FOREIGN KEY (`id_publisher`) REFERENCES `publishers` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
	ADD CONSTRAINT `books_ibfk_5` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `books_orders`
--
ALTER TABLE `books_orders`
	ADD CONSTRAINT `books_orders_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
	ADD CONSTRAINT `books_orders_ibfk_2` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `cities`
--
ALTER TABLE `cities`
	ADD CONSTRAINT `city_idfk_1` FOREIGN KEY (`id_state`) REFERENCES `states` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
	ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`id_city`) REFERENCES `cities` (`id`);

--
-- Limitadores para a tabela `user_usergroup_map`
--
ALTER TABLE `user_usergroup_map`
	ADD CONSTRAINT `user_usergroup_map_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION,
	ADD CONSTRAINT `user_usergroup_map_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `usergroups` (`id`)
	ON DELETE NO ACTION
	ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
