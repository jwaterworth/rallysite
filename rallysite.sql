-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2014 at 11:22 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rallysite`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password` varchar(255) NOT NULL,
  `userSalt` varchar(75) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `emergName` varchar(255) NOT NULL,
  `emergAddress` text NOT NULL,
  `emergPhone` varchar(20) NOT NULL,
  `dietaryReq` text NOT NULL,
  `medicalCond` text NOT NULL,
  `accountTypeID` int(11) NOT NULL,
  `clubID` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `password`, `userSalt`, `name`, `dateOfBirth`, `email`, `phoneNumber`, `emergName`, `emergAddress`, `emergPhone`, `dietaryReq`, `medicalCond`, `accountTypeID`, `clubID`, `address`) VALUES
(10, 'bb40605897b17898f65f40b5c6626c2f4e82b04bc8f1bce08fe4f5a082471da6fb418e6de6f38b833efa190ff708b1e6373cedcac036c86ce8cb5f265fd6e47a', 'cakzqf5ou72or2xth9pnjgp6vpeon8bn9l4zbk989avqjrwvn8', 'James Waterworth', '0000-00-00', 'j.waterworth1990@gmail.com', '07511914561', 'Catherine Waterworth', '17 Needham Avenue', '17 Needham Avenue', 'None', 'None', 15, 1, '1 Orston Lane, Whatton, Nottinghamshire, NG13 9ET'),
(11, '2aff5372d51e2cfce0ccf0e1a0316497bc7e3967d35903366e23f40d1be8f9c689e5db0196ffbaddb300bde300a4bfb85f5464b2be6777f7152a425e1d461938', 'vcapplqscz7qe90nbqpkcnsbgblaovxv6fdy9ajtsfvgkhyk0f', 'Megan Jones', '0000-00-00', 'megansjones1988@gmail.com', '07511914562', 'Sarah', 'Inglenook', '07511914562', 'None', 'None', 2, 1, '1 Orston Lane');

-- --------------------------------------------------------

--
-- Table structure for table `accounttype`
--

CREATE TABLE IF NOT EXISTS `accounttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountTypeName` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `accounttype`
--

INSERT INTO `accounttype` (`id`, `accountTypeName`) VALUES
(0, 'Unapproved'),
(1, 'Member'),
(2, 'Club Representative'),
(4, 'Event Executive'),
(8, 'SSAGO Executive'),
(15, 'All Types');

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activityName` varchar(50) NOT NULL,
  `activityDescription` varchar(250) NOT NULL,
  `activityCost` decimal(10,0) NOT NULL,
  `activityCapacity` int(11) NOT NULL,
  `activityImageLoc` varchar(250) NOT NULL,
  `activityPageID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `activityName`, `activityDescription`, `activityCost`, `activityCapacity`, `activityImageLoc`, `activityPageID`) VALUES
