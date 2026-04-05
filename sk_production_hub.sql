-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 05, 2026 at 09:47 PM
-- Server version: 12.1.2-MariaDB-ubu2404
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sk_production_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(10) UNSIGNED NOT NULL,
  `stage_name` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `bio` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `stage_name`, `slug`, `bio`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 'SKUPPA', 'skuppa', 'Underground selector blending dark, atmospheric club energy.', NULL, '2026-03-19 14:50:35', '2026-03-19 14:50:35'),
(2, 'NOVEL', 'novel', 'Experimental electronic artist focused on immersive sound design.', NULL, '2026-03-19 14:50:35', '2026-03-19 14:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `mix_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `mix_id`, `user_id`, `content`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'This mix is hard. Love the atmosphere.', 0, '2026-03-19 14:50:35', '2026-03-19 14:50:35'),
(2, 2, 2, 'Really unique sound design on this one.', 0, '2026-03-19 14:50:35', '2026-03-19 14:50:35'),
(3, 3, 1, 'this is a test', 0, '2026-03-19 21:37:05', '2026-03-19 21:37:05'),
(4, 1, 1, 'this is another test', 0, '2026-03-20 09:15:45', '2026-03-20 09:15:45'),
(5, 3, 3, 'did is so goed', 0, '2026-03-20 09:49:17', '2026-03-20 09:49:17'),
(6, 3, 1, 'hallo again', 0, '2026-03-27 05:25:39', '2026-03-27 05:25:39'),
(7, 3, 1, 'another test', 0, '2026-04-05 20:16:10', '2026-04-05 20:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `contact_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`contact_id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Visitor One', 'visitor@example.com', 'Booking inquiry', 'Hi, I would like to ask about a future event booking.', '2026-03-19 14:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `mixes`
--

CREATE TABLE `mixes` (
  `mix_id` int(10) UNSIGNED NOT NULL,
  `artist_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `description` text NOT NULL,
  `genre` varchar(100) NOT NULL,
  `tracklist` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `media_url` varchar(500) NOT NULL,
  `duration` int(10) UNSIGNED DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `created_by_user_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mixes`
--

INSERT INTO `mixes` (`mix_id`, `artist_id`, `title`, `slug`, `description`, `genre`, `tracklist`, `image_path`, `media_url`, `duration`, `is_featured`, `is_public`, `created_by_user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'QUI3T_OP3R4T10N', 'qui3t-op3r4t10n', 'A dark late-night mix with industrial textures and deep rhythmic pressure.', 'Techno', 'Track 1, Track 2, Track 3', NULL, 'https://soundcloud.com/', 3600, 1, 1, 1, '2026-03-19 14:50:35', '2026-03-19 14:50:35'),
(2, 2, 'SIGNAL LOSS', 'signal-loss', 'An experimental mix drifting through broken transmissions and ambient tension.', 'Experimental', 'Track A, Track B, Track C', NULL, 'https://soundcloud.com/', 2700, 0, 1, 1, '2026-03-19 14:50:35', '2026-03-19 14:50:35'),
(3, 1, 'blackside', 'blackside', 'its a test', 'House', NULL, NULL, 'https://soundcloud.com/camouflybeats/corsica', 7200, 0, 1, 1, '2026-03-19 21:16:16', '2026-03-19 21:16:16');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `submission_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) NOT NULL,
  `artist_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `genre` varchar(100) NOT NULL,
  `media_url` varchar(500) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_feedback` text DEFAULT NULL,
  `reviewed_by` int(10) UNSIGNED DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`submission_id`, `user_id`, `title`, `artist_name`, `description`, `genre`, `media_url`, `status`, `admin_feedback`, `reviewed_by`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Midnight Transit', 'Demo Artist', 'A submission for review with a deep rolling club sound.', 'Techno', 'https://soundcloud.com/', 'approved', NULL, 1, '2026-04-04 10:59:01', '2026-03-19 14:50:35', '2026-04-04 10:59:01'),
(2, 3, 'Help me', 'Xu', 'techno and hard techno', 'techno', 'https://soundcloud.com/oddmob/albums', 'approved', NULL, 1, '2026-04-04 10:58:57', '2026-03-27 07:33:49', '2026-04-04 10:58:57'),
(3, 1, 'jjfheb', 'sdnasj', 'dsndb', 'techno', 'https://soundcloud.com/discover', 'rejected', NULL, 1, '2026-04-04 10:58:58', '2026-03-27 12:38:33', '2026-04-04 10:58:58'),
(4, 5, 'XXX Radio #182', 'Mau P', 'Find all tracklists here: 1001.tl/m1cbjm\r\n\r\nFrom the Amsterdam underground to the world, this is Mau P\'s weekly radioshow XXX Radio.\r\n\r\nFollow @realmaup to stay up to date with new episodes.', 'Tech House', 'https://soundcloud.com/realmaup/xxx-radio-182', 'approved', NULL, 1, '2026-04-05 20:23:35', '2026-04-05 20:20:04', '2026-04-05 20:23:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `username`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin@skhub.local', 'admin', '$2y$12$UUXeR/NmnDrGLhN1n8Uag.1iUZwPYPtZRKPHXpSpmUjPE9bF/VIy.', 'admin', '2026-03-19 14:50:35', '2026-03-19 16:42:43'),
(2, 'user@skhub.local', 'demo_user', '$2y$12$UUXeR/NmnDrGLhN1n8Uag.1iUZwPYPtZRKPHXpSpmUjPE9bF/VIy.', 'user', '2026-03-19 14:50:35', '2026-03-19 16:42:43'),
(3, 'jd.vandoorn@sk.hub.nl', 'skuppa', '$2y$12$6aY2nHXR21eQJQm3OYzT7.ZKNGWjjXE2g8qtEI4wvch/1nn8pQxsO', 'user', '2026-03-19 17:17:18', '2026-03-19 17:17:18'),
(4, 'demo-1@skuppa.nl', 'demo-1', '$2y$12$E7S9i8rx4kYSSGjJVFELve9IFwP31hN7vWJsZh2Y5HT9IQVVKFQ8a', 'user', '2026-04-04 11:52:31', '2026-04-04 11:52:31'),
(5, 'helpdesk@helpdesk.nl', 'helpdesk', '$2y$12$obvf46VcKv55A96U4wclDuSoxo4PXAMJvd/AD9dgozr1S8Qzs8vTm', 'user', '2026-04-05 20:17:16', '2026-04-05 20:17:16');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(10) UNSIGNED NOT NULL,
  `mix_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `vote_type` enum('like','dislike') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `mix_id`, `user_id`, `vote_type`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'like', '2026-03-19 14:50:35', '2026-03-19 14:50:35'),
(2, 2, 2, 'dislike', '2026-03-19 14:50:35', '2026-03-19 14:50:35'),
(10, 1, 1, 'like', '2026-03-27 05:41:14', '2026-03-27 05:41:14'),
(11, 2, 1, 'like', '2026-03-27 05:41:18', '2026-03-27 05:41:18'),
(20, 3, 1, 'like', '2026-04-05 20:15:56', '2026-04-05 20:15:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `idx_comments_mix_id` (`mix_id`),
  ADD KEY `idx_comments_user_id` (`user_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `idx_contact_messages_email` (`email`);

--
-- Indexes for table `mixes`
--
ALTER TABLE `mixes`
  ADD PRIMARY KEY (`mix_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_mixes_artist_id` (`artist_id`),
  ADD KEY `idx_mixes_created_by_user_id` (`created_by_user_id`),
  ADD KEY `idx_mixes_is_public` (`is_public`),
  ADD KEY `idx_mixes_slug` (`slug`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`submission_id`),
  ADD KEY `idx_submissions_user_id` (`user_id`),
  ADD KEY `idx_submissions_status` (`status`),
  ADD KEY `idx_submissions_reviewed_by` (`reviewed_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_users_email` (`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD UNIQUE KEY `uq_votes_mix_user` (`mix_id`,`user_id`),
  ADD KEY `idx_votes_mix_id` (`mix_id`),
  ADD KEY `idx_votes_user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `contact_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mixes`
--
ALTER TABLE `mixes`
  MODIFY `mix_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `submission_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_mix` FOREIGN KEY (`mix_id`) REFERENCES `mixes` (`mix_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mixes`
--
ALTER TABLE `mixes`
  ADD CONSTRAINT `fk_mixes_artist` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mixes_created_by_user` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `fk_submissions_reviewed_by` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_submissions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `fk_votes_mix` FOREIGN KEY (`mix_id`) REFERENCES `mixes` (`mix_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_votes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
