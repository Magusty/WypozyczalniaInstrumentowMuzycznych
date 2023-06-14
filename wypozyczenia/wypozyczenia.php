<?php
session_start();
include("../config/config.php"); 
include("include/header.php");
include("include/nav.php");
?>
<div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Wypożyczenia</h1>
                </div>
        </div>
<div class="container px-lg-5">

<?php
session_start();

if (isset($_GET['id']) && isset($_SESSION['userID']) && $_SESSION['rankID']!=1)
{
    $query = "SELECT ".$prefix."category.category_name, 
    ".$prefix."items.brand, ".$prefix."items.model, DataOdebrania, DataOddania, DoZaplaty, 
    ".$prefix."users.user_login, ".$prefix."users.ID_user, ".$prefix."users.Imie, ".$prefix."users.Nazwisko, ".$prefix."users.Ulica, ".$prefix."users.Numer_budynku, ".$prefix."users.Numer_mieszkania, ".$prefix."users.Miasto, ".$prefix."users.Telefon,
    ".$prefix."status.status_name, ".$prefix."rentstatus.rentstatus_name, ".$prefix."rents.kaucja
    from (((((".$prefix."rents 
    inner join ".$prefix."items on ".$prefix."rents.ID_item = ".$prefix."items.ID_item) 
    inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category) 
    inner join ".$prefix."users on ".$prefix."rents.ID_user=".$prefix."users.ID_user)
    inner join ".$prefix."rentstatus on ".$prefix."rents.ID_rentstatus = ".$prefix."rentstatus.ID_rentstatus)
    inner join ".$prefix."status on ".$prefix."items.ID_status = ".$prefix."status.ID_status)
    where ".$prefix."rents.ID_rent = ".$_GET['id'];

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
$row = mysqli_fetch_array($result);

    echo "<p class=\"text-start h2 pt-2\"> Dane klienta </p>";
    echo "<p class=\"text-start h2 pt-2\"> Nazwa użytkownika: ".$row['user_login']." </p>";
    echo "<p class=\"text-start h2 pt-2\"> Imię: ".$row['Imie']." </p>";
    echo "<p class=\"text-start h2 pt-2\"> Nazwisko: ".$row['Nazwisko']." </p>";
if ($row['Numer_mieszkania']=="")
{
    echo "<p class=\"text-start h2 pt-2\"> Adres: ".$row['Ulica']." ".$row['Numer_budynku'].", ".$row['Miasto']."</p>";
}
else
{
    echo "<p class=\"text-start h2 pt-2\"> Adres: ".$row['Ulica']." ".$row['Numer_budynku']."/".$row['Numer_mieszkania'].", ".$row['Miasto']."</p>";
}
    echo "<p class=\"text-start h2 pt-2\"> Telefon: ".$row['Telefon']." </p>";
    echo "<p class=\"text-start h2 pt-2\"> ================= </p>";
    echo "<p class=\"text-start h2 pt-2\"> Kaucja: ".$row['kaucja']." </p>";
    echo "<p class=\"text-start h2 pt-2\"> Do zapłaty: ".$row['DoZaplaty']."</p>";
    echo "<p class=\"text-start h2 pt-2\"> ================= </p>";
}
else if (!isset($_SESSION['userID'])) //niezalogowany uzytkownik
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Zaloguj się, by uzyskać dostęp </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../zaloguj/index.php\">Logowanie</a></div> </div>";
}
else if($_SESSION['rankID']==1) //uzytkownik bez uprawnien
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Odmowa dostępu </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../index.php\">Strona główna </a></div> </div>";
}
?>

</div>

<?php
include("include/footer.php");

?>

