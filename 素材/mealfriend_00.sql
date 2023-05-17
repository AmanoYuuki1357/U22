-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-05-11 09:50:07
-- サーバのバージョン： 10.4.21-MariaDB
-- PHP のバージョン: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mealfriend`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `t_buy_history`
--

CREATE TABLE `t_buy_history` (
  `f_buy_history_date` datetime NOT NULL,
  `f_user_id` int(11) NOT NULL,
  `f_item_id` int(11) NOT NULL,
  `f_buy_history_vol` int(11) NOT NULL,
  `f_buy_history_delivery_place` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_intakes`
--

CREATE TABLE `t_intakes` (
  `f_user_id` int(11) NOT NULL,
  `f_intake_date` datetime NOT NULL,
  `f_intake_calorie` decimal(4,1) NOT NULL,
  `f_intake_protein_vol` decimal(4,1) NOT NULL,
  `f_intake_lipid_vol` decimal(4,1) NOT NULL,
  `f_intake_dietary_fiber_vol` decimal(4,1) NOT NULL,
  `f_intake_salt_vol` decimal(4,1) NOT NULL,
  `f_intake_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_items`
--

CREATE TABLE `t_items` (
  `f_item_id` int(11) NOT NULL,
  `f_item_name` varchar(25) NOT NULL,
  `f_item_price` int(11) NOT NULL,
  `f_item_explain` varchar(255) NOT NULL,
  `f_item_calorie` decimal(4,1) NOT NULL,
  `f_item_protein_vol` decimal(4,1) NOT NULL,
  `f_item_lipid_vol` decimal(4,1) NOT NULL,
  `f_item_dietary_fiber_vol` decimal(4,1) NOT NULL,
  `f_item_salt_vol` decimal(4,1) NOT NULL,
  `f_item_materials` varchar(255) NOT NULL,
  `f_item_save_way` varchar(255) NOT NULL,
  `f_item_use_by_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_items`
--

INSERT INTO `t_items` (`f_item_id`, `f_item_name`, `f_item_price`, `f_item_explain`, `f_item_calorie`, `f_item_protein_vol`, `f_item_lipid_vol`, `f_item_dietary_fiber_vol`, `f_item_salt_vol`, `f_item_materials`, `f_item_save_way`, `f_item_use_by_date`) VALUES
(1, '牛丼', 500, '牛肉の上にご飯を盛り付け、特製の甘辛いタレで味付けした日本の定番料理。', 506.9, 20.3, 9.5, 1.1, 0.9, '牛肉、玉ねぎ、醤油、砂糖、酒、みりんなど', '冷蔵保存', '3日'),
(2, 'ステーキ', 800, '高級肉を使ったジューシーなステーキ。', 517.3, 19.8, 9.5, 0.0, 0.9, '牛肉、塩、胡椒など', '冷蔵保存', '3日'),
(3, 'とんかつ', 800, '豚肉をパン粉で衣をつけて揚げた、ボリューム満点の日本の定番料理。', 482.1, 20.7, 20.0, 0.0, 0.9, '豚肉、パン粉、卵、小麦粉など', '冷蔵保存', '3日'),
(4, '豚キムチ', 800, '豚肉とキムチを炒めた、ピリ辛の韓国風料理。', 313.1, 10.9, 4.8, 1.9, 0.7, '豚肉、キムチ、野菜、調味料など', '冷蔵保存', '3日'),
(5, '鶏の唐揚げ', 700, '鶏肉をからっと揚げた、日本の定番の鶏料理。', 393.5, 15.9, 9.6, 0.0, 0.6, '鶏肉、片栗粉、小麦粉、調味料など', '冷蔵保存', '3日'),
(6, '鶏肉の照り焼き', 700, '鶏肉を特製の照り焼きソースで味付けして焼いた日本の料理。', 406.7, 15.4, 10.3, 0.0, 1.0, '鶏肉、照り焼きのたれ、調味料など', '冷蔵保存', '3日'),
(7, '鮭の塩焼き', 700, '塩をまぶして焼き上げた、鮭の香ばしい風味が楽しめる料理。', 397.4, 19.5, 10.4, 0.0, 0.6, '鮭、塩、胡椒など', '冷蔵保存', '3日'),
(8, 'まぐろの刺身', 800, '新鮮なまぐろを薄く切って盛り付けた、日本の代表的な刺身料理。', 300.0, 20.0, 5.2, 0.0, 0.6, 'まぐろ、調味料など', '冷蔵保存', '3日'),
(9, 'オムレツ', 600, '卵をふわふわに焼いた、具材を入れた洋風の料理。', 289.9, 15.5, 19.5, 0.6, 1.3, '卵、野菜、調味料など', '冷蔵保存', '3日'),
(10, 'パンケーキ', 900, 'モチモチとした生地で焼いた、ふわふわの厚焼きパンケーキ。', 302.0, 5.6, 9.7, 0.8, 0.7, '小麦粉、卵、砂糖、牛乳など', '冷蔵保存', '3日'),
(11, 'サンドイッチ', 600, 'パンに具材を挟んで作った、手軽に楽しめる軽食の料理。', 411.5, 10.2, 15.2, 1.6, 0.7, 'パン、ハム、チーズ、野菜、ソースなど', '冷蔵保存', '2日'),
(12, 'ラーメン', 800, '中華麺をスープで煮込み、具材をのせた日本の人気麺料理。', 582.1, 10.6, 20.1, 2.0, 1.8, '麺、スープ、チャーシュー、メンマなど', '冷蔵保存', '2日'),
(13, 'グリルチキン', 900, '鶏肉をグリルで焼いた、ヘルシーな料理。', 303.2, 26.0, 9.9, 1.2, 0.9, '鶏肉、調味料など', '冷蔵保存', '2日'),
(14, 'ペペロンチーノ', 800, 'イタリア料理の一つで、シンプルながらも大胆な味わいが特徴のパスタ料理', 401.1, 10.2, 14.9, 1.8, 0.6, 'パスタ、ソース、チーズなど', '冷蔵保存', '2日'),
(15, '野菜炒め', 800, '野菜を炒めて味付けした、ヘルシーな中華料理。', 209.2, 5.4, 9.8, 3.9, 1.2, '野菜、調味料など', '冷蔵保存', '2日'),
(16, 'グリーンサラダ', 500, '新鮮な野菜を使ったサラダで、さっぱりとしたドレッシングが特徴の料理。', 86.8, 3.2, 5.4, 2.1, 0.4, '野菜、ドレッシングなど', '冷蔵保存', '1日'),
(17, 'チョコレートケーキ', 800, '濃厚なチョコレートの味わいが楽しめる、甘いケーキの一種。', 416.3, 4.8, 19.5, 1.8, 0.5, 'チョコレート、小麦粉、卵、砂糖など', '冷暗所保存', '3日'),
(18, 'フルーツパフェ', 900, 'カットフルーツやアイスクリームを層にして盛り付けた、華やかなデザート。', 503.9, 5.2, 10.2, 2.6, 0.7, 'フルーツ、アイスクリーム、グラノーラなど', '冷蔵保存', '1日'),
(19, 'うどん', 500, '太い麺を使った日本の麺料理で、温かい出汁に入れていただく。', 405.7, 8.3, 2.0, 1.9, 0.7, '小麦粉、水、塩など', '冷蔵保存', '2日'),
(20, 'カレーライス', 800, 'スパイスの効いたルーで作った、日本の定番カレー料理。', 614.2, 9.7, 19.7, 2.7, 1.7, '米、肉、野菜、カレーソースなど', '冷蔵保存', '2日'),
(21, 'シーザーサラダ', 500, 'ロメインレタスをベースにした、具材とドレッシングが絶妙なバランスのサラダ。', 318.6, 5.2, 14.6, 3.0, 0.9, '野菜、チキン、ドレッシングなど', '冷蔵保存', '1日'),
(22, 'グリークサラダ', 500, 'ギリシャ料理のサラダで、フェタチーズやオリーブを使った味わい深い料理。', 230.3, 4.7, 10.0, 3.1, 1.1, '野菜、オリーブオイル、チーズなど', '冷蔵保存', '1日'),
(23, 'みそ汁', 200, '日本の代表的な汁物料理で、みそを溶かしたスープに具材を入れて煮込む。', 106.9, 4.8, 3.2, 1.3, 1.1, '豆みそ、野菜、魚、出汁など', '冷蔵保存', '1日'),
(24, 'トマトスープ', 300, 'トマトをベースにしたスープで、野菜やハーブの風味が効いた料理。', 149.3, 2.6, 4.8, 2.2, 1.1, 'トマト、野菜、調味料など', '冷蔵保存', '1日'),
(25, '枝豆', 200, '大豆の若い実を茹でたり焼いたりして食べる、日本の定番おつまみ。', 130.6, 9.9, 4.8, 5.2, 0.8, '枝豆、塩など', '冷凍保存', '1か月'),
(26, '砂肝', 600, '鶏の内臓の一部で、焼いたり炒めたりして食べる日本のおつまみ。', 181.4, 9.5, 14.7, 0.6, 1.3, '鶏の砂肝、調味料など', '冷蔵保存', '2日'),
(27, '寿司', 1000, '日本の代表的な海鮮料理で、酢飯に生魚や具材をのせた料理。', 211.0, 4.8, 4.7, 1.2, 0.8, '寿司飯、魚、野菜など', '冷蔵保存', '1日'),
(28, '炒飯', 700, '具材を炒めたご飯を焼いて作る、中華料理の一種。', 406.4, 9.8, 9.8, 2.0, 2.3, 'ご飯、肉、野菜、調味料など', '冷蔵保存', '2日'),
(29, 'しゃぶしゃぶ', 1000, '薄く切った肉を湯にくぐらせて食べる、日本の鍋料理。', 296.9, 15.1, 4.7, 2.1, 1.0, '肉、野菜、しゃぶしゃぶのたれなど', '冷蔵保存', '1日'),
(30, 'キムチ鍋', 1000, '韓国の代表的な鍋料理で、キムチをベースにした辛味のある料理。', 247.2, 9.8, 4.5, 2.8, 2.0, '豚肉、キムチ、野菜、調味料など', '冷蔵保存', '1日'),
(31, 'フライドチキン', 800, '鶏肉を衣で包み、揚げたり焼いたりして作る、外はサクサク中はジューシーな料理。', 298.0, 15.0, 20.1, 0.8, 0.6, '鶏肉、小麦粉、調味料など', '冷蔵保存', '2日'),
(32, 'エビフライ', 900, 'エビを衣で包み、揚げたり焼いたりして作る、プリプリとした食感が楽しい料理。', 267.3, 10.3, 9.6, 1.1, 1.0, 'エビ、小麦粉、パン粉など', '冷蔵保存', '2日'),
(33, 'グリルサーモン', 900, '鮭をグリルで焼いて作る、身がふっくらとした健康的な料理。', 361.0, 20.2, 14.7, 2.1, 1.2, 'サーモン、調味料など', '冷蔵保存', '2日'),
(34, 'シーフードパスタ', 900, '海鮮の具材を使ったパスタで、トマトソースやクリームソースが絡み合った一品。', 387.4, 14.5, 9.7, 3.2, 1.6, 'パスタ、魚介類、野菜、調味料など', '冷蔵保存', '1日'),
(35, '麻婆豆腐', 800, '豆腐を具材として使った、中華料理の一種で、ピリ辛の麻婆ソースが特徴。', 309.6, 9.9, 15.0, 3.3, 0.6, '豆腐、肉、野菜、麻婆ソースなど', '冷蔵保存', '1日'),
(36, '春巻き', 600, '野菜や肉を包んで揚げたり焼いたりして作る、アジア料理の一つ。', 193.6, 5.4, 10.0, 1.9, 0.9, '野菜、肉、春巻きの皮など', '冷蔵保存', '1日'),
(37, 'ピザ', 1200, '生地にソースやチーズをのせ、具材をトッピングして焼いた、イタリア発祥の料理。', 304.0, 9.7, 14.5, 1.8, 1.3, 'ピザ生地、チーズ、トッピングなど', '冷凍保存', '1ヶ月'),
(38, 'カルボナーラ', 1000, '豪快な味わいと濃厚なソースが特徴的で、パスタ好きにはたまらない一品。', 393.6, 14.9, 9.5, 3.0, 1.9, 'パスタ、ソース、チーズなど', '常温保存', '1年'),
(39, 'てんぷら', 900, '野菜や魚などを衣で包んで揚げた、日本の揚げ物料理。', 251.2, 10.2, 10.2, 1.2, 1.1, '野菜、エビ、小麦粉など', '冷蔵保存', '1日'),
(40, 'すき焼き', 1000, '牛肉や野菜を甘辛いたれで煮込んで食べる、日本の鍋料理。', 358.3, 19.6, 10.0, 2.1, 1.7, '牛肉、野菜、たれなど', '冷蔵保存', '1日'),
(41, 'ビビンバ', 1200, '韓国料理の一種で、ご飯の上に野菜や肉、卵などをのせて混ぜ合わせて食べる。', 310.6, 9.8, 9.9, 3.1, 2.3, 'ご飯、野菜、調味料など', '冷蔵保存', '1日'),
(42, 'カルビチム', 1800, '韓国料理の一種で、甘辛いソースで味付けされた牛肉を炒めて食べる。', 416.9, 15.3, 19.9, 1.9, 0.9, '牛肉、野菜、チムジルソースなど', '冷蔵保存', '1日'),
(43, 'ハンバーガー', 800, 'パティを挟んだサンドイッチで、肉や野菜、ソースが組み合わさったアメリカンな料理。', 492.2, 20.2, 24.6, 2.9, 2.0, 'パティ、バンズ、野菜など', '常温保存', '1日'),
(44, 'フライドポテト', 500, 'じゃがいもを揚げたり焼いたりして作る、サクサクとした食感が楽しいおつまみ', 282.7, 4.9, 14.7, 1.8, 1.2, 'じゃがいも、油など', '常温保存', '2日'),
(45, '焼き魚弁当', 800, '鮮魚を焼いた弁当で、栄養豊富な魚の旨味を楽しめる健康的なお弁当。', 454.9, 19.8, 9.5, 2.7, 0.9, '魚、ご飯、野菜など', '冷蔵保存', '1日'),
(46, 'シーチキン弁当', 1000, 'シーチキンを使ったお弁当で、ヘルシーな低カロリーの食材を使用したお弁当。', 507.4, 24.9, 15.3, 1.8, 2.2, 'チキン、ご飯、野菜など', '冷蔵保存', '1日'),
(47, '鶏モモのやきとり', 200, '鶏肉を串に刺して焼いた日本の屋台料理で、香ばしくジューシーな味わいが特徴。', 367.3, 14.6, 10.4, 1.8, 1.0, '鶏肉、たれ、野菜など', '冷蔵保存', '1日'),
(48, 'アジの刺身', 900, '生の魚を薄く切った料理で、新鮮な魚の旨味を楽しめる日本料理の一つ。', 308.1, 14.5, 4.6, 0.7, 1.1, '生魚、ご飯、野菜など', '冷蔵保存', '当日中'),
(49, 'くるみパン', 700, 'くるみの香ばしい香りと、ほんのりと甘みのある生地が特徴的。', 415.7, 9.7, 19.8, 2.7, 1.3, 'ピザ生地、チーズ、トッピングなど', '冷凍保存', '1ヶ月'),
(50, 'クロワッサン', 700, 'バターを多く使用し、生地を何層にも折り重ねて焼き上げることで、軽くて香ばしい外側と、ふんわりとした内側が特徴的。', 339.7, 5.1, 9.8, 4.1, 0.8, 'パスタ、ソース、野菜など', '常温保存', '1年'),
(51, '野菜カレー', 1000, '野菜をたっぷりと使ったヘルシーなカレーで、ヴィーガンやヘルシー志向の方に人気。', 290.7, 5.0, 10.4, 3.8, 1.2, '野菜、ルー、ご飯など', '冷蔵保存', '1日'),
(52, '豆腐ハンバーグ', 1000, '豆腐をベースにしたヘルシーなハンバーグで、低カロリーで栄養豊富な一品。', 262.1, 10.1, 4.8, 1.9, 0.8, '豆腐、野菜、調味料など', '冷蔵保存', '1日'),
(53, 'キヌアサラダ', 500, 'キヌアを使ったヘルシーなサラダで、栄養豊富なキヌアが主役の一品。', 369.2, 10.3, 14.8, 5.2, 0.6, 'キヌア、野菜、ドレッシングなど', '冷蔵保存', '2日'),
(54, 'アボカドトースト', 600, 'アボカドをのせたヘルシーなトーストで、栄養豊富なアボカドが絶品の一品。', 287.0, 4.8, 14.6, 6.9, 0.9, 'アボカド、トースト、野菜など', '冷蔵保存', '1日'),
(55, 'サラダチキン', 700, 'グリルやオーブンで焼いた', 184.6, 19.9, 4.6, 0.0, 1.1, '鶏肉、調味料など', '冷蔵保存', '2日'),
(56, 'カット野菜', 400, 'さまざまな種類の野菜を切った状態で提供される商品で、手軽に野菜を摂取できる便利な食材。', 36.4, 1.6, 0.4, 2.9, 0.6, '野菜（人参、キュウリ、ブロッコリーなど）', '冷蔵保存', '3日');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_item_allergens`
--

CREATE TABLE `t_item_allergens` (
  `f_item_id` int(11) NOT NULL,
  `f_item_allergen_wheat` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_egg` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_milk` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_soba` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_shrimp` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_clab` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_peanut` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_pork` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_chicken` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_beef` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_salmon` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_mackerel` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_soy` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_aquid` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_yamaimo` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_orange` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_sesame` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_cashew_nuts` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_abalone` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_ikura` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_kiwi` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_banana` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_peaches` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_apple` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_walnut` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_matsutake` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_gelatin` tinyint(1) NOT NULL DEFAULT 0,
  `f_item_allergen_almond` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_item_allergens`
--

INSERT INTO `t_item_allergens` (`f_item_id`, `f_item_allergen_wheat`, `f_item_allergen_egg`, `f_item_allergen_milk`, `f_item_allergen_soba`, `f_item_allergen_shrimp`, `f_item_allergen_clab`, `f_item_allergen_peanut`, `f_item_allergen_pork`, `f_item_allergen_chicken`, `f_item_allergen_beef`, `f_item_allergen_salmon`, `f_item_allergen_mackerel`, `f_item_allergen_soy`, `f_item_allergen_aquid`, `f_item_allergen_yamaimo`, `f_item_allergen_orange`, `f_item_allergen_sesame`, `f_item_allergen_cashew_nuts`, `f_item_allergen_abalone`, `f_item_allergen_ikura`, `f_item_allergen_kiwi`, `f_item_allergen_banana`, `f_item_allergen_peaches`, `f_item_allergen_apple`, `f_item_allergen_walnut`, `f_item_allergen_matsutake`, `f_item_allergen_gelatin`, `f_item_allergen_almond`) VALUES
(1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0),
(2, 1, 1, 1, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 1, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 1, 1, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(13, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(17, 1, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(18, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(19, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(26, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(27, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(28, 1, 1, 0, 0, 1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(29, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(30, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(31, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(32, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(33, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(34, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(35, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(36, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(37, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(38, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(39, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(40, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(41, 0, 1, 0, 1, 1, 1, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(42, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(43, 1, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(44, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(45, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(46, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(47, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(48, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(49, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0),
(50, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(51, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(52, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(53, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(54, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(55, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(56, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `t_item_genre`
--

CREATE TABLE `t_item_genre` (
  `f_item_genre_id` int(11) NOT NULL,
  `f_item_genre_name` varchar(31) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_item_genre`
--

INSERT INTO `t_item_genre` (`f_item_genre_id`, `f_item_genre_name`) VALUES
(1, '朝食'),
(2, '昼食'),
(3, '夕食'),
(4, '肉'),
(5, '魚介'),
(6, '野菜'),
(7, '卵'),
(8, 'ご飯'),
(9, 'パン'),
(10, '麺'),
(11, 'スープ'),
(12, '鍋'),
(13, '揚げ物'),
(14, 'デザート'),
(15, '和食'),
(16, '洋食'),
(17, '中華'),
(18, '弁当'),
(19, 'ダイエット');

-- --------------------------------------------------------

--
-- テーブルの構造 `t_item_reveiw`
--

CREATE TABLE `t_item_reveiw` (
  `f_reveiw_date` datetime NOT NULL,
  `f_item_id` int(11) NOT NULL,
  `f_user_id` int(11) NOT NULL,
  `f_reveiw_point` int(11) NOT NULL,
  `f_reveiw` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `t_item_types`
--

CREATE TABLE `t_item_types` (
  `f_item_id` int(11) NOT NULL,
  `f_item_genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `t_item_types`
--

INSERT INTO `t_item_types` (`f_item_id`, `f_item_genre_id`) VALUES
(1, 2),
(1, 4),
(1, 8),
(1, 15),
(2, 3),
(2, 4),
(2, 16),
(3, 3),
(3, 4),
(3, 13),
(3, 16),
(4, 3),
(4, 4),
(5, 3),
(5, 4),
(5, 13),
(5, 15),
(6, 3),
(6, 4),
(6, 15),
(7, 1),
(7, 5),
(7, 15),
(8, 3),
(8, 5),
(8, 15),
(9, 1),
(9, 7),
(9, 16),
(10, 1),
(10, 9),
(10, 16),
(11, 1),
(11, 9),
(11, 16),
(12, 3),
(12, 10),
(12, 15),
(13, 3),
(13, 4),
(13, 16),
(14, 2),
(14, 10),
(14, 16),
(15, 3),
(15, 6),
(16, 6),
(17, 14),
(18, 14),
(19, 10),
(19, 15),
(20, 8),
(21, 6),
(22, 6),
(23, 1),
(23, 11),
(23, 15),
(24, 11),
(25, 6),
(26, 4),
(27, 5),
(27, 8),
(27, 15),
(28, 8),
(28, 17),
(29, 3),
(29, 4),
(29, 12),
(29, 15),
(30, 12),
(31, 3),
(31, 4),
(32, 3),
(32, 5),
(32, 15),
(33, 1),
(33, 5),
(33, 15),
(34, 3),
(34, 5),
(34, 16),
(35, 3),
(35, 17),
(36, 2),
(36, 3),
(36, 4),
(36, 17),
(37, 3),
(37, 16),
(38, 2),
(38, 10),
(38, 16),
(39, 3),
(39, 13),
(40, 3),
(40, 4),
(40, 6),
(40, 12),
(40, 15),
(41, 2),
(41, 3),
(41, 8),
(42, 3),
(42, 4),
(43, 2),
(43, 4),
(43, 16),
(44, 19),
(45, 2),
(45, 5),
(45, 15),
(45, 19),
(46, 2),
(46, 5),
(46, 18),
(47, 3),
(47, 15),
(48, 3),
(48, 5),
(48, 15),
(49, 1),
(49, 2),
(49, 3),
(49, 9),
(50, 1),
(50, 2),
(50, 3),
(50, 9),
(51, 2),
(51, 3),
(51, 6),
(51, 16),
(52, 6),
(53, 1),
(53, 2),
(53, 6),
(53, 19),
(54, 1),
(54, 6),
(54, 9),
(54, 16),
(55, 1),
(55, 2),
(55, 4),
(55, 6),
(55, 16),
(56, 1),
(56, 2),
(56, 6),
(56, 19);

-- --------------------------------------------------------

--
-- テーブルの構造 `t_users`
--

CREATE TABLE `t_users` (
  `f_user_id` int(11) NOT NULL,
  `f_user_name` varchar(31) NOT NULL,
  `f_user_nick_name` varchar(31) NOT NULL,
  `f_user_gender` int(2) DEFAULT NULL,
  `f_user_age` int(11) DEFAULT NULL,
  `f_user_address` varchar(255) DEFAULT NULL,
  `f_user_job` varchar(255) DEFAULT NULL,
  `f_user_email` varchar(255) NOT NULL,
  `f_user_password` varchar(255) NOT NULL,
  `f_user_credit` varchar(255) DEFAULT NULL,
  `f_user_point` int(11) NOT NULL DEFAULT 0,
  `f_user_hight` int(11) DEFAULT NULL,
  `f_user_weight` int(11) DEFAULT NULL,
  `f_delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- ビュー用の代替構造 `v_item_genre`
-- (実際のビューを参照するには下にあります)
--
CREATE TABLE `v_item_genre` (
`item_id` int(11)
,`item_name` varchar(25)
,`genre_id` int(11)
,`genre_name` varchar(31)
);

-- --------------------------------------------------------

--
-- ビュー用の構造 `v_item_genre`
--
DROP TABLE IF EXISTS `v_item_genre`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_item_genre`  AS SELECT `item`.`f_item_id` AS `item_id`, `item`.`f_item_name` AS `item_name`, `type`.`f_item_genre_id` AS `genre_id`, `genre`.`f_item_genre_name` AS `genre_name` FROM ((`t_items` `item` join `t_item_types` `type` on(`item`.`f_item_id` = `type`.`f_item_id`)) join `t_item_genre` `genre` on(`type`.`f_item_genre_id` = `genre`.`f_item_genre_id`)) ORDER BY `item`.`f_item_id` ASC, `type`.`f_item_genre_id` ASC ;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `t_buy_history`
--
ALTER TABLE `t_buy_history`
  ADD PRIMARY KEY (`f_buy_history_date`,`f_user_id`,`f_item_id`),
  ADD KEY `f_item_id` (`f_item_id`),
  ADD KEY `f_user_id` (`f_user_id`);

--
-- テーブルのインデックス `t_intakes`
--
ALTER TABLE `t_intakes`
  ADD PRIMARY KEY (`f_user_id`,`f_intake_date`);

--
-- テーブルのインデックス `t_items`
--
ALTER TABLE `t_items`
  ADD PRIMARY KEY (`f_item_id`);

--
-- テーブルのインデックス `t_item_allergens`
--
ALTER TABLE `t_item_allergens`
  ADD PRIMARY KEY (`f_item_id`);

--
-- テーブルのインデックス `t_item_genre`
--
ALTER TABLE `t_item_genre`
  ADD PRIMARY KEY (`f_item_genre_id`);

--
-- テーブルのインデックス `t_item_reveiw`
--
ALTER TABLE `t_item_reveiw`
  ADD PRIMARY KEY (`f_reveiw_date`,`f_item_id`,`f_user_id`),
  ADD KEY `f_item_id` (`f_item_id`),
  ADD KEY `f_user_id` (`f_user_id`);

--
-- テーブルのインデックス `t_item_types`
--
ALTER TABLE `t_item_types`
  ADD PRIMARY KEY (`f_item_id`,`f_item_genre_id`),
  ADD KEY `f_item_genre_id` (`f_item_genre_id`);

--
-- テーブルのインデックス `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`f_user_id`);

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `t_buy_history`
--
ALTER TABLE `t_buy_history`
  ADD CONSTRAINT `t_buy_history_ibfk_1` FOREIGN KEY (`f_item_id`) REFERENCES `t_items` (`f_item_id`),
  ADD CONSTRAINT `t_buy_history_ibfk_2` FOREIGN KEY (`f_user_id`) REFERENCES `t_users` (`f_user_id`);

--
-- テーブルの制約 `t_intakes`
--
ALTER TABLE `t_intakes`
  ADD CONSTRAINT `t_intakes_ibfk_1` FOREIGN KEY (`f_user_id`) REFERENCES `t_users` (`f_user_id`);

--
-- テーブルの制約 `t_item_allergens`
--
ALTER TABLE `t_item_allergens`
  ADD CONSTRAINT `t_item_allergens_ibfk_1` FOREIGN KEY (`f_item_id`) REFERENCES `t_items` (`f_item_id`);

--
-- テーブルの制約 `t_item_reveiw`
--
ALTER TABLE `t_item_reveiw`
  ADD CONSTRAINT `t_item_reveiw_ibfk_1` FOREIGN KEY (`f_item_id`) REFERENCES `t_items` (`f_item_id`),
  ADD CONSTRAINT `t_item_reveiw_ibfk_2` FOREIGN KEY (`f_user_id`) REFERENCES `t_users` (`f_user_id`);

--
-- テーブルの制約 `t_item_types`
--
ALTER TABLE `t_item_types`
  ADD CONSTRAINT `t_item_types_ibfk_1` FOREIGN KEY (`f_item_id`) REFERENCES `t_items` (`f_item_id`),
  ADD CONSTRAINT `t_item_types_ibfk_2` FOREIGN KEY (`f_item_genre_id`) REFERENCES `t_item_genre` (`f_item_genre_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
