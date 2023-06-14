<?php
session_start();
include("../config/config.php"); 
include("include/header.php");
include("include/nav.php");
?>
 <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Twoje wypożyczenia</h1>
                </div>
        </div>
        <!-- Page Content-->
        
<?php

if (isset($_GET['idRent']) )
{
    if (isset($_GET['error']))
    {
        echo "<div class=\"bg-danger text-center p-3 h4 \">
        <p>".$_GET['error']." </p> </div>";
    }

    $query = "SELECT ID_rentstatus from ".$prefix."rents where ID_rent=".$_GET['idRent'];
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        $row = mysqli_fetch_array($result);

        $oldStatusId=$row['ID_rentstatus'];

        switch ($oldStatusId)
        {
            case 1:
                {
                    $query = "SELECT rentstatus_name FROM ".$prefix."rentstatus where ID_rentstatus =2"; 
                    break;
                }
            case 3:
                {
                    $query = "SELECT rentstatus_name FROM ".$prefix."rentstatus where ID_rentstatus =1 or ID_rentstatus=4"; 
                    break;
                }
            //case 4 || 2 nie powinny miec miejsca
                
        }
    echo "<div class=\"container px-lg-5\">
    <section class=\"pt-5 py-5\">";
    $idRent = $_GET['idRent'];

    echo "<form class=\"form-horizontal text-center\" method=\"POST\" action=\"cancelrent.php\">";
    echo "<p class=\"h2 \"> Wybierz status </p>";
    echo "<select name=\"comboStatus\">";

    
    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

    echo "<option value=\"\"> </option>";
    while ($row = mysqli_fetch_array($result)) {
        $value = $row['rentstatus_name'];
        echo "<option value='" . $value . "'>" . $value . "</option> </div>";
    }
 
    echo "<input type=\"hidden\" name=\"IDitem_rent\" value=".$idRent.">  
    <div class=\"py-2\">               
    <button class=\"btn btn-secondary btn-lg rounded-3\" id=\"submitButton\" type=\"submit\" name=\"idRent_confirm\">Potwierdź</button>
    </div> </form> </div>";
}

if (isset($_POST['idRent_confirm']) && $_SESSION['rankID'] >1)
{
    $idRent = $_POST['IDitem_rent'];
    if($_POST['comboStatus']=="")
    {
        header("Location: cancelrent.php?idRent=".$idRent."&error=Wybierz zmiane statusu");
    }
    else
    {
        $query = "SELECT ID_rentstatus from ".$prefix."rentstatus where rentstatus_name='".$_POST['comboStatus']."'";
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        $row = mysqli_fetch_array($result);
        
        $newStatusId = $row['ID_rentstatus'];

        $query = "SELECT ID_rentstatus from ".$prefix."rents where ID_rent=".$idRent;
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        $row = mysqli_fetch_array($result);

        $oldStatusId=$row['ID_rentstatus'];

            //zmiana statusu w wypozyczeniach
            $query = "UPDATE ".$prefix."rents SET ID_rentstatus=".$newStatusId." where ID_rent=".$idRent;
            $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
            $row = mysqli_fetch_array($result);
            //zmiana statusu w instrumencie
            $query = "SELECT ID_item from ".$prefix."rents where ID_rent=".$idRent;
            $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
            $row = mysqli_fetch_array($result);
            $idItem=$row['ID_item'];
            $ID_status;
            switch ($newStatusId)
            {
            case 2 || 4: //jesli oddano lub anulowano to oznacza za instrument jest dostepny
                $ID_status=2;    
            case 3: //zarezerwowano
                $ID_status=3;
            case 1: //wypozyczono
                $ID_status=1;          
            }
            $query = "UPDATE ".$prefix."items SET ID_status=".$ID_status." where ID_item=".$idItem;
            $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
            $row = mysqli_fetch_array($result);
            header("Location: index.php?changed=Pomyślnie zmieniono status");           
            echo "</div> ";
    }
}
else if ($_SESSION['rankID']==1 || !isset($_SESSION['rankID']))
{
    header("Location: index.php?error?Brak wystarczających uprawnień");   
}

if (isset($_GET['idRent_cancel']) && $_SESSION['rankID'] >1)
{
    $idRent = $_GET['idRent_cancel'];

    //zmiana statusu w wypozyczeniach
    $query = "UPDATE ".$prefix."rents SET ID_rentstatus=4 where ID_rent=".$idRent;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);

    //wyciagniecie id instrumentu
    $query = "SELECT ID_item from ".$prefix."rents where ID_rent=".$idRent;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);
    $idItem=$row['ID_item'];

    //zmiana statusu w instrumencie
    $query = "UPDATE ".$prefix."items SET ID_status=2 where ID_item=".$idItem;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);
    header("Location: index.php?changed=Pomyślnie anulowano rezerwację");           
}
else if ($_SESSION['rankID']==1 || !isset($_SESSION['rankID']))
{
    header("Location: index.php?error=Brak wystarczających uprawnień");   
}

include("include/footer.php");
?>