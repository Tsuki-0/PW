-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2026 at 05:14 PM
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
-- Database: `pw`
--
CREATE DATABASE IF NOT EXISTS `pw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `pw`;

-- --------------------------------------------------------

--
-- Table structure for table `enfermeiros`
--

CREATE TABLE `enfermeiros` (
  `ID` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `endereço` varchar(50) NOT NULL,
  `COREN` int(11) NOT NULL,
  `datanasc` datetime NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enfermeiros`
--

INSERT INTO `enfermeiros` (`ID`, `nome`, `endereço`, `COREN`, `datanasc`, `foto`) VALUES
(16, 'Ana Maria Santos', 'Rua das Flores, 123 - São Paulo/SP', 300032, '1985-03-15 00:00:00', 'anna-keibalo-9vH-wWpUP3g-unsplash.jpg'),
(17, 'Carlos Eduardo Lima', 'Av. Brasil, 456 - Rio de Janeiro/RJ', 300032, '1990-07-22 00:00:00', 'usman-yousaf-pTrhfmj2jDA-unsplash.jpg'),
(18, 'Fernanda Costa Oliveira', 'Rua Amazonas, 789 - Belo Horizonte/MG', 300032, '1982-11-05 00:00:00', 'enf_6a2c664394b771.25493501.jpg'),
(19, 'Roberto Alves Silva', 'Praça da Sé, 321 - Salvador/BA', 300032, '1978-09-18 00:00:00', 'ashkan-forouzani-DPEPYPBZpB8-unsplash.jpg'),
(20, 'Juliana Pereira Mendes', 'Av. Paulista, 1000 - São Paulo/SP', 300032, '1995-02-28 00:00:00', 'muhammad-hicham-AZDVF4fEcY4-unsplash.jpg'),
(21, 'Marcos Vinicius Souza', 'Rua XV de Novembro, 555 - Curitiba/PR', 300032, '1988-06-12 00:00:00', 'dalton-ngangi-ZCztndOWdjs-unsplash.jpg'),
(22, 'Patrícia Rodrigues Lima', 'Rua do Carmo, 777 - Recife/PE', 300032, '1992-12-03 00:00:00', 'maxim-tolchinskiy-Ex5WE95GwaI-unsplash.jpg'),
(23, 'André Luiz Ferreira', 'Av. Getúlio Vargas, 888 - Porto Alegre/RS', 300032, '1983-04-25 00:00:00', 'bruno-rodrigues-279xIHymPYY-unsplash.jpg'),
(24, 'Camila Rocha Barbosa', 'Rua Bahia, 444 - Brasília/DF', 300032, '1997-08-14 00:00:00', 'cdc-Y2lUjUiay-o-unsplash.jpg'),
(25, 'Ricardo José Martins', 'Av. Independência, 666 - Goiânia/GO', 300032, '1980-01-30 00:00:00', 'levi-meir-clancy-sX24JW-9tkU-unsplash.jpg'),
(26, 'Tatiane Cristina Nunes', 'Rua Acre, 222 - Manaus/AM', 300032, '1993-05-08 00:00:00', 'cheerful-happy-doctor-with-crossed-hands-white.jpg'),
(27, 'Eduardo Henrique Gomes', 'Av. Beira Mar, 999 - Fortaleza/CE', 300032, '1986-10-19 00:00:00', 'black-nurse-their-workspace.jpg'),
(28, 'Luciana Pereira Dias', 'Rua São João, 333 - Belém/PA', 300032, '1991-07-27 00:00:00', 'ani-kolleshi-7jjnJ-QA9fY-unsplash.jpg'),
(29, 'Gustavo Henrique Lopes', 'Av. Rio Branco, 777 - Santos/SP', 300032, '1984-03-09 00:00:00', 'luke-jones-CEFYNiM9xLk-unsplash.jpg'),
(30, 'Vanessa Cristina Silva', 'Rua Uruguai, 555 - Niterói/RJ', 300032, '1996-11-21 00:00:00', 'enf_6a2c696f1ad2f2.98822692.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enfermeiros`
--
ALTER TABLE `enfermeiros`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enfermeiros`
--
ALTER TABLE `enfermeiros`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
