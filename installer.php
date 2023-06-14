<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Instalator </title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>

<?php
$config_file="config/config.php";

if (isset($_POST['step']) && is_numeric($_POST['step'])) {
  $step = $_POST['step'];
}

// Obsługa poszczególnych kroków

switch ($step) {

  case 1: //1. formularz i wypelniasz wszystko
      form_config();
      break;

  case 2: //2. zapis do pliku z formsa
    include("config/config.php");
    echo "<div style=\"padding-top: 15%; padding-left: 40%\"> <h1>Instalator - krok 2</h1>";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $file=fopen($config_file,"w");
      $config = "<?php
     \$host=\"".$_POST['hostname']."\";
     \$user=\"".$_POST['username']."\";
     \$password=\"".$_POST['password']."\";
     \$dbname=\"".$_POST['database']."\";
     \$prefix=\"".$_POST['prefix']."\";
     \$link = mysqli_connect(\$host, \$user, \$password, \$dbname);\n
     // Check connection
    if (\$link->connect_error) {
        die(\"Connection failed: \" . \$link->connect_error);
    }
    ?>";
       if (!fwrite($file, $config)) { 
           print "Nie można zapisać do pliku ($file). Zmien uprawnienia pliku <code>chmod o+w ".$config_file."</code>"; 
           print "Jeśli to zrobiłeś, kliknij przycisk poniżej";
           echo "<a href=\"installer.php?step=1\">Wróć do formularza</a>";
           exit; 
       } 
       else
       {      
       fclose($file);     
       include("config/config.php");
       $conn = mysqli_connect($host, $user, $password, $dbname);
           if (!$conn) {
             echo "<p> Nie udało się połączyć z bazą danych. </p>";
               $step=2;
               echo "<a href=\"installer.php?step=1\">Wypełnij formularz ponownie</a>";
               exit(); 
           }
           else
           {
            echo "<p>Krok 2 zakończony: \n";
       echo "Plik konfiguracyjny został utworzony pomyślnie</p>"; 
       echo "<form method=\"post\" action=".$_SERVER['PHP_SELF'].">
          <input type=\"hidden\" name=\"step\" value=\"3\">
          <button class='btn btn-info' type=\"submit\" onclick=\"location.href='installer.php?step=3'\"> Dalej</button>
          </form>";
           }  
          }    
      echo "</div>";
        }
      break;

  case 3:   //3. tworzenie tabel w bazie
    include ($config_file); 
    echo "<h1>Instalator - krok 3</h1>";
    echo "Tworzę tabele bazy: ".$dbname.".<br>\n";
    mysqli_select_db($link, $dbname) or die(mysqli_error($link));
    include ("sql/sql.php");
        for($i=0;$i<count($create);$i++)
        {
          echo "<p>".$i.". <code>".$create[$i]."</code></p>\n";
          mysqli_query($link, $create[$i]) or die(mysqli_error($link)) ;
        }
        echo "<form method=\"post\" action=".$_SERVER['PHP_SELF'].">
        <input type=\"hidden\" name=\"step\" value=\"4\">
        <button class='btn btn-info' type=\"submit\" onclick=\"location.href='installer.php?step=4'\"> Dalej</button>
        </form>"; 
      break;

  case 4: //4. wpychanie wartosci do tabel
    echo "<h1>Instalator - krok 4</h1>";
    echo "Uzupełniam tabele w bazie: ".$dbname.".<br>\n";
    include($config_file);
    mysqli_select_db($link, $dbname) or die(mysqli_error($link));
    include ("sql/insert.php");   
    for($i=0;$i<count($insert);$i++)
        {
          echo "<p>".$i.". <code>".$insert[$i]."</code></p>\n";
          mysqli_query($link, $insert[$i]) or die(mysqli_error($link)) ;
        }
        echo "<form method=\"post\" action=".$_SERVER['PHP_SELF'].">
          <input type=\"hidden\" name=\"step\" value=\"5\">
          <button class='btn btn-info' type=\"submit\" onclick=\"location.href='installer.php?step=5'\"> Dalej</button>
          </form>";
    break;

  case 5: //5. rejestracja konta admina
    form_admin();
      break;

    case 6: //6. weryfikacja wprowadzonych danych
      echo "<div style=\"padding-top: 15%; padding-left: 20%\">
      <h1>Instalator - krok 6</h1>";
      if ($_SERVER['REQUEST_METHOD'] === 'POST')
      {
        $Imie = $_POST['imie_reg'];
        $Nazwisko =$_POST['nazwisko_reg'];
        $Ulica =$_POST['ulica_reg'];
        $Nr_bud = $_POST['nrbud_reg'];
        $Nr_mieszk = $_POST['nrmieszk_reg'];
        $miasto =$_POST['miasto_reg'];
        $telefon =$_POST['phone'];
        $username = $_POST['login_reg'];
        if ($_POST['password_reg']==$_POST['password_reg2'])
        {
          $today = date("Y-m-d");
          include($config_file);         
          $hashedPassword = password_hash($_POST['password_reg'], PASSWORD_DEFAULT);  
          if ($Nr_mieszk == "")
          {  
          $query = "INSERT INTO ".$prefix."users (user_login, user_password, ID_rank, Imie, Nazwisko, Ulica, Numer_budynku, Miasto, Telefon, account_created, ID_useractive) 
              VALUES ('".$username."', '".$hashedPassword."', 3, '".$Imie."', '".$Nazwisko."', '".$Ulica."', ".$Nr_bud.", '".$miasto."', '".$telefon."', '".$today."', 1)";
          }
          else
          {
            $query = "INSERT INTO ".$prefix."users (user_login, user_password, ID_rank, Imie, Nazwisko, Ulica, Numer_budynku, Numer_mieszkania, Miasto, Telefon, account_created, ID_useractive) 
            VALUES ('".$username."', '".$hashedPassword."', 3, '".$Imie."', '".$Nazwisko."', '".$Ulica."', ".$Nr_bud.", ".$Nr_mieszk.", '".$miasto."', '".$telefon."', '".$today."', 1)";
          }
          $result = mysqli_query ($link, $query) or die ("Zapytanie zakończone niepowodzeniem");
          if ($result) 
          {
              echo "<p>Dane zostały zapisane w bazie danych.</p><br>
              <form method=\"post\" action=".$_SERVER['PHP_SELF'].">
              <input type=\"hidden\" name=\"step\" value=\"7\">
              <button class='btn btn-info' type=\"submit\" onclick=\"location.href='installer.php?step=7'\"> Dalej</button>
              </form>";
          } 
          else 
          {
              echo "Błąd przy zapisywaniu danych: " . mysqli_error($link) . "<br>";            
          }
          mysqli_close($link);
        }
          else
          {
            echo "<p>Hasła się nie zgadzają </p>";
            echo "<form method=\"post\" action=".$_SERVER['PHP_SELF'].">
        <input type=\"hidden\" name=\"step\" value=\"5\">
        <button class='btn btn-info' type=\"submit\" onclick=\"location.href='installer.php?step=5'\"> Wróć</button>
        </form>";
          } 
          echo "</div>";       
      }
      break;
      case 7: //7. formularz z danymi firmy
       echo "<div style=\"padding-top: 15%; padding-left: 30%\">
       <h2> Informacje o firmie </h2>
       <form method = \"POST\" action =".$_SERVER['PHP_SELF'].">
        <div class=\"m-4 m-lg-5\">
        <p class=\"text-start\">  <i class=\"bi bi-building\"></i> Nazwa firmy <input type=\"text\" name=\"companyName\" required>  </p> 
        <p class=\"text-start\"> <i class=\"bi bi-house-fill\"></i> Adres siedziby, miasto <input type=\"text\" name=\"adres\" required>  </p>                   
        <p class=\"text-start\"> <i class=\"bi bi-envelope\"></i> Adres email <input type=\"email\" name=\"email\" required>  </p>
        <p class=\"text-start\"> <i class=\"bi bi-telephone-fill\"></i> Telefon <input type=\"tel\" name=\"telefon\" pattern=\"[0-9]{3}-[0-9]{3}-[0-9]{3}\" required>  </p>
        <p class=\"text-start\"> (format: XXX-XXX-XXX) </p>       
        <input type=\"hidden\" name=\"step\" value=\"8\">                                    
        <button class=\"btn btn-info\" type=\"submit\" onclick=\"location.href='installer.php?step=8'\"> Zatwiedź </a>
    </form> </div>";
        break;

      case 8: //8. zapis do pliku i koniec
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
        $file=fopen("config/companyinfo.php","w");
        $config = "<?php
       \$companyName=\"".$_POST['companyName']."\";
       \$adres=\"".$_POST['adres']."\";
       \$email=\"".$_POST['email']."\";
       \$telefon=\"".$_POST['telefon']."\";
      ?>";
         if (!fwrite($file, $config)) 
         {  echo "<div style=\"padding-top: 15%; padding-left: 30%\">"; 
            echo "Nie można zapisać do pliku ($file). Zmien uprawnienia pliku chmod o+w dla companyinfo.php w folderze config </div>"; 
            echo "<a class='btn btn-info' href='installer.php?step=7'>Powrót</a> </div>";
         } 
         else
         {      
         fclose($file);  
         echo "<div style=\"padding-top: 15%; padding-left: 30%\">
        <h1>Instalator - koniec</h1>";
        echo "<p>Zainstalowano pomyślnie.</p>";
        echo "<p>Usuń plik installer.php (albo zmień jego nazwę :>) </p>";
        echo "<a class='btn btn-info' href='zaloguj/index.php'>Logowanie</a> </div>";    
         }
        }
        break;

  default: //0. sprawdzanie czy istnieją odpowiednie pliki o odpowiednich nazwach i czy mozna w nich cos zapisac   
  $step=0;
  if(file_exists($config_file)){
    if(is_writable($config_file)){
            form_config();
    } else {
      echo "<div style=\"padding-top: 15%; padding-left: 40%\">
      <h1>Instalator - krok 0</h1>";
        echo "<p>Zmień uprawnienia do pliku <code>".$config_file."</code><br>np. <code>chmod o+w ".$config_file."</code></p>";
        echo "<p><button class='btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p> </div>";
    }
}else{
  echo "<div style=\"padding-top: 15%; padding-left: 40%\">
  <h1>Instalator - krok 0</h1>";
    echo "<p>Stwórz plik <code>".$config_file."</code><br>np. <code>touch ".$config_file."</code></p>";
    echo "<p><button class='btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p> </div>";
}
break;
}

