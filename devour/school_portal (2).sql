-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 04:11 AM
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
-- Database: `school_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` varchar(10) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password_Hash` text DEFAULT NULL,
  `Role` varchar(20) DEFAULT NULL,
  `Created_At` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `FacultyID` varchar(10) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Position` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`FacultyID`, `Name`, `Position`, `Email`) VALUES
('FAC001', 'Maria Santos', 'Filipino Teacher', 'maria.santos@school.edu.ph'),
('FAC002', 'Juan Dela Cruz', 'AP Teacher', 'juan.delacruz@school.edu.ph'),
('FAC003', 'Ana Reyes', 'ESP Teacher', 'ana.reyes@school.edu.ph'),
('FAC004', 'Roberto Garcia', 'Math Teacher', 'roberto.garcia@school.edu.ph'),
('FAC005', 'Liza Mendoza', 'Science Teacher', 'liza.mendoza@school.edu.ph');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `GradeID` int(11) NOT NULL,
  `StudentID` varchar(10) DEFAULT NULL,
  `SubjectID` varchar(10) DEFAULT NULL,
  `Quarter` enum('1','2','3','4') DEFAULT NULL,
  `Score` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`GradeID`, `StudentID`, `SubjectID`, `Quarter`, `Score`) VALUES
(25, 'S001', 'FIL701', '1', 85.50),
(26, 'S001', 'FIL701', '2', 87.00),
(27, 'S001', 'MATH701', '1', 90.25),
(28, 'S001', 'MATH701', '2', 88.75),
(29, 'S002', 'FIL701', '1', 80.00),
(30, 'S002', 'FIL701', '2', 82.25),
(31, 'S002', 'MATH701', '1', 84.00),
(32, 'S002', 'MATH701', '2', 83.50),
(33, 'S003', 'FIL701', '1', 75.75),
(34, 'S003', 'FIL701', '2', 78.00),
(35, 'S003', 'MATH701', '1', 76.25),
(36, 'S003', 'MATH701', '2', 79.00),
(37, 'S004', 'FIL701', '1', 88.00),
(38, 'S004', 'FIL701', '2', 89.50),
(39, 'S004', 'MATH701', '1', 91.00),
(40, 'S004', 'MATH701', '2', 92.75),
(41, 'S005', 'FIL701', '1', 83.25),
(42, 'S005', 'FIL701', '2', 84.75),
(43, 'S005', 'MATH701', '1', 85.50),
(44, 'S005', 'MATH701', '2', 86.00),
(45, 'S0006', 'FIL701', '1', 91.00),
(46, 'S0006', 'FIL701', '2', 93.25),
(47, 'S0006', 'MATH701', '1', 89.50),
(48, 'S0006', 'MATH701', '2', 90.75);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentID` varchar(10) NOT NULL,
  `LRN` varchar(30) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password_Hash` varchar(15) DEFAULT NULL,
  `GradeLevel` int(11) DEFAULT NULL,
  `Section` varchar(10) DEFAULT NULL,
  `ProfilePic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `LRN`, `FirstName`, `LastName`, `Email`, `Password_Hash`, `GradeLevel`, `Section`, `ProfilePic`) VALUES
('S0006', '129557100365', 'Meill', 'Manulat', 'meillicban@gmail.com', 'c00lmeill', 7, 'Bayot', 'pfp_6831321ea3f683.05849850.jpg'),
('S001', '1234567890', 'Maria', 'Cruz', 'maria.cruz@email.com', 'maria123', 6, 'A', 'pfp_6831bb7bc02e18.75797905.gif'),
('S002', '2345678901', 'Juan', 'Santos', 'juan.santos@email.com', 'juan456', 5, 'B', NULL),
('S003', '3456789012', 'Ana', 'Reyes', 'ana.reyes@email.com', 'ana789', 4, 'C', NULL),
('S004', '4567890123', 'Pedro', 'Garcia', 'pedro.garcia@email.com', 'pedro321', 6, 'D', NULL),
('S005', '5678901234', 'Carla', 'Lopez', 'carla.lopez@email.com', 'carla654', 5, 'A', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `SubjectID` varchar(10) NOT NULL,
  `SubjectName` varchar(100) DEFAULT NULL,
  `GradeLevel` int(11) DEFAULT NULL,
  `FacultyID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`SubjectID`, `SubjectName`, `GradeLevel`, `FacultyID`) VALUES
