-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 02:20 PM
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
-- Database: `hostel_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_facility_management`
--

CREATE TABLE `add_facility_management` (
  `add_facility_id` int(11) NOT NULL,
  `facilityname` text NOT NULL,
  `facilitytype` text NOT NULL,
  `facilitycapacity` text NOT NULL,
  `facilityprice` text NOT NULL,
  `areasize` text NOT NULL,
  `amenities` text NOT NULL,
  `photo` text NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `add_facility_management`
--

INSERT INTO `add_facility_management` (`add_facility_id`, `facilityname`, `facilitytype`, `facilitycapacity`, `facilityprice`, `areasize`, `amenities`, `photo`, `status`) VALUES
(1, 'clinic', 'standard', '100', '10000', '6 meters', '1', 'Screenshot 2024-09-09 193000.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `add_room_management`
--

CREATE TABLE `add_room_management` (
  `add_room_id` int(11) NOT NULL,
  `roomnumber` int(11) NOT NULL,
  `roomtype` text NOT NULL,
  `roomcapacity` text NOT NULL,
  `roomprice` text NOT NULL,
  `bedtype` text NOT NULL,
  `photo` text NOT NULL,
  `roomsize` text NOT NULL,
  `roomfloor` text NOT NULL,
  `amenities` text NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `add_room_management`
--

INSERT INTO `add_room_management` (`add_room_id`, `roomnumber`, `roomtype`, `roomcapacity`, `roomprice`, `bedtype`, `photo`, `roomsize`, `roomfloor`, `amenities`, `status`) VALUES
(1, 203, 'Standard Room', '3', '2500', 'single ', '433684726', '50', '1', '', ''),
(2, 204, 'Standard Room', '4', '2500', 'Queen Bed', 'Screenshot 2024-09-09 193000.png', '999', 'Second Floor', '1', ''),
(3, 205, 'Standard Room', '4', '2500', 'Queen Bed', 'Screenshot 2024-09-09 193000.png', '999', 'First Floor', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `compose_messages`
--

CREATE TABLE `compose_messages` (
  `message_id` int(100) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `guest_email` varchar(50) NOT NULL,
  `message_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `compose_messages`
--

INSERT INTO `compose_messages` (`message_id`, `admin_email`, `guest_email`, `message_content`) VALUES
(10, 'b@gmail.com', 'JuanDelaCruz@gmail.com', '<a href=\"www.hostel.com\">www.hostel.com</a>\r\n[File: Main Activity.pdf]\r\n[Photo: Screenshot 2024-09-09 193000.png]\r\n\r\nhello po '),
(11, 'b@gmail.com', 'JuanDelaCruz@gmail.com', '[Photo: Screenshot 2024-09-09 193000.png]\r\n\r\n\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"');

-- --------------------------------------------------------

--
-- Table structure for table `facility_reservation`
--

CREATE TABLE `facility_reservation` (
  `facility_id` int(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phonenumber` text NOT NULL,
  `guest_category` text NOT NULL,
  `event` varchar(100) NOT NULL,
  `numguest` int(100) NOT NULL,
  `photo_facility` text NOT NULL,
  `facilityname` varchar(100) NOT NULL,
  `facility_type` varchar(100) NOT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `facility_reservation`
--

INSERT INTO `facility_reservation` (`facility_id`, `fullname`, `email`, `address`, `phonenumber`, `guest_category`, `event`, `numguest`, `photo_facility`, `facilityname`, `facility_type`, `checkin`, `checkout`, `status`) VALUES
(5, 'Nhatalie Estarija Paras', 'nhatalie26paras@gmail.com', 'purok 5', '09552658953', 'outside guest', 'seminar', 2, 'monkey-d-luffy-one-piece-straw-hat-wallpaper-preview.jpg', 'Hostel Function Hall', 'Standard', '2024-09-20', NULL, 'Reserved'),
(6, 'Nhatalie Estarija Paras', 'nhatalie26paras@gmail.com', 'purok 5', '09552658953', 'outside guest', 'seminar', 50, 'Screenshot 2024-09-09 193000.png', 'Hostel Function Hall', 'Standard', '2024-09-11', '2024-09-12', 'Reserved'),
(7, 'Nhatalie Estarija Paras', 'nhatalie26paras@gmail.com', 'purok 5', '09552658953', 'inside guest', 'seminar', 50, 'Screenshot 2024-09-09 193000.png', 'Hostel Covered Court', 'Standard', '2024-09-10', '2024-09-11', 'Reserved'),
(8, 'Nhatalie Estarija Paras', 'nhatalie26paras@gmail.com', 'purok 5', '09552658953', 'outside guest', 'seminar', 50, 'Screenshot 2024-09-09 193000.png', 'Hostel Covered Court', 'Standard', '2024-09-26', '2024-09-27', 'Reserved');

-- --------------------------------------------------------

--
-- Table structure for table `room_reservation`
--

CREATE TABLE `room_reservation` (
  `room_id` int(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phonenumber` text NOT NULL,
  `Totalguest` int(100) NOT NULL,
  `guestimage` text DEFAULT NULL,
  `roomtype` text NOT NULL,
  `roomnumber` text NOT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `num_days` int(11) NOT NULL,
  `arrival_time` time NOT NULL,
  `amenities` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `accompany` text NOT NULL,
  `departure_time` time NOT NULL,
  `reservation_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `room_reservation`
--

INSERT INTO `room_reservation` (`room_id`, `fullname`, `email`, `address`, `phonenumber`, `Totalguest`, `guestimage`, `roomtype`, `roomnumber`, `checkin`, `checkout`, `num_days`, `arrival_time`, `amenities`, `status`, `accompany`, `departure_time`, `reservation_status`) VALUES
(41, 'Juan Dela Cruz De Guzman', 'JuanDelaCruz@gmail.com', 'Rosario', '944555', 2, 'Screenshot 2024-09-09 193000.png', 'Standard Room', '203', '2024-09-12', '2024-09-13', 1, '08:12:00', 'wifi', 'checkout', 'anything, anything, anything', '05:12:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(11) NOT NULL,
  `fullname` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` text NOT NULL,
  `password` text NOT NULL,
  `gender` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `fullname`, `email`, `phone`, `password`, `gender`) VALUES
(1, 'Nhatalie Estarija Paras', 'nhatalie26paras@gmail.com', '9999 999 9999', '$2y$10$2Z.M5jVSHsXNMFgc5QM7x.dzeDT/R11yXxjvlWNshpPUdD2rdisuW', 'female');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_facility_management`
--
ALTER TABLE `add_facility_management`
  ADD PRIMARY KEY (`add_facility_id`);

--
-- Indexes for table `add_room_management`
--
ALTER TABLE `add_room_management`
  ADD PRIMARY KEY (`add_room_id`);

--
-- Indexes for table `compose_messages`
--
ALTER TABLE `compose_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `facility_reservation`
--
ALTER TABLE `facility_reservation`
  ADD PRIMARY KEY (`facility_id`);

--
-- Indexes for table `room_reservation`
--
ALTER TABLE `room_reservation`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_facility_management`
--
ALTER TABLE `add_facility_management`
  MODIFY `add_facility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `add_room_management`
--
ALTER TABLE `add_room_management`
  MODIFY `add_room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `compose_messages`
--
ALTER TABLE `compose_messages`
  MODIFY `message_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `facility_reservation`
--
ALTER TABLE `facility_reservation`
  MODIFY `facility_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `room_reservation`
--
ALTER TABLE `room_reservation`
  MODIFY `room_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
