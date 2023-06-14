<?php
session_start();
include("../config/config.php");

if (isset($_GET['hideId']) && isset($_GET['instruments']) && $_SESSION['rankID']==3)
{
    $query = "SELECT * from ".$prefix."items where ID_item=".$_GET['hideId']." and (ID_status=3 or ID_status=1)";
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $rowCount = mysqli_num_rows($result);
    if ($rowCount==0)
    {
        $query = "UPDATE ".$prefix."items set ID_itemstatus=2 where ID_item=".$_GET['hideId'];
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

        header("Location: ../list/instruments.php?success=Schowano produkt"); 
    }
    else
    {
        header("Location: ../list/instruments.php?error=Nie mozna schowac produktu"); 

    }  
}
else if (isset($_GET['hideId']) && !isset($_GET['instruments']) && $_SESSION['rankID']==3)
{
    $query = "SELECT * from ".$prefix."items where ID_item=".$_GET['hideId']." and (ID_status=3 or ID_status=1)";
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $rowCount = mysqli_num_rows($result);
    if ($rowCount==0)
    {
        $query = "UPDATE ".$prefix."items set ID_itemstatus=2 where ID_item=".$_GET['hideId'];
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        header("Location: index.php?success=Schowano produkt"); 

    }
    else
    {
        header("Location: index.php?error=Nie mozna schowac produktu");
    }  
}

else if (isset($_GET['showId']) && $_SESSION['rankID']==3)
{
    $query = "UPDATE ".$prefix."items set ID_itemstatus=1 where ID_item=".$_GET['showId'];
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

    if (isset($_GET['instruments']))
    {
    header("Location: ../list/instruments.php?success=Odkryto produkt"); 
    }
    else
    {
    header("Location: index.php?success=Odkryto produkt");  
    }
}

else if ($_SESSION['rankID']==2) //worker
{
    header("Location: index.php?error=Nie masz wystarczających uprawnień");
}

else if ($_SESSION['rankID']==1) //user
{
    header("Location: index.php?error=Nie masz wystarczających uprawnień");
}

else //niezalogowany
{
    header("Location: index.php?error=Zaloguj się ponownie, by dokonać akcji");
}



?>