(4, 'Afternoon off ', 'Got your own puzzling to do?  Take the afternoon off to mull things over', '0', 0, '', 1),
(5, 'Climbing', 'Take to the walls and play some puzzle based climbing games, climbing instructors provided and bouldering will also occur', '12', 15, '', 1),
(6, 'Geocaching', 'Itâ€™s a walk with puzzles built in.  Wander through some lovely scenery and solve the clues to find the caches.  And of course, there will be a rather delightful pub along the way', '0', 30, '', 1),
(7, 'Gin Distillery Tour', 'A trip to 45 Westâ€™s distillery in Nanpantan!  Unravel the mystery of gin making.', '20', 14, '', 1),
(8, 'Great Central Railway', 'Take a trip along the UKâ€™s only double track, main line heritage railway.  And what better way to pass some time on your journey than a puzzle book or two?', '30', 30, '', 1),
(9, 'Murder Mystery', 'A murder has been committed, but by who?  As well as finding out the identity of the murderer, you will have your own goals to achieve as you make your characters your own', '30', 40, '', 1),
(10, 'National Space Centre', 'Space.  The final frontier.  There will be various small challenges to complete at the National Space Centre', '30', 30, '', 1),
(11, 'Pub Quest', 'Solve clues to follow a trail of some of Loughboroughâ€™s finest pubs', '0', 15, '', 1),
(12, 'Pub Quiz Crawl', 'As you make your way through a selection of Loughboroughâ€™s pubs, why not accompany your round with a round?', '0', 15, '', 1),
(13, 'Puzzle Box', 'You are trapped in a room with no easy way out.  There are strange things afoot.  Can you escape the puzzle box?', '0', 10, '', 1),
(14, 'Puzzle Crafts', 'Making your own puzzles.  Thatâ€™s the dream.  Try your hand at some of the puzzle crafts we have picked out', '0', 30, '', 1),
(15, 'Puzzlersâ€™ Corner', 'Just want to rest for a bit?  Sit down and enjoy an afternoon of jigsaws, Rubikâ€™s cubes and dingbats', '0', 30, '', 1),
(16, 'Spy Mission', 'Someone is planning to upset the delicate balance of rally.  Your mission, should you choose to accept it, is to snoop around, talk covertly to our contacts and find out whatâ€™s going on.', '0', 30, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `activitypage`
--

CREATE TABLE IF NOT EXISTS `activitypage` (
  `id` int(11) NOT NULL,
  `activitiesBrief` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activitypage`
--

INSERT INTO `activitypage` (`id`, `activitiesBrief`) VALUES
(1, 'Changes to activities will not be permitted via the online booking system. If you require an activity change please contact us  with an explanation as to why you need to change activity.');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `bookingFee` decimal(10,0) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `userID`, `bookingFee`, `paid`) VALUES
(2, 10, '65', 0),
(3, 11, '65', 0),
(4, 10, '42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bookingactivity`
--

CREATE TABLE IF NOT EXISTS `bookingactivity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bookingID` int(11) NOT NULL,
  `activityID` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bookingactivity`
--

INSERT INTO `bookingactivity` (`id`, `bookingID`, `activityID`, `priority`) VALUES
(1, 2, 1, 1),
(2, 3, 2, 1),
(3, 4, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookingfoodchoice`
--

CREATE TABLE IF NOT EXISTS `bookingfoodchoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foodchoiceid` int(11) NOT NULL,
  `bookingid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `bookingfoodchoice`
--

INSERT INTO `bookingfoodchoice` (`id`, `foodchoiceid`, `bookingid`) VALUES
(1, 0, 2),
(2, 0, 2),
(3, 0, 2),
(4, 0, 3),
(5, 0, 3),
(6, 0, 3),
(7, 0, 4),
(8, 0, 4),
(9, 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `bookinginfo`
--

CREATE TABLE IF NOT EXISTS `bookinginfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bookingSummary` text NOT NULL,
  `bookingInfo` text NOT NULL,
  `paymentAddress` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bookinginfo`
--

INSERT INTO `bookinginfo` (`id`, `bookingSummary`, `bookingInfo`, `paymentAddress`) VALUES
(1, 'Confirmation of booking will be shown via the website booking page. If you feel that there is an error in your booking please email us.', 'If there are any special dietary requirements and/or medical conditions that could affect you please ensure that these are recorded when you book so we can accommodate these needs prior to the event beginning.\r\nNotification of dietary requirements and / or medical conditions at the start of the event can lead to embarrassment and the organisers accept no responsibility for being unable to provide suitable provisions at this late stage of notification.', '');

-- --------------------------------------------------------

--
-- Table structure for table `club`
--

CREATE TABLE IF NOT EXISTS `club` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logoLoc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `club`
--

INSERT INTO `club` (`id`, `name`, `logoLoc`) VALUES
(1, 'Loughborough Scogui', '');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `eventSummary` text NOT NULL,
  `eventInformation` text NOT NULL,
  `eventLogoLoc` varchar(255) NOT NULL,
  `bookingInfoID` int(11) NOT NULL,
  `activityPageID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `eventName`, `eventSummary`, `eventInformation`, `eventLogoLoc`, `bookingInfoID`, `activityPageID`) VALUES
(1, 'Puzzle Rally', 'Loughborough Puzzle Rally.  Thereâ€™s always another puzzle!!\r\n\r\nContact Us\r\n\r\nIf you have any questions, or you want to buy a quiz or badges, let us know via one of the following mediums:\r\nEmail â€“ loughboroughrallycommittee@gmail.com\r\nFacebook â€“ https://www.facebook.com/groups/226287437568791/\r\nBack of a postcard â€“ Tom Chamberlain, 3 Sherwood Court, Long Whatton, Loughborough, LE12 5DY\r\n', 'Badges and Quizzes (Bad Zen Squid Gazes)\r\n\r\nFrances to provide\r\n\r\nDrinking Policy (Kingly Drip Icon)\r\nExec are producing an official one\r\n\r\nIndie Members (Embers in Dime)\r\nIf youâ€™re an indie member, you donâ€™t have a club committee to organise the trip for you.  Maybe we can help.  Let us know where youâ€™re travelling from and weâ€™ll see if thereâ€™s anyone who you could share your journey with.  If you need tent space, or are going to have too much, let us know and weâ€™ll see if we can solve those problems too!  And itâ€™s entirely possible that we can help if you have any questions about rally, particularly if this is your first one!\r\n\r\nNew to Rally? (Worn Lately?)\r\nIf this is your first rally, welcome!  If you have any questions relating to rally, and canâ€™t get a straight answer from anyone else, feel free to ask us!\r\n\r\nWeekly Challenge (Regally Keen Chew)\r\nEach week a new puzzle will be added\r\n\r\nWeek 1 â€“ Codebreaker \r\nWeek 2 â€“ Phrase Initials \r\nWeek 3 â€“ Riddles \r\nWeek 4 â€“ Word Spiral\r\nWeek 5 â€“ Anagrams\r\nWeek 6 â€“ Sudoku\r\nWeek 7 â€“ Crossword\r\nWeek 8 â€“ Wordsearch\r\nWeek 9 â€“ Logic Puzzle\r\nWeek 10 â€“ Dingbats\r\nWeek 11 â€“ Photo Phrases\r\nWeek 12 â€“ The Final Puzzle\r\n', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE IF NOT EXISTS `fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fee` double NOT NULL,
  `deadline` date NOT NULL,
  `bookingInfoID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `fee`, `deadline`, `bookingInfoID`) VALUES
(2, 25, '2014-11-08', 1),
(3, 28, '2014-11-12', 1),
(4, 30, '2014-11-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `foodchoice`
--

CREATE TABLE IF NOT EXISTS `foodchoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `foodTypeID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `foodchoice`
--

INSERT INTO `foodchoice` (`id`, `name`, `notes`, `foodTypeID`) VALUES
(1, 'Ham Sandwich', 'Non veggy', 1),
(2, 'Spaghetti Bolognese', 'Veggy/Non Veggy', 2),
(3, 'Cheese Sandiwch', 'Veggy', 3);

-- --------------------------------------------------------

--
-- Table structure for table `foodtype`
--

CREATE TABLE IF NOT EXISTS `foodtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foodTypeName` varchar(50) NOT NULL,
  `bookingInfoID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `foodtype`
--

INSERT INTO `foodtype` (`id`, `foodTypeName`, `bookingInfoID`) VALUES
(1, 'Saturday Lunch', 1),
(2, 'Saturday Dinner', 1),
(3, 'Sunday Lunch', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newspost`
--

CREATE TABLE IF NOT EXISTS `newspost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsTitle` varchar(255) NOT NULL,
  `newsBody` text NOT NULL,
  `newsTimeStamp` date NOT NULL,
  `userID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `newspost`
--

INSERT INTO `newspost` (`id`, `newsTitle`, `newsBody`, `newsTimeStamp`, `userID`, `eventID`) VALUES
(5, 'Sed ut Perspiciatis ', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '0000-00-00', 10, 1),
(4, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '0000-00-00', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `opensession`
--

CREATE TABLE IF NOT EXISTS `opensession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accountID` int(11) NOT NULL,
  `sessionID` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `opensession`
--

INSERT INTO `opensession` (`id`, `accountID`, `sessionID`, `token`) VALUES
(68, 10, 'bcpmdqpfgdlpcm42141p8of856', '39befbf9b051b23259dfc2063f76b28d8cdefbce5c76b411c01fb7fed9f7c3a0901ec975994a3088623300b568432c147602af14dbcdffc1105a034dc9270771');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
