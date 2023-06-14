<?php

$create[] ="CREATE TABLE `".$prefix."answers` (
  `ID_answer` int(11) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_inquirystatus` int(11) NOT NULL,
  `Czas` datetime NOT NULL,
  `ID_inquiry` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."category` (
  `ID_category` int(11) NOT NULL,
  `category_name` text NOT NULL,
  `category_img` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."inquiries` (
  `ID_inquiry` int(11) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_item` int(11) NOT NULL,
  `ID_inquirystatus` int(11) NOT NULL,
  `Czas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."inquiriesstatus` (
  `ID_inquirystatus` int(11) NOT NULL,
  `inquiry_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."items` (
  `ID_item` int(11) NOT NULL,
  `ID_category` int(11) NOT NULL,
  `brand` text NOT NULL,
  `model` text NOT NULL,
  `ID_player` int(11) NOT NULL,
  `ID_status` int(11) NOT NULL,
  `kaucja` int(11) NOT NULL,
  `koszt_za_dzien` int(11) NOT NULL,
  `ID_itemstatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."itemstatus` (
  `ID_itemstatus` int(11) NOT NULL,
  `name_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."payments` (
  `ID_payment` int(11) NOT NULL,
  `ID_rent` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `Czas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."player` (
  `ID_player` int(11) NOT NULL,
  `player_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."rank` (
  `ID_rank` int(11) NOT NULL,
  `rank` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."rents` (
  `ID_rent` int(11) NOT NULL,
  `ID_item` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `ID_rentstatus` int(11) NOT NULL,
  `DataOdebrania` date NOT NULL,
  `DataOddania` date NOT NULL,
  `CenaLaczna` int(11) NOT NULL,
  `DoZaplaty` int(11) NOT NULL,
  `kaucja` int(11) NOT NULL,
  `ID_shop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."rentstatus` (
  `ID_rentstatus` int(11) NOT NULL,
  `rentstatus_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."shops` (
  `ID_shop` int(11) NOT NULL,
  `miasto` varchar(100) NOT NULL,
  `adres` varchar(100) NOT NULL,
  `ID_useractive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."status` (
  `ID_status` int(11) NOT NULL,
  `status_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."useractive` (
  `ID_useractive` int(11) NOT NULL,
  `active_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."users` (
  `ID_user` int(11) NOT NULL,
  `user_login` varchar(100) NOT NULL,
  `user_password` varchar(500) NOT NULL,
  `ID_rank` int(11) NOT NULL,
  `Imie` varchar(200) NOT NULL,
  `Nazwisko` varchar(200) NOT NULL,
  `Ulica` varchar(200) NOT NULL,
  `Numer_budynku` int(11) NOT NULL,
  `Numer_mieszkania` int(11) DEFAULT NULL,
  `Miasto` varchar(200) NOT NULL,
  `Telefon` varchar(20) NOT NULL,
  `account_created` date NOT NULL,
  `ID_useractive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

$create[] .="CREATE TABLE `".$prefix."workers` (
  `ID_worker` int(11) NOT NULL,
  `ID_shop` int(11) NOT NULL,
  `ID_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

//alter

$create[] .="ALTER TABLE `".$prefix."answers`
  ADD PRIMARY KEY (`ID_answer`),
  ADD KEY `ID_user_FK` (`ID_user`),
  ADD KEY `ID_inquirystatus_FK` (`ID_inquirystatus`),
  ADD KEY `ID_inquiry_FK` (`ID_inquiry`)";

$create[] .="ALTER TABLE `".$prefix."category`
  ADD PRIMARY KEY (`ID_category`)";

$create[] .="ALTER TABLE `".$prefix."inquiries`
  ADD PRIMARY KEY (`ID_inquiry`),
  ADD KEY `ID_user_FK` (`ID_user`),
  ADD KEY `ID_item_FK` (`ID_item`),
  ADD KEY `ID_inquirystatus_FK` (`ID_inquirystatus`)";

$create[] .="ALTER TABLE `".$prefix."inquiriesstatus`
  ADD PRIMARY KEY (`ID_inquirystatus`)";

$create[] .="ALTER TABLE `".$prefix."items`
  ADD PRIMARY KEY (`ID_item`),
  ADD KEY `items_FK` (`ID_category`),
  ADD KEY `ID_player_FK` (`ID_player`),
  ADD KEY `ID_status_FK` (`ID_status`),
  ADD KEY `ID_itemstatus_FK` (`ID_itemstatus`)";

$create[] .="ALTER TABLE `".$prefix."itemstatus`
  ADD PRIMARY KEY (`ID_itemstatus`)";

$create[] .="ALTER TABLE `".$prefix."payments`
  ADD PRIMARY KEY (`ID_payment`),
  ADD KEY `ID_rent_FK` (`ID_rent`)";

$create[] .="ALTER TABLE `".$prefix."player`
  ADD PRIMARY KEY (`ID_player`)";

$create[] .="ALTER TABLE `".$prefix."rank`
  ADD PRIMARY KEY (`ID_rank`)";

$create[] .="ALTER TABLE `".$prefix."rents`
  ADD PRIMARY KEY (`ID_rent`),
  ADD KEY `ID_item_FK` (`ID_item`),
  ADD KEY `ID_user_FK` (`ID_user`),
  ADD KEY `ID_rentstatus_FK` (`ID_rentstatus`),
  ADD KEY `ID_shop_FK` (`ID_shop`)";

$create[] .="ALTER TABLE `".$prefix."rentstatus`
  ADD PRIMARY KEY (`ID_rentstatus`)";

$create[] .="ALTER TABLE `".$prefix."shops`
  ADD PRIMARY KEY (`ID_shop`),
  ADD KEY `ID_useractive_FK` (`ID_useractive`)";

$create[] .="ALTER TABLE `".$prefix."status`
  ADD PRIMARY KEY (`ID_status`)";

$create[] .="ALTER TABLE `".$prefix."useractive`
  ADD PRIMARY KEY (`ID_useractive`)";

$create[] .="ALTER TABLE `".$prefix."users`
  ADD PRIMARY KEY (`ID_user`),
  ADD KEY `user_FK` (`ID_rank`),
  ADD KEY `ID_useractive_FK` (`ID_useractive`)";

$create[] .="ALTER TABLE `".$prefix."workers`
  ADD PRIMARY KEY (`ID_worker`),
  ADD KEY `ID_shop_FK` (`ID_shop`),
  ADD KEY `ID_user_FK` (`ID_user`)";


$create[] .="ALTER TABLE `".$prefix."answers`
  MODIFY `ID_answer` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."category`
  MODIFY `ID_category` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."inquiries`
  MODIFY `ID_inquiry` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."inquiriesstatus`
  MODIFY `ID_inquirystatus` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."items`
  MODIFY `ID_item` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."itemstatus`
  MODIFY `ID_itemstatus` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."payments`
  MODIFY `ID_payment` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."player`
  MODIFY `ID_player` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."rank`
  MODIFY `ID_rank` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."rents`
  MODIFY `ID_rent` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."rentstatus`
  MODIFY `ID_rentstatus` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."shops`
  MODIFY `ID_shop` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."status`
  MODIFY `ID_status` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."useractive`
  MODIFY `ID_useractive` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."users`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."workers`
  MODIFY `ID_worker` int(11) NOT NULL AUTO_INCREMENT";

$create[] .="ALTER TABLE `".$prefix."answers`
  ADD CONSTRAINT `".$prefix."answers_ibfk_1` FOREIGN KEY (`ID_inquiry`) REFERENCES `".$prefix."inquiries` (`ID_inquiry`)";


$create[] .="ALTER TABLE `".$prefix."inquiries`
  ADD CONSTRAINT `".$prefix."inquiries_ibfk_1` FOREIGN KEY (`ID_user`) REFERENCES `".$prefix."users` (`ID_user`),
  ADD CONSTRAINT `".$prefix."inquiries_ibfk_2` FOREIGN KEY (`ID_item`) REFERENCES `".$prefix."items` (`ID_item`),
  ADD CONSTRAINT `".$prefix."inquiries_ibfk_3` FOREIGN KEY (`ID_inquirystatus`) REFERENCES `".$prefix."inquiriesstatus` (`ID_inquirystatus`)";

$create[] .="ALTER TABLE `".$prefix."items`
  ADD CONSTRAINT `".$prefix."items_ibfk_0` FOREIGN KEY (`ID_category`) REFERENCES `".$prefix."category` (`ID_category`),
  ADD CONSTRAINT `".$prefix."items_ibfk_1` FOREIGN KEY (`ID_player`) REFERENCES `".$prefix."player` (`ID_player`),
  ADD CONSTRAINT `".$prefix."items_ibfk_2` FOREIGN KEY (`ID_status`) REFERENCES `".$prefix."status` (`ID_status`),
  ADD CONSTRAINT `".$prefix."items_ibfk_3` FOREIGN KEY (`ID_itemstatus`) REFERENCES `".$prefix."itemstatus` (`ID_itemstatus`)";

$create[] .="ALTER TABLE `".$prefix."payments`
  ADD CONSTRAINT `".$prefix."payments_ibfk_1` FOREIGN KEY (`ID_rent`) REFERENCES `".$prefix."rents` (`ID_rent`)";

$create[] .="ALTER TABLE `".$prefix."rents`
  ADD CONSTRAINT `".$prefix."rents_ibfk_4` FOREIGN KEY (`ID_item`) REFERENCES `".$prefix."items` (`ID_item`),
  ADD CONSTRAINT `".$prefix."rents_ibfk_3` FOREIGN KEY (`ID_user`) REFERENCES `".$prefix."users` (`ID_user`),
  ADD CONSTRAINT `".$prefix."rents_ibfk_1` FOREIGN KEY (`ID_rentstatus`) REFERENCES `".$prefix."rentstatus` (`ID_rentstatus`),
  ADD CONSTRAINT `".$prefix."rents_ibfk_2` FOREIGN KEY (`ID_shop`) REFERENCES `".$prefix."shops` (`ID_shop`)";

$create[] .="ALTER TABLE `".$prefix."shops`
  ADD CONSTRAINT `".$prefix."shops_ibfk_1` FOREIGN KEY (`ID_useractive`) REFERENCES `".$prefix."useractive` (`ID_useractive`)";

$create[] .="ALTER TABLE `".$prefix."users`
  ADD CONSTRAINT `".$prefix."users_ibfk_1` FOREIGN KEY (`ID_useractive`) REFERENCES `".$prefix."useractive` (`ID_useractive`),
  ADD CONSTRAINT `".$prefix."users_ibfk_2` FOREIGN KEY (`ID_rank`) REFERENCES `".$prefix."rank` (`ID_rank`)";

$create[] .="ALTER TABLE `".$prefix."workers`
  ADD CONSTRAINT `".$prefix."workers_ibfk_1` FOREIGN KEY (`ID_shop`) REFERENCES `".$prefix."shops` (`ID_shop`),
  ADD CONSTRAINT `".$prefix."workers_ibfk_2` FOREIGN KEY (`ID_user`) REFERENCES `".$prefix."users` (`ID_user`)";

$create[] .="COMMIT";

?>