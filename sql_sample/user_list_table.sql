-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3307
-- 生成日時: 2025-03-27 13:42:45
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
-- テーブルの構造 `user_list_table`
--

CREATE TABLE `user_list_table` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `lid` varchar(128) NOT NULL,
  `lpw` varchar(64) NOT NULL,
  `birthday` text NOT NULL,
  `gender` varchar(64) NOT NULL,
  `prefectures` varchar(64) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `kanri_flg` int(1) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `user_list_table`
--

INSERT INTO `user_list_table` (`id`, `name`, `lid`, `lpw`, `birthday`, `gender`, `prefectures`, `created_at`, `kanri_flg`, `role`) VALUES
(1, 'テスト１管理者', 'test1', 'test1', '', '', '', NULL, 99, '0'),
(2, 'テスト2一般', 'test2', 'test2', '', '', '', NULL, 0, '0'),
(3, 'テスト３', 'test3', 'test3', '', '', '', NULL, 0, '0'),
(4, '田中純', 'tanaka', 'tanaka', '', '', '', NULL, 0, '0'),
(6, 'テストユーザー', 'testuser', 'testuser', '', '', '', NULL, 0, '0'),
(7, '田中太郎', 'tanaka@tanaka', '1111', '', '', '', NULL, 0, '0'),
(8, '大谷翔平', 'test@test', '1111', '', '', '', NULL, 0, '0'),
(9, '鈴木一郎', 'suzuki@suzuki', '1111', '1992-06-13', '男性', '東京都', NULL, 0, '0'),
(11, 'アソビシステム', 'asobi@asobi', '1111', '2009-01-23', '男性', '東京都', NULL, 1, 'admin'),
(12, 'スターダスト', 'stardust@stardust', '1111', '2025-03-03', '男性', '東京都', NULL, 1, 'admin'),
(13, 'test4', 'test4@test4', 'test4', '', '', '', '2025-03-26 01:07:13', 99, '');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `user_list_table`
--
ALTER TABLE `user_list_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `user_list_table`
--
ALTER TABLE `user_list_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
