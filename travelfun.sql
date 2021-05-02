-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 
-- 伺服器版本： 8.0.17
-- PHP 版本： 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `travelfun`
--

-- --------------------------------------------------------

--
-- 資料表結構 `favorites`
--

CREATE TABLE `favorites` (
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `view_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='瀏覽';

--
-- 傾印資料表的資料 `favorites`
--

INSERT INTO `favorites` (`user_id`, `view_id`) VALUES
('sheng', 2),
('sheng', 3),
('sheng', 4),
('sheng', 5),
('sheng', 8),
('sheng', 13),
('sheng', 31);

-- --------------------------------------------------------

--
-- 資料表結構 `friend`
--

CREATE TABLE `friend` (
  `friend_id` int(10) NOT NULL,
  `oneself` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `others` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='好友';

--
-- 傾印資料表的資料 `friend`
--

INSERT INTO `friend` (`friend_id`, `oneself`, `others`, `status`) VALUES
(1, 'sheng', 'amigo', 1),
(2, 'test2', 'sheng', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `itinerary`
--

CREATE TABLE `itinerary` (
  `itinerary_id` int(10) NOT NULL,
  `itinerary_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_status` int(1) NOT NULL,
  `itinerary_date` date NOT NULL COMMENT '開始日期',
  `itinerary_days` int(3) NOT NULL,
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK_user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='行程';

--
-- 傾印資料表的資料 `itinerary`
--

INSERT INTO `itinerary` (`itinerary_id`, `itinerary_name`, `public_status`, `itinerary_date`, `itinerary_days`, `user_id`) VALUES
(5, '台北', 2, '2021-04-13', 3, 'amigo'),
(10, '高雄', 1, '2021-04-12', 2, 'amigo'),
(12, '新北', 1, '2021-04-14', 1, 'sheng');

-- --------------------------------------------------------

--
-- 資料表結構 `sequence`
--

CREATE TABLE `sequence` (
  `itinerary_id` int(10) NOT NULL,
  `view_id` int(11) NOT NULL,
  `opt_day` int(3) NOT NULL,
  `sequence` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='景點排序';

--
-- 傾印資料表的資料 `sequence`
--

INSERT INTO `sequence` (`itinerary_id`, `view_id`, `opt_day`, `sequence`) VALUES
(5, 1, 1, 1),
(5, 3, 1, 1),
(5, 4, 1, 2),
(5, 8, 2, 1),
(5, 10, 1, 1),
(10, 4, 2, 1),
(12, 2, 1, 1),
(12, 3, 0, NULL),
(12, 4, 1, 1),
(12, 5, 1, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `share`
--

CREATE TABLE `share` (
  `share_id` int(10) NOT NULL,
  `itinerary_id` int(10) NOT NULL,
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='共同作者';

--
-- 傾印資料表的資料 `share`
--

INSERT INTO `share` (`share_id`, `itinerary_id`, `user_id`) VALUES
(20, 10, 'test2'),
(23, 5, 'sheng'),
(24, 10, 'sheng');

-- --------------------------------------------------------

--
-- 資料表結構 `sight`
--

CREATE TABLE `sight` (
  `view_id` int(11) NOT NULL,
  `view_name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortcode` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag_area` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` int(3) NOT NULL,
  `status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `sight`
--

INSERT INTO `sight` (`view_id`, `view_name`, `shortcode`, `timestamp`, `tag_area`, `source`, `status`) VALUES
(1, '三創生活園區 Clapper Studio', 'CITYm-FBImX', '1606928234', 'taipei', 0, 1),
(2, '板橋市政府 新北耶誕城', 'CITYW4ipHe4', '1606924800', 'taipei', 0, 1),
(3, 'COOL TOY 酷玩具', 'CITX8X2hg6B', '1606927885', 'taipei', 0, 1),
(4, '安慰劑 Placebo Taipei', 'CITXp3fgajs', '1606927733', 'taipei', 0, 1),
(5, 'Trio Cafe 三重奏 - 華山', 'CITXcCggsAw', '1606927620', 'taipei', 0, 1),
(6, '虎山峰觀景臺', 'CITXO2ch6OY', '1606927512', 'taipei', 0, 1),
(7, 'Modism Muses 繆斯餐酒館', 'CMJBFjyBVLY', '1615170292', 'taipei', 0, 1),
(8, 'Taipei, Taiwan', 'CMJA1EQHEIk', '1615170157', 'taipei', 0, 1),
(10, 'Taipei, Taiwan', 'CMJAskunSlT', '1615170087', 'taipei', 0, 1),
(11, 'Missgreen', 'CMJAZk_MlVB', '1615169931', 'taipei', 0, 1),
(12, '有之和牛 鍋物放題', 'CMJAVFAnK-w', '1615169895', 'taipei', 0, 1),
(13, '象山', 'CMJAT4-HqRM', '1615169885', 'taipei', 0, 1),
(14, '信義區商圈', 'CMJAS4_hdDe', '1615169877', 'taipei', 0, 1),
(15, '赤?街', 'CMJAHtVD7Pm', '1615169785', 'taipei', 0, 1),
(16, '原岩攀岩館-萬華店 T-UP Climbing Wanhua', 'CMI_lPXj0Fa', '1615169503', 'taipei', 0, 1),
(17, '三分半海鮮鍋物', 'CMI_MLIHtT9', '1615169297', 'taipei', 0, 1),
(18, 'Taipei, Taiwan', 'CMI_GtpnvXX', '1615169253', 'taipei', 0, 1),
(19, '宏南中油宿舍', 'CMI_F56jxaI', '1615169246', 'taipei', 0, 1),
(20, '家香味食堂', 'CMI-XP1B5-K', '1615168864', 'taipei', 0, 1),
(21, '碧山巖櫻花隧道', 'CMI-QitjE-7', '1615168809', 'taipei', 0, 1),
(22, '大鼎豬血湯', 'CMI-QdgH36F', '1615168808', 'taipei', 0, 1),
(23, 'Pingtung County', 'CMI-K9sLVRb', '1615168763', 'taipei', 0, 1),
(24, 'Yellow Lemon', 'CMI-Hfnn99p', '1615168735', 'taipei', 0, 1),
(25, 'Miacucina（My kitchen）復興店', 'CMI-ErTgBXX', '1615168712', 'taipei', 0, 1),
(26, 'de nuit 法式餐廳', 'CMI-EcznkRf', '1615168710', 'taipei', 0, 1),
(27, 'Busan, South Korea', 'CMI95K2FVrh', '1615168617', 'taipei', 0, 1),
(28, 'Roffyscafe', 'CMI9qJTMD3B', '1615168494', 'taipei', 0, 1),
(29, 'Taipei', 'CMI7zW3F2Pu', '1615168394', 'taipei', 0, 1),
(30, '日本美登利壽司（台灣）', 'CMI9RD_nZ1o', '1615168369', 'taipei', 0, 1),
(31, 'Domani 義式餐廳', 'CMI9KMQHRt2', '1615168232', 'taipei', 0, 1),
(32, 'AROS Coffee', 'CMI9BNVhV1K', '1615168159', 'taipei', 0, 1),
(33, '二條通．綠島小夜曲', 'CMI8-z9HGYu', '1615168139', 'taipei', 0, 1),
(34, '財神爺魯肉飯', 'CMI81LonWZe', '1615168060', 'taipei', 0, 1),
(35, '九五峰山頂', 'CMHw0G6H6Fo', '1615128206', 'taipei', 0, 1),
(36, 'Flux Réel Hair Boutique', 'CMEU5h8nUH4', '1615012907', 'taipei', 0, 1),
(37, 'Taoyuan, Taiwan', 'CLPDU3LHR6e', '1613225309', 'taipei', 0, 1),
(38, 'Ribeira Grande São Miguel', 'CFklTXHHemX', '1601062864', 'taipei', 0, 1),
(49, 'test', '12', '1321050142', '1213', 0, 1),
(50, '12', '21', '1364774399', 'taipei', 1, 1),
(51, '12', 'www.yahoo.com', '', '1111', 1, 1),
(52, '板橋市政府 新北耶誕城', NULL, NULL, NULL, 0, NULL),
(53, '板橋市政府 新北耶誕城', NULL, NULL, NULL, 1, 1),
(54, 'IG', NULL, NULL, 'IG', 1, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_key` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `introduction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Authority` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用者';

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`user_id`, `user_password`, `user_name`, `user_email`, `user_key`, `photo`, `introduction`, `Authority`) VALUES
('amigo', '???', 'amigo', 'admin@goodfun.tech', 'wlCCtnaGDxUCZcA0U4AxOCAvgXXqLrW6', NULL, '', 2),
('sheng', '1qaz@WSX', 'sheng', 'fosilaoshiji@protonmail.com', 'ivShcAVnNtctEFxni5qIQ3B9CMMzIMv5', NULL, 'hioo\r\n', 2),
('test0425', '12345678', 'root', 'amigo@amigo', 'U2b4Eln5E1jUMsNer5phbPQtBUTywrCs', NULL, '', 0),
('test2', '123456789', '123', 'amigo1998928@gmail.com', '7chJ2yIYfvfMnxebCuArNsauRYRVeiRt', NULL, '', 2);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`view_id`),
  ADD KEY `sights_id` (`view_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `friend`
--
ALTER TABLE `friend`
  ADD PRIMARY KEY (`friend_id`),
  ADD UNIQUE KEY `friend2_2` (`others`),
  ADD UNIQUE KEY `friend1_2` (`oneself`),
  ADD KEY `friend1` (`oneself`),
  ADD KEY `friend2` (`others`);

--
-- 資料表索引 `itinerary`
--
ALTER TABLE `itinerary`
  ADD PRIMARY KEY (`itinerary_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `sequence`
--
ALTER TABLE `sequence`
  ADD PRIMARY KEY (`itinerary_id`,`view_id`),
  ADD KEY `sights_id` (`view_id`),
  ADD KEY `itinerary_id` (`itinerary_id`);

--
-- 資料表索引 `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`share_id`),
  ADD KEY `itinerary_id` (`itinerary_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `sight`
--
ALTER TABLE `sight`
  ADD PRIMARY KEY (`view_id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `friend`
--
ALTER TABLE `friend`
  MODIFY `friend_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `itinerary`
--
ALTER TABLE `itinerary`
  MODIFY `itinerary_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `share`
--
ALTER TABLE `share`
  MODIFY `share_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sight`
--
ALTER TABLE `sight`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`view_id`) REFERENCES `sight` (`view_id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- 資料表的限制式 `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`oneself`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`others`) REFERENCES `user` (`user_id`);

--
-- 資料表的限制式 `itinerary`
--
ALTER TABLE `itinerary`
  ADD CONSTRAINT `itinerary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- 資料表的限制式 `sequence`
--
ALTER TABLE `sequence`
  ADD CONSTRAINT `sequence_ibfk_1` FOREIGN KEY (`view_id`) REFERENCES `sight` (`view_id`),
  ADD CONSTRAINT `sequence_ibfk_2` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary` (`itinerary_id`);

--
-- 資料表的限制式 `share`
--
ALTER TABLE `share`
  ADD CONSTRAINT `share_ibfk_1` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary` (`itinerary_id`),
  ADD CONSTRAINT `share_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
