-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 19, 2022 at 01:39 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`aemail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aemail`, `apassword`) VALUES
('admin@ipn.com', 'charmander');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `appoid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(10) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  PRIMARY KEY (`appoid`),
  KEY `pid` (`pid`),
  KEY `scheduleid` (`scheduleid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appoid`, `pid`, `apponum`, `scheduleid`, `appodate`) VALUES
(1, 1, 1, 1, '2025-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
CREATE TABLE IF NOT EXISTS `doctor` (
  `docid` int(11) NOT NULL AUTO_INCREMENT,
  `docemail` varchar(255) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  `docpassword` varchar(255) DEFAULT NULL,
  `docnic` varchar(15) DEFAULT NULL,
  `doctel` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL,
  PRIMARY KEY (`docid`),
  KEY `specialties` (`specialties`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`docid`, `docemail`, `docname`, `docpassword`, `docnic`, `doctel`, `specialties`) VALUES
(1, 'especialista@ipn.com', 'Especialista Prueba', 'charmander', 'AAAAAAAAA', '5500551100', 1),
(2, 'jovani@gmail.com', 'Sarabia Jovani', '123', '2022350996', '0700000000', 20);
-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pnic` varchar(15) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `ptel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pid`, `pemail`, `pname`, `ppassword`, `paddress`, `pnic`, `pdob`, `ptel`) VALUES
(1, 'paciente@ipn.com', 'Test Patient', '123', 'Tacubaya', 'BBBBAAA', '2026-01-01', '5522350996'),
(2, 'sarabiajovani@gmail.com', 'Sarabia Jovani', '123', 'Oajaca', 'SAA202HBCRVA5', '2025-06-03', '55111000');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `scheduleid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL,
  PRIMARY KEY (`scheduleid`),
  KEY `docid` (`docid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `docid`, `title`, `scheduledate`, `scheduletime`, `nop`) VALUES
(1, '1', 'Sesión Prueba', '2025-09-01', '18:00:00', 8),
(2, '1', '1', '2025-06-10', '20:36:00', 12);


-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

DROP TABLE IF EXISTS `specialties`;
CREATE TABLE IF NOT EXISTS `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `sname`) VALUES
(1, 'Terapia Cognitivo Conductual infantil (TCC)'),
(2, 'Manejo de alergias relacionadas con salud mental'),
(3, 'Soporte en cuidados perioperatorios y manejo del dolor'),
(4, 'Hematología psicológica'),
(5, 'Intervenciones en salud cardiaca y soporte psicoemocional para niños con cardiopatías'),
(6, 'Psicología clínica y test neuropsicológico'),
(7, 'Psiquiatría infantil'),
(8, 'Psicodiagnóstico y análisis bioquímico asociado a tratamientos'),
(9, 'Evaluación neurofisiológica y terapias basadas en EEG/estudios del sueño'),
(10, 'Dermatología y apoyo psicológico por condición cutánea crónica'),
(11, 'Cuidado dermatológico y estrategias psicosociales para niños con enfermedades visibles'),
(12, 'Soporte endocrinológico y terapia psicosocial en trastornos del desarrollo puberal'),
(13, 'Apoyo psicológico perioperatorio en cirugías gastroenterológicas pediátricas'),
(14, 'Intervención en problemas digestivos con componente emocional'),
(15, 'Apoyo psicológico en enfermedades hematológicas generales'),
(16, 'Atención primaria con enfoque en salud mental infantil'),
(17, 'Geriatría pediátrica'),
(18, 'Inmunología y salud mental'),
(19, 'Manejo psicosocial de enfermedades infecciosas crónicas en niños'),
(20, 'Medicina interna pediátrica con enfoque biopsicosocial'),
(21, 'Laboratorio y evaluación para apoyar diagnósticos psiquiátricos'),
(22, 'Apoyo psicológico en cirugía maxilofacial'),
(23, 'Microbiología y salud mental'),
(24, 'Soporte para enfermedades renales crónicas en infancia'),
(25, 'Neuropsiquiatría infantil'),
(26, 'Neurología pediátrica y apoyo en epilepsias'),
(27, 'Soporte psicológico pre/post neurocirugía pediátrica'),
(28, 'Obstetricia y ginecología juvenil'),
(29, 'Medicina ocupacional pediátrica'),
(30, 'Atención oftalmológica y soporte para problemas visuales que afectan aprendizaje y autoestima'),
(31, 'Rehabilitación ortopédica con enfoque en salud mental'),
(32, 'Trastornos de la comunicación y audición'),
(33, 'Pediatría con enfoque en salud mental'),
(34, 'Apoyo en procesos patológicos crónicos y duelo en infancia'),
(35, 'Farmacología clínica pediatricada y monitoreo psicofarmacológico'),
(36, 'Medicina física y rehabilitación con terapia ocupacional'),
(37, 'Cirugía plástica y apoyo psicológico en reconstrucción y aceptación corporal'),
(38, 'Medicina podiátrica y asesoría en problemas de marcha que afectan actividad y estado anímico'),
(39, 'Cirugía podiátrica y rehabilitación funcional con soporte psicosocial'),
(40, 'Salud pública y prevención'),
(41, 'Radioterapia pediátrica'),
(42, 'Reumatología pediátrica y apoyo psicológico'),
(43, 'Salud bucodental y su relación con autoestima'),
(44, 'Urología pediátrica y acompañamiento psicológico'),
(45, 'Salud sexual y venereología juvenil'),
(46, 'Cirugía vascular pediátrica con rehabilitación y apoyo psicosocial');

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

DROP TABLE IF EXISTS `webuser`;
CREATE TABLE IF NOT EXISTS `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webuser`
--
START TRANSACTION;

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('admin@ipn.com', 'a'),
('especialista@ipn.com', 'd'),
('paciente@ipn.com', 'p'),
('jovani@gmail.com', 'd');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
