-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: melek_global_education
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin',
  `picture` varchar(255) DEFAULT NULL,
  `remember_token` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`),
  KEY `remember_token` (`remember_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'Gilbert Elikplim','Kukah','kwamegilbert1114@gmail.com','+233 541436414','Lusaka, Zambia','female','$2y$10$hs4g9/vuFh1AFXP7OGyXkezkHo9LYFD5kxdhLTTazBZHGwbLER/WC',NULL,'Administrator','./images/admin/admin_1.jpg',NULL,'2024-11-11 10:53:35','2024-11-24 09:02:17');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application` (
  `application_id` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Pending Processing',
  `date_applied` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL,
  PRIMARY KEY (`application_id`),
  KEY `student_id` (`student_id`),
  CONSTRAINT `application_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` VALUES ('1',1,'Pending Payment','2024-11-11','2024-11-11'),('2',2,'Pending Payment','2024-11-11','2024-11-11'),('3',3,'Pending Processing','2024-11-11','2024-11-11'),('4',4,'Processing','2024-11-11','2024-11-11'),('5',5,'Pending Processing','2024-11-11','2024-11-11');
/*!40000 ALTER TABLE `application` ENABLE KEYS */;

--
-- Table structure for table `application_details`
--

DROP TABLE IF EXISTS `application_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_details` (
  `application_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` varchar(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `program_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `marital_status` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `country_of_birth` varchar(50) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `affiliated_institution` varchar(255) DEFAULT NULL,
  `in_china_now` enum('Yes','No') DEFAULT NULL,
  `native_language` varchar(255) DEFAULT NULL,
  `correspondence_detailed_address` varchar(255) DEFAULT NULL,
  `correspondence_city` varchar(255) DEFAULT NULL,
  `correspondence_zipcode` varchar(10) DEFAULT NULL,
  `correspondence_phone` varchar(50) DEFAULT NULL,
  `correspondence_email` varchar(100) DEFAULT NULL,
  `applicant_detailed_address` varchar(255) DEFAULT NULL,
  `applicant_city` varchar(255) DEFAULT NULL,
  `applicant_zipcode` varchar(10) DEFAULT NULL,
  `applicant_phone` varchar(50) DEFAULT NULL,
  `applicant_email` varchar(100) DEFAULT NULL,
  `passport_number` varchar(50) DEFAULT NULL,
  `passport_start_date` date DEFAULT NULL,
  `passport_expiry_date` date DEFAULT NULL,
  `old_passport_number` varchar(50) DEFAULT NULL,
  `old_expiry_date` date DEFAULT NULL,
  `fin_sponsor_name` varchar(100) DEFAULT NULL,
  `fin_sponsor_relationship` int(100) DEFAULT NULL,
  `fin_sponsor_work_place` varchar(100) DEFAULT NULL,
  `fin_sponsor_occupation` varchar(100) DEFAULT NULL,
  `fin_sponsor_email` varchar(100) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_relationship` varchar(100) DEFAULT NULL,
  `emergency_contact_work_place` varchar(100) DEFAULT NULL,
  `emergency_contact_occupation` varchar(100) DEFAULT NULL,
  `emergency_contact_email` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `major_country` int(11) DEFAULT NULL,
  `major_school` int(11) DEFAULT NULL,
  `major_program` int(11) DEFAULT NULL,
  `major_teaching_language` varchar(100) DEFAULT NULL,
  `major_entry_year` year(4) DEFAULT NULL,
  `english_proficiency` varchar(100) DEFAULT NULL,
  `chinese_proficiency` varchar(100) DEFAULT NULL,
  `hsk_level` varchar(100) DEFAULT NULL,
  `hsk_scores` int(11) DEFAULT NULL,
  `hskk_scores` int(11) DEFAULT NULL,
  `time_of_chinese_learning` varchar(100) DEFAULT NULL,
  `teacher_nationlity_chinese` varchar(50) DEFAULT NULL,
  `chinese_learning_institution` varchar(255) DEFAULT NULL,
  `highest_degree` varchar(255) DEFAULT NULL,
  `highest_degree_school` varchar(255) DEFAULT NULL,
  `highest_degree_certificate_type` varchar(255) DEFAULT NULL,
  `best_mark_if_100` int(11) DEFAULT NULL,
  `worst_mark_if_100` int(11) DEFAULT NULL,
  PRIMARY KEY (`application_detail_id`),
  KEY `application_id` (`application_id`),
  KEY `fk_school_id` (`school_id`),
  KEY `fk_program_id` (`program_id`),
  CONSTRAINT `application_details_ibfk_2` FOREIGN KEY (`application_id`) REFERENCES `application` (`application_id`),
  CONSTRAINT `fk_program_id` FOREIGN KEY (`program_id`) REFERENCES `program` (`program_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_school_id` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_details`
