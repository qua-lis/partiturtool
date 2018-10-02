-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. Okt 2016 um 16:09
-- Server-Version: 5.7.13-0ubuntu0.16.04.2
-- PHP-Version: 5.6.26-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `partitur`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t100_sys_dmversion`
--

DROP TABLE IF EXISTS `part_t100_sys_dmversion`;
CREATE TABLE `part_t100_sys_dmversion` (
  `dmversionsnr` double NOT NULL COMMENT 'aktuelle Datenmodell-Version, Primärschlüssel, immer höchste Version wird ausgewertet',
  `appversionsnr_min` double DEFAULT NULL COMMENT 'Minimale Version des Programms, die erforderlich ist',
  `dm_bem` varchar(200) DEFAULT NULL COMMENT 'Bemerkungen zur Datenmodell-Version',
  `zeitstempel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Zeitstempel'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Datenmodell-Version';

--
-- Daten für Tabelle `part_t100_sys_dmversion`
--

INSERT INTO `part_t100_sys_dmversion` (`dmversionsnr`, `appversionsnr_min`, `dm_bem`, `zeitstempel`) VALUES
(0.02, 0.15, 'Erweiterungen Aug/Sep 2013', '2014-10-01 13:24:33');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t110_sys_log`
--

DROP TABLE IF EXISTS `part_t110_sys_log`;
CREATE TABLE `part_t110_sys_log` (
  `sessionid` varchar(35) NOT NULL COMMENT 'ID der Session',
  `user_id` int(11) NOT NULL COMMENT 'eindeutige ID für jeden Anmeldenamen, - nicht angemeldet',
  `anmeldetyp` varchar(1) DEFAULT NULL COMMENT 'Typ: F-Fachverwalter/in, A-Admin, - undefiniert',
  `aktion_code` smallint(5) DEFAULT NULL COMMENT 'Code der protokollierten Aktion',
  `browser` varchar(100) DEFAULT NULL COMMENT 'Verwendeter Browser',
  `ipadresse` varchar(15) DEFAULT NULL COMMENT 'IP-Adresse',
  `logparam` varchar(100) DEFAULT NULL COMMENT 'weitere Parameter zur protokollierten Aktion',
  `zeitstempel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Zeitstempel'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Protokoll-Tabelle';

--
-- Daten für Tabelle `part_t110_sys_log`
--

