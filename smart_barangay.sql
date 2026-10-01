-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2026 at 06:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_barangay`
--

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `number` varchar(40) NOT NULL,
  `note` varchar(200) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `emergency_contacts`
--

INSERT INTO `emergency_contacts` (`id`, `name`, `number`, `note`, `sort_order`) VALUES
(1, 'National Emergency Hotline', '911', 'Police, fire and medical emergencies, 24/7', 1),
(2, 'Philippine Red Cross', '143', 'Ambulance, first aid and disaster response', 2),
(3, 'Barangay Hall Hotline', '0917 000 0001', 'Barangay officials and tanods', 3),
(4, 'Barangay Tanod Outpost', '0917 000 0002', 'Peace and order concerns, 24/7', 4),
(5, 'Barangay Health Center', '0917 000 0003', 'Medical concerns during clinic hours', 5),
(6, 'Fire Station', '0917 000 0004', 'Fire reports and rescue', 6),
(7, 'Police Station', '0917 000 0005', 'Crime reports and police assistance', 7);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time DEFAULT NULL,
  `location` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `event_time`, `location`) VALUES
(1, 'Barangay Assembly', 'Quarterly assembly with the accomplishment report and open forum.', '2026-10-08', '14:00:00', 'Barangay Covered Court'),
(2, 'Free Anti-Rabies Vaccination', 'Free vaccination for dogs and cats, with the City Veterinary Office.', '2026-10-11', '08:00:00', 'Barangay Health Center'),
(3, 'Community Clean-Up Drive', 'Join your neighbors in cleaning streets, canals and public spaces.', '2026-10-15', '06:30:00', 'Main Street, meet at the Barangay Hall'),
(4, 'Basketball League Opening', 'Opening games of the barangay inter-purok basketball league.', '2026-10-22', '16:00:00', 'Barangay Covered Court'),
(5, 'Senior Citizens Health Day', 'Free blood pressure and sugar checks, with vitamins for seniors.', '2026-10-31', '09:00:00', 'Barangay Hall'),
(6, 'Tree Planting Activity', 'Planting of native tree seedlings along the creek bank.', '2026-09-21', '07:00:00', 'Creek Side Area'),
(7, 'Youth Leadership Seminar', 'Seminar for SK members and youth volunteers.', '2026-09-06', '13:00:00', 'Barangay Hall');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `category` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `office_hours`
--

CREATE TABLE `office_hours` (
  `id` int(11) NOT NULL,
  `day_label` varchar(12) NOT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `office_hours`
--

INSERT INTO `office_hours` (`id`, `day_label`, `open_time`, `close_time`, `sort_order`) VALUES
(1, 'Monday', '08:00:00', '17:00:00', 1),
(2, 'Tuesday', '08:00:00', '17:00:00', 2),
(3, 'Wednesday', '08:00:00', '17:00:00', 3),
(4, 'Thursday', '08:00:00', '17:00:00', 4),
(5, 'Friday', '08:00:00', '17:00:00', 5),
(6, 'Saturday', '08:00:00', '12:00:00', 6),
(7, 'Sunday', NULL, NULL, 7);

-- --------------------------------------------------------

--
-- Table structure for table `officials`
--

CREATE TABLE `officials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `committee` varchar(120) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `officials`
--

