-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 24, 2022 at 04:23 AM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Comp_Sci_IA_Project`
--
CREATE DATABASE IF NOT EXISTS `Comp_Sci_IA_Project` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `Comp_Sci_IA_Project`;

-- --------------------------------------------------------

--
-- Table structure for table `Auth_Users`
--
-- Creation: Aug 17, 2022 at 12:44 PM
--

DROP TABLE IF EXISTS `Auth_Users`;
CREATE TABLE IF NOT EXISTS `Auth_Users` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` text NOT NULL,
  `PassWord` text NOT NULL,
  `AdminStatus` text NOT NULL,
  `ProfilePic` text,
  `UserEmail` text NOT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `Auth_Users`
--

TRUNCATE TABLE `Auth_Users`;
--
--
-- Table structure for table `Ingredients`
--
-- Creation: Aug 14, 2022 at 06:31 PM
--

DROP TABLE IF EXISTS `Ingredients`;
CREATE TABLE IF NOT EXISTS `Ingredients` (
  `Ingredient_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ingredient_Name` text NOT NULL,
  `Count_Num` int(11) NOT NULL DEFAULT '0',
  `WeightG` int(11) NOT NULL DEFAULT '0',
  `Expiration_Date` date NOT NULL,
  PRIMARY KEY (`Ingredient_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `Ingredients`
--

TRUNCATE TABLE `Ingredients`;
--
--
-- Table structure for table `Junction_Rel`
--
-- Creation: Aug 14, 2022 at 06:31 PM
--

DROP TABLE IF EXISTS `Junction_Rel`;
CREATE TABLE IF NOT EXISTS `Junction_Rel` (
  `Junction_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Recipe_Ref` int(11) NOT NULL,
  `Ingredient_Ref` int(11) NOT NULL,
  PRIMARY KEY (`Junction_ID`),
  KEY `RecipeRef` (`Recipe_Ref`),
  KEY `IngredientsRef` (`Ingredient_Ref`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `Junction_Rel`
--

TRUNCATE TABLE `Junction_Rel`;
--
--
-- Table structure for table `Recipes`
--
-- Creation: Aug 17, 2022 at 11:22 AM
--

DROP TABLE IF EXISTS `Recipes`;
CREATE TABLE IF NOT EXISTS `Recipes` (
  `Recipe_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Dish_Name` text NOT NULL,
  `Sufficient_Ingredients` tinyint(1) NOT NULL,
  `Cooking_Time` int(11) NOT NULL,
  `Ratings` decimal(10,0) NOT NULL DEFAULT '0',
  `Last_Cooked` date DEFAULT NULL,
  `Calories` int(11) NOT NULL,
  `Recipe_Tags` text,
  `Recipe_Description` mediumtext NOT NULL,
  `Recipe_Image` text,
  `Methodology` longtext NOT NULL,
  PRIMARY KEY (`Recipe_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `Recipes`
--

TRUNCATE TABLE `Recipes`;
--
--
-- Table structure for table `Recipe_Tags`
--
-- Creation: Aug 14, 2022 at 06:31 PM
--

DROP TABLE IF EXISTS `Recipe_Tags`;
CREATE TABLE IF NOT EXISTS `Recipe_Tags` (
  `Tag_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tag_Name` text,
  PRIMARY KEY (`Tag_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `Recipe_Tags`
--

TRUNCATE TABLE `Recipe_Tags`;
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
