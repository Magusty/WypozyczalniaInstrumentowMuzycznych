<body>
     <!-- Responsive navbar-->
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
         <div class="container px-lg-5">
             <a class="navbar-brand"><?php echo $companyName; ?></a>
             <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
             <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                     <li class="nav-item"><a class="nav-link" aria-current="page" href="../index.php">Strona główna</a></li>
                     <li class="nav-item"><a class="nav-link" href="../oferta/index.php">Oferta</a></li>  
                     <li class="nav-item"><a class="nav-link" href="../kontakt/index.php">Kontakt</a></li>           
                                        
                   <?php 
                     if(!isset($_GET['info']) && ($_SESSION['rankID']==1))
                     {
                        echo "<li class=\"nav-item dropdown\"> 
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        ".$_SESSION['login']."
                      </a>   
                   <ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">
                   <li><a class=\"dropdown-item\" href=\"../profil/index.php\">Mój profil</a></li>
                   <li><a class=\"dropdown-item\" href=\"../zgloszenia/index.php\">Moje zgłoszenia</a></li>
                     <li><a class=\"dropdown-item\" href=\"../wypozyczenia/index.php\">Moje wypożyczenia</a></li>                  
                     <li><a class=\"dropdown-item\" href=\"../logout.php\">Wyloguj</a></li>
                   </ul> </li>";
                    } 
                    else if(!isset($_GET['info']) && ($_SESSION['rankID']==2))
                    {
                        echo "<li class=\"nav-item dropdown\"> 
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        ".$_SESSION['login']."
                      </a>   
                   <ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">
                   <li><a class=\"dropdown-item\" href=\"../profil/index.php\">Profil</a></li>
                   <li><a class=\"dropdown-item\" href=\"../zgloszenia/index.php\">Zgłoszenia</a></li>
                     <li><a class=\"dropdown-item\" href=\"../wypozyczenia/index.php\">Wypożyczenia</a></li>  
                     <li><a class=\"dropdown-item\" href=\"../list/index.php\">Lista klientów</a></li>                
                     <li><a class=\"dropdown-item\" href=\"../logout.php\">Wyloguj</a></li>
                   </ul> </li>";
                    }
                    else if(!isset($_GET['info']) && ($_SESSION['rankID']==3))
                    {
                        echo "<li class=\"nav-item dropdown\"> 
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownMenuLink\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                        ".$_SESSION['login']."
                      </a>   
                   <ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdownMenuLink\">
                   <li><a class=\"dropdown-item\" href=\"../profil/index.php\">Profil</a></li>
                   <li><a class=\"dropdown-item\" href=\"../zgloszenia/index.php\">Lista zgłoszeń</a></li>
                     <li><a class=\"dropdown-item\" href=\"../wypozyczenia/index.php\">Lista wypożyczeń</a></li>  
                     <li><a class=\"dropdown-item\" href=\"../list/index.php\">Lista użytkowników</a></li> 
                     <li><a class=\"dropdown-item\" href=\"../list/shop.php\">Lista wypożyczalni</a></li> 
                     <li><a class=\"dropdown-item\" href=\"../list/payments.php\">Lista płatności</a></li> 
                     <li><a class=\"dropdown-item\" href=\"../list/instruments.php\">Lista instrumentów</a></li> 
                     <li><a class=\"dropdown-item\" href=\"../logout.php\">Wyloguj</a></li>
                   </ul> </li>";
                    }
                    else
                    {
                        echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"../zaloguj/index.php\">Zaloguj</a></li> ";
                    }

                    ?>           
                </ul>
             </div>
         </div>
     </nav>
