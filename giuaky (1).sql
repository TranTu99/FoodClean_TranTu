-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 12, 2025 lúc 02:24 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `giuaky`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-11-09 07:32:37', '2025-11-09 07:32:37'),
(2, 2, '2025-11-10 06:51:04', '2025-11-10 06:51:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `stt` int(11) NOT NULL DEFAULT 0,
  `display` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `parentid`, `stt`, `display`, `created_at`, `updated_at`) VALUES
(1, 'Trứng', 'trung', 0, 10, 1, '2025-11-09 07:23:29', '2025-11-09 07:23:29'),
(2, 'Thịt', 'thit', 0, 10, 1, '2025-11-09 07:23:29', '2025-11-09 07:23:29'),
(3, 'Gạo', 'gao', 0, 10, 1, '2025-11-09 07:23:29', '2025-11-09 07:23:29'),
(4, 'Hoa Quả Tươi', 'hoa-qua-tuoi', NULL, 0, 1, '2025-11-09 14:28:20', '2025-11-09 14:28:20'),
(5, 'Rau Củ', 'rau-cu', NULL, 0, 1, '2025-11-09 14:28:41', '2025-11-09 14:28:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_06_112738_create_categories_table', 1),
(5, '2025_11_07_123228_create_products_table_v2', 1),
(6, '2025_11_07_123236_create_product_details_table_v2', 1),
(7, '2025_11_08_013725_create_carts_table', 1),
(8, '2025_11_08_013741_create_cart_items_table', 1),
(9, '2025_11_08_022232_create_orders_table', 1),
(10, '2025_11_08_022244_create_order_details_table', 1),
(11, '2025_11_10_122826_create_orders_table', 2),
(12, '2025_11_10_122844_create_order_details_table', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `payment_method` enum('COD','ONLINE') NOT NULL,
  `status` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending_payment','unpaid','paid','failed') NOT NULL DEFAULT 'pending_payment',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `phone_number`, `shipping_address`, `note`, `payment_method`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, 26500.00, '0376285043', '317 tan ky tan quy,p. tan quy,q. tan phu', 'Tên: Tu Tran | Email: trantuit4@gmail.com | Ghi chú: ok', 'ONLINE', 'pending', 'pending_payment', '2025-11-10 05:32:48', '2025-11-10 05:32:48'),
(2, 1, 20000.00, '0376285043', '317 tan ky tan quy,p. tan quy,q. tan phu', 'Tên: Tu Tran | Email: trantuit4@gmail.com | Ghi chú: g', 'ONLINE', 'pending', 'pending_payment', '2025-11-10 06:27:03', '2025-11-10 06:27:03'),
(3, 1, 20000.00, '0376285043', '317 tan ky tan quy,p. tan quy,q. tan phu', 'Tên: Tu Tran | Email: trantuit4@gmail.com | Ghi chú: ok', 'ONLINE', 'pending', 'pending_payment', '2025-11-10 07:28:14', '2025-11-10 07:28:14'),
(4, 1, 20000.00, '0376285043', '317 tan ky tan quy,p. tan quy,q. tan phu', 'Tên: Tu Tran | Email: trantuit4@gmail.com | Ghi chú: yyyy', 'COD', 'pending', 'unpaid', '2025-11-10 08:04:22', '2025-11-10 08:04:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 12, 1, 13000.00, '2025-11-10 05:32:48', '2025-11-10 05:32:48'),
(3, 2, 14, 1, 20000.00, '2025-11-10 06:27:03', '2025-11-10 06:27:03'),
(4, 3, 14, 1, 20000.00, '2025-11-10 07:28:14', '2025-11-10 07:28:14'),
(5, 4, 14, 1, 20000.00, '2025-11-10 08:04:22', '2025-11-10 08:04:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `image`, `description`, `price`, `sale_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Táo Fuji Nhật Bản', 'tao-fuji-nhat-ban', 'assets/img/products/product-img-5.jpg', 'Táo giòn, ngọt, nhập khẩu từ Nhật Bản Số 1', 150000.00, 135000.00, 1, '2025-11-09 07:30:32', '2025-11-11 17:37:23'),
(2, 5, 'Cà Rốt Đà Lạt Hữu Cơ 1', 'ca-rot-da-lat-huu-co-1', 'assets/img/products/carot.jpg', 'Cà rốt tươi, sạch, trồng tại Đà Lạt.', 25000.00, 22000.00, 1, '2025-11-09 07:30:32', '2025-11-11 08:00:34'),
(3, 1, 'Trứng Gà Ta Thảo Mộc', 'trung-ga-ta-thao-moc', 'assets/img/products/trunggata.jpg', 'Trứng gà tươi sạch, giàu dinh dưỡng.', 45000.00, 40000.00, 1, '2025-11-09 07:30:33', '2025-11-09 07:30:33'),
(4, 2, 'Thịt Bò Tơ Phi Lê', 'thit-bo-to-phi-le', 'assets/img/products/thitbo.jpg', 'Thịt bò tơ mềm, tươi ngon, thích hợp làm bít tết.', 250000.00, 230000.00, 1, '2025-11-09 07:30:33', '2025-11-09 07:30:33'),
(5, 3, 'Gạo Tám Xoan Hải Hậu', 'gao-tam-xoan-hai-hau', 'assets/img/products/tamxoan.jpg', 'Gạo dẻo thơm, nguồn gốc Hải Hậu.', 120000.00, 115000.00, 1, '2025-11-09 07:30:33', '2025-11-09 07:30:33'),
(6, 3, 'Gạo ST25', 'gao-st25', 'assets/img/products/st25.jpg', 'Gạo đến từ Sóc Trăng mang hương vị thơm ngon', 25000.00, 22000.00, 1, NULL, NULL),
(7, 3, 'Gạo nàng thơm', 'gao-nang-thom', 'assets/img/products/nangthom.jpg', 'Gạo nàng thơm mang lại hương vị miền trung đậm đà cùng với các món chính', 18000.00, 15000.00, 1, NULL, NULL),
(8, 5, 'Cà chua', 'ca-chua', 'assets/img/products/cachua.jpg', 'Cà chưa thanh mát ngọt lịm cùng vị chua tự nhiên', 13000.00, 12000.00, 1, NULL, NULL),
(9, 5, 'Rau Mồng Tơi', 'rau-mong-toi', 'assets/img/products/raumongtoi.jpg', 'Rau đến từ nhà vườn, sạch sẽ và tươi xanh', 8000.00, 5000.00, 1, NULL, NULL),
(11, 1, 'Trứng vịt xiêm', 'trung-vit-xiem', 'assets/img/products/trungvitxiem.jpg', 'Trứng vịt nhà vườn, mang cho món ăn ngon mỗi ngày', 6000.00, 4000.00, 1, NULL, NULL),
(12, 1, 'Trứng Ngỗng', 'trung-ngong', 'assets/img/products/1762873291_trunggata.jpg', 'Trứng Ngỗng nhà nuôi , chế biến các món ăn đơn giản trong nhà hàng,...', 17000.00, 13000.00, 1, NULL, '2025-11-11 08:01:31'),
(13, 1, 'Trứng Gà Tre', 'trung-ga-tre', 'assets/img/products/trunggatre.jpg', 'Trứng gà tre đến từ bến tre nhà nuôi', 7000.00, 6000.00, 1, NULL, NULL),
(14, 4, 'Dâu tây', 'dau-tay', 'assets/img/products/product-img-1.jpg', 'Dâu Tây đến từ Đà Lạt', 23000.00, 20000.00, 1, NULL, NULL),
(15, 4, 'Việt-Quất', 'viet-quat', 'assets/img/products/product-img-2.jpg', 'Việt Quất nhà vườn ngọt chua kết hợp ngon lịm', 25000.00, 18000.00, 1, NULL, NULL),
(16, 4, 'Cam Vàng', 'cam-vang', 'assets/img/products/product-img-3.jpg', 'Cam nhập khẩu Hàn Quốc', 34000.00, 32500.00, 1, NULL, NULL),
(17, 4, 'KiWi', 'ki-wi', 'assets/img/products/product-img-4.jpg', 'Trái Kiwi đầy mọng nước', 36000.00, 35500.00, 1, NULL, NULL),
(18, 2, 'Thịt Gà', 'thit-ga', 'assets/img/products/thitga.jpg', 'Thịt gà công nghiệp Long An ', 150000.00, 145600.00, 1, NULL, NULL),
(19, 2, 'Thịt Heo', 'thit-heo', 'assets/img/products/thitheo.jpg', 'Thịt heo nhà nuôi, nhiều thịt ít mỡ', 13000.00, 124000.00, 1, NULL, NULL),
(20, 2, 'Thịt dê', 'thit-de', 'assets/img/products/thitde.jpg', 'Thịt dê giành cho các quán nhâu, nhà hàng chuyên dùng', 23000.00, 223700.00, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_details`
--

CREATE TABLE `product_details` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `full_description` longtext DEFAULT NULL,
  `technical_specs` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_details`
--

INSERT INTO `product_details` (`product_id`, `full_description`, `technical_specs`, `stock_quantity`, `created_at`, `updated_at`) VALUES
(1, 'Đóng gói 1kg (4-5 quả). Giàu vitamin C, rất tốt cho sức khỏe.', NULL, 25, '2025-11-09 07:30:32', '2025-11-09 07:30:32'),
(2, 'Sản phẩm đạt chuẩn VietGAP. Dùng để ép nước hoặc nấu canh.', NULL, 82, '2025-11-09 07:30:33', '2025-11-09 07:30:33'),
(3, 'Sản phẩm được đóng gói 10 quả/vỉ. Nguồn gốc rõ ràng tại trang trại Thảo Mộc.', NULL, 16, '2025-11-09 07:30:33', '2025-11-09 07:30:33'),
(4, 'Trọng lượng: 500g/hộp. Cung cấp protein và sắt dồi dào. Bảo quản: Ngăn đông.', NULL, 43, '2025-11-09 07:30:33', '2025-11-09 07:30:33'),
(5, 'Đóng gói 5kg/túi. Gạo đạt chuẩn OCOP 4 sao. Cách nấu: 1 chén gạo với 1 chén nước.', NULL, 92, '2025-11-09 07:30:33', '2025-11-09 07:30:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tu Tran', 'trantuit4@gmail.com', NULL, '$2y$12$xHQq/CPX5LLOPNeR0y95c.pQh4G9lesbzMYQcyLkI3qGamQxDbKFW', 1, 'j7zh7NEJttHnGdOGHI3Jds4xg0kPe6OoVG876KhfEmLYcdWdhAarXp76Wi1S', '2025-11-09 07:22:34', '2025-11-09 07:22:34'),
(2, 'Lê Trang', 'lequynhtrang971@gmail.com', NULL, '$2y$12$X8k8Brmu06IxfdHKRLfZheoGVnNnr5iv77FppeBTbsGlMCykas1r2', 0, NULL, '2025-11-10 04:25:26', '2025-11-10 04:25:26');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_unique` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
