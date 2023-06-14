<?php
session_start();

if ($_SESSION['rankID'] <3)
{
    header("Location: index.php");
}

if (isset($_POST['confirm_edit']) && $_SESSION['rankID']==3)
{
    $file=fopen("../config/companyinfo.php","w");
    $config = "<?php
   \$companyName=\"".$_POST['companyName']."\";
   \$adres=\"".$_POST['adres']."\";
   \$email=\"".$_POST['email']."\";
   \$telefon=\"".$_POST['telefon']."\";
  ?>";
     if (!fwrite($file, $config)) 
     { 
         header("Location: editcontact.php?error=Nie można zapisać do pliku ($file). Zmien uprawnienia pliku chmod o+w dla companyinfo.php w folderze config"); 
     } 
     else
     {      
     fclose($file);     
     header("Location: index.php?success=Wprowadzono zmiany");       
      }
}

include("../config/config.php"); 
include("../config/companyinfo.php");
include("include/header.php");
include("include/nav.php");
?>
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
                    <form method = "POST" action = "editcontact.php">
                       <div class="m-4 m-lg-5">
                       <p class="text-start"> <i class="bi bi-building"></i> <input type="text" name="companyName" required value = "<?php echo $companyName; ?>" > </p> 
                       <p class="text-start"> <i class="bi bi-house-fill"></i><input type="text" name="adres" required value = "<?php echo $adres; ?>" > </p>                   
                       <p class="text-start"> <i class="bi bi-envelope"></i> <input type="email" name="email" required value = "<?php echo $email; ?>" > </p>
                       <p class="text-start"> <i class="bi bi-telephone-fill"></i> <input type="tel" name="telefon" value= "<?php echo $telefon; ?>" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" required> </p>
                       <p class="text-start">(format: XXX-XXX-XXX) </p>                                           
                       <button class="btn btn-primary" name ="confirm_edit" type="submit"> Zatwiedź </a>
                   </form>
                   </div>
               </div> 
       </div>                
       </section>

<?php
include("include/footer.php");

?>