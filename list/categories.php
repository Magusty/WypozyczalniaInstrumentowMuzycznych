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
    echo "<a class=\"btn btn-primary\" href=\"../list/addcategory.php\">Dodaj nową kategorię</a>"; 
    echo "<a class=\"btn btn-primary\" href=\"../list/instruments.php\">Przejdź do instrumentów</a>"; 
}
  ?></div>

</div>
</div>
</div>
        <!-- Page Content-->
        <section class="pt-1 py-1">
        <div class="container px-1">


    <?php    
if ($_SESSION['rankID']==3)
{ 
  $query = "SELECT * from ".$prefix."category";

  $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

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
      <a class=\"btn btn-primary\" href=\"../edit/edit.php?categoryId=".$row['ID_category']."\">Edytuj obraz</a>
      </td>";
  }
  echo "</tbody>
  </table> ";
}
else
{
  echo "<p class=\"text-center h3\"> Jeszcze nie masz żadnej kategorii </p>";
}
}
else if ($_SESSION['rankID'] <3 || !isset($_SESSION['userID']))
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