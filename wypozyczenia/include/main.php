 <!-- Header-->
 <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold"> <?php 
                    if ($_SESSION['rankID']==1)
                    {
                      echo "Twoje";
                    }
                    else if (($_SESSION['rankID']==2 || $_SESSION['rankID']==3) && isset($_GET['tomorrow']))
                    { echo "Jutrzejsze"; }
                    else if(($_SESSION['rankID']==2 || $_SESSION['rankID']==3) && isset($_GET['all']))
                    { echo "Wszystkie";}
                    else if ($_SESSION['rankID']==2 || $_SESSION['rankID']==3)
                    {
                      echo "Dzisiejsze";
                    }
                    ?>
                    Wypożyczenia</h1>
                </div>
        </div>
        <!-- Page Content-->
        <?php
if (isset($_GET['changed']))
{
  echo "<div class=\"bg-success text-center p-3\">
        <p class=\"h4\">".$_GET['changed']."</p></div>";
}
if (isset($_GET['error']))
{
  echo "<div class=\"bg-danger text-center p-3\">
        <p class=\"h4\">".$_GET['error']."</p></div>";
}

if($_SESSION['rankID']!=1 && isset($_SESSION['rankID']))
{
echo "<div class = \"bg-info\"> 
        <div class=\"container\">
        <div class=\"d-flex  bd-highlight mb-3\">
  <div class=\"p-2 bd-highlight\"> ";
     
    echo "<a class=\"btn btn-primary\" href=\"index.php?all=1\">Wszystkie zamówienia</a> </div>";
    if(!isset($_GET['showworkers']))
    echo "<div class=\"p-2 bd-highlight\">  <a class=\"btn btn-primary\" href=\"index.php\">Dzisiejsze odbiory/zwroty</a> </div>"; 
    echo "<div class=\"p-2 bd-highlight\"> <a class=\"btn btn-primary\" href=\"index.php?tomorrow=1\">Jutrzejsze odbiory/zwroty</a> </div>"; 
}
  ?> 
</div>
</div>
</div>
        <section class="pt-5 py-5">
        <div class="container px-1">
                <!-- Page Features-->
   <?php 
   include("../config/config.php");

if ($_SESSION['rankID']==1)
{
  $query = "SELECT ".$prefix."category.category_name, ".$prefix."items.brand, ".$prefix."items.model, DataOdebrania, DataOddania, DoZaplaty, ".$prefix."rentstatus.rentstatus_name, ".$prefix."rents.ID_rentstatus, ID_rent,
  ".$prefix."shops.miasto, ".$prefix."shops.adres, ".$prefix."rents.kaucja
  from ((((".$prefix."rents 
inner join ".$prefix."items on ".$prefix."rents.ID_item = ".$prefix."items.ID_item) 
inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category)
inner join ".$prefix."rentstatus on ".$prefix."rents.ID_rentstatus = ".$prefix."rentstatus.ID_rentstatus)
INNER JOIN ".$prefix."shops on ".$prefix."rents.ID_shop = ".$prefix."shops.ID_shop)
where ID_user = ".$_SESSION['userID']." ORDER BY DataOddania DESC";

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Instrument</th>
      <th scope=\"col\" class=\"text-center\">Wypożyczalnia</th>
      <th scope=\"col\" class=\"text-center\">Data odebrania</th>
      <th scope=\"col\" class=\"text-center\">Data oddania</th>
      <th scope=\"col\" class=\"text-center\">Kaucja</th>
      <th scope=\"col\" class=\"text-center\">Do zapłaty</th>
      <th scope=\"col\" class=\"text-center\">Status</th>
      <th scope=\"col\" class=\"text-center\">Akcja</th>
    </tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
      <td class=\"text-center\">".$row["category_name"]." | ".$row["brand"]." ".$row["model"]."</td>
      <td class=\"text-center\">".$row['miasto']." - ".$row['adres']."</td>
      <td class=\"text-center\">".$row["DataOdebrania"]."</td>
      <td class=\"text-center\">".$row["DataOddania"]."</td>
      <td class=\"text-center\">".$row["kaucja"]."</td>
      <td class=\"text-center\">".$row["DoZaplaty"]."</td>
      <td class=\"text-center\">".$row["rentstatus_name"]."</td>";
      
    if ($row['ID_rentstatus'] == 3)
    {
      echo "<td class=\"text-center\"> <a class=\"btn btn-danger\" href=\"cancelrent.php?idRent_cancel=".$row['ID_rent']."\"> Anuluj rezerwację </a> </td>";
    }
    else
    {
      echo "<td class=\"text-center\"></td>";
    }
  }
  } 
  else
  {
    echo "<p class=\"text-center h3\"> Nic jeszcze nie wypożyczyłeś </p>";
  }
}

