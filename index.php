<?php
session_start();

if(isset($_GET['status']))
{
    session_destroy();
}


if (file_exists("installer.php"))
{
require("installer.php"); //po instalacji plik powinien zostac usuniety lub zmienic jego nazwe
}
else 
{ 
include("config/config.php"); 
include("config/mainpage.php");
include("config/companyinfo.php");

include("include/header.php");
include("include/nav.php");
include("include/main.php");
include("include/footer.php");
    
}


?>