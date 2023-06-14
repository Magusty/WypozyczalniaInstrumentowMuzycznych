<?php
session_start();
include("../config/config.php");
include("include/header.php");
include("include/nav.php");

?>
    <div class="p-4 p-lg-5 bg-secondary text-center">
            <div class="m-4 m-lg-2">
                <h1 class="display-5 fw-bold">Dodawanie nowego instrumentu</h1>
            </div>
    </div>
        <?php 
        if (isset($_GET['success']))
    {
      echo "<div class=\"bg-success text-center pt-3 pb-3\">
      <p class=\"h4\">".$_GET['success']." </p></div>";
    }
    if (isset($_GET['error']))
    {
        echo "<div class=\"bg-danger text-center pt-3 pb-3 \">
        <p class=\"h4\">".$_GET['error']."</p></div>";
    }

if ($_SESSION['rankID']==3)
{
    form_add_instrument();
}
else if ($_SESSION['rankID'] <3 || !(isset($_SESSION['userID'])))
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Odmowa dostępu </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../index.php\">Powrót do strony głównej</a></div> </div>";
}

if(isset($_POST['addinstrument_add']) && $_SESSION['rankID']==3)
{
    $combo_instrument = $_POST['combo_instrument'];
    $firma = $_POST['firma'];
    $model = $_POST['model'];
    $combo_player = $_POST['combo_player'];
    $kaucja = $_POST['kaucja'];
    $koszt = $_POST['koszt'];
    $aktywnosc = $_POST['combo_aktywnosc'];
    
    if ($combo_instrument=="" || $combo_player =="" || $aktywnosc=="")
    {
        header("Location: addinstrument.php?error=Pola nie mogą być puste");
    }

    else
    {
       //get category id
        $query = "Select ID_category from ".$prefix."category where category_name = '".$combo_instrument."'";
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        $row = mysqli_fetch_array($result);
    
        $idCategory = $row['ID_category'];
    
        //get player id
        $query = "Select ID_player from ".$prefix."player where player_name = '".$combo_player."'";
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        $row = mysqli_fetch_array($result);
    
        $idPlayer = $row['ID_player'];
    
        //get itemstatus
        $query = "Select ID_itemstatus from ".$prefix."itemstatus where name_status='".$aktywnosc."'";
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        $row = mysqli_fetch_array($result);
    
        $idAktywnosc = $row['ID_itemstatus'];
    
        //insert into ".$prefix."items
        $query = "Insert into ".$prefix."items (ID_category, brand, model, ID_player, ID_status, kaucja, koszt_za_dzien, ID_itemstatus)
        values (".$idCategory.",'".$firma."','".$model."',".$idPlayer.",2,".$kaucja.",".$koszt.",".$idAktywnosc.")";
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    
        header("Location: addinstrument.php?success=Pomyślnie dodano przedmiot");
    
    }
}

// ============================================= funkcje ===============================================
function form_add_instrument()
{
    include("../config/config.php");
 echo "<div class=\"py-4\">  
    <div class=\"container px-lg-5\">
    <form class=\"form-horizontal\" method=\"POST\" action=\"addinstrument.php\">
    <div class=\"container px-lg-5\">
        <div class=\"p-4 p-lg-5 text-center\">
        <label class=\"h3\" for=\"combo_instrument\"> Wybierz instrument </label>

    <div class=\"container px-lg-5\">
    <select name=\"combo_instrument\">";
    $query = "select * from ".$prefix."category";
    $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

    echo "<option value=\"\"> </option>";
    while ($row = mysqli_fetch_array($result)) {
        $value = $row['category_name'];
        echo "<option value='" . $value . "'>" . $value . "</option>";
    }
    echo "</select>";

    echo "</div>
        <div class=\"container px-lg-5\">
            <label class=\"h3\" for=\"firma\"> Firma </label>
        </div>
        <div class=\"container px-lg-5\">
            <input type=\"text\" name=\"firma\" id=\"firma\" required>
        </div>
        <div class=\"container px-lg-5\">
            <label class=\"h3\" for=\"model\"> Model </label>
        </div>
        <div class=\"container px-lg-5\">
            <input type=\"text\" name=\"model\" id=\"model\" required>
        </div>
        <div class=\"container px-lg-5\">
            <label class=\"h3\" for=\"combo_player\"> Przeznaczenie </label>
        </div>
        <div class=\"container px-lg-5\">
        
        <select name=\"combo_player\" id=\"combo_player\">";
            $query = "select * from ".$prefix."player";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
            echo "<option value=\"\"> </option>";
            while ($row = mysqli_fetch_array($result)) {
                $value = $row['player_name'];
                echo "<option value='" . $value . "'>" . $value . "</option>";
            }
            echo "</select>";
        echo "</div>
        <div class=\"container px-lg-5\">
            <label class=\"h3\" for=\"kaucja\"> Kaucja</label>
        </div>
        <div class=\"container px-lg-5\">
            <input type=\"number\" name=\"kaucja\" id=\"kaucja\" value=\"200\" min=\"1\" required>
        </div>
        <div class=\"container px-lg-5\">
            <label class=\"h3\" for=\"koszt\"> Koszt wynajmu (za 1 dzień) </label>
        </div>
        <div class=\"container px-lg-5\">
            <input type=\"number\" name=\"koszt\" id=\"koszt\" value=\"30\" min=\"1\" required>
        </div>
        <div class=\"container px-lg-5\">
            <label class=\"h3\" for=\"combo_aktywnosc\"> Wybierz status przedmiotu </label>
        </div>
        <div class=\"container px-lg-5\">
        <select name=\"combo_aktywnosc\" id=\"combo_aktywnosc\">";
            $query = "select * from ".$prefix."itemstatus";
            $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");
            echo "<option value=\"\"> </option>";
            while ($row = mysqli_fetch_array($result)) {
                $value = $row['name_status'];
                echo "<option value='" . $value . "'>" . $value . "</option>";
            }
            echo "</select>
        </div>
        <div class=\"container py-3 d-grid\">
            <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"addinstrument_add\">Dodaj nową kategorię</button>
        </div>
        </form>
    </div>
    </div> </div>
    </div>";
}

?>

</div> 

<?php
include("include/footer.php");

?>