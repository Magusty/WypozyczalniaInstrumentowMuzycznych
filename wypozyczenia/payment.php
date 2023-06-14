<?php
session_start();
include("../config/config.php"); 
include("include/header.php");
include("include/nav.php");

if (isset($_GET['idRent']) && isset($_SESSION['userID']) )
{
    $idRent = $_GET['idRent'];
    $query = "SELECT DoZaplaty from ".$prefix."rents where ID_rent=".$idRent;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);

    echo "<form class=\"form-horizontal\" method=\"POST\" action=\"payment.php\">
<div class=\"container px-lg-5\">
  <div class=\"p-4 p-lg-5 bg-light rounded-3 text-left\">
        <div class=\"pt-4\">
        <p class=\"h3\"> Do zapłaty zostało ".$row['DoZaplaty']." </p>
            <label class=h3 for=\"value\"> Wpisz wartość, którą klient przekazał </label>
            <br>
            <input type=\"number\" name=\"value\" id=\"value\" value=\"1\" min=\"10\" max=\"".$row['DoZaplaty']."\"> 
            <div class=\"container py-3 d-grid\">    
            <input type=\"hidden\" name=\"rent_pay\" value=".$idRent.">                 
            <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"payment_rent\">Potwierdź</button>
        </div></div>
    </div>
    </div>
</form> ";
}
else if (isset($_GET['idRent']) && !isset($_SESSION['userID']))
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Zaloguj się, by uzyskać dostęp </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../zaloguj/index.php\">Logowanie</a></div> </div>";
}
else if (isset($_GET['idRent']) &&  $_SESSION['rankID']==1)
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Odmowa dostępu </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../index.php\">Powrót do strony głównej</a></div> </div>";
}

if (isset($_POST['payment_rent']) && $_SESSION['rankID'] >1)
{
    $idRent = $_POST['rent_pay'];
    $value=$_POST['value'];
    $today= date('Y-m-d H:i:s');

    //zapis do ".$prefix."payments
    $query = "INSERT INTO ".$prefix."payments (ID_rent, value, Czas) values (".$idRent.", ".$value.", '".$today."')";

    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);

    //zmiana kosztu w ".$prefix."rents
    $query = "SELECT DoZaplaty from ".$prefix."rents where ID_rent=".$idRent;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);
    $koszt = $row['DoZaplaty'];
    $newKoszt = $koszt-$value;

    $query = "Update ".$prefix."rents set DoZaplaty=".$newKoszt." where ID_rent=".$idRent; 
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result); 
    
    header("Location: index.php?all=1&changed=Pomyślnie przeprowadzono wpłatę");
}
else if ($_SESSION['rankID']==1 || !isset($_SESSION['rankID']))
{
    header("Location: index.php?error=Nie masz wystarczajacych uprawnien");
}


if (isset($_GET['idRent_kaucja']) && $_SESSION['rankID'] >1)
{
    $idRent=$_GET['idRent_kaucja'];
    $today= date('Y-m-d H:i:s');

    $query = "SELECT DoZaplaty, kaucja from ".$prefix."rents where ID_rent=".$idRent;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);

    $value=$row['kaucja'];

    //zapis do ".$prefix."payments
    $query = "INSERT INTO ".$prefix."payments (ID_rent, value, Czas) values (".$idRent.", ".$value.", '".$today."')";

    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);

    //wyzerowanie kaucji w ".$prefix."rents i zmniejszenie zaplaty
    $query = "SELECT DoZaplaty from ".$prefix."rents where ID_rent=".$idRent;
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);
    $koszt = $row['DoZaplaty'];
    $newKoszt = $koszt-$value;

    $query = "Update ".$prefix."rents set DoZaplaty=".$newKoszt." where ID_rent=".$idRent; 
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $query = "Update ".$prefix."rents set kaucja=0 where ID_rent=".$idRent; 
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
   
    header("Location: index.php?changed=Pomyślnie przeprowadzono wpłatę");
}
else if ($_SESSION['rankID']==1 || !isset($_SESSION['rankID']))
{
    header("Location: index.php?error=Nie masz wystarczajacych uprawnien");
}

include("include/footer.php");
?>