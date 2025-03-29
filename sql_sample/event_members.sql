-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3307
-- 生成日時: 2025-03-27 13:41:50
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
-- テーブルの構造 `event_members`
--

CREATE TABLE `event_members` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `event_members`
--

INSERT INTO `event_members` (`id`, `event_id`, `member_id`, `message`, `created_at`, `updated_at`) VALUES
(2, 7, 12, 'がんばります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 7, 13, 'がんばります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 10, 11, 'やっぱり出ます', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 10, 13, 'イベントに出たい！！！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 9, 36, '大きいイベント頑張ります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 9, 37, '大きいイベント頑張ります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 9, 38, '大きいイベント頑張ります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 9, 39, '大きいイベント頑張ります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 9, 40, '大きいイベント頑張ります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 9, 41, '大きいイベント頑張ります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 9, 42, '大きいイベント頑張ります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 11, 12, 'がんばります！！！！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 11, 13, 'がんばります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 11, 14, 'がんばります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 11, 15, 'がんばります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 11, 16, 'がんばります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 11, 17, 'がんばります！', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 5, 51, '出ます！！！', '2025-03-24 16:50:43', '2025-03-24 16:50:43'),
(25, 5, 52, '出ます！', '2025-03-24 16:50:43', '2025-03-24 16:50:43'),
(26, 5, 53, 'がんばります', '2025-03-24 17:07:12', '2025-03-24 17:07:12'),
(28, 6, 51, 'たのしむぞ', '2025-03-26 13:28:34', '2025-03-26 13:28:34'),
(29, 6, 52, 'たのしむぞ', '2025-03-26 13:28:34', '2025-03-26 13:28:34'),
(30, 6, 53, 'たのしむぞ', '2025-03-26 13:28:34', '2025-03-26 13:28:34'),
(31, 11, 11, 'がんばります！！！', '2025-03-26 14:44:44', '2025-03-26 14:44:44'),
(32, 8, 50, '桜庭はるかです！', '2025-03-26 15:49:13', '2025-03-26 15:49:13'),
(34, 15, 44, '', '2025-03-26 16:04:59', '2025-03-26 16:04:59'),
(35, 15, 45, '', '2025-03-26 16:04:59', '2025-03-26 16:04:59'),
(36, 15, 46, '', '2025-03-26 16:04:59', '2025-03-26 16:04:59'),
(37, 15, 47, '', '2025-03-26 16:04:59', '2025-03-26 16:04:59'),
(38, 15, 48, '', '2025-03-26 16:04:59', '2025-03-26 16:04:59'),
(39, 15, 49, '', '2025-03-26 16:04:59', '2025-03-26 16:04:59'),
(40, 15, 50, '', '2025-03-26 16:04:59', '2025-03-26 16:04:59'),
(41, 4, 59, 'gannbaru', '2025-03-26 17:32:34', '2025-03-26 17:32:34');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `event_members`
--
ALTER TABLE `event_members`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `event_members`
--
ALTER TABLE `event_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
