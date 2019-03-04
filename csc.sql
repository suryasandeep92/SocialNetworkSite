-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2018 at 06:32 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(100) NOT NULL,
  `posted_to` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
);

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(1, 'hi there', 'bala_surya', 'mani_krishna', '2018-10-07 02:13:47', 'no', 17),
(15, 'hello', 'bala_surya', 'bala_surya', '2018-11-13 05:43:13', 'no', 5),
(16, 'hey', 'bala_surya', 'mani_krishna', '2018-11-13 05:43:21', 'no', 4),
(17, 'hey', 'bala_surya', 'mani_krishna', '2018-11-13 05:43:32', 'no', 17),
(18, 'gud mrng', 'bala_surya', 'bala_surya', '2018-11-13 05:46:52', 'no', 2),
(19, 'hello', 'mani_krishna', 'mani_krishna', '2018-12-04 22:04:22', 'no', 17),
(20, 'yeah will do it', 'mansi_mistry', 'bala_surya', '2018-12-06 01:36:02', 'no', 5),
(21, '1', 'bala_surya', 'bala_surya', '2018-12-06 21:42:11', 'no', 2),
(22, '3', 'bala_surya', 'bala_surya', '2018-12-06 21:42:14', 'no', 2),
(23, '4', 'bala_surya', 'bala_surya', '2018-12-06 21:42:17', 'no', 2),
(24, '5', 'bala_surya', 'bala_surya', '2018-12-06 21:42:20', 'no', 2),
(25, '6', 'bala_surya', 'bala_surya', '2018-12-06 22:48:06', 'no', 2),
(26, '6', 'bala_surya', 'bala_surya', '2018-12-06 22:53:55', 'no', 2),
(27, 'era abbai', 'bala_surya', 'mani_krishna', '2018-12-08 15:06:41', 'no', 17),
(28, 'cheppara abbai', 'bala_surya', 'mani_krishna', '2018-12-12 00:33:53', 'no', 17),
(29, 'hey', 'bala_surya', 'mani_krishna', '2018-12-12 02:01:49', 'no', 17);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `request_made` varchar(200) NOT NULL,
  `request_accepted` varchar(200) NOT NULL
);

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `request_made`, `request_accepted`) VALUES
(8, 'mansi_mistry', 'bala_surya'),
(11, 'bala_surya', 'mani_krishna');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to` varchar(100) NOT NULL,
  `user_from` varchar(100) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `post_id` int(11) NOT NULL
);

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(1, 'mansi_mistry', 5),
(2, 'mansi_mistry', 3),
(3, 'mansi_mistry', 2),
(4, 'mani_krishna', 5),
(5, 'mani_krishna', 2),
(14, 'bala_surya', 4),
(21, 'mani_krishna', 17),
(22, 'mani_krishna', 4);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` varchar(100) NOT NULL,
  `user_from` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(6) NOT NULL,
  `viewed` varchar(6) NOT NULL,
  `deleted` varchar(6) NOT NULL
);

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(1, 'mani_krishna', 'bala_surya', 'hi ra', '2018-11-23 00:11:17', 'yes', 'yes', 'no'),
(2, 'bala_surya', 'mani_krishna', 'hi how are you', '2018-11-23 00:17:19', 'yes', 'yes', 'no'),
(15, 'mani_krishna', 'bala_surya', 'afafaf', '2018-11-23 00:18:58', 'yes', 'yes', 'no'),
(16, 'mansi_mistry', 'bala_surya', 'hi how are you', '2018-12-04 22:37:55', 'yes', 'yes', 'no'),
(17, 'bala_surya', 'mansi_mistry', 'hi there how are you', '2018-12-04 22:38:19', 'yes', 'yes', 'no'),
(18, 'bala_surya', 'mansi_mistry', 'yeah good\r\n', '2018-12-06 00:03:18', 'yes', 'yes', 'no'),
(19, 'mansi_mistry', 'bala_surya', 'hey ', '2018-12-06 00:05:19', 'yes', 'yes', 'no'),
(20, 'bala_surya', 'mansi_mistry', 'hey', '2018-12-06 00:07:12', 'yes', 'yes', 'no'),
(21, 'bala_surya', 'mani_krishna', 'oyre puka', '2018-12-08 15:07:46', 'yes', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_to` varchar(100) NOT NULL,
  `user_from` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL
);

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_to`, `user_from`, `message`, `link`, `datetime`, `opened`, `viewed`) VALUES
(1, 'bala_surya', 'mansi_mistry', 'Mansi Mistry liked your post', 'post.php?id=5', '2018-12-06 01:35:52', 'yes', 'yes'),
(3, 'bala_surya', 'mansi_mistry', 'Mansi Mistry liked your post', 'post.php?id=3', '2018-12-06 01:38:43', 'yes', 'yes'),
(4, 'bala_surya', 'mansi_mistry', 'Mansi Mistry liked your post', 'post.php?id=2', '2018-12-06 01:39:47', 'yes', 'yes'),
(5, 'bala_surya', 'mani_krishna', 'Mani Krishna liked your post', 'post.php?id=5&type=0', '2018-12-07 01:29:54', 'yes', 'yes'),
(6, 'bala_surya', 'mani_krishna', 'Mani Krishna liked your post', 'post.php?id=2&type=0', '2018-12-07 01:32:54', 'yes', 'yes'),
(7, 'mani_krishna', 'bala_surya', 'Bala Surya commented on your post', 'post.php?id=17&type=0', '2018-12-08 15:06:41', 'yes', 'yes'),
(8, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-09 21:11:16', 'yes', 'yes'),
(9, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-09 21:11:18', 'yes', 'yes'),
(10, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-09 21:11:20', 'yes', 'yes'),
(11, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-09 21:55:18', 'yes', 'yes'),
(12, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-09 21:55:40', 'yes', 'yes'),
(13, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=4&type=0', '2018-12-09 21:59:19', 'yes', 'yes'),
(14, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-09 22:45:42', 'yes', 'yes'),
(15, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-10 01:16:58', 'yes', 'yes'),
(16, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-10 01:17:00', 'yes', 'yes'),
(17, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-10 01:17:02', 'yes', 'yes'),
(18, 'mani_krishna', 'bala_surya', 'Bala Surya commented on your post', 'post.php?id=17&type=0', '2018-12-12 00:33:53', 'yes', 'yes'),
(19, 'mani_krishna', 'bala_surya', 'Bala Surya commented on your post', 'post.php?id=17&type=0', '2018-12-12 02:01:49', 'no', 'no'),
(20, 'mani_krishna', 'bala_surya', 'Bala Surya liked your post', 'post.php?id=17&type=0', '2018-12-12 02:02:03', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(100) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL
);

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `added_by`, `date_added`, `user_closed`, `deleted`, `likes`) VALUES
(1, 'hello', 'bala_surya', '2018-10-07 02:13:47', 'no', 'yes', 0),
(2, 'gud mrng', 'bala_surya', '2018-10-09 00:33:15', 'no', 'yes', 2),
(3, 'time to go to college', 'bala_surya', '2018-10-09 00:34:34', 'no', 'no', 1),
(4, 'hello surya ', 'mani_krishna', '2018-10-09 00:35:38', 'no', 'no', 2),
(5, 'next sprint will be in 3weeks, need to work on the tasks for every person individually', 'bala_surya', '2018-10-09 00:37:56', 'no', 'no', 2),
(17, 'hello', 'mani_krishna', '2018-11-09 01:08:24', 'no', 'no', 2),
(18, '1', 'bala_surya', '2018-12-12 01:18:19', 'no', 'yes', 0),
(19, '2', 'bala_surya', '2018-12-12 01:18:22', 'no', 'yes', 0),
(20, '3', 'bala_surya', '2018-12-12 01:18:26', 'no', 'yes', 0),
(21, '4', 'bala_surya', '2018-12-12 01:18:28', 'no', 'yes', 0),
(22, '5', 'bala_surya', '2018-12-12 01:28:17', 'no', 'yes', 0),
(23, '6', 'bala_surya', '2018-12-12 01:46:11', 'no', 'yes', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `student_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `student_id`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friend_array`) VALUES
(4, 'Bala', 'Surya', 'bala_surya', 'Bpasagadi1579@conestogac.on.ca', 8011579, '5f4dcc3b5aa765d61d8327deb882cf99', '2018-10-05', 'assets/images/profile_pics/bala_surya8f1cd382496d04df6618a723c854ab23n.jpeg', 2, 5, 'no', ','),
(5, 'Mani', 'Krishna', 'mani_krishna', 'Mani12344@conestogac.on.ca', 7654321, '5f4dcc3b5aa765d61d8327deb882cf99', '2018-10-09', 'assets/images/profile_pics/defaults/head_1.png', 2, 4, 'no', ','),
(6, 'Mansi', 'Mistry', 'mansi_mistry', 'Mansimistry1579@conestogac.on.ca', 1234567, '5f4dcc3b5aa765d61d8327deb882cf99', '2018-12-04', 'assets/images/profile_pics/defaults/head_1.png', 0, 0, 'no', ',');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
