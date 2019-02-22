-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 22, 2019 at 07:50 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courses`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `center_id`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, 'ps3ioFNmd6jxVDgoGihYNuTwuxsZplHuom1hWHRx.jpeg', '2019-02-10 14:44:15', '2019-02-10 14:44:15'),
(2, 5, 1, 1, 'VwfMOFUzZQxgpWyholkpzrSlmlQ3fm5J6NNGK6kJ.jpeg', '2019-02-10 14:46:24', '2019-02-10 14:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `end_reservation` date NOT NULL,
  `start_time` time NOT NULL,
  `price` int(11) NOT NULL,
  `attendance` int(11) NOT NULL,
  `gender` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `course_id`, `start_date`, `finish_date`, `end_reservation`, `start_time`, `price`, `attendance`, `gender`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-02-24', '2019-02-28', '2019-02-20', '19:30:00', 200, 100, 3, '2019-02-15 15:50:54', '2019-02-15 15:50:54'),
(2, 2, '2019-03-01', '2019-03-09', '2019-03-01', '06:30:00', 200, 100, 3, '2019-02-22 14:40:21', '2019-02-22 14:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `admin_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'الراجحي', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/Al_Rajhi_Bank_Logo.svg/1280px-Al_Rajhi_Bank_Logo.svg.png', NULL, NULL),
(2, 'الأهلي', 'https://lammt.com/resource/uploads/AlAhli.png', NULL, NULL),
(3, 'سامبا', 'https://upload.wikimedia.org/wikipedia/ar/thumb/7/7d/Samba_Bank_Logo.svg/1280px-Samba_Bank_Logo.svg.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'علوم', NULL, NULL),
(2, 'رياضة', NULL, NULL),
(3, 'تكنولوجيا', NULL, NULL),
(4, 'فن', NULL, NULL),
(5, 'أدب', NULL, NULL),
(6, 'تطوير الذات', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_authority` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(11) NOT NULL,
  `cover` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `about` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `centers`
--

INSERT INTO `centers` (`id`, `user_id`, `verification_code`, `verification_authority`, `website`, `city_id`, `cover`, `logo`, `status`, `about`, `created_at`, `updated_at`) VALUES
(1, 1, '7386982578', 'الهيئة العامة للأوقاف', 'https://alkhirat.org', 2, 'VMwnPqHUay8vOdWQMvQo3wIKd5ZZOJdatfcPH3hP.jpeg', 'sBLA15qhfEWh9vgSgT1yhfalcUwyWqpoNvChw7q5.jpeg', 1, 'وقف الخيرات الذي يسعى بتقديم شباب مثقف ومتعلم بعلوم التقنية الحديثة', '2019-02-10 09:15:35', '2019-02-10 17:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `center_accounts`
--

CREATE TABLE `center_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `center_accounts`
--

INSERT INTO `center_accounts` (`id`, `account_owner`, `account_number`, `bank_id`, `center_id`, `created_at`, `updated_at`) VALUES
(1, 'جمعية وقف الخيرات', '748338594085904', 1, 1, '2019-02-10 09:15:35', '2019-02-10 09:15:35');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'أبها', NULL, NULL),
(2, 1, 'مكة المكرمة', NULL, NULL),
(3, 1, 'المدينة المنورة', NULL, NULL),
(4, 1, 'جدة', NULL, NULL),
(5, 1, 'الباحة', NULL, NULL),
(6, 2, 'أربد', NULL, NULL),
(7, 2, 'عمان', NULL, NULL),
(8, 3, 'أبوجا', NULL, NULL),
(9, 3, 'كانو', NULL, NULL),
(10, 4, 'الخرطوم', NULL, NULL),
(11, 4, 'ام درمان', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'المملكة العربية السعودية', NULL, NULL),
(2, 'الأردن', NULL, NULL),
(3, 'نيجيريا', NULL, NULL),
(4, 'السودان', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `course_id`, `discount`, `created_at`, `updated_at`) VALUES
(1, 'mo15', 1, 15, '2019-02-10 18:37:30', '2019-02-10 18:37:30'),
(2, 'mo20', 1, 20, '2019-02-10 18:37:30', '2019-02-10 18:37:30'),
(3, 'laravel-2019', 2, 20, '2019-02-11 14:02:15', '2019-02-11 14:02:15'),
(4, 'ando-pro', 3, 20, '2019-02-11 14:06:21', '2019-02-11 14:06:21'),
(8, 'laravel-15', 4, 15, '2019-02-15 15:07:04', '2019-02-15 15:07:04'),
(10, 'laravel-15', 1, 15, '2019-02-15 15:21:12', '2019-02-15 15:21:12'),
(11, 'laravel-15', 2, 15, '2019-02-15 15:50:54', '2019-02-15 15:50:54'),
(12, 'android', 2, 20, '2019-02-22 14:40:21', '2019-02-22 14:40:21'),
(13, 'and', 2, 50, '2019-02-22 14:40:21', '2019-02-22 14:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `identifier` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SKF',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  `center_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `validation` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `identifier`, `title`, `description`, `address`, `location`, `visible`, `center_id`, `category_id`, `city_id`, `template_id`, `validation`, `created_at`, `updated_at`) VALUES
(1, 'eaAvIerxwR', 'البرمجة بإستخدام لارافيل', 'سوف نتطرق لتعلم اساسيات لارافيل ومن ثم تحويها الى تطبيق عملي بعد ذلك سوف نتهمق في تفاصيل لارافيل', 'الشوقية خلف حلويات زمان', 'https://www.google.com', 1, 1, 3, 2, 1, 0, '2019-02-15 15:50:54', '2019-02-15 15:50:54'),
(2, 'DUyrf0CVpu', 'ejgku4hg4g46g56h', 'eyjfgkeugfkufgjcyfr6ti4ukgjhf4iukgy,4ikyguitkgtu4tjt4hgfik4t', 'jkfyio4ygi4ygt4t', 'jhwftkeuflieyfioi4ltgh45iguik5ygh5', 1, 1, 1, 1, 1, 0, '2019-02-22 14:40:21', '2019-02-22 14:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `course_admins`
--

CREATE TABLE `course_admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_admins`
--

INSERT INTO `course_admins` (`id`, `course_id`, `admin_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2019-02-19 18:41:33', '2019-02-19 18:41:33'),
(2, 2, 2, 2, '2019-02-22 14:43:33', '2019-02-22 14:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `course_trainers`
--

CREATE TABLE `course_trainers` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_trainers`
--

INSERT INTO `course_trainers` (`id`, `course_id`, `trainer_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 2, 2, '2019-02-22 14:40:21', '2019-02-22 14:40:21'),
(4, 2, 3, '2019-02-22 14:40:21', '2019-02-22 14:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `deadlines`
--

CREATE TABLE `deadlines` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_id` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ذكر', NULL, NULL),
(2, 'أنثى', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `url`, `course_id`, `created_at`, `updated_at`) VALUES
(1, 'U1JdzxtHUZbZf4awAADr3OvrInRE1Zw9aqOzFh0a.png', 1, '2019-02-15 15:50:54', '2019-02-15 15:50:54'),
(2, 'F9GE0S30f4TLmUsfMd7fzXcFDlZKN1EUaWaHuVJ7.jpeg', 1, '2019-02-15 15:50:54', '2019-02-15 15:50:54'),
(3, 'ieQv4UwI5lNblS8C3bYubVIamMp9iNBW4B5O4GpW.png', 2, '2019-02-22 14:40:21', '2019-02-22 14:40:21'),
(4, 'zr7Ys8UiHQ4Ht2E9StSkoYMBWjw0BTaYbjbbDG9D.jpeg', 2, '2019-02-22 14:40:21', '2019-02-22 14:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(112, '2014_10_12_000000_create_users_table', 1),
(113, '2014_10_12_100000_create_password_resets_table', 1),
(114, '2019_01_12_194802_create_students_table', 1),
(115, '2019_01_12_195730_create_reservations_table', 1),
(116, '2019_01_12_200322_create_attendances_table', 1),
(117, '2019_01_12_201354_create_certificates_table', 1),
(118, '2019_01_12_201648_create_images_table', 1),
(119, '2019_01_12_201937_create_centers_table', 1),
(120, '2019_01_12_202230_create_countries_table', 1),
(121, '2019_01_12_202419_create_cities_table', 1),
(122, '2019_01_12_202847_create_categories_table', 1),
(123, '2019_01_12_203014_create_banks_table', 1),
(124, '2019_01_12_203225_create_admins_table', 1),
(125, '2019_01_12_203446_create_coupons_table', 1),
(126, '2019_01_12_203935_create_templates_table', 1),
(127, '2019_01_12_204153_create_trainers_table', 1),
(128, '2019_01_12_204412_create_deadlines_table', 1),
(129, '2019_01_12_204552_create_courses_table', 1),
(130, '2019_01_12_205430_create_appointments_table', 1),
(131, '2019_01_13_131901_create_genders_table', 1),
(132, '2019_01_23_155510_create_nationalities_table', 1),
(133, '2019_01_23_160020_create_titles_table', 1),
(134, '2019_01_26_092026_create_course_trainers_table', 1),
(135, '2019_01_27_150449_create_course_admins_table', 1),
(136, '2019_02_09_132714_create_center_accounts_table', 1),
(137, '2019_02_12_145859_create_payment_confirmations_table', 2),
(138, '2019_02_13_170139_create_course_admins_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `nationalities`
--

CREATE TABLE `nationalities` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nationalities`
--

INSERT INTO `nationalities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'المملكة العربية السعودية', NULL, NULL),
(2, 'نيجيريا', NULL, NULL),
(3, 'الامارات', NULL, NULL),
(4, 'السودان', NULL, NULL),
(5, 'مصر', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments_confirmation`
--

CREATE TABLE `payments_confirmation` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments_confirmation`
--

INSERT INTO `payments_confirmation` (`id`, `account_owner`, `account_number`, `image`, `reservation_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Saud Saeed Hamza', '76459248762642', 'Lw72Y7cDReHhpY9QXDZBmpLyzfjK3jYehnOd4HLK.png', 1, 1, '2019-02-17 13:58:00', '2019-02-17 13:58:00'),
(2, 'shtfjygfuyjrdyjnt', '5436789708656436', 'egqLTD51FnHXKH7BiXDcki5jnKMG069ZZyZ3BFwu.png', 3, 1, '2019-02-22 14:31:55', '2019-02-22 14:31:55');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT '0',
  `appointment_id` int(11) NOT NULL,
  `identifier` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmation` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `student_id`, `coupon_id`, `appointment_id`, `identifier`, `confirmation`, `created_at`, `updated_at`) VALUES
(3, 1, 10, 1, 'C5nVu7s8F8', 0, '2019-02-22 14:30:53', '2019-02-22 14:30:53');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'account-profile.png',
  `year` year(4) NOT NULL DEFAULT '2000',
  `month` int(2) NOT NULL DEFAULT '0',
  `day` int(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `gender_id`, `city_id`, `status`, `url`, `year`, `month`, `day`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 2, 1, 'GXCJZ0FZQg8xZugZ88dhDe7kHVzbBWW98GaxKRzT.jpeg', 1996, 2, 10, '2019-02-12 03:05:43', '2019-02-22 14:41:24');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'القالب الأول', NULL, NULL),
(2, 'القالب الثاني', NULL, NULL),
(3, 'القالب الثالث', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'السيد', NULL, NULL),
(2, 'الاستاذ', NULL, NULL),
(3, 'الدكتور', NULL, NULL),
(4, 'البروفيسور', NULL, NULL),
(5, 'المهندس', NULL, NULL),
(6, 'الطبيب', NULL, NULL),
(7, 'الضابط', NULL, NULL),
(8, 'الوزير', NULL, NULL),
(9, 'الأمير', NULL, NULL),
(10, 'الملك', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `nationality_id` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `user_id`, `center_id`, `title_id`, `nationality_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 3, 1, 'LvrrggyOrIM2RQb8UtvoDqGbZyVVR4STV0HMuxlZ.jpeg', '2019-02-10 14:15:57', '2019-02-10 14:15:57'),
(2, 3, 1, 5, 1, '4u8rWc0hc2qZffT0aUxjjejLuwAxRsHd6wKSH8UF.jpeg', '2019-02-10 14:23:01', '2019-02-10 14:23:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'وقف الخيرات', 'al-khirat-2018', 'al-khirat-2018@hotmail.com', '+966568399409', NULL, '$2y$10$WC0G0YB7d5lVP73lB052I.dkTm2ITDsgj2clGb94DLzzH2JQpOO5W', 2, 'vCPl5Fq7DcUOBwcS6Ju1fSoci3NRGnZGmyGoEtPNMNbK698qfdGpY6TVmKXy', '2019-02-10 09:15:35', '2019-02-20 12:26:04'),
(2, 'محمد بكر الأمين', 'mohammed_alameen', 'mohammed_alameen@hotmail.com', '+278968052659', NULL, '$2y$10$ic3iAPlWvj2B9q4X093T9.oB75q5FV1WAPTRPmZT1XB1fEZCIoSN2', 4, NULL, '2019-02-10 14:15:57', '2019-02-10 14:15:57'),
(3, 'خالد مسعود الشهري', 'khalid-2018', 'khalid-2019@gmail.com', '+966529870927', NULL, '$2y$10$6VC24rsqAkLA392YzL6XweeONsI2AIbauduus.vpjtJVAOxl0tdma', 4, NULL, '2019-02-10 14:23:00', '2019-02-10 14:23:00'),
(4, 'محمود احمد الهاجري', 'meemo_2019', 'meemo_2019@hotmail.com', '+966923764028', NULL, '$2y$10$ZArw.THIlh7BT3hWmQuRD..17gx3rAL1y4k.229rhJzqU67ljaMqS', 3, 'lsUra8UD0UY8xNhVM09qVZu5fyNRe6z9QBWYiyLMp80k2QCKfu7E9tbs8mAj', '2019-02-10 14:44:15', '2019-02-10 14:44:15'),
(5, 'معاذ يعقوب يحيى', 'moaz-3320', 'moaz-3320@yahoo.com', '+966529746827', NULL, '$2y$10$Z4wd1c6XiU1/UNSGQ3GLoebBVvxTZTO6VlGkM/Wg8mSsuoPeT9zjS', 3, '3YDBcBmKtwcQGRi45RIJB1q7nwykagiN7A5LkaM0ZSw8fYc2fqV1DThrCofY', '2019-02-10 14:46:24', '2019-02-10 14:46:24'),
(6, 'سعود سعيد حمزة عبدالله', 'soao_d', 'soao_d@hotmail.com', '+966592970476', NULL, '$2y$10$rR8SmmJA0UIm0XUuKq9HZe6TOU.XHP9MvskSPGBTlob2NYD7cbRa6', 3, 'oBPMcPJn40vB6HCpKlR8cXDjLDZRwKzE6loBNfBNWbiwk0lpwe7evsT8Tr1v', '2019-02-12 03:05:43', '2019-02-12 03:05:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `center_accounts`
--
ALTER TABLE `center_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_admins`
--
ALTER TABLE `course_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_trainers`
--
ALTER TABLE `course_trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deadlines`
--
ALTER TABLE `deadlines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nationalities`
--
ALTER TABLE `nationalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments_confirmation`
--
ALTER TABLE `payments_confirmation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `center_accounts`
--
ALTER TABLE `center_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_admins`
--
ALTER TABLE `course_admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_trainers`
--
ALTER TABLE `course_trainers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deadlines`
--
ALTER TABLE `deadlines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `nationalities`
--
ALTER TABLE `nationalities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments_confirmation`
--
ALTER TABLE `payments_confirmation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
