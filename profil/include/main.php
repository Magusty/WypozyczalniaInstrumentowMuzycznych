 <!-- Header-->
 <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Mój profil</h1>
                </div>
        </div>
      <?php  if (isset($_GET['success']))
{
        echo "<div class=\"bg-success text-center p-3 \">
        <p class=\"h4\">".$_GET['success']."</p></div>";
}
if (isset($_GET['error']))
{
        echo "<div class=\"bg-danger text-center p-3 \">
        <p class=\"h4\">".$_GET['error']."</p></div>";
} 

if (!isset($_SESSION['userID']))
{
    echo "<div class=\"text-center\">";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../zaloguj/index.php\">Logowanie</a></div> </div>";
}
?>
        <!-- Page Content-->
        <section class="pt-5 py-5">
                <!-- Page Features-->
                <div class="container px-lg-5">
                <div class="d-flex flex-row bd-highlight mb-3 justify-content-center">
                <div class="p-2 bd-highlight">
                            <?php 
                            if (isset($_SESSION['userID']))
                        {
                            include("../config/config.php");
                            
                            $query = "Select * from ".$prefix."users where ID_user=".$_SESSION['userID'];
                            $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
                            $row = mysqli_fetch_array($result);
                            echo 
                            "<p class=\"h4\"> Imię: ".$row['Imie']."</p>
                            <p class=\"h4\"> Nazwisko: ".$row['Nazwisko']."</p>
                            <p class=\"h4\"> Miasto: ".$row['Miasto']." </p>
                            <p class=\"h4\"> Ulica: ".$row['Ulica']." </p>";
                            
                            if ($row['Numer_mieszkania'] == "")
                            {
                                echo "<p class=\"h4\"> Numer budynku: ".$row['Numer_budynku']." </p>";                            
                            }
                            else
                            {
                                echo "<p class=\"h4\"> Numer: ".$row['Numer_budynku']."/".$row['Numer_mieszkania']." </p>";
                            }
                            echo "<p class=\"h4\"> Telefon: ".$row['Telefon']." </p>";
                            echo "<p class=\"h4\"> Założenie konta: ".$row['account_created']." </p>";
                            
                            echo "<a class=\"btn btn-primary\" href=\"editprofile.php\">Edytuj profil</a>
                            </div>
                <div class=\"p-2 bd-highlight\">
                                <form action=\"index.php\" method=\"POST\"> 
                                <div class=\"container px-lg-5\">
                                <div class=\"p-4 p-lg-5 rounded-3 text-left\">
                                <legend>Zmień hasło</legend>
                                <p>Stare hasło</p>
                                <p> <input type=\"password\" required name=\"old_password\"> </p>
                                <p>Hasło</p>
                                <p> <input type=\"password\" required  name=\"password_new\"> </p>
                                <p>Powtórz hasło</p>
                                <p> <input type=\"password\" required  name=\"password_new2\"> </p>          
                                <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"password_change\">Zmień hasło</button>
                                </div>
                                </div>
                                </form>
                                </div>";
                        }
                        
                        ?>
                       </div>
                   </div>
                </div>                 
        </section>