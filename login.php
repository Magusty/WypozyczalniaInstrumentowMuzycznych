<?php
session_start();
include("config/config.php");
if (!isset($_SESSION['userID']))
{
$query = "SELECT * FROM " . $prefix . "users WHERE user_login='" . $_POST['login_login'] . "'";
$wynik = mysqli_query($link, $query) or die ("Something went wrong");

if (mysqli_num_rows($wynik) == 1) 
{
    $wiersz = mysqli_fetch_assoc($wynik);

    if (password_verify($_POST['password_login'], $wiersz['user_password']) && $wiersz['ID_useractive']==1) {
        session_start();
        $_SESSION['userID'] = $wiersz['ID_user'];
        $_SESSION['login'] = $wiersz['user_login'];
        $_SESSION['rankID'] = $wiersz['ID_rank'];

        if ($_SESSION['rankID']==2) //przypisanie sklepu do pracownika
        {
            $query = "SELECT * FROM " . $prefix . "workers where ID_user = ".$_SESSION['userID'];
            $wynik = mysqli_query($link, $query) or die ("Something went wrong");
            $wiersz = mysqli_fetch_assoc($wynik);
            $_SESSION['shopID'] = $wiersz['ID_shop'];
        }
        header("Location: index.php?logged=Zalogowano");
    } 
    else 
    {
        if ($wiersz['ID_useractive']==2)
        {
            header("Location: zaloguj/index.php?error=Konto nieaktywne");
        }
        else
        {
        header("Location: zaloguj/index.php?error=Hasło jest niepoprawne");}
        }
} 
else 
{
    header("Location: zaloguj/index.php?error=Podany login nie istnieje");
}
}
else
{
    header("Location: index.php?error=Jesteś już zalogowany");
}


?>