--

/*!40000 ALTER TABLE `application_details` DISABLE KEYS */;
INSERT INTO `application_details` VALUES (1,'1',1,1,'Sarah','Johnson','Female','American','Single','1998-03-15','Christianity','USA','Student','New York','Columbia University','','English','123 Park Avenue','New York','10001','+1-212-555-0123','sarah.j@email.com','123 Park Avenue','New York','10001','+1-212-555-0123','sarah.j@email.com','P123456789','2020-01-01','2030-01-01','P987654321','2020-01-01','Robert Johnson',0,'Johnson & Associates','Lawyer','robert.j@email.com','Mary Johnson','Mother','NYC Hospital','Doctor','mary.j@email.com','+1-212-555-0124',0,4,1,'English',2021,'Advanced','Beginner','HSK2',180,60,'1 year','1','Beijing Language Institute','Bachelor','Columbia University','Degree Certificate',95,75),(2,'2',2,2,'Mohammed','Al-Rashid','Male','Saudi Arabian','Single','1997-06-22','Islam','Saudi Arabia','Student','Riyadh','King Saud University','Yes','Arabic','456 Beijing Road','Beijing','100000','+86-10-12345678','mohammed.r@email.com','789 Riyadh St','Riyadh','12345','+966-11-123456','mohammed.r@email.com','S987654321','2019-05-15','2029-05-15','S123456789','2019-05-15','Abdullah Al-Rashid',0,'Al-Rashid Trading','Business Owner','abdullah.r@email.com','Fatima Al-Rashid','Sister','Riyadh Bank','Banker','fatima.r@email.com','+966-11-234567',3,3,2,'English',2020,'Intermediate','Intermediate','HSK4',240,70,'2 years','0','Shanghai University','Bachelor','King Saud University','Degree Certificate',92,78),(3,'3',3,3,'Elena','Popov','Female','Russian','Married','1996-11-30','Orthodox','Russia','Engineer','Moscow','Moscow State University','','Russian','789 Arbat Street','Moscow','119019','+7-495-123-4567','elena.p@email.com','789 Arbat Street','Moscow','119019','+7-495-123-4567','elena.p@email.com','R123789456','2018-08-20','2028-08-20','R456123789','2018-08-20','Igor Popov',0,'Gazprom','Manager','igor.p@email.com','Natalia Popov','Mother','State School','Teacher','natalia.p@email.com','+7-495-234-5678',2,1,3,'Russian',2019,'Upper Intermediate','Advanced','HSK5',260,80,'3 years','1','Peking University','Master','Moscow State University','Degree Certificate',98,82),(4,'4',4,4,'Yuki','Tanaka','Female','Japanese','Single','1999-08-12','Buddhism','Japan','Student','Tokyo','University of Tokyo','','Japanese','123 Shibuya Street','Tokyo','150-0002','+81-3-1234-5678','yuki.t@email.com','123 Shibuya Street','Tokyo','150-0002','+81-3-1234-5678','yuki.t@email.com','J456789123','2021-03-15','2031-03-15','J123456789','2021-03-15','Hiroshi Tanaka',0,'Sony Corporation','Executive','hiroshi.t@email.com','Akiko Tanaka','Mother','Home','Homemaker','akiko.t@email.com','+81-3-2345-6789',4,2,4,'Japanese',2022,'Advanced','Upper Intermediate','HSK5',255,75,'2.5 years','1','Fudan University','Bachelor','University of Tokyo','Degree Certificate',96,80),(5,'5',5,5,'Lucas','Silva','Male','Brazilian','Single','1997-04-25','Christianity','Brazil','Student','São Paulo','University of São Paulo','','Portuguese','456 Paulista Avenue','São Paulo','01310-100','+55-11-12345678','lucas.s@email.com','456 Paulista Avenue','São Paulo','01310-100','+55-11-12345678','lucas.s@email.com','B789123456','2019-12-01','2029-12-01','B456789123','2019-12-01','Pedro Silva',0,'Petrobras','Engineer','pedro.s@email.com','Maria Silva','Mother','Bank of Brazil','Manager','maria.s@email.com','+55-11-23456789',1,2,5,'Portuguese',2020,'Upper Intermediate','Beginner','HSK3',200,65,'1.5 years','0','Tsinghua University','Bachelor','University of São Paulo','Degree Certificate',94,77);
/*!40000 ALTER TABLE `application_details` ENABLE KEYS */;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_name` varchar(100) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'United States','2024-11-12','2024-11-12'),(2,'Canada','2024-11-12','2024-11-12'),(3,'United Kingdom','2024-11-12','2024-11-12'),(4,'Australia','2024-11-12','2024-11-12'),(5,'Germany','2024-11-12','2024-11-12'),(6,'France','2024-11-12','2024-11-12'),(7,'Italy','2024-11-12','2024-11-12'),(8,'Spain','2024-11-12','2024-11-12'),(9,'Brazil','2024-11-12','2024-11-12'),(10,'India','2024-11-12','2024-11-12'),(11,'Ghaana','2024-11-20','0000-00-00');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `application_id` varchar(11) NOT NULL,
  `passport` int(11) NOT NULL,
  `highest_certificate` int(11) NOT NULL,
  `academic_transcript` int(11) NOT NULL,
  `non_criminal_record_certificate` int(11) NOT NULL,
  `bank_statement` int(11) NOT NULL,
  `application_fee_receipt` int(11) NOT NULL,
  `recommendation_letter` int(11) NOT NULL,
  `articles_thesis` int(11) NOT NULL,
  `physical_examination_form` int(11) NOT NULL,
  `guardian_guarantee_letter` int(11) NOT NULL,
  `english_proficiency` int(11) NOT NULL,
  `hsk_certificate` int(11) NOT NULL,
  `parent_authorization` int(11) NOT NULL,
  `research_proposal` int(11) NOT NULL,
  `cv` int(11) NOT NULL,
  `additional_document` int(11) NOT NULL,
  KEY `application_id` (`application_id`),
  CONSTRAINT `document_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

