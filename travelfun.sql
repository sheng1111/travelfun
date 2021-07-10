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
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員',
  `view_id` int(11) NOT NULL COMMENT '景點編號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='收藏';

--
-- 傾印資料表的資料 `favorites`
--

INSERT INTO `favorites` (`user_id`, `view_id`) VALUES
('sheng', 1),
('sheng', 2),
('sheng', 74),
('sheng', 75),
('sheng', 80),
('sheng', 81),
('sheng', 87),
('wanting', 94),
('chinyu', 286),
('chinyu', 287),
('chinyu', 289),
('chinyu', 291),
('chinyu', 294),
('sheng', 419),
('wanting', 419),
('wanting', 420),
('wanting', 421),
('wanting', 424);

-- --------------------------------------------------------

--
-- 資料表結構 `friend`
--

CREATE TABLE `friend` (
  `friend_id` int(10) NOT NULL COMMENT '好友編號',
  `oneself` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '自己(帳號)',
  `others` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '他人(帳號)',
  `status` int(1) DEFAULT NULL COMMENT '好友狀態'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='好友';

--
-- 傾印資料表的資料 `friend`
--

INSERT INTO `friend` (`friend_id`, `oneself`, `others`, `status`) VALUES
(1, 'sheng', 'amigo', 1),
(2, 'amigo', 'chinyu', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `itinerary`
--

CREATE TABLE `itinerary` (
  `itinerary_id` int(10) NOT NULL COMMENT '行程編號',
  `itinerary_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '行程名稱',
  `public_status` int(1) NOT NULL COMMENT '公開狀態',
  `itinerary_date` date NOT NULL COMMENT '開始日期',
  `itinerary_days` int(3) NOT NULL COMMENT '出遊天數',
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '作者'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='行程';

--
-- 傾印資料表的資料 `itinerary`
--

INSERT INTO `itinerary` (`itinerary_id`, `itinerary_name`, `public_status`, `itinerary_date`, `itinerary_days`, `user_id`) VALUES
(1, '台北', 2, '2021-04-13', 3, 'amigo'),
(2, '基隆', 1, '2021-05-08', 2, 'wanting'),
(3, '彰化一日遊', 1, '2021-05-15', 1, 'chinyu'),
(4, '基隆出去玩', 1, '2021-05-15', 2, 'sheng');

-- --------------------------------------------------------

--
-- 資料表結構 `sequence`
--

CREATE TABLE `sequence` (
  `sequence_id` int(11) NOT NULL COMMENT '順序編號',
  `itinerary_id` int(10) NOT NULL COMMENT '(隸屬)行程編號',
  `view_id` int(11) NOT NULL COMMENT '景點編號',
  `opt_day` int(3) NOT NULL COMMENT '出遊日',
  `sequence` int(10) DEFAULT NULL COMMENT '當天順序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='景點排序';

--
-- 傾印資料表的資料 `sequence`
--

INSERT INTO `sequence` (`sequence_id`, `itinerary_id`, `view_id`, `opt_day`, `sequence`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 3, 1, 2),
(3, 1, 4, 1, 4),
(4, 1, 8, 2, 1),
(5, 1, 9, 1, 3),
(6, 2, 94, 1, 1),
(7, 2, 419, 2, 1),
(8, 2, 420, 1, 2),
(9, 2, 421, 2, 2),
(10, 2, 424, 1, 3),
(11, 3, 286, 1, 1),
(12, 3, 287, 1, 2),
(13, 3, 289, 1, 4),
(14, 3, 291, 1, 5),
(15, 3, 294, 1, 6),
(16, 4, 75, 1, 1),
(17, 4, 80, 1, 2),
(18, 4, 81, 2, 1),
(19, 4, 87, 2, 2),
(20, 4, 419, 1, 3),
(21, 4, 76, 2, 3),
(22, 3, 293, 1, 3);

-- --------------------------------------------------------

--
-- 資料表結構 `share`
--

CREATE TABLE `share` (
  `share_id` int(10) NOT NULL COMMENT '共享編號',
  `itinerary_id` int(10) NOT NULL COMMENT '行程編號',
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '協作者'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='共筆作者';

--
-- 傾印資料表的資料 `share`
--

INSERT INTO `share` (`share_id`, `itinerary_id`, `user_id`) VALUES
(1, 1, 'sheng'),
(2, 4, 'amigo'),
(3, 2, 'sheng'),
(4, 4, 'wanting'),
(5, 3, 'amigo');

-- --------------------------------------------------------

--
-- 資料表結構 `sight`
--

CREATE TABLE `sight` (
  `view_id` int(11) NOT NULL COMMENT '景點編號',
  `view_name` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '景點名稱',
  `shortcode` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '貼文代碼(網址)',
  `timestamp` int(20) DEFAULT NULL COMMENT '貼文時間戳',
  `tag_area` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '貼文標籤',
  `source` int(3) NOT NULL COMMENT '來源',
  `status` int(1) DEFAULT NULL COMMENT '發佈狀態'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='景點';

--
-- 傾印資料表的資料 `sight`
--

INSERT INTO `sight` (`view_id`, `view_name`, `shortcode`, `timestamp`, `tag_area`, `source`, `status`) VALUES
(1, '三創生活園區 Clapper Studio', 'CITYm-FBImX', 1606928234, 'taipei', 0, 1),
(2, '板橋市政府 新北耶誕城', 'CITYW4ipHe4', 1606924800, 'taipei', 0, 1),
(3, 'COOL TOY 酷玩具', 'CITX8X2hg6B', 1606927885, 'taipei', 0, 1),
(4, '安慰劑 Placebo Taipei', 'CITXp3fgajs', 1606927733, 'taipei', 0, 1),
(5, 'Trio Cafe 三重奏 - 華山', 'CITXcCggsAw', 1606927620, 'taipei', 0, 1),
(6, '虎山峰觀景臺', 'CITXO2ch6OY', 1606927512, 'taipei', 0, 1),
(7, 'Modism Muses 繆斯餐酒館', 'CMJBFjyBVLY', 1615170292, 'taipei', 0, 1),
(8, 'Taipei, Taiwan', 'CMJA1EQHEIk', 1615170157, 'taipei', 0, 1),
(9, 'Taipei, Taiwan', 'CMJAskunSlT', 1615170087, 'taipei', 0, NULL),
(10, 'Missgreen', 'CMJAZk_MlVB', 1615169931, 'taipei', 0, 1),
(11, '有之和牛 鍋物放題', 'CMJAVFAnK-w', 1615169895, 'taipei', 0, 1),
(12, '象山', 'CMJAT4-HqRM', 1615169885, 'taipei', 0, 1),
(13, '信義區商圈', 'CMJAS4_hdDe', 1615169877, 'taipei', 0, 1),
(14, '三分半海鮮鍋物', 'CMI_MLIHtT9', 1615169297, 'taipei', 0, 1),
(15, '原岩攀岩館-萬華店 T-UP Climbing Wanhua', 'CMI_lPXj0Fa', 1615169503, 'taipei', 0, 1),
(16, '宏南中油宿舍', 'CMI_F56jxaI', 1615169246, 'taipei', 0, 1),
(17, 'Taipei, Taiwan', 'CMI_GtpnvXX', 1615169253, 'taipei', 0, NULL),
(18, '碧山巖櫻花隧道', 'CMI-QitjE-7', 1615168809, 'taipei', 0, 1),
(19, '家香味食堂', 'CMI-XP1B5-K', 1615168864, 'taipei', 0, 1),
(20, 'Pingtung County', 'CMI-K9sLVRb', 1615168763, 'taipei', 0, 1),
(21, '大鼎豬血湯', 'CMI-QdgH36F', 1615168808, 'taipei', 0, 1),
(22, 'Miacucina（My kitchen）復興店', 'CMI-ErTgBXX', 1615168712, 'taipei', 0, 1),
(23, 'Yellow Lemon', 'CMI-Hfnn99p', 1615168735, 'taipei', 0, 1),
(24, 'Busan, South Korea', 'CMI95K2FVrh', 1615168617, 'taipei', 0, 1),
(25, 'de nuit 法式餐廳', 'CMI-EcznkRf', 1615168710, 'taipei', 0, 1),
(26, 'Taipei', 'CMI7zW3F2Pu', 1615168394, 'taipei', 0, 1),
(27, 'Roffyscafe', 'CMI9qJTMD3B', 1615168494, 'taipei', 0, 1),
(28, 'Domani 義式餐廳', 'CMI9KMQHRt2', 1615168232, 'taipei', 0, 1),
(29, '日本美登利壽司（台灣）', 'CMI9RD_nZ1o', 1615168369, 'taipei', 0, 1),
(30, '二條通．綠島小夜曲', 'CMI8-z9HGYu', 1615168139, 'taipei', 0, 1),
(31, 'AROS Coffee', 'CMI9BNVhV1K', 1615168159, 'taipei', 0, 1),
(32, '九五峰山頂', 'CMHw0G6H6Fo', 1615128206, 'taipei', 0, 1),
(33, '財神爺魯肉飯', 'CMI81LonWZe', 1615168060, 'taipei', 0, 1),
(34, 'Taoyuan, Taiwan', 'CLPDU3LHR6e', 1613225309, 'taipei', 0, 1),
(35, 'Flux Réel Hair Boutique', 'CMEU5h8nUH4', 1615012907, 'taipei', 0, 1),
(36, '阿華炒麵', 'COYJz3gns-5', 1619973149, 'keelung', 0, 1),
(37, 'Ribeira Grande São Miguel', 'CFklTXHHemX', 1601062864, 'taipei', 0, 1),
(38, 'Panchiao', 'CM_CzkQBae7', 1616983132, 'taipei', 0, 1),
(39, '石梯坪', 'CM_CkLnnH42', 1616983006, 'taipei', 0, 1),
(40, '陽明山擎天崗', 'CM_ChhJDxm_', 1616982984, 'taipei', 0, 1),
(41, 'Taipei, Taiwan', 'CM_CbxsnUC2', 1616982937, 'taipei', 0, NULL),
(42, '沙崙海灘', 'CM_CVcXlqtF', 1616982885, 'taipei', 0, 1),
(43, '寧夏觀光夜市', 'CM_B9a2nG0x', 1616982689, 'taipei', 0, 1),
(44, 'Ms.艾瑪小姐 美甲/美睫/韓式半永久', 'CM_B9DtpVu6', 1616982686, 'taipei', 0, 1),
(45, 'Singkawang', 'CM_B5YLr8PU', 1616982655, 'taipei', 0, 1),
(46, '浮光書店', 'CM_B0HcjWkL', 1616982612, 'taipei', 0, 1),
(47, '西門町 Ximenting', 'CM_ByDvBqqn', 1616982596, 'taipei', 0, 1),
(48, '東咖啡 Dong Coffee Bar', 'CM_Brm_HH3i', 1616982543, 'taipei', 0, 1),
(49, '三芝區', 'CM_BSurp7SI', 1616982339, 'taipei', 0, 1),
(50, 'Taipei, Taiwan', 'CM_BQJinpIt', 1616982318, 'taipei', 0, NULL),
(51, 'Taipei, Taiwan', 'CM_A-AxBuG-', 1616982169, 'taipei', 0, NULL),
(52, 'Taipei, Taiwan', 'CM_AyPnHVWj', 1616982073, 'taipei', 0, NULL),
(53, '艾叻沙', 'CM_AYx5H8E2', 1616981864, 'taipei', 0, 1),
(54, '信義區商圈', 'CM-_WH7MMOU', 1616981318, 'taipei', 0, NULL),
(55, '茗香園冰室 - 大安店', 'CM_C4w6jHzo', 1616983175, 'taipei', 0, 1),
(56, '鶯歌陶瓷博物館', 'CM-_JJ9shUr', 1616981212, 'taipei', 0, 1),
(57, 'Din Tai Fung Taipei 101', 'CLwjXTFhbLI', 1614349402, 'taipei', 0, 1),
(58, 'Bobo nail Studio 美甲工作室 基隆七堵百福五堵汐止凝膠美甲', 'CM_I9Qfjp0G', 1616986357, 'keelung', 0, 1),
(59, '萬祝號', 'CM_NMwMHsU2', 1616988581, 'keelung', 0, 1),
(60, '延平街口傳統早餐店', 'CM_HA9ThkVr', 1616985339, 'keelung', 0, 1),
(61, 'Keelung, Taiwan', 'CM-6BSMDgiX', 1616978526, 'keelung', 0, 1),
(62, '夏朵義式咖啡cafe chateau', 'CM-56XlnJz7', 1616978469, 'keelung', 0, 1),
(63, '義美自助火鍋城', 'CM_IAzdDRvu', 1616985862, 'keelung', 0, 1),
(64, '基隆港 Keelung Harbor', 'CM-34EmhXUO', 1616977402, 'keelung', 0, 1),
(65, '汐止區', 'CM-wmBunUOc', 1616973584, 'keelung', 0, 1),
(66, 'Taipe 101', 'CM-_RVrHtUO', 1616981279, 'taipei', 0, 1),
(67, '基隆嶼燈塔', 'CM-MdcUMXis', 1616954639, 'keelung', 0, 1),
(68, '基隆嶼', 'CM-JgszMqU0', 1616953093, 'keelung', 0, 1),
(69, '容軒步道', 'CM-5zoEr7YN', 1616978414, 'keelung', 0, 1),
(70, 'Keelung', 'CM-E87bnEgv', 1616950703, 'keelung', 0, 1),
(71, '十一指古道', 'COF7sV1hxhv', 1619361768, 'Taoyuan', 0, 1),
(72, '八番居酒屋', 'COF7pDnAW6F', 1619361741, 'Taoyuan', 0, 1),
(73, '癮食聖堂 Poppy Church', 'COF7iruJrCu', 1619361689, 'Taoyuan', 0, 1),
(74, '正濱漁港', 'CM_ODuDDRSt', 1616989032, 'keelung', 0, 1),
(75, '基隆仙洞巖', 'CM_NDUnjmoN', 1616988504, 'keelung', 0, 1),
(76, 'Mr.uncle - 大叔先生', 'CM_K8cNDuES', 1616987399, 'keelung', 0, 1),
(77, '汴洲公園', 'COF59rRAfd4', 1619360987, 'Taoyuan', 0, 1),
(78, '桃園大溪笠復威斯汀度假酒店 The Westin Tashee Resort, Taoyu', 'COF6BuLha8X', 1619360894, 'Taoyuan', 0, 1),
(79, '白千層綠色隧道', 'COF4W2Xh9cr', 1619360019, 'Taoyuan', 0, 1),
(80, '容軒步道', 'CM_EUyvLPMu', 1616983929, 'keelung', 0, NULL),
(81, '基隆港 - 海洋廣場', 'CM_AsDIDPet', 1616982022, 'keelung', 0, 1),
(82, 'Mitsui Outlet Park 林口', 'COF64xYjRU-', 1619361345, 'Taoyuan', 0, 1),
(83, 'Daisy cafe', 'COF6vu-AbQd', 1619361271, 'Taoyuan', 0, 1),
(84, '中山陸橋', 'CM-GlVgDYqc', 1616951558, 'keelung', 0, 1),
(85, 'Xpark水族館', 'COF1gntBEzY', 1619358526, 'Taoyuan', 0, 1),
(86, 'Taiwan', 'CM-E1E6nnVv', 1616950639, 'keelung', 0, 1),
(87, '正豐鵝肉老店', 'CM-O0JRMCZ4', 1616955874, 'keelung', 0, 1),
(88, '基隆嶼', 'CM-OOAdMm8h', 1616955562, 'keelung', 0, NULL),
(89, 'Hsin 美學', 'COF2NKhAD1j', 1619358891, 'Taoyuan', 0, 1),
(90, '台茂購物中心 TaiMall Shopping Center', 'COF2EYkpWGR', 1619358819, 'Taoyuan', 0, 1),
(91, '陪你去流浪', 'COF7cCvhDqW', 1619361634, 'Taoyuan', 0, 1),
(92, '桃園巨蛋體育館', 'COF656_FZpV', 1619361355, 'Taoyuan', 0, 1),
(93, '桃園市立大溪木藝生態博物館', 'COFzr-QLKnh', 1619357570, 'Taoyuan', 0, 1),
(94, 'LOKA CAFE', 'CM-A43oFTHh', 1616948573, 'keelung', 0, 1),
(95, '東眼山國家森林遊樂區森林浴場', 'COF0q4Ujxcm', 1619358086, 'Taoyuan', 0, 1),
(96, 'Abbraccio 抱抱義大利', 'COF0NvxHuSi', 1619357847, 'Taoyuan', 0, 1),
(97, '東眼山國家森林遊樂區森林浴場', 'COF0D4CjM0-', 1619357766, 'Taoyuan', 0, NULL),
(98, 'The Good One Coffee Roaster', 'COF342yn6bP', 1619359773, 'Taoyuan', 0, 1),
(99, '石門水庫坪林收費站', 'COF3AU6LktY', 1619359310, 'Taoyuan', 0, 1),
(100, '路伊Salon-美髮/美甲/霧眉/熱蠟美肌', 'COFwhNAhTeB', 1619355909, 'Taoyuan', 0, 1),
(101, 'GLORIA OUTLETS 華泰名品城', 'COFzYn1HCz3', 1619357412, 'Taoyuan', 0, 1),
(102, 'Taoyuan, Taiwan', 'COFywn-sDjB', 1619357084, 'Taoyuan', 0, NULL),
(103, '友竹居茶藝館', 'COFyt6enDJv', 1619357062, 'Taoyuan', 0, 1),
(104, '華泰名品城', 'COFylNvHBFP', 1619356991, 'Taoyuan', 0, 1),
(105, '阿蕊姨米干', 'COF06cnsIdc', 1619358213, 'Taoyuan', 0, 1),
(106, '蛋寶生技不老村', 'COFtCMKJJKq', 1619354082, 'Taoyuan', 0, 1),
(107, '甘家堡 桐花林', 'COFsqDUg8Hb', 1619353885, 'Taoyuan', 0, 1),
(108, 'Maison_406', 'COFwJhip9v1', 1619355715, 'Taoyuan', 0, 1),
(109, 'Hakkafe’哈嘎廢', 'COF1tC_MyzO', 1619358628, 'Taoyuan', 0, 1),
(110, '埔心牧場', 'COFuzInDX-X', 1619355008, 'Taoyuan', 0, 1),
(111, 'Friend In Cafe', 'COF1Rl7nDlz', 1619358403, 'Taoyuan', 0, 1),
(112, '怎麻辣', 'COFpTFEAvnA', 1619352124, 'Taoyuan', 0, 1),
(113, '桃園大溪笠復威斯汀度假酒店 The Westin Tashee Resort, Taoyu', 'COFngW0hnTn', 1619351184, 'Taoyuan', 0, NULL),
(114, 'New Taipei City', 'COFm_7YAxYN', 1619350918, 'Taoyuan', 0, 1),
(115, '桃園國際機場 Taoyuan International Airport', 'COFsYoxAYmT', 1619353742, 'Taoyuan', 0, 1),
(116, '桃園機場第二航廈', 'COFz9A8B3eP', 1619357710, 'Taoyuan', 0, 1),
(117, '新屋綠色走廊', 'COFz5VoMj1X', 1619357680, 'Taoyuan', 0, 1),
(118, '南崁', 'COFpZ6Rjzf-', 1619352179, 'Taoyuan', 0, 1),
(119, '塔那咖啡', 'COFPIfMrJ0-', 1619338405, 'Taoyuan', 0, 1),
(120, '國旗屋雲南米線、米干', 'COFvum0nF4m', 1619355495, 'Taoyuan', 0, 1),
(121, '台灣高鐵桃園站 THSR Taoyuan Station', 'CODDm5KAgCv', 1619265254, 'Taoyuan', 0, 1),
(122, '甘家堡 桐花林', 'COFmQbyBjfy', 1619350529, 'Taoyuan', 0, NULL),
(123, '石門水庫坪林收費站', 'COFyc0lF4Y1', 1619356922, 'Taoyuan', 0, NULL),
(124, '桃園忠烈祠暨神社文化園區', 'COFyV8BM_9e', 1619356866, 'Taoyuan', 0, 1),
(125, '麵屋一人', 'COFfTh5AES7', 1619346884, 'Taoyuan', 0, 1),
(126, '新竹市鐵道藝術村', 'COGIvxHnz67', 1619368611, 'Hsinchu', 0, 1),
(127, 'MEET NIGHT CLUB', 'COFqEbPgySz', 1619352528, 'Taoyuan', 0, 1),
(128, '新屋綠色隧道「濱海自行車道」', 'COFpaa3F_F3', 1619352184, 'Taoyuan', 0, 1),
(129, '福勝亭‧Tonkatsu', 'COFt545g6g1', 1619354539, 'Taoyuan', 0, 1),
(130, '甘家堡 桐花林', 'COFtC-IAHX4', 1619354089, 'Taoyuan', 0, NULL),
(131, 'Hsinchu, Taiwan', 'COGQcrkLG6D', 1619372649, 'Hsinchu', 0, 1),
(132, '新竹火車站hsinchu Train Station', 'COGKxQ7hWer', 1619369672, 'Hsinchu', 0, 1),
(133, 'Hsinchu, Taiwan', 'COGBcHRhAq9', 1619364780, 'Hsinchu', 0, NULL),
(134, '桃園77藝文町', 'COFlr1JHIlw', 1619350229, 'Taoyuan', 0, 1),
(135, '綠島', 'COFle65leTv', 1619350123, 'Taoyuan', 0, 1),
(136, '新竹內灣老街', 'COGGEw-JXPN', 1619367211, 'Hsinchu', 0, 1),
(137, '杷記韓式料理', 'COGCJCUHxYN', 1619365148, 'Hsinchu', 0, 1),
(138, '寶山第二水庫', 'COGB6ounLvt', 1619365030, 'Hsinchu', 0, 1),
(139, 'July.28', 'COGBm6JpFIA', 1619364869, 'Hsinchu', 0, 1),
(140, 'Xpark水族館', 'CN6zJXulAsR', 1618988188, 'Taoyuan', 0, NULL),
(141, '新竹孔廟', 'COGRbLnDieQ', 1619373161, 'Hsinchu', 0, 1),
(142, '新竹巿立動物園', 'COF73I9sIRC', 1619361856, 'Hsinchu', 0, 1),
(143, '東大路橋', 'COF_wpnLdpA', 1619363900, 'Hsinchu', 0, 1),
(144, '東大路橋', 'COF_IbcLIsw', 1619363571, 'Hsinchu', 0, NULL),
(145, '莫甜 More Sweets', 'COEv90DpW51', 1619322065, 'Taoyuan', 0, 1),
(146, '新竹內灣老街', 'COF-nIpp2c3', 1619363298, 'Hsinchu', 0, NULL),
(147, '鳳崎落日登山步道', 'COF6aiwJ1sg', 1619361098, 'Hsinchu', 0, 1),
(148, '暗室微光', 'COF5xUXlEyz', 1619360760, 'Hsinchu', 0, 1),
(149, '李克承博士故居 a-moom', 'COF5RJFHgrH', 1619360496, 'Hsinchu', 0, 1),
(150, '東窩溪螢火蟲生態區', 'COF7nzPFaI8', 1619361730, 'Hsinchu', 0, 1),
(151, 'Susumu', 'COF66UypzIZ', 1619361358, 'Hsinchu', 0, 1),
(152, '漫步天湖露營區', 'COGIc15nCfe', 1619368456, 'Hsinchu', 0, 1),
(153, '天馬行空露營區', 'COGIK8Fnpdi', 1619368310, 'Hsinchu', 0, 1),
(154, 'Kukukohi_哭哭咖啡', 'COF4AXVpPZl', 1619359835, 'Hsinchu', 0, 1),
(155, '暗室微光', 'COF3U5_H0_7', 1619359479, 'Hsinchu', 0, NULL),
(156, '東安古橋', 'COF_Ev_JFpy', 1619363540, 'Hsinchu', 0, 1),
(157, '愛露營 天景露營區', 'COF4sXiBYDk', 1619360195, 'Hsinchu', 0, 1),
(158, '日本橋浜町食事処-新竹大遠百店', 'COF4i1jreAt', 1619360117, 'Hsinchu', 0, 1),
(159, 'July.28', 'COGBSBkJLLJ', 1619364698, 'Hsinchu', 0, NULL),
(160, 'Petaling Jaya, Malaysia', 'COGAr8qHT3v', 1619364467, 'Hsinchu', 0, 1),
(161, '東大路橋', 'COFpYesLHkG', 1619352168, 'Hsinchu', 0, NULL),
(162, '東大路橋', 'COFnm5GL29s', 1619351237, 'Hsinchu', 0, NULL),
(163, '新竹公園 Hsinchu Park', 'COF6u5UhJ5A', 1619361264, 'Hsinchu', 0, 1),
(164, '飛鳳山', 'COF2HijpOsc', 1619358845, 'Hsinchu', 0, 1),
(165, '青林農場', 'COF9IrcnvP2', 1619362524, 'Hsinchu', 0, 1),
(166, '泰崗野溪溫泉', 'COF8lDxD1fH', 1619362232, 'Hsinchu', 0, 1),
(167, '香山濕地賞蟹步道', 'COFsGWpM9tW', 1619353592, 'Hsinchu', 0, 1),
(168, '火炎山大峽谷', 'COGXbqblxH6', 1619376311, 'Miaoli', 0, 1),
(169, '九天夕陽之樹', 'COGUbnvln0W', 1619374738, 'Miaoli', 0, 1),
(170, '無恙', 'COF4fwUHKGa', 1619360092, 'Hsinchu', 0, 1),
(171, '高島縱走', 'COF6nTgH0Km', 1619361202, 'Hsinchu', 0, 1),
(172, '新竹火車站hsinchu Train Station', 'CNiDlskhg74', 1618157948, 'Hsinchu', 0, NULL),
(173, '客雅大道', 'CNiC2ZshHBH', 1618157561, 'Hsinchu', 0, 1),
(174, '新竹中正路', 'CNiCeozhspa', 1618157366, 'Hsinchu', 0, 1),
(175, '橙香森林', 'COGDkpUs_iX', 1619365899, 'Miaoli', 0, 1),
(176, '湖口鄉', 'COF1oKQBOqL', 1619358588, 'Hsinchu', 0, 1),
(177, '新竹孔廟', 'COFzui3MkWA', 1619357591, 'Hsinchu', 0, NULL),
(178, '崎頂車站', 'COF4HzTgLq5', 1619359895, 'Hsinchu', 0, 1),
(179, '魚刺人雞蛋糕-修車廠店', 'COGEuBznIff', 1619366500, 'Miaoli', 0, 1),
(180, '加里山', 'COGEoMiDEDM', 1619366452, 'Miaoli', 0, 1),
(181, 'Hsinchu, Taiwan', 'COF20jqBmkd', 1619359213, 'Hsinchu', 0, NULL),
(182, '東大路橋上', 'COFm8l9LZBb', 1619350891, 'Hsinchu', 0, 1),
(183, '3sän cafe', 'COF6uRgp4I-', 1619361259, 'Miaoli', 0, 1),
(184, 'U+西湖包棟民宿', 'COF5WjHJzP7', 1619360541, 'Miaoli', 0, 1),
(185, '功維敘隧道', 'COGBz9MMqo0', 1619364976, 'Miaoli', 0, 1),
(186, '火炎山大峽谷', 'COF_L3OpQ2P', 1619363599, 'Miaoli', 0, NULL),
(187, '漫步雲端', 'COF_LlJhuOG', 1619363596, 'Miaoli', 0, 1),
(188, '東大路橋', 'COFnePOL_jZ', 1619351166, 'Hsinchu', 0, NULL),
(189, '鯉魚潭水庫 Liyutan Dam', 'COGFgljBDMb', 1619366914, 'Miaoli', 0, 1),
(190, '莫內秘密花園', 'COF0oA4n3kB', 1619358062, 'Miaoli', 0, 1),
(191, '苗栗', 'COF0D41HPbt', 1619357766, 'Miaoli', 0, 1),
(192, 'Mountaintown Coffee Roasters', 'COF5FsRBXkN', 1619360402, 'Miaoli', 0, 1),
(193, '竹南虱目魚大王', 'COF4spYrE-y', 1619360197, 'Miaoli', 0, 1),
(194, 'Miaoli County', 'COF31GoJQb8', 1619359742, 'Miaoli', 0, 1),
(195, '金山跳石沒有名字的咖啡店', 'COGIRQknpYk', 1619368362, 'Miaoli', 0, 1),
(196, '魚藤坪斷橋', 'COFkFV2nP86', 1619349390, 'Miaoli', 0, 1),
(197, '磨實生活工作室', 'COFjRj1H61v', 1619348965, 'Miaoli', 0, 1),
(198, '橙香森林', 'COFjOs8HctZ', 1619348942, 'Miaoli', 0, NULL),
(199, '小山丘', 'COGD1WwD6mg', 1619366036, 'Miaoli', 0, 1),
(200, '銅鑼茶廠', 'COFs1LuD8-M', 1619353976, 'Miaoli', 0, 1),
(201, '窩 coffee', 'COGDGQ4sX_j', 1619365650, 'Miaoli', 0, 1),
(202, '蔬皮肚皮 Superduper', 'COGB9yFsO5c', 1619365056, 'Miaoli', 0, 1),
(203, '勤美學 CMP Village', 'COFcTiinY8t', 1619345312, 'Miaoli', 0, 1),
(204, '好客公園', 'COFcOU1sIVr', 1619345269, 'Miaoli', 0, 1),
(205, 'Route 3 三號公路', 'COFblTcH1WG', 1619344933, 'Miaoli', 0, 1),
(206, '魚刺人雞蛋糕-修車廠店', 'COF_Co6noBy', 1619363523, 'Miaoli', 0, NULL),
(207, '銅鑼茶廠', 'COF8MxMhecB', 1619362033, 'Miaoli', 0, NULL),
(208, '鹿角Café', 'COFcbaOjk-Y', 1619345376, 'Miaoli', 0, 1),
(209, '苗栗 南庄', 'COFcbAds-PG', 1619345373, 'Miaoli', 0, 1),
(210, 'Miaoli County', 'COFyetwJWs6', 1619356937, 'Miaoli', 0, NULL),
(211, '蓁愛產後護理之家', 'COCRxeGhxvU', 1619239126, 'Miaoli', 0, 1),
(212, '火炎山', 'COFqCw_H9tr', 1619352514, 'Miaoli', 0, 1),
(213, '苗栗', 'COF3ppADV8L', 1619359648, 'Miaoli', 0, NULL),
(214, '苗栗烏嘎彥竹林之旅', 'COF3RqdFv_x', 1619359452, 'Miaoli', 0, 1),
(215, '崎頂車站', 'COFT-tuniC1', 1619340947, 'Miaoli', 0, NULL),
(216, '勝興車站', 'COFTQ4ynwVZ', 1619340571, 'Miaoli', 0, 1),
(217, 'Route 3 三號公路', 'COFiwR6DTW8', 1619348693, 'Miaoli', 0, NULL),
(218, '鹿角Café', 'COFewQXL4--', 1619346595, 'Miaoli', 0, NULL),
(219, '實心裡  生活什物店', 'COLQoo6HQaY', 1619540520, 'Taichung', 0, 1),
(220, '臺灣客家文化館', 'COFp_zCHpAl', 1619352490, 'Miaoli', 0, 1),
(221, 'Taiwan', 'COLStw7LoVV', 1619541610, 'Taichung', 0, NULL),
(222, '旅禾 泡芙之家 審計旗艦店', 'COLSmgUhEZ1', 1619541551, 'Taichung', 0, 1),
(223, '欣欣乾洗廠', 'COLSktNnDdN', 1619541536, 'Taichung', 0, 1),
(224, '愛露營 山視界露營區', 'COFbHl5sDyT', 1619344689, 'Miaoli', 0, 1),
(225, '花露農場 FlowerHome', 'COFZ-ijHH0L', 1619344091, 'Miaoli', 0, 1),
(226, 'Draft Land 慢閃店', 'COLOlznpn8w', 1619539462, 'Taichung', 0, 1),
(227, '金色三麥 台中勤美店', 'COLQPocnNN0', 1619540315, 'Taichung', 0, 1),
(228, '清泉崗空軍基地', 'COLQOkHBrVJ', 1619540306, 'Taichung', 0, 1),
(229, '中央公園', 'COLQJJ5p75_', 1619540262, 'Taichung', 0, 1),
(230, 'Smile Cøffee 憲賣-北歐丹麥咖啡吧', 'COLPSekpp2q', 1619539814, 'Taichung', 0, 1),
(231, '苗栗', 'CMMkAiggrnI', 1615289264, 'Miaoli', 0, NULL),
(232, '台中健身房 北區中清店 Souls Fitness覺醒健身俱樂部', 'COLNwnwn8ot', 1619539012, 'Taichung', 0, 1),
(233, '五峰旗風景區', 'COLNH88gbmg', 1619538701, 'Taichung', 0, 1),
(234, '東海大學 Tunghai University', 'COLOar5sylQ', 1619539357, 'Taichung', 0, 1),
(235, '花露農場 FlowerHome', 'COCaJJ_sHLg', 1619243515, 'Miaoli', 0, NULL),
(236, '恆日 - 1989 .', 'COLOLweB8Pt', 1619539234, 'Taichung', 0, 1),
(237, '魚藤坪斷橋', 'CN7nu8hs-BZ', 1619015759, 'Miaoli', 0, NULL),
(238, '歷史建築帝國製糖廠臺中營業所', 'COLMuGpHMq2', 1619538467, 'Taichung', 0, 1),
(239, 'Draft Land 慢閃店', 'COLMdn2J9vh', 1619538422, 'Taichung', 0, NULL),
(240, 'DRINKTOPIA', 'COLMVozHhBb', 1619538267, 'Taichung', 0, 1),
(241, '五峰旗風景區', 'COLNEGwgK5_', 1619538666, 'Taichung', 0, NULL),
(242, 'Taiwan', 'COLSUusr_c4', 1619541405, 'Taichung', 0, NULL),
(243, '早彎', 'COLM-_xHqQM', 1619538606, 'Taichung', 0, 1),
(244, '台中文學館 Taichung Literature Pavilion', 'COLRCdEBR-F', 1619540731, 'Taichung', 0, 1),
(245, '台中文學館 Taichung Literature Pavilion', 'COLLfFYnlt_', 1619537820, 'Taichung', 0, NULL),
(246, 'Taichung', 'COLLW08nJvq', 1619537752, 'Taichung', 0, 1),
(247, '台中浩天宮大庄媽', 'COLOVbPspoy', 1619539314, 'Taichung', 0, 1),
(248, '舊社咖啡     Good Shot Cafe', 'COLMPcJDZ0v', 1619538216, 'Taichung', 0, 1),
(249, '中央公園 Taichung Central Park', 'COLLyZor1s_', 1619537978, 'Taichung', 0, 1),
(250, '大坑新桃花源橋', 'COLO0cCnT0I', 1619539568, 'Taichung', 0, 1),
(251, 'Citrus Pâtisserie Boulangerie 蜜柑。法式甜點。麵包。', 'COLOzw5gAHL', 1619539562, 'Taichung', 0, 1),
(252, '中央公園 Taichung Central Park', 'COIiegBjdP6', 1619449210, 'Taichung', 0, NULL),
(253, '初咖啡The Origin Coffee Roaster in Shalu', 'CLO_qOqHruC', 1613223386, 'Taichung', 0, 1),
(254, '范特喜_綠光計畫（Fantasystory_Green Ray)', 'COLNC5hJKp4', 1619538637, 'Taichung', 0, 1),
(255, 'Taichung', 'COLLOI7nOQf', 1619537681, 'Taichung', 0, NULL),
(256, '春山相館id photo&amp; Dessert 證件照/台中證件照/大頭照/專業形象照', 'COLOH1GHYbk', 1619539202, 'Taichung', 0, 1),
(257, 'Draft Land 慢閃店', 'COLNwUPpE4b', 1619539061, 'Taichung', 0, NULL),
(258, 'Bullpen tattoo 牛棚紋身', 'COLK7uinGN9', 1619537530, 'Taichung', 0, 1),
(259, 'Taichung, Taiwan', 'CBSa_NkHcNi', 1591863541, 'Taichung', 0, 1),
(260, 'Taichung, Taiwan', 'CBQOd04nlS_', 1591789867, 'Taichung', 0, NULL),
(261, '彰化', 'CONmmrJDmZh', 1619619147, 'Changhua', 0, 1),
(262, 'Bun Bun 棒棒', 'CIivBXTj-QE', 1607443301, 'Taichung', 0, 1),
(263, 'Taichung, Taiwan', 'COLM3G4jgr4', 1619538541, 'Taichung', 0, NULL),
(264, '楽珈 Coffee Roaster', 'CEV9E48nQyp', 1598424527, 'Taichung', 0, 1),
(265, 'Taichung, Taiwan', 'CBaL2U_n156', 1592124039, 'Taichung', 0, NULL),
(266, '馬稜溫泉', 'COLLUhWBIe6', 1619537733, 'Taichung', 0, 1),
(267, '餐與生活', 'COLLNENnE64', 1619537672, 'Taichung', 0, 1),
(268, 'Taichung', 'COLLCA3HMWj', 1619537582, 'Taichung', 0, NULL),
(269, '隱鍋 彰化中正店', 'CONmannsrve', 1619619048, 'Changhua', 0, 1),
(270, 'Taichung', 'COLLwhTHjdP', 1619537963, 'Taichung', 0, NULL),
(271, 'Taichung', 'COLLhU6nUVn', 1619537838, 'Taichung', 0, NULL),
(272, '小原婚宴會館', 'CONisO1FPO6', 1619617095, 'Changhua', 0, 1),
(273, 'Bun Bun 棒棒', 'CITLScFj6wu', 1606921250, 'Taichung', 0, NULL),
(274, 'Butter 巴特手作晨食 Brunch&amp;cafe', 'CONIs5dnhCh', 1619603469, 'Changhua', 0, 1),
(275, '臺中市四張犁三官堂', 'CONIiz0sGr7', 1619603386, 'Changhua', 0, 1),
(276, '有片森林「植一座咖啡館」', 'CONIK13jLsl', 1619603190, 'Changhua', 0, 1),
(277, '春日指彩 Spring Daily Nails', 'CONGYfFr2Zg', 1619602253, 'Changhua', 0, 1),
(278, '彰化市．Changhua City', 'CONDEwJnu_a', 1619600524, 'Changhua', 0, 1),
(279, '金水咖啡 Jin Shui Cafe', 'CONTPPNDTyD', 1619608993, 'Changhua', 0, 1),
(280, '溪湖糖廠', 'CONM1Amj-7g', 1619605633, 'Changhua', 0, 1),
(281, '臺中國家歌劇院 National Taichung Theater', 'CI8YQOWDSWO', 1608303779, 'Taichung', 0, 1),
(282, '彰化', 'CONLxPCnQod', 1619605077, 'Changhua', 0, NULL),
(283, '一緒哥 巴哈 Uisge Beatha', 'CONbP79JAxH', 1619613193, 'Changhua', 0, 1),
(284, '田尾公路花園', 'CONW4SAnY1G', 1619610902, 'Changhua', 0, 1),
(285, 'Loyalty Select Shop', 'COM7ITwHKto', 1619596353, 'Changhua', 0, 1),
(286, '彰化車站', 'CONmFOOMzJ5', 1619618873, 'Changhua', 0, 1),
(287, '大甲鎮瀾宮', 'CONkWASnS21', 1619617961, 'Changhua', 0, 1),
(288, 'Goodnight 晚安,美學 - 社頭店', 'COM6N15pGRo', 1619595875, 'Changhua', 0, NULL),
(289, '田中', 'CONbXlXnX_w', 1619613256, 'Changhua', 0, 1),
(290, '農家樂露營區', 'CON4NKxnNF-', 1619628375, 'Nantou', 0, 1),
(291, '田尾公路花園', 'CONXBrfnRAH', 1619610979, 'Changhua', 0, NULL),
(292, '星月天空景觀餐廳', 'CONzVFJgTdC', 1619625818, 'Nantou', 0, 1),
(293, '貳拾捌 28 Nails', 'CONWjogrA5Q', 1619610733, 'Changhua', 0, 1),
(294, '艾波廚房-彰化站前店', 'CONUIM2Hh5d', 1619609460, 'Changhua', 0, 1),
(295, '陽光老店爌肉飯', 'COC68-unrel', 1619260716, 'Changhua', 0, 1),
(296, '明明bakery', 'CN4w4OfDWuV', 1618919890, 'Changhua', 0, 1),
(297, '玻璃媽祖廟', 'CONMa_3D_QU', 1619605419, 'Changhua', 0, 1),
(298, '農家樂露營區', 'CON4VWqHW8a', 1619628442, 'Nantou', 0, NULL),
(299, '員林西區運動公園', 'CONK4L3HMTz', 1619604610, 'Changhua', 0, 1),
(300, '大嫂的奶x有毒-彰化店', 'COM4oY7rBBi', 1619595043, 'Changhua', 0, 1),
(301, '南投埔里寶湖宮天地堂地母廟', 'CON3D4tLx2y', 1619627775, 'Nantou', 0, 1),
(302, '野花小姐', 'COMy5sPAlHa', 1619592039, 'Changhua', 0, 1),
(303, '郡大山', 'CONtXHbH9d5', 1619622689, 'Nantou', 0, 1),
(304, '清境農場 Qingjing Farm', 'CONs0PELFyb', 1619622403, 'Nantou', 0, 1),
(305, '埔里內埔飛場', 'CONqiLHn4O8', 1619621207, 'Nantou', 0, 1),
(306, 'Goodnight 晚安,美學 - 社頭店', 'COM6QQDJVdY', 1619595894, 'Changhua', 0, 1),
(307, 'Goodnight 晚安,美學 - 員林店', 'COM6PeXJ9rM', 1619595888, 'Changhua', 0, 1),
(308, '老英格蘭莊園', 'CONpbUwHypu', 1619620627, 'Nantou', 0, 1),
(309, '西螺大橋', 'COM5du0s__z', 1619595480, 'Changhua', 0, 1),
(310, '鹿篙咖啡莊園', 'CONeWBFBZ93', 1619614816, 'Nantou', 0, 1),
(311, '藝寶窗花門板', 'COM3NQXn7G-', 1619594297, 'Changhua', 0, 1),
(312, '日月潭浪人槳堂SUP教學體驗中心', 'CONZ4UvJOB1', 1619612576, 'Nantou', 0, 1),
(313, '凡果 x NailArt', 'COMuFiPJ0Ks', 1619589515, 'Changhua', 0, 1),
(314, '田中', 'COIaVLznZ9n', 1619444940, 'Changhua', 0, NULL),
(315, '畢瓦客Biwak', 'CONjSN8Hk7k', 1619617406, 'Nantou', 0, 1),
(316, '日月老茶廠', 'CONg9dAsy_J', 1619616187, 'Nantou', 0, 1),
(317, '成美文化園', 'CNZ7p0ipXqL', 1617885352, 'Changhua', 0, 1),
(318, 'Take Me Away帶我走 甜點工作室', 'CONgXFfHTxF', 1619615873, 'Nantou', 0, 1),
(319, '農家樂露營區', 'CON4RqhHjU7', 1619628412, 'Nantou', 0, NULL),
(320, '日月潭大淶閣飯店', 'CONk4peh76f', 1619618245, 'Nantou', 0, 1),
(321, '觀音亭彩虹橋', 'CONbMy7nZFs', 1619613167, 'Nantou', 0, 1),
(322, '台灣最美/最高的公路-台14甲', 'CONkTeZpQys', 1619617941, 'Nantou', 0, 1),
(323, '大竹湖步道', 'CONYPnAHHjN', 1619611618, 'Nantou', 0, 1),
(324, '南投埔里寶湖宮天地堂地母廟', 'CONWrdaAb4e', 1619610797, 'Nantou', 0, NULL),
(325, 'Desolatecoffee/蠻荒咖啡', 'CONV782DN1f', 1619610408, 'Nantou', 0, 1),
(326, '台電雲海保綫所（海拔2360公尺）', 'CONqJ0enCY_', 1619621007, 'Nantou', 0, 1),
(327, '雲品溫泉酒店日月潭Fleur de Chine Hotel', 'CONpqRoHXyp', 1619620749, 'Nantou', 0, 1),
(328, '中興新村[光明里]', 'CONU9uYnE9j', 1619609898, 'Nantou', 0, 1),
(329, 'Shenzhen, Guangdong', 'CONoebOFVCI', 1619620128, 'Nantou', 0, 1),
(330, '竹山紫南宮', 'CLYAGDLjxfC', 1613525604, 'Nantou', 0, 1),
(331, '妖怪村', 'CONkiPXgUVr', 1619618062, 'Nantou', 0, 1),
(332, '烏松崙森林渡假營【石家梅園】', 'CKu6j72jaV_', 1612146972, 'Nantou', 0, 1),
(333, '奧萬大國家森林遊樂區', 'CONkI3dhzqf', 1619617854, 'Nantou', 0, 1),
(334, '蜜仔琉部', 'CONjcEInGtm', 1619617487, 'Nantou', 0, 1),
(335, '佛羅倫斯渡假山莊Florence Resort Villa', 'CONM-1Dn5FH', 1619605713, 'Nantou', 0, 1),
(336, '九族文化村 Formosan Aboriginal Culture Village', 'CONLSxuHDPn', 1619604828, 'Nantou', 0, 1),
(337, '盒木；Hermon', 'CONgZRYnzAN', 1619615891, 'Nantou', 0, 1),
(338, 'Sun Moon Lake日月潭', 'COGswCmholk', 1619387488, 'Nantou', 0, 1),
(339, '塔加加夫妻樹', 'CONf1f7HI8e', 1619615598, 'Nantou', 0, 1),
(340, '中興新村光明三路石斛蘭大道', 'CONT-vSntbh', 1619609382, 'Nantou', 0, 1),
(341, '烏松崙森林渡假營【石家梅園】', 'CKy3bB5DtJG', 1612279544, 'Nantou', 0, NULL),
(342, '多肉秘境', 'CONQUrEDwuV', 1619607465, 'Nantou', 0, 1),
(343, '烏松崙森林渡假營【石家梅園】', 'CKoDp0wjHyE', 1611916857, 'Nantou', 0, NULL),
(344, 'Kebagusan, Pasar Minggu, Jakarta Selatan', 'COX_ttiBAZ1', 1619967856, 'Yunlin', 0, 1),
(345, '千巧谷牛樂園牧場', 'COX-3jbrDCG', 1619967412, 'Yunlin', 0, 1),
(346, '奧萬大國家森林遊樂區', 'CONVnuRHmsA', 1619610242, 'Nantou', 0, NULL),
(347, '南投埔里寶湖宮天地堂地母廟', 'CONVTiGMQNs', 1619610077, 'Nantou', 0, NULL),
(348, '成龍集會所', 'COX-Ginn2gb', 1619967011, 'Yunlin', 0, 1),
(349, '中興新村[光明里]', 'CONUnQhnbof', 1619609714, 'Nantou', 0, NULL),
(350, '雲林斗六火車站', 'COXn27DLC-U', 1619955348, 'Yunlin', 0, 1),
(351, '星月天空景觀餐廳', 'CONTdkdH2G2', 1619609111, 'Nantou', 0, NULL),
(352, '西螺大橋', 'COXkzDPHvaR', 1619953744, 'Yunlin', 0, NULL),
(353, '鹿篙咖啡莊園', 'CONNtiFnMXK', 1619606096, 'Nantou', 0, NULL),
(354, '明新書院-三級古蹟', 'CONNBl2HBZu', 1619605736, 'Nantou', 0, 1),
(355, '北港朝天宮', 'COXxr_vshpm', 1619960502, 'Yunlin', 0, 1),
(356, '北港朝天宮', 'COXsl0pjhec', 1619957830, 'Yunlin', 0, NULL),
(357, 'Take Me Away帶我走 甜點工作室', 'CONJDa5n4LV', 1619603653, 'Nantou', 0, NULL),
(358, '獨角仙休閒農場', 'COXqtvVntbA', 1619956846, 'Yunlin', 0, 1),
(359, '合歡山', 'CNho4VbpKi7', 1618143945, 'Nantou', 0, 1),
(360, '北港觀光大橋 Beigang Tourist Bridge', 'COX8VHbDlla', 1619966081, 'Yunlin', 0, 1),
(361, 'Kaohsiung, Taiwan', 'COXlrFVDq70', 1619954203, 'Yunlin', 0, 1),
(362, 'Yünlin, Taiwan', 'COX5LZGJWm3', 1619964429, 'Yunlin', 0, 1),
(363, '北港朝天宮', 'COXi-r5sCU9', 1619952790, 'Yunlin', 0, NULL),
(364, '華山1914文化創意產業園區', 'COXhSkThD49', 1619951918, 'Yunlin', 0, 1),
(365, '北港朝天宮', 'COXgjoPLlLl', 1619951520, 'Yunlin', 0, NULL),
(366, '國立雲林科技大學YunTech', 'COX-fCUHQCz', 1619967211, 'Yunlin', 0, 1),
(367, '竽芯園庭園美食屋 雲林縣古坑鄉', 'COX-Ps1H5dV', 1619967086, 'Yunlin', 0, 1),
(368, '午光紅茶Brunch X 午光食舍', 'COXUUSbsDwy', 1619945103, 'Yunlin', 0, 1),
(369, 'Yünlin, Taiwan', 'COX8bKHJNv8', 1619966131, 'Yunlin', 0, NULL),
(370, '飛樂尼斯舞蹈工作室-虎尾', 'COW_0jFDn3u', 1619934357, 'Yunlin', 0, 1),
(371, '北港朝天宮', 'COX7wGnnV99', 1619965778, 'Yunlin', 0, NULL),
(372, '走馬瀨農場', 'COW-55vBJQB', 1619933877, 'Yunlin', 0, 1),
(373, '雲林斗六火車站', 'COX5HHeHiZA', 1619964394, 'Yunlin', 0, NULL),
(374, '命中注定Brunch早午餐', 'COXzIkjDIcJ', 1619961260, 'Yunlin', 0, 1),
(375, '澄霖沉香味道森林館', 'COXKQ8ZHWHD', 1619939833, 'Yunlin', 0, 1),
(376, '女兒橋', 'COXKMxGHeU9', 1619939799, 'Yunlin', 0, 1),
(377, '桃花源餐廳 斗六店', 'COXr8s5lCpY', 1619957493, 'Yunlin', 0, 1),
(378, '雲林四湖參天宮關聖帝君', 'COXDqxyH7e-', 1619936374, 'Yunlin', 0, 1),
(379, '北港朝天宮', 'COXpKxTMNdG', 1619956035, 'Yunlin', 0, NULL),
(380, '泰Pan - 泰式小吃', 'COXTRgZlpuu', 1619944556, 'Yunlin', 0, 1),
(381, '走馬瀨農場', 'COW-9REh6tx', 1619933904, 'Yunlin', 0, NULL),
(382, 'Yünlin, Taiwan', 'COXP4D5H44u', 1619942775, 'Yunlin', 0, NULL),
(383, '走馬瀨農場', 'COW-zRFhssJ', 1619933823, 'Yunlin', 0, NULL),
(384, '馬蹄蛤主題館', 'COW9gJds9gL', 1619933142, 'Yunlin', 0, 1),
(385, '千巧谷牛樂園牧場', 'COW7yIHnB-s', 1619932240, 'Yunlin', 0, NULL),
(386, '三秀園', 'COXWRpppLGs', 1619946130, 'Yunlin', 0, 1),
(387, '七の一手作食堂', 'COXVsyRjPnG', 1619945828, 'Yunlin', 0, 1),
(388, 'Yünlin, Taiwan', 'COWopezJqqA', 1619922208, 'Yunlin', 0, NULL),
(389, '虎尾-阿爸的花生糖', 'COXTpLJFgBC', 1619944750, 'Yunlin', 0, 1),
(390, '唉喲唉喲一喲一唷唉喲', 'COYbrWjFSga', 1619982517, 'keelung', 0, 1),
(391, '木子木子', 'COXSAoVJ2UP', 1619943894, 'Yunlin', 0, 1),
(392, '虎尾-阿爸的花生糖', 'COW3nA0FZT0', 1619930052, 'Yunlin', 0, NULL),
(393, '宜梧蚵嗲', 'COXOb9_gvKz', 1619942084, 'Yunlin', 0, 1),
(394, '虎尾鐵橋', 'COXOWKDMcqg', 1619941973, 'Yunlin', 0, 1),
(395, '虎尾鐵橋', 'COVaM6Vn3ww', 1619881080, 'Yunlin', 0, NULL),
(396, '北港鎮', 'COVaD99LuMB', 1619881006, 'Yunlin', 0, 1),
(397, '北港朝天宮', 'COXEFN8JkPE', 1619936591, 'Yunlin', 0, NULL),
(398, '北港朝天宮', 'COVWSK7MXcO', 1619879026, 'Yunlin', 0, NULL),
(399, '北港朝天宮', 'COXCrDKsvkp', 1619935852, 'Yunlin', 0, NULL),
(400, '北港朝天宮', 'COVckN4slf4', 1619882319, 'Yunlin', 0, NULL),
(401, 'Hualian City', 'COy8xhaHqi3', 1620872284, 'hualien', 0, 1),
(402, 'kikumo 菊も', 'COzCtQbMDn5', 1620875395, 'taipei', 0, 1),
(403, '斗六門受天宮', 'COVWiJJlFbe', 1619879156, 'Yunlin', 0, 1),
(404, '太湖漂浮斑馬線', 'COzWXb-r3ZW', 1620885702, 'Kinmen', 0, 1),
(405, '瑞穗天合國際觀光酒店 Grand Cosmos Resort', 'COrRE_iMFZW', 1620614494, 'hualien', 0, 1),
(406, 'CHICO 餐廚', 'COWz6sDHz9E', 1619928116, 'Yunlin', 0, 1),
(407, '太魯閣國家公園', 'COrFs64MjE9', 1620608529, 'hualien', 0, 1),
(408, '馬蹄蛤主題館', 'COWlUQBM1W_', 1619920461, 'Yunlin', 0, NULL),
(409, '北港朝天宮', 'COWchKvDgU5', 1619915849, 'Yunlin', 0, NULL),
(410, '北港朝天宮', 'COWLYWzsIkL', 1619906863, 'Yunlin', 0, NULL),
(411, '北港朝天宮', 'COWGj2-MCDy', 1619904336, 'Yunlin', 0, NULL),
(412, '嘉義觀止Hotel', 'COVroWoFq1a', 1619890217, 'Yunlin', 0, 1),
(413, '峇里情人度假民宿-峇里島風格、旅行攝影、花蓮民宿', 'COrKCStlz9_', 1620610801, 'hualien', 0, 1),
(414, 'Kinmen, Fu-Chien, Taiwan', 'CO0ccCPFQ5o', 1620922439, 'Kinmen', 0, 1),
(415, '基隆夜市', 'COw9u3QMKMx', 1620805677, 'keelung', 0, 1),
(416, '凡不凡咖啡', 'COw64bbjZVz', 1620804183, 'keelung', 0, 1),
(417, '外木山環海步道', 'COw62_KHqAw', 1620804171, 'keelung', 0, 1),
(418, '澄霖沉香味道森林館', 'CORs2GDFECo', 1619756636, 'Yunlin', 0, NULL),
(419, '基隆東岸廣場Esquare', 'COY5iMRDNao', 1619998170, 'keelung', 0, 1),
(420, '八斗子海岸秘徑 - 大坪海岸-潮間帶', 'COY3KJwHjgu', 1619997155, 'keelung', 0, 1),
(421, 'Keelung City Taiwan R.O.C', 'COYiN6tgaDT', 1619985945, 'keelung', 0, 1),
(422, '郵寄兵Rangers 歐美精品', 'COzbo-EjDns', 1620888467, 'kaohsiung', 0, 1),
(423, '草民 Tsao Min', 'COzm73XDRUH', 1620894389, 'taitung', 0, 1),
(424, '老鷹岩', 'COYGDFynbC4', 1619971177, 'keelung', 0, 1),
(425, '藍蜻蜓速食專賣店', 'COzidnjrYGG', 1620892044, 'taitung', 0, 1),
(426, '嘉德萱草 - 金針花園區', 'COrMSH4nBcW', 1620611980, 'hualien', 0, 1),
(427, 'Kaohsiung, Taiwan', 'COzcMrCH1bx', 1620888759, 'kaohsiung', 0, NULL),
(428, 'Central Park (Kaohsiung)', 'COzb1KSnnGz', 1620888567, 'kaohsiung', 0, 1),
(429, 'BELLAVITA', 'CO1dSbLgaEB', 1620956439, 'taipei', 0, 1),
(430, '汐止和信水蓮山莊', 'CO1dNHkB_Xa', 1620956396, 'taipei', 0, 1),
(431, '台東舊站', 'COzk7KQBBJX', 1620893334, 'taitung', 0, 1),
(432, '合歡山 Hehuan Mountain', 'COy7p64Ls4A', 1620871697, 'keelung', 0, 1),
(433, '阿根那造船遺址', 'COy4XMprE1S', 1620869971, 'keelung', 0, 1),
(434, '花蓮', 'COy8-JYjuQL', 1620872387, 'hualien', 0, 1),
(435, '陳清吉洋樓', 'CO1VQfZlkaC', 1620952229, 'Kinmen', 0, 1),
(436, '嚨口海邊', 'CO1RXTPHvSM', 1620950188, 'Kinmen', 0, 1),
(437, 'The Art Space by the Studio', 'COzCkZOjy4S', 1620875322, 'taipei', 0, 1),
(438, 'Vita A Simple Cafe法星自家烘焙咖啡', 'CO1bJp0MqD7', 1620955319, 'keelung', 0, 1),
(439, '金門', 'COzVQ6vF1gq', 1620885124, 'Kinmen', 0, 1),
(440, 'Zhaishan Tunnel', 'COzTCQ5t_cW', 1620883955, 'Kinmen', 0, 1),
(441, '南石滬公園', 'CO1ViLxtSgg', 1620952374, 'Kinmen', 0, 1),
(442, '杉林溪森林生態園區', 'CO1bR1jjsJN', 1620955386, 'nantou', 0, 1),
(443, '互助國小', 'CO1aD_rjbnM', 1620954748, 'nantou', 0, 1),
(444, '汐止區', 'CO1cYMpnJVg', 1620955962, 'keelung', 0, NULL),
(445, '萬國戲院', 'CO1kuh5h4iL', 1620960340, 'chiayi', 0, 1),
(446, 'UTC Union Beauty Salon', 'CO1XAl6A_3j', 1620953148, 'taoyuan', 0, 1),
(447, 'Mr. Sam - 山姆先生咖啡館', 'COzZ9wXrPrZ', 1620887588, 'taitung', 0, 1),
(448, '金門水頭得月樓', 'CO0d7auBpL4', 1620923221, 'Kinmen', 0, 1),
(449, 'HA house 秋', 'CO1esn5nmcH', 1620957178, 'yilan', 0, 1),
(450, '金門城', 'CO0cPOqJyiK', 1620922335, 'Kinmen', 0, 1),
(451, '高洞', 'CO0bKZlhaPW', 1620921771, 'Kinmen', 0, 1),
(452, '淡水三芝淺水灣', 'CO1Y-4zHney', 1620954182, 'taipei', 0, 1),
(453, '羅斯福路二段上', 'CO1Y7hhgZoa', 1620954155, 'taipei', 0, 1),
(454, '迎風狗運動公園', 'CO1YwMqrc3h', 1620954062, 'taipei', 0, 1),
(455, 'UTC Union Beauty Salon', 'CO1Wx6kgf5O', 1620953027, 'taoyuan', 0, NULL),
(456, '村口微光一中店', 'CO1rkyEnOIA', 1620963930, 'taichung', 0, 1),
(457, '蘭城晶英酒店 紅樓中餐廳', 'CO1dCJwhuNj', 1620956306, 'yilan', 0, 1),
(458, '宜蘭縣', 'CO1cN2ZHcnz', 1620955878, 'yilan', 0, 1),
(459, '宜蘭傳藝園區', 'CO1Zr9wMxF8', 1620954551, 'yilan', 0, 1),
(460, 'Taipei, Taiwan', 'CO1aUGXnWrQ', 1620954880, 'keelung', 0, NULL),
(461, '庶民美術館', 'CO1eA7rnPwZ', 1620956820, 'taipei', 0, 1),
(462, '象鼻岩景觀區', 'CO1d97nH5Im', 1620956796, 'taipei', 0, 1),
(463, 'mina.k_nail', 'CO1djf8noeZ', 1620956579, 'taipei', 0, 1),
(464, '巴西集品-宜蘭店', 'CO1q6-pDkxc', 1620963587, 'yilan', 0, 1),
(465, '巴西集品-宜蘭店', 'CO1qnGgD7U3', 1620963425, 'yilan', 0, NULL),
(466, 'Taoyuan, Taiwan', 'CO1fosFNQgu', 1620957670, 'taoyuan', 0, NULL),
(467, '巴西集品-宜蘭店', 'CO1ptyRD09n', 1620962955, 'yilan', 0, NULL),
(468, 'UTC Union Beauty Salon', 'CO1W4J9gmJc', 1620953078, 'taoyuan', 0, NULL),
(469, '台灣高鐵嘉義站 THSR Chiayi Station', 'CO1aFqinB70', 1620954762, 'chiayi', 0, 1),
(470, '起風', 'CO1YWnnH2ct', 1620953852, 'chiayi', 0, 1),
(471, '安樓咖啡 ENZO Cafe', 'CO1z6pZH9HC', 1620968303, 'keelung', 0, 1),
(472, '寂人甜食', 'CO1y2X7H6Kh', 1620967744, 'keelung', 0, 1),
(473, '巴西集品-宜蘭店', 'CO1p7AAD6F8', 1620963063, 'yilan', 0, NULL),
(474, '烏石港', 'CO1Y0maBALG', 1620954098, 'yilan', 0, 1),
(475, '清境星光月語民宿高山茶酒館', 'CO1e1NRLrKn', 1620957249, 'nantou', 0, 1),
(476, 'DORIS HOME 朵麗絲的家', 'CO1dwp3n1KK', 1620956687, 'nantou', 0, 1),
(477, 'Goodnight 晚安,美學 - 社頭店', 'CO1mdLPJdM0', 1620961246, 'changhua', 0, NULL),
(478, '東港強 和牛 燒肉 潮州門市', 'CO10sAhn4Hx', 1620968708, 'pingtung', 0, 1),
(479, '不靠海', 'CO1SrLtHnFE', 1620950875, 'nantou', 0, 1),
(480, 'Return｜迴歸', 'CO1yVvGjzLk', 1620967477, 'pingtung', 0, 1),
(481, '正老牌北興榕樹下', 'CO1kVgHHXiQ', 1620960135, 'chiayi', 0, 1),
(482, '1314觀景台', 'CO1jzORH-bj', 1620959854, 'chiayi', 0, 1),
(483, '紀家烘焙坊', 'CO1mhiyjb4M', 1620961282, 'changhua', 0, 1),
(484, '橫山書法公園', 'CO4-J3tjVb7', 1621074334, 'taoyuan', 0, 1),
(485, '路伊Salon-美髮/美甲/霧眉/熱蠟美肌', 'CO486Hwh0HC', 1621073681, 'taoyuan', 0, NULL),
(486, '牛奶湖', 'CO1ylcanp7n', 1620967605, 'pingtung', 0, 1),
(487, '路伊Salon-美髮/美甲/霧眉/熱蠟美肌', 'CO48L05hNOP', 1621073302, 'taoyuan', 0, NULL),
(488, 'JM Auto SPA Taiwan 巧藝專業汽車美容鍍膜', 'CO12WHvNcMW', 1620969577, 'taipei', 0, 1),
(489, '巴西集品-宜蘭店', 'CO1pfAvD681', 1620962834, 'yilan', 0, NULL),
(490, '雙橡園R1特區', 'CO1rmxJFWFa', 1620963946, 'taichung', 0, 1),
(491, '石門洞風景區', 'CO12HlBgOaf', 1620969458, 'taipei', 0, 1),
(492, '春山相館id photo&amp; Dessert 證件照/台中證件照/大頭照/專業形象照', 'CO1rGdfH1Rb', 1620963681, 'taichung', 0, NULL),
(493, '秀泰生活台中文心店', 'CO1qyUfHz2m', 1620963516, 'taichung', 0, 1),
(494, 'Uglycookie', 'CO1qx_VsZNq', 1620963514, 'taichung', 0, 1),
(495, 'Subi coffee&amp;bakery', 'CO1sofrHzrK', 1620964485, 'changhua', 0, 1),
(496, '英格藍家居Eagle', 'CO1musns1Zo', 1620961390, 'changhua', 0, 1),
(497, 'Taipei', 'CO12Jb3Hyln', 1620969473, 'taipei', 0, NULL),
(498, '財團法人嘉義縣朴子配天宮', 'CO9Z7NuMdZL', 1621223112, 'mazu', 0, NULL),
(499, '國家攝影文化中心 National Center of Photography and I', 'CO113IihfeL', 1620969323, 'taipei', 0, 1),
(500, 'VAN GOGH ATELIER DE PINTURA', 'CO4-f-ZjsXJ', 1621074515, 'taipei', 0, 1),
(501, '艋舺', 'CO4-aJ0H67N', 1621074468, 'taipei', 0, 1),
(502, '勝利星村 V.I.P Zone', 'CO1xiPYLjXH', 1620967055, 'pingtung', 0, 1),
(503, '氮醉JoScubar • 鮮釀啤酒', 'CO1xaf2hoyc', 1620966991, 'pingtung', 0, 1),
(504, '潮境公園', 'CO1035fnQhA', 1620968940, 'keelung', 0, 1),
(505, '基隆 • Kawalulu 美甲工作室', 'CO10xynDeeX', 1620968755, 'keelung', 0, 1),
(506, 'Marlon', 'CO9h3Ldjiot', 1621227273, 'keelung', 0, 1),
(507, '台灣巴西柔術基隆學院 - 藍天教室', 'CO9gq5ZpUUF', 1621226648, 'keelung', 0, 1),
(508, '基隆夜市', 'CO1yw8nMR3h', 1620967700, 'keelung', 0, NULL),
(509, '北港', 'CO9isprskin', 1621227711, 'mazu', 0, 1),
(510, '銀河洞瀑布', 'CO12VEmnUaR', 1620969568, 'taipei', 0, 1),
(511, 'Keelung, Taiwan', 'CO9oyGnnhL4', 1621230902, 'keelung', 0, NULL),
(512, '寂人甜食', 'CO9n65tncek', 1621230449, 'keelung', 0, NULL),
(513, '三魚一羊', 'CO92qBOsJEj', 1621238175, 'pingtung', 0, NULL),
(514, 'Foodies%', 'CO9w9XCLN8z', 1621235188, 'pingtung', 0, 1),
(515, '馬祖南竿', 'CO9naOcMUwM', 1621230182, 'mazu', 0, 1),
(516, '濟善老麵 中山店', 'CO4-W8xg2vQ', 1621074441, 'taipei', 0, 1),
(517, 'Paddock Breeze', 'CO4-LKEHHAQ', 1621074345, 'taipei', 0, 1),
(518, '水炊軒', 'CO4-JoiAVic', 1621074332, 'taipei', 0, 1),
(519, 'Prozess Flower普羅賽斯花藝咖啡廳', 'CO9j1EnA0hd', 1621228304, 'taitung', 0, 1),
(520, '知本國家森林遊樂區', 'CO9i_v6pXOc', 1621227868, 'taitung', 0, 1),
(521, '路伊Salon-美髮/美甲/霧眉/熱蠟美肌', 'CO484KNBKp1', 1621073665, 'taoyuan', 0, NULL),
(522, '東清灣海邊', 'CO9f1YRMQC-', 1621226210, 'taitung', 0, 1),
(523, 'N.V PIZZA 黑.火山披薩 桃園八德店', 'CO47QFEHByf', 1621072812, 'taoyuan', 0, 1),
(524, '基隆 • Kawalulu 美甲工作室', 'CO9o7erDHuO', 1621230978, 'keelung', 0, NULL),
(525, 'Vita A Simple Cafe法星自家烘焙咖啡', 'CO9sEQuss_d', 1621232623, 'keelung', 0, NULL),
(526, '小琉球楊光獨木舟', 'CO95IQXjuyC', 1621239472, 'pingtung', 0, 1),
(527, '隨便點好了', 'CO94npqn4Cj', 1621239205, 'pingtung', 0, 1),
(528, '三魚一羊', 'CO93ZpNM42P', 1621238566, 'pingtung', 0, 1),
(529, 'Checkpoint Charlie, Berlin', 'CO9gergF4XP', 1621226548, 'mazu', 0, 1),
(530, '財團法人嘉義縣朴子配天宮', 'CO9dwVYsop8', 1621225120, 'mazu', 0, 1),
(531, '金華柑仔店', 'CO9odjrl0B3', 1621230733, 'kinmen', 0, 1),
(532, '金門模範街', 'CO9jER_HhkE', 1621227905, 'kinmen', 0, 1),
(533, '金門尚義機場', 'CO9cPQiniL_', 1621224325, 'kinmen', 0, 1),
(534, 'Kinmen, Fu-Chien, Taiwan', 'CO9QNUcF8tN', 1621218017, 'kinmen', 0, NULL),
(535, '沙美摩洛哥', 'CO9QJN3lBDB', 1621217984, 'kinmen', 0, 1),
(536, 'Oceantree YogaFarm      樹與海洋瑜珈農場', 'CO9mgm1DJn1', 1621229710, 'taitung', 0, 1),
(537, '台東豐年機場', 'CO9hMifBnrn', 1621226924, 'taitung', 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `user_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員帳號',
  `user_password` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員密碼',
  `user_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '會員名稱',
  `user_email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電子郵件',
  `user_key` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '代碼',
  `introduction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '自我介紹',
  `Authority` int(1) DEFAULT NULL COMMENT '權限代號'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='會員';

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`user_id`, `user_password`, `user_name`, `user_email`, `user_key`, `introduction`, `Authority`) VALUES
('amigo', 'f76ff90264e6b67fda70351d6945a7a69ddb822cbd231e9fb0496b7c1a270aa6cd1e1ae0807b26c8414d1385b7a693006d7b11c18dcef3a1e44cc0a5458dc3ae', '朱宥頤', 'amigo1998928@gmail.com', 'POzOb7ZYXH2JSATZKcoVzXA8fXQ5PzDc', '', 2),
('chinyu', 'f76ff90264e6b67fda70351d6945a7a69ddb822cbd231e9fb0496b7c1a270aa6cd1e1ae0807b26c8414d1385b7a693006d7b11c18dcef3a1e44cc0a5458dc3ae', '郭勁佑', 'amigo1998928@gmail.com', 'JB3ACHOcq1CXbDRUlNpF41jqFNdwX7BX', '', 1),
('sheng', 'f76ff90264e6b67fda70351d6945a7a69ddb822cbd231e9fb0496b7c1a270aa6cd1e1ae0807b26c8414d1385b7a693006d7b11c18dcef3a1e44cc0a5458dc3ae', '林義昇', 'fosilaoshiji@protonmail.com', 'sINVyWBuAwo6tJ8FT5345TASLk6E2vuN', 'Hello!我是義昇!!\r\n', 2),
('tiffany', 'f76ff90264e6b67fda70351d6945a7a69ddb822cbd231e9fb0496b7c1a270aa6cd1e1ae0807b26c8414d1385b7a693006d7b11c18dcef3a1e44cc0a5458dc3ae', '洪詩婷', 'tiffany@example.com', 'VSYzK2Bly1NDv3WvD1lgw1YfltDPpY0w', '', 1),
('wanting', 'f76ff90264e6b67fda70351d6945a7a69ddb822cbd231e9fb0496b7c1a270aa6cd1e1ae0807b26c8414d1385b7a693006d7b11c18dcef3a1e44cc0a5458dc3ae', '楊詠甯', 'ysl58200@gmail.com', 'XBEezPxGxu0K7e3yX0pAKhbEqCEZSUsC', '', 2);

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
  ADD PRIMARY KEY (`sequence_id`),
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
  MODIFY `friend_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '好友編號', AUTO_INCREMENT=37;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `itinerary`
--
ALTER TABLE `itinerary`
  MODIFY `itinerary_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '行程編號', AUTO_INCREMENT=25;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sequence`
--
ALTER TABLE `sequence`
  MODIFY `sequence_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '順序編號', AUTO_INCREMENT=122;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `share`
--
ALTER TABLE `share`
  MODIFY `share_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '共享編號', AUTO_INCREMENT=43;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sight`
--
ALTER TABLE `sight`
  MODIFY `view_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '景點編號', AUTO_INCREMENT=559;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`view_id`) REFERENCES `sight` (`view_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- 資料表的限制式 `friend`
--
ALTER TABLE `friend`
  ADD CONSTRAINT `friend_ibfk_1` FOREIGN KEY (`oneself`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `friend_ibfk_2` FOREIGN KEY (`others`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- 資料表的限制式 `itinerary`
--
ALTER TABLE `itinerary`
  ADD CONSTRAINT `itinerary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- 資料表的限制式 `sequence`
--
ALTER TABLE `sequence`
  ADD CONSTRAINT `sequence_ibfk_1` FOREIGN KEY (`view_id`) REFERENCES `sight` (`view_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `sequence_ibfk_2` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary` (`itinerary_id`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- 資料表的限制式 `share`
--
ALTER TABLE `share`
  ADD CONSTRAINT `share_ibfk_1` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary` (`itinerary_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `share_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
