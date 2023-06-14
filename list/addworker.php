<?php
session_start();
include("../config/config.php");
if(isset($_POST['addworker']) && $_SESSION['rankID']==3)
{
        $log = $_POST['login_reg'];
        $pas1 = $_POST['password_reg'];
        $pas2 = $_POST['password_reg2'];
    
        $query = "SELECT user_login from ".$prefix."users where user_login = '$log'";
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
        $rowCount = mysqli_num_rows($result);
        
    
        if ($pas1 == $pas2 && !$rowCount==1) //hasla sie zgadzaja i user name sie nie powtarza
        {     $today = date("Y-m-d");
            $hashpass = password_hash($pas1, PASSWORD_DEFAULT);
            if ($_POST['nrmieszk_reg'] != "")
            {
                $nrMieszk = $_POST['nrmieszk_reg'];
            }
            else
            {
                $nrMieszk = "null";
            }
            $query = "INSERT INTO ".$prefix."users (user_login, user_password, ID_rank, Imie, Nazwisko, Miasto, Ulica, Numer_budynku, Numer_mieszkania, Telefon, account_created, ID_useractive) 
            VALUES ('$log', '".$hashpass. "', 2,'".$_POST['imie_reg']."','".$_POST['nazwisko_reg']."','".$_POST['miasto_reg']."', 
            '".$_POST['ulica_reg']."',".$_POST['nrbud_reg'].",".$nrMieszk.",'".$_POST['phone']."','".$today."',1)";
            $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");           

            $query = "SELECT ID_user from ".$prefix."users where user_login='".$log."'";
            $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
            $row = mysqli_fetch_array($result);

            $query = "INSERT INTO ".$prefix."workers (ID_shop, ID_user) values (".$_POST['combo_work'].", ".$row['ID_user'].")";
            $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
            $rowCount = mysqli_num_rows($result);

            header ("Location: index.php?success=Rejestracja pracownika przebiegła pomyślnie.");
            
        }
        else if ($pas1!=$pas2 && $rowCount==1) //nazwa uzytkownika juz istnieje, hasla roznia sie
        {
            header ("Location: addworker.php?error=Nazwa użytkownika jest zajęta");
        }
        else if ($pas1==$pas2 && $rowCount==1) //nazwa uzytkownika juz istnieje, hasla takie same
        {
            header ("Location: addworker.php?error=Nazwa użytkownika jest zajęta");
        }
        else if ($pas1!=$pas2) //hasla roznia sie
        {
            header ("Location: addworker.php?error=Drugie hasło zostało błędnie wprowadzone");
        }
        else if ($rowCount==1) //nazwa uzytkownika istnieje
        {
            header ("Location: addworker.php?error=Nazwa użytkownika jest zajęta");
        }
   
}
include("include/header.php");
include("include/nav.php");
?>
        <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Dodawanie nowego pracownika</h1>
                </div>
        </div>

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
    {
        form_add_worker();
    }
    else
    {
        echo "<div class=\"text-center\">";
        echo "<p class=\"font-weight-bold h4\"> Odmowa dostępu </p>";
        echo "<div class=\"p-2 bd-highlight\"> ";
        echo "<a class=\"btn btn-primary\" href=\"../index.php\">Powrót do strony głównej</a></div> </div>";
    }

include("include/footer.php");

//============================================== funkcje ====================================================

function form_add_worker()
{
    include("../config/config.php");
    echo "<div class=\"py-4\">  
    <div class=\"container px-lg-5\"> 
    <div class=\"px-prc\">
                <div class=\"flex-row d-flex flex-row bd-highlight mb-3 justify-content-center\">
                        <div class=\" bd-highlight p-lg-5 bg-light rounded-5 text-right\">
                <form class=\"form-horizontal px-4\" action=\"addworker.php\" method=\"POST\" >
                                <p>Login</p>
                                <p> <input type=\"text\" required name=\"login_reg\"> </p>
                                <p>Hasło</p>
                                <p> <input type=\"password\" required  name=\"password_reg\"> </p>
                                <p>Powtórz hasło</p>
                                <p> <input type=\"password\" required  name=\"password_reg2\"> </p>
                        </div>
                        <div class=\" bd-highlight p-lg-5 bg-light rounded-3 text-right\">
                                <p> Imię </p>
                                <p> <input type=\"text\" required name=\"imie_reg\"> </p>
                                <p> Nazwisko </p>
                                <p> <input type=\"text\" required name=\"nazwisko_reg\"> </p>
                                <p> Numer telefonu <br>(format: XXX-XXX-XXX) </p>
                                <input type=\"tel\" name=\"phone\" pattern=\"[0-9]{3}-[0-9]{3}-[0-9]{3}\" required> 
                                <p> Jednostka </p>
                        <select name=\"combo_work\">";
                        $query = "select * from ".$prefix."shops";
                        $result = mysqli_query($link, $query) or die("Zapytanie zakończone niepowodzeniem");

                        echo "<option value=\"\"> </option>";
                        while ($row = mysqli_fetch_array($result)) {
                            $value = $row['miasto']." - ".$row['adres'];
                            echo "<option value='" . $row['ID_shop'] . "'>" . $value . "</option>";
                        }
                        echo "</select>                                                       
                        </div>
                        <div class=\"bd-highlight p-lg-5 bg-light rounded-3 text-right\">
                                <p> Miasto </p>
                                <p> <input type=\"text\" required name=\"miasto_reg\"> </p>  
                                <p> Ulica </p>
                                <p> <input type=\"text\" required name=\"ulica_reg\"> </p>
                                <p> Numer budynku </p>
                                <p> <input type=\"number\" min=\"1\" required name=\"nrbud_reg\"> </p>
                                <p> Numer mieszkania </p> 
                                <p> <input type=\"number\" name=\"nrmieszk_reg\" min=\"1\"> </p>
                        </div> 
                        </div></div>
                        <div class=\"container py-1 d-grid\">                   
                        <button class=\"btn btn-secondary btn-lg\" type=\"submit\" name=\"addworker\">Dodaj pracownika</button>  
                </form> 
        </div> 
            <div class=\"container py-1 d-grid\">
                <a class=\"btn btn-primary btn-lg\" href=\"index.php\">Powrót do listy</a>
        </div>
    </div>
    </div> </div>
    </div>
</form </div>";
                    }

?>