<?php
$insert[] ="INSERT INTO `".$prefix."category` (`ID_category`, `category_name`, `category_img`) VALUES 
(1, 'Klarnet', ''),
(2, 'Flet poprzeczny', ''),
(3, 'Saksofon tenorowy', ''),
(4, 'Saksofon altowy', ''),
(5, 'Saksofon sopranowy', ''),
(6, 'Saksofon barytonowy', ''),
(7, 'Gitara basowa', ''),
(8, 'Fagot', ''),
(10, 'Flet prosty', ''),
(11, 'Cymbałki', ''),
(12, 'Gitara akustyczna', ''),
(13, 'Gitara elektryczna', ''),
(14, 'Klarnet basowy', ''),
(15, 'Pianino', ''),
(16, 'Fortepian', ''),
(17, 'Skrzypce', ''),
(18, 'Wiolonczela', ''),
(19, 'Kontrabas', ''),
(20, 'Ukulele', ''),
(21, 'Harfa', ''),
(22, 'Tuba', ''),
(23, 'Puzon', ''),
(24, 'Trąbka', ''),
(25, 'Sakshorn', ''),
(26, 'Flet piccolo', ''),
(27, 'Kornet', ''),
(28, 'Waltornia', ''),
(29, 'Suzafon', '')";

$insert[] .="INSERT INTO `".$prefix."inquiriesstatus` (`ID_inquirystatus`, `inquiry_status`) VALUES
(1, 'Oczekuje na odpowiedź'),
(2, 'Odpowiedziano na zapytanie')";

$insert[] .="INSERT INTO `".$prefix."itemstatus` (`ID_itemstatus`, `name_status`) VALUES
(1, 'Dostępny'),
(2, 'Niedostępny')";

$insert[] .="INSERT INTO `".$prefix."player` (`ID_player`, `player_name`) VALUES
(1, 'początkujący'),
(2, 'umiejący podstawy'),
(3, 'średni'),
(4, 'średniozaawansowany'),
(5, 'profesjonalista')";

$insert[] .="INSERT INTO `".$prefix."rank` (`ID_rank`, `rank`) VALUES
(1, 'Użytkownik'),
(2, 'Pracownik'),
(3, 'Admin')";

$insert[] .="INSERT INTO `".$prefix."rentstatus` (`ID_rentstatus`, `rentstatus_name`) VALUES
(1, 'Wypożyczono'),
(2, 'Oddano'),
(3, 'Zarezerwowano'),
(4, 'Anulowano')";

$insert[] .="INSERT INTO `".$prefix."status` (`ID_status`, `status_name`) VALUES
(1, 'Wypożyczony'),
(2, 'Możliwy do wypożyczenia'),
(3, 'Zarezerwowany')";

$insert[] .="INSERT INTO `".$prefix."useractive` (`ID_useractive`, `active_name`) VALUES
(1, 'Active'),
(2, 'Not active')";

?>