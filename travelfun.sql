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
-- 資料表結構 `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='管理員';

-- --------------------------------------------------------

--
-- 資料表結構 `favorites`
--

CREATE TABLE `favorites` (
  `user_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sights_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='瀏覽';

-- --------------------------------------------------------

--
-- 資料表結構 `hashtag`
--

CREATE TABLE `hashtag` (
  `hashtag_id` int(10) NOT NULL,
  `hashtag_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `itinerary`
--

CREATE TABLE `itinerary` (
  `itinerary_id` int(10) NOT NULL,
  `itinerary_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'FK_user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='景點';

-- --------------------------------------------------------

--
-- 資料表結構 `maintain`
--

CREATE TABLE `maintain` (
  `admin_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sights_id` int(10) NOT NULL,
  `maint_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='維護(管理員維護景點)';

-- --------------------------------------------------------

--
-- 資料表結構 `opt`
--

CREATE TABLE `opt` (
  `itinerary_id` int(10) NOT NULL,
  `sights_id` int(10) NOT NULL,
  `opt_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='選擇行程';

-- --------------------------------------------------------

--
-- 資料表結構 `photos`
--

CREATE TABLE `photos` (
  `photos_id` int(20) NOT NULL,
  `sights_id` int(10) NOT NULL,
  `photos_files` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `region`
--

CREATE TABLE `region` (
  `region_id` int(10) NOT NULL,
  `region_name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地區';

--
-- 傾印資料表的資料 `region`
--

INSERT INTO `region` (`region_id`, `region_name`) VALUES
(1, '臺北市'),
(2, '新北市'),
(3, '桃園市'),
(4, '臺中市'),
(5, '臺南市'),
(6, '高雄市'),
(7, '基隆市'),
(8, '新竹市'),
(9, '嘉義市'),
(10, '新竹縣'),
(11, '苗栗縣'),
(12, '彰化縣'),
(13, '南投縣'),
(14, '雲林縣'),
(15, '嘉義縣'),
(16, '屏東縣'),
(17, '宜蘭縣'),
(18, '花蓮縣'),
(19, '臺東縣'),
(20, '花蓮縣'),
(21, '臺東縣'),
(22, '澎湖縣'),
(23, '金門縣'),
(24, '連江縣');

-- --------------------------------------------------------

--
-- 資料表結構 `sights`
--

CREATE TABLE `sights` (
  `sights_id` int(10) NOT NULL,
  `sights_address` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sights_intro` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '介紹',
  `sights_tel` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '電話',
  `sights_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='景點';

-- --------------------------------------------------------

--
-- 資料表結構 `sights_hashtag`
--

CREATE TABLE `sights_hashtag` (
  `sights_id` int(10) NOT NULL,
  `hashtag_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='景點hashtag';

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `user_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_key` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='使用者';

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- 資料表索引 `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`sights_id`),
  ADD KEY `sights_id` (`sights_id`);

--
-- 資料表索引 `hashtag`
--
ALTER TABLE `hashtag`
  ADD PRIMARY KEY (`hashtag_id`);

--
-- 資料表索引 `itinerary`
--
ALTER TABLE `itinerary`
  ADD PRIMARY KEY (`itinerary_id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `maintain`
--
ALTER TABLE `maintain`
  ADD PRIMARY KEY (`admin_id`,`sights_id`),
  ADD KEY `sights_id` (`sights_id`);

--
-- 資料表索引 `opt`
--
ALTER TABLE `opt`
  ADD PRIMARY KEY (`itinerary_id`,`sights_id`),
  ADD KEY `sights_id` (`sights_id`);

--
-- 資料表索引 `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`photos_id`),
  ADD KEY `sights_id` (`sights_id`);

--
-- 資料表索引 `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`region_id`);

--
-- 資料表索引 `sights`
--
ALTER TABLE `sights`
  ADD PRIMARY KEY (`sights_id`),
  ADD KEY `region_id` (`region_id`);

--
-- 資料表索引 `sights_hashtag`
--
ALTER TABLE `sights_hashtag`
  ADD PRIMARY KEY (`sights_id`),
  ADD KEY `hashtag_id` (`hashtag_id`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `hashtag`
--
ALTER TABLE `hashtag`
  MODIFY `hashtag_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `itinerary`
--
ALTER TABLE `itinerary`
  MODIFY `itinerary_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `photos`
--
ALTER TABLE `photos`
  MODIFY `photos_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=236;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sights`
--
ALTER TABLE `sights`
  MODIFY `sights_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`sights_id`) REFERENCES `sights` (`sights_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- 資料表的限制式 `itinerary`
--
ALTER TABLE `itinerary`
  ADD CONSTRAINT `itinerary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- 資料表的限制式 `maintain`
--
ALTER TABLE `maintain`
  ADD CONSTRAINT `maintain_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `maintain_ibfk_2` FOREIGN KEY (`sights_id`) REFERENCES `sights` (`sights_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- 資料表的限制式 `opt`
--
ALTER TABLE `opt`
  ADD CONSTRAINT `opt_ibfk_1` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary` (`itinerary_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `opt_ibfk_2` FOREIGN KEY (`sights_id`) REFERENCES `sights` (`sights_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- 資料表的限制式 `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `sights_id` FOREIGN KEY (`sights_id`) REFERENCES `sights` (`sights_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- 資料表的限制式 `sights`
--
ALTER TABLE `sights`
  ADD CONSTRAINT `region_id` FOREIGN KEY (`region_id`) REFERENCES `region` (`region_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- 資料表的限制式 `sights_hashtag`
--
ALTER TABLE `sights_hashtag`
  ADD CONSTRAINT `sights_hashtag_ibfk_1` FOREIGN KEY (`sights_id`) REFERENCES `sights` (`sights_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `sights_hashtag_ibfk_2` FOREIGN KEY (`hashtag_id`) REFERENCES `hashtag` (`hashtag_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
