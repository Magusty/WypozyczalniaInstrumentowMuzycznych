<?php
session_start();
include("../config/config.php"); 
include("include/header.php");
include("include/nav.php");

if (isset($_GET['success']))
{
        echo "<div class=\"bg-success text-center p-3 \">
        <p class =\"h4\">".$_GET['success']." </p></div>";
}
if (isset($_GET['error']))
{
        echo "<div class=\"bg-danger text-center p-3\">
        <p class =\"h4\">".$_GET['error']."</p></div>";
}


if (isset($_GET['zgloszenie']) && isset($_SESSION['userID'])) 
{
    echo "<div class=\"p-4 p-lg-5 bg-secondary text-center\">
    <div class=\"m-4 m-lg-2\">";
    echo "<h1 class=\"display-5 fw-bold\"> Zgłoszenie nr ".$_GET['zgloszenie']."</h1> </div></div>";

    $query = "Select *, " . $prefix . "users.user_login, " . $prefix . "users.Imie, " . $prefix . "users.Nazwisko, " . $prefix . "items.model, " . $prefix . "items.brand, " . $prefix . "category.category_name from (((".$prefix."inquiries
    inner join " . $prefix . "items on " . $prefix . "inquiries.ID_item = " . $prefix . "items.ID_item) 
    inner join " . $prefix . "category on " . $prefix . "items.ID_category = " . $prefix . "category.ID_category)
    inner join " . $prefix . "users on " . $prefix . "inquiries.ID_user=" . $prefix . "users.ID_user)
    where ID_inquiry= ".$_GET['zgloszenie'];

    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);

    $status = $row['ID_inquirystatus'];

    echo "<p class=\"p-3 h3 text-center\"> Zapytanie o ".$row['category_name']." | ".$row['brand']." ".$row['model']." </p>";

    if ($_SESSION['rankID']==1)
    {
        $textstyle = "text-end";
        $bgcolor = "bg-info";
        $textstyleAnswer = "text-start";
        $bgcolorAnswer = "bg-light";
    }
    if($_SESSION['rankID']==2 || $_SESSION['rankID']==3)
    {
        $textstyle = "text-start";
        $bgcolor =  "bg-light";
        $textstyleAnswer = "text-end";
        $bgcolorAnswer = "bg-info";
    }
    if($_SESSION['rankID']==3)
    {
        $addictional = $row['user_login']; //admin widzi dodatkowo loginy
    }

    echo "<div class=\"container px-lg-5\">
    <div class=\"p-4 p-lg-5 ".$textstyle."\">
    <p>".$row['Imie']." ".$row['Nazwisko']." ".$addicitonal." o ".$row['Czas']."</p>
    <div class=\"border border-dark ".$bgcolor." p-lg-2 rounded-3\"> <p>".$row['content']."</p> </div>
    </div> </div>";

    $query = "Select *, " . $prefix . "users.Imie, " . $prefix . "users.Nazwisko, " . $prefix . "users.user_login from (".$prefix."answers 
    inner join " . $prefix . "users on " . $prefix . "answers.ID_user=" . $prefix . "users.ID_user)
    where ID_inquiry= ".$_GET['zgloszenie'];
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) == 1) //status=2
    {
        if ($_SESSION['userID']!=$row['ID_user'] && $_SESSION['rankID']==3)
    {       
        $textstyleAnswer="text-start"; 
        $bgcolorAnswer = "bg-light";
    }
    echo "<div class=\"container px-lg-5\">
    <div class=\"p-4 p-lg-5 ".$textstyleAnswer."\">
    <p>".$row['Imie']." ".$row['Nazwisko']." ".$addicitonal." o ".$row['Czas']."</p>
    <div class=\"border border-dark ".$bgcolorAnswer." p-lg-2 rounded-3\"> <p>".$row['content']."</p> </div>
    </div> </div>";

    echo "<p class=\"text-center h4 pb-2\"> Zgłoszenie zostało zamknięte. <br> <a class=\"btn btn-primary \" href=\"index.php\">Powrót do listy zgłoszeń </a> </p>";
    }

    if ($status==1 && ($_SESSION['rankID']==2 || $_SESSION['rankID']==3))
    {
    //dodawanie odpowiedzi  
    echo "<form class=\"form-horizontal\" method=\"POST\" action=\"zgloszenie.php\">
        <div class=\"container px-lg-5\">
            <div class=\"p-4 p-lg-5 rounded-3 text-left\">
                <textarea class=\"form-control\" type=\"text\" name=\"answer_content\" style=\"height: 10rem;\" required ></textarea>     
                <input type=\"hidden\" name=\"requiry_id\" value=".$_GET['zgloszenie'].">
                <div class=\"container py-3 d-grid\">            
                <button class=\"btn btn-secondary btn-lg\" id=\"submitButton\" type=\"submit\" name=\"answer\">Odpowiedz</button>
            </div></div>
        </div>
    </form>";
    }
}


if (isset($_POST['answer']))
{
    //sprawdz czy ktos juz nie udzielil odpowiedzi
    $query = "Select * from ".$prefix."answers where ID_inquiry= ".$_POST['requiry_id'];
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) == 1) //status=2
    {
        header("Location: zgloszenie.php?error=Juz ktos odpowiedzial na zapytanie&zgloszenie=".$_POST['requiry_id']);
    }

    include ("../config/config.php");
    $today = date('Y-m-d H:i:s');

    //dodaj odpowiedz do bazy
    $query = "Insert into ".$prefix."answers (content, ID_user, ID_inquiry, ID_inquirystatus, Czas ) values
    ('".$_POST['answer_content']."',".$_SESSION['userID'].",".$_POST['requiry_id'].",2,'".$today."')";
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

    //aktualizuj status zapytania
    $query = "UPDATE ".$prefix."inquiries set ID_inquirystatus = 2 where ID_inquiry=".$_POST['requiry_id'];
    $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

    header("Location: zgloszenie.php?success=Odpowiedziano na zapytanie&zgloszenie=".$_POST['requiry_id']);

}

include("include/footer.php");

?>