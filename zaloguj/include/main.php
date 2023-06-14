 <!-- Header-->
 <?php 
 if (isset($_GET['error'])) //error wystepuje kiedy login lub haslo sa zle wprowadzone
 {
        echo "<div class=\"bg-danger text-center p-3 h4 \">
        <p>".$_GET['error']." </p> </div>";
 } 
 ?>
 <header class="py-5">
        <div class="container px-lg-5">
            <div class="text-center">
                    <h1 class="display-5 fw-bold">Logowanie</h1>
            </div>
        </div>
</header>
        <!-- Page Content-->
        <section class="pt-5 py-5">
                <!-- Page Features-->
                <div class="container px-prc">
                    <div class="p-lg-5 bg-light rounded-3 text-right">
                            <form class="form-horizontal px-prc"  method="POST" action="../login.php">
                                <p>Login</p>
                                <p> <input type="text" name="login_login" required > </p>
                                <p>Hasło</p>
                                <p> <input type="password" name="password_login" required > </p>
                                <button class="btn btn-secondary btn-lg">Zaloguj</button>                                     
                                <a class="btn btn-primary btn-lg" href="../index.php">Powrót</a>
                                <p> Nie masz konta? <a href="../rejestracja/index.php"> Załóż je! </a> </p>
                            </form> 
                    </div>  
                </div>               
        </section>