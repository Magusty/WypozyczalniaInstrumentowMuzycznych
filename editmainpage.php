<?php
session_start();

if ($_SESSION['rankID'] <3)
{
    header("Location: index.php");
}

include ("config/config.php");
include ("config/mainpage.php");

include("include/header.php");
include("include/nav.php");

if ($_SESSION['rankID']==3 && isset($_POST['edit']))
{
      $file=fopen("config/mainpage.php","w");
      $config = "<?php
     \$firstHeader=\"".$_POST['firstHeader']."\";
     \$firstContent=\"".$_POST['firstContent']."\";
     \$secondHeader=\"".$_POST['secondHeader']."\";
     \$secondContent=\"".$_POST['secondContent']."\";
    ?>";
       if (!fwrite($file, $config)) 
       { 
           header("Location: editmainpage.php?error=Nie można zapisać do pliku ($file). Zmien uprawnienia pliku chmod o+w dla mainpage.php w folderze config"); 
       } 
       else
       {      
       fclose($file);     
       header("Location: index.php?success=Wprowadzono zmiany");       
        }
}

?>

<header class="py-5">
         <div class="container px-lg-5">
            <form method = "POST" action ="editmainpage.php">
            <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                        <div class="m-4 m-lg-5">
                        <input type="text" name="firstHeader" value = "<?php echo $firstHeader ?>" >
                        <textarea class="form-control" type="text" name="firstContent" style="height: 10rem;" required ><?php echo $firstContent ?></textarea>
                        </div>
                    </div>
            </div>
        </div>
</header>
        <!-- Page Content-->
        <section class="pt-5 py-5">
        <div class="container px-lg-5 pb-4">
                    <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                        <div class="m-4 m-lg-5">
                        <input type="text" name="secondHeader" value = "<?php echo $secondHeader ?>" >
                        <textarea class="form-control" type="text" name="secondContent" style="height: 10rem;" required > <?php echo $secondContent ?> </textarea>
                        </div>
                    </div>               
                    <?php if ($_SESSION['rankID']==3)
                {
                    echo "<button class=\"btn btn-primary btn-lg\" type=\"submit\" name=\"edit\"> Zastosuj zmiany </button>";
                } ?>
        </div> 
        </form>
                <!-- Page Features-->
                <div class="container px-lg-5">
                    <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                        <div class="m-4 m-lg-5">
                        <h1 class="display-5 fw-bold">Lokalizacja naszych wypożyczalni</h1>
                        <?php
                        $query = "SELECT * FROM " . $prefix . "shops Order by miasto";
                        $wynik = mysqli_query($link, $query) or die ("Something went wrong");
                        while ($row = mysqli_fetch_assoc($wynik)) {
                            if ($row['ID_useractive'] == 1) {
                                $miasto = $row['miasto'];
                                $adres = $row['adres'];                     
                                echo "<p class=\"text-start h3 p-1\"> <b>$miasto</b> - $adres</p>";
                            }
                        }
                        ?>                     
                    </div>
                </div>  
                </div>                
        </section>

<?php

include("include/footer.php");
?>