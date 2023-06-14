<?php
include("../config/config.php");
session_start();

if (isset($_POST['register_user']) && !isset($_SESSION['userID']))
{    $log = $_POST['login_reg'];
    $pas1 = $_POST['password_reg'];
    $pas2 = $_POST['password_reg2'];

    $query = "SELECT user_login from ".$prefix."users where user_login = '$log'";
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $rowCount = mysqli_num_rows($result);  

    if ($pas1 == $pas2 && !$rowCount==1) //hasla sie zgadzaja i user name sie nie powtarza
    {     $today = date("Y-m-d");
        $hashpass = password_hash($pas1, PASSWORD_DEFAULT);
        if ($_POST['nrmieszk_reg'] != "") //nie kazdy musi mieszkac w bloku
        {
            $nrMieszk=$_POST['nrmieszk_reg'];
        }
        else
        {
            $nrMieszk = "null";
        }
        //dodaj informacje o uzytkowniku do bazy
        $query = "INSERT INTO ".$prefix."users (user_login, user_password, ID_rank, Imie, Nazwisko, Miasto, Ulica, Numer_budynku, Numer_mieszkania, Telefon, account_created, ID_useractive) 
        VALUES ('".$log."', '".$hashpass. "', 1,'".$_POST['imie_reg']."','".$_POST['nazwisko_reg']."','".$_POST['miasto_reg']."', 
        '".$_POST['ulica_reg']."',".$_POST['nrbud_reg'].",".$nrMieszk.",'".$_POST['phone']."','".$today."', 1)";
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        
        header ("Location: index.php?success=Rejestracja przebiegła pomyślnie.");
        
    }
    else if ($pas1!=$pas2 && $rowCount==1) //nazwa uzytkownika juz istnieje, hasla roznia sie
    {
        header ("Location: index.php?error=Nazwa użytkownika jest zajęta");
    }
    else if ($pas1==$pas2 && $rowCount==1) //nazwa uzytkownika juz istnieje, hasla takie same
    {
        header ("Location: index.php?error=Nazwa użytkownika jest zajęta");
    }
    else if ($pas1!=$pas2) //hasla roznia sie
    {
        header ("Location: index.php?error=Drugie hasło zostało błędnie wprowadzone");
    }
    else if ($rowCount==1) //nazwa uzytkownika istnieje
    {
        header ("Location: index.php?error=Nazwa użytkownika jest zajęta");
    }
}
else //zalogowani probuja sie rejestrowac
{
    header ("Location: ../index.php?error=Jesteś już zalogowany");
}

    ?>