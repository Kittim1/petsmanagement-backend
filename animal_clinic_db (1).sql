-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 06:48 AM
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
-- Database: `animal_clinic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adoptions`
--

CREATE TABLE `tbl_adoptions` (
  `AdoptionID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL,
  `AdopterID` int(11) NOT NULL,
  `AdoptionDate` date NOT NULL,
  `Status` varchar(50) DEFAULT 'Pending',
  `Notes` text DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment`
--

CREATE TABLE `tbl_appointment` (
  `AppointmentID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL,
  `OwnerID` int(11) NOT NULL,
  `vet_id` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `AppointmentTime` time NOT NULL,
  `ReasonForVisit` text DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Scheduled',
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_breeds`
--

CREATE TABLE `tbl_breeds` (
  `breed_id` int(11) NOT NULL,
  `breed_name` varchar(100) DEFAULT NULL,
  `species_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_breeds`
--

INSERT INTO `tbl_breeds` (`breed_id`, `breed_name`, `species_id`) VALUES
(1, 'Mountain', 1),
(2, 'Sigbin Blue', NULL),
(3, 'Sigbin Pink', NULL),
(4, 'Sigbin Blue', 1),
(5, 'Sigbin Blue1', 2),
(6, 'Sigbin Pink1', 2),
(7, 'qwerty', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medications`
--

CREATE TABLE `tbl_medications` (
  `medication_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `dosage` varchar(50) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `prescribed_by` int(11) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medicines`
--

CREATE TABLE `tbl_medicines` (
  `medicine_id` int(11) NOT NULL,
  `medicine_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `dosage_form` varchar(50) DEFAULT NULL,
  `unit_of_measurement` varchar(20) DEFAULT NULL,
  `quantity_in_stock` int(11) DEFAULT 0,
  `expiration_date` date DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_owners`
--

CREATE TABLE `tbl_owners` (
  `owner_id` int(11) NOT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `owner_contact_number` varchar(100) DEFAULT NULL,
  `owner_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_owners`
--

INSERT INTO `tbl_owners` (`owner_id`, `owner_name`, `owner_contact_number`, `owner_address`) VALUES
(1, 'Jecham Rey Cabusog', '12345678', 'CDO'),
(2, 'Jecham Rey Cabusog', '123456', 'CDO'),
(3, 'SABEL', '521512SA', 'ASFAF');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pets`
--

CREATE TABLE `tbl_pets` (
  `pet_id` int(11) NOT NULL,
  `pet_name` varchar(100) DEFAULT NULL,
  `species_id` int(11) DEFAULT NULL,
  `breed_id` int(11) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `pet_status` varchar(50) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pets`
--

INSERT INTO `tbl_pets` (`pet_id`, `pet_name`, `species_id`, `breed_id`, `date_of_birth`, `owner_id`, `pet_status`) VALUES
(1, 'Macuse', 1, 1, '2024-05-11', 1, 'Active'),
(2, 'Choco', 1, 1, '2024-05-11', 1, 'Active'),
(3, 'gabons', 2, 2, '1912-12-12', 1, 'Active'),
(4, 'gabons1', 2, 5, '1612-12-12', 1, 'Active'),
(5, 'gabons2', 2, 6, '1621-01-04', 1, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_species`
--

CREATE TABLE `tbl_species` (
  `species_id` int(11) NOT NULL,
  `species_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_species`
--

INSERT INTO `tbl_species` (`species_id`, `species_name`) VALUES
(1, 'Blue Whale'),
(2, 'Sigbin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_veterinarians`
--

CREATE TABLE `tbl_veterinarians` (
  `vet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vetrecords`
--

CREATE TABLE `tbl_vetrecords` (
  `RecordID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL,
  `vet_id` int(11) DEFAULT NULL,
  `Diagnosis` text DEFAULT NULL,
  `Treatment` text DEFAULT NULL,
  `Prescription` text DEFAULT NULL,
  `VisitDate` date NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_firstname` varchar(50) DEFAULT NULL,
  `user_lastname` varchar(50) DEFAULT NULL,
  `user_level` enum('admin','owner','veterinarian') NOT NULL DEFAULT 'owner'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Email`, `Password`, `CreatedAt`, `UpdatedAt`, `user_firstname`, `user_lastname`, `user_level`) VALUES
(1, 'admin', 'admin@admin.com', '12345', '2024-09-25 21:57:03', '2024-10-02 07:14:18', 'admin', 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_adoptions`
--
ALTER TABLE `tbl_adoptions`
  ADD PRIMARY KEY (`AdoptionID`),
  ADD KEY `PetID` (`PetID`),
  ADD KEY `AdopterID` (`AdopterID`),
  ADD KEY `fk_adoptions_pet_id` (`pet_id`);

--
-- Indexes for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `PetID` (`PetID`),
  ADD KEY `OwnerID` (`OwnerID`),
  ADD KEY `VetID` (`vet_id`);

--
-- Indexes for table `tbl_breeds`
--
ALTER TABLE `tbl_breeds`
  ADD PRIMARY KEY (`breed_id`),
  ADD KEY `species_id` (`species_id`);

--
-- Indexes for table `tbl_medications`
--
ALTER TABLE `tbl_medications`
  ADD PRIMARY KEY (`medication_id`),
  ADD KEY `record_id` (`record_id`),
  ADD KEY `medicine_id` (`medicine_id`),
  ADD KEY `prescribed_by` (`prescribed_by`);

--
-- Indexes for table `tbl_medicines`
--
ALTER TABLE `tbl_medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `tbl_owners`
--
ALTER TABLE `tbl_owners`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `tbl_pets`
--
ALTER TABLE `tbl_pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `species_id` (`species_id`),
  ADD KEY `breed_id` (`breed_id`);

--
-- Indexes for table `tbl_species`
--
ALTER TABLE `tbl_species`
  ADD PRIMARY KEY (`species_id`);

--
-- Indexes for table `tbl_veterinarians`
--
ALTER TABLE `tbl_veterinarians`
  ADD PRIMARY KEY (`vet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_vetrecords`
--
ALTER TABLE `tbl_vetrecords`
  ADD PRIMARY KEY (`RecordID`),
  ADD KEY `PetID` (`PetID`),
  ADD KEY `VetID` (`vet_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_adoptions`
--
ALTER TABLE `tbl_adoptions`
  MODIFY `AdoptionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_breeds`
--
ALTER TABLE `tbl_breeds`
  MODIFY `breed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_medications`
--
ALTER TABLE `tbl_medications`
  MODIFY `medication_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_medicines`
--
ALTER TABLE `tbl_medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_owners`
--
ALTER TABLE `tbl_owners`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_pets`
--
ALTER TABLE `tbl_pets`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_species`
--
ALTER TABLE `tbl_species`
  MODIFY `species_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_veterinarians`
--
ALTER TABLE `tbl_veterinarians`
  MODIFY `vet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_vetrecords`
--
ALTER TABLE `tbl_vetrecords`
  MODIFY `RecordID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_adoptions`
--
ALTER TABLE `tbl_adoptions`
  ADD CONSTRAINT `fk_adoptions_pet_id` FOREIGN KEY (`pet_id`) REFERENCES `tbl_pets` (`pet_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD CONSTRAINT `fk_appointment_pet_id` FOREIGN KEY (`PetID`) REFERENCES `tbl_pets` (`pet_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_appointment_ibfk_1` FOREIGN KEY (`vet_id`) REFERENCES `tbl_veterinarians` (`vet_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_breeds`
--
ALTER TABLE `tbl_breeds`
  ADD CONSTRAINT `tbl_breeds_ibfk_1` FOREIGN KEY (`species_id`) REFERENCES `tbl_species` (`species_id`);

--
-- Constraints for table `tbl_medications`
--
ALTER TABLE `tbl_medications`
  ADD CONSTRAINT `tbl_medications_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `tbl_vetrecords` (`RecordID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_medications_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `tbl_medicines` (`medicine_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_medications_ibfk_3` FOREIGN KEY (`prescribed_by`) REFERENCES `tbl_veterinarians` (`vet_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_pets`
--
ALTER TABLE `tbl_pets`
  ADD CONSTRAINT `fk_pets_owner_id` FOREIGN KEY (`owner_id`) REFERENCES `tbl_owners` (`owner_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_pets_user_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_pets_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `tbl_owners` (`owner_id`),
  ADD CONSTRAINT `tbl_pets_ibfk_2` FOREIGN KEY (`species_id`) REFERENCES `tbl_species` (`species_id`),
  ADD CONSTRAINT `tbl_pets_ibfk_3` FOREIGN KEY (`breed_id`) REFERENCES `tbl_breeds` (`breed_id`);

--
-- Constraints for table `tbl_veterinarians`
--
ALTER TABLE `tbl_veterinarians`
  ADD CONSTRAINT `tbl_veterinarians_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_vetrecords`
--
ALTER TABLE `tbl_vetrecords`
  ADD CONSTRAINT `fk_vetrecords_pet_id` FOREIGN KEY (`PetID`) REFERENCES `tbl_pets` (`pet_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_vetrecords_ibfk_1` FOREIGN KEY (`vet_id`) REFERENCES `tbl_veterinarians` (`vet_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