INSERT INTO `officials` (`id`, `name`, `position`, `committee`, `sort_order`) VALUES
(1, 'Ricardo M. Dela Cruz', 'Punong Barangay', 'Barangay Captain', 1),
(2, 'Maria Luisa S. Reyes', 'Barangay Kagawad', 'Committee on Health and Sanitation', 2),
(3, 'Eduardo P. Villanueva', 'Barangay Kagawad', 'Committee on Peace and Order', 3),
(4, 'Corazon B. Mendoza', 'Barangay Kagawad', 'Committee on Education', 4),
(5, 'Roberto T. Aquino', 'Barangay Kagawad', 'Committee on Infrastructure', 5),
(6, 'Teresita G. Ramos', 'Barangay Kagawad', 'Committee on Livelihood', 6),
(7, 'Jose Miguel C. Bautista', 'Barangay Kagawad', 'Committee on Disaster Risk Reduction', 7),
(8, 'Angelica R. Torres', 'Barangay Kagawad', 'Committee on Women and Family', 8),
(9, 'Kyle Andrei D. Navarro', 'SK Chairperson', 'Sangguniang Kabataan', 9),
(10, 'Lorna F. Castillo', 'Barangay Secretary', NULL, 10),
(11, 'Benjamin O. Salazar', 'Barangay Treasurer', NULL, 11);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `type` enum('Announcement','Update') NOT NULL,
  `title` varchar(150) NOT NULL,
  `body` text NOT NULL,
  `posted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `type`, `title`, `body`, `posted_at`) VALUES
(1, 'Announcement', 'Barangay Assembly this month', 'All residents are invited to attend the quarterly Barangay Assembly. Barangay officials will present the accomplishment report and open the floor for questions and suggestions. Please bring a valid ID for attendance.', '2026-09-30 12:34:47'),
(2, 'Announcement', 'Free anti-rabies vaccination for pets', 'The Barangay Health Center, together with the City Veterinary Office, will vaccinate dogs and cats free of charge. Please bring your pets on a leash or in a carrier.', '2026-09-28 12:34:47'),
(3, 'Announcement', 'Barangay clearance now processed within the day', 'Residents who submit complete requirements before 3:00 PM can now receive their barangay clearance on the same day.', '2026-09-25 12:34:47'),
(4, 'Announcement', 'Reminder: keep canals and gutters clear', 'To prevent flooding during heavy rain, please do not throw garbage into canals. Tanods will conduct inspections along main roads.', '2026-09-22 12:34:47'),
(5, 'Update', 'Drainage clearing completed along Main Street', 'The barangay maintenance team has finished declogging the drainage along Main Street. Residents may report remaining problem areas through the feedback form.', '2026-09-29 12:34:47'),
(6, 'Update', 'New streetlights installed in Purok 3', 'Ten solar streetlights were installed in Purok 3 to improve safety for residents walking at night.', '2026-09-26 12:34:47'),
(7, 'Update', 'Health Center adds weekly immunization day', 'The Barangay Health Center now holds a dedicated immunization day every Wednesday morning for infants and children.', '2026-09-23 12:34:47'),
(8, 'Update', 'Livelihood training enrollment extended', 'Enrollment for the basic food processing livelihood training has been extended. Register at the Barangay Hall during office hours.', '2026-09-19 12:34:47');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `category` varchar(40) NOT NULL,
  `title` varchar(120) NOT NULL,
  `when_text` varchar(150) NOT NULL,
  `details` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `category`, `title`, `when_text`, `details`) VALUES
(1, 'Sanitation', 'Garbage collection', 'Every Monday and Thursday, 6:00 AM', 'Place segregated waste outside your gate before the truck arrives.'),
(2, 'Sanitation', 'Recyclables collection', 'Every first Saturday of the month', 'Clean plastic, paper and metal only.'),
(3, 'Health', 'Child immunization', 'Every Wednesday, 8:00 AM to 11:00 AM', 'Bring the child\'s health card.'),
(4, 'Health', 'Prenatal check-up', 'Every Friday, 9:00 AM to 12:00 NN', 'Barangay Health Center.'),
(5, 'Governance', 'Barangay Council session', 'Every first Monday of the month, 2:00 PM', 'Open to residents who wish to observe.'),
(6, 'Peace and Order', 'Mediation hearings', 'Every Tuesday and Friday, 9:00 AM', 'By appointment at the Barangay Hall.'),
(7, 'Peace and Order', 'Tanod night patrol', 'Daily, 9:00 PM to 5:00 AM', 'Report suspicious activity to the emergency hotline.');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `fee` varchar(60) NOT NULL DEFAULT 'Free',
  `icon` varchar(30) NOT NULL DEFAULT 'file-text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `requirements`, `fee`, `icon`) VALUES
(1, 'Barangay Clearance', 'Official clearance for employment, business, school or other legal purposes.', 'Valid ID\nCedula (community tax certificate)\n1 passport-size photo', 'PHP 50', 'file-text'),
(2, 'Certificate of Residency', 'Proof that you live in the barangay, needed for school and government transactions.', 'Valid ID with address\nProof of billing (if available)', 'PHP 30', 'home'),
(3, 'Certificate of Indigency', 'Issued to qualified residents who need assistance for medical, education or legal needs.', 'Valid ID\nPurpose letter or request', 'Free', 'users'),
(4, 'Business Clearance', 'Required before applying for a mayor\'s permit for a business within the barangay.', 'Valid ID\nDTI or SEC registration\nSketch of business location', 'PHP 200', 'briefcase'),
(5, 'Mediation and Complaints', 'Settlement of neighborhood disputes through the Lupon Tagapamayapa before court action.', 'Valid ID\nWritten or verbal complaint', 'Free', 'shield'),
(6, 'Health Center Services', 'Immunization, prenatal check-ups, blood pressure monitoring and basic consultations.', 'Barangay health record\nValid ID of patient or guardian', 'Free', 'heart');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `office_hours`
--
ALTER TABLE `office_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officials`
--
ALTER TABLE `officials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `office_hours`
--
ALTER TABLE `office_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
