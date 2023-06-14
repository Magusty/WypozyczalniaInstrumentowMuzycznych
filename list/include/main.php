 <!-- Header-->
 <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Lista 
                  <?php 
                  if ($_SESSION['rankID']==2)    
                   {
                    echo "klientów";
                  }
                  if ($_SESSION['rankID']==3)
                  {
                    if (isset($_GET['showworkers']))
                    {
                      echo "pracowników";
                    }
                    else
                    {
                      echo "użytkowników";
                    }
                  }
                  ?>
                  </h1>
                </div>
        </div>
        <!-- Page Content-->
        <?php 
if (isset($_GET['success']))
{
        echo "<div class=\"bg-success text-center p-3 \">
        <p class=\"h4\">".$_GET['success']." </p></div>";
}
if (isset($_GET['error']))
{
        echo "<div class=\"bg-danger text-center p-3 \">
        <p class=\"h4\">".$_GET['error']."</p></div>";
}

if ($_SESSION['rankID']==3)
{
echo "<div class = \"bg-info\"> 
<div class=\"container\">
<div class=\"d-flex  bd-highlight mb-3\">
  <div class=\"me-auto p-2 bd-highlight\"> ";
  
    echo "<a class=\"btn btn-primary\" href=\"addworker.php\">Dodaj nowego pracownika</a>";
    if(!isset($_GET['showworkers']))
{
    echo "<a class=\"btn btn-primary\" href=\"index.php?showworkers=1\">Pokaż pracowników</a>"; 
}
else
{
  echo "<a class=\"btn btn-primary\" href=\"index.php\">Pokaż wszystkich</a>"; 
}
echo "</div>
</div>
</div>
</div>";
}
  ?>
        <section class="pt-3 py-3">
        <div class="container px-1">
                <!-- Page Features-->
   <?php 
   include("../config/config.php");

   //WORKER
if ($_SESSION['rankID']==2)
{
  $query = "SELECT * from ".$prefix."users where ID_rank=1"; //pracownik moze sprawdzic tylko klientow

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Nazwa użytkownika</th>
      <th scope=\"col\" class=\"text-center\">Imię i nazwisko</th>
      <th scope=\"col\" class=\"text-center\">Miasto</th>
      <th scope=\"col\" class=\"text-center\">Adres</th>
      <th scope=\"col\" class=\"text-center\">Telefon</th>
    </tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
      <td class=\"text-center\">".$row["user_login"]."</td>
      <td class=\"text-center\">".$row["Imie"]." ".$row["Nazwisko"]."</td>
      <td class=\"text-center\">".$row["Miasto"]."</td>";
      if ($row['Numer_mieszkania']=="")
      {
      echo "<td class=\"text-center\">".$row["Ulica"]." ".$row["Numer_budynku"]."</td>";
      }
      else
      {
        echo "<td class=\"text-center\">".$row["Ulica"]." ".$row["Numer_budynku"]."/".$row["Numer_mieszkania"]."</td>";
      }
      echo "<td class=\"text-center\">".$row["Telefon"]."</td>";
  }
  echo "</tbody>
  </table> ";
}
else
{
  echo "<p class=\"text-center h3\"> Jeszcze żadna osoba się nie zarejestrowała </p>";
}
}

//ADMIN
if ($_SESSION['rankID']==3)
{
  $query = "SELECT *, ".$prefix."rank.rank from ".$prefix."users inner join ".$prefix."rank on ".$prefix."users.ID_rank=".$prefix."rank.ID_rank"; //admin moze sprawdzic wszystkich

if(isset($_GET['showworkers']))
{
  $query = "SELECT *, ".$prefix."rank.rank, ".$prefix."shops.miasto, ".$prefix."shops.adres, ".$prefix."useractive.active_name from (((".$prefix."users 
  inner join ".$prefix."rank on ".$prefix."users.ID_rank=".$prefix."rank.ID_rank) 
  inner join ".$prefix."workers on ".$prefix."users.ID_user = ".$prefix."workers.ID_user)
  inner join ".$prefix."shops on ".$prefix."workers.ID_shop = ".$prefix."shops.ID_shop)
  inner join ".$prefix."useractive on ".$prefix."users.ID_useractive = ".$prefix."useractive.ID_useractive
  where ".$prefix."users.ID_rank=2"; 
}
$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Nazwa użytkownika</th>
      <th scope=\"col\" class=\"text-center\">Imię i nazwisko</th>
      <th scope=\"col\" class=\"text-center\">Miasto</th>
      <th scope=\"col\" class=\"text-center\">Adres</th>
      <th scope=\"col\" class=\"text-center\">Telefon</th>
      <th scope=\"col\" class=\"text-center\">Rola</th>";
      
if (isset($_GET['showworkers']))
{
  echo "<th scope=\"col\" class=\"text-center\">Jednostka</th>
        <th scope=\"col\" class=\"text-center\">Akcja</th>";
}
    echo "</tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {   
    echo"<tr>
      <td class=\"text-center\">".$row["user_login"]."</td>
      <td class=\"text-center\">".$row["Imie"]." ".$row["Nazwisko"]."</td>
      <td class=\"text-center\">".$row["Miasto"]."</td>";
      if ($row['Numer_mieszkania']=="")
      {
      echo "<td class=\"text-center\">".$row["Ulica"]." ".$row["Numer_budynku"]."</td>";
      }
      else
      {
        echo "<td class=\"text-center\">".$row["Ulica"]." ".$row["Numer_budynku"]."/".$row["Numer_mieszkania"]."</td>";
      }
      echo "<td class=\"text-center\">".$row["Telefon"]."</td>
      <td class=\"text-center\">".$row["rank"]."</td>";
      $activeUser = $row['ID_useractive'];     
      if (isset($_GET['showworkers']))
          {            
            echo "<td class=\"text-center\">".$row['miasto']." - ".$row['adres']."</td>";
            switch ($activeUser)
            { case 1:
             { 
              echo "<td class=\"text-center\"> <a class=\"btn btn-primary\" href=\"changestatusworker.php?deactivate=".$row['ID_user']."\">Dezaktywuj pracownika</a> </td>";
              break;
             }
             case 2:
              {
              echo "<td class=\"text-center\"> <a class=\"btn btn-primary\" href=\"changestatusworker.php?activateworker=".$row['ID_user']."\">Aktywuj pracownika</a> </td>"; 
              break;
             }
            }
            echo "</tr>";     
          }
    }
  echo "</tbody>
  </table> ";

}
else
{
  echo "<p class=\"text-center h3\"> ";

  if (isset($_GET['showworkers']))
  {ECHO "Nie masz żadnych pracowników";}
  else
  {echo "Jeszcze żadna osoba się nie zarejestrowała";}
  echo "</p>";
}
}
else if ($_SESSION['rankID']==1 || !isset($_SESSION['rankID']))
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Odmowa dostępu </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../index.php\">Powrót do strony głównej</a></div> </div>";
}

   ?>
   
  </div>
</section>