-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3307
-- 生成日時: 2025-03-27 13:42:04
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
-- テーブルの構造 `gs_bm_table`
--

CREATE TABLE `gs_bm_table` (
  `id` int(12) NOT NULL,
  `name` varchar(64) NOT NULL,
  `url` text NOT NULL,
  `comment` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `gs_bm_table`
--

INSERT INTO `gs_bm_table` (`id`, `name`, `url`, `comment`, `date`) VALUES
(5, 'SUPER☆GiRLS', 'https://www.youtube.com/watch?v=YRNt9hNJFRY&list=RDWK9vnRjhS1U&index=15', 'めっちゃかわいい', '2024-12-16 23:59:36'),
(6, '私立恵比寿中学', 'https://www.youtube.com/watch?v=qSA2Lu7E9hI&list=RDWK9vnRjhS1U&index=18', 'ひなたがかっこいい', '2024-12-17 00:12:04'),
(14, 'ONE LOVE ONE HEART', 'https://www.youtube.com/watch?v=OJ6JJDO6Qks&list=RDOJ6JJDO6Qks&start_radio=1', 'いいね', '2024-12-26 20:56:26'),
(15, 'ONE LOVE ONE HEART', 'https://www.youtube.com/watch?v=OJ6JJDO6Qks&list=RDOJ6JJDO6Qks&start_radio=1', '2', '2024-12-26 20:59:11'),
(16, 'ONE LOVE ONE HEART', 'https://www.youtube.com/watch?v=xX6bHsgxy_M&list=RDxX6bHsgxy_M&start_radio=1', 'テスト', '2025-01-10 01:45:55');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `gs_bm_table`
--
ALTER TABLE `gs_bm_table`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `gs_bm_table`
--
ALTER TABLE `gs_bm_table`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
