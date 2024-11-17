-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-07-2024 a las 02:14:37
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apsystem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `absences`
--

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `absence_type_id` int(11) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `absences`
--

INSERT INTO `absences` (`id`, `employee_id`, `date`, `absence_type_id`, `reason`, `created_at`) VALUES
(30, 31, '2024-07-01', 5, NULL, '2024-07-16 21:10:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `absence_types`
--

CREATE TABLE `absence_types` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `absence_types`
--

INSERT INTO `absence_types` (`id`, `description`) VALUES
(1, 'Enfermedad'),
(2, 'Motivos personales'),
(3, 'Vacaciones'),
(4, 'Licencia'),
(5, 'Falta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'eneirah', '$2y$10$UrGSvHTWm8.ZK4BzPmo8iuqsK6XF5RfHay6ooC5D50y/nShon5wqe', 'Erick', 'Neira', 'Facha.jpeg', '2024-05-21'),
(2, 'eneirah', '$2y$10$UrGSvHTWm8.ZK4BzPmo8iuqsK6XF5RfHay6ooC5D50y/nShon5wqe', 'Erick', 'Neira Huamán', '', '2024-05-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `status` int(1) NOT NULL,
  `time_out` time NOT NULL,
  `num_hr` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `status`, `time_out`, `num_hr`) VALUES
(133, 31, '0000-00-00', '07:45:00', 1, '16:00:00', 7),
(144, 31, '2024-06-04', '07:45:00', 1, '16:45:00', 7),
(147, 31, '0000-00-00', '08:45:00', 0, '16:00:00', 6.25),
(149, 31, '2024-07-04', '07:55:00', 1, '16:10:00', 7),
(158, 31, '2024-07-16', '07:45:00', 1, '16:15:00', 7),
(168, 50, '2024-07-02', '07:45:00', 1, '18:45:00', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bonuses`
--

CREATE TABLE `bonuses` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bonuses`
--

INSERT INTO `bonuses` (`id`, `description`, `amount`) VALUES
(1, 'BONIFICACIONES REGULARES', 300),
(2, 'PACTO COLECTIVO', 300),
(3, 'BONIFICACIÓN DIFERENCIAL', 300),
(7, 'nuevo bono', 250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cashadvance`
--

CREATE TABLE `cashadvance` (
  `id` int(11) NOT NULL,
  `date_advance` date NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cashadvance`
--

INSERT INTO `cashadvance` (`id`, `date_advance`, `employee_id`, `amount`) VALUES
(8, '2024-07-16', '31', 500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `deductions`
--

INSERT INTO `deductions` (`id`, `description`, `amount`) VALUES
(6, 'RENTA DE QUINTA CATEGORIA RETENCIONES', 0),
(10, 'CUOTA SINDICAL', 30),
(11, 'PRIMA DE SEGURO AFP', 43),
(12, 'SPP - APORTACIÓN OBLIGATORIA', 256),
(17, 'descuento', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `firstname`, `lastname`, `address`, `birthdate`, `contact_info`, `gender`, `position_id`, `schedule_id`, `photo`, `created_on`) VALUES
(31, 'NEB134890756', 'ERICK', 'NEIRA HUAMAN', 'Pacaipampa', '2002-05-09', '940558108', 'Masculino', 1, 1, 'OIP.jpg', '2024-06-01'),
(32, 'EQI897635410', 'NELLY', 'HUAMAN ORTIZ', 'Pacaipampa', '2002-03-13', '845116561', 'Femenino', 2, 1, 'OIP.jpg', '2024-06-01'),
(37, 'IGT645073281', 'DANIEL', 'ARRIOLA CHUQUICUSMA', 'PACAIPAMPA', '1999-02-09', '956412887', 'Masculino', 2, 1, 'OIP.jpg', '2024-07-16'),
(38, 'RVD068341957', 'PEDRO', 'CALLE CALLE', 'PACAIPAMPA', '1997-10-15', '987865897', 'Masculino', 10, 1, 'OIP.jpg', '2024-07-16'),
(39, 'GHC935048617', 'HILARIA', 'CARHUAPOMA CORDOVA', 'PACAIPAMPA', '1994-02-28', '985878777', 'Femenino', 7, 1, 'OIP.jpg', '2024-07-16'),
(50, 'HJY675391482', 'Lusito', 'ejemplo', 'ejemplo', '2000-06-13', '959599959', 'Masculino', 27, 1, 'Fondo_Pregrado.png', '2024-07-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `hours` double NOT NULL,
  `rate` double NOT NULL,
  `date_overtime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `position`
--

INSERT INTO `position` (`id`, `description`, `rate`) VALUES
(1, 'PROGRAMADOR', 100),
(2, 'CONTADOR', 100),
(5, 'INGENIERO CIVIL', 3500),
(6, 'ALCALDE', 3000),
(7, 'SECRETARIO', 2000),
(8, 'TESORERO', 2500),
(9, 'ARQUITECTO', 3500),
(11, 'FUNCIONARIO DE IMPUESTOS Y RENTAS', 3000),
(12, 'INGENIERO DE SISTEMAS', 3000),
(27, 'cargo ejemplo', 500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out`) VALUES
(1, '08:00:00', '16:00:00'),
(7, '08:00:00', '12:15:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `absence_type_id` (`absence_type_id`);

--
-- Indices de la tabla `absence_types`
--
ALTER TABLE `absence_types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bonuses`
--
ALTER TABLE `bonuses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cashadvance`
--
ALTER TABLE `cashadvance`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `absence_types`
--
ALTER TABLE `absence_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT de la tabla `bonuses`
--
ALTER TABLE `bonuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cashadvance`
--
ALTER TABLE `cashadvance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `absences_ibfk_2` FOREIGN KEY (`absence_type_id`) REFERENCES `absence_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
