-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:3307
-- 生成日時: 2025-03-27 13:42:31
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
-- テーブルの構造 `member_list`
--

CREATE TABLE `member_list` (
  `id` int(12) NOT NULL,
  `group_id` int(12) NOT NULL,
  `member_name` varchar(256) NOT NULL,
  `member_image` varchar(256) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `member_list`
--

INSERT INTO `member_list` (`id`, `group_id`, `member_name`, `member_image`, `content`) VALUES
(1, 5, '佐々木舞香', 'img/67d51eedd2542.jpg', 'うたがうまい人'),
(2, 5, '高松瞳', 'img/67d521a379780.jpg', 'センターの人'),
(3, 5, '大谷映美里', 'img/67d53573efc00.jpg', 'おおたにさん'),
(4, 5, '大場 花菜', 'img/67d538ba13f74.jpg', 'おおばさん'),
(5, 5, '音嶋 莉沙', 'img/67d53915d5b0c.jpg', 'おとしまさん'),
(6, 5, '齋藤 樹愛羅', 'img/67d53957ba4eb.jpg', 'きあらちゃん'),
(7, 5, '瀧脇 笙古', 'img/67d5399ca27e2.jpg', 'たきわきしょうこ'),
(8, 5, '野口 衣織', 'img/67d539e792d58.jpg', 'のぐちさん'),
(9, 5, '諸橋 沙夏', 'img/67d53a45881d5.jpg', 'さなさん'),
(10, 5, '山本 杏奈', 'img/67d53a98588ce.jpg', 'やまもとさん'),
(11, 6, '月足天音', 'uploads/67e540c00cbfd_member05-img01.jpg', '元HKT48のメンバー'),
(12, 6, '鎮西 寿々歌', 'uploads/67e40b6d87cc8_member05-img01.jpg', 'ちんぜい'),
(13, 6, '櫻井 優衣', 'img/67d53c709029b.jpg', 'さくらい'),
(14, 6, '仲川 瑠夏', 'img/67d53cb018b4f.jpg', 'るなぴ'),
(15, 6, '真中 まな', 'img/67d53d9abe1ec.jpg', 'まなさん'),
(16, 6, '松本 かれん', 'img/67d53de0bfe1b.jpg', 'かれんたん'),
(17, 6, '早瀬 ノエル', 'img/67d53e3068d68.jpg', 'ノエル様'),
(18, 7, '藤咲 碧羽', 'img/67dffedfd783e.jpg', 'メインボーカル'),
(19, 7, 'イーチ', 'img/67dfff1b18bf0.jpg', 'ボーカル'),
(20, 7, '矢嶋 由菜', 'img/67dfff41d46b5.jpg', 'ボブ担当'),
(21, 7, '佐々木 杏莉', 'img/67dfff72f050a.jpg', 'ダンスメンバー'),
(22, 7, '飯塚 瑠乃', 'img/67dfff9d0f7b8.jpg', 'ダンスメンバー'),
(23, 7, '洸瑛', 'img/67dfffd7e52b9.jpg', 'メンズメンバー'),
(24, 7, '久昌 歩夢', 'img/67e000028e17d.jpg', 'メンズメンバー'),
(25, 7, '笹原 遼雅', 'img/67e00026948fe.jpg', 'メンズメンバー'),
(26, 7, '相原 一心', 'img/67e000489579e.jpg', 'メンズメンバー'),
(27, 8, 'カワイレナ', 'img/67e000bb9e8cf.jpg', 'かわい最強！'),
(28, 8, '佐山すずか', 'img/67e000ef26510.jpg', 'すずか'),
(29, 8, '三好佑季', 'img/67e0011c19ec0.jpg', 'ゆうき'),
(30, 8, '茉城奈那', 'img/67e001452b0dd.jpg', 'なな'),
(31, 8, '宮代柚花', 'img/67e00172d03ed.jpg', 'ゆずか'),
(32, 9, '秋吉 優花', 'img/67e001e3a41cc.jpg', ' 根気とやる気は負けません。秋吉優花です。歌とお芝居が大好きです。エンタメに関わる活動をずっとしていたいです。好きな事を発信していたら、福岡でラジオナビゲーターや音楽番組のMCの活動をさせていただけるようになりました。これからも素敵な出会いがあると良いなあ。秋吉のページを開いてくれたあなたにどこかで、出会えますように。'),
(33, 9, '渕上 舞', 'img/67e0022aca27c.jpg', ' 今年でアイドル歴13年目を迎え、劇場公演の出演回数は先日900回を達成しました。スポーツ観戦(特にホークス)が大好きです！大好きな地元・福岡やHKT48のことをたくさんの方に知っていただけるよう頑張ります。今年はお芝居や雑誌の活動にも挑戦したいです。 各SNSもぜひチェックよろしくお願いします！'),
(34, 9, '今村 麻莉愛', 'img/67e0025feb478.jpg', ' ダンスをしている時が1番楽しく、パフォーマンスが大好きで、ステージの中で誰よりも輝けるように頑張っています！また、演技も楽しくて今後頑張りたいと思っています。勉強中です。他にもバラエティなど色んなことに挑戦したいです！できる事全部頑張ります！応援よろしくお願いします。ぜひ会いに来てください！'),
(35, 11, '久木田 菜々夏', 'img/67e002db49d8f.jpg', '2021年からアイドルユニット「衛星とカラテア」メンバーとして活動スタート。 タレント、インフルエンサーと幅広く活躍中。 TikTokでの「#埼玉の彼女」動画は大バズりしフォロワー数は25万人を突破。'),
(36, 12, '立花琴未', 'img/67e00449b799d.jpg', ''),
(37, 12, '村川緋杏', 'img/67e0048d69ab7.jpg', ''),
(38, 12, '桐原美月', 'img/67e004c575fb3.jpg', ''),
(39, 12, '福山梨乃', 'img/67e004fe36ac8.jpg', ''),
(40, 12, '南なつ', 'img/67e0052d7323c.jpg', ''),
(41, 12, '小川奈々子', 'img/67e005577c5e9.jpg', ''),
(42, 12, '宮野静', 'img/67e005860860f.jpg', ''),
(43, 13, '古澤里紗', 'img/67e00625754a9.jpg', ''),
(44, 13, '佐野愛花', 'img/67e006545ac81.jpg', ''),
(45, 13, '板倉可奈', 'img/67e0068478b1f.jpg', ''),
(46, 13, '増田彩乃', 'img/67e006ba06831.jpg', ''),
(47, 13, '川本 笑瑠', 'img/67e006f32a18e.jpg', ''),
(48, 13, '梅田みゆ', 'img/67e0072787fee.jpg', ''),
(49, 13, '真鍋凪咲', 'img/67e00758c81f4.jpg', ''),
(50, 13, '桜庭遥花', 'img/67e00789e8984.jpg', ''),
(51, 14, '真山 りか', 'img/67e0080a08deb.jpg', ''),
(52, 14, '安本 彩花', 'img/67e00844d1b9a.jpg', ''),
(53, 14, '小林歌穂', 'img/67e0087c33a00.jpg', ''),
(54, 14, '中山莉子', 'img/67e008aa7cd14.jpg', ''),
(55, 14, '桜木心菜', 'img/67e008d4cc3eb.jpg', ''),
(58, 14, '桜井えま', 'img/67e0099f23d72.jpg', ''),
(59, 14, '中村悠菜', 'img/67e009fc3e8f0.jpg', ''),
(60, 12, 'テスト', 'img/67e40df4cb12c.jpg', 'テスト'),
(61, 12, 'テスト234', 'img/67e40e4b2d54d.jpg', 'テスト2'),
(62, 0, 'テスト', 'img/67e41057b25bb.jpg', 'テスト'),
(63, 0, 'テスト', 'img/67e410d55d1de.jpg', 'テスト');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `member_list`
--
ALTER TABLE `member_list`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `member_list`
--
ALTER TABLE `member_list`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
