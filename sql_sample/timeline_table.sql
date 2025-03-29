-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3307
-- 生成日時: 2025-03-27 13:42:37
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
-- テーブルの構造 `timeline_table`
--

CREATE TABLE `timeline_table` (
  `id` int(11) NOT NULL,
  `uname` varchar(64) NOT NULL,
  `tweet` text NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `timeline_table`
--

INSERT INTO `timeline_table` (`id`, `uname`, `tweet`, `time`) VALUES
(1, '', 'あ', '2024-12-26 23:31:28'),
(3, '', 'う', '2024-12-28 15:31:10'),
(4, '', 'えええええ', '0000-00-00 00:00:00'),
(13, '', '今削除できる気がする', '2024-12-30 02:49:50'),
(14, '', 'えから編集できました', '2024-12-30 23:36:57');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `timeline_table`
--
ALTER TABLE `timeline_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `timeline_table`
--
ALTER TABLE `timeline_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
