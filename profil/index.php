<?php
session_start();

include("../config/config.php"); 
include("../config/companyinfo.php");
include("include/header.php");
include("include/nav.php");

if(isset($_POST['password_change']) && isset($_SESSION['userID']))
{
    include("../config/config.php"); 
    $query = "SELECT * FROM " . $prefix . "users WHERE ID_user=" .$_SESSION['userID'];
    $wynik = mysqli_query($link, $query) or die ("Something went wrong");
    $wiersz = mysqli_fetch_assoc($wynik);
    if (password_verify($_POST['old_password'], $wiersz['user_password'])) //will not allow to change password if old is wrong
        {
            if ($_POST['password_new'] == $_POST['password_new2'] && $_POST['password_new'] != $_POST['old_password']) //new password ok & new isn't equal to old
            {
                include("../config/config.php"); 
                $hashpass=password_hash($_POST['password_new'], PASSWORD_DEFAULT);
                $query = "Update ".$prefix."users Set user_password='".$hashpass."' where ID_user=".$_SESSION['userID'];
                $wynik = mysqli_query($link, $query) or die ("Something went wrong");
             
                header ("Location: index.php?success=Zmiana hasła powiodła się");
            }
            if ($_POST['password_new'] == $_POST['password_new2'] && $_POST['password_new'] == $_POST['old_password']) //new password ok & new is equal to old
            {
                header ("Location: index.php?error=Nowe hasło nie może być takie samo jak stare");
            }
            if ($_POST['password_new'] != $_POST['password_new2'] && $_POST['password_new'] == $_POST['old_password']) //new passwords aren't equal
            {
                header ("Location: index.php?error=Wprowadzono dwa różne hasła");
            }
            if ($_POST['password_new'] != $_POST['password_new2'] && $_POST['password_new'] != $_POST['old_password']) //new password ok & new is equal to old
            {
                header ("Location: index.php?error=Wprowadzono dwa różne hasła");
            }
        }
        else
        {
            header ("Location: index.php?error=Stare hasło zostało wprowadzone niepoprawnie");
        }
}
else if (!isset($_SESSION['userID']) && isset($_POST['password_change']))
{
    header ("Location: index.php?error=Nie jestes zalogowany");
}



include("include/main.php");
include("include/footer.php");
    

?>