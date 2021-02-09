-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql-egroupware-bio-meyer
-- Erstellungszeit: 09. Feb 2021 um 21:15
-- Server-Version: 8.0.20
-- PHP-Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `your database`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_articles`
--

CREATE TABLE `rosine_articles` (
                                   `ART_NUMBER` varchar(40) NOT NULL,
                                   `ART_NAME` varchar(255) NOT NULL,
                                   `ART_UNIT` varchar(20) DEFAULT NULL,
                                   `ART_PRICE` decimal(8,2) DEFAULT NULL,
                                   `ART_TAX` tinyint DEFAULT '1',
                                   `ART_STOCKNR` smallint NOT NULL DEFAULT '1',
                                   `ART_INSTOCK` int DEFAULT NULL,
                                   `ART_NOTE` varchar(1100) DEFAULT NULL,
                                   `GENERATED` varchar(100) DEFAULT NULL,
                                   `CHANGED` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_config`
--

CREATE TABLE `rosine_config` (
                                 `config` varchar(60) NOT NULL,
                                 `user_id` int NOT NULL,
                                 `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_deliveries`
--

CREATE TABLE `rosine_deliveries` (
                                     `COMPANY_ID` tinyint NOT NULL DEFAULT '0',
                                     `DELIVERY_ID` int NOT NULL,
                                     `DELIVERY_DATE` date DEFAULT NULL,
                                     `DELIVERY_CUSTOMER` int DEFAULT NULL,
                                     `DELIVERY_CUSTOMER_PRIVATE` tinyint NOT NULL DEFAULT '1',
                                     `DELIVERY_AMMOUNT` decimal(8,2) DEFAULT NULL,
                                     `DELIVERY_AMMOUNT_BRUTTO` decimal(8,2) DEFAULT NULL,
                                     `DELIVERY_NOTE` text,
                                     `DELIVERY_STATUS` varchar(10) NOT NULL,
                                     `DELIVERY_TEMPLATE` varchar(250) DEFAULT NULL,
                                     `DELIVERY_PRINTED` tinyint NOT NULL DEFAULT '0',
                                     `GENERATED` varchar(100) DEFAULT NULL,
                                     `CHANGED` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_deliveries_positions`
--

CREATE TABLE `rosine_deliveries_positions` (
                                               `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                               `DELIVERY_ID` int NOT NULL,
                                               `POSI_ID` int NOT NULL,
                                               `ART_NUMBER` varchar(40) NOT NULL,
                                               `POSI_AMMOUNT` decimal(9,3) DEFAULT NULL,
                                               `POSI_UNIT` varchar(20) DEFAULT NULL,
                                               `POSI_PRICE` decimal(8,2) DEFAULT NULL,
                                               `POSI_LOCATION` smallint DEFAULT NULL,
                                               `POSI_SERIAL` varchar(40) DEFAULT NULL,
                                               `POSI_TEXT` varchar(1255) DEFAULT NULL,
                                               `POSI_TAX` tinyint NOT NULL,
                                               `DONE` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_drafts`
--

CREATE TABLE `rosine_drafts` (
                                 `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                 `DRAFT_ID` int NOT NULL,
                                 `DRAFT_DATE` date DEFAULT NULL,
                                 `DRAFT_CUSTOMER` int DEFAULT NULL,
                                 `DRAFT_CUSTOMER_PRIVATE` tinyint NOT NULL DEFAULT '1',
                                 `DRAFT_AMMOUNT` decimal(8,2) DEFAULT NULL,
                                 `DRAFT_AMMOUNT_BRUTTO` decimal(8,2) DEFAULT NULL,
                                 `DRAFT_NOTE` text,
                                 `DRAFT_STATUS` varchar(10) NOT NULL,
                                 `DRAFT_TEMPLATE` varchar(250) DEFAULT NULL,
                                 `DRAFT_PRINTED` tinyint NOT NULL DEFAULT '0',
                                 `GENERATED` varchar(100) DEFAULT NULL,
                                 `CHANGED` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_drafts_positions`
--

CREATE TABLE `rosine_drafts_positions` (
                                           `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                           `DRAFT_ID` int NOT NULL,
                                           `POSI_ID` int NOT NULL,
                                           `ART_NUMBER` varchar(40) NOT NULL,
                                           `POSI_AMMOUNT` decimal(9,3) DEFAULT NULL,
                                           `POSI_UNIT` varchar(20) DEFAULT NULL,
                                           `POSI_PRICE` decimal(8,2) DEFAULT NULL,
                                           `POSI_LOCATION` smallint DEFAULT NULL,
                                           `POSI_SERIAL` varchar(40) DEFAULT NULL,
                                           `POSI_TEXT` varchar(1255) DEFAULT NULL,
                                           `POSI_TAX` tinyint NOT NULL,
                                           `DONE` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_invoices`
--

CREATE TABLE `rosine_invoices` (
                                   `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                   `INVOICE_ID` int NOT NULL,
                                   `INVOICE_DATE` date DEFAULT NULL,
                                   `INVOICE_CUSTOMER` int DEFAULT NULL,
                                   `INVOICE_CUSTOMER_PRIVATE` tinyint NOT NULL DEFAULT '1',
                                   `INVOICE_AMMOUNT` decimal(8,2) DEFAULT NULL,
                                   `INVOICE_AMMOUNT_BRUTTO` decimal(8,2) DEFAULT NULL,
                                   `INVOICE_NOTE` text,
                                   `INVOICE_STATUS` varchar(10) NOT NULL,
                                   `INVOICE_TEMPLATE` varchar(250) DEFAULT NULL,
                                   `INVOICE_PRINTED` tinyint DEFAULT '0',
                                   `GENERATED` varchar(100) DEFAULT NULL,
                                   `CHANGED` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_invoices_positions`
--

CREATE TABLE `rosine_invoices_positions` (
                                             `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                             `INVOICE_ID` int NOT NULL,
                                             `POSI_ID` int NOT NULL,
                                             `ART_NUMBER` varchar(40) NOT NULL,
                                             `POSI_AMMOUNT` decimal(9,3) DEFAULT NULL,
                                             `POSI_UNIT` varchar(20) DEFAULT NULL,
                                             `POSI_PRICE` decimal(8,2) DEFAULT NULL,
                                             `POSI_LOCATION` smallint DEFAULT NULL,
                                             `POSI_SERIAL` varchar(40) DEFAULT NULL,
                                             `POSI_TEXT` varchar(1255) DEFAULT NULL,
                                             `POSI_TAX` tinyint NOT NULL,
                                             `DONE` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_locations`
--

CREATE TABLE `rosine_locations` (
                                    `LOC_ID` smallint NOT NULL,
                                    `LOC_NAME` varchar(255) NOT NULL,
                                    `LOC_NOTE` varchar(1100) DEFAULT NULL,
                                    `GENERATED` varchar(100) DEFAULT NULL,
                                    `CHANGED` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_notes`
--

CREATE TABLE `rosine_notes` (
                                `NOTE_ID` int NOT NULL,
                                `LANGUAGE` varchar(60) NOT NULL,
                                `NOTE_TEXT` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_offers`
--

CREATE TABLE `rosine_offers` (
                                 `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                 `OFFER_ID` int NOT NULL,
                                 `OFFER_DATE` date DEFAULT NULL,
                                 `OFFER_CUSTOMER` int DEFAULT NULL,
                                 `OFFER_CUSTOMER_PRIVATE` tinyint NOT NULL DEFAULT '1',
                                 `OFFER_AMMOUNT` decimal(8,2) DEFAULT NULL,
                                 `OFFER_AMMOUNT_BRUTTO` decimal(8,2) DEFAULT NULL,
                                 `OFFER_NOTE` varchar(1100) DEFAULT NULL,
                                 `OFFER_STATUS` varchar(10) NOT NULL,
                                 `OFFER_TEMPLATE` varchar(250) DEFAULT NULL,
                                 `OFFER_PRINTED` tinyint DEFAULT '0',
                                 `GENERATED` varchar(100) DEFAULT NULL,
                                 `CHANGED` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_offers_positions`
--

CREATE TABLE `rosine_offers_positions` (
                                           `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                           `OFFER_ID` int NOT NULL,
                                           `POSI_ID` int NOT NULL,
                                           `ART_NUMBER` varchar(40) NOT NULL,
                                           `POSI_AMMOUNT` decimal(9,3) DEFAULT NULL,
                                           `POSI_UNIT` varchar(20) DEFAULT NULL,
                                           `POSI_PRICE` decimal(8,2) DEFAULT NULL,
                                           `POSI_LOCATION` smallint DEFAULT NULL,
                                           `POSI_SERIAL` varchar(40) DEFAULT NULL,
                                           `POSI_TEXT` varchar(1255) DEFAULT NULL,
                                           `POSI_TAX` tinyint NOT NULL,
                                           `DONE` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_orders`
--

CREATE TABLE `rosine_orders` (
                                 `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                 `ORDER_ID` int NOT NULL,
                                 `ORDER_DATE` date DEFAULT NULL,
                                 `ORDER_CUSTOMER` int DEFAULT NULL,
                                 `ORDER_CUSTOMER_PRIVATE` tinyint NOT NULL DEFAULT '1',
                                 `ORDER_AMMOUNT` decimal(8,2) DEFAULT NULL,
                                 `ORDER_AMMOUNT_BRUTTO` decimal(8,2) DEFAULT NULL,
                                 `ORDER_NOTE` varchar(1100) DEFAULT NULL,
                                 `ORDER_STATUS` varchar(10) NOT NULL,
                                 `ORDER_TEMPLATE` varchar(250) DEFAULT NULL,
                                 `ORDER_PRINTED` tinyint DEFAULT '0',
                                 `GENERATED` varchar(100) DEFAULT NULL,
                                 `CHANGED` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_orders_positions`
--

CREATE TABLE `rosine_orders_positions` (
                                           `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                           `ORDER_ID` int NOT NULL,
                                           `POSI_ID` int NOT NULL,
                                           `ART_NUMBER` varchar(40) NOT NULL,
                                           `POSI_AMMOUNT` decimal(9,3) DEFAULT NULL,
                                           `POSI_UNIT` varchar(20) DEFAULT NULL,
                                           `POSI_PRICE` decimal(8,2) DEFAULT NULL,
                                           `POSI_LOCATION` smallint DEFAULT NULL,
                                           `POSI_SERIAL` varchar(40) DEFAULT NULL,
                                           `POSI_TEXT` varchar(1255) DEFAULT NULL,
                                           `POSI_TAX` tinyint NOT NULL,
                                           `DONE` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_payments`
--

CREATE TABLE `rosine_payments` (
                                   `COMPANY_ID` tinyint NOT NULL DEFAULT '1',
                                   `PAYMENT_ID` int NOT NULL,
                                   `INVOICE_ID` int DEFAULT NULL,
                                   `PAYMENT_DATE` date DEFAULT NULL,
                                   `METH_ID` int DEFAULT NULL,
                                   `PAYMENT_AMMOUNT` decimal(8,2) DEFAULT NULL,
                                   `PAYMENT_NOTE` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_payments_methods`
--

CREATE TABLE `rosine_payments_methods` (
                                           `METH_ID` smallint NOT NULL,
                                           `METH_NAME` varchar(255) NOT NULL,
                                           `METH_NOTE` text,
                                           `GENERATED` varchar(100) DEFAULT NULL,
                                           `CHANGED` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rosine_taxes`
--

CREATE TABLE `rosine_taxes` (
                                `TAX_ID` tinyint NOT NULL,
                                `TAX_NAME` varchar(20) DEFAULT NULL,
                                `TAX_PERCENTAGE` decimal(4,2) NOT NULL,
                                `GENERATED` varchar(100) NOT NULL,
                                `CHANGED` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `rosine_articles`
--
ALTER TABLE `rosine_articles`
    ADD PRIMARY KEY (`ART_NUMBER`);

--
-- Indizes für die Tabelle `rosine_config`
--
ALTER TABLE `rosine_config`
    ADD PRIMARY KEY (`config`,`user_id`);

--
-- Indizes für die Tabelle `rosine_deliveries`
--
ALTER TABLE `rosine_deliveries`
    ADD PRIMARY KEY (`COMPANY_ID`,`DELIVERY_ID`);

--
-- Indizes für die Tabelle `rosine_deliveries_positions`
--
ALTER TABLE `rosine_deliveries_positions`
    ADD PRIMARY KEY (`COMPANY_ID`,`DELIVERY_ID`,`POSI_ID`);

--
-- Indizes für die Tabelle `rosine_drafts`
--
ALTER TABLE `rosine_drafts`
    ADD PRIMARY KEY (`COMPANY_ID`,`DRAFT_ID`);

--
-- Indizes für die Tabelle `rosine_drafts_positions`
--
ALTER TABLE `rosine_drafts_positions`
    ADD PRIMARY KEY (`COMPANY_ID`,`DRAFT_ID`,`POSI_ID`);

--
-- Indizes für die Tabelle `rosine_invoices`
--
ALTER TABLE `rosine_invoices`
    ADD PRIMARY KEY (`COMPANY_ID`,`INVOICE_ID`);

--
-- Indizes für die Tabelle `rosine_invoices_positions`
--
ALTER TABLE `rosine_invoices_positions`
    ADD PRIMARY KEY (`COMPANY_ID`,`INVOICE_ID`,`POSI_ID`);

--
-- Indizes für die Tabelle `rosine_locations`
--
ALTER TABLE `rosine_locations`
    ADD PRIMARY KEY (`LOC_ID`);

--
-- Indizes für die Tabelle `rosine_notes`
--
ALTER TABLE `rosine_notes`
    ADD PRIMARY KEY (`NOTE_ID`,`LANGUAGE`);

--
-- Indizes für die Tabelle `rosine_offers`
--
ALTER TABLE `rosine_offers`
    ADD PRIMARY KEY (`COMPANY_ID`,`OFFER_ID`);

--
-- Indizes für die Tabelle `rosine_offers_positions`
--
ALTER TABLE `rosine_offers_positions`
    ADD PRIMARY KEY (`COMPANY_ID`,`OFFER_ID`,`POSI_ID`);

--
-- Indizes für die Tabelle `rosine_orders`
--
ALTER TABLE `rosine_orders`
    ADD PRIMARY KEY (`COMPANY_ID`,`ORDER_ID`);

--
-- Indizes für die Tabelle `rosine_orders_positions`
--
ALTER TABLE `rosine_orders_positions`
    ADD PRIMARY KEY (`COMPANY_ID`,`ORDER_ID`,`POSI_ID`);

--
-- Indizes für die Tabelle `rosine_payments`
--
ALTER TABLE `rosine_payments`
    ADD PRIMARY KEY (`COMPANY_ID`,`PAYMENT_ID`);

--
-- Indizes für die Tabelle `rosine_payments_methods`
--
ALTER TABLE `rosine_payments_methods`
    ADD PRIMARY KEY (`METH_ID`);

--
-- Indizes für die Tabelle `rosine_taxes`
--
ALTER TABLE `rosine_taxes`
    ADD PRIMARY KEY (`TAX_ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `rosine_notes`
--
ALTER TABLE `rosine_notes`
    MODIFY `NOTE_ID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
