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
('sheng', 55),
('sheng', 77),
('sheng', 78),
('sheng', 79),
('sheng', 80);

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
(1, 'sheng', 'amigo', 1);

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
(19, '基隆', 1, '2021-05-08', 2, 'sheng');

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
(19, 55, 1, 1),
(19, 77, 1, 1),
(19, 78, 2, 1),
(19, 80, 2, 1);

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
(23, 5, 'sheng'),
(29, 19, 'amigo');

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
(55, '阿華炒麵', 'COYJz3gns-5', '1619973149', 'keelung', 0, 1),
(56, '茗香園冰室 - 大安店', 'CM_C4w6jHzo', '1616983175', 'taipei', 0, 1),
(57, 'Panchiao', 'CM_CzkQBae7', '1616983132', 'taipei', 0, 1),
(58, '石梯坪', 'CM_CkLnnH42', '1616983006', 'taipei', 0, 1),
(59, '陽明山擎天崗', 'CM_ChhJDxm_', '1616982984', 'taipei', 0, 1),
(60, 'Taipei, Taiwan', 'CM_CbxsnUC2', '1616982937', 'taipei', 0, 1),
(61, '沙崙海灘', 'CM_CVcXlqtF', '1616982885', 'taipei', 0, 1),
(62, '寧夏觀光夜市', 'CM_B9a2nG0x', '1616982689', 'taipei', 0, 1),
(63, 'Ms.艾瑪小姐 美甲/美睫/韓式半永久', 'CM_B9DtpVu6', '1616982686', 'taipei', 0, 1),
(64, 'Singkawang', 'CM_B5YLr8PU', '1616982655', 'taipei', 0, 1),
(65, '浮光書店', 'CM_B0HcjWkL', '1616982612', 'taipei', 0, 1),
(66, '西門町 Ximenting', 'CM_ByDvBqqn', '1616982596', 'taipei', 0, 1),
(67, '東咖啡 Dong Coffee Bar', 'CM_Brm_HH3i', '1616982543', 'taipei', 0, 1),
(68, '三芝區', 'CM_BSurp7SI', '1616982339', 'taipei', 0, 1),
(69, 'Taipei, Taiwan', 'CM_BQJinpIt', '1616982318', 'taipei', 0, 1),
(70, 'Taipei, Taiwan', 'CM_A-AxBuG-', '1616982169', 'taipei', 0, 1),
(71, 'Taipei, Taiwan', 'CM_AyPnHVWj', '1616982073', 'taipei', 0, 1),
(72, '艾叻沙', 'CM_AYx5H8E2', '1616981864', 'taipei', 0, 1),
(73, '信義區商圈', 'CM-_WH7MMOU', '1616981318', 'taipei', 0, 1),
(74, 'Taipe 101', 'CM-_RVrHtUO', '1616981279', 'taipei', 0, 1),
(75, '鶯歌陶瓷博物館', 'CM-_JJ9shUr', '1616981212', 'taipei', 0, 1),
(76, 'Din Tai Fung Taipei 101', 'CLwjXTFhbLI', '1614349402}]', 'taipei', 0, 1),
(77, '正濱漁港', 'CM_ODuDDRSt', '1616989032', 'keelung', 0, 1),
(78, '萬祝號', 'CM_NMwMHsU2', '1616988581', 'keelung', 0, 1),
(79, '基隆仙洞巖', 'CM_NDUnjmoN', '1616988504', 'keelung', 0, 1),
(80, 'Mr.uncle - 大叔先生', 'CM_K8cNDuES', '1616987399', 'keelung', 0, 1),
(81, 'Bobo nail Studio 美甲工作室 基隆七堵百福五堵汐止凝膠美甲', 'CM_I9Qfjp0G', '1616986357', 'keelung', 0, 1),
(82, '義美自助火鍋城', 'CM_IAzdDRvu', '1616985862', 'keelung', 0, 1),
(83, '延平街口傳統早餐店', 'CM_HA9ThkVr', '1616985339', 'keelung', 0, 1),
(84, '容軒步道', 'CM_EUyvLPMu', '1616983929', 'keelung', 0, 1),
(85, '基隆港 - 海洋廣場', 'CM_AsDIDPet', '1616982022', 'keelung', 0, 1),
(86, 'Keelung, Taiwan', 'CM-6BSMDgiX', '1616978526', 'keelung', 0, 1),
(87, '夏朵義式咖啡cafe chateau', 'CM-56XlnJz7', '1616978469', 'keelung', 0, 1),
(88, '容軒步道', 'CM-5zoEr7YN', '1616978414', 'keelung', 0, 1),
(89, '基隆港 Keelung Harbor', 'CM-34EmhXUO', '1616977402', 'keelung', 0, 1),
(90, '汐止區', 'CM-wmBunUOc', '1616973584', 'keelung', 0, 1),
(91, '正豐鵝肉老店', 'CM-O0JRMCZ4', '1616955874', 'keelung', 0, 1),
(92, '基隆嶼', 'CM-OOAdMm8h', '1616955562', 'keelung', 0, 1),
(93, '基隆嶼燈塔', 'CM-MdcUMXis', '1616954639', 'keelung', 0, 1),
(94, '基隆嶼', 'CM-JgszMqU0', '1616953093', 'keelung', 0, 1),
(95, '中山陸橋', 'CM-GlVgDYqc', '1616951558', 'keelung', 0, 1),
(96, 'Keelung', 'CM-E87bnEgv', '1616950703', 'keelung', 0, 1),
(97, 'Taiwan', 'CM-E1E6nnVv', '1616950639', 'keelung', 0, 1),
(98, 'LOKA CAFE', 'CM-A43oFTHh', '1616948573', 'keelung', 0, 1),
(99, '十一指古道', 'COF7sV1hxhv', '1619361768', 'Taoyuan', 0, 1),
(100, '八番居酒屋', 'COF7pDnAW6F', '1619361741', 'Taoyuan', 0, 1),
(101, '癮食聖堂 Poppy Church', 'COF7iruJrCu', '1619361689', 'Taoyuan', 0, 1),
(102, '陪你去流浪', 'COF7cCvhDqW', '1619361634', 'Taoyuan', 0, 1),
(103, '桃園巨蛋體育館', 'COF656_FZpV', '1619361355', 'Taoyuan', 0, 1),
(104, 'Mitsui Outlet Park 林口', 'COF64xYjRU-', '1619361345', 'Taoyuan', 0, 1),
(105, 'Daisy cafe', 'COF6vu-AbQd', '1619361271', 'Taoyuan', 0, 1),
(106, '汴洲公園', 'COF59rRAfd4', '1619360987', 'Taoyuan', 0, 1),
(107, '桃園大溪笠復威斯汀度假酒店 The Westin Tashee Resort, Taoyu', 'COF6BuLha8X', '1619360894', 'Taoyuan', 0, 1),
(108, '白千層綠色隧道', 'COF4W2Xh9cr', '1619360019', 'Taoyuan', 0, 1),
(109, 'The Good One Coffee Roaster', 'COF342yn6bP', '1619359773', 'Taoyuan', 0, 1),
(110, '石門水庫坪林收費站', 'COF3AU6LktY', '1619359310', 'Taoyuan', 0, 1),
(111, 'Hsin 美學', 'COF2NKhAD1j', '1619358891', 'Taoyuan', 0, 1),
(112, '台茂購物中心 TaiMall Shopping Center', 'COF2EYkpWGR', '1619358819', 'Taoyuan', 0, 1),
(113, 'Hakkafe’哈嘎廢', 'COF1tC_MyzO', '1619358628', 'Taoyuan', 0, 1),
(114, 'Xpark水族館', 'COF1gntBEzY', '1619358526', 'Taoyuan', 0, 1),
(115, 'Friend In Cafe', 'COF1Rl7nDlz', '1619358403', 'Taoyuan', 0, 1),
(116, '阿蕊姨米干', 'COF06cnsIdc', '1619358213', 'Taoyuan', 0, 1),
(117, '東眼山國家森林遊樂區森林浴場', 'COF0q4Ujxcm', '1619358086', 'Taoyuan', 0, 1),
(118, 'Abbraccio 抱抱義大利', 'COF0NvxHuSi', '1619357847', 'Taoyuan', 0, 1),
(119, '東眼山國家森林遊樂區森林浴場', 'COF0D4CjM0-', '1619357766', 'Taoyuan', 0, 1),
(120, '桃園機場第二航廈', 'COFz9A8B3eP', '1619357710', 'Taoyuan', 0, 1),
(121, '新屋綠色走廊', 'COFz5VoMj1X', '1619357680', 'Taoyuan', 0, 1),
(122, '桃園市立大溪木藝生態博物館', 'COFzr-QLKnh', '1619357570', 'Taoyuan', 0, 1),
(123, 'GLORIA OUTLETS 華泰名品城', 'COFzYn1HCz3', '1619357412', 'Taoyuan', 0, 1),
(124, 'Taoyuan, Taiwan', 'COFywn-sDjB', '1619357084', 'Taoyuan', 0, 1),
(125, '友竹居茶藝館', 'COFyt6enDJv', '1619357062', 'Taoyuan', 0, 1),
(126, '華泰名品城', 'COFylNvHBFP', '1619356991', 'Taoyuan', 0, 1),
(127, '石門水庫坪林收費站', 'COFyc0lF4Y1', '1619356922', 'Taoyuan', 0, 1),
(128, '桃園忠烈祠暨神社文化園區', 'COFyV8BM_9e', '1619356866', 'Taoyuan', 0, 1),
(129, '路伊Salon-美髮/美甲/霧眉/熱蠟美肌', 'COFwhNAhTeB', '1619355909', 'Taoyuan', 0, 1),
(130, 'Maison_406', 'COFwJhip9v1', '1619355715', 'Taoyuan', 0, 1),
(131, '國旗屋雲南米線、米干', 'COFvum0nF4m', '1619355495', 'Taoyuan', 0, 1),
(132, '埔心牧場', 'COFuzInDX-X', '1619355008', 'Taoyuan', 0, 1),
(133, '福勝亭‧Tonkatsu', 'COFt545g6g1', '1619354539', 'Taoyuan', 0, 1),
(134, '甘家堡 桐花林', 'COFtC-IAHX4', '1619354089', 'Taoyuan', 0, 1),
(135, '蛋寶生技不老村', 'COFtCMKJJKq', '1619354082', 'Taoyuan', 0, 1),
(136, '甘家堡 桐花林', 'COFsqDUg8Hb', '1619353885', 'Taoyuan', 0, 1),
(137, '桃園國際機場 Taoyuan International Airport', 'COFsYoxAYmT', '1619353742', 'Taoyuan', 0, 1),
(138, 'MEET NIGHT CLUB', 'COFqEbPgySz', '1619352528', 'Taoyuan', 0, 1),
(139, '新屋綠色隧道「濱海自行車道」', 'COFpaa3F_F3', '1619352184', 'Taoyuan', 0, 1),
(140, '南崁', 'COFpZ6Rjzf-', '1619352179', 'Taoyuan', 0, 1),
(141, '怎麻辣', 'COFpTFEAvnA', '1619352124', 'Taoyuan', 0, 1),
(142, '桃園大溪笠復威斯汀度假酒店 The Westin Tashee Resort, Taoyu', 'COFngW0hnTn', '1619351184', 'Taoyuan', 0, 1),
(143, 'New Taipei City', 'COFm_7YAxYN', '1619350918', 'Taoyuan', 0, 1),
(144, '甘家堡 桐花林', 'COFmQbyBjfy', '1619350529', 'Taoyuan', 0, 1),
(145, '桃園77藝文町', 'COFlr1JHIlw', '1619350229', 'Taoyuan', 0, 1),
(146, '綠島', 'COFle65leTv', '1619350123', 'Taoyuan', 0, 1),
(147, '麵屋一人', 'COFfTh5AES7', '1619346884', 'Taoyuan', 0, 1),
(148, '塔那咖啡', 'COFPIfMrJ0-', '1619338405', 'Taoyuan', 0, 1),
(149, '莫甜 More Sweets', 'COEv90DpW51', '1619322065', 'Taoyuan', 0, 1),
(150, '台灣高鐵桃園站 THSR Taoyuan Station', 'CODDm5KAgCv', '1619265254', 'Taoyuan', 0, 1),
(151, 'Xpark水族館', 'CN6zJXulAsR', '1618988188}]', 'Taoyuan', 0, 1),
(152, '新竹孔廟', 'COGRbLnDieQ', '1619373161', 'Hsinchu', 0, 1),
(153, 'Hsinchu, Taiwan', 'COGQcrkLG6D', '1619372649', 'Hsinchu', 0, 1),
(154, '新竹火車站hsinchu Train Station', 'COGKxQ7hWer', '1619369672', 'Hsinchu', 0, 1),
(155, '新竹市鐵道藝術村', 'COGIvxHnz67', '1619368611', 'Hsinchu', 0, 1),
(156, '漫步天湖露營區', 'COGIc15nCfe', '1619368456', 'Hsinchu', 0, 1),
(157, '天馬行空露營區', 'COGIK8Fnpdi', '1619368310', 'Hsinchu', 0, 1),
(158, '新竹內灣老街', 'COGGEw-JXPN', '1619367211', 'Hsinchu', 0, 1),
(159, '杷記韓式料理', 'COGCJCUHxYN', '1619365148', 'Hsinchu', 0, 1),
(160, '寶山第二水庫', 'COGB6ounLvt', '1619365030', 'Hsinchu', 0, 1),
(161, 'July.28', 'COGBm6JpFIA', '1619364869', 'Hsinchu', 0, 1),
(162, 'Hsinchu, Taiwan', 'COGBcHRhAq9', '1619364780', 'Hsinchu', 0, 1),
(163, 'July.28', 'COGBSBkJLLJ', '1619364698', 'Hsinchu', 0, 1),
(164, 'Petaling Jaya, Malaysia', 'COGAr8qHT3v', '1619364467', 'Hsinchu', 0, 1),
(165, '東大路橋', 'COF_wpnLdpA', '1619363900', 'Hsinchu', 0, 1),
(166, '東大路橋', 'COF_IbcLIsw', '1619363571', 'Hsinchu', 0, 1),
(167, '東安古橋', 'COF_Ev_JFpy', '1619363540', 'Hsinchu', 0, 1),
(168, '新竹內灣老街', 'COF-nIpp2c3', '1619363298', 'Hsinchu', 0, 1),
(169, '青林農場', 'COF9IrcnvP2', '1619362524', 'Hsinchu', 0, 1),
(170, '泰崗野溪溫泉', 'COF8lDxD1fH', '1619362232', 'Hsinchu', 0, 1),
(171, '新竹巿立動物園', 'COF73I9sIRC', '1619361856', 'Hsinchu', 0, 1),
(172, '東窩溪螢火蟲生態區', 'COF7nzPFaI8', '1619361730', 'Hsinchu', 0, 1),
(173, 'Susumu', 'COF66UypzIZ', '1619361358', 'Hsinchu', 0, 1),
(174, '新竹公園 Hsinchu Park', 'COF6u5UhJ5A', '1619361264', 'Hsinchu', 0, 1),
(175, '高島縱走', 'COF6nTgH0Km', '1619361202', 'Hsinchu', 0, 1),
(176, '鳳崎落日登山步道', 'COF6aiwJ1sg', '1619361098', 'Hsinchu', 0, 1),
(177, '暗室微光', 'COF5xUXlEyz', '1619360760', 'Hsinchu', 0, 1),
(178, '李克承博士故居 a-moom', 'COF5RJFHgrH', '1619360496', 'Hsinchu', 0, 1),
(179, '愛露營 天景露營區', 'COF4sXiBYDk', '1619360195', 'Hsinchu', 0, 1),
(180, '日本橋浜町食事処-新竹大遠百店', 'COF4i1jreAt', '1619360117', 'Hsinchu', 0, 1),
(181, '無恙', 'COF4fwUHKGa', '1619360092', 'Hsinchu', 0, 1),
(182, '崎頂車站', 'COF4HzTgLq5', '1619359895', 'Hsinchu', 0, 1),
(183, 'Kukukohi_哭哭咖啡', 'COF4AXVpPZl', '1619359835', 'Hsinchu', 0, 1),
(184, '暗室微光', 'COF3U5_H0_7', '1619359479', 'Hsinchu', 0, 1),
(185, 'Hsinchu, Taiwan', 'COF20jqBmkd', '1619359213', 'Hsinchu', 0, 1),
(186, '飛鳳山', 'COF2HijpOsc', '1619358845', 'Hsinchu', 0, 1),
(187, '湖口鄉', 'COF1oKQBOqL', '1619358588', 'Hsinchu', 0, 1),
(188, '新竹孔廟', 'COFzui3MkWA', '1619357591', 'Hsinchu', 0, 1),
(189, '香山濕地賞蟹步道', 'COFsGWpM9tW', '1619353592', 'Hsinchu', 0, 1),
(190, '東大路橋', 'COFpYesLHkG', '1619352168', 'Hsinchu', 0, 1),
(191, '東大路橋', 'COFnm5GL29s', '1619351237', 'Hsinchu', 0, 1),
(192, '東大路橋', 'COFnePOL_jZ', '1619351166', 'Hsinchu', 0, 1),
(193, '東大路橋上', 'COFm8l9LZBb', '1619350891', 'Hsinchu', 0, 1),
(194, '新竹火車站hsinchu Train Station', 'CNiDlskhg74', '1618157948', 'Hsinchu', 0, 1),
(195, '客雅大道', 'CNiC2ZshHBH', '1618157561', 'Hsinchu', 0, 1),
(196, '新竹中正路', 'CNiCeozhspa', '1618157366', 'Hsinchu', 0, 1),
(197, '火炎山大峽谷', 'COGXbqblxH6', '1619376311', 'Miaoli', 0, 1),
(198, '九天夕陽之樹', 'COGUbnvln0W', '1619374738', 'Miaoli', 0, 1),
(199, '金山跳石沒有名字的咖啡店', 'COGIRQknpYk', '1619368362', 'Miaoli', 0, 1),
(200, '鯉魚潭水庫 Liyutan Dam', 'COGFgljBDMb', '1619366914', 'Miaoli', 0, 1),
(201, '魚刺人雞蛋糕-修車廠店', 'COGEuBznIff', '1619366500', 'Miaoli', 0, 1),
(202, '加里山', 'COGEoMiDEDM', '1619366452', 'Miaoli', 0, 1),
(203, '小山丘', 'COGD1WwD6mg', '1619366036', 'Miaoli', 0, 1),
(204, '橙香森林', 'COGDkpUs_iX', '1619365899', 'Miaoli', 0, 1),
(205, '窩 coffee', 'COGDGQ4sX_j', '1619365650', 'Miaoli', 0, 1),
(206, '蔬皮肚皮 Superduper', 'COGB9yFsO5c', '1619365056', 'Miaoli', 0, 1),
(207, '功維敘隧道', 'COGBz9MMqo0', '1619364976', 'Miaoli', 0, 1),
(208, '火炎山大峽谷', 'COF_L3OpQ2P', '1619363599', 'Miaoli', 0, 1),
(209, '漫步雲端', 'COF_LlJhuOG', '1619363596', 'Miaoli', 0, 1),
(210, '魚刺人雞蛋糕-修車廠店', 'COF_Co6noBy', '1619363523', 'Miaoli', 0, 1),
(211, '銅鑼茶廠', 'COF8MxMhecB', '1619362033', 'Miaoli', 0, 1),
(212, '3sän cafe', 'COF6uRgp4I-', '1619361259', 'Miaoli', 0, 1),
(213, 'U+西湖包棟民宿', 'COF5WjHJzP7', '1619360541', 'Miaoli', 0, 1),
(214, 'Mountaintown Coffee Roasters', 'COF5FsRBXkN', '1619360402', 'Miaoli', 0, 1),
(215, '竹南虱目魚大王', 'COF4spYrE-y', '1619360197', 'Miaoli', 0, 1),
(216, 'Miaoli County', 'COF31GoJQb8', '1619359742', 'Miaoli', 0, 1),
(217, '苗栗', 'COF3ppADV8L', '1619359648', 'Miaoli', 0, 1),
(218, '苗栗烏嘎彥竹林之旅', 'COF3RqdFv_x', '1619359452', 'Miaoli', 0, 1),
(219, '莫內秘密花園', 'COF0oA4n3kB', '1619358062', 'Miaoli', 0, 1),
(220, '苗栗', 'COF0D41HPbt', '1619357766', 'Miaoli', 0, 1),
(221, 'Miaoli County', 'COFyetwJWs6', '1619356937', 'Miaoli', 0, 1),
(222, '銅鑼茶廠', 'COFs1LuD8-M', '1619353976', 'Miaoli', 0, 1),
(223, '火炎山', 'COFqCw_H9tr', '1619352514', 'Miaoli', 0, 1),
(224, '臺灣客家文化館', 'COFp_zCHpAl', '1619352490', 'Miaoli', 0, 1),
(225, '魚藤坪斷橋', 'COFkFV2nP86', '1619349390', 'Miaoli', 0, 1),
(226, '磨實生活工作室', 'COFjRj1H61v', '1619348965', 'Miaoli', 0, 1),
(227, '橙香森林', 'COFjOs8HctZ', '1619348942', 'Miaoli', 0, 1),
(228, 'Route 3 三號公路', 'COFiwR6DTW8', '1619348693', 'Miaoli', 0, 1),
(229, '鹿角Café', 'COFewQXL4--', '1619346595', 'Miaoli', 0, 1),
(230, '鹿角Café', 'COFcbaOjk-Y', '1619345376', 'Miaoli', 0, 1),
(231, '苗栗 南庄', 'COFcbAds-PG', '1619345373', 'Miaoli', 0, 1),
(232, '勤美學 CMP Village', 'COFcTiinY8t', '1619345312', 'Miaoli', 0, 1),
(233, '好客公園', 'COFcOU1sIVr', '1619345269', 'Miaoli', 0, 1),
(234, 'Route 3 三號公路', 'COFblTcH1WG', '1619344933', 'Miaoli', 0, 1),
(235, '愛露營 山視界露營區', 'COFbHl5sDyT', '1619344689', 'Miaoli', 0, 1),
(236, '花露農場 FlowerHome', 'COFZ-ijHH0L', '1619344091', 'Miaoli', 0, 1),
(237, '崎頂車站', 'COFT-tuniC1', '1619340947', 'Miaoli', 0, 1),
(238, '勝興車站', 'COFTQ4ynwVZ', '1619340571', 'Miaoli', 0, 1),
(239, '花露農場 FlowerHome', 'COCaJJ_sHLg', '1619243515', 'Miaoli', 0, 1),
(240, '蓁愛產後護理之家', 'COCRxeGhxvU', '1619239126', 'Miaoli', 0, 1),
(241, '魚藤坪斷橋', 'CN7nu8hs-BZ', '1619015759', 'Miaoli', 0, 1),
(242, '苗栗', 'CMMkAiggrnI', '1615289264}]', 'Miaoli', 0, 1),
(243, 'Taiwan', 'COLStw7LoVV', '1619541610', 'Taichung', 0, 1),
(244, '旅禾 泡芙之家 審計旗艦店', 'COLSmgUhEZ1', '1619541551', 'Taichung', 0, 1),
(245, '欣欣乾洗廠', 'COLSktNnDdN', '1619541536', 'Taichung', 0, 1),
(246, 'Taiwan', 'COLSUusr_c4', '1619541405', 'Taichung', 0, 1),
(248, '台中文學館 Taichung Literature Pavilion', 'COLRCdEBR-F', '1619540731', 'Taichung', 0, 1),
(249, '實心裡  生活什物店', 'COLQoo6HQaY', '1619540520', 'Taichung', 0, 1),
(250, '金色三麥 台中勤美店', 'COLQPocnNN0', '1619540315', 'Taichung', 0, 1),
(251, '清泉崗空軍基地', 'COLQOkHBrVJ', '1619540306', 'Taichung', 0, 1),
(252, '中央公園', 'COLQJJ5p75_', '1619540262', 'Taichung', 0, 1),
(253, 'Smile Cøffee 憲賣-北歐丹麥咖啡吧', 'COLPSekpp2q', '1619539814', 'Taichung', 0, 1),
(254, '大坑新桃花源橋', 'COLO0cCnT0I', '1619539568', 'Taichung', 0, 1),
(255, 'Citrus Pâtisserie Boulangerie 蜜柑。法式甜點。麵包。', 'COLOzw5gAHL', '1619539562', 'Taichung', 0, 1),
(256, 'Draft Land 慢閃店', 'COLOlznpn8w', '1619539462', 'Taichung', 0, 1),
(257, '東海大學 Tunghai University', 'COLOar5sylQ', '1619539357', 'Taichung', 0, 1),
(258, '台中浩天宮大庄媽', 'COLOVbPspoy', '1619539314', 'Taichung', 0, 1),
(259, '恆日 - 1989 .', 'COLOLweB8Pt', '1619539234', 'Taichung', 0, 1),
(260, '春山相館id photo&amp; Dessert 證件照/台中證件照/大頭照/專業形象照', 'COLOH1GHYbk', '1619539202', 'Taichung', 0, 1),
(261, 'Draft Land 慢閃店', 'COLNwUPpE4b', '1619539061', 'Taichung', 0, 1),
(262, '台中健身房 北區中清店 Souls Fitness覺醒健身俱樂部', 'COLNwnwn8ot', '1619539012', 'Taichung', 0, 1),
(263, '五峰旗風景區', 'COLNH88gbmg', '1619538701', 'Taichung', 0, 1),
(264, '五峰旗風景區', 'COLNEGwgK5_', '1619538666', 'Taichung', 0, 1),
(265, '范特喜_綠光計畫（Fantasystory_Green Ray)', 'COLNC5hJKp4', '1619538637', 'Taichung', 0, 1),
(266, '早彎', 'COLM-_xHqQM', '1619538606', 'Taichung', 0, 1),
(267, 'Taichung, Taiwan', 'COLM3G4jgr4', '1619538541', 'Taichung', 0, 1),
(268, '歷史建築帝國製糖廠臺中營業所', 'COLMuGpHMq2', '1619538467', 'Taichung', 0, 1),
(269, 'Draft Land 慢閃店', 'COLMdn2J9vh', '1619538422', 'Taichung', 0, 1),
(270, 'DRINKTOPIA', 'COLMVozHhBb', '1619538267', 'Taichung', 0, 1),
(272, '舊社咖啡     Good Shot Cafe', 'COLMPcJDZ0v', '1619538216', 'Taichung', 0, 1),
(273, '中央公園 Taichung Central Park', 'COLLyZor1s_', '1619537978', 'Taichung', 0, 1),
(274, 'Taichung', 'COLLwhTHjdP', '1619537963', 'Taichung', 0, 1),
(275, 'Taichung', 'COLLhU6nUVn', '1619537838', 'Taichung', 0, 1),
(276, '台中文學館 Taichung Literature Pavilion', 'COLLfFYnlt_', '1619537820', 'Taichung', 0, 1),
(277, 'Taichung', 'COLLW08nJvq', '1619537752', 'Taichung', 0, 1),
(278, '馬稜溫泉', 'COLLUhWBIe6', '1619537733', 'Taichung', 0, 1),
(279, 'Taichung', 'COLLOI7nOQf', '1619537681', 'Taichung', 0, 1),
(280, '餐與生活', 'COLLNENnE64', '1619537672', 'Taichung', 0, 1),
(281, 'Taichung', 'COLLCA3HMWj', '1619537582', 'Taichung', 0, 1),
(282, 'Bullpen tattoo 牛棚紋身', 'COLK7uinGN9', '1619537530', 'Taichung', 0, 1),
(283, '中央公園 Taichung Central Park', 'COIiegBjdP6', '1619449210', 'Taichung', 0, 1),
(284, '初咖啡The Origin Coffee Roaster in Shalu', 'CLO_qOqHruC', '1613223386', 'Taichung', 0, 1),
(285, '臺中國家歌劇院 National Taichung Theater', 'CI8YQOWDSWO', '1608303779', 'Taichung', 0, 1),
(286, 'Bun Bun 棒棒', 'CIivBXTj-QE', '1607443301', 'Taichung', 0, 1),
(287, 'Bun Bun 棒棒', 'CITLScFj6wu', '1606921250', 'Taichung', 0, 1),
(288, '楽珈 Coffee Roaster', 'CEV9E48nQyp', '1598424527', 'Taichung', 0, 1),
(289, 'Taichung, Taiwan', 'CBaL2U_n156', '1592124039', 'Taichung', 0, 1),
(290, 'Taichung, Taiwan', 'CBSa_NkHcNi', '1591863541', 'Taichung', 0, 1),
(291, 'Taichung, Taiwan', 'CBQOd04nlS_', '1591789867}]', 'Taichung', 0, 1),
(292, '彰化', 'CONmmrJDmZh', '1619619147', 'Changhua', 0, 1),
(293, '隱鍋 彰化中正店', 'CONmannsrve', '1619619048', 'Changhua', 0, 1),
(294, '彰化車站', 'CONmFOOMzJ5', '1619618873', 'Changhua', 0, 1),
(295, '大甲鎮瀾宮', 'CONkWASnS21', '1619617961', 'Changhua', 0, 1),
(296, '小原婚宴會館', 'CONisO1FPO6', '1619617095', 'Changhua', 0, 1),
(297, '田中', 'CONbXlXnX_w', '1619613256', 'Changhua', 0, 1),
(298, '一緒哥 巴哈 Uisge Beatha', 'CONbP79JAxH', '1619613193', 'Changhua', 0, 1),
(299, '田尾公路花園', 'CONXBrfnRAH', '1619610979', 'Changhua', 0, 1),
(300, '田尾公路花園', 'CONW4SAnY1G', '1619610902', 'Changhua', 0, 1),
(301, '貳拾捌 28 Nails', 'CONWjogrA5Q', '1619610733', 'Changhua', 0, 1),
(302, '艾波廚房-彰化站前店', 'CONUIM2Hh5d', '1619609460', 'Changhua', 0, 1),
(303, '金水咖啡 Jin Shui Cafe', 'CONTPPNDTyD', '1619608993', 'Changhua', 0, 1),
(304, '溪湖糖廠', 'CONM1Amj-7g', '1619605633', 'Changhua', 0, 1),
(305, '玻璃媽祖廟', 'CONMa_3D_QU', '1619605419', 'Changhua', 0, 1),
(306, '彰化', 'CONLxPCnQod', '1619605077', 'Changhua', 0, 1),
(307, '員林西區運動公園', 'CONK4L3HMTz', '1619604610', 'Changhua', 0, 1),
(308, 'Butter 巴特手作晨食 Brunch&amp;cafe', 'CONIs5dnhCh', '1619603469', 'Changhua', 0, 1),
(309, '臺中市四張犁三官堂', 'CONIiz0sGr7', '1619603386', 'Changhua', 0, 1),
(310, '有片森林「植一座咖啡館」', 'CONIK13jLsl', '1619603190', 'Changhua', 0, 1),
(311, '春日指彩 Spring Daily Nails', 'CONGYfFr2Zg', '1619602253', 'Changhua', 0, 1),
(312, '彰化市．Changhua City', 'CONDEwJnu_a', '1619600524', 'Changhua', 0, 1),
(313, 'Loyalty Select Shop', 'COM7ITwHKto', '1619596353', 'Changhua', 0, 1),
(314, 'Goodnight 晚安,美學 - 社頭店', 'COM6QQDJVdY', '1619595894', 'Changhua', 0, 1),
(315, 'Goodnight 晚安,美學 - 員林店', 'COM6PeXJ9rM', '1619595888', 'Changhua', 0, 1),
(316, 'Goodnight 晚安,美學 - 社頭店', 'COM6N15pGRo', '1619595875', 'Changhua', 0, 1),
(317, '西螺大橋', 'COM5du0s__z', '1619595480', 'Changhua', 0, 1),
(318, '大嫂的奶x有毒-彰化店', 'COM4oY7rBBi', '1619595043', 'Changhua', 0, 1),
(319, '藝寶窗花門板', 'COM3NQXn7G-', '1619594297', 'Changhua', 0, 1),
(320, '野花小姐', 'COMy5sPAlHa', '1619592039', 'Changhua', 0, 1),
(321, '凡果 x NailArt', 'COMuFiPJ0Ks', '1619589515', 'Changhua', 0, 1),
(322, '田中', 'COIaVLznZ9n', '1619444940', 'Changhua', 0, 1),
(323, '陽光老店爌肉飯', 'COC68-unrel', '1619260716', 'Changhua', 0, 1),
(324, '明明bakery', 'CN4w4OfDWuV', '1618919890', 'Changhua', 0, 1),
(325, '成美文化園', 'CNZ7p0ipXqL', '1617885352}]', 'Changhua', 0, 1),
(326, '農家樂露營區', 'CON4VWqHW8a', '1619628442', 'Nantou', 0, 1),
(327, '農家樂露營區', 'CON4RqhHjU7', '1619628412', 'Nantou', 0, 1),
(328, '農家樂露營區', 'CON4NKxnNF-', '1619628375', 'Nantou', 0, 1),
(329, '南投埔里寶湖宮天地堂地母廟', 'CON3D4tLx2y', '1619627775', 'Nantou', 0, 1),
(330, '星月天空景觀餐廳', 'CONzVFJgTdC', '1619625818', 'Nantou', 0, 1),
(331, '郡大山', 'CONtXHbH9d5', '1619622689', 'Nantou', 0, 1),
(332, '清境農場 Qingjing Farm', 'CONs0PELFyb', '1619622403', 'Nantou', 0, 1),
(333, '埔里內埔飛場', 'CONqiLHn4O8', '1619621207', 'Nantou', 0, 1),
(334, '台電雲海保綫所（海拔2360公尺）', 'CONqJ0enCY_', '1619621007', 'Nantou', 0, 1),
(335, '雲品溫泉酒店日月潭Fleur de Chine Hotel', 'CONpqRoHXyp', '1619620749', 'Nantou', 0, 1),
(336, '老英格蘭莊園', 'CONpbUwHypu', '1619620627', 'Nantou', 0, 1),
(337, 'Shenzhen, Guangdong', 'CONoebOFVCI', '1619620128', 'Nantou', 0, 1),
(338, '日月潭大淶閣飯店', 'CONk4peh76f', '1619618245', 'Nantou', 0, 1),
(339, '妖怪村', 'CONkiPXgUVr', '1619618062', 'Nantou', 0, 1),
(340, '台灣最美/最高的公路-台14甲', 'CONkTeZpQys', '1619617941', 'Nantou', 0, 1),
(341, '奧萬大國家森林遊樂區', 'CONkI3dhzqf', '1619617854', 'Nantou', 0, 1),
(342, '蜜仔琉部', 'CONjcEInGtm', '1619617487', 'Nantou', 0, 1),
(343, '畢瓦客Biwak', 'CONjSN8Hk7k', '1619617406', 'Nantou', 0, 1),
(344, '日月老茶廠', 'CONg9dAsy_J', '1619616187', 'Nantou', 0, 1),
(345, '盒木；Hermon', 'CONgZRYnzAN', '1619615891', 'Nantou', 0, 1),
(346, 'Take Me Away帶我走 甜點工作室', 'CONgXFfHTxF', '1619615873', 'Nantou', 0, 1),
(347, '塔加加夫妻樹', 'CONf1f7HI8e', '1619615598', 'Nantou', 0, 1),
(348, '鹿篙咖啡莊園', 'CONeWBFBZ93', '1619614816', 'Nantou', 0, 1),
(349, '觀音亭彩虹橋', 'CONbMy7nZFs', '1619613167', 'Nantou', 0, 1),
(350, '日月潭浪人槳堂SUP教學體驗中心', 'CONZ4UvJOB1', '1619612576', 'Nantou', 0, 1),
(351, '大竹湖步道', 'CONYPnAHHjN', '1619611618', 'Nantou', 0, 1),
(352, '南投埔里寶湖宮天地堂地母廟', 'CONWrdaAb4e', '1619610797', 'Nantou', 0, 1),
(353, 'Desolatecoffee/蠻荒咖啡', 'CONV782DN1f', '1619610408', 'Nantou', 0, 1),
(354, '奧萬大國家森林遊樂區', 'CONVnuRHmsA', '1619610242', 'Nantou', 0, 1),
(355, '南投埔里寶湖宮天地堂地母廟', 'CONVTiGMQNs', '1619610077', 'Nantou', 0, 1),
(356, '中興新村[光明里]', 'CONU9uYnE9j', '1619609898', 'Nantou', 0, 1),
(357, '中興新村[光明里]', 'CONUnQhnbof', '1619609714', 'Nantou', 0, 1),
(358, '中興新村光明三路石斛蘭大道', 'CONT-vSntbh', '1619609382', 'Nantou', 0, 1),
(359, '星月天空景觀餐廳', 'CONTdkdH2G2', '1619609111', 'Nantou', 0, 1),
(360, '多肉秘境', 'CONQUrEDwuV', '1619607465', 'Nantou', 0, 1),
(361, '鹿篙咖啡莊園', 'CONNtiFnMXK', '1619606096', 'Nantou', 0, 1),
(362, '明新書院-三級古蹟', 'CONNBl2HBZu', '1619605736', 'Nantou', 0, 1),
(363, '佛羅倫斯渡假山莊Florence Resort Villa', 'CONM-1Dn5FH', '1619605713', 'Nantou', 0, 1),
(364, '九族文化村 Formosan Aboriginal Culture Village', 'CONLSxuHDPn', '1619604828', 'Nantou', 0, 1),
(365, 'Take Me Away帶我走 甜點工作室', 'CONJDa5n4LV', '1619603653', 'Nantou', 0, 1),
(366, 'Sun Moon Lake日月潭', 'COGswCmholk', '1619387488', 'Nantou', 0, 1),
(367, '合歡山', 'CNho4VbpKi7', '1618143945', 'Nantou', 0, 1),
(368, '竹山紫南宮', 'CLYAGDLjxfC', '1613525604', 'Nantou', 0, 1),
(369, '烏松崙森林渡假營【石家梅園】', 'CKy3bB5DtJG', '1612279544', 'Nantou', 0, 1),
(370, '烏松崙森林渡假營【石家梅園】', 'CKu6j72jaV_', '1612146972', 'Nantou', 0, 1),
(371, '烏松崙森林渡假營【石家梅園】', 'CKoDp0wjHyE', '1611916857}]', 'Nantou', 0, 1),
(372, 'Kebagusan, Pasar Minggu, Jakarta Selatan', 'COX_ttiBAZ1', '1619967856', 'Yunlin', 0, 1),
(373, '千巧谷牛樂園牧場', 'COX-3jbrDCG', '1619967412', 'Yunlin', 0, 1),
(374, '國立雲林科技大學YunTech', 'COX-fCUHQCz', '1619967211', 'Yunlin', 0, 1),
(375, '竽芯園庭園美食屋 雲林縣古坑鄉', 'COX-Ps1H5dV', '1619967086', 'Yunlin', 0, 1),
(376, '成龍集會所', 'COX-Ginn2gb', '1619967011', 'Yunlin', 0, 1),
(377, 'Yünlin, Taiwan', 'COX8bKHJNv8', '1619966131', 'Yunlin', 0, 1),
(378, '北港觀光大橋 Beigang Tourist Bridge', 'COX8VHbDlla', '1619966081', 'Yunlin', 0, 1),
(379, '北港朝天宮', 'COX7wGnnV99', '1619965778', 'Yunlin', 0, 1),
(380, 'Yünlin, Taiwan', 'COX5LZGJWm3', '1619964429', 'Yunlin', 0, 1),
(381, '雲林斗六火車站', 'COX5HHeHiZA', '1619964394', 'Yunlin', 0, 1),
(382, '命中注定Brunch早午餐', 'COXzIkjDIcJ', '1619961260', 'Yunlin', 0, 1),
(383, '北港朝天宮', 'COXxr_vshpm', '1619960502', 'Yunlin', 0, 1),
(384, '北港朝天宮', 'COXsl0pjhec', '1619957830', 'Yunlin', 0, 1),
(385, '桃花源餐廳 斗六店', 'COXr8s5lCpY', '1619957493', 'Yunlin', 0, 1),
(386, '獨角仙休閒農場', 'COXqtvVntbA', '1619956846', 'Yunlin', 0, 1),
(387, '北港朝天宮', 'COXpKxTMNdG', '1619956035', 'Yunlin', 0, 1),
(388, '雲林斗六火車站', 'COXn27DLC-U', '1619955348', 'Yunlin', 0, 1),
(389, 'Kaohsiung, Taiwan', 'COXlrFVDq70', '1619954203', 'Yunlin', 0, 1),
(390, '西螺大橋', 'COXkzDPHvaR', '1619953744', 'Yunlin', 0, 1),
(391, '北港朝天宮', 'COXi-r5sCU9', '1619952790', 'Yunlin', 0, 1),
(392, '華山1914文化創意產業園區', 'COXhSkThD49', '1619951918', 'Yunlin', 0, 1),
(393, '北港朝天宮', 'COXgjoPLlLl', '1619951520', 'Yunlin', 0, 1),
(394, '三秀園', 'COXWRpppLGs', '1619946130', 'Yunlin', 0, 1),
(395, '七の一手作食堂', 'COXVsyRjPnG', '1619945828', 'Yunlin', 0, 1),
(396, '午光紅茶Brunch X 午光食舍', 'COXUUSbsDwy', '1619945103', 'Yunlin', 0, 1),
(397, '虎尾-阿爸的花生糖', 'COXTpLJFgBC', '1619944750', 'Yunlin', 0, 1),
(398, '泰Pan - 泰式小吃', 'COXTRgZlpuu', '1619944556', 'Yunlin', 0, 1),
(399, '木子木子', 'COXSAoVJ2UP', '1619943894', 'Yunlin', 0, 1),
(400, 'Yünlin, Taiwan', 'COXP4D5H44u', '1619942775', 'Yunlin', 0, 1),
(401, '宜梧蚵嗲', 'COXOb9_gvKz', '1619942084', 'Yunlin', 0, 1),
(402, '虎尾鐵橋', 'COXOWKDMcqg', '1619941973', 'Yunlin', 0, 1),
(403, '澄霖沉香味道森林館', 'COXKQ8ZHWHD', '1619939833', 'Yunlin', 0, 1),
(404, '女兒橋', 'COXKMxGHeU9', '1619939799', 'Yunlin', 0, 1),
(405, '北港朝天宮', 'COXEFN8JkPE', '1619936591', 'Yunlin', 0, 1),
(406, '雲林四湖參天宮關聖帝君', 'COXDqxyH7e-', '1619936374', 'Yunlin', 0, 1),
(407, '北港朝天宮', 'COXCrDKsvkp', '1619935852', 'Yunlin', 0, 1),
(408, '飛樂尼斯舞蹈工作室-虎尾', 'COW_0jFDn3u', '1619934357', 'Yunlin', 0, 1),
(409, '走馬瀨農場', 'COW-9REh6tx', '1619933904', 'Yunlin', 0, 1),
(410, '走馬瀨農場', 'COW-55vBJQB', '1619933877', 'Yunlin', 0, 1),
(411, '走馬瀨農場', 'COW-zRFhssJ', '1619933823', 'Yunlin', 0, 1),
(412, '馬蹄蛤主題館', 'COW9gJds9gL', '1619933142', 'Yunlin', 0, 1),
(413, '千巧谷牛樂園牧場', 'COW7yIHnB-s', '1619932240', 'Yunlin', 0, 1),
(414, '虎尾-阿爸的花生糖', 'COW3nA0FZT0', '1619930052', 'Yunlin', 0, 1),
(415, 'CHICO 餐廚', 'COWz6sDHz9E', '1619928116', 'Yunlin', 0, 1),
(416, 'Yünlin, Taiwan', 'COWopezJqqA', '1619922208', 'Yunlin', 0, 1),
(417, '馬蹄蛤主題館', 'COWlUQBM1W_', '1619920461', 'Yunlin', 0, 1),
(418, '北港朝天宮', 'COWchKvDgU5', '1619915849', 'Yunlin', 0, 1),
(419, '北港朝天宮', 'COWLYWzsIkL', '1619906863', 'Yunlin', 0, 1),
(420, '北港朝天宮', 'COWGj2-MCDy', '1619904336', 'Yunlin', 0, 1),
(421, '嘉義觀止Hotel', 'COVroWoFq1a', '1619890217', 'Yunlin', 0, 1),
(422, '北港朝天宮', 'COVckN4slf4', '1619882319', 'Yunlin', 0, 1),
(423, '虎尾鐵橋', 'COVaM6Vn3ww', '1619881080', 'Yunlin', 0, 1),
(424, '北港鎮', 'COVaD99LuMB', '1619881006', 'Yunlin', 0, 1),
(425, '斗六門受天宮', 'COVWiJJlFbe', '1619879156', 'Yunlin', 0, 1),
(426, '北港朝天宮', 'COVWSK7MXcO', '1619879026', 'Yunlin', 0, 1),
(427, '澄霖沉香味道森林館', 'CORs2GDFECo', '1619756636}]', 'Yunlin', 0, 1),
(428, '基隆東岸廣場Esquare', 'COY5iMRDNao', '1619998170', 'keelung', 0, 1),
(429, '八斗子海岸秘徑 - 大坪海岸-潮間帶', 'COY3KJwHjgu', '1619997155', 'keelung', 0, 1),
(430, 'Keelung City Taiwan R.O.C', 'COYiN6tgaDT', '1619985945', 'keelung', 0, 1),
(431, '唉喲唉喲一喲一唷唉喲', 'COYbrWjFSga', '1619982517', 'keelung', 0, 1),
(433, '老鷹岩', 'COYGDFynbC4', '1619971177}]', 'keelung', 0, 1);

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
('amigo', '1qaz@WSX', 'amigo', 'amigo1998928@gmail.com', 'wlCCtnaGDxUCZcA0U4AxOCAvgXXqLrW6', NULL, '', 2),
('chinyu', '1qaz@WSX', 'chinyu', 'amigo1998928@gmail.com', 'U2b4Eln5E1jUMsNer5phbPQtBUTywrCs', NULL, '', 1),
('sheng', '1qaz@WSX', 'sheng', 'fosilaoshiji@protonmail.com', 'ivShcAVnNtctEFxni5qIQ3B9CMMzIMv5', NULL, '', 2),
('wanting', '1qaz@WSX', 'wanting', 'ysl58200@gmail.com', '7chJ2yIYfvfMnxebCuArNsauRYRVeiRt', NULL, '', 2);

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
  MODIFY `itinerary_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `share`
--
ALTER TABLE `share`
  MODIFY `share_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sight`
--
ALTER TABLE `sight`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=434;

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
