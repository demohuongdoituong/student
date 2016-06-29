-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 29, 2016 at 06:54 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gallerysite`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `images_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `images_typeID` tinyint(3) unsigned NOT NULL,
  `images_title` varchar(120) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `images_date` date NOT NULL,
  `images_userID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`images_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`images_id`, `images_typeID`, `images_title`, `images_date`, `images_userID`) VALUES
(1, 1, 'Abstrac', '2011-12-14', 1),
(2, 1, 'Life', '2011-12-14', 1),
(3, 1, 'Virus', '2011-12-14', 1),
(5, 1, 'Butterfly', '2011-12-14', 1),
(6, 1, 'Flow', '2011-12-14', 1),
(7, 1, 'Nature', '2011-12-14', 1),
(9, 1, 'Cassie', '2011-12-14', 6),
(10, 1, 'DJ', '2011-12-14', 6),
(52, 5, 'Process', '2016-06-29', 7),
(49, 1, 'mây ngũ sắc', '2016-06-29', 6),
(50, 4, 'Lớp Học', '2016-06-29', 6),
(46, 4, 'thiên nhiên Việt Nam', '2016-06-28', 6),
(44, 4, 'SuShi Nhật Bản', '2016-06-28', 6),
(43, 2, 'Hoa Hồng', '2016-06-28', 6);

-- --------------------------------------------------------

--
-- Table structure for table `typeimage`
--

CREATE TABLE IF NOT EXISTS `typeimage` (
  `typeimage_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `typeimage_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`typeimage_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `typeimage`
--

INSERT INTO `typeimage` (`typeimage_id`, `typeimage_name`) VALUES
(1, 'Nghệ thuật'),
(2, 'Thiên nhiên / phong cảnh'),
(3, 'Gia Đình'),
(4, 'Văn hóa'),
(5, 'Web template');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL,
  `user_pass` varchar(40) NOT NULL,
  `user_fullname` varchar(40) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_website` varchar(60) DEFAULT NULL,
  `user_level` tinyint(1) NOT NULL DEFAULT '2',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pass`, `user_fullname`, `user_email`, `user_website`, `user_level`) VALUES
(7, 'ductoan', 'toan123', 'phan duc toan', 'toanpdpd01147@fpt.edu.vn', 'toan.com', 2),
(6, 'chienhuu', 'chien123', 'Dinh Huu Chien', 'chiendhpd01156@fpt.edu.vn', 'chiendhpd01156.com.vn', 2),
(1, 'chiendinh', 'chien123', 'Đinh Hữu Chiến', 'chiendinh@gmail.com', 'chiendinh.com', 1),
(8, 'minhphong', 'phong123', 'hoang minh phong', 'phonghmpd00878@fpt.edu.vn', 'phong.com', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
