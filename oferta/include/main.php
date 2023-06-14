 <!-- Header-->
            <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Oferta</h1>
                </div>
        </div>
        <!-- Page Content-->
        <?php 
    if (isset($_GET['success']))
    {
      echo "<div class=\"bg-success text-center p-3 h4 \">
        <p>".$_GET['success']." </p></div>";
    }

    if (isset($_GET['error']))
    {
      echo "<div class=\"bg-danger text-center p-3 h4 \">
        <p>".$_GET['error']." </p></div>";
    }
    ?>
  <div class="container pt-5 py-5">
    <!-- Page Features-->
  <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col" class="text-center h3">Instrument</th>
      <th scope="col" class="text-center h3">Firma</th>
      <th scope="col" class="text-center h3">Model</th>
      <th scope="col" class="text-center h3"></th>
    </tr>
  </thead>
  <tbody> 
   <?php  //filling table with data
   include("../config/config.php");
   if($_SESSION['rankID']!=3)
   {
$query = "SELECT ".$prefix."category.category_name, brand, model, ID_item FROM (".$prefix."items
inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category ) where ID_itemstatus=1
Order By category_name";

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

   while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
      <td class=\"text-center h4\">".$row["category_name"]."</td>
      <td class=\"text-center h4\">".$row["brand"]."</td>
      <td class=\"text-center h4\">".$row["model"]."</td>
      <td class=\"text-center h4\"> <a class=\"btn btn-primary\" href=\"../item/index.php?id=".$row["ID_item"]."\">Szczegóły </a>";  
      echo"</td>
    </tr>";
  }
  }

  if($_SESSION['rankID']==3)
{
  $query = "SELECT ".$prefix."category.category_name, brand, model, ID_item, ID_itemstatus FROM (".$prefix."items
inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category) Order By category_name";

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    while($row = mysqli_fetch_array($result)) 
    {
    echo"<tr>
    <td class=\"text-center h4\">".$row["category_name"]."</td>
    <td class=\"text-center h4\">".$row["brand"]."</td>
    <td class=\"text-center h4\">".$row["model"]."</td>
    <td class=\"text-center h4\"> <a class=\"btn btn-primary\" href=\"../item/index.php?id=".$row["ID_item"]."\">Szczegóły </a>"; 
    if ($row['ID_itemstatus']==1)
    {
      echo "<a class=\"btn btn-danger\" href=\"action.php?hideId=".$row["ID_item"]."\">Ukryj</a>";
    }
    else
    {
      echo "<a class=\"btn btn-danger\" href=\"action.php?showId=".$row["ID_item"]."\">Odkryj </a>";
    }
    } 

}

    ?>
  </tbody>
</table>
</div>

<?php



?>