<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>
        <?php if ($_SESSION['rankID']==1)
                    {
                      echo "Twoje";
                    }
                    else if (($_SESSION['rankID']==2 || $_SESSION['rankID']==3) && isset($_GET['tomorrow']))
                    { echo "Jutrzejsze"; }
                    else if(($_SESSION['rankID']==2 || $_SESSION['rankID']==3) && isset($_GET['all']))
                    { echo "Wszystkie";}
                    else if ($_SESSION['rankID']==2 || $_SESSION['rankID']==3)
                    {
                      echo "Dzisiejsze";
                    }    ?>
        Wypożyczenia</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>