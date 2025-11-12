-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 19. Jul 2025 um 21:12
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `mustermann`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ausstattung`
--

CREATE TABLE `ausstattung` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `modell` varchar(100) DEFAULT NULL,
  `preis` decimal(10,2) DEFAULT NULL,
  `bild` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `ausstattung`
--

INSERT INTO `ausstattung` (`id`, `name`, `modell`, `preis`, `bild`) VALUES
(1, 'GPU', 'ASUS ROG RTX 5090', 1999.00, 'rog5090.jpg'),
(2, 'GPU', 'MSI Suprim RTX 5080', 1499.00, 'rtx5080.jpg'),
(3, 'SSD NVMe', 'Samsung 990 Pro 1TB', 129.00, '990pro.jpg'),
(4, 'AiO Wasserkühlung', 'ASUS ROG Ryuo III', 229.00, 'ryuoiii.jpg'),
(5, 'aRGB Lüfter x3', 'LianLi Uni Fan SL120 x3', 89.00, 'sl120.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellungen`
--

CREATE TABLE `bestellungen` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `gehäuse` varchar(100) DEFAULT NULL,
  `cpu_id` int(11) DEFAULT NULL,
  `ram` int(11) DEFAULT NULL,
  `zubehoer` text DEFAULT NULL,
  `ausstattung` text DEFAULT NULL,
  `bestelldatum` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `bestellungen`
--

INSERT INTO `bestellungen` (`id`, `user_id`, `gehäuse`, `cpu_id`, `ram`, `zubehoer`, `ausstattung`, `bestelldatum`) VALUES
(3, 1, 'ASUS ROG Hyperion GR701 – 289,99 €', 1, 32, '[\"1\",\"2\",\"3\"]', '[\"5\"]', '2025-07-19 19:50:27'),
(4, 1, 'Lenovo Desktop PC – 49,99 €', 3, 32, '[\"5\"]', '[\"3\"]', '2025-07-19 19:55:14'),
(5, 3, 'Corsair 6500X – 69,99 €', 1, 32, '[]', '[\"2\",\"4\",\"5\"]', '2025-07-19 20:00:26'),
(6, 1, 'Cooler Master HAF 700 EVO – 99,99 €', 1, 32, '[]', '[\"2\",\"4\"]', '2025-07-19 20:16:53'),
(7, 1, 'Corsair 6500X – 69,99 €', 3, 8, '[]', '[\"1\",\"5\"]', '2025-07-19 21:01:36'),
(8, 1, 'LianLi O11D Evo RGB – 59,99 €', 2, 8, '[]', '[]', '2025-07-19 21:03:20'),
(9, 1, 'LianLi O11D Evo RGB – 59,99 €', 2, 8, '[]', '[]', '2025-07-19 21:03:28'),
(10, 1, 'LianLi O11D Evo RGB – 59,99 €', 2, 8, '[]', '[]', '2025-07-19 21:04:03');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cpus`
--

CREATE TABLE `cpus` (
  `id` int(11) NOT NULL,
  `modell` varchar(100) DEFAULT NULL,
  `hersteller` enum('Intel','AMD') DEFAULT NULL,
  `max_ram` varchar(20) DEFAULT NULL,
  `preis` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `cpus`
--

INSERT INTO `cpus` (`id`, `modell`, `hersteller`, `max_ram`, `preis`) VALUES
(1, 'i5-14600K', 'Intel', '192 GB', 299.00),
(2, 'i7-14700K', 'Intel', '192 GB', 399.00),
(3, 'i9-14900K', 'Intel', '192 GB', 599.00),
(4, 'Ryzen 7 7800X3D', 'AMD', '128 GB', 429.00),
(5, 'Ryzen 7 9800X3D', 'AMD', '192 GB', 549.00);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `nachname` varchar(50) DEFAULT NULL,
  `vorname` varchar(50) DEFAULT NULL,
  `eintrittsjahr` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `team`
--

INSERT INTO `team` (`id`, `nachname`, `vorname`, `eintrittsjahr`) VALUES
(1, 'Müller', 'Max', 2003),
(2, 'Meier', 'Martin', 2019),
(3, 'Unger', 'Ulrike', 2010),
(4, 'Peters', 'Paul', 2018),
(5, 'Schmid', 'Sandra', 2015);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `anrede` varchar(10) NOT NULL,
  `vorname` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firma` varchar(255) DEFAULT NULL,
  `strasse` varchar(255) NOT NULL,
  `plz` varchar(5) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `anrede`, `vorname`, `nachname`, `email`, `firma`, `strasse`, `plz`, `passwort`, `erstellt_am`) VALUES
(1, 'Herr', 'Jiaxu', 'Shen', 'jxshen2009@muster.com', '', 'Musterstraße 107', '60435', '$2y$10$udps506.d9olgzhOYmrcgeELP5PQgZaJxpoNYyg89ondAnVfFlykm', '2025-07-19 17:47:45'),
(2, 'Frau', 'Mengyu', 'Wang', 'guiqulaixi2021@gmail.com', '', 'in der Burg 15', '61169', '$2y$10$7AeLhFsQg7YbBDCNAWssH.O20iLmQZPzR7r5NE5jvNtnp/bsm1Fny', '2025-07-19 17:53:50'),
(3, 'Herr', 'Max', 'Mustermann', 'Muster@gmail.com', '', 'Musterstraße 106', '60435', '$2y$10$VLzNZUixVLeX48Wm//nUHug0lZSaElWYerNVpkzrr1zo82ousDetG', '2025-07-19 18:00:01');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zubehoer`
--

CREATE TABLE `zubehoer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `modell` varchar(100) DEFAULT NULL,
  `preis` decimal(10,2) DEFAULT NULL,
  `bild` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `zubehoer`
--

INSERT INTO `zubehoer` (`id`, `name`, `modell`, `preis`, `bild`) VALUES
(1, 'Gaming Mouse', 'Logitech G502', 69.99, 'g502.jpg'),
(2, 'Gaming Tastatur', 'ASUS ROG Flare II', 159.00, 'rogii.jpg'),
(3, 'Gaming Mousepad', 'ASUS ROG Balteus', 99.00, 'balteus.jpg'),
(4, 'Gaming Headset', 'Razer Kraken', 89.00, 'razer.jpg'),
(5, 'Mikrofon', 'ASUS ROG Carnyx', 139.00, 'carnyx.jpg');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ausstattung`
--
ALTER TABLE `ausstattung`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cpus`
--
ALTER TABLE `cpus`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `zubehoer`
--
ALTER TABLE `zubehoer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ausstattung`
--
ALTER TABLE `ausstattung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `cpus`
--
ALTER TABLE `cpus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `zubehoer`
--
ALTER TABLE `zubehoer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
