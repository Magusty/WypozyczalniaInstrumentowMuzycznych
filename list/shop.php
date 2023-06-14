<?php
session_start();
include("../config/config.php"); 
include("include/header.php");
include("include/nav.php");

?>

<div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Lista wypożyczalni</h1>
                </div>
        </div>
        <!-- Page Content-->
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
      echo "<div class = \"bg-info\"> 
        <div class=\"container\">
        <div class=\"d-flex  bd-highlight mb-3\">
  <div class=\"me-auto p-2 bd-highlight\"> 
   <a class=\"btn btn-primary\" href=\"../list/addshop.php\">Dodaj nową lokalizację</a>
  </div>
</div>
</div>
</div>";
?>
    <section class="pt-4 py-4">      
    <div class="container px-1">

<?php
if ($_SESSION['rankID']==3)
{
  $query = "SELECT * from ".$prefix."shops";

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Numer sklepu</th>
      <th scope=\"col\" class=\"text-center\">Miasto</th>
      <th scope=\"col\" class=\"text-center\">Adres</th>
      <th scope=\"col\" class=\"text-center\">Akcja</th>
    </tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
      <td class=\"text-center\">".$row["ID_shop"]."</td>
      <td class=\"text-center\">".$row["miasto"]." ".$row["Nazwisko"]."</td>
      <td class=\"text-center\">".$row["adres"]."</td>";
      if ($row['ID_useractive']==1)
      {
        $button = "Dezaktywuj";
        $href = "addshop.php?deactivate=".$row["ID_shop"];
      }
      else
      {
        $button = "Aktywuj";
        $href = "addshop.php?activate=".$row["ID_shop"];
      }
      echo "<td class=\"text-center\"> <a class=\"btn btn-danger\" href=\"$href\">".$button." lokalizację</a> </td>";
  }
  echo "</tbody>
  </table> ";
}
else
{
  echo "<p class=\"text-center h3\"> Jeszcze nie wpisano żadnego adresu </p>";
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