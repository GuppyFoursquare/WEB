-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 20, 2008 at 08:55 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `cake`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `comments`
-- 

CREATE TABLE `comments` (
  `id` int(11) NOT NULL auto_increment,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) collate latin1_general_ci NOT NULL,
  `email` varchar(255) collate latin1_general_ci NOT NULL,
  `text` text collate latin1_general_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `comments`
-- 

INSERT INTO `comments` (`id`, `post_id`, `name`, `email`, `text`, `created`) VALUES 
(1, 1, 'James', 'info@jamesfairhurst.co.uk', 'This is a sample comment.', '0000-00-00 00:00:00'),
(2, 1, 'James', 'info@jamesfairhurst.co.uk', 'This is another sample comment.', '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Table structure for table `posts`
-- 

CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(50) collate latin1_general_ci default NULL,
  `body` text collate latin1_general_ci,
  `image_url` varchar(255) collate latin1_general_ci NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `posts`
-- 

INSERT INTO `posts` (`id`, `title`, `body`, `image_url`, `created`, `modified`) VALUES 
(1, 'The title', 'This is the post body.', '', '2007-12-28 13:54:34', NULL),
(2, 'A title once again', 'And the post body follows.', '', '2007-12-28 13:54:34', NULL),
(3, 'Title strikes back', 'This is really exciting! Not. edit', '', '2007-12-28 13:54:34', '2008-02-19 18:51:52'),
(4, 'Test Title', 'Test body text', 'img/files/15_zamri.jpg', '2008-02-20 19:54:02', '2008-02-20 19:54:02'),
(5, 'aaa', 'aaa', 'img/files/deckofdeath.jpg', '2008-02-20 20:00:49', '2008-02-20 20:00:49');

-- --------------------------------------------------------

-- 
-- Table structure for table `posts_tags`
-- 

CREATE TABLE `posts_tags` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `posts_tags`
-- 

INSERT INTO `posts_tags` (`post_id`, `tag_id`) VALUES 
(3, 3),
(4, 1),
(5, 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `tags`
-- 

CREATE TABLE `tags` (
  `id` int(11) NOT NULL auto_increment,
  `tag` varchar(100) collate latin1_general_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `tags`
-- 

INSERT INTO `tags` (`id`, `tag`, `created`, `modified`) VALUES 
(1, 'General', '2008-02-11 18:39:27', '2008-02-11 18:39:27'),
(2, 'Programming', '2008-02-11 18:39:33', '2008-02-11 18:39:33'),
(3, 'Films', '2008-02-11 18:39:37', '2008-02-11 18:39:45');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) collate latin1_general_ci NOT NULL,
  `password` varchar(255) collate latin1_general_ci NOT NULL,
  `last_login` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`id`, `username`, `password`, `last_login`) VALUES 
(1, 'admin', 'acae4c9e83e53b63ffc7740215898a65', '2008-01-28 19:15:26');
