<?php
session_start();
include("../config/config.php"); 
include("include/header.php");
include("include/nav.php");
?>
<div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Lista instrumentów</h1>
                </div>
        </div>
        <?php if (isset($_GET['success']))
    {
      echo "<div class=\"bg-success text-center pt-3 pb-3 \">
        <p class=\"h4\">".$_GET['success']." </p></div>";
    }
    if (isset($_GET['error']))
{
        echo "<div class=\"bg-danger text-center pt-3 pb-3 \">
        <p class=\"h4\">".$_GET['error']."</p></div>";
}

if ($_SESSION['rankID']==3)
{
   echo "<div class = \"bg-info\"> 
    <div class=\"container\">
    <div class=\"d-flex  bd-highlight mb-3\">
<div class=\"me-auto p-2 bd-highlight\">";
    echo "<a class=\"btn btn-primary\" href=\"addinstrument.php\">Dodaj nową pozycję</a>";
    echo "<a class=\"btn btn-primary\" href=\"categories.php\">Przejdź do kategorii</a> 
    </div>
    </div>
    </div>
    </div>";}
  ?>
<!-- Page Content-->
<section class="pt-1 py-1">
<div class="container px-1">

    <?php    
if ($_SESSION['rankID']==3)
{ 
  $query = "SELECT ".$prefix."category.category_name, brand, model, ".$prefix."items.ID_itemstatus, ID_item, ".$prefix."status.status_name, kaucja, koszt_za_dzien, 
  ".$prefix."player.player_name, ".$prefix."itemstatus.name_status FROM ((((".$prefix."items
  inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category)
  inner join ".$prefix."status on ".$prefix."items.ID_status = ".$prefix."status.ID_status)
  inner join ".$prefix."player on ".$prefix."items.ID_player = ".$prefix."player.ID_player)
  inner join ".$prefix."itemstatus on ".$prefix."items.ID_itemstatus = ".$prefix."itemstatus.ID_itemstatus)";

  $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
    <th scope=\"col\" class=\"text-center\">Nr</th>
      <th scope=\"col\" class=\"text-center\">Instrument</th>
      <th scope=\"col\" class=\"text-center\">Model</th>
      <th scope=\"col\" class=\"text-center\">Przeznaczenie</th>
      <th scope=\"col\" class=\"text-center\">Kaucja</th>
      <th scope=\"col\" class=\"text-center\">Koszt za dzień</th>
      <th scope=\"col\" class=\"text-center\">Status wypożyczenia</th>
      <th scope=\"col\" class=\"text-center\">Status przedmiotu</th>
      <th scope=\"col\" class=\"text-center\">Akcja</th>
    </tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
    <td class=\"text-center h6\">".$row["ID_item"]."</td>
      <td class=\"text-center h6\">".$row["category_name"]."</td>
      <td class=\"text-center h6\">".$row["brand"]." ".$row["model"]."</td>
      <td class=\"text-center h6\">".$row["player_name"]."</td>
      <td class=\"text-center h6\">".$row["kaucja"]."</td>
      <td class=\"text-center h6\">".$row["koszt_za_dzien"]."</td>
      <td class=\"text-center h6\">".$row["status_name"]."</td>
      <td class=\"text-center h6\">".$row["name_status"]."</td>
      <td class=\"text-center h6\"> <a class=\"btn btn-primary\" href=\"../edit/edit.php?id=".$row["ID_item"]."\">Edytuj</a>";  
      if ($row['ID_itemstatus']==1)
      {
        echo "<a class=\"btn btn-danger\" href=\"../oferta/action.php?instruments=1&hideId=".$row["ID_item"]."\">Ukryj</a>";
      }
      else
      {
        echo "<a class=\"btn btn-danger\" href=\"../oferta/action.php?instruments=1&showId=".$row["ID_item"]."\">Odkryj </a>";
      }
      echo"</td>";
    echo "</tr>";
  }
  echo "</tbody>
  </table> ";
}
else
{
  echo "<p class=\"text-center h3\"> Jeszcze nie masz żadnego przedmiotu </p>";
}
}
else
{
  echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Odmowa dostępu </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../index.php\">Powrót do strony głównej</a></div> </div>";
}

?>
   
   </div>
        </section>
<?php

include("include/footer.php");

?>