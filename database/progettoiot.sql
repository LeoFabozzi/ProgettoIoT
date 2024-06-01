-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 01, 2024 alle 17:32
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progettoiot`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `access_allarm`
--

CREATE TABLE `access_allarm` (
  `id` int(11) NOT NULL,
  `allarm` varchar(255) NOT NULL,
  `access_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `access_allarm`
--

INSERT INTO `access_allarm` (`id`, `allarm`, `access_time`) VALUES
(1, 'disattivato', '2024-06-01 13:44:45');

-- --------------------------------------------------------

--
-- Struttura della tabella `access_logs`
--

CREATE TABLE `access_logs` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `access_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `access_logs`
--

INSERT INTO `access_logs` (`id`, `uid`, `user_id`, `access_time`) VALUES
(1, '83 AC AF 0D', 1, '2024-06-01 13:44:24'),
(2, '83 AC AF 0D', 1, '2024-06-01 13:44:32'),
(3, '83 AC AF 0D', 1, '2024-06-01 13:44:51'),
(4, '83 AC AF 0D', 1, '2024-06-01 13:46:20'),
(5, '83 AC AF 0D', 1, '2024-06-01 13:46:26'),
(6, '83 AC AF 0D', 1, '2024-06-01 13:48:56'),
(7, '83 AC AF 0D', 1, '2024-06-01 13:49:00'),
(8, '83 AC AF 0D', 1, '2024-06-01 13:49:06'),
(9, '83 AC AF 0D', 1, '2024-06-01 13:49:09');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `uid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `email`, `username`, `password`, `role`, `uid`) VALUES
(1, 'leofabozzi@gmail.com', 'admin', '$2y$10$ARUIioqDXkH.fEcJF2WSzeQMaFtc/KlNzRriai1cDv/afb19V1Kma', 'admin', '83 AC AF 0D'),
(3, 'leo1@gmail.com', 'leo', '$2y$10$4mOehID3u6K20rwtNh8TtOPEjJ11OjRPddLFf4H0KG00FjrAyIipy', 'admin', '83%02AC%02AF%020D');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `access_allarm`
--
ALTER TABLE `access_allarm`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `access_logs`
--
ALTER TABLE `access_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `access_allarm`
--
ALTER TABLE `access_allarm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `access_logs`
--
ALTER TABLE `access_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `access_logs`
--
ALTER TABLE `access_logs`
  ADD CONSTRAINT `access_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utenti` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
