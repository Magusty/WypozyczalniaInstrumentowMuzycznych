 <!-- Header-->
 <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Oferta</h1>
                </div>
        </div>
        <!-- Page Content-->
<section class="pt-5 py-5">
<!-- Instrument info -->
<div class="container px-lg-5">
 <div class="card-group">
  <div class="card">
  <div class="card-body">

<?php
$itemid=$_GET["itemId"]; 

$query = "SELECT ".$prefix."category.category_name, brand, model, ".$prefix."player.player_name, ".$prefix."category.category_img, kaucja, koszt_za_dzien FROM ((".$prefix."items
inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category)
inner join ".$prefix."player on ".$prefix."items.ID_player = ".$prefix."player.ID_player)
where ID_item = $itemid";

include("../config/config.php");
$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

   while($row = mysqli_fetch_array($result)) 
   {   
$image = $row["category_img"];
echo "<img style=\"width:560px\" src='data:image/jpeg;base64," . base64_encode($image) . "' alt='Obraz'>
</div>
  </div>
  <div class=\"card\">
    <div class=\"card-body\">";

    echo "<div class=\"container px-lg-5\">
    <h1> <p> Informacje </p> </h1>
    <p> <b> Instrument: </b>".$row["category_name"]."</p>
    <p> <b> Firma: </b>".$row["brand"]."</p>
    <p> <b> Model: </b>".$row["model"]."</p>
    <p> <b> Rekomendowane dla: </b>".$row["player_name"]."</p>
    <p> <b> Kaucja [zł]: </b>".$row["kaucja"]."</p>     
    <p> <b> Cena wypożyczenia (1 dzień) [zł]: </b>".$row["koszt_za_dzien"]."</p>   
    ";
}
$itemid=$_GET["id"];

//USER THINGS
if (isset($_SESSION['userID']) && isset($_SESSION['login']) && $_SESSION['rankID']==1)
{
  $query = "SELECT ID_status FROM ".$prefix."items where ID_item=$itemid";
  include("../config/config.php");
$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
  $row = mysqli_fetch_array($result);
  //guzik 'wypozycz' jesli instrument jest mozliwy do wypozyczenia

  if ($row["ID_status"]==1) //wypożyczony
  {
    $query = "SELECT DataOddania from ".$prefix."rents where ID_rentstatus=1 and ID_item=$itemid";
    include("../config/config.php");
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);
    echo "<p> Instrument jest możliwy do wypożyczenia od ".$row["DataOddania"]."</p>";
  }

  else if ($row["ID_status"]==2) //jest mozliwy do wypozyczenia
  {
    echo "<form class=\"form-horizontal\" method=\"POST\" action=\"rent.php\">
<div class=\"container px-lg-5\">
  <div class=\"rounded-3 \">  
            <input type=\"hidden\" name=\"IDitem_rent\" value=".$itemid.">         
            <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"rent_form\">Wypożycz</button>
        </div>
    </div>
</form>";
  }

  else if ($row["ID_status"]==3) //jest zarezerwowany, moze sie okazac ze jednak osoba nie pojawila sie po odbior instrumentu
  {
    $query = "SELECT DataOdebrania from ".$prefix."rents where ID_rentstatus=3 and ID_item=$itemid";
    include("../config/config.php");
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);
    echo "<p> Instrument jest zarezerwowany. Wejdź na stronę w dniu ".$row['DataOdebrania'].", by sprawdzić czy instrument jest do wypożyczenia </p>";
  }

  echo " </div> </div></div> </div></div>";

  //form z zapytaniem o instrument 
echo "<form class=\"form-horizontal\" method=\"POST\" action=\"index.php\">
<div class=\"container px-lg-5\">
  <div class=\"p-4 p-lg-5 bg-light rounded-3 text-left\">
            <legend>Zapytaj o więcej</legend>
            <textarea class=\"form-control\" type=\"text\" name=\"ask_more\" style=\"height: 10rem;\" required ></textarea>     
            <input type=\"hidden\" name=\"item\" value=".$itemid.">
            <div class=\"container py-3 d-grid\">            
            <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"submit\">Wyślij</button>
        </div>
    </div>
</form>";
} 

//WORKER THINGS

if (isset($_SESSION['userID']) && isset($_SESSION['login']) && ($_SESSION['rankID']==2 || $_SESSION['rankID']==3))
{
  $query = "SELECT ID_status FROM ".$prefix."items where ID_item=$itemid";
  include("../config/config.php");
$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
  $row = mysqli_fetch_array($result);

  if ($row["ID_status"]==1) //wypożyczony
  {
    $query = "SELECT DataOddania from ".$prefix."rents where ID_rentstatus=1 and ID_item=$itemid";
    include("../config/config.php");
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);
    echo "<p> Instrument jest możliwy do wypożyczenia od ".$row["DataOddania"]."</p>";
  }

  else if ($row["ID_status"]==2) //jest mozliwy do wypozyczenia
  {
    echo "<form class=\"form-horizontal\" method=\"POST\" action=\"rent.php\">
<div class=\"container px-lg-5\">
  <div class=\"d-flex flex-row bd-highlight mb-3\">  
            <input type=\"hidden\" name=\"IDitem_rent\" value=".$itemid.">               
            <button class=\"btn btn-secondary btn-lg rounded-3\" id=\"submitButton\" type=\"submit\" name=\"rent_form\">Wypożycz dla klienta</button>
            <div class=\"ps-2\">    
            <button class=\"btn btn-secondary btn-lg rounded-3\" id=\"submitButton\" type=\"submit\" name=\"check_form\">Sprawdź cenę</button>
            </div>
        </div>
    </div>
</form>";
  }

  else if ($row["ID_status"]==3) //jest zarezerwowany, moze sie okazac ze jednak osoba nie pojawila sie po odbior instrumentu
  {
    $query = "SELECT DataOdebrania from ".$prefix."rents where ID_rentstatus=3 and ID_item=$itemid";
    include("../config/config.php");
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);
    echo "<p> Instrument jest zarezerwowany. Rezerwacja jest na ".$row['DataOdebrania']." </p>";
  }
  echo " </div> </div></div> </div></div>";
}

if(!isset($_SESSION['userID']))
{
  echo "<p> By wypożyczyć instrument, musisz się zalogować </p>";
  echo " </div> </div></div> </div></div>";
  echo "<div class=\"container px-lg-5\">
  <div class=\"container px-lg-5 bg-grey text-center p-3 h4 \">
  <p>By zapytać o więcej informacji, musisz się zalogować </p>  </div>          
  </div>";
}  
?>
</section>