else if ($_SESSION['rankID']==2)
{
  $tomorrow = date("Y-m-d", strtotime("+1 day"));
  $today = date("Y-m-d");
  if (isset($_GET['tomorrow']))
  {
    $condition="where (".$prefix."rents.ID_rentstatus = 1 or ".$prefix."rents.ID_rentstatus=3) and (DataOdebrania ='".$tomorrow."' or DataOddania='".$tomorrow."') and ".$prefix."workers.ID_shop=".$_SESSION['shopID'];
  $ifempty = "Wygląda na to, że jutro nie ma nic do roboty";
  }
  else if (isset($_GET['all']))
  {
    $condition ="where ".$prefix."rents.ID_rentstatus = 1 or ".$prefix."rents.ID_rentstatus=3";
    $ifempty = "Brak wypożyczeń";
  }
  else //today
  {
    $condition = "where (".$prefix."rents.ID_rentstatus = 1 or ".$prefix."rents.ID_rentstatus=3) and (DataOdebrania ='".$today."' or DataOddania='".$today."')";
    $ifempty = "Wygląda na to, że dzisiaj nie ma nic do roboty";
  }
  $query = "SELECT ID_rent, ".$prefix."category.category_name, ".$prefix."items.brand, ".$prefix."items.model, DataOdebrania, DataOddania, DoZaplaty, 
  ".$prefix."users.user_login, ".$prefix."users.ID_user, ".$prefix."rentstatus.rentstatus_name, ".$prefix."status.status_name, ".$prefix."rents.ID_rentstatus, ".$prefix."rents.kaucja,
  ".$prefix."shops.miasto, ".$prefix."shops.adres
  from (((((((".$prefix."rents 
  inner join ".$prefix."items on ".$prefix."rents.ID_item = ".$prefix."items.ID_item) 
  inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category) 
  inner join ".$prefix."users on ".$prefix."rents.ID_user=".$prefix."users.ID_user)
  inner join ".$prefix."rentstatus on ".$prefix."rents.ID_rentstatus = ".$prefix."rentstatus.ID_rentstatus)
  inner join ".$prefix."status on ".$prefix."items.ID_status = ".$prefix."status.ID_status)
  INNER JOIN ".$prefix."shops on ".$prefix."rents.ID_shop = ".$prefix."shops.ID_shop)
  INNER JOIN ".$prefix."workers on ".$prefix."shops.ID_shop = ".$prefix."workers.ID_shop)".$condition;

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
  if (mysqli_num_rows($result) > 0)
  {
    echo "<table class=\"table table-bordered\">
    <thead>
      <tr>
        <th scope=\"col\" class=\"text-center\">Instrument</th>
        <th scope=\"col\" class=\"text-center\">Data odebrania</th>
        <th scope=\"col\" class=\"text-center\">Data oddania</th>
        <th scope=\"col\" class=\"text-center\">Status zamówienia</th>
        <th scope=\"col\" class=\"text-center\">Akcje</th>
      </tr>
    </thead>
    <tbody> ";
    while($row = mysqli_fetch_array($result)) 
    {
      echo"<tr>
        <td class=\"text-center\">".$row["category_name"]." | ".$row["brand"]." ".$row["model"]."</td>
        <td class=\"text-center\">".$row["DataOdebrania"]."</td>
        <td class=\"text-center\">".$row["DataOddania"]."</td>
        <td class=\"text-center\">".$row["rentstatus_name"]."</td>
        <td class=\"text-center\"> <a class=\"btn btn-info\" href=\"wypozyczenia.php?id=".$row["ID_rent"]."\">Pokaż </a>";
        if($row['ID_rentstatus']==3 && $row['kaucja']>0)
        {
          echo "<a class=\"btn btn-danger\" href=\"payment.php?idRent_kaucja=".$row['ID_rent']."\"> Dodaj wpłacenie kaucji </a>";
        }
        echo "<a class=\"btn btn-danger\" href=\"cancelrent.php?idRent=".$row['ID_rent']."\"> Zmień status wypożyczenia </a>";  
        if ($row['DoZaplaty']>0)
        {
        echo "<a class=\"btn btn-danger\" href=\"payment.php?idRent=".$row['ID_rent']."\"> Dodaj zapłatę </a>";
      }
        echo "</td> </tr>";
    }
  }
  else
  {
    echo "<p class=\"text-center h3\">".$ifempty."</p>";
  }
}

