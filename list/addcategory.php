<?php
session_start();
include("../config/config.php");
include("include/header.php");
include("include/nav.php");

?>
<div class="p-4 p-lg-5 bg-secondary text-center">
                <div class="m-4 m-lg-2">
                    <h1 class="display-5 fw-bold">Dodawanie nowej kategorii</h1>
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
    
<?php 
    if ($_SESSION['rankID']==3)
    {
   echo "<form class=\"form-horizontal\" method=\"POST\" action=\"addcategory.php\">
    <div class=\"container px-lg-5\">
        <div class=\"p-4 p-lg-5 rounded-3 text-left\">
        <label class=\"h3\" for=\"nazwa_instrumentu\"> Nazwa </label>
            <br>
            <input type=\"text\" name=\"nazwa_instrumentu\" id=\"nazwa_instrumentu\" required> 
            <br>
            <label class=h3 for=\"zdjecie\"> Wybierz obraz </label>
            <br>
            <input type=\"file\" name=\"zdjecie\" id=\"zdjecie\" accept=\".jpg, .jpeg, .png\" class=\"btn btn-primary\">       
            <div class=\"container py-3 d-grid\">                  
            <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"addcategory_add\">Dodaj nową kategorię</button>
        </div></div>
    </div> </div>
    </div>
</form>"; 
}


if(isset($_POST['addcategory_add']) && $_SESSION['rankID']==3)
{

    $imagePath = $_FILES['zdjecie']['tmp_name'];
    $instrument = $_POST['nazwa_instrumentu'];
    
    $imageContent = file_get_contents($imagePath);
    
    include("../config/config.php");

    if (empty($imageContent) ) //obraz moze zostac dodany pozniej
    {
      $query = "insert into ".$prefix."category (category_name) values (?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "s", $instrument);

    }
    else
    {
    $query = "insert into ".$prefix."category (category_name, category_img) values (? , ?)";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "sb", $instrument, $imageContent);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: addcategory.php?success=Dodano nową kategorię");
    } else {
        header("Location: addcategory.php?error=Coś poszło nie tak");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
else if ($_SESSION['rankID']<3 || !isset($_SESSION['userID']))
{
    echo "<div class=\"text-center\">";
    echo "<p class=\"font-weight-bold h4\"> Odmowa dostępu </p>";
    echo "<div class=\"p-2 bd-highlight\"> ";
    echo "<a class=\"btn btn-primary\" href=\"../index.php\">Powrót do strony głównej</a></div> </div>";
}

?>

</div> 

<?php
include("include/footer.php");

?>