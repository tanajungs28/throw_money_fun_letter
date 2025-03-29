-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3307
-- 生成日時: 2025-03-27 13:41:42
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `user_db_class`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `event_list`
--

CREATE TABLE `event_list` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_day` date NOT NULL,
  `twitter_post` int(11) NOT NULL,
  `hashtag` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `event_list`
--

INSERT INTO `event_list` (`id`, `group_id`, `event_name`, `event_day`, `twitter_post`, `hashtag`, `created_at`) VALUES
(1, 0, 'アイドルライブ', '2025-04-30', 0, '#アイドル最高', '2025-03-23 03:43:56'),
(4, 14, 'ふぁみえん', '2025-07-10', 0, 'ふぁみえん', '2025-03-25 12:53:57'),
(5, 14, '冬の大学芸会！！！', '2025-12-25', 0, '大学芸会', '2025-03-25 17:17:33'),
(6, 14, '秋ツアー＠東京', '2025-08-15', 1, '#エビ中秋ツアー', '2025-03-26 12:28:51'),
(7, 6, 'アリーナツアー＠横浜', '2025-06-17', 0, '#フルーツジッパー', '2025-03-23 09:29:58'),
(8, 13, 'リリイベ@豊洲ららぽーと', '2025-06-10', 0, '#リリイベ', '2025-03-23 09:32:09'),
(9, 12, '対バンライブwithまねきケチャ', '2025-04-17', 0, '#対バン', '2025-03-23 09:33:09'),
(10, 6, 'テストイベント', '2025-04-08', 0, 'テスト', '2025-03-23 11:14:03'),
(11, 6, 'TIF2025', '2025-08-02', 1, '#TIF2025', '2025-03-26 13:44:21'),
(12, 12, '単独ライブ＠ZEPP羽田', '2025-04-14', 0, 'きゃんちゅー単独', '2025-03-24 17:37:04'),
(13, 14, '秋ツアー＠沖縄', '2025-07-08', 1, '沖縄', '2025-03-25 12:32:55'),
(15, 13, 'TGC＠東京', '2025-05-28', 0, 'TGC', '2025-03-27 12:10:44'),
(16, 12, 'てすと', '2025-03-29', 1, 'てすと', '2025-03-27 12:15:40');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `event_list`
--
ALTER TABLE `event_list`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