//=============================================== funkcje z formularzami ==================================================

function form_config() 
{
  echo "<div style=\"padding-top: 15%; padding-left: 40%\">
  <h1>Instalator - krok 1</h1>
  <form method=\"post\" action=".$_SERVER['PHP_SELF'].">
          <label>Host bazy danych:</label>
          <input type=\"text\" name=\"hostname\" required><br>
  
          <label>Nazwa bazy danych:</label>
          <input type=\"text\" name=\"database\" required><br>
  
          <label>Użytkownik bazy danych:</label>
          <input type=\"text\" name=\"username\" required><br>
  
          <label>Hasło bazy danych:</label>
          <input type=\"password\" name=\"password\"><br>
          <label>Prefix tabel:</label>
          <input type=\"text\" name=\"prefix\"><br>  
          <input type=\"hidden\" name=\"step\" value=\"2\">
          <button class='btn btn-info' type=\"submit\" onclick=\"location.href='installer.php?step=2'\"> Dalej</button>
      </form> </div>";
}
function form_admin()
{
  echo "<div style=\"padding-top: 6%; padding-left: 25%\">
  <h1>Instalator - krok 5</h1>
  <h1>Konto administratora</h1>
      <div class=\"flex-row d-flex flex-row bd-highlight mb-3\">
      <div class=\"bd-highlight p-lg-5 bg-light rounded-3 text-right\">
        <form class=\"form-horizontal px-4\" method=\"post\" action=".$_SERVER['PHP_SELF'].">
        <p>Login*</p>
        <p> <input type=\"text\" required name=\"login_reg\"> </p>
        <p>Hasło*</p>
        <p> <input type=\"password\" required  name=\"password_reg\"> </p>
        <p>Powtórz hasło*</p>
        <p> <input type=\"password\" required  name=\"password_reg2\"> </p>
        </div>
        <div class=\" bd-highlight p-lg-5 bg-light rounded-3 text-right\">
            <p> Imię* </p>
            <p> <input type=\"text\" required name=\"imie_reg\"> </p>
            <p> Nazwisko* </p>
            <p> <input type=\"text\" required name=\"nazwisko_reg\"> </p>
            <p> Numer telefonu* <br>(format: XXX-XXX-XXX) </p>
            <input type=\"tel\" name=\"phone\" pattern=\"[0-9]{3}-[0-9]{3}-[0-9]{3}\" required>                                                           
        </div>
        <div class=\" bd-highlight p-lg-5 bg-light rounded-3 text-right\">
            <p> Miasto* </p>
            <p> <input type=\"text\" required name=\"miasto_reg\"> </p>  
            <p> Ulica* </p>
            <p> <input type=\"text\" required name=\"ulica_reg\"> </p>
            <p> Numer budynku* </p>
            <p> <input type=\"number\" min=\"1\" required name=\"nrbud_reg\"> </p>
            <p> Numer mieszkania </p> 
            <p> <input type=\"number\" name=\"nrmieszk_reg\" min=\"1\"> </p>
        </div> 
        </div>
            <div class=\"pb-2 px-prc\">  
        <input type=\"hidden\" name=\"step\" value=\"6\">
        <button class='btn btn-info' type=\"submit\" onclick=\"location.href='installer.php?step=6'\"> Dalej</button>
        </div>
        </form>
        </div></div>";
}
?>


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>