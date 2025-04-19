-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 Nis 2025, 22:13:40
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `beta`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `alert`
--

CREATE TABLE `alert` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `post_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `alert`
--

INSERT INTO `alert` (`id`, `text`, `post_at`) VALUES
(1, 'qweqwewqe', 1744657367);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(2, 'test', '2'),
(3, 'test', '2231231'),
(4, '213213', '12321'),
(5, '22', '22'),
(6, '22', '22'),
(8, 'test', '2');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `channels`
--

CREATE TABLE `channels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `channels`
--

INSERT INTO `channels` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Haberler', 'Haberler', '2024-11-03 09:18:58'),
(2, 'Haber ekle', 'Haber ekle', '2024-11-03 09:19:53'),
(3, 'Duyurular', 'Duyurular', '2024-11-03 09:20:02'),
(4, 'Katagoriler', 'Katagoriler', '2024-11-03 09:20:10'),
(5, 'Katagori ekle', 'Katagori ekle', '2024-11-03 09:20:16'),
(6, 'Rank ekleme ', 'Rank ayarlama ve düzenleme ', '2024-11-03 13:30:42'),
(7, 'Panel log', 'Panel log', '2025-04-14 19:13:50'),
(8, 'Kullanıcı listesi', 'Kullanıcı listesi', '2025-04-14 19:15:43'),
(9, 'Onay bekleyen haberler', 'Onay bekleyen haberler', '2025-04-14 19:16:07'),
(10, 'Site ayarı', 'Site ayarı', '2025-04-14 19:18:53'),
(11, 'Panel izinleri', 'Panel izinleri', '2025-04-14 19:19:05'),
(12, 'Yetkili rank ayarlama', 'Yetkili rank ayarlama', '2025-04-14 19:25:28');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `look` text NOT NULL,
  `post_at` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `news` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`id`, `author`, `look`, `post_at`, `comment`, `news`) VALUES
(106, 155, 'hasan26', 1702190423, 'test', 1),
(107, 155, 'hasan26', 1702333212, 'test', 2),
(108, 1, 'Kamobbah', 1702190423, 'test', 1),
(109, 155, 'hasan26', 1702335804, 'test 23', 2),
(110, 155, 'hasan26', 1702337541, 'test', 3),
(111, 155, 'hasan26', 1723046658, 'test', 3),
(112, 155, 'hasan26', 1733594392, '44', 22),
(113, 155, 'hasan26', 1733597331, '@Hasan26', 22),
(114, 155, 'hasan26', 1739544578, 'test', 28),
(115, 155, 'hasan26', 1744656124, 'www', 29);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `validity` tinyint(1) NOT NULL DEFAULT 1,
  `for_the` varchar(10) NOT NULL,
  `place` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `events`
--

INSERT INTO `events` (`id`, `title`, `text`, `validity`, `for_the`, `place`) VALUES
(11, 'test', 'test2', 1, '2023-12-16', 'test3'),
(12, 'test 1', 'test 2', 1, '2023-12-25', 'https://getbootstrap.com/');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `flux`
--

