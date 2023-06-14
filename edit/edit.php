<?php
session_start();
include("../config/config.php");
include("../config/companyinfo.php");
include("include/header.php");
include("include/nav.php");

?>
<div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Edycja przedmiotu</h1>
                </div>
        </div>
        <?php if (isset($_GET['success']))
    {
      echo "<div class=\"bg-success text-center pt-3 pb-3\">
        <p class=\"h4\">".$_GET['success']." </p></div>";
    }
    if (isset($_GET['error']))
{
        echo "<div class=\"bg-danger text-center pt-3 pb-3 \">
        <p class=\"h4\">".$_GET['error']."</p></div>";
}

?>
    <div class="py-4">  
    
<?php

if (isset($_GET["itemId"]) && $_SESSION['rankID']==3)
{
    echo "<div class=\"container px-lg-5\">
    <div class=\"card-group\">
    <div class=\"card\">
    <div class=\"card-body\">";
    include("../config/config.php");
   $itemid=$_GET["itemId"]; 
   
   $query = "SELECT ".$prefix."category.category_name, brand, model, ".$prefix."player.player_name, ".$prefix."category.category_img, kaucja, koszt_za_dzien FROM ((".$prefix."items
   inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category)
   inner join ".$prefix."player on ".$prefix."items.ID_player = ".$prefix."player.ID_player)
   where ID_item = $itemid";
    
   $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
   
   $row = mysqli_fetch_array($result);  
   $image = $row["category_img"];
   echo "<img style=\"width:560px\" src='data:image/jpeg;base64," . base64_encode($image) . "' alt='Obraz'>
   </div>
     </div>
     <div class=\"card\">
       <div class=\"card-body\">";
   
       echo "<div class=\"container px-lg-5\">
       <p> <b> Instrument: </b>".$row["category_name"]."</p>
       <p> <b> Firma: </b>".$row["brand"]."</p>
       <p> <b> Model: </b>".$row["model"]."</p>
       <p> <b> Rekomendowane dla: </b>".$row["player_name"]."</p>
       <p> <b> Kaucja [zł]: </b>".$row["kaucja"]."</p>     
       <p> <b> Cena wypożyczenia (1 dzień) [zł]: </b>".$row["koszt_za_dzien"]."</p>   
       </div> </div></div> </div></div>"; 

//form ze zmianą cen
    $kaucja=$row['kaucja'];
   $cenaZaDzien=$row['koszt_za_dzien'];

    echo "<form class=\"form-horizontal\" method=\"POST\" action=\"edit.php\">
    <div class=\"container px-lg-5\">
        <div class=\"p-4 p-lg-5 bg-light text-left\">
            <label class=h3 for=\"cena_wypozyczenia\"> Ustaw nową cenę wypożyczenia</label>
            <br>
            <input type=\"number\" name=\"cena_wypozyczenia\" id=\"cena_wypozyczenia\" value=\"".$cenaZaDzien."\" min=\"1\"> 
        <div class=\"pt-4\">
            <label class=h3 for=\"kaucja\"> Ustaw nową kaucję </label>
            <br>
            <input type=\"number\" name=\"kaucja\" id=\"kaucja\" value=\"".$kaucja."\" min=\"1\"> 
            <div class=\"container py-3 d-grid\">    
            <input type=\"hidden\" name=\"item_to_edit\" value=".$itemid.">                 
            <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"edycja_confirm\">Zmień</button>
        </div></div>
    </div>
    
    </div>
</form> </section>";
}

else if (isset($_GET['id']) && $_SESSION['rankID']==3)
{
    echo "<div class=\"container px-lg-5\">
    <div class=\"card-group\">
    <div class=\"card\">
    <div class=\"card-body\">";
    include("../config/config.php");
   $itemid=$_GET["id"]; 
   
   $query = "SELECT ".$prefix."category.category_name, brand, model, ".$prefix."player.player_name, ".$prefix."category.category_img, kaucja, koszt_za_dzien FROM ((".$prefix."items
   inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category)
   inner join ".$prefix."player on ".$prefix."items.ID_player = ".$prefix."player.ID_player)
   where ID_item = $itemid";
    
   $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
   
   $row = mysqli_fetch_array($result);  
   $image = $row["category_img"];
   echo "<img style=\"width:560px\" src='data:image/jpeg;base64," . base64_encode($image) . "' alt='Obraz'>
   </div>
     </div>
     <div class=\"card\">
       <div class=\"card-body\">";
   
       echo "<div class=\"container px-lg-5\">
       <p> <b> Instrument: </b>".$row["category_name"]."</p>
       <p> <b> Firma: </b>".$row["brand"]."</p>
       <p> <b> Model: </b>".$row["model"]."</p>
       <p> <b> Rekomendowane dla: </b>".$row["player_name"]."</p>
       <p> <b> Kaucja [zł]: </b>".$row["kaucja"]."</p>     
       <p> <b> Cena wypożyczenia (1 dzień) [zł]: </b>".$row["koszt_za_dzien"]."</p>   
       </div> </div></div> </div></div>"; 

