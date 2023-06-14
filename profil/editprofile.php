<?php session_start();
include("../config/config.php"); 
if(isset($_POST['edit_user']) && isset($_SESSION['userID']))
{
     if ($_POST['nrmieszk_edit'] == "")
     {
     $query = "UPDATE tb_users set Imie='".$_POST['imie_edit']."', Nazwisko ='". $_POST['nazwisko_edit']."', Telefon ='". $_POST['phone']."', Miasto ='".$_POST['miasto_edit']."', 
     Ulica='".$_POST['ulica_edit']."', Numer_budynku=".$_POST['nrbud_edit'].", Numer_mieszkania= NULL where ID_user=".$_SESSION['userID'];
     }
     else
     {
     $query = "UPDATE tb_users set Imie='".$_POST['imie_edit']."', Nazwisko ='". $_POST['nazwisko_edit']."', Telefon ='". $_POST['phone']."', Miasto ='".$_POST['miasto_edit']."', 
     Ulica='".$_POST['ulica_edit']."', Numer_budynku=".$_POST['nrbud_edit'].", Numer_mieszkania=".$_POST['nrmieszk_edit']." where ID_user=".$_SESSION['userID'];
     }

    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    
    header("Location: index.php?success=Pomyślnie zedytowano informacje");
}

include("include/header.php");
include("include/nav.php");
?>
 <div class="p-4 p-lg-5 bg-secondary text-center">
      <div class="m-4 m-lg-2">
          <h1 class="display-5 fw-bold">Edycja profilu</h1>
      </div>
 </div>
<?php
if (isset($_SESSION['userID']))
{
     edit_form();             
}
else if (!isset($_SESSION['userID']))
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Nie jesteś zalogowany </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../zaloguj/index.php\">Logowanie</a></div> </div>";
}
        
include("include/footer.php");

function edit_form()
{
        include("../config/config.php");
        $query = "SELECT * from tb_users where ID_user=".$_SESSION['userID'];
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        $row = mysqli_fetch_array($result);
echo "<div class=\"px-prc\">
        <div class=\"flex-row d-flex flex-row bd-highlight mb-3 justify-content-center\">
                <div class=\"bd-highlight p-lg-5 bg-light rounded-3 text-right\">
        <form class=\"form-horizontal px-4\" action=\"editprofile.php\" method=\"POST\" > 
                <p> Imię* </p>
                <p> <input type=\"text\" required name=\"imie_edit\" value=".$row['Imie']."> </p>
                <p> Nazwisko* </p>
                <p> <input type=\"text\" required name=\"nazwisko_edit\" value=".$row['Nazwisko']."> </p>
                <p> Numer telefonu* <br>(format: XXX-XXX-XXX) </p>
                <input type=\"tel\" name=\"phone\" pattern=\"[0-9]{3}-[0-9]{3}-[0-9]{3}\" required value=".$row['Telefon'].">                                                           
        </div>
        <div class=\" bd-highlight p-lg-5 bg-light rounded-3 text-right\">
                <p> Miasto* </p>
                <p> <input type=\"text\" required name=\"miasto_edit\" value=".$row['Miasto']."> </p>  
                <p> Ulica* </p>
                <p> <input type=\"text\" required name=\"ulica_edit\" value=".$row['Ulica']."> </p>
                <p> Numer budynku* </p>
                <p> <input type=\"number\" min=\"1\" required name=\"nrbud_edit\" value=".$row['Numer_budynku']."> </p>
                <p> Numer mieszkania </p> 
                <p> <input type=\"number\" name=\"nrmieszk_edit\" min=\"1\" value=".$row['Numer_mieszkania']."> </p>
        </div> 
        </div>
        <div class=\"pb-2 px-prc text-center\">                   
        <button class=\"btn btn-secondary btn-lg\" type=\"submit\" name=\"edit_user\">Zatwierdź zmiany</button>  
        </div>
        </form> 
</div>";
}


?>