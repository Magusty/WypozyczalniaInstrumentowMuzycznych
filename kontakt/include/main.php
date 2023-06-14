 <!-- Header-->
 <div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Kontakt</h1>
                </div>
        </div>
      <?php  
      if (isset($_GET['success']))
        {
        echo "<div class=\"bg-success text-center p-3 \">
        <p class=\"h4\">".$_GET['success']."</p></div>";
        }
      if (isset($_GET['error']))
        {
        echo "<div class=\"bg-danger text-center p-3 \">
        <p class=\"h4\">".$_GET['error']."</p></div>";
        } 

?>
        <!-- Page Content-->
        <section class="pt-5 py-5">
                <!-- Page Features-->
                <div class="container px-lg-5 pb-4">
                    <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                        <div class="m-4 m-lg-5">
                        <p class="text-start"> <i class="bi bi-building"></i> <?php echo $companyName; ?> </p> 
                        <p class="text-start"> <i class="bi bi-house-fill"></i> <?php echo $adres; ?> </p>                   
                        <p class="text-start"> <i class="bi bi-envelope"></i> <?php echo $email; ?> </p>
                        <p class="text-start"> <i class="bi bi-telephone-fill"></i> <?php echo $telefon; ?> </p>
                       <?php
                       if ($_SESSION['rankID']==3)
                       {
                        echo "<a class=\"btn btn-primary\" href = \"editcontact.php\"> Edytuj informacje </a>";
                    } ?>
                    </div>
                </div> 
        </div>                
        </section>