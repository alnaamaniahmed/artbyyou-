-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 12, 2023 at 12:14 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `artbyyou`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `AboutID` int(11) NOT NULL,
  `HomePage` text NOT NULL,
  `Story` text NOT NULL,
  `AboutImage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`AboutID`, `HomePage`, `Story`, `AboutImage`) VALUES
(1, 'We are a group of community artists who are dedicated to bringing art to our community. We display our work both to record community events and for sale.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus pretium augue nec dui elementum, ac tempor velit tempus.', 'img/AllArt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `ArtistID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `ArtistImage` varchar(50) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`ArtistID`, `Name`, `ArtistImage`, `Type`, `Description`) VALUES
(1, 'Pete Sanderson', 'files/artists/peteSanderson.jpg', 'Animals lover', 'Sed accumsan urna tempor bibendum tristique. Aliquam eget molestie lectus. Sed dui orci, auctor sagittis aliquet sed, dictum sit amet nunc. Cras enim neque, dignissim vel rhoncus a, tristique vitae diam'),
(2, 'Mary Major', 'files/artists/maryMajor.jpg', 'Photographer', 'Suspendisse ac odio nisl. Suspendisse nec nisl et lorem euismod ornare. Donec dictum tempor ipsum, a tincidunt tortor.'),
(3, 'Sue Kass', 'files/artists/sueKass.jpg', 'Painter/Photographer', 'Proin ut elit congue, tempus purus tristique, sagittis nisl. Donec elementum ipsum nec ex rhoncus, at convallis neque varius.'),
(4, 'Tina Vax', 'files/artists/tinaVax.jpg', 'Pottery', 'Aliquam cursus est eget odio iaculis convallis. In at consequat justo. Ut eros lectus, tempor ac placerat ac, facilisis sit amet diam.'),
(5, 'Alan Doyle', 'files/artists/alanDoyle.jpg', 'Photographer', 'Praesent iaculis enim sed odio sollicitudin, ac ultrices massa facilisis. Praesent congue pellentesque sollicitudin'),
(6, 'Carl Palmer', 'files/artists/carlPalmer.jpg', 'Textiles', 'Praesent iaculis enim sed odio sollicitudin, ac ultrices massa facilisis. Praesent congue pellentesque sollicitudin'),
(7, 'Jane Lester', 'files/artists/janeLester.jpg', 'Painter', 'Vestibulum dictum sollicitudin tortor id vulputate. Praesent interdum aliquet dapibus. Phasellus eget sagittis metus.'),
(8, 'Ibbie Eckart', 'files/artists/IbbieEckart.jpg', 'Photographer', 'Nunc blandit augue quis massa hendrerit condimentum. Integer bibendum massa arcu, eu hendrerit sem luctus vel.'),
(9, 'Ahmed Al-Naamani', 'files/artists/newArtist.jpg', 'Painter', 'I love painting and I have started painting a year ago.'),
(16, 'Ahmed AlNaamani2', 'files/artists/carlPalmer.jpg', 'Painter', 'I love painting about sport');

-- --------------------------------------------------------

--
-- Table structure for table `artwork`
--

