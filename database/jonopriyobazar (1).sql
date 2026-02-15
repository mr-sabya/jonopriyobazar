-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 12, 2026 at 05:57 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jonopriyobazar`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-avatar_6e70b33f81e7d96e52f3738403310d8b', 's:2170:\"data:image/png;base64,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\";', 1768066290),
('laravel-cache-avatar_d9a978dde3c82bf05e7782e6b8ef7f28', 's:3298:\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAJSUlEQVR4nO2de1BU1x3Hv3fZXdgHC8hLXgJiERAIGMXEiFibqGMTmXTScYzTSVvaGZO/2k7T1zim7Ti06aRt/qBJa2rTl5ZpEzMmhinVmjRANbYR5KGLgBAEeS8s7pPdZfuHXWZd7929e/ecuxe4nxn+OnfvOfv73N8595xz78J4vV7ISAdltBsQLieLzoZ9BdUZaxkabaEBI+UMERJ8vkhVkqSE0BQQCqkIkoSQaIoIJNpioiZEShK4iIYc0YUsBxGBiClGIVZFwPKUAYjbblEyZLmKYIN2tlAVspJEBEJLDBUhK1lEIKTFiDqGyISGaIaspswIhFSmEMuQ1SwDIPf9iQhZ7TJ8kIhDxEJkGfcTaTwiEiLLYCeSuAgWIssIjtD4CBIiy+CHkDiFLUSWER7hxkueGEoM3hNDOTMih8/kUc4QicFLiJwdZOATRzlDJEZIIXJ2kCVUPOUMkRhBhcjZQYdgceUUIsugC1d85S5LYrAKkbNDHNjiLGeIxJCFSIwH1rKod1cMkFOTjrVbk5FangR9hhZqgwoqbQxcNg8W5l2wjtsxYzRjumsOo22TsE87eZ16+0vlKD6UH/I476IXbrsHCxYX3DYPLGM2zN68C1OvGSMt/Osjhf8al2gv7DAxDMrqNqDkcD506RrWY2INCsQaVIjP1mLtlmQA94I33TOHweY76DszDIdpIfK2KBiodEqodPe+fkK+Hlnb05bqG/t4GtdP3cKnF8YjrivstvlnCK3sMOTp8LlXt2JNUUJE51l0L+LG6UFcru9mLeebIXwZaZ1Eyw/aYZt0EDsnF74soT6GxGdrsf8Pj0UsAwAUSgWs4/SD4yN7Rxo+f2oHtOlxotVJVwgDPN5QxdlFhYvb6cHNtz8lci6+GHJ02PubRwCRXkigKqT4UB6RzPBx6/1ROM0uYufjy5qiBBQdzBOlrqVBncb48Zmn1wUtNw9a0POnAZgHrXDMOqHWq6DL1CClJBGZj6Q8IPPG6UHBbTHdnEfTl1oBAAqVAsq4mKW68vZkIH1zctDPlz5XAGPjkOD6Q3Gy6Ky3zljLULvLilujRmpZEmf54N9HcfGb/wVYLoOBd0cAALoMDQqeykbh0+vgvOvCdPec4PZ4Pd4HsuvuiA3jV2bQ/fsB5O3NRM3PNkMZG8P6+YR8PQzrdJgftgpuAx+oCYnP0XGWeRe9uHS8i1WGP9YxOzpP9KHzRB9iE1SEW3g/Q813YMjVYeu3SjiPSa1Ioi6E2hiiSY7lLFuwuMOefIkxdvSdGQ5ark2hf7dFTYjb7uEsU+uV1K94IdinnXDb3ZzlcUlq6m1QAHQGdOuEnbOMUTDY+uIm0lUSgYnhvkbdTu6LjAQni856qWWIedAC2xT3JG7jM7nY/eoWxIpw1fElPluLGDV3SKxj3BcZKejNQ7zAwLmRoIfk78vCwQtP4OFvFEuiCws115jsmKXeBqoTw843+uAwBR+8VTolKo4U4uDFPdj2vVJRlyn8KTiQjdKvFHCWm4xmzA3cpd4Oqqu9DtMCWo524PGGKjCK4GsPKp0SpV8uQPGz+eh7Zxjtr/XCNkFp3YoBVFol9JkapJYnYcOBHGRsSwn6kfbXb9JpS2DTvF4v9T2QDbU52PmTypBS/PEsLKLrd/3oeK0XnoVFXp8hvdrrY/iDcZx//mPi52VDlB3D/rO30fz1S0EH+UBi1ApUHCnEF97fjeQScuth4WIymvHhtz8RrT7RtnBH26bw1r5/ouvN/rBuHw05Ojz5l2rkPpFBsXXsjLRO4tzhVris3HMT0oi6p+6yunHl5R78bc8F9PxxIOgkzB9lbAx2/3IL1lYFXwAkhW3KgdZjHWj+2iVRZQBResjBNuHA5fpuNO76B642GOGcD70solAqUPPTzUHnCaT494870ftXcfddfET1qROn2YX2hl407mrG1QZjyIzRZ2pRUJtDvV2PHi2DOj46vw8qiceA3DYP2ht68faTFzHVFXzylb83U1AdJqMZb5a9u/T3521NsNyxsR6rS9fgsR9VCKonUiQhxIdl1I6m59ow2z/PeUxKaaKgc3u9wKLLu/TnNLvQ9tI1zuPX78/C+v1ZguqKBAUQ/R9+9Mdt86DzjX7O8liDitj+9kjLJPrf417eefRYObRp4q0c1BlrGUlliA/LKHtXAtzb3Aq1sRUOl493ci7vxCWqUV1fSa4yHlATUl1fibKvbhC0aLhmo4GzzD5D9qlCp9mFy/VdnOXZO9JQ/Gwe0TqDQU1IfJYWVd/ZhEMt+/DZX2xBzq50KFSh+xp9lgYPHSnkLDf1co8vQhk4N4rb/+J+SrHqxU0wrOPekiYJ9Xu7GLViaYB0Wd0Y/2QGU52zmLluhn3KAafZBUbJQJ+hQdaONGz8Yi7Ueu6sGjo/RqWdrceu4ZmmlKXHS/1RapSoeeVhvHfwI6LdJRtLtdcZaxnai4wqnRI5O9ORszNd0OdtUw4MNo0SbtX/zz3hwH9+3oPtxx5iLU8rT0LlCxvR/qteKvWL9igpSS4d76K6lHHj9BAmrs5wllc8Xyj4tpsvy0bIlVd6MNR8h3o9LUc7OBc/FUoFal6mu3xD7cyLHn57GKFwzrvw0fevouu33HMTkphvWXDt19ybUYkF8aj6bim1+u8TQnKCeP6FK2j74TVM9wh72tA578L1U4N4a98F9L1zm1SzeHHtRB9MRjNnecnhfGRXpxGrT5QXdjwOD4yNQzA2DkGTEovM7alILU1Ewvp4GHJ1UOuUUOqUYBgGLosLC1Y3LCM2THfPYbJzFrc/HMeiKzrvnno9XrQc7cBTjdVQKNk7ker6Spw58AGcs5G/QOQP688zyW/hikdgr7RsBvXVgixEYrAKkdLq70qGLc5yhkgMTiFyltCFK75BM0SWQodgcZW7LIkRUoicJWQJFU85QyQGLyFylpBB/iHlZUjY/4NKXucKn3B6GDlDJEbYQuTxJDzCjZegDJGl8ENInAR3WbKU4AiNT0RjiCyFnUjiEvGgLku5n0jjQeQuS5ZyDxJxIHbbu9qlkPr+8r/vjhD533evcKhkiI+VnCm0umiqQnysJDG0x0pRhPhYzmLEumkRdQxZrndiYrZb1AzxZzlkSzQuoKgJ8UdKcqKdxZIQ4iOaYqItwoekhARCU5BUBAQiaSFsCJEk1eCz8T9r65jEybiogAAAAABJRU5ErkJggg==\";', 1768134059),
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0', 'i:3;', 1768066008),
('laravel-cache-da4b9237bacccdf19c0760cab7aec4a8359010b0:timer', 'i:1768066008;', 1768066008),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"d\";s:10:\"group_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:34:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:23:\"admin.permissions.index\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:11:\"permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:24:\"admin.permissions.create\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:11:\"permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:23:\"admin.permissions.store\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:11:\"permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:22:\"admin.permissions.edit\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:11:\"permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:22:\"admin.permissions.show\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:11:\"permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:24:\"admin.permissions.update\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:11:\"permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:25:\"admin.permissions.destroy\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:11:\"permissions\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:17:\"admin.roles.index\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:18:\"admin.roles.create\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:17:\"admin.roles.store\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"admin.roles.edit\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:16:\"admin.roles.show\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:18:\"admin.roles.update\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:19:\"admin.roles.destroy\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"roles\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:18:\"admin.admins.index\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"admin\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:19:\"admin.admins.create\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"admin\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:18:\"admin.admins.store\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"admin\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:17:\"admin.admins.edit\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"admin\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:17:\"admin.admins.show\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"admin\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:19:\"admin.admins.update\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"admin\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:20:\"admin.admins.destroy\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"admin\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:8:\"category\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:8:\"category\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:8:\"products\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:8:\"products\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:5:\"cupon\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"cupon\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:7:\"address\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:7:\"address\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:6:\"banner\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:6:\"banner\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:6:\"wallet\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:6:\"wallet\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:8:\"customer\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:8:\"customer\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:6:\"others\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:6:\"others\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:6:\"orders\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:6:\"orders\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:10:\"percentage\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:10:\"percentage\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:6:\"report\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:6:\"report\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:5:\"prize\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:5:\"prize\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:7:\"setting\";s:1:\"c\";s:5:\"admin\";s:1:\"d\";s:7:\"setting\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:3:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"Superadmin\";s:1:\"c\";s:5:\"admin\";}i:1;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:5:\"admin\";}i:2;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"Sales\";s:1:\"c\";s:5:\"admin\";}}}', 1768070902);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('npWqyEVtJuKjXX2faRVQ5oARVsJy0ymZRvaFMp9w', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQXA2Z25pejdZRWw2MldvOGpTcmxGMEk5OVI4NmRoTlhyMVdvWmpNeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1768067491);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
