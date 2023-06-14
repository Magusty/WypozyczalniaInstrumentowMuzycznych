<?php
session_start();
include("../config/config.php"); 
include("include/header.php");
include("include/nav.php");

$query = "SELECT * from ".$prefix."items";

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
$row = mysqli_fetch_array($result);
?>

<div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Lista instrumentów</h1>
                </div>
        </div>
  <div class = "bg-info"> 
        <div class="container px-1">
        <div class="d-flex  bd-highlight mb-3">
  <div class="me-auto p-2 bd-highlight"> <?php echo "<a class=\"btn btn-primary\" href=\"../edit/edit.php?categoryId=".$row['ID_category']."\">Dodaj nową kategorię</a>"; ?> 
  <?php echo "<a class=\"btn btn-primary\" href=\"../edit/edit.php?categoryId=".$row['ID_category']."\">Przejdź do kategorii</a>"; ?></div>

  <div class="p-2 bd-highlight"> <input type="text"> </div>
  <div class="p-2 bd-highlight"> <a class="btn btn-primary" href="instruments.php?findByName">Szukaj</a> </div>
</div>
</div>
</div>
        <!-- Page Content-->
        <section class="pt-1 py-1">
        <div class="container px-1">


    <?php    
if ($_SESSION['rankID']==3)
{


if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Nazwa instrumentu</th>
      <th scope=\"col\" class=\"text-center\">Zdjęcie</th>
      <th scope=\"col\" class=\"text-center\">Akcje</th>
    </tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {
    $image = $row["category_img"];
    echo"<tr>
      <td class=\"text-center\">".$row["category_name"]."</td>
      <td class=\"text-center\"> <img style=\"height:200px\" src='data:image/jpeg;base64," . base64_encode($image) . "' alt='Brak obrazu'> </td>
      <td class=\"text-center\"> 
      <a class=\"btn btn-primary\" href=\"../edit/edit.php?categoryId=".$row['ID_category']."\">Edytuj</a>
      <a class=\"btn btn-danger\" href=\"../edit/edit.php?categoryId=".$row['ID_category']."\">Usuń kategorię</a>
      </td>";
  }
  echo "</tbody>
  </table> ";
}
else
{
  echo "<p class=\"text-center h3\"> Jeszcze nie wpłacono żadnych pieniędzy </p>";
}
}

?>
   
   </div>
        </section>
<?php

include("include/footer.php");

?>