/*!40000 ALTER TABLE `document` DISABLE KEYS */;
/*!40000 ALTER TABLE `document` ENABLE KEYS */;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_status` varchar(50) NOT NULL,
  `payment_amount` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `application_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `payment_ibfk_1` (`application_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,'Completed',1500,'Credit Card',1,'2024-03-15'),(2,'Pending',2000,'Bank Transfer',2,'2024-03-14'),(3,'Failed',1750,'Debit Card',3,'2024-03-13'),(4,'Completed',1250,'PayPal',4,'2024-03-12'),(5,'Processing',1800,'Credit Card',5,'2024-03-11'),(6,'Completed',2250,'Bank Transfer',6,'2024-03-10'),(7,'Pending',1650,'PayPal',7,'2024-03-09'),(8,'Completed',1900,'Credit Card',8,'2024-03-08'),(9,'Failed',1450,'Debit Card',9,'2024-03-07'),(10,'Completed',2100,'Bank Transfer',10,'2024-03-06');
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;

--
-- Table structure for table `payment_links`
--

DROP TABLE IF EXISTS `payment_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_links` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_name` varchar(50) NOT NULL,
  `payment_method_link` varchar(255) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`payment_method_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_links`
--

/*!40000 ALTER TABLE `payment_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_links` ENABLE KEYS */;

--
-- Table structure for table `program`
--

DROP TABLE IF EXISTS `program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) NOT NULL,
  `program_degree` varchar(255) NOT NULL,
  `program_duration` varchar(100) NOT NULL,
  `school_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`program_id`),
  KEY `school_id` (`school_id`),
  CONSTRAINT `program_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program`
