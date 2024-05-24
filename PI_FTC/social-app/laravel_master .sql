-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-05-2024 a las 01:36:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `laravel_master`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `image_id` int(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `image_id`, `content`, `created_at`, `updated_at`) VALUES
(12, 19, 8, 'holaa', '2024-04-28 16:17:32', '2024-04-28 16:17:32'),
(14, 19, 8, 'hoasa', '2024-05-06 11:32:42', '2024-05-06 11:32:42'),
(16, 19, 5, 'fafs', '2024-05-21 22:14:00', '2024-05-21 22:14:00'),
(17, 19, 9, 'asdasd', '2024-05-21 22:18:52', '2024-05-21 22:18:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `images`
--

CREATE TABLE `images` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `images`
--

INSERT INTO `images` (`id`, `user_id`, `image_path`, `description`, `created_at`, `updated_at`) VALUES
(5, 13, '1713300266girl1.jpg', 'Cute!', '2024-04-16 20:44:26', '2024-04-16 20:44:26'),
(6, 14, '1713300333boy1.1.jpg', 'check', '2024-04-16 20:45:33', '2024-04-16 20:46:20'),
(7, 15, '1713300446boy2.jpg', 'saa', '2024-04-16 20:47:26', '2024-04-16 20:47:26'),
(8, 16, '1713300543girl2.jpg', 'saw', '2024-04-16 20:49:03', '2024-04-16 20:49:03'),
(9, 19, '1713386615Carnecita con pimiento rojo y patata.jpg', 'Quien me invita a comer ?¿', '2024-04-17 20:43:35', '2024-04-17 20:43:35'),
(11, 22, '1715614786doggy.jpg', 'Con mi perro doggy, chico guapo que le encante los animales donde estais?¿', '2024-05-13 15:39:46', '2024-05-13 15:39:46'),
(13, 19, '1716588581pexels-bri-schneiter-28802-346529.jpg', 'asasa sa assaas', '2024-05-24 22:09:41', '2024-05-24 22:09:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likematch`
--

CREATE TABLE `likematch` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `target_user_id` int(255) DEFAULT NULL,
  `click_type` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likematch`
--

INSERT INTO `likematch` (`id`, `user_id`, `target_user_id`, `click_type`, `created_at`, `updated_at`) VALUES
(19, 15, 19, 'like', '2024-04-17 20:46:45', '2024-04-17 20:46:45'),
(21, 15, 16, 'like', '2024-04-21 10:46:06', '2024-04-21 10:46:06'),
(22, 13, 19, 'like', '2024-04-22 09:13:35', '2024-04-22 09:13:35'),
(26, 13, 14, 'like', '2024-04-22 11:37:30', '2024-04-22 11:37:30'),
(29, 13, 21, 'like', '2024-04-23 12:39:38', '2024-04-23 12:39:38'),
(30, 21, 13, 'like', '2024-04-23 12:47:12', '2024-04-23 12:47:12'),
(69, 19, 13, 'like', '2024-04-30 13:43:27', '2024-04-30 13:43:27'),
(84, 19, 22, 'like', '2024-05-24 22:18:26', '2024-05-24 22:18:26'),
(85, 22, 19, 'like', '2024-05-24 22:19:21', '2024-05-24 22:19:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `image_id` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `image_id`, `created_at`, `updated_at`) VALUES
(2, 13, 8, '2024-04-16 21:00:44', '2024-04-16 21:00:44'),
(3, 13, 7, '2024-04-16 21:00:46', '2024-04-16 21:00:46'),
(4, 19, 8, '2024-04-17 20:40:08', '2024-04-17 20:40:08'),
(5, 19, 6, '2024-04-17 20:40:15', '2024-04-17 20:40:15'),
(6, 19, 5, '2024-04-17 20:40:17', '2024-04-17 20:40:17'),
(8, 11, 6, '2024-04-21 10:43:09', '2024-04-21 10:43:09'),
(10, 13, 5, '2024-04-23 13:11:54', '2024-04-23 13:11:54'),
(30, 22, 13, '2024-05-24 22:31:13', '2024-05-24 22:31:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(255) NOT NULL,
  `sender_id` int(255) DEFAULT NULL,
  `receiver_id` int(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `content`, `created_at`, `updated_at`, `read_at`) VALUES
(673, 19, 13, 'aa', '2024-05-06 11:34:15', '2024-05-06 11:35:19', '2024-05-06 11:35:19'),
(674, 13, 19, 'guapa', '2024-05-06 11:35:24', '2024-05-06 11:35:25', '2024-05-06 11:35:25'),
(675, 19, 13, 'aa', '2024-05-06 11:36:30', '2024-05-06 11:36:31', '2024-05-06 11:36:31'),
(676, 13, 19, 'assd', '2024-05-20 11:43:17', '2024-05-20 11:43:45', '2024-05-20 11:43:45'),
(677, 19, 13, 'asdfas', '2024-05-20 11:43:51', '2024-05-24 20:15:55', '2024-05-24 20:15:55'),
(678, 22, 19, 'hola', '2024-05-24 23:35:15', '2024-05-24 23:35:20', '2024-05-24 23:35:20'),
(679, 19, 22, 'hola', '2024-05-24 23:35:24', '2024-05-24 23:35:25', '2024-05-24 23:35:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usermatch`
--

CREATE TABLE `usermatch` (
  `id` int(255) NOT NULL,
  `user1_id` int(255) DEFAULT NULL,
  `user2_id` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usermatch`
--

INSERT INTO `usermatch` (`id`, `user1_id`, `user2_id`, `created_at`, `updated_at`) VALUES
(15, 13, 21, '2024-04-23 14:47:24', '2024-04-23 14:47:24'),
(17, 13, 19, '2024-04-30 15:43:32', '2024-04-30 15:43:32'),
(18, 19, 22, '2024-05-25 00:19:22', '2024-05-25 00:19:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(200) DEFAULT NULL,
  `nick` varchar(100) DEFAULT NULL,
  `telefono` int(255) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  `edad` int(3) DEFAULT NULL,
  `residencia` varchar(255) DEFAULT NULL,
  `profileDescription` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `surname`, `nick`, `telefono`, `genero`, `edad`, `residencia`, `profileDescription`, `email`, `password`, `image`, `created_at`, `updated_at`, `remember_token`) VALUES
(11, 'admin', 'Admin', 'b', 'b', 655223311, 'mujer', 25, 'Badajoz', NULL, 'b@b.com', '$2y$10$DFsCTnmnd3Gk3Y4kc1EgHeBIV5HWB7Bhw2GZ5PYrvuQv8SKox5P7O', 'default.jpg', '2024-04-16 17:21:50', '2024-05-24 23:31:26', NULL),
(13, 'user', 'angela', 'angela', 'angela', 655234165, 'mujer', 24, 'Madrid', 'Amo el surf y viajar asasddas', 'angela@angela.com', '$2y$10$NZEKcnPvQgR8E4wyYU.sl.5/RS9oYPoD2J3Z7zk4KU9kLaBPWRp9q', '1713300581girl1.jpg', '2024-04-16 20:44:04', '2024-05-06 11:37:20', NULL),
(14, 'user', 'javier', 'javier', 'javier', 652369874, 'hombre', 28, 'Madrid', NULL, 'javier@javier.com', '$2y$10$si.PT/7Zm.uqAxtF/st5PeYalUS1Qa8GEPBWQaPnb1oirnpAySB1O', '1713300392boy1.jpg', '2024-04-16 20:45:09', '2024-04-16 20:46:32', NULL),
(15, 'user', 'xavi', 'xavi', 'xavi', 655212123, 'hombre', 19, 'Badajoz', NULL, 'xavi@xavi.com', '$2y$10$g3clcTofQnt6qPONyn7jl.KZ6IO8Rw1oEDFCTHAYYyYCR2.jRLRAS', '1713300455boy2.jpg', '2024-04-16 20:47:08', '2024-04-16 20:47:35', NULL),
(16, 'user', 'Sara', 'Sara', 'Sara', 655212136, 'mujer', 30, 'Sevilla', NULL, 'Sara@Sara.com', '$2y$10$x9fRfFO84/JICChC3aOAXuvdDcPObQZLKCIt4eHGGcNLboGOpFhly', '1713300553girl2.jpg', '2024-04-16 20:48:31', '2024-04-16 20:49:13', NULL),
(19, 'user', 'Ángel', 'Higuero Mora', 'Ángel Mora', 655124569, 'hombre', 28, 'Madrid', 'hoola hola hoal', 'c@c.com', '$2y$10$1d7bHWBqUd0lz1QkGOUnAO5S./gzPuKbE0PcQFC3Rw67cDmcD76oe', '1716588114WhatsApp Image 2024-05-24 at 23.59.16.jpeg', '2024-04-17 19:47:42', '2024-05-24 23:34:10', 'UTcC7nvJTUQbguuJkQM9WbZ3IeBcS5edIAJIHWknKzYHI4azjWvJHhgLEaWF'),
(21, 'user', 'z', 'z', 'z', 655221133, 'hombre', 30, 'Cáceres', NULL, 'higueromora@hotmail.com', '$2y$10$ppODhr624xK0qI7pbF4b1OwOPpSsjAD/SgiONyfaA613bFyIY4fDu', 'default.jpg', '2024-04-22 14:38:28', '2024-04-22 15:30:09', 'ZMSJPXiozMZBwo7yYspeQHn4EzE0wBJ72HT79lI4TxDMjqsJAnVetQslqBSG'),
(22, 'user', 'clara', 'García', 'Clarita', 655232387, 'mujer', 28, 'Madrid', 'Amante de los animales y el running.', 'clara@clara.com', '$2y$10$/zkVDtotaoytsj8xBOUol.SnDco/NU06XWIGDhCxgHilRsSYk.9Sa', '1715527022clara.jpg', '2024-05-12 15:10:44', '2024-05-24 22:19:58', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_blocks`
--

CREATE TABLE `user_blocks` (
  `id` int(255) NOT NULL,
  `blocker_id` int(255) DEFAULT NULL,
  `blocked_id` int(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user_blocks`
--

INSERT INTO `user_blocks` (`id`, `blocker_id`, `blocked_id`, `created_at`, `updated_at`) VALUES
(6, 15, 13, '2024-04-21 10:51:29', '2024-04-21 10:51:29'),
(11, 13, 14, '2024-04-22 11:38:35', '2024-04-22 11:38:35'),
(16, 19, 21, '2024-04-28 16:37:40', '2024-04-28 16:37:40');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_users` (`user_id`),
  ADD KEY `fk_comments_images` (`image_id`);

--
-- Indices de la tabla `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_images_users` (`user_id`);

--
-- Indices de la tabla `likematch`
--
ALTER TABLE `likematch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_target_user_id` (`target_user_id`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_likes_users` (`user_id`),
  ADD KEY `fk_likes_images` (`image_id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sender_id` (`sender_id`),
  ADD KEY `fk_receiver_id` (`receiver_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_reset_tokens_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `usermatch`
--
ALTER TABLE `usermatch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user1_id` (`user1_id`),
  ADD KEY `fk_user2_id` (`user2_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_blocks`
--
ALTER TABLE `user_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blocker_id` (`blocker_id`),
  ADD KEY `fk_blocked_id` (`blocked_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `images`
--
ALTER TABLE `images`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `likematch`
--
ALTER TABLE `likematch`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=680;

--
-- AUTO_INCREMENT de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usermatch`
--
ALTER TABLE `usermatch`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `user_blocks`
--
ALTER TABLE `user_blocks`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_images` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `fk_images_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `likematch`
--
ALTER TABLE `likematch`
  ADD CONSTRAINT `fk_target_user_id` FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_likes_images` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `fk_likes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_receiver_id` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `usermatch`
--
ALTER TABLE `usermatch`
  ADD CONSTRAINT `fk_user1_id` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_user2_id` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `user_blocks`
--
ALTER TABLE `user_blocks`
  ADD CONSTRAINT `fk_blocked_id` FOREIGN KEY (`blocked_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_blocker_id` FOREIGN KEY (`blocker_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
