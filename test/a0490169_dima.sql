-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 20 2021 г., 11:10
-- Версия сервера: 10.4.12-MariaDB
-- Версия PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `a0490169_dima`
--

-- --------------------------------------------------------

--
-- Структура таблицы `airports`
--

CREATE TABLE `airports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iata` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `airports`
--

INSERT INTO `airports` (`id`, `city`, `name`, `iata`, `created_at`, `updated_at`) VALUES
(1, 'Kazan', 'Kazan', 'KZN', NULL, NULL),
(2, 'Moscow', 'Sheremetyevo', 'SVO', NULL, NULL),
(3, 'St Petersburg', 'Pulkovo', 'LED', NULL, NULL),
(4, 'Sochi', 'Sochi', 'AER', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_from` bigint(20) UNSIGNED NOT NULL,
  `flight_back` bigint(20) UNSIGNED DEFAULT NULL,
  `date_from` date NOT NULL,
  `date_back` date DEFAULT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `flight_from`, `flight_back`, `date_from`, `date_back`, `code`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2020-10-01', '2020-10-10', 'TESTA', '2020-09-15 14:53:44', '2020-09-15 14:53:44'),
(2, 1, 2, '2020-11-01', '2020-11-10', '2TEST', '2020-09-15 14:53:44', '2020-09-15 14:53:44');

-- --------------------------------------------------------

--
-- Структура таблицы `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flight_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint(20) UNSIGNED NOT NULL,
  `to_id` bigint(20) UNSIGNED NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `cost` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `flights`
--

INSERT INTO `flights` (`id`, `flight_code`, `from_id`, `to_id`, `time_from`, `time_to`, `cost`, `created_at`, `updated_at`) VALUES
(1, 'FP2100', 2, 1, '08:35:00', '10:05:00', 10500, NULL, NULL),
(2, 'FP1200', 1, 2, '12:00:00', '13:35:00', 9500, NULL, NULL),
(3, 'FP2300', 2, 3, '07:05:00', '08:20:00', 4500, NULL, NULL),
(4, 'FP3200', 3, 2, '11:35:00', '12:50:00', 5500, NULL, NULL),
(5, 'FP2400', 2, 4, '10:00:00', '11:20:00', 3500, NULL, NULL),
(6, 'FP4200', 4, 2, '13:00:00', '14:20:00', 4500, NULL, NULL),
(7, 'FP3100', 3, 1, '15:00:00', '16:50:00', 7000, NULL, NULL),
(8, 'FP1300', 1, 3, '18:30:00', '20:10:00', 7500, NULL, NULL),
(9, 'FP3400', 3, 4, '18:00:00', '20:10:00', 10450, NULL, NULL),
(10, 'FP4300', 4, 3, '21:30:00', '23:10:00', 12050, NULL, NULL),
(11, 'FP1400', 1, 4, '14:30:00', '16:30:00', 15050, NULL, NULL),
(12, 'FP1400', 1, 4, '17:30:00', '19:30:00', 14050, NULL, NULL),
(13, 'FP2101', 2, 1, '12:10:00', '13:35:00', 12500, NULL, NULL),
(14, 'FP1201', 1, 2, '08:45:00', '10:05:00', 10500, NULL, NULL),
(15, 'FP2301', 2, 3, '11:45:00', '12:50:00', 5000, NULL, NULL),
(16, 'FP3201', 3, 2, '07:15:00', '08:20:00', 6000, NULL, NULL),
(17, 'FP2401', 2, 4, '13:10:00', '14:20:00', 2500, NULL, NULL),
(18, 'FP4201', 4, 2, '10:10:00', '11:20:00', 3500, NULL, NULL),
(19, 'FP3101', 3, 1, '18:40:00', '20:10:00', 7500, NULL, NULL),
(20, 'FP1301', 1, 3, '15:10:00', '16:50:00', 6500, NULL, NULL),
(21, 'FP3401', 3, 4, '21:40:00', '23:10:00', 9450, NULL, NULL),
(22, 'FP4301', 4, 3, '18:10:00', '20:10:00', 13050, NULL, NULL),
(23, 'FP1401', 1, 4, '17:40:00', '19:30:00', 13050, NULL, NULL),
(24, 'FP1401', 1, 4, '14:40:00', '16:30:00', 12050, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `passengers`
--

CREATE TABLE `passengers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `document_number` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_from` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `place_back` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `passengers`
--

INSERT INTO `passengers` (`id`, `booking_id`, `first_name`, `last_name`, `birth_date`, `document_number`, `place_from`, `place_back`, `created_at`, `updated_at`) VALUES
(1, 1, 'TestCase1_first_name', 'TestCase1_last_name', '1990-02-20', '7788223311', '7A', NULL, '2020-09-15 14:53:44', '2020-09-15 14:53:44'),
(2, 1, 'TestCase2_first_name', 'TestCase2_last_name', '1992-09-22', '9922335577', NULL, '8B', '2020-09-15 14:53:44', '2020-09-15 14:53:44'),
(3, 2, 'TestCase1_first_name', 'TestCase1_last_name', '1990-02-20', '7788223311', '8A', NULL, '2020-09-15 14:53:44', '2020-09-15 14:53:44');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `phone`, `password`, `document_number`, `api_token`, `created_at`, `updated_at`) VALUES
(1, 'TestCase1_first_name', 'TestCase1_last_name', '89001238833', 'password', '7788223311', 'testCaseToken', '2020-09-15 14:55:35', '2020-09-15 14:55:35'),
(2, 'Демитрий', 'Демин', '899242391955', '$2y$10$RKUkIIpLIqaqYwXfZq9Hz.mJZEDQvJVSc.rB5ln69wXZslWV7naJi', '9013454567', 'ee735bc561c20f96b269c6d6c729f8df', NULL, NULL),
(3, 'Ivan', 'Ivanov', '89001234567', '$2y$10$/P2ox.i6qPP3d3aZrrIb/.XuVPHRb3tYJGykWc3sHib4ccslMrLsy', '7567999222', 'bdad8e8914d7567c1c46f013129d0fbc', NULL, NULL),
(4, 'Ivan', 'Ivanov', '89001234577', '$2y$10$xYCGCibvFilGUjNhe3ObGe2lhIQz/KWKvs8o9nLHpgxe0uveiiR.S', '7567999272', '14c871f2951a1eb1ccbe66443c91ad46', NULL, NULL),
(5, 'Ivan', 'Ivanov', '89001234570', '$2y$10$iYpLS2DL7RZy6IF7I5R67eJHW2IIlY5Iv2jnOPTobFCEjGMQuu0o2', '7567999270', '7007ffefaca212736e962f897e6c3ff3', NULL, NULL),
(6, 'Ivan', 'Ivanov', '89001234170', '$2y$10$P2P6UqRdv9HhxrAPQ7Re3uBTHwFDmfceceucSbbRoZwXS1t/F5lcS', '3567999270', 'd37bf9cc814eb5049f3fa42a640722f1', NULL, NULL),
(7, 'Ivan', 'Ivanov', '8900в234170', '$2y$10$9qtJIPH421ucO6kt0Aa2sO4BcYKVfwpLVb/7AVSDslR69JIPDW5sq', '3467999270', '3be960e02049490031d942cc336493d4', NULL, NULL),
(8, 'Ivan', 'Ivanov', '89004534170', '$2y$10$hoRuTjw../ESCCuIrKKRDu3gFmI9Djwup0wHMYSETmmvmiBFkfzV6', '3467699270', 'eb03f6995309414f851061b8b0b9469e', NULL, NULL),
(9, 'Dimasik', 'Nemkov', '99999999999', '$2y$10$Man5FPQofJvQirrs3EhhcuOAxo//bmlRK9GNSIfH7c3M/iCWgxcKO', '3214587690', '4bd2452cfd9a521c7a845a6c88873037', NULL, NULL),
(10, 'Ivan', 'Ivanov', '89031234567', '$2y$10$jPp0MKnAISUZikahid1kMuht/ZHkmVjmgqH2bzRebtqxHmhg.Ip8m', '6567999252', '9139cbf1b0e94a6a503ab5a0a8c3e9c5', NULL, NULL),
(11, 'Ivan', 'Ivanov', '89031244567', '$2y$10$DcwDejR3yRnASdxujOLAhugfmidQlVlunqzneN65dSufRY3uYUkjy', '6167999252', 'b032394708a648cecb4bb35e56841286', NULL, NULL),
(12, 'Dimasik', 'Nemkov', '99999999990', '$2y$10$Zl3tVmMZccHgG8zWdlHowO6Yci7s0Jw3MUz2YRL3Lkl7RUK4ErbYC', '3214587698', '6ae516c28a6c0cbe524814c99f9e4e6a', NULL, NULL),
(13, '543', '543', '54354354353', '$2y$10$EWMA.fOKIvOoRin4RXQkl.t6BJOyrXiBVa1BW2DOmRTimhq.O0loS', '5435455677', '6bee2ddeab8e8358eb22dd980c398258', NULL, NULL),
(14, '232', 'rew', '23244342', '$2y$10$pHuFsvZyehvv5nbObiCFZerjBdDlEVSMPV.vMETGrk9ZGicn751k6', '4534567654', '6e1bac12a41fc898fb0ccb787a890ef4', NULL, NULL),
(15, 'rewrew', 'rewrew', '433243', '$2y$10$qImaaTYaaRiiUcxsG.0YuuLmeMb58WgOV826pA0TXREJZ6iCP12cq', '3434343434', 'e76d26e40f89e2a129070096f90677a1', NULL, NULL),
(16, 'куц', 'куц', '1233', '$2y$10$hqFyPFgeMu76UfnF7bYaeO.Avg37Fu5HoEs60IToeOmt3KyUZSPxm', '3434231213', 'be7c4666ce953f77e34a2c50eae94ad1', NULL, NULL),
(17, '543', '543', '1233432', '$2y$10$42UYeTk/B5A2gXd4k4ypXeBAjmmAxdcV4Dk3pwjMahYGy79RoAqeS', '4564564566', '545979625df3d14368cb8c811f26cd56', NULL, NULL),
(18, 'rewrew', 'rewrew', '3211', '$2y$10$Set.A3JQl91LnRGCFhWx1e8fvE/RHEgCMEl7JK3TiqfFNP/EJDqvi', '4535435454', '30a9e353f325a9106c1d95ab1202eea9', NULL, NULL),
(19, 'trerte', 'tretre', '2424', '$2y$10$Rnbd.kt726wubTeJG0UCq.ApWB.Huu0J51Y6o7wr3Flrfr/DhYla.', '4567890093', 'e0fa0e989124023a91d31a676425bfa7', NULL, NULL),
(20, 'rewrw', 'rewre', '5655', '$2y$10$59DaoJeK1Dr5SgrmbnV8suEo6sG1meP8q1YbNr3KJQVtvKnFbyiqq', '8767676777', '75ec1153318397b25e10269cc7c91f53', NULL, NULL),
(21, 'Владислав', 'Демин', '88005553535', '$2y$10$AnaueATrUd4fC1r13liYr./eOM8Y4Yomqxqde1k7L4ixKNeOXOSEm', '0987342165', '0b3a5fea4f3eca4c268d73505cf575af', NULL, NULL),
(22, 'Влад', 'Демин', '880055535355', '$2y$10$XsRhrUrSyc5MhakbeTTOFO55Dsd5GroOlNWKPoRHGBlSBJ6mipYjq', '0984576346', '78bb40842fe464c5be205dfb5c9df956', NULL, NULL),
(23, 'Влад', 'Демин', '8800555353555', '$2y$10$K3LyBt/M28XZV8wd1UKKnuzMYoWlaN0tproLojEpQPW6h1PDGmD9G', '0984576347', '8ece96fc927b652256ff677c112f1799', NULL, NULL),
(24, 'Влад', 'Демин', '88005553535555', '$2y$10$lqBrlEzbweMrnTtnRJMENu0HtibtFLfV5LxMr4ry2MXCpp0K.5N6G', '0984576348', 'feedbe7cc60b49778fd0074868b0313c', NULL, NULL),
(25, 'Влад', 'Демин', '880055535355555', '$2y$10$LdmWFSPtZJcRhB1j5Jned..WBeeAwlR0uF.GoPHs.zfJbDnEd9ai2', '0984576349', '1546a8f5046a7ea3f82aa0ac105df935', NULL, NULL),
(26, 'Настя', 'Щипанова', '6969', '$2y$10$vW.mDHsuOk2RoEejcHQQfOIjBFpS.u6I00NQPKdtEi0wQhwVthP2W', '1234123412', 'b35ccbebca6eabb47fa3ad9d934b4307', NULL, NULL),
(27, 'Настя', 'Щипанова', '699', '$2y$10$vHUyvTdre1OlkPui4MFSYuDEydvkn5ztegcn5s/RRdO4AnCnf5vke', '0000055555', '37a1a68a90c1c52e231f41231c96463a', NULL, NULL),
(28, 'gfdg', 'gfdgfd', '123312', '$2y$10$SZATSD7d3RmyC5D3BQyXEesPnEXjNEh7sqyn/M6TnlxqIwygymaTe', '1233333333', 'de92795b5e8dbadee95a6576254d4447', NULL, NULL),
(29, 'Анастасия', 'Щипанова', '89924239195', '$2y$10$itXaPQDU/yWozkPnjt3i.uKIAwkGO44XstP4357J62dcuha2cv.xe', '6969696969', '078b521730359532a57a38d26dc654d9', NULL, NULL),
(30, 'gfdgfd', 'jhgrrtyrhgf', '22222', '$2y$10$5NxXmD9CleZ8hI/6TXFfz.p8bLRuSV4M6octQes6FekRHqD4OJLi.', '4576874586', 'be6ecfef45c0e4849fe43171527c29f4', NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_flight_from_foreign` (`flight_from`),
  ADD KEY `bookings_flight_back_foreign` (`flight_back`);

--
-- Индексы таблицы `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flights_from_id_foreign` (`from_id`),
  ADD KEY `flights_to_id_foreign` (`to_id`);

--
-- Индексы таблицы `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `passengers_booking_id_foreign` (`booking_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `airports`
--
ALTER TABLE `airports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_flight_back_foreign` FOREIGN KEY (`flight_back`) REFERENCES `flights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_flight_from_foreign` FOREIGN KEY (`flight_from`) REFERENCES `flights` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_from_id_foreign` FOREIGN KEY (`from_id`) REFERENCES `airports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `flights_to_id_foreign` FOREIGN KEY (`to_id`) REFERENCES `airports` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `passengers`
--
ALTER TABLE `passengers`
  ADD CONSTRAINT `passengers_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
