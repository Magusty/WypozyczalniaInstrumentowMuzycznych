<?php
session_start();
include("../config/config.php");
include("include/header.php");
include("include/nav.php");

?>
 <div class="p-4 p-lg-5 bg-secondary text-center">
         <div class="m-4 m-lg-2">
             <h1 class="display-5 fw-bold">Dodawanie nowej lokacji</h1>
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

?>
    <div class="py-4">  
    <div class="container px-lg-5">
    
    <form class="form-horizontal" method="POST" action="addshop.php">
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 text-center">
        <label class="h3" for="miasto"> Miasto</label>
        <br>
        <input type="text" name="miasto" id="adres" required>
        <br>
            <label class="h3" for="adres"> Adres </label>
        <br>
            <input type="text" name="adres" id="adres" required>
        <div class="container py-3 d-grid">
            <button class="btn btn-secondary btn-lg" id="submitButton" type="submit" name="addlocation_add">Dodaj nową lokację</button>
            </div>
            <div class="container py-1 d-grid">
                <?php
                if (isset($_GET['mainpage']))
                {
            echo "<a class=\"btn btn-primary btn-lg\" href=\"../index.php\">Powrót do strony głównej</a>";
                }
                else
                {
                    echo "<a class=\"btn btn-primary btn-lg\" href=\"shop.php\">Powrót do listy</a>";
                }
            ?>
        </div>
    </div>
    </div> </div>
    </div>
</form> </section>

<?php
if(isset($_POST['addlocation_add']) && $_SESSION['rankID']==3)
{
    $miasto = $_POST['miasto'];
    $adres = $_POST['adres'];  
    
        $query = "Insert into ".$prefix."shops (miasto, adres, ID_useractive) values ('".$miasto."','".$adres."', 1)";
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    
        header("Location: addshop.php?success=Pomyślnie dodano nową lokalizację");   
}

if(isset($_GET['deactivate']) && $_SESSION['rankID']==3)
{
    $deactivateID = $_GET['deactivate'];
    
        $query = "Update ".$prefix."shops set ID_useractive = 2 where ID_shop=".$deactivateID;
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    
        header("Location: shop.php?success=Pomyślnie zdezaktywowano lokalizację");   
}

if(isset($_GET['activate']) && $_SESSION['rankID']==3)
{
    $activateID = $_GET['activate'];
    
        $query = "Update ".$prefix."shops set ID_useractive = 1 where ID_shop=".$activateID;
        $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    
        header("Location: shop.php?success=Pomyślnie aktywowano lokalizację");   
}

else if ($_SESSION['rankID']!=3)
{
    header("Location: shop.php?error=Odmowa wykonania działania"); 
}

?>

</div> 

<?php
include("include/footer.php");

?>