 <!-- Header-->
 <?php 
if (isset($_GET['success']))
{
        echo "<div class=\"bg-success text-center p-3 h4 \">
        <p>".$_GET['success']." <a href=\"../zaloguj/index.php\"> Możesz się zalogować</a> </p></div>";
}
if (isset($_GET['error']))
{
        echo "<div class=\"bg-danger text-center p-3 h4 \">
        <p>".$_GET['error']."</p></div>";
}
?>
  
 <header class="py-5">
        <div class="container px-lg-5">
            <div class="text-center">
                    <h1 class="display-5 fw-bold">Rejestracja</h1>
            </div>
        </div>
</header>
      <!-- Page Content-->
        <section class="pt-5 py-5">
                <!-- Page Features-->
        <div class="px-prc">
                <div class="flex-row d-flex flex-row bd-highlight mb-3 justify-content-center">
                        <div class=" bd-highlight p-lg-5 bg-light rounded-3 text-right">
                <form class="form-horizontal px-4" action="rejestracja.php" method="POST" >
                                <p>Login*</p>
                                <p> <input type="text" required name="login_reg"> </p>
                                <p>Hasło*</p>
                                <p> <input type="password" required  name="password_reg"> </p>
                                <p>Powtórz hasło*</p>
                                <p> <input type="password" required  name="password_reg2"> </p>
                        </div>
                        <div class=" bd-highlight p-lg-5 bg-light rounded-3 text-right">
                                <p> Imię* </p>
                                <p> <input type="text" required name="imie_reg"> </p>
                                <p> Nazwisko* </p>
                                <p> <input type="text" required name="nazwisko_reg"> </p>
                                <p> Numer telefonu* <br>(format: XXX-XXX-XXX) </p>
                                <input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required>                                                           
                        </div>
                        <div class=" bd-highlight p-lg-5 bg-light rounded-3 text-right">
                                <p> Miasto* </p>
                                <p> <input type="text" required name="miasto_reg"> </p>  
                                <p> Ulica* </p>
                                <p> <input type="text" required name="ulica_reg"> </p>
                                <p> Numer budynku* </p>
                                <p> <input type="number" min="1" required name="nrbud_reg"> </p>
                                <p> Numer mieszkania </p> 
                                <p> <input type="number" name="nrmieszk_reg" min="1"> </p>
                        </div> 
                        </div>
                        <div class="pb-2 px-prc">                   
                        <button class="btn btn-secondary btn-lg" type="submit" name="register_user">Zarejestruj się</button>  
                        </div>
                </form> 
        </div>          
        </section>