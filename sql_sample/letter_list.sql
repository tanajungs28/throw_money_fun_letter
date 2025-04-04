-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3307
-- 生成日時: 2025-03-27 13:42:24
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
-- テーブルの構造 `letter_list`
--

CREATE TABLE `letter_list` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `member_id` int(12) NOT NULL,
  `event_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `amount` int(12) NOT NULL,
  `status` varchar(64) NOT NULL,
  `release_status` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `letter_list`
--

INSERT INTO `letter_list` (`id`, `user_id`, `member_id`, `event_id`, `message`, `amount`, `status`, `release_status`, `created_at`) VALUES
(1, 1, 11, 0, 'テスト', 5100, 'open', '0', '2025-03-15 14:58:01'),
(2, 1, 11, 0, 'かわいい', 5100, '', '0', '2025-03-15 15:11:35'),
(3, 1, 11, 0, '', 10000, 'close', '0', '2025-03-15 15:11:55'),
(4, 1, 2, 0, 'イコラブ最高', 1000, 'open', '0', '2025-03-15 15:14:23'),
(5, 1, 2, 0, 'ひとみんさいこう！！！', 1000, 'open', '0', '2025-03-15 15:16:51'),
(6, 1, 2, 0, 'かわいい～', 1000, '', '0', '2025-03-15 15:19:17'),
(7, 1, 2, 0, '武道館でのライブ最高でした。高松さんのパフォーマンスの一つ一つが胸に刺さっています', 5100, 'open', '0', '2025-03-15 15:28:26'),
(8, 1, 2, 0, '最高！！！', 2200, 'close', '0', '2025-03-15 15:28:50'),
(9, 1, 2, 0, 'いいね', 5100, 'open', '0', '2025-03-15 15:29:06'),
(10, 1, 2, 0, '', 5100, 'open', '0', '2025-03-15 15:36:15'),
(11, 1, 12, 0, '鎮西さいこう！', 5100, 'open', '0', '2025-03-15 15:48:42'),
(12, 1, 1, 0, 'かわいい！', 5100, 'open', '0', '2025-03-16 04:55:24'),
(13, 1, 2, 0, '', 5100, 'open', '0', '2025-03-16 07:37:51'),
(14, 1, 2, 0, 'あ', 100, 'open', '0', '2025-03-16 07:50:13'),
(15, 1, 2, 0, 'a', 100, 'open', '0', '2025-03-16 07:51:28'),
(16, 1, 2, 0, 'a', 100, 'open', '0', '2025-03-16 07:51:37'),
(17, 1, 2, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:05:44'),
(18, 1, 2, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:10:08'),
(19, 1, 2, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:21:03'),
(20, 1, 2, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:24:18'),
(21, 1, 2, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:24:20'),
(22, 1, 2, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:24:27'),
(23, 1, 2, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:24:33'),
(24, 1, 2, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:24:36'),
(25, 1, 1, 0, 'いいね！', 100, 'close', '0', '2025-03-16 08:25:42'),
(26, 1, 1, 0, '最高！', 100, 'close', '0', '2025-03-16 08:27:47'),
(27, 1, 1, 0, '最高！', 100, 'close', '0', '2025-03-16 08:27:55'),
(28, 1, 1, 0, '最高！', 100, 'close', '0', '2025-03-16 08:28:07'),
(29, 1, 1, 0, 'たくさん送ります！', 5100, 'open', '0', '2025-03-16 08:38:06'),
(30, 1, 1, 0, 'たくさん送ります！', 100, 'open', '0', '2025-03-16 08:43:17'),
(31, 1, 1, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:43:38'),
(32, 1, 1, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:45:02'),
(33, 1, 1, 0, 'テスト', 100, 'open', '0', '2025-03-16 08:45:21'),
(34, 1, 1, 0, 'ないす！', 100, 'open', '0', '2025-03-16 09:21:58'),
(35, 1, 1, 0, 'あああ', 100, 'open', '0', '2025-03-16 09:30:18'),
(36, 1, 3, 0, '大谷さん最高', 2000, 'open', '0', '2025-03-16 12:21:51'),
(37, 1, 3, 0, 'めっちゃいいね！', 2900, 'open', '0', '2025-03-16 12:23:52'),
(38, 1, 3, 0, '大谷さん！', 3000, 'open', '0', '2025-03-16 12:39:05'),
(39, 1, 3, 0, 'たくさん送ります！', 5100, 'open', '0', '2025-03-16 12:40:00'),
(40, 1, 3, 0, 'たくさんおくる！', 5100, 'open', '0', '2025-03-16 12:42:42'),
(41, 1, 3, 0, '沢山送ります！', 9000, 'open', '0', '2025-03-16 12:43:20'),
(42, 1, 11, 0, '月足さん最高！', 2700, 'open', '0', '2025-03-16 12:46:04'),
(43, 1, 11, 0, '月足さいこう～', 3300, 'open', '0', '2025-03-16 12:46:45'),
(44, 1, 5, 0, 'かわいい！', 4500, 'open', '0', '2025-03-16 12:47:58'),
(45, 1, 15, 0, 'まなさんかわいい', 3000, 'open', '0', '2025-03-16 12:53:09'),
(46, 1, 5, 0, 'おとしまさんかわいい', 5100, 'open', '0', '2025-03-16 12:57:47'),
(47, 1, 16, 0, 'かれんたんかわいい', 4000, 'open', '0', '2025-03-16 12:59:28'),
(48, 1, 16, 0, 'テスト', 5100, 'open', '0', '2025-03-16 13:08:30'),
(49, 1, 16, 0, 'テスト', 5100, 'open', '0', '2025-03-16 13:09:22'),
(51, 1, 17, 0, 'ノエル神', 3900, 'open', '0', '2025-03-16 13:19:29'),
(52, 1, 7, 0, 'たきわきしょうこ！', 2000, 'open', '0', '2025-03-16 13:28:00'),
(53, 1, 2, 0, 'memo', 6400, 'close', '0', '2025-03-16 13:33:42'),
(54, 1, 17, 0, 'ノエル様最高', 9000, 'close', '0', '2025-03-16 13:37:32'),
(55, 1, 2, 0, 'テスト', 3000, 'open', '0', '2025-03-16 15:25:47'),
(56, 1, 6, 0, 'きあらかわいい', 2200, 'open', '0', '2025-03-17 13:20:50'),
(57, 1, 6, 0, 'きあらちゃん', 500, 'open', '0', '2025-03-17 13:22:22'),
(58, 1, 6, 0, 'きあらちゃん', 2300, 'open', '0', '2025-03-17 13:22:47'),
(59, 1, 16, 0, 'テスト', 5100, 'close', '0', '2025-03-22 04:14:21'),
(60, 1, 16, 0, 'たくさん送ります！', 5100, 'close', '0', '2025-03-22 04:37:11'),
(61, 1, 16, 0, 'テスト', 10000, 'close', '0', '2025-03-22 04:42:09'),
(62, 2, 16, 0, 'test2のアカウントでレター送信', 3000, 'open', '0', '2025-03-22 05:29:48'),
(63, 2, 16, 0, 'テスト', 5100, 'open', '0', '2025-03-22 05:50:52'),
(64, 2, 16, 0, 'レター送信後にかれんたんのページに戻ってきたい', 5100, 'open', '0', '2025-03-22 05:54:52'),
(65, 2, 16, 0, 'aaa', 5100, 'open', '0', '2025-03-22 05:57:42'),
(66, 2, 15, 0, 'かわいい', 1900, 'open', '0', '2025-03-22 07:59:17'),
(67, 2, 15, 0, 'テスト', 5100, 'open', '0', '2025-03-22 08:07:38'),
(70, 2, 15, 0, 'いいいいいいいいいいいいいい', 100, 'open', 'completed', '2025-03-22 08:50:18'),
(72, 10, 14, 0, 'るなぴかわいい', 100, 'open', 'completed', '2025-03-22 13:01:37'),
(73, 10, 14, 0, 'kawaii', 10000, 'close', 'completed', '2025-03-22 13:02:27'),
(74, 1, 13, 0, 'X連携テスト', 100, 'open', 'completed', '2025-03-22 17:02:55'),
(75, 1, 13, 0, 'X連携テスト2', 100, 'open', 'completed', '2025-03-22 17:07:47'),
(76, 1, 13, 0, 'X連携テスト3', 100, 'open', 'completed', '2025-03-22 17:15:20'),
(77, 1, 13, 0, 'X連携テスト4', 100, 'open', 'completed', '2025-03-22 17:19:28'),
(78, 1, 13, 0, 'X連携テスト4', 100, 'open', 'completed', '2025-03-22 17:26:00'),
(79, 1, 13, 0, 'X連携テスト5', 100, 'open', 'completed', '2025-03-22 17:28:10'),
(80, 1, 13, 0, 'X連携テスト6', 5100, 'open', 'completed', '2025-03-22 17:30:54'),
(81, 1, 13, 0, 'X連携テスト7', 100, 'open', 'completed', '2025-03-22 17:32:50'),
(82, 1, 13, 0, 'X連携テスト8', 100, 'open', 'completed', '2025-03-22 17:36:23'),
(83, 1, 13, 0, 'X連携テスト9', 100, 'open', 'completed', '2025-03-22 17:39:39'),
(84, 1, 13, 0, 'X連携テスト10', 100, 'open', 'completed', '2025-03-22 17:42:46'),
(85, 1, 13, 0, 'X連携テスト11', 5100, 'open', 'completed', '2025-03-22 17:45:46'),
(86, 1, 13, 0, 'X連携テスト、ハッシュタグが付くかの確認', 100, 'open', 'completed', '2025-03-23 02:48:03'),
(87, 1, 13, 0, 'X連携テスト12', 100, 'open', 'completed', '2025-03-23 03:00:08'),
(88, 11, 36, 0, 'テスト投稿', 3400, 'open', 'completed', '2025-03-23 14:42:06'),
(89, 11, 36, 0, 'テスト投稿2', 5100, 'open', 'completed', '2025-03-23 14:51:56'),
(90, 11, 36, 0, 'テスト投稿3', 100, 'open', 'completed', '2025-03-23 14:56:53'),
(91, 11, 36, 11, 'テスト投稿4', 5500, 'close', 'completed', '2025-03-24 17:35:02'),
(92, 11, 13, 11, 'テスト投稿', 100, 'open', 'completed', '2025-03-24 17:32:44'),
(93, 11, 13, 11, 'テスト投稿', 5100, 'open', 'completed', '2025-03-24 17:06:38'),
(94, 12, 51, 5, 'テスト', 100, 'open', 'completed', '2025-03-25 13:02:29'),
(99, 12, 51, 5, 'テスト2', 0, 'open', 'completed', '2025-03-25 14:04:28'),
(100, NULL, 51, 5, 'テスト3', 0, 'open', 'completed', '2025-03-25 14:37:37'),
(101, NULL, 51, 5, 'テスト4', 5100, 'open', 'completed', '2025-03-25 14:39:40'),
(102, NULL, 51, 5, 'テスト5100円', 5100, 'open', 'completed', '2025-03-25 14:40:50'),
(103, NULL, 51, 5, 'テスト5　3000円', 3000, 'open', 'completed', '2025-03-25 14:56:11'),
(104, NULL, 51, 5, 'テスト6　非公開　3000円', 3000, 'close', 'completed', '2025-03-25 14:56:55'),
(105, 11, 12, 7, 'テスト', 0, 'open', 'completed', '2025-03-26 14:47:04'),
(106, 11, 50, 8, 'たくさん送ります！', 0, 'open', 'completed', '2025-03-26 15:03:03'),
(107, 11, 44, 15, 'テスト', 0, 'close', 'completed', '2025-03-26 15:06:04');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `letter_list`
--
ALTER TABLE `letter_list`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `letter_list`
--
ALTER TABLE `letter_list`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
