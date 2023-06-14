<?php
session_start();
include("../config/config.php"); 

if(isset($_GET['deactivate']) && $_SESSION['rankID']==3)
{
    $userID = $_GET['deactivate'];
    $query = "Update ".$prefix."users set ID_useractive = 2 where ID_user=".$userID;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    header("Location: index.php?showworkers=1&success=Zdezaktywowano pracownika");
}

if(isset($_GET['activateworker']) && $_SESSION['rankID']==3)
{
    $userID = $_GET['activateworker'];
    $query = "Update ".$prefix."users set ID_useractive = 1 where ID_user=".$userID;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    header("Location: index.php?showworkers=1&success=Aktywowano pracownika");
}

?>