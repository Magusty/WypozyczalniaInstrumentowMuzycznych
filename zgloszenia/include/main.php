 <!-- Header-->
 <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">
                      <?php if ($_SESSION['rankID']==1)
                      {
                        echo "Twoje zgłoszenia";
                      }
                      else {echo "Zgłoszenia";} ?>
                      </h1>
                </div>
        </div>
        <!-- Page Content-->
  <?php
if ($_SESSION['rankID']!=1 && isset($_SESSION['rankID'])) //pasek dla pracownika i admina z jakimis funkcjonalnosciami
{
  echo "<div class = \"bg-info\"> 
  <div class=\"container px-lg-4\">
  <div class=\"d-flex  bd-highlight mb-3\">
  <div class=\"p-2 bd-highlight\"> ";
    
    if (isset($_GET['myinquiries']) || isset($_GET['closed']))
    {
      echo "<a class=\"btn btn-primary\" href=\"index.php\">Pokaż wszystkie zgłoszenia</a>";
    }
    else
    {
   echo "<a class=\"btn btn-primary\" href=\"index.php?myinquiries=1\">Pokaż moje zgłoszenia</a> </div>";
      if ($_SESSION['rankID']==3)
      {
       echo "<div class=\"p-2 bd-highlight\"> ";
       echo "<a class=\"btn btn-primary\" href=\"index.php?closed=1\">Pokaż zamknięte zgłoszenia </a></div>";
      }
    }
}
   ?>
   </div>
   </div>
   </div></div>
    
  <section class="pt-5 py-5">
  <div class="container px-lg-5">
    <!-- Page Features-->
  
   <?php 

   if ($_SESSION['rankID']==1) //USER
   {
   include("../config/config.php");
$query = "SELECT ID_inquiry, ".$prefix."inquiriesstatus.inquiry_status from (".$prefix."inquiries inner join ".$prefix."inquiriesstatus
on ".$prefix."inquiries.ID_inquirystatus = ".$prefix."inquiriesstatus.ID_inquirystatus) where ID_user=".$_SESSION['userID'];

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Nr zgłoszenia</th>
      <th scope=\"col\" class=\"text-center\">Status</th>
    </tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
      <td class=\"text-center\"> <a class=\"btn btn-link\" href=\"zgloszenie.php?zgloszenie=".$row["ID_inquiry"]."\">".$row["ID_inquiry"]."</a></td>
      <td class=\"text-center\">".$row["inquiry_status"]."</td>
    </tr>";
  }
}
else
{
  echo "<p class=\"text-center h3\"> Nie masz żadnych zgłoszeń </p>";
}
}

else if ($_SESSION['rankID']==2) //WORKER
   {
   include("../config/config.php");

    if (isset($_GET['myinquiries']))
    {
      $addictionalParams = ", ".$prefix."answers.ID_user, ".$prefix."users.Imie, ".$prefix."users.Nazwisko, ".$prefix."users.user_login ";
      $nawiasy = "((";
      $innerJoin = " inner join ".$prefix."answers on ".$prefix."inquiries.ID_inquiry= ".$prefix."answers.ID_inquiry)
      inner join ".$prefix."users on ".$prefix."answers.ID_user = ".$prefix."users.ID_user) ";
      $condition = " where ".$prefix."answers.ID_user=".$_SESSION['userID']." ";
    }
    else
    {
      $condition = " where ".$prefix."inquiriesstatus.ID_inquirystatus=1 ";
    }

$query = "SELECT ".$prefix."inquiries.ID_inquiry, ".$prefix."inquiriesstatus.inquiry_status, ".$prefix."items.brand, ".$prefix."items.model, ".$prefix."category.category_name ".$addictionalParams." 
from 
((".$nawiasy."(".$prefix."inquiries 
inner join ".$prefix."items on ".$prefix."inquiries.ID_item = ".$prefix."items.ID_item) 
inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category)
inner join ".$prefix."inquiriesstatus on ".$prefix."inquiries.ID_inquirystatus = ".$prefix."inquiriesstatus.ID_inquirystatus)
".$innerJoin." ".$condition." order by ".$prefix."inquiriesstatus.ID_inquirystatus";