CREATE TABLE `artwork` (
  `ArtID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `ArtImage` varchar(50) NOT NULL,
  `ThemeID` int(11) NOT NULL,
  `ArtistID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `artwork`
--

INSERT INTO `artwork` (`ArtID`, `Title`, `ArtImage`, `ThemeID`, `ArtistID`) VALUES
(1, 'Ocean view', 'files/water/ocean_view.jpg', 4, 2),
(2, 'deep ocean', 'files/water/ocean_view1.jpg', 4, 2),
(3, 'boat on the ocean', 'files/water/ocean_view2.jpg', 4, 2),
(4, 'colorful painting', 'files/paintings/colorful_kass.jpg', 6, 3),
(5, 'yellowish plant', 'files/paintings/jane_painting.jpg', 6, 7),
(6, 'pretty flowers', 'files/flowers/sue_flowers.jpg', 3, 3),
(7, 'orange flowers', 'files/flowers/sue_flowers1.jpg', 3, 3),
(8, 'pink flowers', 'files/flowers/sue_flowers2.jpg', 3, 3),
(9, 'bowls and plates', 'files/crafts/tina_pottery.jpg', 5, 4),
(10, 'beautiful pottery', 'files/crafts/tina_pottery1.jpg', 5, 4),
(11, 'perfection of pottery', 'files/crafts/tina_pottery2.jpg', 5, 4),
(12, 'smiles from pottery', 'files/crafts/tina_pottery3.jpg', 5, 4),
(13, 'special pottery', 'files/crafts/tina_pottery4.jpg', 5, 4),
(14, 'excellent crafts', 'files/crafts/tina_pottery5.jpg', 5, 4),
(15, 'cool pottery', 'files/crafts/alanPottery.jpg', 5, 5),
(16, 'cute rat', 'files/animals/rat-picture.jpg', 1, 6),
(17, 'eagle', 'files/animals/eagle-picture.jpg', 1, 1),
(18, 'skyscrapers', 'files/architecture/skyscrapers.jpg', 2, 8),
(19, 'Country view', 'files/architecture/country.jpg', 2, 8),
(20, 'fishy', 'files/animals/fish.jpg', 1, 6),
(21, 'Beautiful house', 'files/paintings/house.jpg', 6, 9),
(24, 'SportBeauty', 'files/paintings/painting1.jpg', 9, 16);

-- --------------------------------------------------------

--
-- Table structure for table `signin`
--

CREATE TABLE `signin` (
  `UserID` int(11) NOT NULL COMMENT ' ',
  `ArtistID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `signin`
--

INSERT INTO `signin` (`UserID`, `ArtistID`, `Username`, `Password`) VALUES
(1, 1, 'petes', 'abc123'),
(2, 2, 'marym', 'abc213'),
(3, 5, 'aland', 'smth123'),
(4, 3, 'suek', 'sue135'),
(5, 8, 'ibbiek', 'ibie123'),
(6, 7, 'janel', 'lester123'),
(7, 4, 'tinav', 'vax345'),
(8, 6, 'carlp', 'carlp123'),
(9, 9, 'alnaamani', 'ahmed123'),
(16, 16, 'ahmed22', '$2y$10$pNpiiCTDAFL6VVPZx3DC8.lo6Y5Ul0Jj/eU9IKpY1k6pJY5B6QZCS');

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `ThemeID` int(11) NOT NULL,
  `Theme` varchar(100) NOT NULL,
  `ThemeImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`ThemeID`, `Theme`, `ThemeImage`) VALUES
(1, 'Animals', 'files/animals/eagle-picture.jpg'),
(2, 'Architecture', 'files/architecture/skyscrapers.jpg'),
(3, 'Flowers', 'files/flowers/sue_flowers1.jpg'),
(4, 'Water', 'files/water/ocean_view.jpg'),
(5, 'Crafts', 'files/crafts/alanPottery.jpg'),
(6, 'Paintings', 'files/paintings/colorful_kass.jpg'),
(9, 'Sport', 'files/paintings/painting1.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`AboutID`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`ArtistID`);

--
-- Indexes for table `artwork`
--
ALTER TABLE `artwork`
  ADD PRIMARY KEY (`ArtID`),
  ADD KEY `ThemeID` (`ThemeID`),
  ADD KEY `ArtistID` (`ArtistID`);

--
-- Indexes for table `signin`
--
ALTER TABLE `signin`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `ArtistID` (`ArtistID`) USING BTREE;

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`ThemeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `AboutID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `ArtistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `artwork`
--
ALTER TABLE `artwork`
  MODIFY `ArtID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `signin`
--
ALTER TABLE `signin`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT ' ', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `ThemeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `signin`
--
ALTER TABLE `signin`
  ADD CONSTRAINT `fk_signin_artists` FOREIGN KEY (`ArtistID`) REFERENCES `artists` (`ArtistID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
