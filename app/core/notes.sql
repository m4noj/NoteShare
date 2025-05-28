-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 04:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notes`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `likes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `likes`, `created_at`) VALUES
(1, 10, 14, 'very informative for Data Visualization.', 0, '2025-03-23 16:05:44'),
(2, 6, 14, 'very nice post for KNN', 0, '2025-03-23 16:05:44'),
(3, 10, 1, 'Data Visualization explained easily', 0, '2025-03-23 16:06:46'),
(4, 7, 1, 'good post on clustering methods.', 0, '2025-03-23 16:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `communities`
--

CREATE TABLE `communities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `experts` int(11) NOT NULL DEFAULT 0,
  `logo` varchar(255) NOT NULL DEFAULT 'default-logo.jpg',
  `creator_id` int(11) NOT NULL,
  `type` enum('public','private','invite-only') DEFAULT 'public',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `communities`
--

INSERT INTO `communities` (`id`, `name`, `description`, `experts`, `logo`, `creator_id`, `type`, `created_at`) VALUES
(1, 'Computer Science', 'a friendly community for computer science students.', 0, 'default-logo.jpg', 1, 'public', '2025-03-17 08:19:22'),
(2, 'Machine Learning', 'community for Machine Learning Students', 0, 'default-logo.jpg', 1, 'public', '2025-03-17 08:19:22'),
(9, 'Physics', 'physics community', 0, 'default-logo.jpg', 1, 'public', '2025-03-17 09:33:35'),
(13, 'Mathematics', 'This is a community for maths students and enthusiasts', 0, 'default-logo.jpg', 1, 'private', '2025-03-17 09:35:33'),
(14, 'Scholars', 'This is a invite only community for all the scholars and experts in their fields', 0, 'default-logo.jpg', 1, 'invite-only', '2025-03-17 09:36:19'),
(16, 'Science', 'science community', 0, 'default-logo.jpg', 1, 'public', '2025-03-17 09:41:40'),
(35, 'Data Science', 'Community for Data Science Learners.', 0, 'default-logo.jpg', 14, 'public', '2025-03-21 16:17:06'),
(36, 'Artificial Intelligence', 'community for AI (Artificial Intelligence) students and learners. ', 0, 'CommunityLogo__iron.jpg', 1, 'public', '2025-03-21 16:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `community_members`
--

CREATE TABLE `community_members` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `community_id` int(11) NOT NULL,
  `role` enum('member','moderator','admin') DEFAULT 'member',
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_members`
--

INSERT INTO `community_members` (`id`, `user_id`, `community_id`, `role`, `joined_at`) VALUES
(1, 1, 1, 'admin', '2025-03-21 17:56:22'),
(2, 1, 2, 'admin', '2025-03-21 17:56:22'),
(3, 14, 1, 'member', '2025-03-22 08:56:53'),
(4, 14, 2, 'member', '2025-03-22 08:56:53'),
(5, 1, 36, 'admin', '2025-03-22 08:57:50'),
(6, 1, 35, 'moderator', '2025-03-22 08:57:50');

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `expert_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `community` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `postimg` varchar(255) NOT NULL DEFAULT 'userPost__default.jpg',
  `file` varchar(255) DEFAULT NULL,
  `upvotes` int(11) NOT NULL DEFAULT 0,
  `downvotes` int(11) DEFAULT 0,
  `comments` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `description`, `community`, `tags`, `content`, `postimg`, `file`, `upvotes`, `downvotes`, `comments`, `created_at`) VALUES
(1, 1, 'Machine Learning for beginners', 'this post teachers machine learning for beginners.', 1, 'Machine Learning', 'this is the content of this machine learrning for beginners post. ', 'userPost__default.jpg', 'userFile_', 0, 0, 2, '2025-03-17 11:44:15'),
(2, 1, 'Machine Learning for Experts', 'this post explains ML for Expert Level', 2, 'Machine Learning, Artificial Intelligence', 'expert level Machine learning posts.', 'userPost__default.jpg', 'userFile_', 0, 0, 0, '2025-03-17 11:48:33'),
(3, 1, 'PHP Developememnt', 'php development', 1, 'php, lamp', 'post for php developers', 'userPost__default.jpg', 'userFile_shivam cv 2024.docx', 0, 0, 0, '2025-03-17 11:50:06'),
(4, 1, 'java', 'java', 2, 'java', 'java', 'userPost__default.jpg', NULL, 0, 0, 0, '2025-03-17 11:54:10'),
(5, 14, 'Deep Learning', 'this post teaches deep learning', 1, 'ML', 'Learn how to build a PHP MVC framework from scratch. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi eveniet officia necessitatibus? Corrupti incidunt, blanditiis voluptate commodi, cum magni consectetur placeat enim ipsam numquam veniam reiciendis, excepturi eos deleniti ipsa?\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam fuga aliquam velit explicabo qui necessitatibus voluptatum, esse optio ducimus. Architecto incidunt nulla ab repellat fugit pariatur quam dolore perspiciatis omnis.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum excepturi magnam voluptas inventore fugit eius, rem fuga, eum molestias quia aliquam ipsum dignissimos amet eos illum nam esse perspiciatis sint!\n                   Learn how to build a PHP MVC framework from scratch. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi eveniet officia necessitatibus? Corrupti incidunt, blanditiis voluptate commodi, cum magni consectetur placeat enim ipsam numquam veniam reiciendis, excepturi eos deleniti ipsa?\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam fuga aliquam velit explicabo qui necessitatibus voluptatum, esse optio ducimus. Architecto incidunt nulla ab repellat fugit pariatur quam dolore perspiciatis omnis.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum excepturi magnam voluptas inventore fugit eius, rem fuga, eum molestias quia aliquam ipsum dignissimos amet eos illum nam esse perspiciatis sint!\n                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eaque recusandae, tempora odit beatae quisquam iste, veniam dolorem ut veritatis earum saepe ipsa perspiciatis sequi architecto ipsam consequatur rem, itaque nostrum.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores alias deleniti fuga minima repellendus similique itaque consectetur libero enim recusandae ea sunt, a quae facere aspernatur magnam quo excepturi rerum.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. In temporibus ducimus fugiat modi porro ipsa, dolorem molestias quaerat. Minus vel veritatis necessitatibus fugiat, sint numquam tenetur dolor aut corporis expedita.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum quam beatae sed non aspernatur dolorem distinctio, eius animi, recusandae illum eos optio obcaecati magni soluta culpa reprehenderit aliquam minus natus!\n                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia, neque. Expedita exercitationem minima accusantium suscipit enim voluptatem laboriosam blanditiis consequuntur, ipsam molestias perferendis, voluptatum est id repellendus excepturi! Provident, sunt.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus qui architecto fugit quisquam molestias. Laborum, corrupti earum. Recusandae similique inventore enim, dolore a ab odit, voluptas distinctio ad reiciendis mollitia?\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum labore dolorem, impedit odio harum ex distinctio quidem assumenda pariatur animi ipsam quaerat quam modi culpa, provident error laudantium nobis dolorum.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic, unde vitae. Deserunt, blanditiis. Nesciunt, accusantium minima. Neque laboriosam possimus provident ad odio dolorem, minus delectus reprehenderit optio ratione sit minima!\n                    \n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. In temporibus ducimus fugiat modi porro ipsa, dolorem molestias quaerat. Minus vel veritatis necessitatibus fugiat, sint numquam tenetur dolor aut corporis expedita.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum quam beatae sed non aspernatur dolorem distinctio, eius animi, recusandae illum eos optio obcaecati magni soluta culpa reprehenderit aliquam minus natus!\n                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia, neque. Expedita exercitationem minima accusantium suscipit enim voluptatem laboriosam blanditiis consequuntur, ipsam molestias perferendis, voluptatum est id repellendus excepturi! Provident, sunt.\n                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus qui architecto fugit quisquam molestias. Laborum, corrupti earum. Recusandae similique inventore enim, dolore a ab odit, voluptas distinctio ad reiciendis mollitia?\n                    ', 'userPost__default.jpg', 'userFile__avatar_WIN_20250310_12_52_34_Pro.jpg', 0, 0, 0, '2025-03-18 17:25:33'),
(6, 1, 'K-nearest Neighbours', 'teaches K-nearest Neighbours', 2, 'KNN', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi at consectetur provident deserunt nam labore similique, itaque tenetur, \r\nexercitationem deleniti dolor quos. Enim dignissimos consectetur, repellendus suscipit corporis in perspiciatis?\r\nReiciendis delectus deserunt at aspernatur quidem nesciunt unde nam distinctio quam, asperiores omnis illum quisquam Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti ab odit vitae \r\n\r\nnulla pariatur maiores! Voluptas aliquam voluptatibus accusantium omnis nam cumque, officiis unde atque perferendis eius esse, repellat veritatis?\r\nexcepturi aliquam eveniet, atque accusantium deleniti molestias.\r\ndicta perspiciatis laborum eos est vero, dolorum in non praesentium ullam neque vel sint saepe! Fuga accusamus cupiditate ut temporibus facilis!\r\n\r\nconsectetur adipisicing elit. Voluptas, aperiam sint. Aperiam sint natus amet iusto explicabo accusamus, assumenda placeat Lorem ipsum dolor sit amet consectetur, adipisicing elit. \r\nAb natus, Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque facilis recusandae excepturi beatae molestiae accusamus velit dolorem, nesciunt aperiam repellendus \r\nperspiciatis qui eveniet culpa quae alias minima at fuga deleniti!', 'userPost__FIRST PHASE.docx', 'userFile__FIRST PHASE.docx', 0, 0, 0, '2025-03-18 20:12:56'),
(7, 14, 'Clustering', 'clustering in Machine learning', 2, 'ML', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi at consectetur provident deserunt nam labore similique, itaque tenetur, \r\nexercitationem deleniti dolor quos. Enim dignissimos consectetur, repellendus suscipit corporis in perspiciatis?\r\nReiciendis delectus deserunt at aspernatur quidem nesciunt unde nam distinctio quam, asperiores omnis illum quisquam Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti ab odit vitae \r\n\r\nnulla pariatur maiores! Voluptas aliquam voluptatibus accusantium omnis nam cumque, officiis unde atque perferendis eius esse, repellat veritatis?\r\nexcepturi aliquam eveniet, atque accusantium deleniti molestias.\r\ndicta perspiciatis laborum eos est vero, dolorum in non praesentium ullam neque vel sint saepe! Fuga accusamus cupiditate ut temporibus facilis!\r\n\r\nconsectetur adipisicing elit. Voluptas, aperiam sint. Aperiam sint natus amet iusto explicabo accusamus, assumenda placeat Lorem ipsum dolor sit amet consectetur, adipisicing elit. \r\nAb natus, Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque facilis recusandae excepturi beatae molestiae accusamus velit dolorem, nesciunt aperiam repellendus \r\nperspiciatis qui eveniet culpa quae alias minima at fuga deleniti!', 'userPost__userPost__default.jpg', 'userFile__MCA FORM.pdf', 0, 0, 0, '2025-03-18 20:20:31'),
(10, 14, 'Data Visualization', 'learning data visualization in R', 35, 'Data Visualization, Data Science', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi at consectetur provident deserunt nam labore similique, itaque tenetur, \r\nexercitationem deleniti dolor quos. Enim dignissimos consectetur, repellendus suscipit corporis in perspiciatis?\r\nReiciendis delectus deserunt at aspernatur quidem nesciunt unde nam distinctio quam, asperiores omnis illum quisquam Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti ab odit vitae \r\n\r\nnulla pariatur maiores! Voluptas aliquam voluptatibus accusantium omnis nam cumque, officiis unde atque perferendis eius esse, repellat veritatis?\r\nexcepturi aliquam eveniet, atque accusantium deleniti molestias.\r\ndicta perspiciatis laborum eos est vero, dolorum in non praesentium ullam neque vel sint saepe! Fuga accusamus cupiditate ut temporibus facilis!\r\n\r\nconsectetur adipisicing elit. Voluptas, aperiam sint. Aperiam sint natus amet iusto explicabo accusamus, assumenda placeat Lorem ipsum dolor sit amet consectetur, adipisicing elit. \r\nAb natus, Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque facilis recusandae excepturi beatae molestiae accusamus velit dolorem, nesciunt aperiam repellendus \r\nperspiciatis qui eveniet culpa quae alias minima at fuga deleniti!\r\n\r\nReiciendis delectus deserunt at aspernatur quidem nesciunt unde nam distinctio quam, asperiores omnis illum quisquam Lorem ipsum dolor sit amet consectetur, adipisicing elit. \r\nCorrupti ab odit vitae nulla pariatur maiores! Voluptas aliquam voluptatibus accusantium omnis nam cumque, officiis unde atque perferendis eius esse, repellat veritatis?\r\ntemporibus enim blanditiis unde doloremque fuga debitis totam corrupti, aliquid doloribus voluptates nemo sapiente incidunt. Incidunt similique tempore nostrum eveniet?\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius praesentium laborum sed illum asperiores qui laboriosam assumenda \r\n\r\ntotam sapiente molestiae eligendi consequuntur ullam dolorem alias, hic repudiandae rerum et odit.\r\nexcepturi aliquam eveniet, atque accusantium deleniti molestias.\r\n\r\nmaiores suscipit eligendi ratione laudantium distinctio minima iste tempora. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Harum, adipisci omnis. Illo aperiam, quod illum, \r\nvoluptatem consequuntur quae quos assumenda aut odio modi fuga expedita amet quia, distinctio ipsam tempora.\r\ndicta perspiciatis laborum eos est vero, dolorum in non praesentium ullam neque vel sint saepe! Fuga accusamus cupiditate ut temporibus facilis!\r\ntemporibus enim blanditiis unde doloremque fuga debitis totam corrupti, aliquid doloribus voluptates nemo sapiente incidunt. Incidunt similique tempore nostrum eveniet?\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius praesentium laborum sed illum asperiores qui laboriosam assumenda totam \r\nsapiente molestiae eligendi consequuntur ullam dolorem alias, hic repudiandae rerum et odit.', 'userPost__avatar_avatar_avatar_RDT_20240505_0708322173105094607674996[1].jpg', 'userFile__116800884_ExamForm.PDF', 0, 0, 0, '2025-03-21 16:20:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first` varchar(100) NOT NULL,
  `last` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('student','expert') DEFAULT 'student',
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'default.png',
  `joined` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first`, `last`, `username`, `email`, `role`, `password`, `bio`, `avatar`, `joined`) VALUES
(1, 'Manoj', 'Borkar', 'm4noj', 'manoj@gmail.com', 'expert', '$2y$10$vsYkcQvkBeQOJ2kvUjLiQu/glHY8JLyG3Xe5l0c29lxzfHRpjU3o6', 'I\'m the Best!!', 'default-avatar.jpg', '2025-03-12 10:57:39'),
(14, 'Ashish', 'Patil', 'ashishhk', 'ashish@info.com', 'student', '$2y$10$CQG9XIv4CApDsdUx20U5S.i.W9eXn5woV8dJDPPLrO6qOgs1pjrrK', 'cool bio', 'default-avatar.jpg', '2025-03-14 20:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `vote_type` enum('up','down') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comment_id` (`comment_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `creator_id` (`creator_id`);

--
-- Indexes for table `community_members`
--
ALTER TABLE `community_members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`community_id`),
  ADD KEY `community_id` (`community_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `follower_id` (`follower_id`,`expert_id`),
  ADD KEY `expert_id` (`expert_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `friend_id` (`friend_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `community` (`community`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `communities`
--
ALTER TABLE `communities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `community_members`
--
ALTER TABLE `community_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `comment_likes_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `communities`
--
ALTER TABLE `communities`
  ADD CONSTRAINT `communities_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `community_members`
--
ALTER TABLE `community_members`
  ADD CONSTRAINT `community_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `community_members_ibfk_2` FOREIGN KEY (`community_id`) REFERENCES `communities` (`id`);

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`expert_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`community`) REFERENCES `communities` (`id`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
