<?php
session_start();
include("../config/config.php"); 
include("include/header.php");
include("include/nav.php");

?>

<div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Lista płatności</h1>
                </div>
        </div>
        <!-- Page Content-->
        <section class="pt-5 py-5">
        <div class="container px-1">

<?php
if ($_SESSION['rankID']==3)
{
  $query = "SELECT * from ".$prefix."payments"; //admin moze sprawdzic wszystkich

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Numer zapłaty</th>
      <th scope=\"col\" class=\"text-center\">Numer zamówienia</th>
      <th scope=\"col\" class=\"text-center\">Kwota</th>
      <th scope=\"col\" class=\"text-center\">Czas</th>
    </tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
      <td class=\"text-center\">".$row["ID_payment"]."</td>
      <td class=\"text-center\"> <a href=\"../wypozyczenia/wypozyczenia.php?id=".$row["ID_rent"]."\">".$row["ID_rent"]."</a> </td>
      <td class=\"text-center\">".$row["value"]."</td>
      <td class=\"text-center\">".$row["Czas"]."</td>";
  }
  echo "</tbody>
  </table> ";
}
else
{
  echo "<p class=\"text-center h3\"> Jeszcze nie wpłacono żadnych pieniędzy </p>";
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