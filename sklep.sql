-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Kwi 2023, 00:51
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `tytul` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `autor` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `rok` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `id` int(11) NOT NULL,
  `muzyka` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`tytul`, `autor`, `rok`, `id`, `muzyka`) VALUES
('Walc a-moll', 'Fryderyk Chopin', '1835-1838', 1, 'muzyka/Walc-a-moll.mp3'),
('Walc Es-dur', 'Fryderyk Chopin', '1833', 2, 'muzyka/Walc-Es-dur.mp3'),
('Polonez', 'Fryderyk Chopin', '1817', 3, 'muzyka/Polonez.mp3'),
('Toccata i fuga', 'Jan Sebastian Bach', '1706', 4, 'muzyka/Toccata-i-fuga.mp3'),
('Air', 'Jan Sebastian Bach', '1717-1723', 5, 'muzyka/Air.mp3'),
('Requiem Mass K. 626', 'Wolfgang Amadeus Mozart', '1791', 6, 'muzyka/Lacrimosa.mp3'),
('Cztery pory roku - Lato cz.II Adagio', 'Antonio Vivaldi', '1725', 7, 'muzyka/Storm.mp3'),
('Fur Elise', 'Ludwig van Beethoven', '1808-1810', 8, 'muzyka/Fur-Elise.mp3'),
('Szaman Ty i Ja', 'Współczesny Szaman', '2017', 9, 'muzyka/Szaman-ty-i-ja.mp3');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `nazwisko` varchar(35) COLLATE utf8_polish_ci DEFAULT NULL,
  `nazwa` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `haslo` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `email` varchar(70) COLLATE utf8_polish_ci DEFAULT NULL,
  `numer` varchar(15) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) NOT NULL,
  `id_uzytkownika` int(11) DEFAULT NULL,
  `produkty` mediumtext COLLATE utf8_polish_ci DEFAULT NULL,
  `platnosc` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