else if ($_SESSION['rankID']==3)
{
  $tomorrow = date("Y-m-d", strtotime("+1 day"));
  $today = date("Y-m-d");

  if (isset($_GET['tomorrow']))
  {
    $condition = "where (DataOdebrania ='".$tomorrow."' or DataOddania='".$tomorrow."') and (".$prefix."rents.ID_rentstatus = 1 or ".$prefix."rents.ID_rentstatus=3)";
    $isempty= "Wygląda na to, że jutro nie ma nic do roboty";
  }
  else if (isset($_GET['all']))
  { 
     $condition = "";
     $isempty = "Nic nie zostało wypożyczone";
  }
  else
  {
    $condition = "where (DataOdebrania ='".$today."' or DataOddania='".$today."') and (".$prefix."rents.ID_rentstatus = 1 or ".$prefix."rents.ID_rentstatus=3)";
    $isempty = "Wygląda na to, że dzisiaj nie ma nic do roboty";
  }
  $query = "SELECT ID_rent, ".$prefix."category.category_name, ".$prefix."items.brand, ".$prefix."items.model, DataOdebrania, DataOddania, DoZaplaty, 
  ".$prefix."users.user_login, ".$prefix."users.ID_user, ".$prefix."rentstatus.rentstatus_name, ".$prefix."status.status_name, ".$prefix."rents.ID_rentstatus, ".$prefix."rents.kaucja, ".$prefix."shops.miasto, ".$prefix."shops.adres
  from ((((((".$prefix."rents 
  inner join ".$prefix."items on ".$prefix."rents.ID_item = ".$prefix."items.ID_item) 
  inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category) 
  inner join ".$prefix."users on ".$prefix."rents.ID_user=".$prefix."users.ID_user)
  inner join ".$prefix."shops on ".$prefix."rents.ID_shop = ".$prefix."shops.ID_shop)
  inner join ".$prefix."rentstatus on ".$prefix."rents.ID_rentstatus = ".$prefix."rentstatus.ID_rentstatus)
  inner join ".$prefix."status on ".$prefix."items.ID_status = ".$prefix."status.ID_status)".$condition;

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Instrument</th>
      <th scope=\"col\" class=\"text-center\">Data odebrania</th>
      <th scope=\"col\" class=\"text-center\">Data oddania</th>
      <th scope=\"col\" class=\"text-center\">Status zamówienia</th>
      <th scope=\"col\" class=\"text-center\">Wypożyczalnia</th>
      <th scope=\"col\" class=\"text-center\">Akcje</th>
    </tr>
  </thead>
  <tbody> ";
  while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
      <td class=\"text-center\">".$row["category_name"]." | ".$row["brand"]." ".$row["model"]."</td>
      <td class=\"text-center\">".$row["DataOdebrania"]."</td>
      <td class=\"text-center\">".$row["DataOddania"]."</td>
      <td class=\"text-center\">".$row["rentstatus_name"]."</td>
      <td class=\"text-center\">".$row["miasto"]." - ".$row['adres']."</td>
      <td class=\"text-center\"> <a class=\"btn btn-info\" href=\"wypozyczenia.php?id=".$row["ID_rent"]."\">Pokaż </a>";
      
      if($row['ID_rentstatus']==3 && $row['kaucja']>0)
      {
        echo "<a class=\"btn btn-danger\" href=\"payment.php?idRent_kaucja=".$row['ID_rent']."\"> Dodaj wpłacenie kaucji </a>";
      }
      if ($row['DoZaplaty']>0 && $row['ID_rentstatus']!=4)
      {
      echo "<a class=\"btn btn-danger\" href=\"payment.php?idRent=".$row['ID_rent']."\"> Dodaj zapłatę </a>";
    }
      if($row['ID_rentstatus']!=4 && $row['ID_rentstatus']!=2)
      {
      echo "<a class=\"btn btn-danger\" href=\"cancelrent.php?idRent=".$row['ID_rent']."\"> Zmień status wypożyczenia </a>"; 
    } 
      
      echo "</td> </tr>";
  }
}
else
{
  echo "<p class=\"text-center h3\">".$isempty."</p>";
}
}
else
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Zaloguj się, by uzyskać dostęp </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../zaloguj/index.php\">Logowanie</a></div> </div>";
}
    ?>
  </tbody>
</table>  
</div>
        </section>