//form ze zmianą cen
    $kaucja=$row['kaucja'];
   $cenaZaDzien=$row['koszt_za_dzien'];

    echo "<form class=\"form-horizontal\" method=\"POST\" action=\"edit.php\">
    <div class=\"container px-lg-5\">
        <div class=\"p-4 p-lg-5 bg-light text-left\">
            <label class=h3 for=\"cena_wypozyczenia\"> Ustaw nową cenę wypożyczenia</label>
            <br>
            <input type=\"number\" name=\"cena_wypozyczenia\" id=\"cena_wypozyczenia\" value=\"".$cenaZaDzien."\" min=\"1\"> 
        <div class=\"pt-4\">
            <label class=h3 for=\"kaucja\"> Ustaw nową kaucję </label>
            <br>
            <input type=\"number\" name=\"kaucja\" id=\"kaucja\" value=\"".$kaucja."\" min=\"1\"> 
            <div class=\"container py-3 d-grid\">    
            <input type=\"hidden\" name=\"item_to_edit\" value=".$itemid.">                 
            <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"edycja_confirm\">Zmień</button>

        </div></div>
    </div>
    
    </div>
</form> </section>";

}

 
else if (isset($_POST['edycja_confirm']) && $_SESSION['rankID']==3) //akceptacja zmian cen
{
    $itemid=$_POST["item_to_edit"]; 
    $cenaDzien = $_POST['cena_wypozyczenia'];
    $kaucja = $_POST['kaucja'];

    include("../config/config.php");
   $query = "Update ".$prefix."items set kaucja=".$kaucja." where ID_item=".$itemid;
   $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

   $query = "Update ".$prefix."items set koszt_za_dzien=".$cenaDzien." where ID_item=".$itemid;
   $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");


   header("Location: ../edit/edit.php?id=".$itemid."&success=Zmieniono ceny");
}

else if (isset($_GET['categoryId']) && $_SESSION['rankID']==3)
{
    echo "<div class=\"container text-center px-lg-5\">";
    $categoryid=$_GET["categoryId"]; 

$query = "SELECT * from ".$prefix."category where ID_category =".$categoryid;

include("../config/config.php");
$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

   $row = mysqli_fetch_array($result); 
 
$image = $row["category_img"];
echo "<p class=\" h2\"> <b> ".$row["category_name"]."</b> </p> 
<img style=\"height:300px\" class=\"border rounded-5\" src='data:image/jpeg;base64," . base64_encode($image) . "' alt='Brak obrazu'>
</div>
  </div>";

    echo "<div class=\"container text-center px-lg-5\">
    <form method=\"POST\" action=\"edit.php\" enctype=\"multipart/form-data\">
    <p> <input type=\"file\" required class=\"btn btn-primary\" name=\"filename\" accept=\".jpg, .jpeg, .png\"> </p>
    <input type=\"hidden\" value=".$categoryid." name=\"categoryId\">
    <p> <button type=\"submit\" class=\"btn btn-danger\" name=\"upload\"> Zaktualizuj obraz </button>  </p>
    </form>";
    echo "<p> <a class=\"btn btn-primary\" href=\"../list/instruments.php\"> Powrót </a>  </p>";
} 

else if(isset($_POST['upload']) && $_SESSION['rankID']==3)
{
    $categoryID_upload = $_POST["categoryId"];
    $imagePath = $_FILES['filename']['tmp_name'];
    
    // Otwórz przesłane zdjęcie i odczytaj jego zawartość
    $imageContent = file_get_contents($imagePath);
    
    include("../config/config.php");
    
    $query = "UPDATE ".$prefix."category SET category_img=? WHERE ID_category=?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "si", $imageContent, $categoryID_upload);
    //mysqli_stmt_execute($stmt);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: edit.php?categoryId=".$categoryID_upload."&success=Zdjęcie zostało zaktualizowane.");
    } else {
        header("Location: edit.php?categoryId=".$categoryID_upload."&error=Coś poszło nie tak");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
else if ($_SESSION['rankID']!=3) //pracownik lub uzytkownik
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Odmowa dostępu </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../oferta/index.php\">Powrót do oferty</a></div> </div>";
}
else if (!isset($_SESSION['rankID'])) //niezalogowany user
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Zaloguj się, by uzyskać dostęp </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../zaloguj/index.php\">Logowanie</a></div> </div>";
}



?>

</div> 

<?php
include("include/footer.php");

?>