INSERT INTO `part_t110_sys_log` (`sessionid`, `user_id`, `anmeldetyp`, `aktion_code`, `browser`, `ipadresse`, `logparam`, `zeitstempel`) VALUES
('97ddbffa3d51314bfde4b06e192785ee', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-01 13:24:51'),
('4058eea641236aa5d3a1f6b22e4bbbdd', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-01 13:25:21'),
('4058eea641236aa5d3a1f6b22e4bbbdd', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', '2', '2014-10-01 13:26:34'),
('ecbd804334c19cc90dc48515e8f2d9d2', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-01 15:05:47'),
('-', 0, '-', 1105, 'Mozilla/5.0 (X11; CrOS x86_64 5978.98.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120', '93.233.30.107', 'whupfeld', '2014-10-05 20:44:53'),
('2f9de0d7535ae2c6d7915ac208c12a22', 1, 'A', 1100, 'Mozilla/5.0 (X11; CrOS x86_64 5978.98.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120', '93.233.30.107', 'admin', '2014-10-05 20:45:08'),
('5e0ce9bcc2ba6b6c04236e5eedcf8282', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-06 08:20:09'),
('63d5aa3320bca80d933c3716be353c49', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-06 08:37:13'),
('354f011bc3dc3a9ecb4f46aa17739a49', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-06 08:40:45'),
('4f7c53429903b4037f5b50e7ed80a0d9', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-06 08:41:56'),
('e1716b2fccaa0027ce3c676b2101c4d7', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-06 08:42:07'),
('d089b45a271cac84b53cecaa5107e48c', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safa', '93.184.128.33', 'admin', '2014-10-06 08:43:26'),
('0acfc347b5a2d3e8d6709e6445a95bc8', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '93.184.128.33', 'admin', '2014-10-13 09:09:15'),
('97b3942a8edf2e73b6260d796854504e', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '93.184.128.33', 'admin', '2014-10-13 09:09:54'),
('41a03073c5c64c8eae6da68ca6ad5002', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '93.184.128.34', 'admin', '2014-10-20 09:27:31'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '93.184.128.34', 'whupfeld', '2014-10-20 09:29:52'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '93.184.128.34', 'whupfeld', '2014-10-20 09:29:57'),
('48df84ad0b4d3bc0814f9dbf4d095850', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '93.184.128.34', 'whupfeld', '2014-10-20 09:30:03'),
('4248ac40b0802bfc918079b74083e9c3', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '87.123.164.133', 'admin', '2014-10-23 15:51:41'),
('4248ac40b0802bfc918079b74083e9c3', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '87.123.164.133', '1', '2014-10-23 15:56:06'),
('4248ac40b0802bfc918079b74083e9c3', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '87.123.164.133', '3', '2014-10-23 15:56:56'),
('16729db7dbcd43d7395801880b99176b', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '87.123.164.133', 'admin', '2014-10-23 15:57:29'),
('32b0da919af66d8a42d398562e698f8f', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '87.123.164.133', 'fvma', '2014-10-23 15:57:51'),
('7ce40f5cce717019866b1f4e69ac53bb', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:32.0) Gecko/20100101 Firefox/32.0', '87.123.164.133', 'fvma', '2014-10-23 16:01:33'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '93.184.128.34', 'fvma', '2014-10-24 06:22:36'),
('511bb3fe8182c297c500502878f57a17', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', '93.184.128.34', 'fvma', '2014-10-24 06:22:49'),
('94bffb6dd322bc8b282be9b64fcec40f', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'fvma', '2014-10-24 11:07:23'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'fvma', '2014-10-24 11:27:11'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'fvma', '2014-10-24 11:27:23'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'fvma', '2014-10-24 11:35:43'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'fvma', '2014-10-24 11:35:59'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'fvma', '2014-10-24 11:36:20'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-24 11:36:44'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-24 11:36:53'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-24 11:37:02'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-24 11:37:11'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'admin', '2014-10-24 11:37:19'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-24 11:37:29'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'admin', '2014-10-24 11:37:48'),
('fb615be0ddf541e2e87731ed887d521d', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-24 11:37:55'),
('75b9bccb92cd6f8f78087c95f31bfde9', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-24 11:38:24'),
('d3bfb2e82e943d278af98eb000f19a62', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1', '93.233.37.72', 'whupfeld', '2014-10-26 19:26:34'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'admin', '2014-10-27 07:32:30'),
('3e20f72dd25bf39b074a91613b6efc47', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-27 07:32:39'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-27 07:36:40'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-27 07:37:14'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-27 07:41:39'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-27 07:41:42'),
('61dfd63e70beca3bba1f06a58d3101a3', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-27 07:41:47'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'walter', '2014-10-27 10:19:48'),
('1e0f378737f43458eb3f41e359af0254', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'whupfeld', '2014-10-27 10:19:58'),
('1e0f378737f43458eb3f41e359af0254', 2, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'Konf: stufe (7 DS)', '2014-10-27 10:23:24'),
('6f8fbd24b514d070f0288efe99566dc1', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'fvma', '2014-10-27 10:24:16'),
('6f8fbd24b514d070f0288efe99566dc1', 3, 'F', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'admin', '2014-10-27 10:30:48'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safa', '93.184.128.34', 'admin', '2014-10-27 10:30:55'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safa', '93.184.128.34', 'admin', '2014-11-03 12:49:09'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safa', '93.184.128.34', 'admin', '2014-11-03 12:49:12'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safa', '93.184.128.34', 'admin', '2014-11-03 12:49:18'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safa', '93.184.128.34', 'admin', '2014-11-03 12:49:22'),
('66dcb2bf89abbc14a542f35ed3888dcd', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safa', '93.184.128.34', 'whupfeld', '2014-11-03 12:49:32'),
('2a29141ba7aaa9a8c587b20a709c11ee', 2, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safa', '93.184.128.34', 'whupfeld', '2014-11-03 12:50:10'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safa', '93.184.128.34', 'fvwma', '2014-11-03 12:51:01'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safa', '93.184.128.34', 'fvwma', '2014-11-03 12:51:10'),
('-', 0, '-', 1105, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/53', '217.89.92.10', 'whupfeld', '2016-01-18 15:32:20'),
('-', 0, '-', 1105, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/53', '217.89.92.10', 'admin', '2016-01-18 15:32:29'),
('-', 0, '-', 1105, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/53', '217.89.92.10', 'admin', '2016-01-18 15:32:39'),
('3febbddf5214ae19124ff0f4bfe0533e', 1, 'A', 1100, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:43.0) Gecko/20100101 Firefox/43.0', '217.89.92.10', 'admin', '2016-01-18 15:34:52'),
('10142ac78500c9e4ce65f6071355aaaa', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.33', 'admin', '2016-01-19 10:20:00'),
('7f0a994b8c42079d9c6aca4667335cf1', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.33', 'admin', '2016-01-21 12:41:42'),
('9c017fa8725aac3e8f6b375b81bbbbff', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'admin', '2016-01-23 14:28:20'),
('9c017fa8725aac3e8f6b375b81bbbbff', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'Konf: fach (10 DS)', '2016-01-23 14:32:25'),
('9c017fa8725aac3e8f6b375b81bbbbff', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', '4', '2016-01-23 14:33:45'),
('9c017fa8725aac3e8f6b375b81bbbbff', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', '4', '2016-01-23 14:33:55'),
('9c017fa8725aac3e8f6b375b81bbbbff', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', '5', '2016-01-23 14:34:35'),
('9c017fa8725aac3e8f6b375b81bbbbff', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', '6', '2016-01-23 14:35:20'),
('9c017fa8725aac3e8f6b375b81bbbbff', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'Konf: textfeld (5 DS)', '2016-01-23 14:42:23'),
('1266c6ba88b193e3f4f2982fd969973d', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvbi', '2016-01-23 14:43:05'),
('64ba43f9ba523ed41e012fe1132a55b1', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'admin', '2016-01-23 14:49:35'),
('64ba43f9ba523ed41e012fe1132a55b1', 1, 'A', 3120, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'Konf: textfeld (ID: 1 )', '2016-01-23 14:50:09'),
('64ba43f9ba523ed41e012fe1132a55b1', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'Konf: textfeld (4 DS)', '2016-01-23 14:50:31'),
('ce7cd7c2b38a4701ab150936094b6a75', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvbi', '2016-01-23 14:52:23'),
('b7249cabb4b1610646ff1a38d787a229', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'admin', '2016-01-23 14:59:04'),
('b7249cabb4b1610646ff1a38d787a229', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'Konf: textfeld (4 DS)', '2016-01-23 14:59:46'),
('26693f89174db8913947147f38672078', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvbi', '2016-01-23 15:00:02'),
('6f4e89d7ff33667ae286389087f25fc3', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'admin', '2016-01-23 15:02:11'),
('6f4e89d7ff33667ae286389087f25fc3', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'Konf: textfeld (4 DS)', '2016-01-23 15:02:19'),
('684185d20449b72d1a6f5690c800f8af', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvbi', '2016-01-23 15:02:34'),
('deb18e18463dd57bf4a9e92545cae2ef', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'admin', '2016-01-23 15:08:23'),
('deb18e18463dd57bf4a9e92545cae2ef', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'Konf: textfeld (4 DS)', '2016-01-23 15:08:37'),
('14bcb104ebd9a170b065243a763e75bd', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvbi', '2016-01-23 15:08:56'),
('fb6f8a7e1f0637c43e7daa62230c6717', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvbi', '2016-01-23 19:45:00'),
('f7f774578c6f8165f4bab76180fc65e0', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvbi', '2016-01-23 19:45:51'),
('d8f954218b14ecb1a2cb516adbf09471', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvbi', '2016-01-23 19:48:31'),
('03eb5b4d20f43ee5bd869102208cc110', 5, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvch', '2016-01-23 19:49:07'),
('7d16cec8aa76f74ba7160e79a6cde9d6', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'admin', '2016-01-23 19:57:26'),
('7d16cec8aa76f74ba7160e79a6cde9d6', 1, 'A', 3310, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'Sitzung 14bcb104ebd9a170b065243a763e75bd, User: fvbi, Fach:Biologie', '2016-01-23 19:57:58'),
('47a4172b91ad8058b46a9e093e13c401', 6, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvph', '2016-01-23 23:02:50'),
('46586c930d0e6343be05e442b528fcf4', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'admin', '2016-01-23 23:14:22'),
('46586c930d0e6343be05e442b528fcf4', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', '3', '2016-01-23 23:17:04'),
('ea1d72ba2d9403b018c7c96b064d3b33', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvma', '2016-01-23 23:17:28'),
('a89376d4dc9a0a7093ce2970483f314a', 5, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvch', '2016-01-23 23:21:37'),
('06977eb3ca640e9664f74bb18344d779', 6, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.158.116', 'fvph', '2016-01-23 23:22:10'),
('bd5568d14b1a95399d340953b5ee774f', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'admin', '2016-01-25 13:05:56'),
('bd5568d14b1a95399d340953b5ee774f', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'Konf: fach (11 DS)', '2016-01-25 13:06:46'),
('bd5568d14b1a95399d340953b5ee774f', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'Konf: fach (11 DS)', '2016-01-25 13:06:56'),
('bd5568d14b1a95399d340953b5ee774f', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', '7', '2016-01-25 13:07:53'),
('bd5568d14b1a95399d340953b5ee774f', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', '7', '2016-01-25 13:08:59'),
('3b2569b6da582d29046be8e04b441737', 7, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'fvnw', '2016-01-25 13:09:24'),
('30eecc98b467b9c2fedcbec61b0b428c', 6, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'fvph', '2016-01-25 14:04:03'),
('fc00e5b391a6b93732d93d5f64b1260e', 6, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'fvph', '2016-01-25 15:04:53'),
('8acc8715b48a630e1a35c441b83875a9', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'fvbi', '2016-01-25 15:19:04'),
('bc1f08e2f115c41df037f0559a92d594', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'fvbi', '2016-01-25 15:33:11'),
('20939dd552977b78d8af450869bf87e2', 5, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.132.17', 'fvch', '2016-01-25 16:03:39'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.33', 'michael', '2016-01-28 14:11:44'),
('3ce903fe7656b53ef1997fd09ac6b6ec', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.33', 'fvbi', '2016-01-28 14:12:14'),
('3da1c02324d088af93bc00a89ba4aeb0', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'admin', '2016-02-10 15:55:00'),
('9c8df78ada2b703d467bf8b50dd102d6', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'admin', '2016-02-10 16:04:47'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'fvbi', '2016-02-10 18:38:00'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'fvbi', '2016-02-10 18:38:09'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'admin', '2016-02-10 18:38:21'),
('7fc6983582d4e22c596ba1ea8bc7bfa4', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'admin', '2016-02-10 18:38:45'),
('ce2480bdc9ac42883f4fd6b488a47ee5', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'fvbi', '2016-02-10 18:50:34'),
('16751554acefd39fbb45fc25e5376cde', 5, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'fvch', '2016-02-10 18:51:15'),
('5bea900d1c74c066942ff29e48c8e0fd', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'fvma', '2016-02-10 18:52:04'),
('bb223bce3447118a83d8f67985164493', 6, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'fvph', '2016-02-10 18:52:32'),
('14b0f507a1527b28e9e10ecf054abdd9', 7, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'fvnw', '2016-02-10 18:53:29'),
('7d939e30d1a1c6b269b8ec816b5442b1', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'admin', '2016-02-10 19:49:02'),
('7d939e30d1a1c6b269b8ec816b5442b1', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', '8', '2016-02-10 19:49:49'),
('7d939e30d1a1c6b269b8ec816b5442b1', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'Konf: textfeld (4 DS)', '2016-02-10 19:50:31'),
('176747a14886456033eb11244deaee0a', 8, 'L', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '87.123.174.0', 'lehrkraft', '2016-02-10 19:51:29'),
('5eb834f06fc1551bc0303a131c48506a', 8, 'L', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '217.89.92.10', 'lehrkraft', '2016-02-11 09:10:16'),
('17d2cccbd6ade69f91839885c7417436', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0', '217.89.92.10', 'admin', '2016-02-11 10:18:57'),
('4a65f4e888a719943cdf6f1329097bb9', 8, 'L', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0', '78.50.66.142', 'lehrkraft', '2016-02-15 16:18:11'),
('49fa0e5ff3c645c642d94444d45acd18', 8, 'L', 1100, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:45.0) Gecko/20100101 Firefox/45.0', '146.60.132.39', 'lehrkraft', '2016-04-02 16:40:46'),
('6b45ab3e09109ba2023a8aa86ba3df3a', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', 'admin', '2016-05-15 15:17:55'),
('d8509c4ce95991928e58bfe060133320', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', 'admin', '2016-05-15 16:48:37'),
('ab51c84ce4ad181e0ceacf9d44b77bc2', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', 'admin', '2016-05-15 21:22:07'),
('ab51c84ce4ad181e0ceacf9d44b77bc2', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', '4', '2016-05-15 21:25:39'),
('ab51c84ce4ad181e0ceacf9d44b77bc2', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', '5', '2016-05-15 21:26:28'),
('ab51c84ce4ad181e0ceacf9d44b77bc2', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', '3', '2016-05-15 21:26:46'),
('ab51c84ce4ad181e0ceacf9d44b77bc2', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', '7', '2016-05-15 21:27:03'),
('ab51c84ce4ad181e0ceacf9d44b77bc2', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', '6', '2016-05-15 21:27:21'),
('ab51c84ce4ad181e0ceacf9d44b77bc2', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', '8', '2016-05-15 21:27:42'),
('49f2d0db21e5918f2fcc06ad15763475', 6, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', 'fvph', '2016-05-15 21:28:10'),
('5b85ef80e918f0026caa7412d99fb0f2', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.172.250', 'admin', '2016-05-15 21:48:36'),
('d925efce255c51328dff8b209b8b956c', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.189', 'fvma', '2016-05-16 15:03:04'),
('afa76a1430a5341725749327dca45e75', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.189', 'admin', '2016-05-16 15:59:34'),
('afa76a1430a5341725749327dca45e75', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.189', 'Konf: textfeld (4 DS)', '2016-05-16 15:59:51'),
('afa76a1430a5341725749327dca45e75', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.189', 'Konf: textfeld (4 DS)', '2016-05-16 15:59:55'),
('b50fa7be08da765fc2ed3eff54c7c37e', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.189', 'fvma', '2016-05-16 16:00:15'),
('58b5a74f89a3eec1d613e2557d2bfe0d', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.179.82', 'fvma', '2016-05-17 18:20:40'),
('31941075e0a1dcdaca9bc19faf8b0438', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.179.82', 'fvma', '2016-05-17 19:12:43'),
('6a7161e9794d14e3f20d7bdb21333b03', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.136.238', 'fvma', '2016-05-18 13:31:02'),
('8bb310c2df2bc43102350b06a34c2078', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.136.238', 'fvma', '2016-05-18 15:29:55'),
('84a077941e2ec35fac46b88365c6d50f', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.136.238', 'fvma', '2016-05-18 18:20:14'),
('c6944731868fb3465add7a932783ebac', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'fvma', '2016-05-21 14:22:41'),
('3caf9be0b88eb105906d651c47d86db1', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'fvma', '2016-05-21 14:29:08'),
('b76863032dc2a33ac06052e4153139e8', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'fvma', '2016-05-21 14:38:42'),
('5b9b677e9eea80fa4e993ff3e3e99000', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'admin', '2016-05-21 14:39:01'),
('5b9b677e9eea80fa4e993ff3e3e99000', 1, 'A', 3310, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'Sitzung c6944731868fb3465add7a932783ebac, User: fvma, Fach:Mathematik', '2016-05-21 14:39:38'),
('0bbcaace97fa03fa796685d851ff51f3', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'fvma', '2016-05-21 14:39:55'),
('51b33541dd60d72d8dbca5894c866c87', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'admin', '2016-05-21 16:41:08'),
('51b33541dd60d72d8dbca5894c866c87', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'Konf: textfeld (4 DS)', '2016-05-21 16:41:37'),
('5a3c162b94c78196b0454be2499a2c36', 4, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'fvbi', '2016-05-21 16:42:10'),
('7cf33b6434c63d247d57a6ec7ff7fae2', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'admin', '2016-05-21 16:44:07'),
('7cf33b6434c63d247d57a6ec7ff7fae2', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', '8', '2016-05-21 16:44:49'),
('639df332b0aca179e56f73dce9035239', 8, 'L', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'Lehrkraft', '2016-05-21 16:45:28'),
('105ccd21ee0668ab3d730b3e60218cc2', 7, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'fvnw', '2016-05-21 16:46:47'),
('ec6af72fa60754306b990888af09e2a4', 8, 'L', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.154.8', 'Lehrkraft', '2016-05-21 16:49:09'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '217.89.92.10', 'lehrkraft', '2016-05-23 10:51:58'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '217.89.92.10', 'lehrkraft', '2016-05-23 10:52:12'),
('e34ed0ac172e54f8ca2a473e5447ca39', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'admin', '2016-05-23 12:14:08'),
('e34ed0ac172e54f8ca2a473e5447ca39', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '3', '2016-05-23 12:14:35'),
('af09437abd204e9b8e3402b51b3c8ef7', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'fvma', '2016-05-23 12:15:00'),
('8e6d5327dc067a4689c92dabc81b7dbb', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '93.184.128.34', 'fvma', '2016-05-24 05:41:39'),
('8e6d5327dc067a4689c92dabc81b7dbb', 3, 'F', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '93.184.128.34', 'fvma', '2016-05-24 06:01:44'),
('4b633e02dbe9c9ef355431526dee9c8d', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '93.184.128.34', 'fvma', '2016-05-24 06:02:06'),
('7cda66121b11cdc2689848a0a483da59', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0', '87.123.183.74', 'fvma', '2016-05-24 10:39:50'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'admin', '2016-06-02 13:39:11'),
('38ee391184710afb3af25586c246185e', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'admin', '2016-06-02 13:39:42'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '9', '2016-06-02 13:40:25'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '10', '2016-06-02 13:41:17'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '11', '2016-06-02 13:42:10'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '11', '2016-06-02 13:42:18'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'Konf: fach (13 DS)', '2016-06-02 13:43:15'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '9', '2016-06-02 13:43:31'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '9', '2016-06-02 13:43:37'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '10', '2016-06-02 13:43:47'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '11', '2016-06-02 13:44:01'),
('38ee391184710afb3af25586c246185e', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', '12', '2016-06-02 13:44:49'),
('a6a032610068e58445f7f9d9bffe0c5d', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'fvd', '2016-06-02 13:45:58'),
('ea1c7a66f57d634eaa2dc71fa9922f79', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'admin', '2016-06-02 14:12:23'),
('ea1c7a66f57d634eaa2dc71fa9922f79', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'Konf: textfeld (4 DS)', '2016-06-02 14:12:55'),
('ea1c7a66f57d634eaa2dc71fa9922f79', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'Konf: textfeld (4 DS)', '2016-06-02 14:12:58'),
('7669ab35f99ee74af0cf751f1c1c3911', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'fvd', '2016-06-02 14:13:17'),
('1f5d2a32d3b26de63bd146b3dabe1f92', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'admin', '2016-06-02 14:16:28'),
('1f5d2a32d3b26de63bd146b3dabe1f92', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'Konf: textfeld (4 DS)', '2016-06-02 14:16:44'),
('b99d9550eb64809274ef6e524e8e3e18', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'fvd', '2016-06-02 14:17:02'),
('b5ef8e0d2d6b902b0514241e4993019d', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'admin', '2016-06-02 14:22:29'),
('b5ef8e0d2d6b902b0514241e4993019d', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'Konf: textfeld (4 DS)', '2016-06-02 14:22:56'),
('cc0910e38dbc4188f5d2b0dc4ba91542', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', '93.184.128.34', 'fvd', '2016-06-02 14:23:12'),
('ebeee4552ed632c9a9832190e8c8882f', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', '93.184.128.17', 'fvma', '2016-06-08 04:56:55'),
('0476c8d469ad6abf32cf18a57cc026ac', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '93.184.128.17', 'fvma', '2016-06-08 12:23:22'),
('b898ccca260669d69d2e91c5634916b2', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'fve', '2016-06-15 16:54:59'),
('8c6143c4b12005df714cd598dff3f850', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'admin', '2016-06-15 17:09:24'),
('3bfd2f8d805c19bc941fa5d9a5a57559', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'fve', '2016-06-15 17:10:47'),
('026f402975489857e144283d8be4d8dd', 11, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'fvf', '2016-06-15 17:16:18'),
('e21677999dfb5ba858dd5120322bf5a7', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'admin', '2016-06-15 17:28:04'),
('e21677999dfb5ba858dd5120322bf5a7', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'Konf: fach (13 DS)', '2016-06-15 17:29:35'),
('ddbf778cc562d7ca91a8fed11f6d235a', 12, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'fvl', '2016-06-15 17:30:11'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'fvma', '2016-06-15 17:45:27'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'fvm', '2016-06-15 17:45:39'),
('687d2a5fa1c73efc9c409922728b6202', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'admin', '2016-06-15 17:45:59'),
('687d2a5fa1c73efc9c409922728b6202', 1, 'A', 3210, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', '3', '2016-06-15 17:46:21'),
('e21e71afc8230f100c3686b26d45348a', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'fvma', '2016-06-15 17:46:37'),
('13f914d28b65ffd0699db03f18eed540', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'fvma', '2016-06-15 17:49:33'),
('af7c02f457c34c4576aa8df4e3198a82', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'admin', '2016-06-15 17:53:12'),
('af7c02f457c34c4576aa8df4e3198a82', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'Konf: textfeld (4 DS)', '2016-06-15 17:53:32'),
('af7c02f457c34c4576aa8df4e3198a82', 1, 'A', 3110, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.177.162', 'Konf: textfeld (4 DS)', '2016-06-15 17:53:37'),
('640f13e4358245b4920f97bb53e423f8', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fvd', '2016-06-16 12:23:47'),
('62a4ce3190a71fa3c5606c6d1b542014', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fve', '2016-06-16 12:24:23'),
('84c58238508df8c7cf67d984c7d8f6ec', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fvd', '2016-06-16 12:28:02'),
('ad251f63cb3f199e73e256e8d5d2469d', 11, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fvf', '2016-06-16 12:31:44'),
('bb6e4e6dc4bba5b21065e4486ddaca5f', 12, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fvl', '2016-06-16 12:35:18'),
('c3f4e1fbc4c0b822e32b193fbde8f759', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fvma', '2016-06-16 12:40:24'),
('c7789ddcd42258db7c519f132fc88c02', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fvd', '2016-06-16 14:45:41'),
('e44195a4778df4c45783eaf8c4a54b4b', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fve', '2016-06-16 14:58:21'),
('a8ffdca179a57ce6d67882f530030086', 11, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fvf', '2016-06-16 15:00:46'),
('ae4247c19a2c04b0286002f0b28627d6', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.17', 'fvma', '2016-06-16 15:03:36'),
('9b2b4cb3088740bdd82b47fef03f2954', 12, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Saf', '188.100.160.104', 'fvl', '2016-06-24 09:05:41'),
('6003b8195337bc3a66526ad51376a6fd', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.147.196', 'fvd', '2016-06-30 08:53:07'),
('a28464101e5b4151246bf9352dc31b9b', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.147.196', 'fvd', '2016-06-30 12:06:50'),
('dc47c25955c12bedff0bb6a605db39e5', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.147.196', 'fvd', '2016-06-30 12:07:44'),
('5f95137dcc24a4d829aa67006adc9cac', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.147.196', 'fvd', '2016-06-30 13:22:25'),
('47959858ce9b3afee42883b113c70bcc', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.16', 'admin', '2016-06-30 13:29:21'),
('47959858ce9b3afee42883b113c70bcc', 1, 'A', 3310, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0', '93.184.128.16', 'Sitzung 6003b8195337bc3a66526ad51376a6fd, User: fvd, Fach:Deutsch', '2016-06-30 13:34:51'),
('bc681eff7e3a2992ffcf6a8548c5500e', 9, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.147.196', 'fvd', '2016-06-30 13:35:18'),
('8f31d68ef07384af1cdf104918545837', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '62.158.233.16', 'fvma', '2016-07-01 13:35:20'),
('dc7bd0f2cd92948f3c8019211b94e821', 3, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '62.158.233.16', 'fvma', '2016-07-01 15:22:47'),
('8486bc37ba0f40306751a806d16255d3', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.148.254', 'fve', '2016-07-05 11:26:16'),
('434bfb028d17d83e17a0d8a78dcae442', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.148.254', 'fve', '2016-07-05 15:30:35'),
('68bba40b07f54a87e77286ae225401a1', 11, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.148.254', 'fvf', '2016-07-05 15:52:26'),
('ab572c5e32d2c760bf78337723ff1a33', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.148.254', 'fve', '2016-07-05 15:53:35'),
('f0f4a929b55e7d50faaf8793c9466f9d', 11, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.148.254', 'fvf', '2016-07-05 15:55:49'),
('2fe41a21ce8d193b8b46503f13ab71a7', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.148.254', 'fve', '2016-07-05 15:56:48'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.129.151', 'fve', '2016-07-05 18:46:26'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.129.151', 'fve', '2016-07-05 18:48:31'),
('c306ee233ae04a3d8467d2dd7b89e46e', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.129.151', 'fve', '2016-07-05 18:48:51'),
('8fca8cd6fb9b44b03aab2440e735c7cd', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.129.151', 'fve', '2016-07-05 19:14:20'),
('74602c9c6d19c20b3925cef2c13fbd38', 1, 'A', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.129.151', 'admin', '2016-07-05 19:14:39'),
('74602c9c6d19c20b3925cef2c13fbd38', 1, 'A', 3310, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.129.151', 'Sitzung c306ee233ae04a3d8467d2dd7b89e46e, User: fve, Fach:Englisch', '2016-07-05 19:14:48'),
('8d92efea3fc352fdae3f5ac4f5de8d4d', 11, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.129.151', 'fvf', '2016-07-05 19:15:02'),
('0e0f56d630bab6e081d3bd41723949b0', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '87.123.129.151', 'fve', '2016-07-05 19:16:05'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '92.50.116.218', 'lehrkraft', '2016-07-06 08:07:09'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '92.50.116.218', 'lehrkraft', '2016-07-06 08:07:45'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '92.50.116.218', 'deutsch', '2016-07-06 08:08:09'),
('41191d0ffc6856a18e0b269bbeb6e485', 10, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '84.135.149.109', 'fve', '2016-07-06 09:00:39'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '92.50.116.218', 'lehrkraft', '2016-07-08 07:57:39'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '92.50.116.218', 'deutsch', '2016-07-08 07:57:52'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0', '92.50.116.218', 'lehrkraft', '2016-07-08 07:58:38'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', '84.135.159.130', 'fvf', '2016-09-06 11:07:22'),
('-', 0, '-', 1105, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', '84.135.159.130', 'fvf', '2016-09-06 11:08:00'),
('85e3aacd5d73e566c186c67e875dffa3', 11, 'F', 1100, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:48.0) Gecko/20100101 Firefox/48.0', '84.135.159.130', 'fvf', '2016-09-06 11:08:56');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t150_sys_user`
--

DROP TABLE IF EXISTS `part_t150_sys_user`;
CREATE TABLE `part_t150_sys_user` (
  `user_id` int(11) NOT NULL COMMENT 'eindeutige ID für jeden Anmeldenamen, Primärschlüssel',
  `anmeldename` varchar(100) NOT NULL COMMENT 'eindeutiger Anmeldename',
  `vollname` varchar(150) DEFAULT NULL COMMENT 'Vor- und Zuname',
  `kennwort_crypt` varchar(32) DEFAULT NULL COMMENT 'Einweg-verschlüsseltes Kennwort',
  `kennwort_klar` varchar(100) DEFAULT NULL COMMENT 'Klartext-Kennwort (bzw. b64)',
  `anmeldetyp` varchar(1) DEFAULT NULL COMMENT 'Typ: F-Fachverwalter/in, A-Admin, L-Lehrer/in',
  `fach_id` int(10) DEFAULT NULL COMMENT 'Fach-ID des Faches, das von Fachverwalter/in bearbeitet wird'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Anmeldekennungen';

--
-- Daten für Tabelle `part_t150_sys_user`
--

INSERT INTO `part_t150_sys_user` (`user_id`, `anmeldename`, `vollname`, `kennwort_crypt`, `kennwort_klar`, `anmeldetyp`, `fach_id`) VALUES
(1, 'admin', 'Administrator/in', 'd5133c970ad3a99c2248fed76970d06c', NULL, 'A', NULL),
(2, 'whupfeld', 'Walter Hupfeld', '5b3bc530601d665b7c847bb1099713a5', NULL, 'A', NULL),
(3, 'fvma', 'Fachverwalter Mathematik', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 3),
(4, 'fvbi', 'Fachverwalter Biologie', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 7),
(5, 'fvch', 'Fachverwalter Chemie', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 9),
(6, 'fvph', 'Fachverwalter Physik', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 10),
(7, 'fvnw', 'Fachverwalter Naturwissenschaften', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 11),
(8, 'lehrkraft', 'Lehrkraft', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'L', NULL),
(9, 'fvd', 'Fachverwalter Deutsch', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 1),
(10, 'fve', 'Fachverwalter Englisch', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 2),
(11, 'fvf', 'Fachverwalter Französisch', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 12),
(12, 'fvl', 'Fachverwalter Latein', 'a5fddf0a03f68bbba324bb80e8e9387d', NULL, 'F', 13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t160_sys_sperren`
--

DROP TABLE IF EXISTS `part_t160_sys_sperren`;
CREATE TABLE `part_t160_sys_sperren` (
  `fach_id` int(10) NOT NULL COMMENT 'Fach-ID des Faches, das bearbeitet und damit gesperrt wird, Primärschlüssel',
  `session_id` varchar(35) NOT NULL COMMENT 'eindeutige Session-ID',
  `user_id` int(11) DEFAULT NULL COMMENT 'eindeutige ID für jeden Anmeldenamen',
  `sessionende` varchar(40) DEFAULT NULL COMMENT 'Ende der Session (Gültigkeit der Sperre)'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Sperren: Bearbeitung nur eines Faches zur Zeit erlaubt';

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t170_sys_aender_session_uv`
--

DROP TABLE IF EXISTS `part_t170_sys_aender_session_uv`;
CREATE TABLE `part_t170_sys_aender_session_uv` (
  `user_id` int(11) NOT NULL COMMENT 'eindeutige ID für jeden Anmeldenamen, Teil-Primärschlüssel',
  `uv_id` int(12) NOT NULL COMMENT 'eind. ID für das Unterrichtsvorhaben, Teil-Primärschlüssel',
  `schulform_id` int(10) NOT NULL COMMENT 'Schulform-ID, Fremdschlüssel',
  `fach_id` int(10) NOT NULL COMMENT 'Fach-ID, Fremdschlüssel',
  `stufe_id` int(10) NOT NULL COMMENT 'Stufen-ID, Fremdschlüssel',
  `kursart_id` int(10) NOT NULL COMMENT 'ID für Kursart, Fremdschlüssel, 0 wenn keine Kursart',
  `zug_id` int(10) NOT NULL COMMENT 'Zug-ID (Klasse, Lerngruppe), Fremdschlüssel, 0 wenn kein Zug',
  `zeitbedarf_std` int(5) DEFAULT NULL COMMENT 'Zeitbedarf in Stunden',
  `zeitbedarf_wochen` int(5) DEFAULT NULL COMMENT 'Zeitbedarf in Wochen, wichtig für Zeitplan',
  `beginn_kw` int(5) DEFAULT NULL COMMENT 'Kalenderwoche: Beginn',
  `ende_kw` int(5) DEFAULT NULL COMMENT 'Kalenderwoche: Ende',
  `aenderung_user_id` int(11) DEFAULT NULL COMMENT 'Hinweis auf die Person, die zuletzt änderte',
  `aenderung_zeitstempel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Zeitstempel der letzten Änderung'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Angaben, um Änderungen einer Sitzung rückgängig zu machen';

--
-- Daten für Tabelle `part_t170_sys_aender_session_uv`
--

INSERT INTO `part_t170_sys_aender_session_uv` (`user_id`, `uv_id`, `schulform_id`, `fach_id`, `stufe_id`, `kursart_id`, `zug_id`, `zeitbedarf_std`, `zeitbedarf_wochen`, `beginn_kw`, `ende_kw`, `aenderung_user_id`, `aenderung_zeitstempel`) VALUES
(7, 17, 2, 11, 1, 0, 0, 22, 8, 1, 8, 7, '2016-01-25 13:54:22'),
(9, 86, 4, 1, 6, 1, 1, 24, 7, 14, 20, 9, '2016-06-30 14:02:09'),
(9, 85, 4, 1, 4, 0, 0, 48, 13, 35, 47, 9, '2016-06-30 13:55:15'),
(9, 88, 4, 1, 5, 0, 0, 15, 5, 36, 40, 9, '2016-06-30 14:13:01'),
(9, 87, 4, 1, 4, 0, 0, 48, 13, 21, 33, 9, '2016-06-30 14:07:02'),
(9, 82, 4, 1, 3, 0, 0, 40, 2, 1, 2, 9, '2016-06-30 13:40:57'),
(9, 83, 4, 1, 3, 0, 0, 40, 11, 12, 22, 9, '2016-06-30 13:45:30'),
(10, 152, 4, 2, 5, 0, 0, 29, 8, 19, 26, 10, '2016-07-05 13:57:18'),
(10, 151, 4, 2, 5, 0, 0, 23, 7, 12, 18, 10, '2016-07-05 13:53:56'),
(10, 145, 4, 2, 4, 0, 0, 20, 6, 6, 11, 10, '2016-07-05 13:30:33'),
(10, 141, 4, 2, 3, 0, 0, 23, 7, 11, 17, 10, '2016-07-05 18:55:59'),
(11, 153, 4, 12, 2, 0, 0, 15, 8, 5, 12, 11, '2016-09-06 11:18:47'),
(11, 154, 4, 12, 6, 1, 1, 15, 8, 13, 20, 11, '2016-09-06 11:38:21'),
(11, 155, 4, 12, 2, 0, 0, 0, 2, 21, 22, 11, '2016-09-06 11:50:54'),
(11, 158, 4, 12, 2, 0, 0, 15, 16, 45, 60, 11, '2016-09-06 12:04:57'),
(11, 156, 4, 12, 2, 0, 0, 15, 8, 29, 36, 11, '2016-09-06 11:57:13'),
(11, 157, 4, 12, 2, 0, 0, 15, 8, 37, 44, 11, '2016-09-06 12:01:04'),
(11, 159, 4, 12, 2, 0, 0, 15, 8, 43, 50, 11, '2016-09-06 12:15:21'),
(11, 160, 4, 12, 3, 0, 0, 20, 2, 1, 2, 11, '2016-09-06 12:21:49'),
(11, 161, 4, 12, 3, 0, 0, 20, 10, 11, 20, 11, '2016-09-06 12:26:55'),
(11, 162, 4, 12, 3, 0, 0, 20, 11, 30, 40, 11, '2016-09-06 12:31:42'),
(11, 164, 4, 12, 3, 0, 0, 20, 7, 43, 49, 11, '2016-09-06 12:44:58'),
(11, 163, 4, 12, 3, 0, 0, 20, 11, 32, 42, 11, '2016-09-06 12:38:59'),
(11, 166, 4, 12, 4, 0, 0, 20, 9, 1, 9, 11, '2016-09-06 13:00:01'),
(11, 169, 4, 12, 4, 0, 0, 20, 10, 27, 36, 11, '2016-09-06 13:17:03'),
(11, 170, 4, 12, 4, 0, 0, 20, 10, 37, 46, 11, '2016-09-06 13:23:09'),
(11, 171, 4, 12, 5, 0, 0, 25, 11, 1, 11, 11, '2016-09-06 13:30:04'),
(11, 172, 4, 12, 5, 0, 0, 25, 12, 12, 23, 11, '2016-09-06 13:36:01'),
(11, 173, 4, 12, 5, 0, 0, 25, 12, 24, 35, 11, '2016-09-06 13:42:25'),
(11, 174, 4, 12, 5, 0, 0, 25, 12, 36, 47, 11, '2016-09-06 13:50:34');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t210_kfg_uv_textfelder`
--

DROP TABLE IF EXISTS `part_t210_kfg_uv_textfelder`;
CREATE TABLE `part_t210_kfg_uv_textfelder` (
  `textfeld_id` int(10) NOT NULL COMMENT 'eindeutige ID für Textfeld, Primärschlüssel',
  `textfeld` varchar(30) NOT NULL COMMENT '(eindeutige) Bezeichnung des Textfeldes',
  `textfeld_label` varchar(100) DEFAULT NULL COMMENT 'Beschriftung des Textfeldes in Eingabeformular',
  `textfeld_beschreibung` varchar(200) DEFAULT NULL COMMENT 'Hinweise/Hilfetext zum Textfeld',
  `textfeld_bem` varchar(200) DEFAULT NULL COMMENT 'Bemerkungen zum Textfeld',
  `feldlaenge` int(4) DEFAULT NULL COMMENT 'optionale Zeichenlängenbeschränkung',
  `pflichtfeld` int(1) DEFAULT NULL COMMENT 'Muss Feld ausgefüllt werden (0/1 = nein/ja)?',
  `plananzeige` int(1) DEFAULT NULL COMMENT 'Soll Feld in Planübersicht angezeigt werden (0/1 = nein/ja)?',
  `reihenfolge` int(4) DEFAULT NULL COMMENT 'Reihenfolge zur Sortierung',
  `nur_lehrkraefte` int(1) DEFAULT NULL COMMENT 'Soll Feld nur für Lehrkräfte sichtbar sein (0/1 = nein/ja)?'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Konfigurierbare Textfelder für Unterrichtsvorhaben';

--
-- Daten für Tabelle `part_t210_kfg_uv_textfelder`
--

INSERT INTO `part_t210_kfg_uv_textfelder` (`textfeld_id`, `textfeld`, `textfeld_label`, `textfeld_beschreibung`, `textfeld_bem`, `feldlaenge`, `pflichtfeld`, `plananzeige`, `reihenfolge`, `nur_lehrkraefte`) VALUES
(2, 'Inhaltsfeld', 'Inhaltsfeld und Schwerpunkte', NULL, NULL, 2000, NULL, 1, 200, NULL),
(3, 'Schwerpunkte', 'Schwerpunkte der übergeordneten Kompetenzerwartungen', NULL, NULL, 2000, NULL, 1, 300, NULL),
(4, 'Kompetenzentwicklung', 'Aspekte der Kompetenzentwicklung', NULL, NULL, 2000, NULL, 1, 400, NULL),
(5, 'Zusatzinfo', 'Zusatzinformationen', NULL, 'Testfeld', 1500, NULL, 1, 500, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t310_kat_schulform`
--

DROP TABLE IF EXISTS `part_t310_kat_schulform`;
CREATE TABLE `part_t310_kat_schulform` (
  `schulform_id` int(10) NOT NULL COMMENT 'eindeutige Schulform-ID, Primärschlüssel',
  `schulform` varchar(30) NOT NULL COMMENT 'Bezeichnung der Schulform',
  `schulformkuerzel` varchar(5) NOT NULL COMMENT 'Kürzel für die Schulform, auch eindeutig',
  `schulform_bem` varchar(200) DEFAULT NULL COMMENT 'Bemerkungen zur Schulform'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Katalog der Schulformen';

--
-- Daten für Tabelle `part_t310_kat_schulform`
--

INSERT INTO `part_t310_kat_schulform` (`schulform_id`, `schulform`, `schulformkuerzel`, `schulform_bem`) VALUES
(1, 'Hauptschule', 'HS', NULL),
(2, 'Gesamtschule', 'GE', NULL),
(3, 'Realschule', 'RS', NULL),
(4, 'Gymnasium', 'GY', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t320_kat_fach`
--

DROP TABLE IF EXISTS `part_t320_kat_fach`;
CREATE TABLE `part_t320_kat_fach` (
  `fach_id` int(10) NOT NULL COMMENT 'eindeutige Fach-ID, Primärschlüssel',
  `fach` varchar(50) NOT NULL COMMENT 'Bezeichnung des Faches',
  `fachkuerzel` varchar(5) NOT NULL COMMENT 'Kürzel für das Fach, auch eindeutig',
  `fach_farbe` varchar(7) DEFAULT NULL COMMENT 'Farbe zur Darstellung des Faches',
  `fachreihenfolge` int(10) NOT NULL COMMENT 'Reihenfolge-Wert',
  `fach_bem` varchar(200) DEFAULT NULL COMMENT 'Bemerkungen zum Fach'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Katalog der Fächer';

--
-- Daten für Tabelle `part_t320_kat_fach`
--

INSERT INTO `part_t320_kat_fach` (`fach_id`, `fach`, `fachkuerzel`, `fach_farbe`, `fachreihenfolge`, `fach_bem`) VALUES
(1, 'Deutsch', 'D', '#FFCCCC', 100, NULL),
(2, 'Englisch', 'E', '#99FFFF', 200, NULL),
(3, 'Mathematik', 'M', '#99FF00', 500, NULL),
(4, 'Geschichte', 'GE', '#CCFF66', 4005, NULL),
(5, 'Erdkunde', 'EK', '#66FFFF', 4100, NULL),
(6, 'Politik', 'PK', '#FFCCFF', 4200, NULL),
(7, 'Biologie', 'BI', '#92d050', 2000, NULL),
(8, 'Gesellschaftslehre (integriert)', 'GL_i', '#99FF99', 5000, NULL),
(9, 'Chemie', 'CH', '#ffff00', 3000, NULL),
(10, 'Physik', 'PH', '#8db3e2', 4000, NULL),
(11, 'Naturwissenschaften', 'NW', '#bfbfbf', 1000, NULL),
(12, 'Französisch', 'F', '#c4bd97', 300, NULL),
(13, 'Latein', 'L', '#e5b9b7', 400, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t330_kat_stufe`
--

DROP TABLE IF EXISTS `part_t330_kat_stufe`;
CREATE TABLE `part_t330_kat_stufe` (
  `stufe_id` int(10) NOT NULL COMMENT 'eindeutige Stufen-ID, Primärschlüssel',
  `stufe` varchar(10) NOT NULL COMMENT '(eindeutige) Bezeichnung der Stufe, normalerweise Zahl, kann aber auch Buchstaben enthalten',
  `stufe_bem` varchar(200) DEFAULT NULL COMMENT 'Bemerkungen zur Stufe'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Katalog der Jahrgangsstufen (5,6,7, ...)';

--
-- Daten für Tabelle `part_t330_kat_stufe`
--

INSERT INTO `part_t330_kat_stufe` (`stufe_id`, `stufe`, `stufe_bem`) VALUES
(1, '5', NULL),
(2, '6', NULL),
(3, '7', NULL),
(4, '8', NULL),
(5, '9', NULL),
(6, '10', NULL),
(7, '11-EF', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t340_kat_zug`
--

DROP TABLE IF EXISTS `part_t340_kat_zug`;
CREATE TABLE `part_t340_kat_zug` (
  `zug_id` int(10) NOT NULL COMMENT 'eindeutige ID für Zug (Klasse, Lerngruppe), Primärschlüssel',
  `zug` varchar(25) NOT NULL COMMENT '(eindeutige) Bezeichnung des Zuges wie a, b, c',
  `zug_bem` varchar(200) DEFAULT NULL COMMENT 'Bemerkungen zum Zug'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Katalog der Züge (Klassen-Kürzel, Lerngruppen wie a, b, c)';

--
-- Daten für Tabelle `part_t340_kat_zug`
--

INSERT INTO `part_t340_kat_zug` (`zug_id`, `zug`, `zug_bem`) VALUES
(0, 'keiner', NULL),
(1, 'a', NULL),
(2, 'b', NULL),
(3, 'c', NULL),
(4, 'd', NULL),
(5, 'e', NULL),
(6, 'f', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t350_kat_kursart`
--

DROP TABLE IF EXISTS `part_t350_kat_kursart`;
CREATE TABLE `part_t350_kat_kursart` (
  `kursart_id` int(10) NOT NULL COMMENT 'eindeutige ID für Kursart, Primärschlüssel',
  `kursart` varchar(10) NOT NULL COMMENT '(eindeutige) Kurz-Bezeichnung der Kursart (z.B. E-Kurs)',
  `kursart_bezeichnung` varchar(50) DEFAULT NULL COMMENT 'evtl. längere Bezeichnung der Kursart',
  `kursart_bem` varchar(200) DEFAULT NULL COMMENT 'Bemerkungen zur Kursart'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Katalog der Kursarten wie E-Kurs, GK, etc.';

--
-- Daten für Tabelle `part_t350_kat_kursart`
--

INSERT INTO `part_t350_kat_kursart` (`kursart_id`, `kursart`, `kursart_bezeichnung`, `kursart_bem`) VALUES
(0, 'keine', 'keine Kurs-Differenzierung', NULL),
(1, 'E-Kurs', 'Erweiterungskurs', NULL),
(2, 'G-Kurs', 'Grundkurs', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t510_ein_unterrichtsvorhaben`
--

DROP TABLE IF EXISTS `part_t510_ein_unterrichtsvorhaben`;
CREATE TABLE `part_t510_ein_unterrichtsvorhaben` (
  `uv_id` int(12) NOT NULL COMMENT 'eindeutige ID für das Unterrichtsvorhaben, Primärschlüssel',
  `schulform_id` int(10) NOT NULL COMMENT 'Schulform-ID, Fremdschlüssel',
  `fach_id` int(10) NOT NULL COMMENT 'Fach-ID, Fremdschlüssel',
  `stufe_id` int(10) NOT NULL COMMENT 'Stufen-ID, Fremdschlüssel',
  `kursart_id` int(10) NOT NULL COMMENT 'ID für Kursart, Fremdschlüssel, 0 wenn keine Kursart',
  `zug_id` int(10) NOT NULL COMMENT 'Zug-ID (Klasse, Lerngruppe), Fremdschlüssel, 0 wenn kein Zug',
  `uv_titel` varchar(100) NOT NULL COMMENT 'Titel des Unterrichtsvorhabens',
  `zeitbedarf_std` int(5) DEFAULT NULL COMMENT 'Zeitbedarf in Stunden',
  `zeitbedarf_wochen` int(5) DEFAULT NULL COMMENT 'Zeitbedarf in Wochen, wichtig für Zeitplan',
  `beginn_kw` int(5) DEFAULT NULL COMMENT 'Kalenderwoche: Beginn',
  `ende_kw` int(5) DEFAULT NULL COMMENT 'Kalenderwoche: Ende',
  `aenderung_user_id` int(11) DEFAULT NULL COMMENT 'Hinweis auf die Person, die zuletzt änderte',
  `aenderung_zeitstempel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Zeitstempel der letzten Änderung'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Eingabetabelle mit allen Unterrichtsvorhaben';

--
-- Daten für Tabelle `part_t510_ein_unterrichtsvorhaben`
--

INSERT INTO `part_t510_ein_unterrichtsvorhaben` (`uv_id`, `schulform_id`, `fach_id`, `stufe_id`, `kursart_id`, `zug_id`, `uv_titel`, `zeitbedarf_std`, `zeitbedarf_wochen`, `beginn_kw`, `ende_kw`, `aenderung_user_id`, `aenderung_zeitstempel`) VALUES
(18, 2, 11, 1, 0, 0, 'Leben im Jahreslauf (NW 2)', 24, 8, 9, 16, 7, '2016-01-25 13:54:41'),
(17, 2, 11, 1, 0, 0, 'Tiere und Pflanzen in meiner Umgebung (NW 1)', 22, 8, 1, 8, 7, '2016-01-25 13:54:22'),
(37, 2, 7, 4, 0, 0, 'Modelle zur Entwicklung des Menschen (8.2)', 6, 3, 16, 18, 4, '2016-01-25 15:40:44'),
(36, 2, 7, 4, 0, 0, 'Lebewesen und Lebensräume - in ständiger Veränderung (8.1)', 10, 5, 11, 15, 4, '2016-01-25 15:38:55'),
(34, 2, 7, 4, 0, 0, 'Ökosystem Wald (8.1)', 16, 8, 1, 8, 4, '2016-01-25 15:34:53'),
(35, 2, 7, 4, 0, 0, 'Ökosysteme im Wandel (8.1)', 4, 2, 9, 10, 4, '2016-01-25 15:36:36'),
(48, 2, 9, 5, 0, 0, 'Mobile Energiespeicher', 8, 4, 7, 10, 5, '2016-01-25 16:12:51'),
(47, 2, 9, 5, 0, 0, 'Der Aufbau der Stoffe', 12, 6, 1, 6, 5, '2016-01-25 16:10:42'),
(46, 2, 9, 3, 0, 0, 'Von der Steinzeit bis zum High-Tech-Metall', 14, 7, 10, 16, 5, '2016-01-25 16:08:39'),
(28, 2, 10, 4, 0, 0, 'Physik und Sport (Ph 8)', 14, 7, 23, 29, 6, '2016-01-25 14:14:09'),
(27, 2, 10, 4, 0, 0, 'Elektroinstallation und Sicherheit im Haus (Ph 7)', 12, 6, 17, 22, 6, '2016-01-25 14:12:14'),
(26, 2, 10, 4, 0, 0, 'Blitze und Gewitter (Ph 7)', 7, 4, 13, 16, 6, '2016-01-25 14:10:14'),
(25, 2, 10, 4, 0, 0, 'Die Erde im Weltall (Ph 6)', 10, 5, 8, 12, 6, '2016-01-25 14:08:11'),
(19, 2, 11, 1, 0, 0, 'Sinneseindrücke im Kino (NW 3)', 18, 6, 17, 22, 7, '2016-01-25 13:54:44'),
(20, 2, 11, 1, 0, 0, 'Tiere als Sinnesspezialisten (NW 3)', 10, 4, 23, 26, 7, '2016-01-25 13:56:14'),
(21, 2, 11, 2, 0, 0, 'Training und Ausdauer (NW 4)', 28, 10, 1, 10, 7, '2016-01-25 13:58:14'),
(22, 2, 11, 2, 0, 0, 'Elektrogeräte im Alltag (NW 5)', 22, 8, 11, 18, 7, '2016-01-25 13:59:54'),
(23, 2, 11, 2, 0, 0, 'Speisen und Getränke (NW 5)', 20, 8, 19, 26, 7, '2016-01-25 14:01:54'),
(24, 2, 10, 4, 0, 0, 'Sehhilfen für nah und fern<br />\r\n(Ph 5)', 14, 7, 1, 7, 6, '2016-01-25 14:06:00'),
(29, 2, 10, 6, 0, 0, 'Im Fitnessstudio (Ph 9)', 10, 5, 1, 5, 6, '2016-01-25 14:15:39'),
(30, 2, 10, 6, 0, 0, 'Werkzeuge und Maschinen erleichtern die Arbeit (Ph 9)', 12, 6, 6, 11, 6, '2016-01-25 14:17:22'),
(31, 2, 10, 6, 0, 0, 'Elektrofahrzeuge (Ph 10)', 12, 6, 12, 17, 6, '2016-01-25 14:18:41'),
(32, 2, 10, 6, 0, 0, 'Stromversorgung einer Stadt (Ph 10)', 10, 5, 18, 22, 6, '2016-01-25 14:21:15'),
(33, 2, 10, 6, 0, 0, 'Kernkraftwerke und Entsorgung (Ph 11)', 12, 6, 23, 28, 6, '2016-01-25 14:22:57'),
(38, 2, 7, 4, 0, 0, 'Vererbung (8.2)', 20, 10, 30, 39, 4, '2016-01-28 14:13:20'),
(39, 2, 7, 4, 0, 0, 'Produkte aus dem Genlabor (8.2)', 8, 8, 22, 29, 4, '2016-01-28 14:13:13'),
(40, 2, 7, 5, 0, 0, 'Verantwortung für das Leben (9.1)', 6, 3, 1, 3, 4, '2016-01-25 15:46:10'),
(41, 2, 7, 5, 0, 0, 'Organspende (9.1)', 10, 5, 4, 8, 4, '2016-01-25 15:48:10'),
(42, 2, 7, 5, 0, 0, 'Lernen - nicht nur in der Schule (9.2)', 14, 7, 9, 15, 4, '2016-01-25 15:51:41'),
(43, 2, 7, 5, 0, 0, 'Farben und Signale (9.2)', 10, 5, 16, 20, 4, '2016-01-25 15:53:25'),
(44, 2, 7, 5, 0, 0, 'Der Kampf gegen Krankheiten(9.2)', 24, 12, 21, 32, 4, '2016-01-25 15:55:11'),
(45, 2, 9, 3, 0, 0, 'Brände und Brandbekämpfung', 18, 9, 1, 9, 5, '2016-01-25 16:06:08'),
(49, 2, 9, 5, 0, 0, 'Säuren und Laugen in Alltag und Beruf', 12, 6, 11, 16, 5, '2016-01-25 16:14:58'),
(50, 2, 9, 6, 0, 0, 'Zukunftssichere Energieversorgung', 14, 7, 1, 7, 5, '2016-01-25 16:16:44'),
(51, 2, 9, 6, 0, 0, 'Anwendungen der Chemie in Medizin, Natur und Technik', 18, 10, 8, 17, 5, '2016-01-25 16:18:57'),
(66, 4, 13, 2, 0, 0, '<b>Römisches Alltagsleben</b>', 40, 18, 18, 35, 12, '2016-06-24 09:16:13'),
(65, 4, 13, 2, 0, 0, 'Treffpunkte im alten Rom', 40, 17, 1, 17, 12, '2016-06-24 09:11:40'),
(63, 4, 2, 1, 0, 0, 'Thema: <em>Hello - getting to know each other</em>', 15, 5, 1, 5, 10, '2016-07-05 18:53:48'),
(64, 4, 12, 2, 0, 0, 'Vorkurs: Coucou, c&#039;est moi!<br />\r\n- Bonjour et au revoir -', 10, 4, 1, 4, 11, '2016-06-16 12:34:28'),
(56, 2, 3, 1, 0, 0, '<h6>Wir lernen uns kennen - Datenerhebung und Darstellung von Zahlen und Größen</h6>', 20, 4, 1, 4, 3, '2016-05-24 06:03:05'),
(57, 2, 3, 1, 0, 0, 'Mit der Mathebrille unterwegs - Rechnen mit natürlichen Zahlen und Aufstellen von Zahlentermen ', 24, 5, 5, 9, 3, '2016-05-24 06:05:55'),
(67, 4, 13, 2, 0, 0, '<b>Heldenerzählungen der römischen Frühzeit</b>', 40, 17, 36, 52, 12, '2016-06-24 09:19:56'),
(59, 4, 1, 1, 0, 0, 'Wir und unsere neue Schule', 16, 5, 1, 5, 9, '2016-06-02 14:10:31'),
(60, 4, 1, 1, 0, 0, 'Tiere hier und anderswo', 36, 10, 8, 17, 9, '2016-06-02 14:36:38'),
(61, 4, 3, 1, 0, 0, 'Wir lernen uns kennen - Datenerhebung und Darstellung von Zahlen und Größen', 20, 5, 1, 5, 3, '2016-07-01 14:08:26'),
(62, 4, 3, 1, 0, 0, 'Mit der Mathebrille unterwegs - Rechnen mit natürlichen Zahlen und Aufstellen von Zahlentermen ', 24, 6, 7, 12, 3, '2016-07-01 14:09:01'),
(68, 4, 13, 3, 0, 0, '<em></em>(Bürger-)Kriege - Wer ist der Feind? Herausragende historische Persönlichkeiten: Hannibal, ', 40, 17, 1, 17, 12, '2016-06-24 09:26:45'),
(69, 4, 13, 3, 0, 0, '<b>Abenteuerliche Reisen</b>', 30, 14, 18, 31, 12, '2016-06-24 09:32:02'),
(70, 4, 13, 3, 0, 0, '<b>Mensch und Götter</b>', 50, 21, 32, 52, 12, '2016-06-24 09:33:56'),
(71, 4, 13, 4, 0, 0, '<b>Die Griechen erklären die Welt</b>', 30, 17, 1, 17, 12, '2016-06-24 09:37:53'),
(72, 4, 13, 4, 0, 0, '<b>Wunderprovinz Kleinasien</b>', 30, 18, 18, 35, 12, '2016-06-24 09:40:02'),
(73, 4, 13, 4, 0, 0, 'Fluch und Segen römischer Zivilisation', 30, 17, 36, 52, 12, '2016-06-24 09:42:01'),
(74, 4, 13, 5, 0, 0, '<b>Liebe, Reise, Abenteuer im antiken Roman anhand der Historia Apollonii</b>', 30, 17, 1, 17, 12, '2016-06-24 09:44:28'),
(75, 4, 13, 5, 0, 0, '<b>Perfide Leserlenkung am Beispiel von Cäsars Erster Britannien-Exkursion</b>', 30, 18, 18, 35, 12, '2016-06-24 09:48:51'),
(76, 4, 13, 5, 0, 0, '<b>Martial, Epigramme - Ernst und Unernst des römischen Alltagslebens</b>', 30, 17, 36, 52, 12, '2016-06-24 09:51:20'),
(77, 4, 1, 1, 0, 0, 'Märchen und andere Geschichten - lesen und ausgestalten (UV 5.3)', 34, 9, 19, 27, 9, '2016-06-30 09:04:30'),
(78, 4, 1, 1, 0, 0, 'Poetische Jahreszeiten - Lyrische Texte untersuchen und gestalten (UV 5.4)', 16, 5, 29, 33, 9, '2016-06-30 09:14:48'),
(79, 4, 1, 2, 0, 0, 'Sensationelle Ereignisse (UV 6.1)', 40, 10, 1, 10, 9, '2016-06-30 09:24:02'),
(80, 4, 1, 2, 0, 0, 'Erzählen früher und heute (UV 6.2)', 35, 9, 12, 20, 9, '2016-06-30 09:33:11'),
(81, 4, 1, 2, 0, 0, 'Das Thema &quot;Freundschaft&quot; im Jugendbuch (UV 6.3)', 45, 12, 22, 33, 9, '2016-06-30 09:38:09'),
(82, 4, 1, 3, 0, 0, 'Kann man Glück kaufen? (UV 7.1)', 40, 10, 1, 10, 9, '2016-06-30 13:41:23'),
(83, 4, 1, 3, 0, 0, 'Von großen und kleinen Heldinnen und Helden (UV 7.2)', 40, 11, 12, 22, 9, '2016-06-30 13:45:30'),
(84, 4, 1, 3, 0, 0, 'Mit Konflikten umgehen (lernen) (UV 7.3)', 40, 11, 24, 34, 9, '2016-06-30 13:51:09'),
(85, 4, 1, 4, 0, 0, 'Für andere schreiben (UV 8.1)', 48, 12, 1, 12, 9, '2016-06-30 13:59:01'),
(86, 4, 1, 4, 0, 0, 'Alltägliche Begebenheiten in kurzen Geschichten (UV 8.2)', 24, 7, 14, 20, 9, '2016-06-30 14:02:44'),
(87, 4, 1, 4, 0, 0, 'Zukunft - alles ist möglich! (UV 8.3)', 48, 13, 22, 34, 9, '2016-06-30 14:09:39'),
(88, 4, 1, 5, 0, 0, 'Beziehungen in Geschichten und Gedichten (UV 9.1)', 15, 4, 1, 4, 9, '2016-06-30 14:13:26'),
(89, 4, 1, 5, 0, 0, 'Berufliche Perspektiven (UV 9.2)', 18, 6, 6, 11, 9, '2016-06-30 14:16:25'),
(90, 4, 1, 5, 0, 0, 'Familienkonstellationen (UV 9.3)', 32, 9, 13, 21, 9, '2016-06-30 14:21:06'),
(91, 4, 1, 5, 0, 0, 'Wie redest du mit mir? - Sprache als Mittel der Verständigung (UV 9.4)', 25, 5, 23, 27, 9, '2016-06-30 14:23:51'),
(92, 4, 3, 1, 0, 0, 'Mathematik mit Papier und Spiegel <br />\r\ngeom. Grundbegriffe an ebenen Figuren entdecken', 20, 5, 14, 18, 3, '2016-07-01 14:09:19'),
(93, 4, 3, 1, 0, 0, 'Unsere Wohnung / Unser Klassenraum<br />\r\nBerechnung von Fläche &amp; Umfang ebener Figuren', 16, 4, 20, 23, 3, '2016-07-01 14:09:44'),
(94, 4, 3, 1, 0, 0, 'Die optimale Verpackung Berechnung von Rauminhalt &amp; Oberfläche von Quadern', 20, 5, 25, 29, 3, '2016-07-01 14:10:43'),
(128, 4, 2, 1, 0, 0, '<b>Thema: <em>My life in a nutshell</em> (UV 5.1.2)</b>', 23, 7, 7, 13, 10, '2016-07-05 11:52:26'),
(96, 4, 3, 1, 0, 0, 'Veränderungen und Zustände beschreiben Rechnen mit ganzen Zahlen', 16, 4, 31, 34, 3, '2016-07-01 14:12:20'),
(97, 4, 3, 2, 0, 0, 'Die drei Gesichter einer Zahl Einführung der rationalen Zahlen', 20, 4, 1, 4, 3, '2016-07-01 14:15:16'),
(98, 4, 3, 2, 0, 0, 'Entwicklung und Reflexion von Problemlösestrategien<br />\r\nAddition und Subtraktion von Brüchen und ', 20, 5, 6, 10, 3, '2016-07-01 14:17:06'),
(99, 4, 3, 2, 0, 0, 'Kunst und Architektur<br />\r\nWinkel und Kreis zeichnen', 20, 5, 12, 16, 3, '2016-07-01 14:18:12'),
(100, 4, 3, 2, 0, 0, 'Wir planen einen Garten<br />\r\nMultiplikation und Division von Brüchen und Dezimalzahlen', 20, 5, 18, 22, 3, '2016-07-01 14:20:11'),
(101, 4, 3, 2, 0, 0, 'Wir führen eine Befragung durch <br />\r\nGrundlagen der Stochastik erarbeiten', 16, 4, 24, 27, 3, '2016-07-01 14:21:47'),
(102, 4, 3, 2, 0, 0, 'Zahlenmuster mit Termen beschreiben<br />\r\nProblemlösen und Muster erkunden', 20, 5, 29, 33, 3, '2016-07-01 14:23:01'),
(103, 4, 3, 3, 0, 0, 'Guthaben und Schulden<br />\r\nMit rationalen Zahlen rechnen', 18, 4, 1, 4, 3, '2016-07-01 14:24:46'),
(104, 4, 3, 3, 0, 0, 'Winkel in Figuren erschließen<br />\r\nWinkelsätze entdecken und anwenden', 12, 3, 6, 8, 3, '2016-07-01 14:25:38'),
(105, 4, 3, 3, 0, 0, 'Kosten mit dem Tabellenkalkulationsprogramm berechnen<br />\r\nTerme mit Variablen aufstellen und bere', 8, 2, 10, 11, 3, '2016-07-01 14:28:31'),
(106, 4, 3, 3, 0, 0, 'In die Zukunft schauen, mit gegebenen Werten Voraussagen treffen<br />\r\nRechnen in proportionalen un', 20, 5, 13, 17, 3, '2016-07-01 14:28:32'),
(107, 4, 3, 3, 0, 0, 'Rund ums Geld: Günstig einkaufen und Geld anlegen<br />\r\nProzente und Zinsen berechnen', 12, 3, 19, 21, 3, '2016-07-01 15:03:07'),
(108, 4, 3, 3, 0, 0, 'Landschaften vermessen<br />\r\nKongruente Dreiecke konstruieren', 16, 4, 23, 26, 3, '2016-07-01 14:31:57'),
(109, 4, 3, 3, 0, 0, 'Wie arbeitet ein Marktforschungsinstitut?<br />\r\nErhebung und Auswertung großer Datenmengen', 16, 4, 28, 31, 3, '2016-07-01 14:31:46'),
(110, 4, 3, 3, 0, 0, 'Berechnungen an Figuren auf unterschiedliche Weise durchführen<br />\r\nTerme umformen', 12, 3, 33, 35, 3, '2016-07-01 14:33:12'),
(111, 4, 3, 3, 0, 0, 'Knack&#039; die Box<br />\r\nEinfache Gleichungen lösen', 8, 2, 37, 38, 3, '2016-07-01 14:35:22'),
(112, 4, 3, 4, 0, 0, 'Zusammengesetzte Flächen<br />\r\nAnwendung von binomischen Formeln', 12, 3, 1, 3, 3, '2016-07-01 14:36:52'),
(113, 4, 3, 4, 0, 0, 'Mit der Mathe-Brille unterwegs<br />\r\nLineare Funktionen in Alltagssituationen entdecken', 20, 5, 5, 9, 3, '2016-07-01 14:38:06'),
(114, 4, 3, 4, 0, 0, 'Unbekannte Werte finden mit System<br />\r\nLineare Gleichungen und Gleichungssysteme lösen', 24, 6, 11, 16, 3, '2016-07-01 14:39:13'),
(115, 4, 3, 4, 0, 0, 'Mit Wahrscheinlichkeiten Vorhersagen machen<br />\r\nZufallsversuche durchführen und beschreiben', 20, 5, 18, 22, 3, '2016-07-01 14:40:31'),
(116, 4, 3, 4, 0, 0, 'Auf dem Weg zu irrationalen Zahlen<br />\r\nBestimmen von Seitenlängen quadratischer Flächen', 16, 4, 24, 27, 3, '2016-07-01 14:41:50'),
(117, 4, 3, 4, 0, 0, 'Vermutungen durch Messen und Wiegen gewinnen bzw. validieren<br />\r\nBerechnungen an Kreisen und Körp', 20, 5, 29, 33, 3, '2016-07-01 14:42:38'),
(118, 4, 3, 5, 0, 0, 'Modellieren mit Parabeln<br />\r\nQuadratische Funktionen', 14, 5, 1, 5, 3, '2016-07-01 14:44:49'),
(119, 4, 3, 5, 0, 0, 'Entwickeln und Anwenden von Lösungsverfahren zum Lösen quadratischer Gleichungen<br />\r\nQuadratische', 9, 3, 7, 9, 3, '2016-07-01 14:48:52'),
(120, 4, 3, 5, 0, 0, 'Riesig groß und winzig klein - wie notieren wir das in Zahlen?<br />\r\nDarstellen von Zahle', 3, 2, 11, 12, 3, '2016-07-01 14:56:50'),
(121, 4, 3, 5, 0, 0, 'Wie sich Sparen lohnt<br />\r\nExponentielles Wachstum beschreiben', 9, 3, 14, 16, 3, '2016-07-01 14:48:48'),
(122, 4, 3, 5, 0, 0, 'Was macht ein Zoom?<br />\r\nBerechnungen mithilfe von Ähnlichkeitsbeziehungen', 3, 3, 18, 20, 3, '2016-07-01 14:49:52'),
(123, 4, 3, 5, 0, 0, 'Wie wichtig ist der rechte Winkel?<br />\r\nDie Sätze von Pythagoras und Thales beweisen und anwenden', 14, 5, 22, 26, 3, '2016-07-01 14:51:12'),
(124, 4, 3, 5, 0, 0, 'Wie wird die Welt vermessen?<br />\r\nEinführung in Trigonometrie', 9, 3, 28, 30, 3, '2016-07-01 14:51:52'),
(125, 4, 3, 5, 0, 0, 'Mogelpackungen und Design<br />\r\nOberfläche und Volumen berechnen', 9, 3, 32, 34, 3, '2016-07-01 14:52:38'),
(126, 4, 3, 5, 0, 0, 'Sinus-Funktion<br />\r\nDarstellung periodischer Vorgänge', 6, 2, 36, 37, 3, '2016-07-01 14:53:42'),
(127, 4, 3, 5, 0, 0, 'Wie lügt man mit Statistik?<br />\r\nManipulationen erkennen', 8, 3, 39, 41, 3, '2016-07-01 14:54:55'),
(129, 4, 2, 1, 0, 0, '<b>Thema: <em>My new school</em> (UV 5.1.3)</b>', 23, 7, 14, 20, 10, '2016-07-05 11:50:51'),
(130, 4, 2, 1, 0, 0, '<b>Thema: <em>Fun in town</em> (UV 5.2.1)</b>', 20, 6, 21, 26, 10, '2016-07-05 11:57:36'),
(131, 4, 2, 1, 0, 0, 'Thema: <em>Let`s go shopping</em> (UV 5.2.2)', 20, 6, 27, 32, 10, '2016-07-05 19:17:36'),
(132, 4, 2, 1, 0, 0, 'Thema: <em>It`s my party</em> (UV 5.2.3)', 19, 5, 33, 37, 10, '2016-07-05 18:54:27'),
(133, 4, 2, 2, 0, 0, '<b>Thema: <em>Good-bye holidays</em>  (UV 6.1.1)</b>', 19, 5, 1, 5, 10, '2016-07-05 12:32:19'),
(134, 4, 2, 2, 0, 0, '<b>Thema: <em>School life here and abroad</em>  (UV 6.1.2)</b>', 17, 6, 6, 11, 10, '2016-07-05 12:36:10'),
(135, 4, 2, 2, 0, 0, '<b>Thema: <em>I love London</em>  (UV 6.1.3)</b>', 24, 7, 12, 18, 10, '2016-07-05 12:41:35'),
(136, 4, 2, 2, 0, 0, '<b>Thema: <em>How do you keep fit?</em>  (UV 6.2.1)</b>', 19, 6, 19, 24, 10, '2016-07-05 12:45:25'),
(137, 4, 2, 2, 0, 0, '<b>Thema: <em>We are moving - let`s keep in touch</em>  (UV 6.2.2)</b>', 17, 5, 25, 29, 10, '2016-07-05 18:55:04'),
(138, 4, 2, 2, 0, 0, '<b>Thema: <em>Mysterious Britain</em>  (UV 6.2.3)</b>', 24, 7, 30, 36, 10, '2016-07-05 12:52:36'),
(139, 4, 2, 3, 0, 0, '<b>Thema: <em>Sport around the world</em> (UV 7.1.1)</b>', 20, 5, 1, 5, 10, '2016-07-05 12:55:54'),
(140, 4, 2, 3, 0, 0, '<b>Thema: <em>The power of language! magazines, commercials &amp; co</em> (UV 7.1.2)</b>', 17, 5, 6, 10, 10, '2016-07-05 12:59:29'),
(141, 4, 2, 3, 0, 0, '<b>Thema: <em>Digging deep - the industrial revolution from a child`s perspective</em> (UV 7.1.3)</b', 23, 7, 11, 17, 10, '2016-07-06 09:01:28'),
(142, 4, 2, 3, 0, 0, '<b>Thema: <em>We are British - regions of the UK</em> (UV 7.2.1)</b>', 19, 6, 18, 23, 10, '2016-07-05 13:19:44'),
(143, 4, 2, 3, 0, 0, '<b>Thema: <em>Dealing with differences - being tolerant and accepting</em> (UV 7.2.2)</b>', 17, 5, 24, 28, 10, '2016-07-05 13:23:34'),
(144, 4, 2, 4, 0, 0, '<b>Thema: <em>New York - off to the New World: immigration to the US</em> (UV 8.1.1)</b>', 20, 5, 1, 5, 10, '2016-07-05 13:27:04'),
(145, 4, 2, 4, 0, 0, '<b>Thema: <em>School and part-time jobs</em> (UV 8.1.2)</b>', 20, 6, 6, 11, 10, '2016-07-05 13:30:33'),
(146, 4, 2, 4, 0, 0, '<b>Thema: <em>Texas - bigger is better</em> (UV 8.2.1)</b>', 14, 5, 12, 16, 10, '2016-07-05 13:35:36'),
(147, 4, 2, 4, 0, 0, '<b>Thema: <em>The American West: Native Americans today</em> (UV 8.2.2)</b>', 20, 7, 17, 23, 10, '2016-07-05 13:38:17'),
(148, 4, 2, 4, 0, 0, '<b>Thema: <em>The Media: behind the scenes</em> (UV 8.2.3)</b>', 16, 5, 24, 28, 10, '2016-07-05 13:42:02'),
(149, 4, 2, 5, 0, 0, '<b>Thema: <em>Your dream job - get the future started</em> (UV 9.1.1)</b>', 18, 5, 1, 5, 10, '2016-07-05 13:46:39'),
(150, 4, 2, 5, 0, 0, '<b>Thema: <em>Down under in Australia</em> (UV 9.1.2)</b>', 20, 6, 6, 11, 10, '2016-07-05 13:49:20'),
(151, 4, 2, 5, 0, 0, '<b>Thema: <em>&quot;Get up, stand up, stand up for your rights&quot;</em> (Bob Marley) (UV 9.2.1)</b', 23, 7, 12, 18, 10, '2016-07-06 09:04:21'),
(152, 4, 2, 5, 0, 0, '<b>Thema: <em>Youth literature - the world of teens (Bob Marley)</em> (UV 9.2.2)</b>', 29, 8, 19, 26, 10, '2016-07-05 13:57:18'),
(153, 4, 12, 2, 0, 0, 'Une idée super? - Non, c`est l`horreur!<br />\r\n- Les amis et les activités ', 15, 6, 5, 10, 11, '2016-09-06 12:07:00'),
(154, 4, 12, 2, 0, 0, 'Ensemble on s`amuse<br />\r\n - Moi et ma famille - ', 15, 6, 11, 16, 11, '2016-09-06 12:07:28'),
(155, 4, 12, 2, 0, 0, 'L`école en France - c`est mieux ? - La vie à l`école -<br />\r\n', 15, 6, 17, 22, 11, '2016-09-06 12:07:47'),
(156, 4, 12, 2, 0, 0, 'Tu viens chez moi? - Voilà ma maison  - ', 15, 6, 23, 28, 11, '2016-09-06 12:08:10'),
(157, 4, 12, 2, 0, 0, 'Faire la fête - Une année en France: fêtes et traditions ', 15, 6, 29, 34, 11, '2016-09-06 12:08:30'),
(158, 4, 12, 2, 0, 0, 'Sur le pont d` Avignon ...<br />\r\nVisiter la ville d` Avignon ', 15, 8, 35, 42, 11, '2016-09-06 12:09:59'),
(159, 4, 12, 2, 0, 0, 'Le tour de France - Passer les grandes vacances en France ', 15, 8, 43, 50, 11, '2016-09-06 12:15:21'),
(160, 4, 12, 3, 0, 0, 'Les écoles du désert - Apprendre ici et ailleurs ', 20, 10, 1, 10, 11, '2016-09-06 12:22:39'),
(161, 4, 12, 3, 0, 0, 'Contre-courants - Mille visages mais tout simplement moi -', 20, 10, 11, 20, 11, '2016-09-06 12:26:55'),
(162, 4, 12, 3, 0, 0, 'Classe découverte - Géo ado: Les aventuriers de la France ', 20, 9, 21, 29, 11, '2016-09-06 12:48:43'),
(163, 4, 12, 3, 0, 0, 'Petit(e)s chefs', 20, 9, 30, 38, 11, '2016-09-06 12:49:07'),
(164, 4, 12, 3, 0, 0, 'Notre Terre - Les bons réflexes pour la planète -', 20, 7, 39, 45, 11, '2016-09-06 12:49:58'),
(165, 4, 12, 3, 0, 0, 'Grignottes - À chacun son goût -', 20, 7, 46, 52, 11, '2016-09-06 12:55:16'),
(166, 4, 12, 4, 0, 0, 'Paris - ville de mille visages<br />\r\n- La capitale hier et aujourd`hui -', 20, 9, 1, 9, 11, '2016-09-06 13:01:20'),
(167, 4, 12, 4, 0, 0, 'Tous ensemble - Ma vie en communauté -', 15, 7, 10, 16, 11, '2016-09-06 13:06:38'),
(168, 4, 12, 4, 0, 0, 'Réel ou virtuel? - Les médias et moi -', 20, 10, 17, 26, 11, '2016-09-06 13:10:36'),
(169, 4, 12, 4, 0, 0, 'Bizarre, les Allemands, bizarre, les Français!<br />\r\n- On prépare un échange -', 20, 10, 27, 36, 11, '2016-09-06 13:17:03'),
(170, 4, 12, 4, 0, 0, 'On parle français ici ? !<br />\r\n - Des pays francophones dans le monde entier - ', 20, 10, 37, 46, 11, '2016-09-06 13:23:09'),
(171, 4, 12, 5, 0, 0, 'Partir à l`étrange ... oui ou non ?<br />\r\n- Apprendre la vie dans un pays francophone -', 25, 11, 1, 11, 11, '2016-09-06 13:31:01'),
(172, 4, 12, 5, 0, 0, 'Les petits spectacles à ciel ouvert - Petit aperçu de festivals de musique, de théâtre, de cinéma', 25, 12, 12, 23, 11, '2016-09-06 13:38:25'),
(173, 4, 12, 5, 0, 0, 'C`est ici qu`on lit - Rencontres littéraires ', 25, 12, 24, 35, 11, '2016-09-06 13:43:03'),
(174, 4, 12, 5, 0, 0, 'Les bagages sont prêts. Allons-y.<br />\r\n - Voyage virtuel sur l`Île de la Réunion -', 25, 12, 36, 47, 11, '2016-09-06 13:51:17');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t520_ein_r_uv_textfelder`
--

DROP TABLE IF EXISTS `part_t520_ein_r_uv_textfelder`;
CREATE TABLE `part_t520_ein_r_uv_textfelder` (
  `uv_id` int(12) NOT NULL COMMENT 'ID für das Unterrichtsvorhaben, Teil-Primärschlüssel',
  `textfeld_id` int(10) NOT NULL COMMENT 'ID für Textfeld, Teil-Primärschlüssel',
  `uv_text` text COMMENT 'Textwert für dieses Feld'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Weitere Text-Angaben zu Unterrichtsvorhaben';

--
-- Daten für Tabelle `part_t520_ein_r_uv_textfelder`
--

INSERT INTO `part_t520_ein_r_uv_textfelder` (`uv_id`, `textfeld_id`, `uv_text`) VALUES
(37, 2, 'Evolutionäre Entwicklung<br />\r\n<ul><li>Fossilien<br />\r</li><li>Stammesentwicklung der Wirbeltiere und des Menschen</li></ul>'),
(37, 3, 'UF2 Konzepte unterscheiden und auswählen<br />\r\nE9 Arbeits- und Denkweisen reflektieren<br />\r\nB3 Werte und Normen berücksichtigen'),
(37, 4, '<ul><li>Unterscheidung von relevanten und nicht relevanten Informationen bei Recherchen<br />\r</li><li>Begrenztheit wissenschaftlicher Aussagen, z. B. zu Methoden der Altersbestimmung bei Fossilien<br />\r</li><li>Geltungsbereich nicht naturwissenschaftlicher Vorstellungen, z. B. zur Entwicklung von Lebewesen</li></ul>'),
(36, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_8.2_1.html'),
(36, 2, 'Evolutionäre Entwicklung<br />\r\n<ul><li>Fossilien<br />\r</li><li>Evolutionsfaktoren</li></ul>'),
(36, 3, 'E3 Hypothesen entwickeln<br />\r\nE7 Modelle auswählen und Modellgrenzen angeben<br />\r\nK2 Informationen identifizieren'),
(36, 4, '<ul><li>Präzisierung von Problemen im Hinblick auf die Angepasstheit von Lebewesen an ihren Lebensraum und ihren Fortpflanzungserfolg<br />\r</li><li>wissenschaftliche Theorie, Gesetze und Regeln beschreiben und Unterschiede erkennen<br />\r</li><li>Ergebnisse verschiedener wissenschaftlicher Funde bezüglich einer Fragestellung interpretieren</li></ul>'),
(34, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_8.1_1.html'),
(34, 4, '<ul><li>systemrelevante Veränderungen durch einzelne Faktoren<br />\r</li><li>Systembegriff unter dem Aspekt des Zusammenwirkens von Einzelteilen zu einem Ganzen<br />\r</li><li>Kooperative Lernform für die Entscheidungsfindung und Entscheidungsbegründung zur Bedeutung von Modellen zum Energiefluss und Stoffkreisläufen<br />\r</li><li>Modellgrenzen an der komplexen Wirklichkeit erkennen</li></ul>'),
(35, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_8.1_2.html'),
(34, 2, 'Ökosysteme und ihre Veränderung<br />\r\n<ul><li>Energiefluss und Stoffkreisläufe</li></ul>'),
(34, 3, 'UF3 Sachverhalte ordnen und strukturieren<br />\r\nE7 Modelle auswählen und Modellgrenzen angeben<br />\r\nK7 Beschreiben, präsentieren, begründen'),
(35, 4, '<ul><li>Einschätzung von recherchierten Materialien auf Qualität und Verwertbarkeit<br />\r</li><li>Berücksichtigung kooperativer Lernformen wie Geben und Nehmen, Informationsaustausch mit mehreren Partnern mit dem Ziel der Wiederholung und Wissenserweiterung, z. B. zum anthropogen verursachten Treibhauseffekt</li></ul>'),
(35, 2, 'Ökosysteme und ihre Veränderung<br />\r\n<ul><li>Anthropogene Einwirkungen auf Ökosysteme</li></ul>'),
(35, 3, 'E9 Arbeits- und Denkweisen reflektieren<br />\r\nB2 Argumentieren und Position beziehen'),
(48, 3, 'UF3 Sachverhalte ordnen und strukturieren<br />\r\nE1 Fragestellungen erkennen<br />\r\nK5 Recherchieren<br />\r\nB1 Bewertungen an Kriterien orientieren'),
(48, 2, 'Elektrische Energie aus chemischen Reaktionen<br />\r\n<ul><li>Batterie und Akkumulator<br />\r</li><li>Brennstoffzelle<br />\r</li><li>Elektrolyse</li></ul>'),
(47, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-chemie/konkretisierte-unterrichtsvorhaben-9.1-.html'),
(47, 4, '<ul><li>Das PSE nutzen um Informationen über die Elemente und deren Beziehungen zueinander zu erhalten<br />\r</li><li>Atommodelle als Grundlage zum Verständnis des Periodensystem<br />\r</li><li>Historische Veränderung von Wissen als Wechselspiel zwischen neuen Erkenntnissen und theoretischen Modellen</li></ul>'),
(47, 3, 'UF3 Sachverhalte ordnen und strukturieren<br />\r\nE7 Modelle auswählen und Modellgrenzen angeben<br />\r\nE9 Arbeits- und Denkweisen reflektieren<br />\r\nK2 Informationen identifizieren'),
(47, 2, 'Elemente und ihre Ordnung<br />\r\n<ul><li>Elementfamilien<br />\r</li><li>Periodensystem<br />\r</li><li>Atombau</li></ul>'),
(46, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-chemie/konkretisierte-unterrichtsvorhaben-7.2-.html'),
(46, 4, '<ul><li>Wissen der Oxidation um Reduktion erweitern<br />\r</li><li>chemische Reaktion als Grundlage der Produktion von Stoffen (Metallen)<br />\r</li><li>Fachbegriffe dem alltäglichen Sprachgebrauch gegenüberstellen<br />\r</li><li>Anforderungen an Recherche in unterschiedlichen Medien<br />\r</li><li>Anforderungen an Präsentationen (mündl./schriftl.)</li></ul>'),
(46, 3, 'UF1 Fakten wiedergeben und erläutern<br />\r\nE4 Untersuchungen und Experimente planen<br />\r\nK1 Texte lesen und erstellen<br />\r\nK5 Recherchieren<br />\r\nK7 Beschreiben, präsentieren, begründen'),
(46, 2, 'Metalle und Metallgewinnung<br />\r\n<ul><li>Metallgewinnung und Recycling<br />\r</li><li>Gebrauchsmetalle<br />\r</li><li>Korrosion und Korrosionsschutz</li></ul>'),
(28, 4, '<ul><li>Erheben und Interpretieren von Messwerten bei Bewegungsvorgängen<br />\r</li><li>Formulieren physikalischer Gesetzmäßig­keiten mithilfe mathematischer Methoden (Proportionalitätsbegriff)</li></ul>'),
(27, 4, '<ul><li>Nutzen erworbenen Wissens zur Entwicklung neuer Hypothesen<br />\r</li><li>Interpretieren und Auswerten von Diagrammen<br />\r</li><li>Formulieren und Anwenden von Gesetzmäßigkeiten, auch mithilfe mathematischer Methoden</li></ul>'),
(28, 2, 'Bewegungen und ihre Ursachen<br />\r\n<ul><li>Bewegungen<br />\r</li><li>Kraft und Druck<br />\r</li><li>Auftrieb<br />\r</li><li>Satelliten und Raumfahrt</li></ul>'),
(28, 3, 'UF3 Sachverhalte ordnen und strukturieren<br />\r\nE5 Untersuchungen und Experimente durchführen<br />\r\nE6 Untersuchungen und Experimente auswerten'),
(27, 3, 'E3 Hypothesen entwickeln<br />\r\nK4 Daten aufzeichnen und darstellen<br />\r\nK7 Beschreiben, präsentieren, begründen'),
(27, 2, 'Stromkreise<br />\r\n<ul><li>Stromstärke und elektrischer Widerstand<br />\r</li><li>Gesetze des Stromkreises</li></ul>'),
(26, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/hinweise-und-beispiele-physik/konkretisierte-unterrichtsvorhaben-8.1-.html'),
(26, 4, '<ul><li>Modellieren natürlicher Phänomene und Überprüfen des Modells unter Laborbedingungen<br />\r</li><li>Einhalten von Regeln zum Schutz von Gesundheit und Sachwerten</li></ul>'),
(26, 3, 'E8 Modelle anwenden<br />\r\nB3 Werte und Normen berücksichtigen'),
(25, 4, '<ul><li>Kennenlernen des Feldbegriffs am Beispiel der Gravitation, Klassifizieren von Himmelsobjekten<br />\r</li><li>Entwickeln von Modellen und Weltbildern im historischen Kontext</li></ul>'),
(26, 2, 'Stromkreise<br />\r\n<ul><li>Spannung und Ladungstrennung</li></ul>'),
(25, 3, 'E7 Modelle auswählen und Modellgrenzen angeben<br />\r\nE9 Arbeits- und Denkweisen reflektieren<br />\r\nB2 Argumentieren und Position beziehen'),
(25, 2, 'Erde und Weltall<br />\r\n<ul><li>Himmelsobjekte<br />\r</li><li>Modelle des Universums<br />\r</li><li>Teleskope</li></ul>'),
(17, 2, 'Lebensräume und Lebensbedingungen<br />\r\n<ul><li>Erkundung eines Lebensraums<br />\r</li><li>Biotopen- und Artenschutz<br />\r</li><li>Extreme Lebensräume<br />\r</li><li>Züchtung von Tieren und Pflanzen</li></ul>'),
(17, 3, 'UF3 Sachverhalte ordnen und strukturieren<br />\r\nE3 Hypothesen entwickeln<br />\r\nK4 Daten aufzeichnen und darstellen<br />\r\nK7 Beschreiben, präsentieren, begründen'),
(17, 4, 'Entwickeln grundlegender Fertigkeiten beim naturwissenschaftlichen Arbeiten:<br />\r\n<ul><li>Ordnen<br />\r</li><li>Systematisieren<br />\r</li><li>Sachverhalte zusammenhängend beschreiben<br />\r</li><li>Vermutungen begründen<br />\r</li><li>einfache Formen des Argumentierens<br />\r</li><li>Sorgfältiges und zuverlässiges Erheben und Aufzeichnen von Daten<br />\r</li><li>Begründen, Argumentieren</li></ul>'),
(18, 2, 'Sonne, Wetter, Jahreszeiten<br />\r\n<ul><li>Die Erde im Sonnensystem<br />\r</li><li>Temperatur und Wärme<br />\r</li><li>Angepasstheit an die Jahreszeiten</li></ul>'),
(18, 3, 'E1 Fragestellungen erkennen<br />\r\nE5 Untersuchungen und Experimente durchführen<br />\r\nK2 Informationen identifizieren<br />\r\nK8 Zuhören, hinterfragen'),
(18, 4, '<ul><li>Bewusstmachen lebensnaher naturwissenschaftlichen Fragestellungen im Alltag<br />\r</li><li>Organisation und Durchführung von angeleiteten Experimenten<br />\r</li><li>Sachdienliche Informationen erkennen<br />\r</li><li>Verstehen einfacher schematischer Darstellungen</li></ul>'),
(18, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/hinweise-und-beispiele-physik/konkretisierte-unterrichtsvorhaben-5.1.html'),
(19, 2, 'Sinne und Wahrnehmung<br />\r\n<ul><li>Sinneserfahrungen und Sinnesorgane<br />\r</li><li>Sehen und Hören</li></ul>'),
(19, 3, 'E2 Bewusst wahrnehmen<br />\r\nE6 Untersuchungen und Experimente auswerten<br />\r\nE7 Modelle auswählen und Modellgrenzen angeben<br />\r\nK6 Informationen umsetzen'),
(19, 4, '<ul><li>An Fragestellungen orientiertes, bewusstes Beobachten<br />\r</li><li>Zielgerichtetes Vorgehen (vom Erkunden bis zur Entwicklung von Regeln)<br />\r</li><li>Vorhersagen auf der Grundlage einfacher Modelle (Lichtstrahl, Teilchenmodell)</li></ul>'),
(20, 2, 'Sinne und Wahrnehmung<br />\r\n<ul><li>Grenzen der Wahrnehmung</li></ul>'),
(20, 3, 'UF4 Wissen vernetzen<br />\r\nK1 Texte lesen und erstellen<br />\r\nK5 Recherchieren'),
(20, 4, '<ul><li>Erstellen eigener Suchbegriffe<br />\r</li><li>Kriterien geleitetes Recherchieren<br />\r</li><li>Kennenlernen und Einüben eines naturwissenschaftlichen Berichtsstils</li></ul>'),
(21, 2, 'Körper und Leistungsfähigkeit<br />\r\n<ul><li>Bewegungssystem<br />\r</li><li>Atmung und Blutkreislauf<br />\r</li><li>Ernährung und Verdauung<br />\r</li><li>Kräfte und Hebel</li></ul>'),
(21, 3, 'UF1 Fakten wiedergeben und erläutern<br />\r\nE5 Untersuchungen und Experimente durchführen<br />\r\nK9 Kooperieren und im Team arbeiten<br />\r\nB3 Werte und Normen berücksichtigen'),
(21, 4, '<ul><li>Datengewinnung durch Untersuchungen und Messungen<br />\r</li><li>Einschätzen eigener Ernährungsgewohnheiten<br />\r</li><li>Einschätzen gesundheitsförderlicher Verhaltensweisen unter Verwendung des erworbenen Fachwissens<br />\r</li><li>Einhalten von Regeln des gemeinsamen Experimentierens bei Partnerarbeit</li></ul>'),
(22, 2, 'Stoffe und Geräte des Alltags<br />\r\n<ul><li>Stoffeigenschaften<br />\r</li><li>Wirkungen des elektrischen Stroms</li></ul>'),
(22, 3, 'E4 Untersuchungen und Experimente planen<br />\r\nE8 Modelle anwenden<br />\r\nK3 Untersuchungen dokumentieren<br />\r\nK4 Daten aufzeichnen und darstellen'),
(22, 4, '<ul><li>Systematisches Durchführen von Untersuchungen<br />\r</li><li>Protokollieren von Untersuchungen, Schemazeichnungen eines Versuchsaufbaus<br />\r</li><li>Kennenlernen der Funktion eines Modells</li></ul>'),
(23, 2, 'Stoffe und Geräte des Alltags<br />\r\n<ul><li>Stoffeigenschaften<br />\r</li><li>Stofftrennung</li></ul>'),
(23, 3, 'UF2 Konzepte unterscheiden und auswählen<br />\r\nUF3 Sachverhalte ordnen und strukturieren<br />\r\nE5 Untersuchungen und Experimente durchführen<br />\r\nK9 Kooperieren und im Team arbeiten'),
(23, 4, '<ul><li>Vielfalt der Stoffe<br />\r</li><li>Anwendung von Prinzipien zur Unterscheidung und Ordnung von Stoffen<br />\r</li><li>erste Modellvorstellungen zur Erklärung von Stoffeigenschaften<br />\r</li><li>zuverlässige und sichere Zusammenarbeit mit Partnern<br />\r</li><li>Einhalten von Absprachen<br />\r</li></ul>'),
(23, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/hinweise-und-beispiele-physik/konkretisierte-unterrichtsvorhaben-6.1-.html'),
(24, 2, 'Optische Instrumente<br />\r\n<ul><li>Abbildungen mit Spiegeln und Linsen<br />\r</li><li>Linsensysteme<br />\r</li><li>Licht und Farbe</li></ul>'),
(24, 3, 'UF2 Konzepte unterscheiden und auswählen<br />\r\nE4 Untersuchungen und Experimente planen<br />\r\nK9 Kooperieren und im Team arbeiten'),
(24, 4, '<ul><li>Erklären natürlicher Phänomene und der Eigenschaften naturwissenschaftlicher Konzepte<br />\r</li><li>Zielgerichtetes Experimentieren unter Berücksichtigung fachmethodischer Grundsätze<br />\r</li><li>Treffen und Einhalten von Absprachen zu Zielen und Aufgaben bei Gruppenarbeiten</li></ul>'),
(29, 2, 'Energie, Leistung, Wirkungsgrad<br />\r\n<ul><li>Kraft, Arbeit und Energie</li></ul>'),
(29, 3, 'UF1 Fakten wiedergeben und erläutern<br />\r\nUF2 Konzepte unterscheiden und auswählen<br />\r\nE8 Modelle anwenden'),
(29, 4, '<ul><li>Definieren von grundlegenden physikalischen Begriffen und ihre Nutzung zu einfachen Berechnungen</li></ul>'),
(30, 2, 'Energie, Leistung, Wirkungsgrad<br />\r\n<ul><li>Maschinen und Leistung<br />\r</li><li>Energieumwandlung und Wirkungsgrad</li></ul>'),
(30, 3, 'UF4 Wissen vernetzen<br />\r\nE3 Hypothesen entwickeln<br />\r\nE4 Untersuchungen planen'),
(30, 4, '<ul><li>Beschreiben von Arbeit, Energie, Reibung und Wirkungsgrad in mechanischen Systemen<br />\r</li><li>Entwickeln und Überprüfen von Hypothesen nach Beobachtungen an einfachen Maschinen.</li></ul>'),
(31, 2, 'Elektrische Energieversorgung<br />\r\n<ul><li>Elektromagnetismus und Induktion<br />\r</li><li>Elektromotor und Generator</li></ul>'),
(31, 3, 'E5 Untersuchungen und Experimente durchführen<br />\r\nE8 Modelle anwenden'),
(31, 4, '<ul><li>Nutzen geeigneter Modelle zur Erklärung von Sachverhalten in komplexen Systemen</li></ul>'),
(31, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/hinweise-und-beispiele-physik/konkretisierte-unterrichtsvorhaben-10.1-.html'),
(32, 2, 'Elektrische Energieversorgung<br />\r\n<ul><li>Kraftwerke und Nachhaltigkeit</li></ul>'),
(32, 3, 'K6 Informationen umsetzen<br />\r\nK9 Kooperieren und im Team arbeiten<br />\r\nB1 Bewertungen an Kriterien orientieren<br />\r\nB3 Werte und Normen berücksichtigen'),
(32, 4, '<ul><li>Verwenden physikalischer Daten zu zielgerichtetem individuellen Handeln<br />\r</li><li>Kooperieren im Rahmen eines Projektes</li></ul>'),
(33, 2, 'Radioaktivität und Kernenergie<br />\r\n<ul><li>Atomkerne und Radioaktivität<br />\r</li><li>Ionisierende Strahlung<br />\r</li><li>Kernspaltung</li></ul>'),
(33, 3, 'K5 Recherchieren<br />\r\nK7 Beschreiben, präsentieren, begründen<br />\r\nK8 Zuhören, hinterfragen<br />\r\nB2 Argumentieren und Position beziehen'),
(33, 4, '<ul><li>Teilhaben am gesellschaftlichen Diskurs<br />\r</li><li>Individuelles Positionieren und Übernehmen von Verantwortung</li></ul>'),
(37, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_8.2_2.html'),
(38, 2, 'Gene und Vererbung<br />\r\n<ul><li>Klassische Genetik<br />\r</li><li>Molekulargenetik</li></ul>'),
(38, 3, 'UF2 Konzepte unterscheiden und auswählen<br />\r\nUF4 Wissen vernetzen<br />\r\nE9 Arbeits- und Denkweisen reflektieren'),
(38, 4, '<ul><li>wiederkehrende Prinzipien bei Erbgängen erkennen und auf neue Beispiele aus dem Tier- oder Pflanzenreich anwenden<br />\r</li><li>Unterscheidung zwischen Regeln und Gesetzen am Beispiel von Mendel</li></ul>'),
(38, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_8.2_3.html'),
(39, 2, 'Gene und Vererbung<br />\r\n<ul><li>Veränderungen des Erbgutes</li></ul>'),
(39, 3, 'K7 Beschreiben, präsentieren, begründen<br />\r\nB1 Bewertungen an Kriterien orientieren<br />\r\nB2 Argumentieren und Position beziehen'),
(39, 4, '<ul><li>Verschiedene Möglichkeiten der Veränderung des Erbgutes präsentieren<br />\r</li><li>Unterscheidung von Sachaussage und Wertung, z. B. zu gentechnisch veränderten Lebewesen<br />\r</li><li>Gewichtung von Bewertungskriterien<br />\r</li><li>Nachvollziehen kontroverser Positionen</li></ul>'),
(39, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_8.2_4.html'),
(40, 2, 'Stationen eines Lebens<br />\r\n<ul><li>Embryonen und Embryonenschutz</li></ul>'),
(40, 3, 'UF2 Konzepte unterscheiden und auswählen<br />\r\nK7 Beschreiben, präsentieren, begründen<br />\r\nB2 Argumentieren und Position beziehen'),
(40, 4, '<ul><li>Problembereiche des Embryonenschutzes aufzeigen anhand von biologisch-medizinischen Hintergründen und rechtlichen Problemen<br />\r</li><li>Fachlich korrekte und kritisch distanzierte Präsentation von Sachverhalten<br />\r</li><li>Fachlich fundierte Kenntnisse von unfachlichen Aussagen abgrenzen</li></ul>'),
(40, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_9.1_1.html'),
(41, 2, 'Stationen eines Lebens<br />\r\n<ul><li>Gesundheitsvorsorge<br />\r</li><li>Organtransplantation</li></ul>'),
(41, 3, 'UF4 Wissen vernetzen<br />\r\nE1 Fragestellungen erkennen<br />\r\nE2 Bewusst wahrnehmen<br />\r\nK9 Kooperieren und im Team arbeiten'),
(41, 4, '<ul><li>Sachliche Fundierung von Lebensentscheidungen<br />\r</li><li>Auseinandersetzung mit dem Zeitpunkt des klinischen Todes<br />\r</li><li>Auseinandersetzung mit der Problematik der Organspende in kooperativen Lernformen</li></ul>'),
(42, 2, 'Information und Regulation<br />\r\n<ul><li>Gehirn und Lernen</li></ul>'),
(41, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_9.1_2.html'),
(42, 3, 'UF1 Fakten wiedergeben und erläutern<br />\r\nUF4 Wissen vernetzen<br />\r\nE8 Modelle anwenden'),
(42, 4, '<ul><li>Neuronale Grundlagen als Voraussetzung für die Verarbeitung von Impulsen<br />\r</li><li>Überprüfung von Modellen zum Lernen für das eigene Lernverhalten<br />\r</li><li>Eigenes Lernverhalten anhand von Modellvorstellungen reflektieren<br />\r</li><li>Optimierung des eigenen Lernverhaltens, &amp;<em>8222;Gehirn-Jogging&amp;</em>8220;, Lernerfolg</li></ul>'),
(42, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_9.2_1.html'),
(43, 2, 'Information und Regulation<br />\r\n<ul><li>Lebewesen kommunizieren</li></ul>'),
(43, 3, 'UF3 Sachverhalte ordnen und strukturieren<br />\r\nK1 Texte lesen und erstellen<br />\r\nK6 Informationen umsetzen<br />\r\nB1 Bewertungen an Kriterien orientieren'),
(43, 4, '<ul><li>Einschätzen und Nutzen aktueller Forschungsergebnisse zur Bedeutung von Farbsignalen bei Tieren<br />\r</li><li>Rolle von Fachsprache bei der Beschreibung der Bedeutung biologisch wirksamer Stoffe wie Antibiotika oder Pheromone erkennen<br />\r</li><li>Signalwirkung und Signaltäuschung in der Werbung als Einflussgröße auf persönliche Entscheidungen benennen</li></ul>'),
(43, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_9.2_2.html'),
(44, 2, 'Information und Regulation<br />\r\n<ul><li>Immunbiologie</li></ul>'),
(44, 3, 'E6 Untersuchungen und Experimente auswerten<br />\r\nE7 Modelle auswählen und Modellgrenzen angeben<br />\r\nK3 Untersuchungen dokumentieren<br />\r\nB3 Werte und Normen berücksichtigen'),
(44, 4, '<ul><li>Vorstellungen zum Immunsystem aus historischer und moderner Sicht<br />\r</li><li>Visualisierung und Versprachlichung komplexer Zusammenhänge zur spezifischen Immunabwehr im freien Vortrag mit Hilfe von Modellen<br />\r</li><li>Persönliche Entscheidungen zur Erhaltung der Gesundheit treffen und deren gesellschaftliche Relevanz erkennen<br />\r</li><li>Bedeutung des Impfverhaltens für die Gesellschaft erkennen</li></ul>'),
(44, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-biologie/uv_9.2_3.html'),
(45, 2, 'Energieumsätze bei Stoffveränderungen<br />\r\n<ul><li>Verbrennung<br />\r</li><li>Oxidation<br />\r</li><li>Stoffumwandlung</li></ul>'),
(45, 3, 'UF3 Sachverhalte ordnen und strukturieren<br />\r\nE2 Bewusst wahrnehmen<br />\r\nE5 Untersuchungen/Experimente durchführen<br />\r\nE6 Untersuchungen/Experimente auswerten'),
(45, 4, '<ul><li>Kennzeichen chemischer Reaktionen, insbesondere der Oxidation<br />\r</li><li>Anforderungen an naturwissenschaftliche Untersuchungen<br />\r</li><li>Zielgerichtetes Beobachten<br />\r</li><li>objektives Beschreiben<br />\r</li><li>Interpretieren der Beobachtungen<br />\r</li><li>Möglichkeiten der Verallgemeinerung<br />\r</li><li>Einführung in einfache Atomvorstellungen<br />\r</li><li>Element, Verbindung</li></ul>'),
(45, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-chemie/konkretisierte-unterrichtsvorhaben-7.1-.html'),
(48, 4, '<ul><li>Chemische Reaktionen (erweiterter Redoxbegriff) durch Elektronenaustausch als Lösung technischer Zukunftsfragen, u.a. zur Energiespeicherung<br />\r</li><li>Orientierungswissen für den Alltag<br />\r</li><li>Technische Anwendung chemischer Reaktionen und ihre Modellierung</li></ul>'),
(48, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-chemie/konkretisierte-unterrichtsvorhaben-9.1_2-.html'),
(49, 2, 'Säuren und Basen<br />\r\n<ul><li>Eigenschaften saurer und alkalischer Lösungen<br />\r</li><li>Neutralisation<br />\r</li><li>Eigenschaften von Salzen</li></ul>'),
(49, 3, 'UF1 Fakten wiedergeben und erläutern<br />\r\nE3 Hypothesen entwickeln<br />\r\nE5 Untersuchungen und Experimente durchführen<br />\r\nE8 Modelle anwenden<br />\r\nK1 Texte lesen und erstellen<br />\r\nK2 Informationen identifizieren<br />\r\nK7 Beschreiben, präsentieren, begründen<br />\r\nB1 Bewertungen an Kriterien orientieren'),
(49, 4, '<ul><li>Vorhersage von Abläufen und Ergebnissen auf der Grundlage von Modellen der chemischen Reaktion<br />\r</li><li>Formalisierte Beschreibung mit Reaktionsschemata<br />\r</li><li>Betrachtung alltäglicher Stoffe aus naturwissenschaftlicher Sicht<br />\r</li><li>Aufbau von Stoffen<br />\r</li><li>Bindungsmodelle<br />\r</li><li>Verwendung der Stoffe kritisch hinterfragen</li></ul>'),
(49, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-chemie/konkretisierte-unterrichtsvorhaben-9.2.html'),
(50, 2, 'Stoffe als Energieträger<br />\r\n<ul><li>Alkane<br />\r</li><li>Alkanole<br />\r</li><li>Fossile und regenerative Energierohstoffe</li></ul>'),
(50, 3, 'UF2 Konzepte unterscheiden und auswählen<br />\r\nUF3 Sachverhalte ordnen und strukturieren<br />\r\nE4 Untersuchungen und Experimente planen<br />\r\nK5 Recherchieren<br />\r\nB2 Argumentieren und Position beziehen<br />\r\nB3 Werte und Normen berücksichtigen'),
(50, 4, '<ul><li>Grundlagen der Kohlenstoffchemie<br />\r</li><li>Nomenklaturregeln<br />\r</li><li>Meinungsbildung zur gesellschaftlichen Bedeutung fossiler Rohstoffe und deren zukünftiger Verwendung<br />\r</li><li>Aufzeigen zukunftsweisender Forschung</li></ul>'),
(50, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-chemie/konkretisierte-unterrichtsvorhaben-10.1_2.html'),
(51, 2, 'Produkte der Chemie<br />\r\n<ul><li>Makromoleküle in Natur und Technik<br />\r</li><li>Struktur und Eigenschaften ausgesuchter Verbindungen<br />\r</li><li>Nanoteilchen und neue Werkstoffe</li></ul>'),
(51, 3, 'UF3 Sachverhalte ordnen und strukturieren<br />\r\nE8 Modelle anwenden<br />\r\nK8 Zuhören, hinterfragen<br />\r\nB2 Argumentieren und Position beziehen'),
(51, 4, '<ul><li>Chemieindustrie als Wirtschaftsfaktor und Berufsfeld<br />\r</li><li>ethische Maßstäbe der Produktion und Produktverwendung<br />\r</li><li>Chancen und Risiken von Produkten und Produktgruppen abwägen<br />\r</li><li>Standpunkt beziehen<br />\r</li><li>Position begründet vertreten<br />\r</li><li>formalisierte Modelle und formalisierte Beschreibungen zur Systematisierung<br />\r</li><li>Dokumentation und Präsentation komplexer Zusammenhänge</li></ul>'),
(51, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gesamtschule/naturwissenschaften/hinweise-und-beispiele/schulinterner-lehrplan-chemie/konkretisierte-unterrichtsvorhaben-10.2-.html'),
(67, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>die Mehrdeutigkeit lateinischer Wörter erklären<br />\r</li><li>für lateinische Wörter Entsprechungen im Deutschen finden<br />\r</li><li>Fremd- und Lehnwörter erkennen<br />\r</li><li>Wortarten unterscheiden<br />\r</li><li>einfache Sätze, Satzreihen und Satzgefüge unterscheiden<br />\r</li><li>die Bestandteile des AcI benennen<br />\r</li><li>die Verwendung der Tempora und Diathesen beschreiben <br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>für die Texterschließung Wortblöcke im Text markieren<br />\r</li><li>Sinnerwartungen überprüfen<br />\r</li><li>ansatzweise zielsprachengerecht übersetzen<br />\r</li><li>sprachlich-stilistische Mittel benennen und ihre Wirkung beschreiben<br />\r</li><li>partiell Sinninhalte stilistisch angemessen ausdrücken<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>sich ansatzweise in Denk- und Verhaltensweisen der Menschen der Antike hineinversetzen<br />\r</li></ul>'),
(68, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömische Geschichte/<br />\r\nStaat und Gesellschaft<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nGliedsätze/Satzgefüge<br />\r\nSubjunktionen<br />\r\nTempora (Fut., Plqpf)<br />\r\n'),
(68, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>die wesentlichen Bedeutungen der lateinischen Wörter nennen und erklären<br />\r</li><li>für lateinische Wörter und Wendungen im Deutschen sinngerechte Entsprechungen wählen<br />\r</li><li>Formen bestimmen, unterscheiden und ihre Funktion erklären<br />\r</li><li>in Satzgefügen die Satzebenen bestimmen<br />\r</li><li>verschiedene Ausdrucksformen für Aussagen, Fragen und Aufforderungen unterscheiden<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>Gliedsätze erkennen und unterscheiden<br />\r</li><li>Texte durch Hörverstehen erfassen<br />\r</li><li>semantische Merkmale benennen<br />\r</li><li>syntaktische Strukturelemente eines Textes beschreiben<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>sich in Denk- und Verhaltensweisen der Menschen der Antike hineinversetzen und Bereitschaft zum Perspektivenwechsel zeigen<br />\r</li></ul>'),
(17, 5, 'Link zum schulinternen Lehrplan UV &quot;Tiere und Pflanzen&quot;<br />\r\nhttp://www.meineSchule.de/intern/nw/jg5/tiereundpflanzen.pdf'),
(63, 5, '<b>Entlastung im Jg 5:</b><br />\r\nAnknüpfung an Grundschulkompetenzen:<br />\r\n<ul><li><em>listening/speaking</em>, u.a. dem <em>classroom discourse</em> folgen; über sich und die Familie Auskunft geben und entsprechende Fragen stellen (vgl. Lehrplan Englisch Grundschule S. 77)<br />\r</li><li><em>Erfahrungsfelder</em> &quot;zu Hause hier und dort&quot; und &quot;lernen, arbeiten, freie Zeit&quot; (vgl. ebd. S. 76)<br />\r</li></ul><br />\r\n<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.1.1-hello.html'),
(59, 5, '<b>Konkretisierung des UV:</b><br />\r\n1. Sequenz: http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/5.-wir-und-unsere-neue-schule-erste-sequenz-reden-und-erzaehlen.html<br />\r\n2. Sequenz: http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/5.-wir-und-unsere-neue-schule-zweite-sequenz-schulgeschichten.html'),
(60, 5, '<b>Konkretisierung des UV:</b><br />\r\n1. Sequenz: http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/5.-tiere-hier-und-anderswo-tiere-beschreiben.html<br />\r\n2. Sequenz: http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/5.-tiere-hier-und-anderswo-ich-wuensche-mir-ein-tier.html'),
(62, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Musik: Rap der Vorfahrtsregeln<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>schridftliche Subtraktion mit maximal zwei Subtrahenden, schriftliche Division mit maximal zweistelligen Divisoren</li></ul>'),
(65, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>Bedeutung lateinischer Wörter nennen<br />\r</li><li>Wortfamilien und Sachfelder bilden<br />\r</li><li>Wörter in anderen Sprachenauf ihre lateinische Ausgangsform zurückführen<br />\r</li><li>Indikativ und Imperativ beschreiben (und wiedergeben)<br />\r</li><li>Kasusfunktionen beschreiben und wiedergeben<br />\r</li><li>die Grundelemente des Formenbaus und deren Funktionen benennen<br />\r</li><li>Formen bestimmen und auf ihre Grundform zurückführen<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>durch Hörverstehen zentrale Aussagen erfassen<br />\r</li><li>Sprech- und Erzählsituationen in Texten unterscheiden<br />\r</li><li>ein vorläufiges Sinnverständnis formulieren<br />\r</li><li>für die Texterschließung Morpheme identifizieren<br />\r</li><li>semantische und syntaktische Phänomene bestimmen<br />\r</li><li>einzelne Sätze erschließen<br />\r</li><li>Textsorten unterscheiden<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>Bereiche des römischen Lebens benennen und beschreiben<br />\r</li><li>diese Bereiche mit der eigenen Lebenswelt vergleichen<br />\r</li></ul>'),
(63, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nFamilie, Freunde, tägliches Leben, Freizeit<br />\r\n<br />\r\n<b>Berufsorientierung:</b><br />\r\nbekannte Berufe im eigenen Umfeld'),
(63, 3, '<b>KK:</b><br />\r\n<em>Hör-/Hörsehverstehen, Sprechen: an Gesprächen teilnehmen:</em><br />\r\nin Alltagssituationen personenbezogene Informationen/Auskünfte verstehen, geben, einholen<br />\r\n<em>(focus speech act: asking for and giving information)</em><br />\r\n<br />\r\n<b>Sprachliche Mittel:</b><br />\r\n<em>Aussprache und Intonation:</em><br />\r\ndie Intonation von einfachen Aussagesätzen, Fragen und Aufforderungen angemessen realisieren<br />\r\n'),
(64, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nFreunde, Kennenlernen, erstes Aufeinandertreffen'),
(64, 3, '<b>Hör/Hör-Sehverstehen</b><br />\r\n<ul><li>Identifizierung und Einoednung von Sprechern in ritualisierten Kontaktsituationen<br />\r</li><li>ritualisierte Bitten, Fragen, Aufforderungen und Erklärungen einordnen und verstehen<br />\r</li></ul><br />\r\n<b>Sprechen: an Gesprächen teilnehmen</b><br />\r\n<ul><li>reproduktives Sprechen in ritualisierten Kontaktsituationen <em>(première prise de contact, discours en classe)</em></li></ul>'),
(65, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömische Alltagskultur/Rezeption und Tradition<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nDer einfache Satz und seine ersten Grundelemente<br />\r\nKasuslehre (N, Akk, Abl, Dat)<br />\r\nTempora (Präsens)'),
(56, 2, 'Die Schülerinnen und Schüler... <br />\r\n<ul><li>erheben Daten und fassen sie in Ur- und Strichlisten zusammen.<br />\r</li><li>stellen Häufigkeitstabellen zusammen und veranschaulichen diese mit Hilfe von Säulendiagrammen.<br />\r</li><li>lesen und interpretieren statistische Darstellungen.<br />\r</li><li>stellen [...] Zahlen [hier: natürliche Zahlen und einfache Dezimalzahlen] auf verschiedene Weise dar (Zahlengerade, Zifferndarstellung, Stellenwerttafel, Wortform).<br />\r</li><li>ordnen und vergleichen Zahlen und runden natürliche Zahlen und Dezimalzahlen.<br />\r</li><li>stellen Größen [hier: Länge, Masse und Zeit] in Sachsituationen mit geeigneten Einheiten dar.<br />\r</li></ul>'),
(56, 3, '<ul><li>geben Informationen aus einfachen mathematikhaltigen Darstellungen (Text, Bild, Tabelle) mit eigenen Worten wieder.<br />\r</li><li>nutzen [das] Lineal [&amp;#8230;] zum Messen und genauen Zeichnen.<br />\r</li><li>präsentieren Ideen und Ergebnisse in kurzen Beiträgen.<br />\r</li><li>dokumentieren ihre Arbeit, ihre eigenen Lernwege und aus dem Unterricht erwachsene Merksätze und Ergebnisse (z. B. im Lerntagebuch, Merkheft).<br />\r</li><li>nutzen selbst erstellte Dokumente und das Schulbuch zum Nach-schlagen.<br />\r</li></ul>'),
(56, 4, '<em>Lernvoraussetzungen/Vernetzung</em><br />\r\n<ul><li>Diagnose und Anknüpfung an die vorhandenen Kompetenzen aus der Grundschule<br />\r</li><li>Kennenlernen mit allen Klassenleitungen der Jahrgangstufe absprechen<br />\r</li><li>Visualisierung mit Hilfe des Zahlenstrahls zur Vorbereitung auf den Umgang mit rationalen Zahlen (-&gt; 5.6)<br />\r</li><li>Grundvorstellungen zu Dezimalzahlen als Vorbereitung auf das Rechnen mit Dezimalzahlen (-&gt; 6.1, 6.2)<br />\r</li></ul><em>Entlastung</em><br />\r\n<ul><li>nur alltagsbezogene und einfache Umwandlung von Größen<br />\r</li><li>lesen und interpretieren statistischer Darstellungen zunächst nur am Säulendiagramm<br />\r</li></ul><em>Schwerpunktsetzung</em><br />\r\n<ul><li>Umwandeln von Größen erst in der Stellenwerttafel und anschließend </li></ul>'),
(56, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.1-wir-lernen-uns-kennen.html'),
(57, 2, 'Die Schülerinnen und Schüler... <br />\r\n<ul><li>führen Grundrechenarten aus (Kopfrechnen und schriftliche Rechenverfahren) mit natürlichen Zahlen [...].<br />\r</li><li>stellen Größen in Sachsituationen mit geeigneten Einheiten dar.<br />\r</li><li>wenden ihre arithmetischen Kenntnisse von Zahlen und Größen an, nutzen Strategien für Rechenvorteile [hier: Rechengesetze und Vorrangregeln], Techniken des Überschlagens und die Probe als Rechenkontrolle.<br />\r</li><li>erkunden Muster in Beziehungen zwischen Zahlen und stellen Vermutungen auf.<br />\r</li></ul>'),
(57, 3, '<ul><li>übersetzen Situationen aus Sachaufgaben in mathematische Modelle (Terme [...]). <br />\r</li><li>überprüfen die im mathematischen Modell gewonnenen Lösungen an der Realsituation.<br />\r</li><li>nutzen intuitiv verschiedene Arten des Begründens [...].<br />\r</li><li>ermitteln Näherungswerte für erwartete Ergebnisse durch Schätzen und Überschlagen. <br />\r</li><li>finden in einfachen Problemsituationen mögliche mathematische Fragestellungen.<br />\r</li><li>erläutern mathematische Sachverhalte, Begriffe, Regeln und Verfahren mit eigenen Worten und geeigneten Fachbegriffen.<br />\r</li><li>geben inner- und außermathematische Problemstellungen in eigenen Worten wieder und entnehmen ihnen die relevanten Größen. <br />\r</li></ul>'),
(57, 4, '<em>Lernvoraussetzungen/Vernetzung</em><br />\r\n<ul><li>Erweitern der Kompetenzen aus der Grundschule<br />\r</li><li>Fach Musik: Rap der Vorfahrtsregeln: &quot;Die Klammer zu den Punkten sprach: Zuerst komm ich und ihr danach. Der Punkt zum Strich: Zuerst komm ich.&quot; <br />\r</li><li>Zahlenrätsel (-&gt; 7.9) <br />\r</li><li>Visualisierung der Grundrechenarten am Zahlenstrahl (-&gt; 5.6)<br />\r</li><li>Idee der Gleichung anregen als Suche nach unbekannten Zahlen (keine Äquivalenzumformung): Strategien des Einsetzens und des Rückwärtsrechnens mithilfe von Pfeilbildern (-&gt; 7.9) <br />\r</li><li>systematische Variationen in Termen zur Vorbereitung der Variablenvorstellung (&quot;Wie verändert sich das Ergebnis, wenn eine Größe verändert wird?&quot;)</li></ul>'),
(57, 5, 'http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.2-mit-der-mathebrille-unterwegs.html'),
(60, 3, '<u>1.	Sequenz: Tiere beschreiben</u><br />\r\n<b>Zentrale Kompetenzen:</b><br />\r\nDie Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>beschaffen Informationen und geben diese adressatenbezogen weiter. (3.1.3)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>informieren über einfache Sachverhalte und wenden dabei die Ge- staltungsmittel einer sachbezogenen Darstellung an. Sie berichten. Sie beschreiben. Sie nutzen Informationen einer Erzählung, eines Films, eines Lexikonartikels, um ein Lebewesen, einen Ort, eine Landschaft zu beschreiben. Sie erklären die Bedeutung nicht- sprach-licher Zeichen. (3.2.3)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>entnehmen Sachtexten Informationen und nutzen sie für die Klärung von Sachverhalten. (3.3.3)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>unterscheiden Wortarten, erkennen und untersuchen deren Funkti- on und bezeichnen sie terminologisch richtig. (3.4.3)<br />\r</li></ul><br />\r\n<u>2.	Sequenz: Ich wünsche mir ein Tier</u><br />\r\n<b>Zentrale Kompetenzen:</b><br />\r\nDie Schülerinnen und Schüler ...<br />\r\nB 1: Sprechen und Zuhören<br />\r\n<ul><li>formulieren eigene Meinungen und vertreten sie in Ansätzen struk- turiert. (3.1.6)<br />\r</li><li>vereinbaren Gesprächsregeln und Standards für die Gesprächsfüh- rung und achten auf deren Einhaltung. (3.1.7)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>formulieren eigene Meinungen und führen hierfür Argumente an. (3.2.4)</li></ul>'),
(64, 5, '<b>Schwerpunktsetzung:</b><br />\r\nOrientierung am natürlichen Spracherwerb - Prinzip &quot;Hören, dann Sprechen&quot;; Erkennung von Wortgrenzen; Zuordnung von Bedeutungen zu Wörtern und Wortfolgen; Intonations- und Aussprachemuster im Französischen<br />\r\n<br />\r\n<b>Synergien:</b><br />\r\nVokabellerntechniken (&lt;&gt; Englisch --&gt; Französisch)<br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\nLautschrift des Französischen als Aussprachehilfe<br />\r\n<br />\r\n<b>Konkretisierung des UV</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/upload/klp_SI/G8/f/Unterrichtsvorhaben_6.1.1.docx'),
(61, 2, 'Die Schülerinnen und Schüler... <br />\r\n<ul><li>erheben Daten, fassen sie in Ur- und Strichlisten zusammen und veranschaulichen sie in Säulendiagrammen.<br />\r</li><li>stellen natürliche Zahlen und einfache Dezimalzahlenauf verschiedene Weise dar.<br />\r</li><li>runden natürliche Zahlen und Dezimalzahlen.<br />\r</li></ul>'),
(67, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömische Geschichte/<br />\r\nStaat und Gesellschaft<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nAcI und Satzgefüge<br />\r\nTempora (Perfekt)<br />\r\ngenus verbi<br />\r\n'),
(61, 3, '<ul><li>geben Informationen aus einfachen mathematikhaltigen Darstellungen (Text, Bild, Tabelle) mit eigenen Worten wieder.<br />\r</li><li>dokumentieren ihre Arbeit, ihre eigenen Lernwege und aus dem Unterricht erwachsene Merksätze und Ergebnisse (z. B. im Lerntagebuch, Merkheft) und  nutzen diese zum Nachschlagen.<br />\r</li></ul>'),
(61, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Diagnose und Anknüpfung an die vorhandenen Kompetenzen aus der Grundschule<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>nur sinnvolle und einfache Umwandlung von Größen<br />\r</li></ul>'),
(59, 3, '<u>1. Sequenz: Reden und Erzählen - mündlich und schriftlich</u><br />\r\n<b>Zentrale Kompetenzen:</b><br />\r\nDie Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>erzählen eigene Erlebnisse und Erfahrungen sowie Geschichten geordnet, anschaulich und lebendig. (3.1.2)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>setzen sich ein Schreibziel und wenden elementare Methoden der Textplanung, Textformulierung und Textüberarbeitung an. (3.2.1)<br />\r</li><li>erzählen Erlebnisse und Begebenheiten anschaulich und lebendig. (3.2.2)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>unterscheiden informationsentnehmendes und identifikatorisches Lesen. Sie erfassen Wort- und Satzbedeutungen, satzübergreifende Bedeutungseinheiten und bauen unter Heranziehung eigener Wissensbestände ein zusammenhängendes Textverständnis auf. Sie ver- fügen über die grundlegenden Arbeitstechniken der Textbearbei- tung. (3.3.1)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n-	untersuchen Unterschiede zwischen mündlichem und schriftlichem Sprachgebrauch und erkennen und nutzen die verschiedenen Ebe- nen stilistischer Entscheidungen. (3.4.8)<br />\r\n<br />\r\n<u>2.Sequenz: Schulgeschichten lesen und verstehen</u><br />\r\n<b>Zentrale Kompetenzen:</b><br />\r\nDie Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>entwickeln und beantworten Fragen zu Texten und belegen ihre Aus-- sagen. (3.2.7)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>unterscheiden einfache literarische Formen, erfassen deren Inhalte und Wirkungsweisen unter Berücksichtigung sprachlicher und struktureller Besonderheiten. (3.3.6)<br />\r</li><li>wenden einfache Verfahren der Textuntersuchung und Grundbegriffe der Textbeschreibung an. (3.3.7)</li></ul>'),
(61, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.1-wir-lernen-uns-kennen.html'),
(62, 2, 'Die Schülerinnen und Schüler... <br />\r\n<ul><li>führen Grundrechenarten aus und nutzen Strategien für Rechenvorteile.<br />\r</li><li>interpretieren Zahlenterme im Sachkontext und stellen eigene Zahlenterme auf.<br />\r</li></ul>'),
(66, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>die grammatischen Eigenschaften der Wörter benennen<br />\r</li><li>Gesetzmäßigkeiten im Wortschatz anderer Sprachen erkennen<br />\r</li><li>Satzglieder benennen und die Füllungsarten erläutern <br />\r</li><li>Satzarten unterscheiden<br />\r</li><li>Gliedsätze erkennen und unterscheiden<br />\r</li><li>die Mehrdeutigkeit einer Wortform reduzieren<br />\r</li><li>Kasusfunktionen beschreiben und wiedergeben<br />\r</li><li>die lateinische Formenbildung mit anderen Sprachen vergleichen<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>Textsignale (Überschrift, handelnde Personen, Zeit) identifizieren<br />\r</li><li>die Texte angemessen vortragen<br />\r</li><li>Texte gliedern und inhaltlich wiedergeben<br />\r</li><li>sinntragende Begriffe bestimmen<br />\r</li><li>Hintergrundinformationen heranziehen<br />\r</li><li>Textaussagen mit heutigen Vorstellungen vergleichen<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>die fremde und die eigene Situation reflektieren und erklären<br />\r</li><li>Akzeptanz gegenüber anderen Kulturen entwickeln<br />\r</li></ul>'),
(62, 3, '<ul><li>nutzen intuitiv verschiedene Arten des Begründens.<br />\r</li><li>übersetzen Situationen aus Sachaufgaben in mathematische Modelle (Terme). <br />\r</li><li>lösen inner- und außermathematische Problemstellungen mithilfe passender Rechenarten.<br />\r</li></ul>'),
(62, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.2-mit-der-mathebrille-unterwegs-rechnen-mit-natuerlichen-zahlen.html'),
(66, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömische Alltagskultur/<br />\r\nRezeption und Tradition<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nDer erweiterte einfache Satz<br />\r\nKasuslehre (Gen)<br />\r\nKongruenzen<br />\r\n'),
(69, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömisches Alltagsleben <br />\r\nMythologien und Religion/<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nTempora/genus verbi/Infinitive (Wdh)<br />\r\nverba anomala<br />\r\n'),
(69, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>Fremdwörter auf die lateinische Ausgangsform zurückführen und erklären<br />\r</li><li>die Zeitverhältnisse bei Infinitivkonstruktionen untersuchen<br />\r</li><li>die Handlungsarten in komplexeren Sätzen bestimmen<br />\r</li><li>die Verwendung der Tempora und Diathesen beschreiben  <br />\r</li><li>Grundregeln der lateinischen Formenbildung mit anderen Sprachen vergleichen<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>Grundregeln des lateinischen Tempusgebrauchs mit anderen Sprachen vergleichen<br />\r</li><li>anhand auffälliger Merkmale begründete Erwartungen an die Texte formulieren<br />\r</li><li>Morpheme identifizieren und für die Texterschließung nutzen.<br />\r</li><li>sprachlich und sachlich angemessen übersetzen<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>die fremde und die eigene Situation reflektieren und erklären<br />\r</li></ul>'),
(70, 2, '<b>Themenfelder gem. KLP</b><br />\r\nMythologie und Religion/<br />\r\nStaat und Gesellschaft<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nPartizipialkonstruktionen<br />\r\nKonjunktiv (Plqpf,Impf,Präs)<br />\r\nGliedsätze als Obj, als Adverbiale<br />\r\n'),
(70, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>die Wortarten sicher unterscheiden<br />\r</li><li>Wortfamilien, Wortfelder und Sachfelder bilden<br />\r</li><li>Elemente des lateinischen Formenbaus und deren Funktion benennen<br />\r</li><li>die Bestandteile einer Partizipialkonstruktion untersuchen und eine Auswahl zwischen Übersetzungsvarianten treffen<br />\r</li><li>die Handlungsarten in komplexeren Sätzen bestimmen<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>Sätze syntaktisch und semantisch erschließen<br />\r</li><li>Sinnerwartungen zunehmend selbstständig überprüfen<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>Merkmale der römischen Kultur (Mythos, Religion) benennen und erläutern<br />\r</li></ul>'),
(71, 2, '<b>Themenfelder gem. KLP</b><br />\r\nMythologie und Religion/<br />\r\nRezeption und Tradition<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nKonjunktiv (Perf)<br />\r\nPartizipialkonstruktionen<br />\r\n'),
(71, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>den Wortschatz strukturieren<br />\r</li><li>semantisch-syntaktische Umfelder von Wörtern nennen <br />\r</li><li>flektierte Formen auf die Grundform zurückführen<br />\r</li><li>Füllungsarten unterscheiden<br />\r</li><li>Mehrdeutigkeit von Gliedsätzen und Konstruktionen reduzieren<br />\r</li><li>die Bestandteile einer Partizipialkonstruktion untersuchen und eine Auswahl zwischen Übersetzungsvarianten treffen<br />\r</li><li>lateinischen Satzbau mit anderen Sprachen vergleichen<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>signifikante semantische und syntaktische Merkmale benennen <br />\r</li><li>lateinische Texte mit richtiger Aussprache und Betonung vortragen<br />\r</li><li>Thematik und Inhalt der Texte wiedergeben und Aufbau beschreiben<br />\r</li><li>zentrale Begriffe oder Wendungen herausarbeiten<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>Unterschiede zwischen der antiken und der heutigen Welt erklären<br />\r</li></ul>'),
(72, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömische Geschichte/<br />\r\nMythologie und Religion<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nnd-Formen <br />\r\nSteigerungen<br />\r\n'),
(72, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>die Bedeutung einzelner Wörter anderer Sprachen ableiten<br />\r</li><li>Gesetzmäßigkeiten im Wortschatz anderer Sprachen erkennen und nutzen<br />\r</li><li>flektierte Formen auf die Grundform zurückführen<br />\r</li><li>verwechselbare Formen unterscheiden<br />\r</li><li>Funktion der Modi bestimmen und wiedergeben<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>sprachlich-stilistische Mittel nachweisen und ihre Wirkung erläutern<br />\r</li><li>typische Strukturmerkmale von Textsorten herausarbeiten<br />\r</li><li>treffende Formulierungen in der dt. Sprache wählen<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>Offenheit und Akzeptanz gegenüber anderen Kulturen und Verständnis für die eigene Kultur entwickeln<br />\r</li></ul>'),
(73, 2, '<b>Themenfeld gem. KLP</b><br />\r\nRömische Geschichte<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nKonjunktiv in HS und NS<br />\r\nDeponentien<br />\r\n'),
(73, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>Regeln der Ableitung und Zusammensetzung lat. Wörter anwenden<br />\r</li><li>verwechselbare Formen unterscheiden<br />\r</li><li>in Satzgefügen Satzebenen bestimmen<br />\r</li><li>Mehrdeutigkeit von Gliedsätzen und Konstruktionen reduzieren<br />\r</li><li>Sinnrichtung und Funktion von Gliedsätzen unterscheiden<br />\r</li><li>Prinzipien der Formenbildung erklären und Formen bestimmen<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>Texte in sachliche und historische Zusammenhänge einordnen<br />\r</li><li>Textaussagen reflektieren und mit heutigen Lebens- und Denkweisen vergleichen<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>wesentliche Merkmale der römischen Gesellschaft sowie einige Aspekte des Fortlebens der römischen Kultur benennen und erläutern<br />\r</li></ul>'),
(74, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömische Alltagskultur/<br />\r\nMythologie und Religion/<br />\r\nRezeption und Tradition<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nErgibt sich aus der Autoren-/ Textauswahl sowie aus den lerngruppenspezifischen Erfordernissen.<br />\r\n');
INSERT INTO `part_t520_ein_r_uv_textfelder` (`uv_id`, `textfeld_id`, `uv_text`) VALUES
(74, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>Wortbedeutungen nennen, erläutern, im Kontext erklären und sinngerechte Entsprechungen wählen <br />\r</li><li>Prinzipien der Formenbildung erklären und Formen bestimmen<br />\r</li><li>Funktion von Wörtern im Kontext erklären und Konstruktionen analysieren<br />\r</li><li>zwischen Übersetzungsvarianten wählen<br />\r</li><li>Formenbildung und Satzbau mit anderen Sprachen vergleichen<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>Texte durch Hörverstehen erfassen <br />\r</li><li>Textsemantik und -syntax herausarbeiten und begründete Erwartungen formulieren<br />\r</li><li>Texte sach- und kontextgerecht erschließen<br />\r</li><li>Sinnerwartungen überprüfen <br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>Merkmale der Antike sowie deren Einfluss auf die europäische Kultur erläutern<br />\r</li><li>Akzeptanz gegenüber anderen Kulturen und Werthaltungen entwickeln<br />\r</li></ul>'),
(75, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömische Geschichte/<br />\r\nStaat und Gesellschaft<br />\r\nMythologien und Religion<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nErgibt sich aus der Autoren-/ Textauswahl sowie aus den lerngruppenspezifischen Erfordernissen.<br />\r\n'),
(75, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>Fremdwörter erklären und wissenschaftliche Terminologie erschließen<br />\r</li><li>Wörter und Wendungen in anderen Fremdsprachen verstehen und Parallelen im Wortschatz anderer Sprachen erkennen <br />\r</li><li>Mehrdeutigkeit von Gliedsätzen und Konstruktionen reduzieren <br />\r</li><li>Satzebenen bestimmen<br />\r</li><li>Zeitstufen und Zeitverhältnisse sowie den Modusgebrauch erklären und wiedergeben<br />\r</li><li>Tempusgebrauch mit anderen Sprachen vergleichen<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>Textaussagen reflektieren und bewerten<br />\r</li><li>Inhalt und Aufbau der Texte strukturiert darstellen<br />\r</li><li>Sätze sach- und kontextgerecht erschließen<br />\r</li><li>die Texte angemessenen übersetzen, sinntragende Wendungen nachweisen, sprachlich-stilistische Mittel erläutern<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>Bereitschaft zum Perspektivenwechsel zeigen<br />\r</li><li>Fragen zu Kontinuität und Wandel erörtern<br />\r</li></ul>'),
(76, 2, '<b>Themenfelder gem. KLP</b><br />\r\nRömische Alltagskultur/<br />\r\nStaat und Gesellschaft<br />\r\n<br />\r\n<b>Sprachl. Schwerpunkt</b><br />\r\nErgibt sich aus der Autoren-/ Textauswahl sowie aus den lerngruppenspezifischen Erfordernissen<br />\r\n'),
(76, 3, '<b>Sprachkompetenz</b><br />\r\n<ul><li>Vokabeln mit Wörterbuch ermitteln <br />\r</li><li>Funktionen von Wortarten erklären und den Wortschatz strukturieren <br />\r</li><li>autoren- und textsortenspezifische Elemente des Wortschatzes identifizieren <br />\r</li><li>flektierte Formen auf ihre Grundform zurückführen und Formen bestimmen <br />\r</li><li>die Funktion der Modi herausarbeiten, erklären und wiedergeben<br />\r</li></ul><br />\r\n<b>Textkompetenz</b><br />\r\n<ul><li>Gestaltungselemente untersuchen <br />\r</li><li>lat. Texte flüssig und unter Beachtung ihres Sinngehalts vortragen <br />\r</li><li>Textaussagen deuten und erörtern<br />\r</li><li>zwischen wörtlicher, sachgerechter und wirkungsgerechter Wiedergabe unterscheiden und dies beim Ausdruck von Sinninhalten berücksichtigen<br />\r</li></ul><br />\r\n<b>Kulturkompetenz</b><br />\r\n<ul><li>die fremde und die eigene Situation reflektieren und beurteilen<br />\r</li><li>Fragen zu Kontinuität und Wandel erörtern<br />\r</li><li>zentrale Ideen und Wertvorstellungen sowie den Einfluss der Antike auf die europäische Kultur erläutern<br />\r</li></ul>'),
(77, 3, '<u>1. Sequenz: Märchen und andere Geschichten - lesen und ausgestalten</u><br />\r\n<b>Zentrale Kompetenzen:</b><br />\r\nDie Schülerinnen und Schüler ...<br />\r\nKB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>unterscheiden einfache literarische Formen, erfassen deren Inhalte und Wirkungsweisen unter Berücksichtigung sprachlicher und struktureller Besonderheiten. (3.3.6)<br />\r</li><li>gestalten Geschichten nach, formulieren sie um, produzieren Texte mithilfe vorgegebener Textteile. (3.3.11)<br />\r</li></ul><br />\r\n<u>2. Sequenz: Fantastische Geschichten - schreiben und überarbeiten</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>setzen sich ein Schreibziel und wenden elementare Methoden der Textplanung, Textformulierung und Textüberarbeitung an. (3.2.1)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>gestalten Geschichten nach, formulieren sie um, produzieren Texte mithilfe vorgegebener Textteile. (3.3.11)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>beschreiben die grundlegenden Strukturen des Satzes. (3.4.5)</li></ul>'),
(77, 4, 'keine'),
(77, 5, '<b>Konkretisierung des UV:</b><br />\r\n<br />\r\n<b>1. Sequenz: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/5.-zauberhafte-welten-maerchen.html<br />\r\n<br />\r\n<b>2. Sequenz: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/5.-zauberhafte-welten-fantastische-geschichten.html'),
(78, 3, 'Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>sprechen gestaltend. (3.1.11)<br />\r</li><li>tragen kürzere Texte auswendig vor. (3.1.12)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>untersuchen Gedichte unter Berücksichtigung einfacher formaler, sprachlicher Beobachtungen. (3.3.9)</li></ul>'),
(78, 4, 'keine'),
(78, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/5.-poetische-jahreszeiten.html'),
(79, 3, '<u>1. Sequenz: Über ein sensationelles Ereignis berichten</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>erzählen eigene Erlebnisse und Erfahrungen sowie Geschichten geordnet, anschaulich und lebendig. (3.1.2)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>informieren über einfache Sachverhalte und wenden dabei die Gestaltungsmittel einer sachbezogenen Darstellung an. Sie berichten. Sie nutzen Informationen einer Erzählung, eines Films, eines Lexi konartikels, um ein Lebewesen, einen Ort, eine Landschaft zu beschreiben. Sie erklären die Bedeutung nicht-sprachlicher Zeichen. (3.2.3)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>entnehmen Sachtexten Informationen und nutzen sie für die Klärung von Sachverhalten. (3.3.3)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>kennen die einschlägigen Flexionsformen und deren Funktionen und wenden sie richtig an. (3.4.4)<br />\r</li></ul><br />\r\n<u>2. Sequenz: Texte über ein sensationelles Ereignis vergleichen</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>entwickeln und beantworten Fragen zu Texten und belegen ihre Aussagen. (3.2.7)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>entnehmen Sachtexten (auch Bildern und diskontinuierlichen Texten) Informationen und nutzen sie für die Klärung von Sachverhalten. (3.3.3)<br />\r</li><li>unterscheiden grundlegende Formen von Sachtexten (Bericht, Beschreibung) in ihrer Struktur, Zielsetzung und Wirkung. (3.3.4)</li></ul>'),
(79, 4, 'keine'),
(79, 5, '<b>Konkretisierung des UV:</b><br />\r\n<em>Sequenz 1:</em><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/6.-sensationelle-ereignisse-erste-sequenz-berichten.html<br />\r\n<em>Sequenz 2:</em><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/6.-sensationelle-ereignisse-zweite-sequenz-texte-vergleichen.html<br />\r\n'),
(80, 3, '<u>1. Sequenz: Epische Kurzformen lesen, untersuchen und vergleichen</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>entwickeln und beantworten Fragen zu Texten und belegen ihre Aussagen. (3.2.7)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>unterscheiden einfache literarische Formen, erfassen deren Inhalte und Wirkungsweisen unter Berücksichtigung sprachlicher und struktureller Besonderheiten. (3.3.6)<br />\r</li><li>verstehen kürzere Erzählungen, Jugendbücher und Ausschnitte aus literarischen Ganzschriften. (3.3.8)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n- untersuchen die Bildung von Wörtern. Sie verstehen einfache sprachliche Bilder. (3.4.6)<br />\r\n<br />\r\n<u>2. Sequenz: Und die Moral von der Geschicht&#039; - kurze Lehrgeschichten selbst schreiben</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>sprechen gestaltend. (3.1.11)<br />\r</li><li>setzen beim szenischen Spiel verbale und nonverbale Mittel bewusst ein und erproben deren Wirkung. (3.1.13)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>setzen sich ein Schreibziel und wenden elementare Methoden der Textplanung, Textformulierung und Textüberarbeitung an. (3.2.1)<br />\r</li><li>erzählen Erlebnisse und Begebenheiten frei oder nach Vorlagen anschaulich und lebendig. Sie wenden dabei in Ansätzen Erzähltechniken an. (3.2.2)</li></ul>'),
(80, 4, 'keine'),
(80, 5, '<b>Konkretisierung des UV:</b><br />\r\n<b>Sequenz 1: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/6.-erzaehlen-frueher-und-heute-erste-sequenz-epische-kurzformen.html<br />\r\n<b>Sequenz 2:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/6.-erzaehlen-frueher-und-heute-zweite-sequenz-und-die-moral-von-der-geschicht.html'),
(81, 3, '<u>1. Sequenz: Lesetagebuch zu einem Jugendbuch</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>tragen zu einem begrenzten Sachthema stichwortgestützt Ergebnisse vor und setzen hierbei in einfacher Weise Medien ein. (3.1.4)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>setzen sich ein Schreibziel und wenden elementare Methoden der Textplanung, Textformulierung und Textüberarbeitung an. (3.2.1)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>wenden einfache Verfahren der Textuntersuchung und Grundbegriffe der Textbeschreibung an. (3.3.7)<br />\r</li><li>verstehen kürzere Erzählungen, Jugendbücher und Ausschnitte aus literarischen Ganzschriften. (3.3.8)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>korrigieren und vermeiden Fehlschreibungen durch richtiges Abschreiben, Sprech- und Schreibproben, Fehleranalyse, Nachschlagen in einem Wörterbuch. (3.4.14)<br />\r</li></ul><br />\r\n<u>2. Sequenz: Ein Jugendbuch bewerten</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>formulieren eigene Meinungen und führen hierfür Argumente an. (3.2.4)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>schließen von der sprachlichen Form einer Äußerung auf die mögliche Absicht ihres Verfassers. (3.4.2)</li></ul>'),
(81, 4, 'keine'),
(81, 5, '<b>Konkretisierung des UV:</b><br />\r\n<b>Sequenz 1:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/6.-freundschaft-im-jugendbuch-erste-sequenz-lesetagebuch.html<br />\r\n<b>Sequenz 2:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/6.-freundschaft-im-jugendbuch-zweite-sequenz-ein-jugendbuch-bewerten.html'),
(82, 3, '<u>1. Sequenz: Werbetexte lesen und untersuchen</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>gestalten appellative Texte und verwenden dabei verschiedene Präsentationstechniken. (3.2.5)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>untersuchen und bewerten Sachtexte, Bilder und diskontinuierliche Texte im Hinblick auf Intention, Funktion und Wirkung. (3.3.3)<br />\r</li><li>untersuchen Texte audiovisueller Medien im Hinblick auf ihre Intention. Sie reflektieren und bewerten deren Inhalte, Gestaltungs- und Wirkungsweisen. (3.3.5)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>vergleichen und unterscheiden Ausdrucksweisen und Wirkungsabsichten von sprachlichen Äußerungen und treffen in eigenen Texten solche Entscheidungen begründet. (3.4.2)<br />\r</li></ul><br />\r\n<u>2. Sequenz: Wünsche formulieren</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>gestalten Schreibprozesse selbstständig. (3.2.1)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>vergleichen und unterscheiden Ausdrucksweisen und Wirkungsabsichten von sprachlichen Äußerungen und treffen in eigenen Texten solche Entscheidungen begründet. (3.4.2)<br />\r</li><li>kennen weitere Formen der Verbflexion, bilden die Formen weitgehend korrekt und können ihren funktionalen Wert erkennen und deuten. (3.4.4)</li></ul>'),
(82, 4, 'keine'),
(82, 5, '<b>Konkretisierung des UV:</b><br />\r\nSequenz 1: http://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/7.-kann-man-glueck-kaufen-erste-sequenz-werbetexte.html<br />\r\nSequenz 2:<br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/7.-kann-man-glueck-kaufen-zweite-sequenz-wuensche-formulieren.html'),
(83, 3, '<u>1. Sequenz: Heldinnen und Helden im Alltag</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>verarbeiten Informationen zu kürzeren, thematisch begrenzten freien Redebeiträgen und präsentieren diese mediengestützt. (3.1.4)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>informieren, indem sie in einem funktionalen Zusammenhang berichten oder einen Vorgang bzw. einen Gegenstand in seinem funktionalen Zusammenhang beschreiben, einen Vorgang schildern. Sie erklären Sachverhalte und Vorgänge in ihrem Zusammenhang differenziert. (3.2.3)<br />\r</li><li>fassen literarische Texte, Sachtexte und Medientexte strukturiert zusammen. (3.2.6)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>Sie kennen weitere Formen der Verbflexion, bilden die Formen weitgehend korrekt und können ihren funktionalen Wert erkennen und deuten. (3.4.4)<br />\r</li></ul><br />\r\n<u>2. Sequenz: Der Held in der Ballade</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>erschließen sich literarische Texte in szenischem Spiel und setzen dabei verbale und nonverbale Ausdrucksformen ein. (3.1.13)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>beziehen die Darstellung von Erfahrungen, Gefühlen, Meinungen in Erzähltexte ein. Sie setzen gestalterische Mittel des Erzählens planvoll und differenziert im Rahmen anderer Schreibtätigkeiten ein. (3.2.2)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>untersuchen lyrische Formen, erarbeiten deren Merkmale und Funktion. (3.3.9)<br />\r</li><li>verändern unter Verwendung akustischer, optischer und szenischer Elemente Texte. Sie präsentieren ihre Ergebnisse in medial geeigneter Form. (3.3.11)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>vergleichen und unterscheiden Ausdrucksweisen und Wirkungsabsichten von sprachlichen Äußerungen und treffen in eigenen Texten solche Ent</li></ul>'),
(83, 4, 'keine'),
(83, 5, '<b>Konkretisierung des UV:</b><br />\r\n<b>Sequenz 1:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/7.-von-grossen-und-kleinen-heldinnen-und-helden-erste-sequenz-alltag.html<br />\r\n<b>Sequenz 2:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/7.-von-grossen-und-kleinen-heldinnen-und-helden-zweite-sequenz-balladen.html'),
(84, 3, '<u>1. Sequenz: Perspektiven literarischer Figuren nachvollziehen</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>beantworten Fragen zu Texten sowie zu deren Gestaltung und entwickeln auf dieser Grundlage ihr eigenes Textverständnis. (3.2.7)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>unterscheiden spezifische Merkmale epischer, lyrischer und dramatischer Texte, haben Grundkenntnisse von deren Wirkungsweisen und berücksichtigen ggf. historische Zusammenhänge. Sie verfügen über grundlegende Fachbegriffe. (3.3.6)<br />\r</li><li>wenden textimmanente Analyse- und Interpretationsverfahren bei altersgemäßen literarischen Texten an und verfügen über die dazu erforderlichen Fachbegriffe. (3.3.7)<br />\r</li></ul><br />\r\n<u>2. Sequenz: Konflikte aushandeln</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>beteiligen sich an einem Gespräch konstruktiv, sachbezogen und ergebnisorientiert und unterscheiden zwischen Gesprächsformen. (3.1.7)<br />\r</li><li>unterscheiden in strittigen Auseinandersetzungen zwischen sachlichen und personenbezogenen Beiträgen, setzen sich mit Standpunkten anderer sachlich auseinander, respektieren fremde Positionen und erarbeiten Kompromisse. (3.1.8)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>setzen sich argumentativ mit einem neuen Sachverhalt auseinander. (3.2.4)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>festigen, differenzieren und erweitern ihre Kenntnisse im Bereich der Syntax und nutzen sie zur Analyse und zum Schreiben von Texten. (3.4.5)</li></ul>'),
(84, 4, 'keine'),
(84, 5, '<b>Konkretisierung des UV:</b><br />\r\n<b>Sequenz 1:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/7.-mit-konflikten-umgehen-lernen-erste-sequenz-perspektiven-literarischer-figuren.html<br />\r\n<b>Sequenz 2:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/7.-mit-konflikten-umgehen-lernen-zweite-sequenz-konflikte-aushandeln.html'),
(85, 4, 'keine'),
(85, 5, '<b>Konkretisierung des UV:</b><br />\r\n<b>Sequenz 1:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/8.-fuer-andere-schreiben-erste-sequenz-zeitungsprojekt.html<br />\r\n<b>Sequenz 2:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/8.-fuer-andere-schreiben-zweite-sequenz-digitales-leben.html'),
(85, 3, '<u>1. Sequenz: Zeitungsprojekt</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>fassen literarische Texte, Sachtexte und Medientexte strukturiert zusammen. (3.2.6)<br />\r</li><li>formulieren Aussagen zu diskontinuierlichen Texten und werten die Texte in einem funktionalen Zusammenhang an Fragen orientiert aus. (3.2.8)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n- untersuchen und bewerten Sachtexte, Bilder und diskontinuierliche Texte im Hinblick auf Intention, Funktion und Wirkung. (3.3.3)<br />\r\nKB 4: Reflexion über Sprache<br />\r\n<ul><li>vergleichen und unterscheiden Ausdrucksweisen und Wirkungsabsichten von sprachlichen Äußerungen und treffen in eigenen Texten solche Entscheidungen begründet. ( 3.4.2)<br />\r</li></ul><br />\r\n<u>2. Sequenz: Digitales Leben in sozialen Netzwerken</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>unterscheiden in strittigen Auseinandersetzungen zwischen sachlichen und personenbezogenen Beiträgen, setzen sich mit Standpunkten anderer sachlich auseinander, respektieren fremde Positionen und erarbeiten Kompromisse. (3.1.8)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>setzen sich argumentativ mit einem neuen Sachverhalt auseinander. (3.2.4)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>untersuchen Texte audiovisueller Medien im Hinblick auf ihre Intenion. Sie reflektieren und bewerten deren Inhalte, Gestaltungs- und Wirkungsweisen. (3.3.5)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>erkennen verschiedene Sprachebenen und Sprachfunktionen in gesprochenen und schriftlich verfassten Texten. Sie erkennen Ursachen möglicher Verstehens- und Verständigungsprobleme in mündlichen wie schriftlichen Texten und verfügen über ein Repertoire der Korrektur und Problemlösung. (3.4.1)</li></ul>'),
(86, 3, 'Über ein sensationelles Ereignis berichten<br />\r\n<br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>beantworten Fragen zu Texten sowie zu deren Gestaltung und entwickeln auf dieser Grundlage ihr eigenes Textverständnis. (3.2.7)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>wenden textimmanente Analyse- und Interpretationsverfahren bei altersgemäßen literarischen Texten an und verfügen über die dazu erforderlichen Fachbegriffe. (3.3.7)<br />\r</li><li>verstehen weitere epische Texte. (3.3.8)</li></ul>'),
(86, 4, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/8.-alltaegliche-begebenheiten-in-kurzen-geschichten.html'),
(87, 3, '<u>1. Sequenz: Lebenswege in literarischen Texten - Umgang mit einer Ganzschrift</u><br />\r\n<br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>erschließen sich literarische Texte in szenischem Spiel und setzen dabei verbale und nonverbale Ausdrucksformen ein. (3.1.13)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>beziehen die Darstellung von Erfahrungen, Gefühlen, Meinungen in Erzähltexte ein. Sie setzen gestalterische Mittel des Erzählens planvoll und differenziert im Rahmen anderer Schreibtätigkeiten ein. (3.2.2)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>verändern unter Verwendung akustischer, optischer und szenischer Elemente Texte. Sie präsentieren ihre Ergebnisse in medial geeigneter Form. (3.3.11)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>wenden operationale Verfahren zur Ermittlung der Satz- und Textstruktur zunehmend selbstständig an. (3.4.7)<br />\r</li></ul><br />\r\n<u>2. Sequenz: Die eigene Zukunft planen</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>äußern Gedanken, Empfindungen, Wünsche und Forderungen strukturiert, situationsangemessen, adressatenbezogen und unter Beachtung der Formen gesellschaftlichen Umgangs. (3.1.5)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>kennen, verwenden und verfassen Texte in standardisierten Formaten. (3.2.9)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>nutzen selbstständig Bücher und Medien zur Informationsentnahme und Recherche, ordnen die Informationen und halten sie fest. Sie berücksichtigen dabei zunehmend fachübergreifende Aspekte. (3.3.2)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>erkennen verschiedene Sprachebenen und Sprachfunktionen in gesprochenen und schriftlich verfassten Texten. Sie erkennen Ursachen möglicher Verstehens- und Verständigungsprobleme in mündlichen </li></ul>'),
(87, 4, 'keine'),
(87, 5, '<b>Konkretisierung des UV:</b><br />\r\n<b>Sequenz 1</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/8.-zukunft-alles-ist-moeglich-erste-sequenz-lebenswege-in-literarischen-texten-umgang-mit-einer-ganzschrift.html<br />\r\n<b>Sequenz 2</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/8.-zukunft-alles-ist-moeglich-zweite-sequenz-die-eigene-zukunft-planen.html'),
(88, 3, '<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>analysieren Texte und Textauszüge unter Berücksichtigung formaler und sprachlicher Besonderheiten und interpretieren sie ansatzweise. (3.2.7)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>erschließen (beschreiben und deuten) literarische Texte mit Verfahren der Textanalyse auch unter Einbeziehung historischer und gesellschaftlicher Fragestellungen. (3.3.7)<br />\r</li><li>erschließen auf der Grundlage eingeführten fachlichen und methodischen Wissens lyrische Texte und stellen ihre Ergebnisse in Form eines zusammenhängenden und strukturierten, deutenden Textes dar. (3.3.9)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>unterscheiden sicher zwischen begrifflichem und bildlichem Sprachgebrauch. (3.4.6)</li></ul>'),
(88, 4, 'keine'),
(88, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/9.-beziehungen-in-geschichten-und-gedichten.html'),
(89, 3, '<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\n<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>erarbeiten Referate zu begrenzten Themen und tragen diese weitgehend frei vor. Sie unterstützen ihren Vortrag durch Präsentationstechniken und Begleitmedien, die der Intention angemessen sind. (3.1.4)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>verfassen unter Beachtung unterschiedlicher Formen schriftlicher Erörterung argumentative Texte. (3.2.4)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>unterscheiden und reflektieren bei Sprachhandlungen Inhalts- und Beziehungsebenen und stellen ihre Sprachhandlungen darauf ein. (3.4.2)</li></ul>'),
(89, 4, 'keine'),
(89, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/9.-berufliche-perspektiven.html'),
(90, 3, '<u>1. Sequenz: Gestaltung von Familienkonstellationen in Roman und Film</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 2: Schreiben<br />\r\n<ul><li>analysieren Texte und Textauszüge unter Berücksichtigung formaler und sprachlicher Besonderheiten und interpretieren sie ansatzweise. (3.2.7)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>erschließen (beschreiben und deuten) literarische Texte mit Verfahren der Textanalyse auch unter Einbeziehung historischer und gesellschaftlicher Fragestellungen. (3.3.7)<br />\r</li><li>verstehen längere epische Texte. (3.3.8)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>korrigieren und vermeiden Fehler. (3.4.14)<br />\r</li></ul><br />\r\n<u>2. Sequenz: So ein Theater - Auseinandersetzung auf der Bühne</u><br />\r\n<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n<ul><li>erarbeiten mithilfe gestaltenden Sprechens literarischer Texte und szenischer Verfahren Ansätze für eigene Textinterpretationen. (3.1.13)<br />\r</li></ul>KB 2: Schreiben<br />\r\n<ul><li>analysieren Texte und Textauszüge unter Berücksichtigung formaler und sprachlicher Besonderheiten und interpretieren sie ansatzweise. (3.2.7)<br />\r</li></ul>KB 3: Lesen - Umgang mit Texten und Medien<br />\r\n<ul><li>verstehen und erschließen dramatische Texte unter Berücksichtigung struktureller, sprachlicher und inhaltlicher Merkmale. (3.3.10)<br />\r</li></ul>KB 4: Reflexion über Sprache<br />\r\n<ul><li>beherrschen sprachliche Verfahren und können diese beschreiben. (3.4.7)</li></ul>'),
(90, 4, 'keine'),
(90, 5, '<b>Konkretisierung des UV:</b><br />\r\n<b>Sequenz 1:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/9.-familienkonstellationen-erste-sequenz-gestaltung-von-familienkonstellationen-in-roman-und-film.html<br />\r\n<b>Sequenz 2:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/9.-familienkonstellationen-zweite-sequenz-so-ein-theater-auseinandersetzung-auf-der-buehne.html'),
(91, 3, '<b>Zentrale Kompetenzen:</b> Die Schülerinnen und Schüler ...<br />\r\nKB 1: Sprechen und Zuhören<br />\r\n- setzen sprechgestaltende Mittel und Redestrategien in unterschiedlichen Situationen bewusst ein. (3.1.11/12)<br />\r\nKB 2: Schreiben<br />\r\n- informieren über komplexe Sachverhalte, über Gesprächsergebnisse und Arbeitsabläufe und beschreiben vom eigenen oder fremden Standpunkt aus, beschreiben Textvorlagen oder Teile und Aspekte von Vorlagen. Sie erklären Sachverhalte unter Benutzung von Materialien und Beobachtungen an Texten. (3.2.3)<br />\r\nKB 3: Lesen - Umgang mit Texten und Medien<br />\r\n- verstehen komplexe Sachtexte. (3.3.3)<br />\r\nKB 4: Reflexion über Sprache<br />\r\n- kennen verbale und non-verbale Strategien der Kommunikation, setzen diese gezielt ein und reflektieren ihre Wirkung. (3.4.1)<br />\r\n- reflektieren Sprachvarianten (3.4.8)<br />\r\n- kennen und bewerten ausgewählte Erscheinungen des Sprachwandels (3.4.9)<br />\r\n- reflektieren ihre Kenntnis der eigenen Sprache und ihre Bedeutung für das Erlernen von Fremdsprachen (3.4.10)'),
(91, 4, 'keine'),
(91, 5, '<b>Konkretisierung des Unterrichtsvorhabens</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/deutsch-g8/hinweise-und-beispiele-deutsch/schulinterner-lehrplan/9.-wie-redest-du-mit-mir-sprache-als-mittel-der-verstaendigung.html'),
(92, 3, '<ul><li>nutzen das Geodreieck zum Messen und genauen Zeichnen.<br />\r</li><li>setzen Begriffe an Beispielen und in Zeichnungen miteinander in Beziehung (z. B. parallel/senkrecht, achsen-, punktsymmetrisch).<br />\r</li></ul>'),
(92, 2, 'Die Schülerinnern und Schüler<br />\r\n<ul><li>benennen, charakterisieren, zeichnen und vermessen Figuren (Rechteck, Quadrat, Parallelogramm, Raute, Trapez, Dreieck).</li></ul>'),
(92, 4, '<b>Entlastung</b><br />\r\n<ul><li>Schwerpunkt auf das Zeichnen von Vierecken<br />\r</li><li>keine zeichnerische Umsetzung der Spiegelungen oder Drehungen<br />\r</li></ul>'),
(92, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.3-mathematik-mit-papier-und-spiegel.html'),
(93, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>schätzen und bestimmen Umfang und Flächeninhalt von Rechtecken, Dreiecken, Parallelogrammen und daraus zusammengesetzten Figuren.<br />\r</li><li>stellen Größen in Sachsituationen mit geeigneten Einheiten dar.<br />\r</li><li>nutzen gängige Maßstabsverhältnisse.<br />\r</li></ul>'),
(93, 3, '<ul><li>nutzen die Strategien &quot;Zerlegen&quot; und &quot;Ergänzen&quot; zur Flächenberechnung.</li></ul>'),
(93, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Kunst<br />\r</li><li>Fach Erdkunde: Absprache zum Maßstab<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>nur Dreiecke und Vierecke, Kreise erst in 6.3<br />\r</li><li>nur einfache Umwandlungen von Größen<br />\r</li></ul>'),
(93, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.4-unsere-wohnung.html'),
(94, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>benennen und charakterisieren Grundkörper, identifizieren sie in ihrer<br />\r</li><li>Umwelt und stellen Größen in Sachsituationen mit geeigneten Einheiten dar.<br />\r</li><li>erstellen Schrägbilder, Netze und Modelle von Würfeln und Quadern.<br />\r</li><li>schätzen und bestimmen Oberflächen und Volumina von Quadern.<br />\r</li></ul>'),
(94, 3, '<ul><li>arbeiten bei der Lösung von Problemen im Team.</li></ul>'),
(94, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Kunst: Körper, Gebäude<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>nur einfache Umwandlungen von Größen<br />\r</li><li>keine Schrägbilder und Netze von zusammengesetzten Körpern<br />\r</li></ul>'),
(94, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.5-die-optimale-verpackung.html'),
(128, 4, '-'),
(128, 3, '<b>KK:</b><br />\r\n<b>Sprechen: zusammenhängendes Sprechen:</b> in einfacher Form aus dem eigenen Erlebnisbereich berichten und erzählen <em>(focus speech act: describing something)</em><br />\r\n<b>Hörverstehen:</b> im Unterricht Vorgetragenes und Erzähltes verstehen<br />\r\n<b>Sprachmittlung:</b> im Unterricht verwendete Aufforderungen, Fragen und Erklärungen der Mitschülerinnen und Mitschüler ggf.in der jeweils anderen Sprache wiedergeben<br />\r\n<b>MK:</b><br />\r\nunterschiedliche Formen der Wortschatzarbeit einsetzen, z.B. Wortfelder bilden, ein-/zweisprachige Vokabellisten führen; Worterschließungsstrategien anwenden'),
(128, 2, '<b>Persönliche Lebensgestaltung:</b> Familie, Freunde, tägliches Leben und Tagesabläufe, Freizeit'),
(96, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>stellen ganze Zahlen auf verschiedene Weise dar.<br />\r</li><li>ordnen und vergleichen Zahlen.<br />\r</li><li>führen Grundrechenarten mit ganzen Zahlen aus.<br />\r</li></ul><br />\r\n'),
(96, 3, '<ul><li>erläutern die Addition und Multiplikation ganzer Zahlen anschaulich mit eigenen Worten, geeigneten Fachbegriffen und in Sachzusammenhängen.</li></ul>'),
(96, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Physik (JG 6), Biologie, Erdkunde: Temperatur<br />\r</li><li>Fach Erdkunde: Höhen<br />\r</li></ul><br />\r\n<br />\r\n<b>Entlastung</b><br />\r\n<ul><li>nur Addition und Multiplikation ganzer Zahlen<br />\r</li><li>Multiplikation zweier negativer ganzer Zahlen zunächst nur über das Permanenzprinzip<br />\r</li></ul>'),
(96, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.6-veraenderungen-und-zustaende.html'),
(97, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>stellen einfache Bruchteile auf verschiedene Weise dar und deuten sie als Operatoren, Größen und Verhältnisse.<br />\r</li><li>deuten Dezimalzahlen und Prozentzahlen als andere Darstellungsform für Brüche.<br />\r</li><li>bestimmen Teiler und Vielfache natürlicher Zahlen und wenden einfache Teilbarkeitsregeln an<br />\r</li></ul>'),
(97, 3, '<ul><li>setzen Begriffe an Beispielen miteinander in Beziehung (z. B. natürliche Zahlen und Brüche).</li></ul>'),
(97, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Grundschule: einfache Brüche, Dezimalzahlen<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>grundlegende Teilbarkeitsregeln ohne Primfaktorzerlegung, ggT und kgV<br />\r</li><li>Verhältnisse nur als Abgrenzung zu Anteilen<br />\r</li></ul>'),
(97, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.1-die-drei-gesichter-einer-zahl.html'),
(98, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>addieren und subtrahieren einfache Brüche und endliche Dezimalzahlen.<br />\r</li><li>nutzen Strategien für Rechenvorteile, Techniken des Überschlagens und die Probe als Rechenkontrolle.</li></ul>'),
(98, 3, '<ul><li>nutzen elementare mathematische Regeln und Verfahren (Rechnen, Schließen) zum Lösen von Problemen.<br />\r</li><li>wenden die Problemlösestrategien &quot;Beispiele finden&quot;, &quot;Überprüfen durch Probieren&quot; an.<br />\r</li><li>deuten Ergebnisse in Bezug auf die ursprüngliche Problemstellung.</li></ul>'),
(98, 4, '<b>Entlastung</b><br />\r\n<ul><li>Vorstellung der gemischten Schreibweise als Summe von ganzer Zahl und Bruch muss verankert werden.<br />\r</li><li>Rechnen mit Zahlen in gemischter Schreibweise entfällt.<br />\r</li></ul>'),
(98, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.2-entwicklung-und-reflexion-von-problemloesestrategien.html'),
(99, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>benennen, charakterisieren und zeichnen grundlegende ebene Figuren (Kreis und Dreieck - rechtwinklig, gleichschenklig und gleichseitig) und identifizieren sie in ihrer Umwelt.</li></ul>'),
(99, 3, '<ul><li>nutzen Geodreieck und Zirkel zum Messen und genauen Zeichnen.<br />\r</li><li>messen und schätzen Winkel.</li></ul>'),
(100, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>führen Multiplikation und Division mit einfachen Brüchen und endlichen Dezimalzahlen aus</li></ul>'),
(99, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Kunst: Mondrian, Itten ...<br />\r</li></ul>'),
(99, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.3-kunst-und-architektur.html'),
(100, 3, '<ul><li>stellen den Zusammenhang zwischen dem Produkt von Dezimalzahlen und dem Flächeninhalt dar.<br />\r</li><li>erklären das Produkt von Brüchen sowohl als Anteil eines Anteils als auch als Flächeninhalt<br />\r</li><li>wenden die Division als Umkehrung der Multiplikation an (Rückwärtsrechnen).</li></ul>'),
(100, 4, '<b>Entlastung</b><br />\r\n<ul><li>keine Doppelbrüche<br />\r</li><li>keine Rechenoperation mit Brüchen in gemischter Schreibweise<br />\r</li></ul>'),
(100, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.4-wir-planen-einen-garten.html'),
(101, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>bestimmen absolute und relative Häufigkeiten, arithmetisches Mittel und Median.<br />\r</li><li>veranschaulichen Häufigkeitstabellen mithilfe von Kreisdiagrammen<br />\r</li><li>lesen und interpretieren statistische Darstellungen.</li></ul>'),
(101, 3, '<ul><li>geben Informationen aus einfachen mathematikhaltigen Darstellungen mit eigenen Worten wieder.</li></ul>'),
(101, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Deutsch: Wie halte ich ein Kurzreferat?</li></ul>'),
(101, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.5-wir-fuehren-eine-befragung-durch.html'),
(102, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>erkunden Muster in Beziehungen zwischen Zahlen und stellen Vermutungen auf.<br />\r</li><li>stellen Beziehungen zwischen Zahlen in Diagrammen und Tabellen dar.</li></ul>'),
(102, 3, '<ul><li>übersetzen Muster in Zahlenterme.</li></ul>'),
(102, 4, '<b>Entlastung</b><br />\r\n<ul><li>Terme entwickeln mit dem Fokus auf lineare Zusammenhänge</li></ul>'),
(102, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.6-zahlenmuster-mit-termen-beschreiben.html'),
(103, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>führen Grundrechenarten für rationale Zahlen aus.<br />\r</li></ul>'),
(103, 3, '<ul><li>verbalisieren mit eigenen Worten unter Verwendung der Fachbegriffe ihre Vorstellungen zu der Bedeutung der durchgeführten Rechenoperationen im Kontext.</li></ul>'),
(103, 4, '<b>Entlastung</b><br />\r\n<ul><li>Addition und Multiplikation ganzer Zahlen bereits eingeführt (5.6)<br />\r</li></ul>'),
(103, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.1-guthaben-und-schulden.html'),
(104, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>erfassen und begründen Eigenschaften von ebenen Figuren (Winkelgrößen, Streckenlängen) mithilfe von Symmetrien und einfachen Winkelsätzen.</li></ul>'),
(104, 3, '<ul><li>nutzen eine Dynamische Geometriesoftware zum Erkunden von Winkelsätzen und Winkelsummensätzen.</li></ul>'),
(104, 4, '<b>Entlastung</b><br />\r\n<ul><li>Verringerung des händischen Zeichnens durch Einsatz der DGS<br />\r</li></ul>'),
(104, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.2-winkel-in-figuren-erschliessen.html'),
(105, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>stellen Terme mit Variablen zu Realsituationen auf.<br />\r</li><li>verwenden Terme nicht nur als Rechenaufforderung, sondern schwerpunktmäßig als Beschreibungsmittel für mathematische Zusammenhänge zwischen Größen</li></ul>'),
(105, 3, '<ul><li>beschreiben Realsituationen mithilfe von Termen mit Variablen (unbestimmte veränderliche Zahlen).<br />\r</li><li>stellen Terme mithilfe eines Tabellenkalkulationsprogramms auf und nutzen relative Bezüge.</li></ul>'),
(105, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>aufbauend auf Zahlentermen (5.2, 5.6, 6.2, 6.4) und algebraischen Termen (6.6)<br />\r</li><li>Vorbereitung zum Umformen von Termen und zum Lösen einfacher Gleichungen (7.8 und 7.9)<br />\r</li><li>Fach Informatik: Absprachen<br />\r</li></ul>'),
(105, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.3-kosten-mit-dem-tabellenkalkulationsprogramm-berechnen.html'),
(106, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>erkunden Zuordnungen, stellen diese auf verschiedene Arten dar und wechseln zwischen den Darstellungen (Tabelle, Graph, Term).<br />\r</li><li>identifizieren proportionale und antiproportionale Zusammenhänge.<br />\r</li><li>bestimmen Werte mithilfe der Dreisatzrechnung</li></ul>'),
(106, 3, '<ul><li>erarbeiten den Zuordnungsbegriff experimentell und stellen ihre Ergebnisse in kurzen vorbereiteten Vorträgen dar.<br />\r</li><li>bewerten die verschiedenen Darstellungsarten und stellen Beziehungen zwischen ihnen her.<br />\r</li><li>führen ihre Rechnungen auch erstmalig mit dem WTR aus.</li></ul>'),
(106, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Physik: Vorbereitend für Zeit-Geschwindigkeits- und Zeit-Weg-Diagramme<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>Lineare Zuordnungen ergeben sich aus den proportionalen und sind in dem Vorhaben eingebettet.<br />\r</li></ul>'),
(106, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.4-in-die-zukunft-schauen.html'),
(107, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>berechnen Prozentwert, Prozentsatz und Grundwert in Realsituationen (auch Zinsrechnung).</li></ul>'),
(107, 3, '<ul><li>ziehen Informationen aus mathematikhaltigen Darstellungen und einfachen authentischen Texten.</li></ul>'),
(107, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>fachübergreifend: Recherchen im Internet<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>Kreisdiagramme mit Tabellenkalkulation</li></ul>'),
(107, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.5-rund-ums-geld.html'),
(108, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>zeichnen Dreiecke aus gegebenen Winkel- und Seitenmaßen mithilfe der Kongruenzsätze.</li></ul>'),
(108, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.6-landschaften-vermessen.html'),
(108, 3, '<ul><li>erläutern die Arbeitsschritte ihrer Konstruktionen mit geeigneten Fachbegriffen (Konstruktionsbeschreibung).</li></ul>'),
(108, 4, '<b>Entlastung</b><br />\r\n<ul><li>besondere Linien im Dreieck nicht thematisiert, insbesondere nicht Schnittpunkte dieser</li></ul>'),
(109, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>planen Datenerhebungen und führen sie durch.<br />\r</li><li>nutzen und interpretieren Median, Spannweite und Quartile zur Darstellung von Häufigkeitsverteilungen als Boxplots.</li></ul>'),
(109, 3, '<ul><li>tragen Daten in elektronischer Form zusammen, stellen sie mithilfe einer Tabellenkalkulation dar und werten sie aus.</li></ul>'),
(109, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Politik / Geschichte / Erdkunde: Befragung zu einem aktuellen jugend-, schul- oder kommunalpolitischen Thema</li></ul>'),
(109, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.7-wie-arbeitet-ein-marktforschungsinstitut.html'),
(110, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>fassen Terme zusammen, multiplizieren sie aus und faktorisieren sie mit einem einfachen Faktor.</li></ul>'),
(110, 3, '<ul><li>untersuchen beschreibungsgleiche Terme zur Beschreibung geometrischer Figuren oder Realsituationen und stellen Vermutungen zu Term­umformungsregeln auf.<br />\r</li><li>vergleichen und bewerten Lösungswege und Argumentationen.</li></ul>'),
(110, 4, '<b>Entlastung</b><br />\r\n<ul><li>Beschränken auf einfache Umformungen, zunächst ohne Binome</li></ul>'),
(110, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.8-berechnungen-an-figuren.html'),
(111, 3, '<ul><li>nutzen Algorithmen zum Lösen mathematischer Standardaufgaben und bewerten ihre Praktikabilität.</li></ul>'),
(111, 4, '<b>Entlastung</b><br />\r\n<ul><li>Techniken der Äquivalenzumformungen zunächst auf einfachem Niveau</li></ul>'),
(111, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.9-knack-die-box.html'),
(111, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>lösen Gleichungen sowohl durch Probieren als auch algebraisch und nutzen die Probe als Rechenkontrolle.</li></ul>'),
(112, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>nutzen die binomischen Formeln als Rechenstrategie.<br />\r</li></ul>'),
(112, 3, '<ul><li>begründen mithilfe geometrischer und formalsymbolischer Darstellungen die Beschreibungsgleichheit von binomischen Termen.</li></ul>'),
(112, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Verknüpfung der Inhaltsfelder Geometrie und Algebra<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>nur die erste binomische Formel geometrisch veranschaulichen<br />\r</li></ul>'),
(112, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/8.1-zusammengesetzte-flaechen.html'),
(113, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>identifizieren und interpretieren lineare Zusammenhänge und wechseln zwischen den Darstellungen.<br />\r</li><li>stellen Terme linearer Funktionen auf.<br />\r</li><li>lösen lineare Gleichungen und lineare Gleichungssysteme tabellarisch und grafisch.</li></ul>'),
(113, 3, '<ul><li>übersetzen einfache Realsituationen in mathematische Modelle und überprüfen die Gültigkeit ihres Modells.</li></ul>'),
(113, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Physik: Zeit-Geschwindigkeits- und Zeit-Weg-Diagramme (vgl. 7.4)<br />\r</li></ul>'),
(113, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/8.2-mit-der-mathe-brille-unterwegs-lineare-funktionen.html');
INSERT INTO `part_t520_ein_r_uv_textfelder` (`uv_id`, `textfeld_id`, `uv_text`) VALUES
(114, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>lösen lineare Gleichungen sowie Gleichungssysteme mit zwei Variablen algebraisch und grafisch.<br />\r</li><li>interpretieren die Lösbarkeit beim Lösen von Gleichungen.</li></ul>'),
(114, 3, '<ul><li>übersetzen einfache Realsituationen in mathematische Modelle.<br />\r</li><li>nutzen verschiedene Darstellungsformen zur Problemlösung und reflektieren/bewerten diese.</li></ul>'),
(114, 4, '<b>Entlastung</b><br />\r\n<ul><li>Weglassen von Bewegungsaufgaben möglich<br />\r</li><li>mindestens ein Lösungsverfahren sicher beherrschen<br />\r</li></ul>'),
(114, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/8.3-unbekannte-werte-finden.html'),
(115, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>benutzen relative Häufigkeiten zur Schätzung von Wahrscheinlichkeiten. verwenden ein- und zweistufige Zufallsversuche zur Darstellung zufälliger Erscheinungen in alltäglichen Situationen und veranschaulichen sie mit Baumdiagrammen.<br />\r</li><li>bestimmen Wahrscheinlichkeiten mithilfe der Laplace-Regel und den Pfadregeln.</li></ul>'),
(115, 3, '<ul><li>übersetzen eine gegebene Sachsituation in ein geeignetes stochastisches Grundmodell, um Wahrscheinlichkeiten bestimmen zu können und umgekehrt.</li></ul>'),
(115, 4, '<b>Entlastung</b><br />\r\n<ul><li>nur ein- und zweistufige Zufallsexperimente<br />\r</li><li>keine beurteilende Statistik (bedingte Wahrscheinlichkeiten, Vierfeldertafel -&gt; EF)<br />\r</li></ul>'),
(115, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/8.4-mit-wahrscheinlichkeiten-vorhersagen-machen.html'),
(116, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>berechnen und überschlagen Quadratwurzeln einfacher Zahlen im Kopf.<br />\r</li><li>unterscheiden rationale und irrationale Zahlen.<br />\r</li><li>wenden das Radizieren als Umkehren des Potenzierens an.</li></ul>'),
(116, 3, '<ul><li>verwenden die Speicherfunktion des Taschenrechners, um mit genauen Werten weiter zu rechnen.<br />\r</li><li>wenden die Strategie des Rückwärtsrechnens an.</li></ul>'),
(116, 4, '<b>Entlastung</b><br />\r\n<ul><li>keine Näherungsverfahren (Intervallschachtelung, Heron-Verfahren)<br />\r</li><li>Beschränken auf anschauliche Begründung der Zahlbereichserweiterung</li></ul>'),
(116, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/8.5-auf-dem-weg-zu-irrationalen-zahlen.html'),
(117, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>benennen und charakterisieren Prismen und Zylinder und identifizieren sie in ihrer Umwelt.<br />\r</li><li>schätzen und bestimmen Umfang und Flächeninhalt von Kreisen und zusammengesetzten Figuren.<br />\r</li><li>schätzen und bestimmen Oberflächen und Volumina von Prismen, Zylindern.</li></ul>'),
(117, 3, '<ul><li>verwenden Skizzen und nutzen Hilfslinien zur Berechnung von Oberflächen und Volumina.</li></ul>'),
(117, 4, '<b>Entlastung</b><br />\r\n<ul><li>zunächst keine zusammengesetzten Körper</li></ul>'),
(117, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/8.6-vermutungen-durch-messen-und-wiegen-gewinnen.html'),
(118, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>wechseln zwischen den Darstellungsformen (in Worten, Tabelle, Graph, Term) linearer und quadratischer Funktionen und benennen ihre Vor- und Nachteile.<br />\r</li><li>deuten die Parameter der Termdarstellungen von linearen und quadratischen Funktionen in der grafischen Darstellung und nutzen dies in Anwendungssituationen.<br />\r</li></ul>'),
(118, 3, '<ul><li>übersetzen Realsituationen in Modelle.<br />\r</li><li>finden zu einem Modell passende Realsituationen.<br />\r</li><li>erläutern Grenzen des Modells.<br />\r</li><li>wählen ein geeignetes Werkzeug (Tabellenkalkulation, Funktionenplotter) aus und nutzen es.</li></ul>'),
(118, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Grundlage für Transformationen von Funktionen (-&gt; SII / EF)<br />\r</li><li>Fach Physik: Bewegungen<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>Stauchungen und Streckungen nur an einfachen Beispielen (Systematisierung -&gt; EF)<br />\r</li></ul>'),
(118, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.1-modellieren-mit-parabeln.html'),
(119, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>lösen einfache quadratische Gleichungen.</li></ul>'),
(119, 3, '<ul><li>reflektieren im Sachzusammenhang die Lösbarkeit bzw. Frage nach der Anzahl der Lösungen.<br />\r</li><li>vergleichen Lösungswege und Problemlösestrategien und bewerten sie.</li></ul>'),
(119, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Quadratische Funktionen als wichtige Vertreter der ganzrationalen Funktionen (EF)<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>Lösungsverfahren (z. B. pq-Formel, Faktorisieren) unmittelbar anwendbar<br />\r</li></ul>'),
(119, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.2-entwickeln-und-anwenden-von-loesungsverfahren.html'),
(120, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>schreiben große (und kleine) Zahlen mit Zehnerpotenzen.<br />\r</li><li>verwenden und erklären Potenzschreibweise mit ganzzahligen Exponenten.</li></ul>'),
(123, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Wurzel als Umkehrung des Potenzierens mit natürlichen Exponenten (&lt;- 8.5, -&gt; EF)</li></ul>'),
(120, 3, '<ul><li>vergleichen unterschiedliche Zahldarstellungen.</li></ul>'),
(120, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Geschichte, Politik: Geldentwertung, Staatsverschuldung<br />\r</li><li>Fach Biologie, Physik: Kleinstlebewesen, Astronomie<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>nur grundlegende Rechenregeln für Potenzen mit Blick auf Exponentialfunktionen (-&gt; EF)<br />\r</li></ul>'),
(123, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>berechnen geometrische Größen und verwenden dazu den Satz des Pythagoras.<br />\r</li><li>begründen Eigenschaften von Figuren mithilfe des Satzes des Thales.</li></ul>'),
(120, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.3-riesig-gross-und-winzig-klein.html'),
(121, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>wenden exponentielle Funktionen zur Lösung außermathematischer Problemstellungen aus dem Bereich Zinseszins an.<br />\r</li><li>vergleichen exponentielle und lineare Funktionen.</li></ul>'),
(121, 3, '<ul><li>übersetzen Realsituationen aus dem Bereich Zinsrechnung in Modelle.<br />\r</li><li>erläutern Grenzen des Modells.</li></ul>'),
(121, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Biologie, Physik: Wachstums- und Zerfallsprozesse<br />\r</li><li>Fach Politik: Entwicklung der Staatsverschuldung<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>nur eine Anwendung<br />\r</li></ul>'),
(121, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.4-wie-sich-sparen-lohnt.html'),
(122, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>beschreiben und begründen Ähnlichkeitsbeziehungen geometrischer Objekte und nutzen diese im Rahmen des Problemlösens zur Analyse von Sachzusammenhängen.<br />\r</li><li>vergrößern und verkleinern einfache Figuren maßstabsgetreu.</li></ul>'),
(122, 3, '<ul><li>lösen Probleme mit &quot;Vorwärts- und Rückwärtsarbeiten&quot;.</li></ul>'),
(122, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Kunst: Perspektiven<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>anschaulicher Ähnlichkeitsbegriff ersetzt Strahlensätze</li></ul>'),
(122, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.5-was-macht-ein-zoom.html'),
(123, 3, '<ul><li>finden und präsentieren Argumentationsketten.<br />\r</li><li>lösen Probleme durch Zerlegen in Teilprobleme.</li></ul>'),
(124, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>berechnen geometrische Größen (Längen und Winkel) und verwenden dazu die Definitionen von sin, cos und tan.</li></ul>'),
(124, 3, '<ul><li>lösen Probleme durch Zerlegen in Teilprobleme</li></ul>'),
(124, 4, '<b>Entlastung</b><br />\r\n<ul><li>kein Kosinus-Satz, kein Sinus-Satz</li></ul>'),
(124, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.7-wie-wird-die-welt-vermessen.html'),
(125, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>schätzen und bestimmen Oberflächen und Volumina: Pyramide, Kegel, Kugel.</li></ul>'),
(125, 3, '<ul><li>nutzen mathematisches Wissen und mathematische Symbole für Begründungen und Argumentationsketten.</li></ul>'),
(125, 4, '<b>Entlastung</b><br />\r\n<ul><li>Erstellen der Schrägbilder nur kurz, Interpretation von diesen notwendig</li></ul>'),
(125, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.8-mogelpackungen-und-design.html'),
(126, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>stellen die Sinusfunktion mit eigenen Worten, in Wertetabellen, Grafen und Termen dar.<br />\r</li><li>verwenden die Sinus-Funktion zur Beschreibung einfacher periodischer Vorgänge.</li></ul>'),
(126, 3, '<ul><li>bewerten und interpretieren Modelle für eine Realsituation.<br />\r</li><li>wählen ein geeignetes Werkzeug aus und nutzen es.</li></ul>'),
(126, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Transformationen der Sinus-Funktion in der EF<br />\r</li><li>Fach Biologie: Stoffkreisläufe<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>beschränkt auf die Sinus-Funktion</li></ul>'),
(126, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.9-sinus-funktion.html'),
(123, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.6-wie-wichtig-ist-der-rechte-winkel.html'),
(127, 2, 'Die Schülerinnen und Schüler...<br />\r\n<ul><li>analysieren grafische statistische Darstellungen kritisch und erkennen Manipulationen.<br />\r</li><li>beurteilen Chancen und Risiken.</li></ul>'),
(127, 3, '<ul><li>nutzen selbstständig Print- und elektronische Medien zur Informationsbeschaffung.<br />\r</li><li>überprüfen und bewerten Problembearbeitungen und bewerten Lösungswege.</li></ul>'),
(127, 4, '<b>Lernvoraussetzungen/Vernetzung</b><br />\r\n<ul><li>Fach Politik, Geschichte, Deutsch: Auswertung von Grafiken aus aktuellen Zeitungen<br />\r</li></ul><br />\r\n<b>Entlastung</b><br />\r\n<ul><li>Beschränkung auf einfache manipulative Abbildungen<br />\r</li><li>keine stochastische Unabhängigkeit (-&gt; EF)</li></ul>'),
(127, 5, '<b>Konkretisierung des UV:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/mathematik-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.10-wie-luegt-man-mit-statistik.html'),
(128, 5, '<b> <ul><li><em>speaking</em> / Sprachmittlung,</b> u.a. mit vertrauten Wendungen und Sätzen über Ereignisse und Erlebnisse erzählen und berichten; global verstandenes Gehörtes anderen auf Deutsch erklären (vgl. ebd. S. 78-79)<br />\r</li><b> <li>Erfahrungsfelder</b> &quot;zu Hause hier und dort&quot; und &quot;lernen, arbeiten, freie Zeit&quot; (vgl. ebd. S. 76)<br />\r</li></ul><br />\r\nKonkretisierung des Unterrichtsvorhabens:<br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.1.2-my-life-in-a-nutshell.html'),
(129, 2, '<b>Ausbildung/Schule:</b> Schule und Schulalltag<br />\r\n<br />\r\n'),
(129, 3, '<b>KK:</b><br />\r\n<b>Schreiben:</b> Lernprozesse schriftlich begleiten (z.B. Notizen anfertigen), alltagsbezogene Kurztexte verfassen<br />\r\n<b>Lesen:</b> einfache Geschichten inhaltlich erschließen (Personen, Handlung)<br />\r\n<em>focus speech act: expressing likes/dislikes (e.g. I like English ...)</em><br />\r\n<b>MK:</b><br />\r\nzentrale Handlungselemente erkennen, Wichtiges von Unwichtigem unterscheiden, <em>note-taking,</em> einfache Kompensationsstrategien, z.B. paraphrasieren, entwickeln'),
(129, 4, '-'),
(129, 5, '<b> <ul><li><em>reading / writing,</em> </b> u.a. kurze Texte mit bekanntem Wortschatz verstehen, einfache Notizen anfertigen (vgl. ebd. S. 78-79)<br />\r</li><b> <li>Erfahrungsfeld</b> &quot;lernen, arbeiten, freie Zeit&quot; (vgl. ebd. S. 76)</li></ul>'),
(130, 2, '<b>Persönliche Lebensgestaltung:</b> Familie, Freunde, tägliches Leben und Tagesabläufe, Freizeit<br />\r\n<b>Teilhabe am gesellschaftlichen Leben:</b> Reisen, Einblicke in altersgemäße aktuelle kulturelle Ereignisse (u.a. Musik, Sport)'),
(130, 3, '<b>KK:</b><br />\r\nSprechen: zusammenhängendes Sprechen: einfache Texte darstellend laut lesen und vortragen<br />\r\nSprechen: an Gesprächen teilnehmen: Rollenspielen einfache Alltagssituationen erproben <em>(focus speech act: social conventions)</em><br />\r\n<b>IK:</b><br />\r\nHandeln in Begegnungssituationen: einfache fiktive und reale Begegnungssituationen bewältigen; einige wichtige kulturspezifische Verhaltensweisen kennen (z.B. Begrüßungsrituale, Anredekonventionen, Höflichkeitsfloskeln)'),
(130, 4, '-'),
(130, 5, '<ul><li><em>speaking</em>, u.a. in Rollenspielen mit bekanntem Wortschatz und bekannten Redemitteln zunehmend selbstständig agieren (vgl. ebd. S. 77)<br />\r</li><li>Erfahrungsfelder &quot;zu Hause hier und dort&quot; (u.a. <em>me and my family, leisure time</em>) (vgl. ebd. S. 76)</li></ul>'),
(131, 2, '<b>Persönliche Lebensgestaltung:</b> Familie, Freunde, tägliches Leben und Tagesabläufe, Freizeit'),
(131, 3, '<b>KK:</b><br />\r\n<b>Hör-/Hörsehverstehen:</b> einfachen (ggf. authentischen) Filmausschnitten wesentliche Informationen entnehmen<br />\r\n<b>Sprechen: an Gesprächen teilnehmen:</b> in Rollenspielen die Situation eines Verkaufsgesprächs erproben <em>(focus speech act: sales talk)</em>'),
(131, 4, '-'),
(131, 5, '<ul><li><b> <em>listening</em> </b>, u.a. didaktisierte und authentische kindgemäße fiktionale Texte verstehen und ihnen in Bezug auf Handlungsschritte und Akteure wichtige Informationen entnehmen (vgl. ebd. S. 77)<br />\r</li><li><b>Erfahrungsfeld</b> &quot;freie Zeit&quot;<br />\r</li></ul>(vgl. ebd. S. 76)<br />\r\n<br />\r\n<b>Konkretisierung des Unterrichtsvorhabens: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.2.2-lets-go-shopping.html'),
(132, 2, '<b>Persönliche Lebensgestaltung: </b>Familie, Freunde, tägliches Leben und Tagesabläufe, Freizeit<br />\r\n<b>Teilhabe am gesellschaftlichen Leben: </b> Feste und Traditionen'),
(132, 3, '<b>KK:</b><br />\r\n<b>Leseverstehen:</b> kurzen privaten und öffentlichen Alltagstexten (z.B. Anzeigen, Einladungen) sowie Lehrbuchtexten und adaptierten Texten die wesentlichen Informationen entnehmen<br />\r\n<b>Schreiben:</b> einfache Geschichten erweitern und aus einer anderen Perspektive erzählen <em>(focus speech act: announcing, expressing gratitude)</em><br />\r\n<b>Sprachliche Mittel:</b> Gefühl für Regelhaftigkeit der Orthographie entwickeln und zunehmend sicher über die Orthographie ihres produktiven Grundwortschatzes verfügen'),
(132, 4, '-'),
(132, 5, '<ul><li><b> <em>reading / writing,</em> </b>  u.a. kurze - auch authentische - Texte mit bekanntem Wortschatz verstehen und entnehmen die wesentlichen Handlungselemente, z.B. Ort, Zeit entnehmen (vgl. ebd. S. 78-79)<br />\r</li><li><b>Erfahrungsfelder</b> &quot;zu Hause hier und dort&quot; (vgl. ebd. S. 76)<br />\r</li></ul><br />\r\n<b>Konkretisierung des Unterrichtsvorhabens: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/5.2.3-its-my-party.html'),
(133, 2, '<b>Persönliche Lebensgestaltung:</b> Freunde, Freizeit<br />\r\n<b>Teilhabe am gesellschaftlichen Leben:</b> Reisen, Einblicke in altersgemäße aktuelle kulturelle Ereignisse (u.a. Musik, Sport)'),
(133, 3, '<b>KK:</b><br />\r\n<b>Hör-/Hörsehverstehen:</b> in einfachen Geschichten und Spielszenen wesentliche Merkmale von Figuren verstehen und den Handlungsablauf nachvollziehen<br />\r\n<b>Sprechen:</b> an Gesprächen teilnehmen: Gefühle über Ereignisse ausdrücken <em>(focus speech act: expressing feelings)</em><br />\r\n<b>Sprechen: zusammenhängendes Sprechen:</b> Vorlieben, Erlebnisse und Tätigkeiten beschreiben und vergleichen'),
(133, 4, '-'),
(133, 5, '<b>Schwerpunkte/Entlastung:</b><br />\r\nSprechen: Fokussierung u.a. auf Emotionen ausdrücken (vgl. UV 5.2.1)<br />\r\n<br />\r\nKonkretisierung des Unterrichtsvorhabens: <br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.1.1-good-bye-holidays.html'),
(134, 2, '<b>Ausbildung/Schule:</b> Schule und Schulalltag in Großbritannien oder Irland'),
(134, 3, '<b>KK:</b><br />\r\n<b>Leseverstehen:</b> einfachen, ggf. adaptierten Texten zu vertrauten Themen wesentliche Informationen entnehmen<br />\r\n<b>Schreiben:</b> einfache deskriptive Texte (z. B. Flyer) erstellen<br />\r\n<b>IK:</b> kulturspezifische Informationen aus dem/zum englischsprachigen Schulsystem aufnehmen und mit eigenen Schulerfahrungen vergleichen <em>(focus speech act: describing, comparing)</em>'),
(134, 4, '-'),
(134, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\nAnknüpfung an Orientierungswissen &quot;Schulleben&quot; (vgl. UV 5.1.3)<br />\r\n 	<br />\r\n<b>Konkretisierung des Unterrichtsvorhabens:</b> <br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.1.2-school-life.html'),
(135, 2, '<b>Inhaltsfeld und Schwerpunkte:</b> <br />\r\n<b>Teilhabe am gesellschaftlichen Leben:</b> Aspekte von:<br />\r\nFeste und Traditionen, exemplarische historische Persönlichkeiten und Ereignisse, Reisen, Einblicke in altersgemäße aktuelle kulturelle Ereignisse (u.a. Musik, Sport)'),
(135, 3, '<b>KK:</b><br />\r\n<b>Sprechen: an Gesprächen teilnehmen/Sprachmittlung:</b> in Rollenspielen (z.B. Familienbesuch in London) eine Vermittlerrolle einnehmen: Äußerungen verstehen und in der jeweils anderen Sprache das Wichtigste wiedergeben bzw. erklären <em>(focus speech act: giving explanations, expressing emotions)</em><br />\r\n<b>MK:</b><br />\r\neinfache authentische Materialien (vor allem Texte und Bilder) im Internet recherchieren und themenspezifisch für ein Dossier/für eine Präsentation zusammenstellen'),
(135, 4, '-'),
(135, 5, '<b>Verknüpfung / Entlastung:</b><br />\r\n<br />\r\n<ul><li>Fokussierung u.a. auf Erklärungen abgeben (vgl. UV 5.2.1)<br />\r</li><li>Strategietraining: Wesentliches von Unwesentlichem unterscheiden (vgl. UV 5.1.3 MK)<br />\r</li></ul> 	<br />\r\n<b>Konkretisierung des Unterrichtsvorhabens: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.1.3-i-love-london.html'),
(136, 2, '<b>Persönliche Lebensgestaltung:</b> Familie, Freunde, Freizeit'),
(136, 3, '<b>KK:</b><br />\r\n<b>Leseverstehen:</b> Arbeitsanweisungen, Anleitungen und Erklärungen zu gesunder Ernährung und Sport verstehen<br />\r\n<b>Sprechen:</b> an Gesprächen teilnehmen: in Rollenspielen (z.B. Arztbesuch, Interview) einfache Sprechsituationen bewältigen, z.B. Informationen austauschen, Auskünfte einholen und geben <em>(focus speech act: asking for/giving information; expressing helplessness)</em>'),
(136, 4, '-'),
(136, 5, '<b>Verknüpfung / Entlastung:</b><br />\r\n<ul><li>Anknüpfung an Orientierungswissen <em>sport &amp; health</em> (vgl. Erfahrungsfeld <em>my body</em>, Lehrplan Englisch Grundschule, S. 76)<br />\r</li><li>Fokussierung u.a. Informationen erfragen/geben (vgl. UV 5.1.1)</li></ul>'),
(137, 2, '<b>Persönliche Lebensgestaltung:</b> Familie, Freunde, tägliches Leben, Freizeit<br />\r\n<b>Berufsorientierung:</b> Bedeutung von Arbeit im Leben der eigenen Familie und dem von Freunden<br />\r\n'),
(137, 3, '<b>KK:</b><br />\r\n<b>Schreiben:</b> kurze persönliche Alltagstexte (z.B. Briefe, Postkarten, E-Mails, SMS, Chat) schreiben und Sachverhalte aus dem eigenen Erfahrungshorizont adressatengerecht beschreiben und kommentieren(z.B. Arbeitsleben der Eltern) <em>(focus speech act: expressing an opinion)</em><br />\r\n<b>MK:</b><br />\r\neigene Texte nach Vorlagen gestalten und einfache Umformungen vornehmen, eigene und fremde Texte unter Anleitung korrigieren und überarbeiten'),
(137, 4, '-'),
(137, 5, '<b>Synergie:</b><br />\r\nTextüberarbeitungsstrategien (vgl. u.a. KLP Deutsch, S. 29)'),
(138, 2, '<b>Persönliche Lebensgestaltung:</b> Familie, Freunde, Freizeit<br />\r\n<b>Teilhabe am gesellschaftlichen Leben:</b> exemplarische historische und fiktive Persönlichkeiten und Ereignisse, Reisen'),
(138, 3, '<b>KK:</b><br />\r\n<b>Leseverstehen:</b> kürzere und längere adaptierte Erzähltexte verstehen<br />\r\n<b>Schreiben:</b> einfache Modelltexte umformen und kurze persönliche Texte schreiben <em>(focus speech act: expressing wishes)</em><br />\r\n<b>MK:</b><br />\r\neigene Texte nach Vorlagen gestalten und Umformungen vornehmen; ein kleines Dossier zu einem Thema erstellen'),
(138, 4, '-'),
(138, 5, '<b>Verknüpfung / Entlastung:</b><br />\r\n<ul><li>Reaktivierung der Kompetenz im Umgang Lesestrategien (vgl. UV 5.1.3)<br />\r</li><li>methodische Kompetenzen: Fokussierung u.a. auf Texte nach Vorlagen umgestalten (vgl. UV 6.2.2)<br />\r</li></ul><br />\r\n<b>Konkretisierung des Unterrichtsvorhabens: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/6.2.3-mysterious-britain.html'),
(139, 2, '<b>Persönliche Lebensgestaltung:</b> Einblicke in das Alltagsleben von Jugendlichen (Musik, Sport), Aspekte des Schulalltags<br />\r\n<b>Teilhabe am gesellschaftlichen Leben:</b> Einblicke in wichtige kulturelle Ereignisse'),
(139, 3, '<b>KK:</b><br />\r\n<b>Leseverstehen:</b> authentischen Alltagstexten (z.B. Broschüren, Flyer, Plakate) wesentliche Informationen entnehmen<br />\r\n<b>Sprechen:</b> zusammenhängendes Sprechen: freies oder materialgestütztes Sprechen <em>(focus speech act: praising someone)</em><br />\r\n<b>IK:</b><br />\r\nAspekte der gesellschaftlichen Wirklichkeit der eigenen Welt und weiterer englischsprachiger Länder: Bewusstmachung von Gemeinsamkeiten und Unterschieden <em>(focus speech act: comparing, expressing joy/ frustration)</em>'),
(139, 4, '-<br />\r\n'),
(139, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\nAnknüpfung an Orientierungswissen <em>sport &amp; leisure time</em> (vgl. UV 6.2.1)<br />\r\n 	<br />\r\n<b>Konkretisierung des Unterrichtsvorhabens:</b> <br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.1.1-sport.html<br />\r\n'),
(140, 2, '<b>Persönliche Lebensgestaltung:</b> Medien in der Freizeitgestaltung'),
(140, 3, '<b>KK:</b><br />\r\n<b>Schreiben:</b> Sachverhalte gemäß vorgegebenen Textsorten darstellen (z.B. <em>report in a teen magazine</em>)<br />\r\n<b>Sprechen:</b> an Gesprächen teilnehmen: sich zu Aspekten der Medienwelt kritisch äußern und persönlich wertend Stellung nehmen <em>(focus speech act: drawing attention to something, language of advertising)</em><br />\r\n<b>MK:</b><br />\r\nWirkung und Gestaltung von medialen Texten (z.B. Werbung, Zeitungsartikeln, <em>teen magazines</em>); globales, detailliertes und selektives Leseverstehen'),
(140, 4, '-'),
(140, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\n<b>Schreiben:</b> Fokussierung u.a. auf Textsortenmerkmale (vgl. UV 6.1.2)'),
(141, 2, '<b>Teilhabe am gesellschaftlichen Leben:</b> Kinderarbeit in der industriellen Revolution, Kinderrechte '),
(141, 3, '<b>KK:</b><br />\r\n<b>Leseverstehen:</b> im Unterricht thematisch vorbereiteten Sachtexten wesentliche Informationen entnehmen<br />\r\n<b>Hör-/Hörsehverstehen:</b> einfachen Filmausschnitten wichtige Informationen entnehmen<br />\r\n<b>Schreiben:</b> einfache Formen des beschreibenden, berichtenden und Stellung nehmenden Schreibens einsetzen <em>(focus speech act: reporting, expressing an opinion)</em><br />\r\n<b>MK:</b><br />\r\neine einfache Internetrecherche zum Thema <em>Industrial Revolution from a young person s perspective</em> durchführen und ein kleines Dossier erstellen'),
(141, 4, '-'),
(141, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\n<ul><li>Schreiben: Fokussierung u.a. auf Textsorte Bericht<br />\r</li><li>Meinungsäußerung, Erklärungen geben (vgl. UV 6.1.3)<br />\r</li></ul> 	<br />\r\n<b>Konkretisierung des Unterrichtsvorhabens: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.1.3-digging-deep.html<br />\r\n'),
(142, 2, '<b>Persönliche Lebensgestaltung:</b> Freizeitgestaltung Leben in der <em>peer group</em><br />\r\n<b>Teilhabe am gesellschaftlichen Leben:</b> Nationale und regionale Identität, Einwanderung nach Großbritannien'),
(142, 3, '<b>KK:</b><br />\r\n<b>Sprechen: an Gesprächen teilnehmen:</b> in Gesprächssituationen Erfahrungen, Erlebnisse und Gefühle einbringen; in einfacher Form Meinungen und eigene Positionen vertreten; Gespräche beginnen, fortführen, beenden <em>(focus speech act: expressing an interest, expressing enthusiasm, asking for information)</em><br />\r\n<b>Sprechen: zusammenhängendes Sprechen:</b> in kurzen Präsentationen Arbeitsergebnisse unter Verwendung von einfachen visuellen Hilfsmitteln oder Notizen vortragen<br />\r\n<b>MK:</b><br />\r\nProjekte durchführen und die Ergebnisse mit unterschiedlichen Visualisierungen und in unterschiedlichen Präsentationsformen vorstellen'),
(142, 4, '-'),
(142, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\nAnknüpfung an Orientierungswissen <em>British History</em> (vgl. UV 7.1.3, UV 6.2.3)'),
(143, 2, '<b>Persönliche Lebensgestaltung:</b> Freundschaft, Leben in der <em>peer group</em>'),
(143, 3, '<b>KK:</b><br />\r\n<b>Sprechen: an Gesprächen teilnehmen:</b> in Gesprächssituationen Erfahrungen, Erlebnisse und Gefühle einbringen; Diskussionen/Streitgespräche <em>(focus speech act: expressing emotions of joy, disappointment, annoyance; agreeing/contradicting)</em><br />\r\n<b>Leseverstehen:</b> längere adaptierte Erzähltexte bezogen auf Thema, Figuren, Handlungsverlauf, emotionalen Gehalt und Grundhaltung verstehen<br />\r\nSchreiben: einfache Formen des kreativen Schreibens einsetzen, z.B. Texte ergänzen, Figuren umgestalten<br />\r\n<b>MK:</b><br />\r\nLesen einer Ganzschrift (z.B. Kurzroman)<br />\r\nVorgegebene und eigene mündliche und schriftliche Texte nach einem einfachen Schema strukturieren (z.B. Pro-Kontra-Diskussion)'),
(143, 4, '-'),
(143, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\nSprechen: Fokussierung u.a. auf Emotionen ausdrücken (vgl. UV 6.1.3)<br />\r\n 	<br />\r\nKonkretisierung des Unterrichtsvorhabens:<br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/7.2.2-dealing-with-differences.html'),
(144, 2, '<b>Teilhabe am gesellschaftlichen Leben:</b> Migration als persönliches Schicksal'),
(144, 3, '<b>KK:</b><br />\r\n<b>Hör-/Hörsehverstehen:</b> einfachen Radio- und Filmausschnitten wichtige Informationen entnehmen<br />\r\n<b>Leseverstehen:</b> im Unterricht thematisch vorbereiteten Sachtexten wesentliche Informationen (z.B. Daten, Fakten, Statistiken, Meinungen, Argumente) entnehmen sowie Wirkungsabsichten verstehen<br />\r\n<b>IK:</b><br />\r\nGemeinsamkeiten und Unterschiede zur eigenen Welt erkennen und diskutieren; einfache Begegnungssituationen auch mit Blick auf mögliche Missverständnisse und Konflikte bewältigen <em>(focus speech act: asking for/giving reasons, justifying, expressing hope, describing similarities and differences/comparing)</em>'),
(144, 4, '-'),
(144, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\n<ul><li>Leseverstehen: Fokussierung u.a. auf Textsorte Sachtext<br />\r</li><li>Reaktivierung der Kompetenz im Umgang mit Hör/Hörsehstrategien (vgl. UV 7.1.3)<br />\r</li><li>Begründungen geben, Unterscheidungen vornehmen (vgl. UV 7.1.1) 	<br />\r</li></ul><br />\r\n<b>Konkretisierung des Unterrichtsvorhabens:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/8.1.1-new-york.html<br />\r\n'),
(145, 2, '<b>Ausbildung/Schule:</b> exemplarische Einblicke in den Lernbetrieb einer Schule in den USA<br />\r\n<b>Teilhabe am gesellschaftlichen Leben:</b> Berufsorientierung: Kinderrechte<br />\r\n'),
(145, 3, '<b>KK:</b><br />\r\n<b>Sprechen: an Gesprächen teilnehmen:</b> in Rollenspielen (z.B. <em>discussion</em>) unterschiedliche Perspektiven erkunden<br />\r\n<b>Schreiben:</b> in persönlichen Stellungnahmen Meinungen, Hoffnungen und Einstellungen darlegen <em>(focus speech act: expressing an opinion, giving reasons)</em><br />\r\n<b>MK:</b><br />\r\n<ul><li>schriftliche Texte nach einem einfachen Schema strukturieren (z.B. Pro-Kontra-Argumentation)<br />\r</li><li>anhand einfacher Textvorlagen Rollenspiele durchführen<br />\r</li></ul>'),
(145, 4, '-'),
(145, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\n<ul><li>Anknüpfung an Orientierungswissen &quot;Schulleben&quot; (vgl. UV 5.1.3, 6.1.2)<br />\r</li><li>Fokussierung u.a. Argumentieren (vgl. UV 7.2.2)</li></ul>'),
(146, 2, '<b>Teilhabe am gesellschaftlichen Leben:</b> Regionale Identität am Beispiel einer Region in den USA'),
(146, 3, '<b>KK:</b><br />\r\n<b>Sprechen: an Gesprächen teilnehmen:</b> einen Sachverhalt kommentieren, Vorschläge machen, jemanden durch Argumente überzeugen <em>(focus speech act: making suggestions, dis-/agreeing, convincing sb.)</em><br />\r\n<b>Hörverstehen:</b> zentrale Informationen aus Hörtexten entnehmen - auch mit einfach erkennbaren Aussprachevarianten<br />\r\n<b>Schreiben:</b> Sachverhalte gemäß vorgegebener Textsorte darstellen (z.B. einen Zeitungsbericht verfassen)<br />\r\n<b>MK:</b><br />\r\nglobales, detailliertes und selektives Hörverstehen'),
(146, 4, '-'),
(146, 5, '<b>Verknüpfungen/Entlastung:</b><br />\r\n<ul><li>Sprechen: Fokussierung auf jmd. überzeugen (vgl. UV 7.2.2)<br />\r</li><li>Schreiben: Fokussierung auf Textsorte Bericht (vgl. UV 7.1.2)</li></ul>'),
(147, 2, '<b>Teilhabe am gesellschaftlichen Leben:</b> Nationale und regionale Identität am Beispiel einer Region in den USA'),
(147, 3, '<b>KK:</b><br />\r\nLeseverstehen: längere adaptierte Erzähltexte bezogen auf Thema, Figuren, Handlungsverlauf, emotionalen Gehalt und Grundhaltung verstehen<br />\r\n<b>Schreiben:</b><br />\r\nSachverhalte gemäß vorgegebenen Textsorten darstellen (z.B. Personenbeschreibungen, Stellungnahmen mit Begründungen); einfache Formen des kreativen Schreibens einsetzen (z.B. Texte ergänzen, eine Figur umgestalten) <em>(focus speech act: describing, characterizing)</em><br />\r\n<b>IK:</b><br />\r\nWissen über englischsprachig geprägte Lebenswelten im europäischen Kontext durch exemplarische Einblicke am Beispiel einer Region der USA erweitern'),
(147, 4, '-'),
(147, 5, '<b>Verknüpfungen/Entlastungen:</b><br />\r\n<ul><li>Reaktivierung der Kompetenz im Umgang mit Lesestrategien (vgl. z.B. UV 6.2.3 oder UV 7.2.2)<br />\r</li><li>Anknüpfung an Orientierungswissen British culture (vgl. UV 6.1.3, UV 7.2.1)</li></ul>'),
(148, 2, '<b>Persönliche Lebensgestaltung:</b> Medien in der Freizeitgestaltung'),
(148, 3, '<b>KK:</b><br />\r\n<b>Sprechen: an Gesprächen teilnehmen:</b> Erfahrungen, Erlebnisse und Gefühle einbringen und Positionen zum eigenen Medienkonsum in einer <em>panel discussion</em> vertreten<br />\r\n<em>(focus speech act: dis-/agreeing, concluding a statement)</em><br />\r\n<b>Hör-/Hörsehverstehen:</b> einfachen Radio- und Filmausschnitten wichtige Informationen entnehmen<br />\r\n<b>Sprachmittlung:</b> mündlich gegebene Informationen in der jeweils anderen Sprache sinngemäß wiedergeben<br />\r\n<b>MK:</b><br />\r\nargumentative Stützen z.B. für eine Pro-Kontra-Diskussion erstellen'),
(148, 4, '-'),
(148, 5, '<b>Verknüpfungen/Entlastung:</b><br />\r\n<ul><li>Sprechen: Fokussierung auf Positionen vertreten (vgl. UV 7.2.1)<br />\r</li><li>Reaktivierung der Kompetenz im Umgang mit Hör/Hörsehstrategien (global, detailliert, selektiv) (vgl. UV 5.2.2, 6.1.1)<br />\r</li></ul><br />\r\n<b>Konkretisierung des Unterrichtsvorhabens:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/8.2.3-the-media.html'),
(149, 2, '<b>Berufsorientierung:</b> Berufliche Interessensprofile, Bewerbungen'),
(149, 3, '<b>KK:</b><br />\r\n<b>Sprachmittlung:</b> den Inhalt von einfachen Sach- und Gebrauchstexten in der jeweils anderen Sprache sinngemäß wiedergeben <em>(focus speech act: conducting an interview, negotiating, positive/negative evaluation)</em><br />\r\n<b>Sprechen:</b> an Gesprächen teilnehmen/zusammenhängendes Sprechen: in einem Interview konkrete Auskünfte geben (z.B. <em>job interviews</em>); Kurzreferate halten <em>(focus speech act: conducting an interview, negotiating, positive/negative evaluation)</em><br />\r\n<b>IK:</b><br />\r\nGemeinsamkeiten und Unterschiede zwischen deutsch-, englisch- sowie französisch- und ggfs. herkunftssprachigen Arbeitswelten kennen und bewerten lernen<br />\r\n<b>MK:</b><br />\r\nLerngelegenheiten gezielt nutzen, die sich aus dem Miteinander von Deutsch, ggf. den Herkunftssprachen sowie Englisch als erster Fremdsprache, einer zweiten und ggf. einer dritten Fremdsprache ergeben'),
(149, 4, '-'),
(149, 5, '<b>Verknüpfungen/Entlastung:</b><br />\r\n<b>Synergie:</b><br />\r\nDeutsch / Englisch / Französisch: Bewerbungstraining (vgl. KLP Französisch S. 17, S. 34, KLP Deutsch S. 14, S. 16)<br />\r\n<b>Verknüpfung/Entlastung:</b><br />\r\nAnknüpfung an Orientierungswissen &quot;Job&quot;, auch aus interkultureller Perspektive (vgl. UV 8.1.2)<br />\r\n<br />\r\n<b>Konkretisierung des Unterrichtsvorhabens: </b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.1.1-your-dream-job.html'),
(150, 2, '<b>Teilhabe am gesellschaftlichen Leben:</b> Exemplarische Einblicke in das Leben in Australien, Demokratie und Menschenrechte'),
(150, 3, '<b>KK:</b><br />\r\n<b>Hör-/Hörsehverstehen:</b> Filmsequenzen wesentliche Informationen entnehmen (Figuren, <em>setting</em>, Handlung)<br />\r\n<b>Sprechen: an Gesprächen teilnehmen:</b> an einfachen Pro- und Kontra-Diskussionen teilnehmen <em>(focus speech act: organizing a speech)</em>, Strategien zur Überwindung von Kommunikationsschwierigkeiten entwickeln<br />\r\n<b>IK:</b><br />\r\n<b>Handeln in Begegnungssituationen:</b> kulturspezifische Konventionen erkennen und beachten<br />\r\n<b>MK:</b><br />\r\ndas Zusammenspiel von Sprache, Bild und Ton in einfachen Filmausschnitten beschreiben'),
(150, 4, '-'),
(150, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\n<b>Hör-/ Hörsehverstehen:</b> gezielte Informationsentnahme aus Filmen (vgl. u.a. UV 8.1.1)<br />\r\n<br />\r\n<b>Konkretisierung des Unterrichtsvorhabens:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.1.2-down-under-in-australia.html'),
(151, 2, 'Teilhabe am gesellschaftlichen Leben:<br />\r\nEinblicke in das politische System der USA, Demokratie und Menschenrechte'),
(151, 3, '<b>KK:</b><br />\r\n<b>Leseverstehen:</b> Sach- und Gebrauchstexten, Texten der öffentlichen Kommunikation wesentliche Punkte entnehmen sowie Einzelinformationen in den Kontext der Gesamtaussage einordnen<br />\r\n<b>IK:</b><br />\r\ndas Verständnis von Demokratieformen und Möglichkeiten der gesellschaftlichen Teilhabe in englischsprachigen Ländern (hier: USA) kennen und einschätzen lernen <em>(focus speech act: giving reasons, justifying, evaluating)</em><br />\r\n<b>MK:</b><br />\r\nmonolinguale und bilinguale Online-Wörterbücher korrekt verwenden'),
(151, 4, '-'),
(151, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\n<b>interkulturelle Kompetenzen:</b> Fokussierung auf (kulturspezifisch geprägte) Begründungen / Einschätzungen geben (vgl. UV 8.1.1)<br />\r\n<br />\r\n<b>Konkretisierung des Unterrichtsvorhabens:</b><br />\r\nhttp://www.schulentwicklung.nrw.de/lehrplaene/lehrplannavigator-s-i/gymnasium-g8/englisch-g8/hinweise-und-beispiele/schulinterner-lehrplan/9.2.1-get-up-stand-up.html'),
(152, 2, '<b>Persönliche Lebensgestaltung:</b> Partnerschaft, Beziehungen zwischen den Geschlechtern (<em>gender</em>), Jugendkulturen (z.B. <em>teenagers on the streets</em>)<br />\r\n<b>Teilhabe am gesellschaftlichen Leben:</b> Sprache und sprachlicher Wandel (z.B. <em>teenage language</em>)'),
(152, 3, '<b>KK:</b><br />\r\n<b>Leseverstehen:</b> literarische Texte verstehen und stilistische Besonderheiten erkennen, einen Roman(auszug) verstehen und interpretieren<br />\r\n<b>Schreiben:</b> eine Geschichte aus unterschiedlichen Perspektiven schreiben<br />\r\n<b>IK:</b><br />\r\nWerte, Haltungen und Einstellungen: literarische Texte aus (auch kulturell) unterschiedlichen Perspektiven erschließen<br />\r\n<b>MK:</b><br />\r\nunterschiedliche Verarbeitungsstile des Lesens (detailliertes, selektives, globales Lesen) entsprechend der gewählten Leseintention einsetzen<br />\r\nLesen einer Ganzschrift'),
(152, 4, '-'),
(152, 5, '<b>Verknüpfung/Entlastung:</b><br />\r\nReaktivierung der Kompetenz im Umgang mit Lesestrategien (vgl. UV 8.2.2)'),
(153, 3, '<b>Leseverstehen</b><br />\r\n<ul><li>ritualisierten persönlichen Mitteilungen und einfachen öffentlichen Alltagstexten aufgabengeleitet spezifische und allgemeine Informationen entnehmen<br />\r</li></ul><b>Schreiben</b><br />\r\n<ul><li>Emails/Briefe nach Modelltexten verfassen<br />\r</li><li>kurze Gedichte/einzelne Strophen nach Modelltexten gestalten<br />\r</li></ul>'),
(153, 5, '<b> Schwerpunktsetzung: </b><br />\r\nReproduktives Schreiben gemäß des Prinzips &quot;erst Lesen, dann Schreiben&quot;; Akzente und besondere Schriftzeichen (cédille, tréma, besondere Buchstaben); Diskrepanz Schriftbild-Lautbild<br />\r\n<b> Synergien: </b><br />\r\nWorterschließungsstrategien (&lt;&gt;Deutsch/Englisch -&gt; Französisch); Vergleich Textformate (&lt;&gt;Deutsch/Englisch -&gt; Französisch)<br />\r\n'),
(154, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nBegegnung mit einer französischen Familie; Familienmitglieder'),
(154, 5, '<b>Schwerpunktsetzung: </b> <br />\r\nFestigung der Phonetik und Orthographie (Vorkurs)<br />\r\n<b>Entlastung:</b><br />\r\nreproduktives Schreiben nach Modelltexten<br />\r\n'),
(154, 3, '<b>Sprechen: zusammenhängendes Sprechen</b><br />\r\n<ul><li>eine Familie und deren Alltag vorstellen<br />\r</li><li>Bilder und Orte beschreiben<br />\r</li></ul><b>Sprechen: an Gesprächen teilnehmen</b><br />\r\nFragen zur Familie und Wohnort stellen und beantworten<br />\r\n<b>Schreiben</b><br />\r\n<ul><li>(Familien-)Portraits verschriftlichen<br />\r</li></ul>'),
(153, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\npersönliche Vorlieben, Interessen und Abneigungen; Freizeitaktivitäten '),
(155, 2, '<b>Persönliche Lebensgestaltung: </b><br />\r\nTagesablauf und Alltag von Kindern in Frankreich<br />\r\n<b>Schule:</b><br />\r\n eine französische Schule; das deutsche und französische Schulsystem im Vergleich<br />\r\n'),
(155, 3, '<b>Leseverstehen</b><br />\r\n<ul><li>Tagesabläufen und Schulportraits spezifische und allgemeine Informationen entnehmen<br />\r</li><li>authentischen schulischen Alltagstexten, spezifische Informationen entnehmen<br />\r</li></ul><b>Sprachmittlung</b><br />\r\n<ul><li>spezifische Inhalte einfacher schriftlicher französisch-sprachiger Texte (Stundenplan, Orientierungsschilder in der Schule) mündlich ins Deutsche übertragen<br />\r</li></ul>'),
(155, 5, '<b>Schwerpunktsetzung:</b><br />\r\nKontrastierung der eigenen und fremden Sprache/Kultur zur Förderung von conscience langagière et culturelle; Entdecken von Parallelen und Unterschieden bzgl. der frankophonen Lebenswelt<br />\r\n<br />\r\n<b>Synergien: </b><br />\r\nWorterschließungsstrategien (&lt;&gt; Englisch -&gt; Französisch); elementare Kompensationsstrategien (&lt;&gt;Englisch -&gt; Französisch)<br />\r\nEntlastung: sukzessiver Aufbau der Sprachmittlungskompetenz durch Fokussierung auf mündliche Übertragungen ins Deutsche; Exemplarität eines französischen Schulbetriebs (F -&gt; D)<br />\r\n'),
(156, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\n Entdeckung einer französischen Stadt; Wohnen in Frankreich (Wohnung und Zimmer); Mahlzeiten in Frankreich'),
(156, 3, '<b>Sprechen:</b><br />\r\n zusammenhängendes Sprechen<br />\r\n<ul><li>sein Zuhause und Zimmer vorstellen<br />\r</li><li>Vorlieben und Abneigungen ausdrücken<br />\r</li></ul><b>Sprechen:</b><br />\r\n an Gesprächen teilnehmen<br />\r\n<ul><li>Verabredungen treffen (auch telefonisch)<br />\r</li></ul><b>Leseverstehen:</b><br />\r\n<ul><li>einfachen persönlichen Emails/Briefen wesentliche Informationen entnehmen<br />\r</li><li>diskontinuierlichen Texten (Wohnungsanzeigen, Ankündi-gungstexten) spezifische Informationen entnehmen<br />\r</li></ul>'),
(156, 5, '<b>Schwerpunktsetzung:</b><br />\r\nReproduktives Sprechen<br />\r\n<br />\r\n<b>Synergien:</b><br />\r\nRedegeländer als Memorisierungshilfe Textformate (&lt;&gt;Englisch -&gt; Französisch)<br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\n Fokussierung auf diskontinuierliche Texte mit reduziertem Sprachmaterial (Motivationsförderung durch Leseerfolg); Exemplarität einer französischen Stadt (F-&gt; D)<br />\r\n'),
(157, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nGeburtstag feiern<br />\r\nGesellschaftliches Leben: 14 juillet, Jahreszeiten<br />\r\n'),
(157, 3, '<b>Hör-/Hör-Sehverstehen</b><br />\r\n<ul><li>chansons und kurzen Dialogen wesentliche Informationen entnehmen<br />\r</li></ul><b>Schreiben</b><br />\r\n<ul><li>eine Glückwunschkarte/Einladung zum Geburtstag verfassen<br />\r</li><li>Wünsche mit elementaren Mitteln beschreiben<br />\r</li></ul>'),
(157, 5, '<b>Schwerpunktsetzung:</b><br />\r\nKontrastierung der eigenen Kultur zur Förderung von conscience culturelle; Entdecken von Parallelen und Unterschieden bzgl. der frankophonen Lebenswelt<br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\nsukzessiver Aufbau der Schreibkompetenz durch reproduktives Schreiben nach Modelltexten<br />\r\n'),
(158, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nWege in einer Stadt; sich mit (öffentlichen) Verkehrsmitteln bewegen; <br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\n Sehenswürdigkeiten Avignons; Freizeitangebote Avignons<br />\r\n'),
(158, 3, '<b>Hör-/Hör-Sehverstehen</b><br />\r\n<ul><li>öffentlichen Durchsagen und kurzen Dialogen wesentliche Informationen entnehmen<br />\r</li></ul><b>Sprechen: zusammenhängendes Sprechen</b><br />\r\n<ul><li>eine Stadt vorstellen<br />\r</li></ul><b>Sprechen: an Gesprächen teilnehmen</b><br />\r\n<ul><li>eine Wegbeschreibung tätigen/nach dem Weg fragen<br />\r</li><li>einen Fahrschein kaufen<br />\r</li></ul>'),
(158, 5, '<b>Schwerpunktsetzung:</b><br />\r\n Sprechen und Hören sind komplementäre Fertigkeiten; Fokussierung auf den natürlichen Interaktionsprozess Sprechen &gt;&lt; Hören in typischen Kommunikationssituationen; Motivationsförderung durch Erfahrung des Französischen als Verständigungsmittel zum selbstständigen Bewegen in einer französischen Stadt<br />\r\n<br />\r\nEntlastung:<em></em><br />\r\nSprechen in ritualisierten Kommunikationssituationen; Exemplarität einer weiteren französischen Stadt (F -&gt; D)<br />\r\n'),
(159, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nUrlaubspläne; Urlaub machen<br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\nSehenswürdigkeiten Avignons; Freizeitangebote Avignons<br />\r\n<br />\r\n<b>Regionen/Regionale Besonderheiten:</b> <br />\r\nUrlaubsorte kennenlernen<br />\r\n'),
(159, 3, '<b>Leseverstehen</b><br />\r\n<ul><li>einfachen Urlaubsberichten und -erzählungen wesentliche Informationen entnehmen<br />\r</li></ul><b>Schreiben</b><br />\r\n<ul><li>eine Postkarte / einen kurzen Reisebericht verfassen<br />\r</li></ul><b>Sprachmittlung</b><br />\r\n<ul><li>einfache Informationen zu Sehenswürdigkeiten zusammenfassend mündlich ins Deutsche mitteln<br />\r</li><li>das Französische in typischen touristischen Kommunikationsituationen als Sprache zur Verständigungsvermittlung nutzen<br />\r</li></ul>'),
(159, 5, '<b>Schwerpunktsetzung:</b><br />\r\ndas Französische als Mittel der Verständigungshilfe in zweisprachigen Kommunikationssituationen (F &gt;&lt; D) erfahren (Motivationsförderung); <br />\r\ndas Französische als Sprache zum Aufbau und Pflege deutsch-französischer Beziehungen erfahren (Motivationsförderung)<br />\r\n<br />\r\n<b>Verknüpfung:</b> Vertiefung der Sprachmittlungskompetenz aus &lt;&gt; UV 6.1.4 <br />\r\n'),
(160, 2, '<b>Schule:</b><br />\r\n Schulleben in Frankreich und in Afrika ; Vergleich von schulischen Wirklichkeiten (Deutschland, Frankreich, Afrika: <em>Le Burkina Faso</em>)<br />\r\n<br />\r\n<b>Frankophonie:</b><br />\r\n erste Begegnung mit einem frankophonen Land (<em>Le Burkina Faso</em>)<br />\r\n'),
(160, 3, '<b>Leseverstehen</b><br />\r\n- Verstehen von Hauptaussagen<br />\r\n- Auffinden von spezifischen Informationen <br />\r\n<br />\r\n<b>Schreiben</b><br />\r\n- gelenktes Verfassen von Beschreibungen<br />\r\n- einen persönlichen Brief/email verfassen<br />\r\n'),
(160, 5, '<b>Schwerpunktsetzung:</b><br />\r\n vgl. &lt;&gt; UV 6.1.2; Sensibilisierung für Werte, Haltungen, Einstellungen im Rahmen eines interkulturellen Korrespondenzprojekts; Orientierung am natürlichen Spracherwerb &amp;<em>8211; Prinzip &amp;</em>8222;Vom Lesen zum Schreiben&amp;#8220;; Förderung der Lese- und Schreibkompetenz in authentischen Kommunikationssituationen (Motivationsförderung)<br />\r\n<br />\r\n<b>Verknüpfung:</b><br />\r\nReaktivierung des themengebundenen Wortschatzes &lt;&gt; UV 6.1.4; <br />\r\n<br />\r\n<b>Synergien:</b><br />\r\n einfache Kompensationsstrategien: Verstehen von Texten trotz unbekannten Vokabulars (&lt;&gt; Englisch -&gt; Französisch)<br />\r\nFächerverbindender Unterricht: Erdkunde<br />\r\n'),
(161, 2, '<b>Persönliche Lebensgestaltung:</b> Freizeitgestaltung; persönliche Interessen<br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\nPersönlichkeiten des öffentlichen Lebens, migrationsbedingte Vielfalt<br />\r\n<br />\r\n<b>Frankophonie:</b><br />\r\n Kennenlernen weiterer frankophoner Länder<br />\r\n'),
(161, 3, '<b>Leseverstehen</b><br />\r\nVerstehen wesentlicher Details<br />\r\n<br />\r\n<b>Sprechen:</b><br />\r\nzusammenhängendes Sprechen<br />\r\n<ul><li>sich und andere vorstellen<br />\r</li><li>über Vorlieben und Abneigungen berichten<br />\r</li></ul><br />\r\n<b>Schreiben:</b><br />\r\nMeinungen, Hoffnungen und Einstellungen formulieren<br />\r\n'),
(161, 5, '<b>Schwerpunktsetzung:</b><br />\r\nVertiefung und Erweiterung der Schwerpunktkompetenzen aus &lt;&gt; UV 7.1.1; Sensibilisierung für Werte, Haltungen, Einstellungen mit dem Fokus &quot;Anderssein&quot; als Bereicherung <br />\r\n<br />\r\n<b>Verknüpfung:</b><br />\r\nReaktivierung und Erweiterung des themengebundenen Wortschatzes aus &lt;&gt; UV 6.1.2<br />\r\n<br />\r\n<b>Synergien:</b><br />\r\nPräsentationsstrategien (&lt;&gt;Deutsch/Englisch -&gt; Französisch)<br />\r\n'),
(162, 2, '<b>Regionen:</b><br />\r\nEinblick in ausgewählte Regionen Frankreichs; <em>chefs-lieux des régions</em><br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\nRegionalspezifische Lebensarten; exemplarische Begegnung mit Institutionen und Persönlichkeiten des öffentlichen Lebens <br />\r\n<br />\r\n'),
(162, 3, '<b>Hör-/Hör-Sehverstehen</b><br />\r\nkurzen Hör-/Hörsehtexten aus Rundfunk und Dokumentarsendungen aufgabengeleitet Informationen entnehmen <br />\r\n<br />\r\n<b>Sprachmittlung</b><br />\r\nwesentliche Aussagen aus dem Französischen mündlich und schriftlich ins Deutsche übertragen<br />\r\n');
INSERT INTO `part_t520_ein_r_uv_textfelder` (`uv_id`, `textfeld_id`, `uv_text`) VALUES
(162, 5, '<b>Schwerpunktsetzung:</b><br />\r\ndas Französische als Mittel der Verständigungshilfe in zweisprachigen Kommunikationssituationen (F&lt;&gt;D) erfahren (vgl. UV &lt;&gt; 6.2.4)<br />\r\n<br />\r\n<b>Synergien:</b> <br />\r\nBeschreibungen als Kompensationshilfe produktiv nutzen; visuelle Mittel als Verständnisstütze heranziehen (&lt;&gt; Englisch -&gt; Französisch)<br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\nExemplarität statt Vollständigkeit; sukzessiver Aufbau der Sprachmittlungskompetenz durch Fokussierung auf eine Kommunikationsrichtung (F -&gt; D); alternative Form der Leistungsüberprüfung<br />\r\nFächerverbindender Unterricht: Erdkunde/Politik<br />\r\n'),
(163, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nFamilienleben, Feste feiern<br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\nEsskultur in Frankreich; Feste feiern (<em>Épihanie, &quot;la fête&quot; </em>); Essen und Traditionen (<em>la galette du roi</em>)<br />\r\n'),
(163, 3, '<b>Hör-/Hör-Sehverstehen</b><br />\r\n<ul><li>Anweisungen verstehen und befolgen<br />\r</li><li>Ansagen und Mitteilungen spezifische Details entnehmen <br />\r</li></ul><br />\r\n<b>Sprechen: an Gesprächen teilnehmen</b><br />\r\n<ul><li>Tischgespräche führen<br />\r</li><li>Einkaufsgespräche führen<br />\r</li></ul><br />\r\n<b>Sprechen: zusammenhängendes Sprechen</b><br />\r\nkurze Texte sinngestaltend vortragen<br />\r\n'),
(163, 5, '<b>Schwerpunktsetzung:</b><br />\r\nFokussierung auf den Vergleich deutsch-französischer Feste und Tradition zur Förderung einer conscience culturelle (vgl. &lt;&gt; UV 6.2.3);  Intonation/Aussprache als Gestaltungs- und Mitteilungsinstrument in verbundener Rede erfahren<br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\nFokussierte Kompetenzentwicklung des zusammenhängenden Sprechens durch Konzentration auf das sinngestaltende Vortragen von Texten; Intonation/Aussprache als Gestaltungs- und Mitteilungsinstrument in verbundener Rede erfahren; alternative Form der Leistungsüberprüfung<br />\r\nVerknüpfung: Vertiefung des HSV aus &lt;&gt; UV 7.1.3; Reaktivierung des themengebundenen Wortschatzes &lt;&gt; UV 6.2.1; Vorwissen zur Esskultur in Frankreich aktivieren; &lt;&gt; Feste/Traditionen in anglophonen und weiteren Kulturräumen (GB/USA + Herkunftsländer von SuS)<br />\r\n<br />\r\n<b>Fächerverbindender Unterricht:</b> Kunst oder Praktische Philosophie/Religion<br />\r\n'),
(164, 2, '<b>Gesellschaftliches Leben:</b><br />\r\n Soziale Verantwortung und Engagement; Umweltschutz und Tierschutz'),
(164, 3, '<b>Sprechen: zusammenhängendes Sprechen</b><br />\r\n<ul><li>Beschreibungen tätigen<br />\r</li><li>seine Meinung äußern und ansatzweise begründen<br />\r</li></ul><b>Sprachmittlung</b><br />\r\n<ul><li>wesentliche Informationen aus deutschen Informationsmaterialien mündlich ins Französische übertragen<br />\r</li><li>in die jeweils andere Sprache Kernaussagen von schriftlichen Texten sinngemäß mündlich übertragen<br />\r</li></ul>'),
(164, 5, '<b>Schwerpunktsetzung:</b><br />\r\nVertiefung und Erweiterung der Schwerpunktkompetenz aus &lt;&gt; UV7.2.1 zur Vorbereitung auf die mündliche Prüfung; <br />\r\n<br />\r\n<b>#Entlastung:</b><br />\r\nFokussierung auf monologische Kommunikationssituationen; Fokussierung der Kompetenzentwicklung Sprachmittlung in mündlichen Kommunikationssituationen<br />\r\n<br />\r\n<b>Fächerverbindender Unterricht:</b><br />\r\nSOS  &amp;#8211; fächerverbindende Projektphase (Englisch/Französisch) zur Förderung von Mehrsprachigkeit<br />\r\n'),
(165, 2, '<b>Gesellschaftliches Leben:</b><br />\r\nKommunikationsmittel und -formen  (<em>les médias</em>), <br />\r\nUnterhaltungskultur (<em>Au pays des livres ; Francomusique</em>) ; <br />\r\nPersönlichkeiten des öffentlichen Lebens (<em>écrivains, chanteurs/chanteuses, groupes de musique, acteurs /actrices</em>)'),
(165, 3, '<b>Leseverstehen</b><br />\r\n<ul><li>kurzen Artikeln und Blogeinträgen wichtige Aussagen und wesentliche Details entnehmen<br />\r</li><li>kurzen Geschichten und szenischen Texten die Hauptaussagen entnehmen<br />\r</li></ul><br />\r\n<b>Sprechen: zusammenhängendes Sprechen</b><br />\r\nBücher, Lieder, Filme, Künstler vorstellen<br />\r\n<br />\r\n<b>Hör-/Hör-Sehverstehen</b><br />\r\nLiedern, Filmausschnitten und Dokumentationen aufgabengeleitet die Hauptaussagen entnehmen<br />\r\n'),
(165, 5, '<b>Schwerpunktsetzung:</b><br />\r\nVertiefung der Schwerpunktkompetenzen durch Erweiterung zu den diesbezüglichen vorherigen Unterrichtsvorhaben &lt;&gt; UV 7.1.2 &amp;#8211; 7.2.2<br />\r\n<br />\r\n<b>Fächerverbindender Unterricht:</b><br />\r\n Politik<br />\r\n'),
(166, 2, '<b>Gesellschaftliches Leben:</b><br />\r\nAlltag in Paris, Verkehrsmittel <em>(métro, Vélib`)</em><br />\r\n<br />\r\n<b>Regionen/regionale Besonderheiten:</b><br />\r\nEntstehungsgeschichte von Paris anhand ausgewählter Bauwerke; Pariser Sehenswürdigkeiten; Gliederung Frankreichs<br />\r\n'),
(166, 3, '<b>Leseverstehen</b><br />\r\nSachtexten wichtige Aussagen und wesentliche Details entnehmen <br />\r\n<br />\r\n<b>Schreiben</b><br />\r\n<ul><li>einfache, kurze Texte über Sachverhalte und Ereignisse verfassen<br />\r</li><li>wichtige Informationen aus Texten schriftlich wiedergeben<br />\r</li></ul>'),
(166, 5, '<b>Schwerpunktsetzung:</b><br />\r\nFokussierung auf den grammatikalischen Schwerpunkt: Bildung des imparfait und dessen kontrastiver Gebrauch zum <em>passé composé</em> <br />\r\n<br />\r\n<b>Entlastung:</b> Exemplarität ausgewählter Sehenswürdigkeiten<br />\r\n<br />\r\n<b>Synergien:</b><br />\r\nVergleich/Unterschied der französischen Vergangenheitstempora mit dem <em>present perfect</em> und <em>simple past</em> (&lt;&gt;Englisch -&gt; Französisch)<br />\r\n<br />\r\n<b>Fächerverbindender Unterricht:</b><br />\r\nGeschichte<br />\r\n'),
(167, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nFamilienleben in Frankreich <em>(quotidien, traditions)</em>; Freundschaften pflegen; sich gegen Diskriminierung einsetzen; Möglichkeiten des sozialen Engagements<br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\nInstitutionen für soziales Engagement <em>(Emmaüs, Restos du Coeur, Médecins sans frontières)</em> <br />\r\n'),
(167, 3, '<b>Sprechen:</b><br />\r\nan Gesprächen teilnehmen<br />\r\n<ul><li>einfache alltägliche Kommunikationssituationen sprachlich bewältigen<br />\r</li><li>sich an Gesprächen beteiligen, in denen es um Alltagsthemen geht<br />\r</li><li>in Diskussionen den eigenen Standpunkt deutlich machen<br />\r</li></ul><br />\r\n<b>Leseverstehen</b><br />\r\n<ul><li>Informationsmaterialien (digital/Print) wesentliche Details entnehmen<br />\r</li><li>unter Anleitung kurze, themengebundene, adaptierte fiktionale Texte verstehen<br />\r</li></ul>'),
(167, 5, '<b>Schwerpunktsetzung:</b><br />\r\nSensibilisierung für Werte, Haltungen, Einstellungen: Multikulturalität als gesellschaftliche und persönliche Bereicherung <br />\r\n<br />\r\n<b>Synergien:</b><br />\r\nKommunikationsstrategien (&lt;&gt;Englisch -&gt; Französisch); Lesestrategien<br />\r\n(&lt;&gt;Englisch -&gt; Französisch)<br />\r\n'),
(168, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nsoziale Netzwerke und virtuelle Freundschaften; Mediengewohnheiten von deutschen und französischen Jugendlichen im Vergleich<br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\nFranzösische Medien <em>(la presse, Internet, chaînes de télévision)</em>; Gefahren und Risiken der Datenautobahn<br />\r\n'),
(168, 3, '<b>Sprachmittlung</b><br />\r\nKernaussagen mündlicher wie schriftlicher Texte in der jeweils anderen Sprache sinngemäß wiedergeben<br />\r\n<br />\r\n<b>Sprechen:</b><br />\r\nan Gesprächen teilnehmen<br />\r\n<ul><li>sich in Diskussionen einbringen<br />\r</li><li>seine Meinung äußern und begründen<br />\r</li></ul>'),
(168, 4, '<b>Verknüpfung:</b><br />\r\nReaktivierung und Erweiterung des themengebundenen Wortschatzes &lt;&gt; UV 7.2.3; Erweiterung des Wortschatzes aus &lt;&gt; UV 8.1.2; Reaktivierung und Erweiterung des Wortschatzes zur Meinungsäußerung &lt;&gt; UV 7.2.2<br />\r\n<br />\r\n<b>Fächerverbindender Unterricht:</b> Politik/Informatik/Praktische Philosophie; Kooperation mit Medienscouts<br />\r\n'),
(169, 2, '<b>Gesellschaftliches Leben:</b> <br />\r\nKulturelle Unterschiede Frankreich-Deutschland<br />\r\n<br />\r\n<b>Schule:</b> Alltag in einem französischen Lernbetrieb; Schüleraustausch planen<br />\r\n<br />\r\n<b>Regionen:</b> Besonderheiten einer Region Frankreichs <em>(Nord-Pas de Calais)</em><br />\r\n'),
(169, 3, '<b>Sprechen: zusammenhängendes Sprechen</b><br />\r\n<ul><li>über seinen persönlichen Alltag berichten<br />\r</li><li>die eigene Stadt vorstellen<br />\r</li><li>seine persönliche Meinung und Vorschläge in eine Diskussion einbringen<br />\r</li></ul><br />\r\n<b>Sprechen: an Gesprächen teilnehmen</b><br />\r\n<ul><li>alltägliche Begegnungssituationen mit französischen Jugendlichen simulieren und bewältigen<br />\r</li><li>über die Gestaltung eines Austauschprogramms diskutieren<br />\r</li></ul><br />\r\n<b>Schreiben:</b><br />\r\n<ul><li>persönliche Briefe/Emails an französische SuS verfassen<br />\r</li></ul>'),
(169, 5, '<b>Schwerpunktsetzung:</b><br />\r\nSprechen und Schreiben als interkulturelle Mitteilungsinstrumente; Vorbereitung auf den Austausch mit der französischen Partnerschule<br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\nExemplarität (bei der Auswahl der Region) statt Vollständigkeit -&gt; <em>Nord Pas de Calais</em><br />\r\n<br />\r\n<b>Verknüpfung:</b><br />\r\nfrz. Briefkonventionen &lt;&gt; Klasse UV 7.1.1 und Briefkonventionen im Vergleich (&lt;&gt; Englisch/Deutsch -&gt; Französisch); Reaktivierung und Erweiterung des themengebundenen Wortschatzes &lt;&gt; UV  7.1.1; Umgang mit französischen Internetplattformen &lt;&gt; UV 8.1.3'),
(170, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nMigration als persönliches Schicksal<br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b> <br />\r\nMultikulturalität als Bereicherung; Einheit in Vielfalt<br />\r\n<br />\r\n<b>Frankophonie:</b> <br />\r\ndie Besonderheiten eines oder mehrerer französischsprachiger Länder <em>(Canada : Montréal)</em><br />\r\n'),
(170, 3, '<b>Leseverstehen</b><br />\r\n<ul><li>Sach- und Gebrauchstexten (Broschüren, Prospekten) und digitalen Informationstexten <em>(informations touristiques, guide touristique)</em> wichtige Aussagen entnehmen<br />\r</li><li>kurze, adaptierte Erzähltexte der Bezugskultur verstehen<br />\r</li><li>verschriftlichte Ergebnissicherungen verstehen<br />\r</li></ul><br />\r\n<b>Schreiben</b><br />\r\n<ul><li>wichtige Informationen aus Texten widergeben <br />\r</li><li>zusammenhängend kurz persönliche Reflexionen, Erfahrungen und Ereignisse, Meinungen und Einstellungen darlegen<br />\r</li><li>einfache, kurze Geschichten verfassen und fortschreiben<br />\r</li></ul>'),
(170, 5, '<b>Schwerpunktsetzung:</b> <br />\r\nFranzösisch als Weltsprache; Selbst- und Fremdwahrnehmung in Bezug zur Herkunft; Interesse an frankophonen Ländern außerhalb Europas wecken<br />\r\n<br />\r\n<b>Entlastung:</b> <br />\r\nländerspezifische Schwerpunktsetzung -&gt; <em>Canada : Montréal</em><br />\r\nVerknüpfung Frankophonie &lt;&gt; UV 7.1.1/7.1.2<br />\r\n<br />\r\n<b>Synergien:</b> <br />\r\nFehlervermeidungsstrategien &lt;&gt; UV 7.1.2, &lt;&gt; UV 8.1.1; <em>rédaction de texte</em> (&lt;&gt; Englisch -&gt; Französisch); &lt;&gt; <em> English as a lingua franca</em> (&lt;&gt; Englisch -&gt; Französisch)<br />\r\n<br />\r\n<em>Fächerverbindender Unterricht:</em><br />\r\nErdkunde/Geschichte<br />\r\n'),
(171, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nReisen<br />\r\n<br />\r\n<b>Schule:</b><br />\r\nschulischer Auslandsaufenthalt; Austauschprogramme<br />\r\n<br />\r\n<b>Frankophonie:</b><br />\r\nLeben in einem franko-phonen Land <em>(Canada)</em><br />\r\n'),
(171, 3, '<b>Leseverstehen</b><br />\r\n<ul><li>Sach- und Gebrauchstexte erfassen und ihnen gezielt Informationen entnehmen<br />\r</li><li>Auffinden von spezifischen Informationen<br />\r</li></ul><br />\r\n<b>Schreiben</b><br />\r\n<ul><li>formalisierte Gebrauchstexte (Lebenslauf, Bewerbung) formulieren und gestalten<br />\r</li><li>in persönlichen Texten Meinungen, Hoffnungen und Einstellungen darlegen<br />\r</li></ul>'),
(171, 5, '<b>Schwerpunktsetzung:</b><br />\r\nVerwendung des Französischen in beruflichen Kontexten<br />\r\n<br />\r\n<b>Verknüpfung:</b><br />\r\nReaktivierung des Repertoires zum Ausdruck von zukünftigen Handlungen (<em>futur simple</em> &lt;&gt; UV 8.1.2/8.1.3)<br />\r\n<br />\r\n<b>Synergien:</b><br />\r\nKontextwissen als Lesestrategie (&lt;&gt; Deutsch/Englisch -&gt; Französisch)<br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\nalternative Form der Leistungsüberprüfung <br />\r\n<br />\r\n<b>fächerverbindender Unterricht:</b><br />\r\nDeutsch/Englisch <br />\r\n'),
(172, 2, '<b>Gesellschaftliches Leben:</b><br />\r\nEinblicke in das kulturelle Leben und soziale Leben in Frankreich <em>(« Franco-musiques », Festival International de la BD, festival de film, festival de théâtre)</em> <br />\r\n<br />\r\n<b>Regionale Besonderheiten:</b><br />\r\nAngoulême, Cannes<br />\r\n'),
(172, 3, '<b>Hör-/Hör-Sehverstehen:</b><br />\r\n<ul><li>themenbezogenen und klar strukturierten, einfachen authentische Hör-/Hörsehtexte verstehen<br />\r</li><li>authentischen Texten (Reportage, Bericht, Interview) Hauptaussagen und Einzelinformationen entnehmen<br />\r</li></ul><br />\r\n<b>Sprechen:</b><br />\r\nzusammenhängendes Sprechen<br />\r\n<ul><li>von alltäglichen Erlebnissen und Erfahrungen, Vorhaben und Wünschen erzählen und berichten<br />\r</li><li>wesentliche Aussagen/Inhalte von Texten zusammenfassen<br />\r</li></ul><br />\r\n<b>Sprechen: an Gesprächen teilnehmen</b><br />\r\n- sich über Musik, Film, Theater, Kultur sachbezogen unterhalten<br />\r\n- Meinungen äußern und begründen<br />\r\n'),
(172, 5, '<b>Schwerpunktsetzung:</b><br />\r\nAussprache- und Intonationsmuster in Vortrag und freier Rede einsetzen<br />\r\n<br />\r\n<b>Verknüpfung:</b><br />\r\nReaktivierung und Erweiterung des themengebundenen Wortschatzes &lt;&gt; UV 7.2.3<br />\r\n<br />\r\n<b>#Synergien:</b><br />\r\nunterschiedliche Verarbeitungsstile des aktiven Hörens/Hör-Sehens (u.a. global, selektiv, detailliert) einsetzen (&lt;&gt; Deutsch/Englisch -&gt; Französisch); Förderung des selbstständigen und kooperativen Arbeitens <br />\r\n<br />\r\n<b>Fächerverbindender Unterricht:</b> <br />\r\nMusik<br />\r\n'),
(173, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nLesen als Hobby, persönliche Vorlieben und Abneigungen<br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\nfrankophone Jugendliteratur zu jugendspezifischen Themen; Kennenlernen von bedeutsamen Persönlichkeiten der Zielkultur<br />\r\n'),
(173, 3, '<b>Leseverstehen</b><br />\r\n<ul><li>längere fiktionale Texte verstehen<br />\r</li></ul><br />\r\n<b>Schreiben</b><br />\r\n<ul><li>wesentliche Inhalte fiktionaler Texte zusammenfassen und Angaben zur Form der Darstellung machen<br />\r</li><li>verschiedene Formen des kreativen Schreibens einsetzen<br />\r</li></ul>'),
(173, 5, '<b>Schwerpunktsetzung:</b><br />\r\nFörderung der Lesekompetenz; eine Ganzschrift lesen<br />\r\n<br />\r\n<b>Synergien:</b><br />\r\nLeseverstehensstrategien / Wortentschlüsselungsstrategien(&lt;&gt; Englisch -&gt; Französisch); produktionsorientierte und kreative Arbeitstechniken im Umgang mit Texten (&lt;&gt; Englisch/Deutsch -&gt; Französisch)<br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\nExemplarität statt Vollständigkeit im Rahmen des extensiven Lesens; alternative Form der Leistungsüberprüfung<br />\r\n'),
(174, 2, '<b>Persönliche Lebensgestaltung:</b><br />\r\nReisen, Urlaubsaktivitäten<br />\r\n<br />\r\n<b>Gesellschaftliches Leben:</b><br />\r\nfrankophone Vielfalt <br />\r\n<br />\r\n<b>Frankophonie:</b><br />\r\nfrankophone Vielfalt außerhalb Europas, <em>la Réunion</em>, Geographie <em>(les départements d`outre-mer)</em> <br />\r\n'),
(174, 3, '<b>Hör-/Hör-Sehverstehen:</b><br />\r\n<ul><li>Sach- und Gebrauchstexte verstehen und ihnen Hauptaussagen und Einzelinformationen entnehmen<br />\r</li></ul><br />\r\n<b>Sprechen: zusammenhängendes Sprechen</b><br />\r\nErgebnisse individueller und kooperativer Arbeitsprozesse sachlich angemessen präsentieren<br />\r\n<br />\r\n<b>Sprachmittlung:</b><br />\r\n<ul><li>wesentliche Aussagen und Details von Äußerungen und schriftlichen Dokumenten in der jeweils anderen Sprache zusammenfassend wiedergeben und ggf. notwendige Erläuterungen hinzufügen<br />\r</li></ul><br />\r\n<b>Interkulturelle Kompetenz:</b><br />\r\nkulturspezifische Konventionen in Begegnungssituationen erkennen und beim eigenen Handeln beachten<br />\r\n'),
(174, 5, '<b>Schwerpunktsetzung:</b><br />\r\nEinblicke in die soziale und kulturelle Wirklichkeit eines <em>département d`outre-mer</em><br />\r\n<br />\r\n<b>Entlastung:</b><br />\r\nExemplarität des <em>DOM la Réunion</em> für die frankophone Vielfalt in Übersee<br />\r\n<br />\r\n<b>Verknüpfung:</b><br />\r\nVertiefung der Schwerpunktkompetenzen durch Erweiterung zu den &lt;&gt; UV 9.1.1-2; Frankophonie (&lt;&gt; UV  7.1.1; &lt;&gt; UV 8.2.2, &lt;&gt; UV 9.1.1); Reaktivierung und Erweiterung des themengebundenen Wortschatzes &quot;Reisen&quot; (&lt;&gt; UV 9.1.1);)<br />\r\n<br />\r\n<b>Synergien:</b> <br />\r\nErweiterung des Inventars von Strategien, Methoden sowie Lern- und Arbeitstechniken (&lt;&gt; Englisch/Deutsch -&gt; Französisch); Präsentationsstrategien (&lt;&gt; Englisch/Deutsch -&gt; Französisch)<br />\r\n');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `part_t540_ein_wochenstunden`
--

DROP TABLE IF EXISTS `part_t540_ein_wochenstunden`;
CREATE TABLE `part_t540_ein_wochenstunden` (
  `schulform_id` int(10) NOT NULL COMMENT 'Schulform-ID, Teilprimärschlüssel, FK',
  `fach_id` int(10) NOT NULL COMMENT 'Fach-ID, Teilprimärschlüssel, FK',
  `stufe_id` int(10) NOT NULL COMMENT 'Stufen-ID, Teilprimärschlüssel, FK',
  `kursart_id` int(10) NOT NULL COMMENT 'ID für Kursart, Teilprimärschlüssel, FK, 0 wenn keine Kursart',
  `zug_id` int(10) NOT NULL COMMENT 'Zug-ID (Klasse, Lerngruppe), Teilprimärschlüssel, FK, 0 wenn kein Zug',
  `wochenstunden` int(5) DEFAULT NULL COMMENT 'Wochenstundenzahl',
  `aenderung_zeitstempel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Zeitstempel der letzten Änderung'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Eingabetabelle mit Wochenstundenzahlen';

--
-- Daten für Tabelle `part_t540_ein_wochenstunden`
--

INSERT INTO `part_t540_ein_wochenstunden` (`schulform_id`, `fach_id`, `stufe_id`, `kursart_id`, `zug_id`, `wochenstunden`, `aenderung_zeitstempel`) VALUES
(2, 7, 1, 0, 0, 2, '2016-01-23 14:47:44'),
(2, 7, 2, 0, 0, 2, '2016-01-23 19:44:05'),
(2, 9, 1, 0, 0, 2, '2016-01-23 23:21:48'),
(2, 10, 1, 0, 0, 2, '2016-01-23 23:22:18'),
(2, 11, 1, 0, 0, 3, '2016-01-25 13:53:59'),
(2, 10, 4, 0, 0, 2, '2016-01-25 14:08:18'),
(2, 10, 6, 0, 0, 2, '2016-01-25 15:05:04'),
(2, 7, 4, 0, 0, 2, '2016-01-25 15:55:21'),
(2, 7, 5, 0, 0, 2, '2016-01-25 15:55:27'),
(2, 9, 3, 0, 0, 2, '2016-01-25 16:10:47'),
(2, 9, 5, 0, 0, 2, '2016-01-25 16:10:53'),
(2, 9, 6, 0, 0, 2, '2016-01-25 16:16:54'),
(2, 3, 5, 1, 0, 3, '2016-05-17 19:09:51'),
(2, 3, 1, 0, 1, 5, '2016-05-24 05:48:22'),
(4, 13, 2, 0, 0, 3, '2016-06-24 09:08:15'),
(2, 3, 1, 0, 0, 5, '2016-05-24 06:06:17'),
(4, 3, 0, 0, 0, 5, '2016-06-08 04:59:40'),
(4, 13, 3, 0, 0, 3, '2016-06-24 09:29:18'),
(4, 13, 4, 0, 0, 3, '2016-06-24 09:51:36'),
(4, 13, 5, 0, 0, 3, '2016-06-24 09:51:40'),
(4, 3, 1, 0, 0, 116, '2016-07-01 14:12:45'),
(4, 3, 2, 0, 0, 116, '2016-07-01 14:23:08'),
(4, 3, 3, 0, 0, 122, '2016-07-01 14:34:11'),
(4, 3, 4, 0, 0, 112, '2016-07-01 14:42:49'),
(4, 3, 5, 0, 0, 93, '2016-07-01 14:55:56');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `part_t100_sys_dmversion`
--
ALTER TABLE `part_t100_sys_dmversion`
  ADD PRIMARY KEY (`dmversionsnr`);

--
-- Indizes für die Tabelle `part_t150_sys_user`
--
ALTER TABLE `part_t150_sys_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uk_t150_anmeldename` (`anmeldename`),
  ADD KEY `fk_t150_sys_user_fach_id` (`fach_id`);

--
-- Indizes für die Tabelle `part_t160_sys_sperren`
--
ALTER TABLE `part_t160_sys_sperren`
  ADD PRIMARY KEY (`fach_id`);

--
-- Indizes für die Tabelle `part_t170_sys_aender_session_uv`
--
ALTER TABLE `part_t170_sys_aender_session_uv`
  ADD PRIMARY KEY (`user_id`,`uv_id`);

--
-- Indizes für die Tabelle `part_t210_kfg_uv_textfelder`
--
ALTER TABLE `part_t210_kfg_uv_textfelder`
  ADD PRIMARY KEY (`textfeld_id`),
  ADD UNIQUE KEY `uk_t210_textfeld` (`textfeld`);

--
-- Indizes für die Tabelle `part_t310_kat_schulform`
--
ALTER TABLE `part_t310_kat_schulform`
  ADD PRIMARY KEY (`schulform_id`),
  ADD UNIQUE KEY `uk_t310_schulformkuerzel` (`schulformkuerzel`);

--
-- Indizes für die Tabelle `part_t320_kat_fach`
--
ALTER TABLE `part_t320_kat_fach`
  ADD PRIMARY KEY (`fach_id`),
  ADD UNIQUE KEY `uk_t320_fachkuerzel` (`fachkuerzel`);

--
-- Indizes für die Tabelle `part_t330_kat_stufe`
--
ALTER TABLE `part_t330_kat_stufe`
  ADD PRIMARY KEY (`stufe_id`),
  ADD UNIQUE KEY `uk_t330_stufe` (`stufe`);

--
-- Indizes für die Tabelle `part_t340_kat_zug`
--
ALTER TABLE `part_t340_kat_zug`
  ADD PRIMARY KEY (`zug_id`),
  ADD UNIQUE KEY `uk_t340_stufe` (`zug`);

--
-- Indizes für die Tabelle `part_t350_kat_kursart`
--
ALTER TABLE `part_t350_kat_kursart`
  ADD PRIMARY KEY (`kursart_id`),
  ADD UNIQUE KEY `uk_t350_kursart` (`kursart`);

--
-- Indizes für die Tabelle `part_t510_ein_unterrichtsvorhaben`
--
ALTER TABLE `part_t510_ein_unterrichtsvorhaben`
  ADD PRIMARY KEY (`uv_id`),
  ADD KEY `fk_t510_schulform` (`schulform_id`),
  ADD KEY `fk_t510_fach` (`fach_id`),
  ADD KEY `fk_t510_stufe` (`stufe_id`),
  ADD KEY `fk_t510_kursart` (`kursart_id`),
  ADD KEY `fk_t510_zug` (`zug_id`);

--
-- Indizes für die Tabelle `part_t520_ein_r_uv_textfelder`
--
ALTER TABLE `part_t520_ein_r_uv_textfelder`
  ADD PRIMARY KEY (`uv_id`,`textfeld_id`),
  ADD KEY `fk_t520_textfeld` (`textfeld_id`);

--
-- Indizes für die Tabelle `part_t540_ein_wochenstunden`
--
ALTER TABLE `part_t540_ein_wochenstunden`
  ADD PRIMARY KEY (`schulform_id`,`fach_id`,`stufe_id`,`kursart_id`,`zug_id`),
  ADD KEY `fk_t540_fach` (`fach_id`),
  ADD KEY `fk_t540_stufe` (`stufe_id`),
  ADD KEY `fk_t540_kursart` (`kursart_id`),
  ADD KEY `fk_t540_zug` (`zug_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