CREATE TABLE `flux` (
  `id` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `victim` int(11) NOT NULL,
  `post_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `flux`
--

INSERT INTO `flux` (`id`, `action`, `author`, `victim`, `post_at`) VALUES
(27, 1, 155, 0, 1702190321),
(28, 3, 155, 155, 1702190324),
(29, 10, 155, 0, 1702190458),
(30, 1, 155, 0, 1702331699),
(31, 3, 155, 155, 1702331705),
(32, 2, 155, 155, 1702332781),
(33, 16, 155, 0, 1702336571),
(34, 16, 155, 0, 1702336617),
(35, 1, 155, 0, 1702337488),
(36, 3, 155, 155, 1702337511),
(37, 2, 155, 155, 1702337519),
(38, 10, 155, 0, 1723480664),
(39, 11, 155, 0, 1730125468),
(40, 10, 155, 0, 1730125591),
(41, 11, 155, 0, 1730125625),
(42, 10, 155, 0, 1730125707),
(43, 11, 155, 0, 1730126372),
(44, 11, 155, 0, 1730126551),
(45, 11, 155, 0, 1730126554),
(46, 10, 155, 0, 1730126558),
(47, 10, 155, 0, 1730126573),
(48, 10, 155, 0, 1730126579),
(49, 10, 155, 0, 1730126622),
(50, 10, 155, 0, 1730126630),
(51, 10, 155, 0, 1730126718),
(52, 11, 155, 0, 1730126719),
(53, 11, 155, 0, 1730126722),
(54, 11, 155, 0, 1730126723),
(55, 10, 155, 0, 1730126727),
(56, 10, 155, 0, 1730126732),
(57, 11, 155, 0, 1730126844),
(58, 11, 155, 0, 1730126868),
(59, 10, 155, 0, 1730126876),
(60, 10, 155, 0, 1730126959),
(61, 10, 155, 0, 1730126970),
(62, 11, 155, 0, 1730126972),
(63, 11, 155, 0, 1730126987),
(64, 11, 155, 0, 1730126989),
(65, 11, 155, 0, 1730127060),
(66, 11, 155, 0, 1730127062),
(67, 10, 155, 0, 1730127075),
(68, 10, 155, 0, 1730127080),
(69, 10, 155, 0, 1730127086),
(70, 10, 155, 0, 1730127175),
(71, 10, 155, 0, 1730127177),
(72, 10, 155, 0, 1730127179),
(73, 10, 155, 0, 1730127181),
(74, 10, 155, 0, 1730127186),
(75, 10, 155, 0, 1730127188),
(76, 10, 155, 0, 1730127190),
(77, 10, 155, 0, 1730127192),
(78, 10, 155, 0, 1730127194),
(79, 10, 155, 0, 1730127197),
(80, 10, 155, 0, 1730127199),
(81, 10, 155, 0, 1730127202),
(82, 10, 155, 0, 1730127205),
(83, 10, 155, 0, 1730127208),
(84, 10, 155, 0, 1730127211),
(85, 10, 155, 0, 1730127214),
(86, 10, 155, 0, 1730127217),
(87, 10, 155, 0, 1730127220),
(88, 10, 155, 0, 1730127223),
(89, 10, 155, 0, 1730127226),
(90, 10, 155, 0, 1730127229),
(91, 10, 155, 0, 1730127232),
(92, 10, 155, 0, 1730127235),
(93, 10, 155, 0, 1730127238),
(94, 10, 155, 0, 1730127241),
(95, 10, 155, 0, 1730127244),
(96, 10, 155, 0, 1730127247),
(97, 10, 155, 0, 1730127250),
(98, 11, 155, 0, 1730127255),
(99, 11, 155, 0, 1730127260),
(100, 11, 155, 0, 1730127266),
(101, 11, 155, 0, 1730127271),
(102, 10, 155, 0, 1730127275),
(103, 10, 155, 0, 1730127280),
(104, 10, 155, 0, 1730127286),
(105, 10, 155, 0, 1730127292),
(106, 10, 155, 0, 1730127298),
(107, 10, 155, 0, 1730127304),
(108, 10, 155, 0, 1730127310),
(109, 10, 155, 0, 1730127316),
(110, 10, 155, 0, 1730127322),
(111, 10, 155, 0, 1730127328),
(112, 10, 155, 0, 1730127334),
(113, 10, 155, 0, 1730127340),
(114, 10, 155, 0, 1730127346),
(115, 10, 155, 0, 1730127352),
(116, 10, 155, 0, 1730127358),
(117, 10, 155, 0, 1730127364),
(118, 10, 155, 0, 1730127370),
(119, 10, 155, 0, 1730127376),
(120, 10, 155, 0, 1730127381),
(121, 10, 155, 0, 1730127383),
(122, 11, 155, 0, 1730127387),
(123, 11, 155, 0, 1730127393),
(124, 11, 155, 0, 1730127395),
(125, 11, 155, 0, 1730127400),
(126, 11, 155, 0, 1730127406),
(127, 11, 155, 0, 1730127411),
(128, 11, 155, 0, 1730127416),
(129, 11, 155, 0, 1730127422),
(130, 11, 155, 0, 1730127427),
(131, 11, 155, 0, 1730127433),
(132, 11, 155, 0, 1730127438),
(133, 11, 155, 0, 1730127444),
(134, 11, 155, 0, 1730127449),
(135, 11, 155, 0, 1730127454),
(136, 11, 155, 0, 1730127460),
(137, 10, 155, 0, 1730127465),
(138, 10, 155, 0, 1730127488),
(139, 10, 155, 0, 1730127494),
(140, 10, 155, 0, 1730127516),
(141, 11, 155, 0, 1730127587),
(142, 11, 155, 0, 1730127630),
(143, 11, 155, 0, 1730127634),
(144, 11, 155, 0, 1730127706),
(145, 11, 155, 0, 1730127750),
(146, 11, 155, 0, 1730127754),
(147, 10, 155, 0, 1730127758),
(148, 11, 155, 0, 1730127773),
(149, 11, 155, 0, 1730127778),
(150, 10, 155, 0, 1730127781),
(151, 10, 155, 0, 1730127858),
(152, 11, 155, 0, 1730127860);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(85) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `username`, `action`, `details`, `created_at`) VALUES
(1, 155, NULL, 'Duyuru Silme', 'Kullanıcı 155 mevcut duyuruyu sildi.', '2024-10-28 15:31:25'),
(2, 155, 'Hasan26', 'Duyuru Ekleme', 'Kullanıcı 155 (Hasan26) yeni duyuru ekledi: 123123', '2024-10-28 15:33:27'),
(3, 155, 'Hasan26', 'Duyuru Silme', 'Kullanıcı İD:155 (Hasan26) mevcut duyuruyu sildi.', '2024-10-28 15:34:19'),
(4, 155, 'Hasan26', 'Duyuru Ekleme', 'Kullanıcı İD:155 (Hasan26) yeni duyuru ekledi: 21312', '2024-10-28 15:34:36'),
(5, 155, 'Hasan26', 'Duyuru Güncelleme', 'Kullanıcı İD:155 (Hasan26) duyuruyu güncelledi: 21312111', '2024-10-28 15:34:38'),
(6, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: hasan log test', '2024-10-29 09:29:22'),
(7, 155, 'Hasan26', 'Haber güncellendi', 'Güncellenen haber başlığı: hasan log testwwwwwwwwwwwwwwwwwwwwwwwwwwwww', '2024-10-29 10:40:32'),
(8, 155, 'Hasan26', 'Haber güncellendi', 'Güncellenen haber başlığı: hasan log testwwwwwwwwwwwwwwwwwwwwwwwwwwwww', '2024-10-29 10:42:59'),
(9, 155, 'Hasan26', 'Haber güncellendi', 'Güncellenen haber başlığı: hasan log testwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqweqwe', '2024-10-29 10:43:12'),
(10, 155, 'Hasan26', 'Haber güncellendi', 'Güncellenen haber ID: 15, Yeni başlık: hasan log testwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqweqwe', '2024-10-29 10:44:17'),
(11, 155, 'Hasan26', 'Haber güncellendi', 'Güncellenen haber ID: 15, Yeni başlık: hasan log testwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqweqwe', '2024-10-29 10:44:56'),
(12, 155, 'Hasan26', 'Haber güncellendi', 'Güncellenen haber ID: 15, Yeni başlık: hasan log testwwwwwwwwwwwwwwwwwwwwwwwwwwwwwqweqwe', '2024-10-29 10:45:07'),
(13, 155, 'Hasan26', 'Haber güncellendi', 'Güncellenen haber ID: 4, Yeni başlık: wwwzxczxc', '2024-10-29 11:07:29'),
(14, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: sadasda', '2024-10-29 11:07:51'),
(15, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: asdasd', '2024-10-29 11:10:39'),
(16, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: asdasdasd', '2024-10-29 11:11:03'),
(17, 155, 'Hasan26', 'Haber Sil', 'Haber silindi: asdasd', '2024-10-29 13:12:47'),
(18, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: sadasd', '2024-10-29 11:13:32'),
(19, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: qweqwe', '2024-10-29 11:15:09'),
(20, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: weqrwerw', '2024-10-29 11:17:28'),
(21, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: asdad', '2024-10-29 13:18:32'),
(22, 155, 'Hasan26', 'Haber güncellendi', 'Güncellenen haber ID: 22, Yeni başlık: asdad333', '2024-10-29 13:21:15'),
(23, 155, 'Hasan26', 'Rank güncellendi', 'Rank güncellendi: yönetici 1', '2024-11-03 11:53:59'),
(24, 155, 'Hasan26', 'Rank güncellendi', 'Rank güncellendi: yönetici 1', '2024-11-03 11:55:03'),
(25, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 11:56:24'),
(26, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 5', '2024-11-03 11:56:36'),
(27, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 2', '2024-11-03 11:57:20'),
(28, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: <br />\r\n<b>Warning</b>:  Undefined array key ', '2024-11-03 11:59:55'),
(29, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:00:57'),
(30, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 7', '2024-11-03 12:02:16'),
(31, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 12:02:25'),
(32, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:06:12'),
(33, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 12:06:54'),
(34, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:07:05'),
(35, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 12:07:22'),
(36, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:08:51'),
(37, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 12:09:00'),
(38, 155, 'Hasan26', 'Rank seviyesi sıfırlandı', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:09:07'),
(39, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:09:14'),
(40, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:09:25'),
(41, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 12:11:54'),
(42, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:15:08'),
(43, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 12:15:35'),
(44, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:15:39'),
(45, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 12:15:43'),
(46, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 12:18:06'),
(47, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:26:36'),
(48, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:27:03'),
(49, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 12:27:07'),
(50, 155, 'Hasan26', 'Haber silindi', 'Haber silindi başlıgı: sadasd', '2024-11-03 12:28:04'),
(51, 155, 'Hasan26', 'Rank silindi', 'Rank silindi: admin', '2024-11-03 12:44:21'),
(52, 155, 'Hasan26', 'Rank silindi', 'Rank silindi: Yeni admin', '2024-11-03 13:05:45'),
(53, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 155 için yeni seviye: 8', '2024-11-03 13:37:14'),
(54, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 1', '2024-11-03 15:25:08'),
(55, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 15:25:35'),
(56, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 0', '2024-11-03 15:26:11'),
(57, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 15:26:17'),
(58, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 15:26:21'),
(59, 155, 'Hasan26', 'Rank seviyesi sıfırlandı', 'Kullanıcı ID: 1 için yeni seviye: 0', '2024-11-03 15:26:26'),
(60, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 15:28:46'),
(61, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 15:29:03'),
(62, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 15:30:46'),
(63, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 15:31:08'),
(64, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 15:32:06'),
(65, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 15:33:00'),
(66, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 15:33:54'),
(67, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 15:34:05'),
(68, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 15:35:20'),
(69, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 15:38:08'),
(70, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 15:38:30'),
(71, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 15:38:40'),
(72, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 15:40:52'),
(73, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 15:42:35'),
(74, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 7', '2024-11-03 15:47:58'),
(75, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 0', '2024-11-03 15:48:02'),
(76, 155, 'Hasan26', 'Rank seviyesi sıfırlandı', 'Kullanıcı ID: 1 için yeni seviye: 0', '2024-11-03 15:48:18'),
(77, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 16:16:22'),
(78, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 16:16:25'),
(79, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 10', '2024-11-03 16:18:46'),
(80, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 16:20:16'),
(81, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 16:20:31'),
(82, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 16:21:39'),
(83, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 11', '2024-11-03 16:25:36'),
(84, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2024-11-03 16:27:49'),
(85, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 9', '2024-11-03 16:27:52'),
(86, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 0', '2024-11-03 16:41:28'),
(87, 1, 'admin', 'Ayar Güncelleme', 'site_description güncellendi | Eski Değer: Hasanx Fansite Sistemi | Yeni Değer: Hasanx Fansite Sistemissss', '2024-11-12 11:54:07'),
(88, 155, 'Hasan26', 'Ayar Güncelleme', 'site_name güncellendi | Eski Değer: Hasanxw | Yeni Değer: Hasanxwwww', '2024-11-12 11:58:08'),
(89, 155, 'Hasan26', 'Ayar Güncelleme', 'site_keywords güncellendi | Eski Değer: Hasanx,test | Yeni Değer: Hasanx,test,www', '2024-11-12 11:58:31'),
(90, 1, 'admin', 'Ayar Güncelleme', 'site_name güncellendi | Eski Değer: Hasanxwwww | Yeni Değer: Hasanx2', '2024-11-12 12:05:52'),
(91, 1, 'admin', 'Ayar Güncelleme', 'site_description güncellendi | Eski Değer: Hasanx Fansite Sistemissss | Yeni Değer: asdsad', '2024-11-12 12:06:21'),
(92, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 9', '2024-11-12 12:09:14'),
(93, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 0', '2024-11-12 12:09:18'),
(94, 155, 'Hasan26', 'Rank seviyesi sıfırlandı', 'Kullanıcı ID: 1 için yeni seviye: 0', '2024-11-12 12:09:33'),
(95, 155, 'Hasan26', 'Rank seviyesi sıfırlandı', 'Kullanıcı ID: 1 için yeni seviye: 0', '2024-11-12 12:09:36'),
(96, 155, 'Hasan26', 'Duyuru Güncelleme', 'Kullanıcı İD:155 (Hasan26) duyuruyu güncelledi: 555', '2024-12-06 16:45:13'),
(97, 1, 'admin', 'Ayar Güncelleme', 'site_name güncellendi | Eski Değer: Hasanx2 | Yeni Değer: Hasanx22', '2024-12-06 16:45:39'),
(98, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: tedt', '2024-12-06 16:46:48'),
(99, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: test', '2025-02-07 20:31:43'),
(100, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 8', '2025-02-14 14:45:43'),
(101, 155, 'Hasan26', 'Rank seviyesi güncellendi', 'Kullanıcı ID: 1 için yeni seviye: 0', '2025-02-14 14:46:07'),
(102, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: test', '2025-02-14 15:02:12'),
(103, 155, 'Hasan26', 'Haber yayınlandı', 'Yayınlanan haber ID: 29', '2025-02-14 15:16:39'),
(104, 155, 'Hasan26', 'Haber eklendi', 'Eklenen haber başlığı: test', '2025-04-14 18:45:27'),
(105, 155, 'Hasan26', 'Haber yayınlandı', 'Yayınlanan haber ID: 30', '2025-04-14 18:46:02'),
(106, 155, 'Hasan26', 'Duyuru Güncelleme', 'Kullanıcı İD:155 (Hasan26) duyuruyu güncelledi: qweqwewqe', '2025-04-14 19:02:47');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `author` varchar(11) NOT NULL,
  `post_at` int(11) NOT NULL,
  `validity` int(1) DEFAULT 0,
  `background` text DEFAULT NULL,
  `corrector` int(11) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `news`
--

INSERT INTO `news` (`id`, `title`, `descr`, `text`, `author`, `post_at`, `validity`, `background`, `corrector`, `category_id`) VALUES
(20, 'qweqwe', 'qweqwe', 'qweqwe', '155', 1730207708, 1, 'https://habbo-stories-content.s3.amazonaws.com/diy%2Ftrain-robbery-short-story-competition%2Fhhes-1408557629997-d%40vid!!!mor-cibolatucson.gif', 0, 5),
(21, 'weqrwerw', 'asd', 'wwerw', '155', 2024, 1, 'https://habbo-stories-content.s3.amazonaws.com/diy%2Ftrain-robbery-short-story-competition%2Fhhes-1408557629997-d%40vid!!!mor-cibolatucson.gif', 0, 5),
(22, 'asdad333', 'asdsad', 'asdsad', '155', 1730207911, 1, 'https://habbo-stories-content.s3.amazonaws.com/diy%2Ftrain-robbery-short-story-competition%2Fhhes-1408557629997-d%40vid!!!mor-cibolatucson.gif', 155, 4),
(23, 'tedt', '232', '22', '155', 1733503608, 1, 'https://pbs.twimg.com/profile_images/1619432144652075009/PeVzvHrs_400x400.png', 0, 6),
(24, 'qweqwe', 'qweqwe', 'qweqwe', '155', 1730207708, 1, 'https://habbo-stories-content.s3.amazonaws.com/diy%2Ftrain-robbery-short-story-competition%2Fhhes-1408557629997-d%40vid!!!mor-cibolatucson.gif', 0, 5),
(25, 'weqrwerw', 'asd', 'wwerw', '155', 2024, 1, 'https://habbo-stories-content.s3.amazonaws.com/diy%2Ftrain-robbery-short-story-competition%2Fhhes-1408557629997-d%40vid!!!mor-cibolatucson.gif', 0, 5),
(26, 'asdad333', 'asdsad', 'asdsad', '155', 1730207911, 1, 'https://habbo-stories-content.s3.amazonaws.com/diy%2Ftrain-robbery-short-story-competition%2Fhhes-1408557629997-d%40vid!!!mor-cibolatucson.gif', 155, 4),
(27, 'tedt', '232', '22', '155', 1733503608, 1, 'https://pbs.twimg.com/profile_images/1619432144652075009/PeVzvHrs_400x400.png', 0, 6),
(28, 'test', 'acıkas', 'qweqwe', '155', 1738960303, 1, 'https://images.habbo.com/habbo-web/america/tr/assets/images/app_summary_image-1200x628.3bc8bbb2.png', 0, 5),
(29, 'test', 'test', 'test', '155', 1739545332, 1, 'https://banner2.cleanpng.com/20180628/iqk/kisspng-habbo-landscaping-chandelier-vegetation-landscape-rafflesia-5b3474d2eade30.996898131530164434962.jpg', 0, 2),
(30, 'test', 'test', 'qweqweqweqwqwe', '155', 1744656327, 1, 'https://content.puhekupla.com/uploads/2022/05/lpromo_summer18.png', 0, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rank`
--

CREATE TABLE `rank` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rank`
--

INSERT INTO `rank` (`id`, `name`, `description`, `level`) VALUES
(1, 'Normal User', 'Kullanıcı', 0),
(3, 'Kurucu', 'Kurucu', 11),
(4, 'Yönetici', 'yönetici', 10),
(6, 'Moderetör', 'moderatör', 9),
(7, 'Baş haberci', 'baş', 8),
(8, 'Haberci', 'haberci', 7);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rank_channel_permissions`
--

CREATE TABLE `rank_channel_permissions` (
  `id` int(11) NOT NULL,
  `rank_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `can_view` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rank_channel_permissions`
--

INSERT INTO `rank_channel_permissions` (`id`, `rank_id`, `channel_id`, `can_view`) VALUES
(1, 1, 1, 0),
(2, 1, 2, 0),
(3, 1, 3, 0),
(4, 1, 4, 0),
(5, 1, 5, 0),
(11, 3, 1, 1),
(12, 3, 2, 1),
(13, 3, 3, 1),
(14, 3, 4, 1),
(15, 3, 5, 1),
(16, 4, 1, 0),
(17, 4, 2, 0),
(18, 4, 3, 0),
(19, 4, 4, 0),
(20, 4, 5, 0),
(21, 1, 6, 0),
(22, 3, 6, 1),
(23, 4, 6, 0),
(24, 6, 1, 0),
(25, 6, 2, 0),
(26, 6, 3, 0),
(27, 6, 4, 0),
(28, 6, 5, 0),
(29, 6, 6, 0),
(30, 7, 1, 0),
(31, 7, 2, 0),
(32, 7, 3, 0),
(33, 7, 4, 0),
(34, 7, 5, 0),
(35, 7, 6, 0),
(36, 8, 1, 0),
(37, 8, 2, 0),
(38, 8, 3, 0),
(39, 8, 4, 0),
(40, 8, 5, 0),
(41, 8, 6, 0),
(42, 1, 7, 0),
(43, 1, 8, 0),
(44, 1, 9, 0),
(45, 1, 10, 0),
(46, 1, 11, 0),
(47, 3, 7, 1),
(48, 3, 8, 1),
(49, 3, 9, 1),
(50, 3, 10, 1),
(51, 3, 11, 1),
(52, 4, 7, 0),
(53, 4, 8, 0),
(54, 4, 9, 0),
(55, 4, 10, 0),
(56, 4, 11, 0),
(57, 6, 7, 0),
(58, 6, 8, 0),
(59, 6, 9, 0),
(60, 6, 10, 0),
(61, 6, 11, 0),
(62, 7, 7, 0),
(63, 7, 8, 0),
(64, 7, 9, 0),
(65, 7, 10, 0),
(66, 7, 11, 0),
(67, 8, 7, 0),
(68, 8, 8, 0),
(69, 8, 9, 0),
(70, 8, 10, 0),
(71, 8, 11, 0),
(72, 1, 12, 0),
(73, 3, 12, 1),
(74, 4, 12, 0),
(75, 6, 12, 0),
(76, 7, 12, 0),
(77, 8, 12, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'site_name', 'Hasanx22'),
(2, 'site_description', 'asdsad'),
(3, 'site_keywords', 'Hasanx,test,www'),
(4, 'site_info', 'Site acıklması alt kısım'),
(5, 'site_url', 'http://localhost/');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `staff` int(11) NOT NULL DEFAULT 0,
  `username` varchar(85) NOT NULL,
  `pass` text NOT NULL,
  `ip` varchar(25) NOT NULL,
  `look` text NOT NULL,
  `born` varchar(255) NOT NULL,
  `last` int(11) NOT NULL,
  `ban` int(11) NOT NULL DEFAULT 0,
  `ban_reason` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `staff`, `username`, `pass`, `ip`, `look`, `born`, `last`, `ban`, `ban_reason`) VALUES
(1, 0, 'Kamobbah', '57eb058f552475400965981def84465a9bfcb6fe', '154.68.48.172', 'ea-3484-0.cc-3360-110.wa-9073-92.hr-3322-49.lg-3202-1341-1408.hd-195-3.sh-3524-91-92.ch-3438-92-1408.fa-3350-0', '', 1543437917, 0, 'Trop fort !'),
(155, 11, 'Hasan26', '47c36fbaac1694b8885ed1206fd72cc1bd5b1c67', '::1', 'hasan26', '1702190238', 1745092640, 0, NULL),
(156, 11, 'hasanx', '47c36fbaac1694b8885ed1206fd72cc1bd5b1c67', '::1', 'hasan26', '1745089211', 1745089214, 0, NULL);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `alert`
--
ALTER TABLE `alert`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `channels`
--
ALTER TABLE `channels`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `flux`
--
ALTER TABLE `flux`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Tablo için indeksler `rank`
--
ALTER TABLE `rank`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `level` (`level`);

--
-- Tablo için indeksler `rank_channel_permissions`
--
ALTER TABLE `rank_channel_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rank_id` (`rank_id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `alert`
--
ALTER TABLE `alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `channels`
--
ALTER TABLE `channels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Tablo için AUTO_INCREMENT değeri `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `flux`
--
ALTER TABLE `flux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- Tablo için AUTO_INCREMENT değeri `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- Tablo için AUTO_INCREMENT değeri `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `rank`
--
ALTER TABLE `rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `rank_channel_permissions`
--
ALTER TABLE `rank_channel_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Tablo kısıtlamaları `rank_channel_permissions`
--
ALTER TABLE `rank_channel_permissions`
  ADD CONSTRAINT `rank_channel_permissions_ibfk_1` FOREIGN KEY (`rank_id`) REFERENCES `rank` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