$result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
if (mysqli_num_rows($result) > 0)
{
  echo "<table class=\"table table-bordered\">
  <thead>
    <tr>
      <th scope=\"col\" class=\"text-center\">Nr zgłoszenia</th>
      <th scope=\"col\" class=\"text-center\">Status</th>
      <th scope=\"col\" class=\"text-center\">Instrument</th>
      <th scope=\"col\" class=\"text-center\">Model</th>
    </tr>
  </thead>
  <tbody> ";
   while($row = mysqli_fetch_array($result)) 
  {
    echo"<tr>
      <td class=\"text-center\"> <a class=\"btn btn-link\" href=\"zgloszenie.php?zgloszenie=".$row["ID_inquiry"]."\">".$row["ID_inquiry"]."</a></td>
      <td class=\"text-center\">".$row["inquiry_status"]."</td>
      <td class=\"text-center\">".$row["category_name"]."</td>
      <td class=\"text-center\">".$row["brand"]." ".$row["model"]."</td>
    </tr>";
  }
}
else
{
  echo "<p class=\"text-center h3\"> Brak zgłoszeń </p>";
}
}

else if ($_SESSION['rankID']==3) //ADMIN
{
   include("../config/config.php");

    if (isset($_GET['myinquiries']))
    {
      $condition = "where ".$prefix."answers.ID_user=".$_SESSION['userID'];
      $addictionalParams = ", ".$prefix."answers.ID_user, ".$prefix."users.Imie, ".$prefix."users.Nazwisko, ".$prefix."users.user_login";
      $nawiasy = "((";
      $innerJoin="inner join ".$prefix."answers on ".$prefix."inquiries.ID_inquiry = ".$prefix."answers.ID_inquiry)
      inner join ".$prefix."users on ".$prefix."answers.ID_user = ".$prefix."users.ID_user)";
    }

    if (isset($_GET['closed']))
    {
      $addictionalParams = ", ".$prefix."answers.ID_user, ".$prefix."users.Imie, ".$prefix."users.Nazwisko, ".$prefix."users.user_login";
      $nawiasy = "((";
      $innerJoin="inner join ".$prefix."answers on ".$prefix."inquiries.ID_inquiry = ".$prefix."answers.ID_inquiry)
      inner join ".$prefix."users on ".$prefix."answers.ID_user = ".$prefix."users.ID_user)";
    }

    $query = "SELECT ".$prefix."inquiries.ID_inquiry, ".$prefix."inquiriesstatus.inquiry_status, ".$prefix."items.brand, ".$prefix."items.model, ".$prefix."category.category_name 
    ".$addictionalParams." from 
   ".$nawiasy."(((".$prefix."inquiries  
   inner join ".$prefix."items on ".$prefix."inquiries.ID_item = ".$prefix."items.ID_item) 
   inner join ".$prefix."category on ".$prefix."items.ID_category = ".$prefix."category.ID_category)
   inner join ".$prefix."inquiriesstatus on ".$prefix."inquiries.ID_inquirystatus = ".$prefix."inquiriesstatus.ID_inquirystatus) 
   ".$innerJoin." ".$condition."
   order by ".$prefix."inquiriesstatus.ID_inquirystatus";

    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    if (mysqli_num_rows($result) > 0)
    {
      echo "<table class=\"table table-bordered\">
      <thead>
        <tr>
          <th scope=\"col\" class=\"text-center\">Nr zgłoszenia</th>
          <th scope=\"col\" class=\"text-center\">Status</th>
          <th scope=\"col\" class=\"text-center\">Instrument</th>
          <th scope=\"col\" class=\"text-center\">Model</th>";
          if (isset($_GET['closed']))
          {
            echo "<th scope=\"col\" class=\"text-center\">Pracownik</th>";
          }
        echo "</tr>
      </thead>
      <tbody> ";
       while($row = mysqli_fetch_array($result)) 
      {
        echo"<tr>
          <td class=\"text-center\"> <a class=\"btn btn-link\" href=\"zgloszenie.php?zgloszenie=".$row["ID_inquiry"]."\">".$row["ID_inquiry"]."</a></td>
          <td class=\"text-center\">".$row["inquiry_status"]."</td>
          <td class=\"text-center\">".$row["category_name"]."</td>
          <td class=\"text-center\">".$row["brand"]." ".$row["model"]."</td>";
          if (isset($_GET['closed']))
          {
              echo "<td class=\"text-center\">".$row["Imie"]." ".$row["Nazwisko"]." (".$row["user_login"].") </td>";
          }
        echo "</tr>";
      }
    }
    else
    {
      echo "<p class=\"text-center h3\"> Brak zgłoszeń </p>";
    }
}
else //niezalogowany uzytkownik sie zgubil
{
  echo "<div class=\"text-center\">";
  echo "<p class=\"font-weight-bold h4\"> Zaloguj się, by uzyskać dostęp </p>";
  echo "<div class=\"p-2 bd-highlight\"> ";
  echo "<a class=\"btn btn-primary\" href=\"../zaloguj/index.php\">Logowanie </a></div> </div>";
}
    ?>
  </tbody>
</table>  
</div>
        </section>