--

/*!40000 ALTER TABLE `program` DISABLE KEYS */;
INSERT INTO `program` VALUES (1,'Computer Science','BSc','3',1,'2024-11-12','2024-11-12'),(2,'Electrical Engineering','BSc','4',2,'2024-11-12','2024-11-12'),(3,'Mechanical Engineering','BSc','4',3,'2024-11-12','2024-11-12'),(4,'Business Administration','BBA','3',4,'2024-11-12','2024-11-12'),(5,'Law','LLB','4',5,'2024-11-12','2024-11-12'),(6,'Medicine','MBBS','6',6,'2024-11-12','2024-11-12'),(7,'Chemical Engineering','BSc','4',7,'2024-11-12','2024-11-12'),(8,'Mathematics','BSc','3',8,'2024-11-12','2024-11-12'),(9,'Economics','BA','3',9,'2024-11-12','2024-11-12'),(10,'Psychology','BA','3',10,'2024-11-12','2024-11-12'),(11,'Civil Engineering','BSc','4',1,'2024-11-12','2024-11-12'),(12,'Architecture','BArch','5',2,'2024-11-12','2024-11-12'),(13,'Philosophy','BA','3',3,'2024-11-12','2024-11-12'),(14,'Political Science','BA','3',4,'2024-11-12','2024-11-12'),(15,'Sociology','BA','3',5,'2024-11-12','2024-11-12'),(16,'Chemistry','BSc','3',6,'2024-11-12','2024-11-12'),(17,'Physics','BSc','3',7,'2024-11-12','2024-11-12'),(18,'Environmental Science','BSc','3',8,'2024-11-12','2024-11-12'),(19,'Biology','BSc','3',9,'2024-11-12','2024-11-12'),(20,'Nursing','BSc','4',10,'2024-11-12','2024-11-12'),(21,'Artificial Intelligence','MSc','2',1,'2024-11-12','2024-11-12'),(22,'Data Science','MSc','2',2,'2024-11-12','2024-11-12'),(23,'Software Engineering','BSc','4',3,'2024-11-12','2024-11-12'),(24,'Management','MBA','2',4,'2024-11-12','2024-11-12'),(25,'Public Health','MPH','2',5,'2024-11-12','2024-11-12'),(26,'Pharmacology','MSc','2',6,'2024-11-12','2024-11-12'),(27,'Human Resources','MBA','2',7,'2024-11-12','2024-11-12'),(28,'Journalism','BA','3',8,'2024-11-12','2024-11-12'),(29,'Fine Arts','BA','3',9,'2024-11-12','2024-11-12'),(30,'Graphic Design','BFA','3',10,'2024-11-12','2024-11-12'),(31,'Music','BA','3',1,'2024-11-12','2024-11-12'),(32,'Film Studies','BA','3',2,'2024-11-12','2024-11-12'),(33,'Business Analytics','MBA','2',3,'2024-11-12','2024-11-12'),(34,'International Relations','BA','3',4,'2024-11-12','2024-11-12'),(35,'Marketing','BBA','3',5,'2024-11-12','2024-11-12'),(36,'Finance','BBA','3',6,'2024-11-12','2024-11-12'),(37,'Accounting','BBA','3',7,'2024-11-12','2024-11-12'),(38,'Nutritional Science','BSc','3',8,'2024-11-12','2024-11-12'),(39,'Veterinary Medicine','BVSc','5',9,'2024-11-12','2024-11-12'),(40,'Forensic Science','BSc','3',10,'2024-11-12','2024-11-12'),(41,'Education','BEd','4',1,'2024-11-12','2024-11-12'),(42,'Sports Science','BSc','3',2,'2024-11-12','2024-11-12'),(43,'Tourism Management','BA','3',3,'2024-11-12','2024-11-12'),(44,'Event Management','BA','3',4,'2024-11-12','2024-11-12'),(45,'Culinary Arts','BA','3',5,'2024-11-12','2024-11-12'),(46,'Agriculture','BSc','4',6,'2024-11-12','2024-11-12'),(48,'Fashion Design','BA','3',8,'2024-11-12','2024-11-12'),(49,'Industrial Design','BSc','4',9,'2024-11-12','2024-11-12'),(50,'Urban Planning','MSc','2',10,'2024-11-12','2024-11-12'),(51,'Social Work','BA','3',1,'2024-11-12','2024-11-12'),(52,'History','BA','3',2,'2024-11-12','2024-11-12');
/*!40000 ALTER TABLE `program` ENABLE KEYS */;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `school` (
  `school_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) NOT NULL,
  `school_city` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`school_id`),
  KEY `school's country id` (`country_id`),
  CONSTRAINT `school_country` FOREIGN KEY (`country_id`) REFERENCES `country` (`country_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school`
--

/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` VALUES (1,'Harvard University','Cambridge',1,'2024-11-12','2024-11-12'),(2,'Stanford University','Stanford',1,'2024-11-12','2024-11-12'),(3,'University of Toronto','Toronto',2,'2024-11-12','2024-11-12'),(4,'University of Oxford','Oxford',3,'2024-11-12','2024-11-12'),(5,'University of Melbourne','Melbourne',4,'2024-11-12','2024-11-12'),(6,'Ludwig Maximilian University of Munich','Munich',5,'2024-11-12','2024-11-12'),(7,'Sorbonne University','Paris France',6,'2024-11-12','2024-11-12'),(8,'University of Rome','Rome',7,'2024-11-12','2024-11-12'),(9,'University of Barcelona','Barcelona',8,'2024-11-12','2024-11-12'),(10,'University of São Paulo','São Paulo',9,'2024-11-12','2024-11-12'),(11,'Indian Institute of Technology Bombay','Mumbai',10,'2024-11-12','2024-11-12'),(12,'Yale University','New Haven',1,'2024-11-12','2024-11-12'),(13,'Princeton University','Princeton',1,'2024-11-12','2024-11-12'),(14,'University of Cambridge','Cambridge',3,'2024-11-12','2024-11-12'),(15,'Monash University','Melbourne',4,'2024-11-12','2024-11-12'),(16,'University of Freiburg','Freiburg',5,'2024-11-12','2024-11-12'),(17,'Sciences Po','Paris',6,'2024-11-12','2024-11-12'),(18,'University of Naples Federico II','Naples',7,'2024-11-12','2024-11-12'),(19,'Autonomous University of Barcelona','Barcelona',8,'2024-11-12','2024-11-12'),(20,'Akenten Appiah Menka','Kumasi',11,'0000-00-00','0000-00-00'),(21,'KNUST','Kumasi',11,'0000-00-00','0000-00-00');
/*!40000 ALTER TABLE `school` ENABLE KEYS */;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` date DEFAULT current_timestamp(),
  `update_at` date DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'John','Doe','M','USA','2000-01-15','1234567890','johndoe@example.com','$2y$10$0zTPoxQ2Z8hUFjtbK/pcYO84ESVbqsLalAv6lsmBu56zpYemzYMe6','2024-11-11','2024-11-11'),(2,'Jane','Smith','F','Canada','1999-03-22','9876543210','janesmith@example.com','$2y$10$Lf8F1v5AafIDPEuNTg/Q8uLV3EDNqOU6HDf7uEjZ5/m6owCXJlyL2','2024-11-11','2024-11-11'),(3,'Alex','Johnson','M','UK','2001-06-18','2345678901','alexjohnson@example.com','$2y$10$X9g6.Ht2qQkV6s6J9NShV.2QppYFfPM.Fib/iGbgh9QUfqEb0/Hrm','2024-11-11','2024-11-11'),(4,'Emily','Davis','F','Australia','2002-11-30','3456789012','emilydavis@example.com','$2y$10$rt0J9yf3gof9.uLTodG3zO2H6BIFe/bP1yVpQPo91l9SxAw3pRHby','2024-11-11','2024-11-11'),(5,'Michael','Brown','M','Germany','2000-08-25','4567890123','michaelbrown@example.com','$2y$10$TqLtI2Se.uHr4sw8tcfRUu2H6oTwv0TklDW8pZFBuT4.csmk6BZGy','2024-11-11','2024-11-11');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;

--
-- Table structure for table `study_experience`
--

DROP TABLE IF EXISTS `study_experience`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `study_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `study_experience`
--

/*!40000 ALTER TABLE `study_experience` DISABLE KEYS */;
INSERT INTO `study_experience` VALUES (1,1,'Harvard University','Bachelor of Science','Computer Science','2018-09-01','2022-05-31'),(2,1,'University of Oxford','Master of Arts','Economics','2019-10-01','2021-09-30'),(3,2,'Stanford University','PhD','Physics','2020-01-15','2024-12-20'),(4,2,'Massachusetts Institute of Technology','Bachelor of Engineering','Mechanical Engineering','2017-08-20','2021-06-15'),(5,1,'University of Cambridge','Bachelor of Arts','Philosophy','2016-10-01','2020-06-30'),(6,1,'California Institute of Technology','Master of Science','Mathematics','2021-01-01','2022-12-31'),(7,2,'Princeton University','Bachelor of Arts','History','2015-09-01','2019-06-15'),(8,3,'University of Chicago','PhD','Political Science','2022-01-10','2026-06-20'),(9,4,'Columbia University','Master of Public Health','Epidemiology','2018-07-01','2020-05-31'),(10,4,'Yale University','Bachelor of Science','Biology','2017-09-01','2021-05-30');
/*!40000 ALTER TABLE `study_experience` ENABLE KEYS */;

--
-- Table structure for table `update`
--

DROP TABLE IF EXISTS `update`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL,
  `application_id` varchar(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `updates_ibfk_1` (`application_id`),
  CONSTRAINT `updates_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `update`
--

/*!40000 ALTER TABLE `update` DISABLE KEYS */;
INSERT INTO `update` VALUES (2,'Document Verification','Your documents are under review. Please allow 2-3 business days.','2024-11-11 09:30:00','3','2024-11-19','2024-11-19'),(3,'Payment Received','We have received your payment for the application.','2024-11-12 10:45:00','4','2024-11-19','2024-11-19'),(4,'Application Approved','Congratulations! Your application has been approved.','2024-11-13 11:20:00','5','2024-11-19','2024-11-19'),(5,'Additional Documents Needed','Please upload additional documents for further processing.','2024-11-14 14:00:00','3','2024-11-19','2024-11-19'),(6,'Final Review','Your application is in the final review stage.','2024-11-15 16:10:00','3','2024-11-19','2024-11-19'),(7,'Decision Released','The decision on your application has been released. Check your portal.','2024-11-16 17:25:00','5','2024-11-19','2024-11-19'),(8,'Application Closed','Your application has been closed as per your request.','2024-11-17 18:40:00','4','2024-11-19','2024-11-19'),(9,'Pending Payment','Your application is pending because payment has not been received.','2024-11-18 08:00:00','3','2024-11-19','2024-11-19'),(10,'Interview Scheduled','An interview has been scheduled for your application. Check your email.','2024-11-19 10:15:00','3','2024-11-19','2024-11-19'),(11,'Application Deferred','Your application has been deferred to the next intake.','2024-11-20 12:30:00','3','2024-11-19','2024-11-19'),(12,'Application Rejected','Unfortunately, your application did not meet the criteria.','2024-11-21 14:45:00','5','2024-11-19','2024-11-19'),(13,'Scholarship Granted','You have been awarded a partial scholarship for your application.','2024-11-22 16:00:00','4','2024-11-19','2024-11-19'),(15,'Login Activity  Now','We detected a login to your account from a new device.','2024-11-24 05:08:00','3','2024-11-19','2024-11-19'),(16,'Application Error','There was an error processing your application. Please contact support.','2024-11-25 17:50:00','4','2024-11-19','2024-11-19');
/*!40000 ALTER TABLE `update` ENABLE KEYS */;

--
-- Table structure for table `work_history`
--

DROP TABLE IF EXISTS `work_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` varchar(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `application_id` (`application_id`),
  CONSTRAINT `work_history_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `application` (`application_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_history`
--

/*!40000 ALTER TABLE `work_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_history` ENABLE KEYS */;

--
-- Dumping routines for database 'melek_global_education'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-24 12:05:11