('AP1001', 'Kontemporaryong Isyu', 10, 'FAC002'),
('AP701', 'Kasaysayan ng Daigdig', 7, 'FAC002'),
('AP801', 'Kasaysayan ng Asya', 8, 'FAC002'),
('AP901', 'Ekonomiks', 9, 'FAC002'),
('EAPP1101', 'English for Academic & Professional Purposes', 11, 'FAC005'),
('ESP1001', 'Etika at Panlipunang Asal', 10, 'FAC003'),
('ESP701', 'Edukasyon sa Pagpapakatao', 7, 'FAC003'),
('ESP801', 'Pagpapakatao: Mga Birtud at Asal', 8, 'FAC003'),
('ESP901', 'Pag-unawa sa Sarili at Kapwa', 9, 'FAC003'),
('FIL1001', 'Pagsulat ng Sanaysay at Pananaliksik', 10, 'FAC001'),
('FIL101', 'Wikang Filipino: Alpabeto at Tinig', 1, 'FAC001'),
('FIL102', 'Pagkilala sa Sarili at Kapamilya', 1, 'FAC002'),
('FIL103', 'Pagbasa at Pag-unawa ng Pangungusap', 1, 'FAC003'),
('FIL104', 'Panitikan para sa mga Bata', 1, 'FAC004'),
('FIL105', 'Awitin at Sayaw', 1, 'FAC005'),
('FIL1101', 'Komunikasyon at Pananaliksik', 11, 'FAC001'),
('FIL1201', 'Pagbasa at Pagsusuri ng Teksto', 12, 'FAC001'),
('FIL201', 'Wika at Komunikasyon', 2, 'FAC001'),
('FIL202', 'Pagbasa ng mga Salita at Parirala', 2, 'FAC002'),
('FIL203', 'Pagsulat ng mga Pangungusap', 2, 'FAC003'),
('FIL204', 'Kuwento at Tula', 2, 'FAC004'),
('FIL205', 'Tradisyonal na Awitin at Sayaw', 2, 'FAC005'),
('FIL301', 'Pagsasalita at Pakikinig', 3, 'FAC001'),
('FIL302', 'Pag-unawa sa Pangungusap', 3, 'FAC002'),
('FIL303', 'Panitikan: Kuwento at Tula', 3, 'FAC003'),
('FIL304', 'Pagsulat ng Talata', 3, 'FAC004'),
('FIL305', 'Kultura at Tradisyon', 3, 'FAC005'),
('FIL401', 'Pagbabasa at Pagsusuri', 4, 'FAC001'),
('FIL402', 'Pagsulat ng Komposisyon', 4, 'FAC002'),
('FIL403', 'Panitikang Pilipino', 4, 'FAC003'),
('FIL404', 'Wika sa Araw-araw na Pamumuhay', 4, 'FAC004'),
('FIL405', 'Pananamit at Pagkain ng Pilipino', 4, 'FAC005'),
('FIL501', 'Masusing Pagbasa at Pagsusulat', 5, 'FAC001'),
('FIL502', 'Panitikan: Nobela at Dula', 5, 'FAC002'),
('FIL503', 'Pagsasalita sa Iba\'t Ibang Sitwasyon', 5, 'FAC003'),
('FIL504', 'Kasaysayan ng Wikang Filipino', 5, 'FAC004'),
('FIL505', 'Mga Tradisyon at Pananampalataya', 5, 'FAC005'),
('FIL601', 'Panitikan ng Pilipinas', 6, 'FAC001'),
('FIL602', 'Masusing Pag-unawa sa Teksto', 6, 'FAC002'),
('FIL603', 'Pagsulat ng Sanaysay', 6, 'FAC003'),
('FIL604', 'Filipino sa Komunikasyon', 6, 'FAC004'),
('FIL605', 'Kulturang Pilipino at Wika', 6, 'FAC005'),
('FIL701', 'Wika at Gramatika', 7, 'FAC001'),
('FIL801', 'Panitikan: Rehiyon sa Pilipinas', 8, 'FAC001'),
('FIL901', 'Panitikan: Mitolohiya at Epiko', 9, 'FAC001'),
('KOM1201', 'Filipino sa Piling Larang', 12, 'FAC002'),
('MATH1001', 'Trigonometriya', 10, 'FAC004'),
('MATH1101', 'General Mathematics', 11, 'FAC003'),
('MATH1201', 'Statistics and Probability', 12, 'FAC003'),
('MATH701', 'Matematika: Batayang Konsepto', 7, 'FAC004'),
('MATH801', 'Alhebra', 8, 'FAC004'),
('MATH901', 'Geometry', 9, 'FAC004'),
('ORALCOM', 'Oral Communication', 11, 'FAC002'),
('PEH1201', 'Physical Education and Health', 12, 'FAC004'),
('RP1201', 'Research Project', 12, 'FAC005'),
('SCI1001', 'Agham: Pisika', 10, 'FAC005'),
('SCI701', 'Agham: Pisikal at Kemikal', 7, 'FAC005'),
('SCI801', 'Agham: Biyolohiya', 8, 'FAC005'),
('SCI901', 'Agham: Kemistri', 9, 'FAC005'),
('UCSP1101', 'Understanding Culture, Society & Politics', 11, 'FAC004');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`FacultyID`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`GradeID`),
  ADD UNIQUE KEY `unique_grade_entry` (`StudentID`,`SubjectID`,`Quarter`),
  ADD KEY `SubjectID` (`SubjectID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`SubjectID`),
  ADD KEY `FacultyID` (`FacultyID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `GradeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`SubjectID`) REFERENCES `subject` (`SubjectID`);

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`FacultyID`) REFERENCES `faculty` (`FacultyID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
