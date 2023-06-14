 <!-- Header-->
 <header class="py-5">
         <div class="container px-lg-5">
         <?php if ($_SESSION['rankID']==3 && !isset($_GET['status']))
                {
                    echo "<a class='btn btn-primary btn-lg' href='editmainpage.php'> Edytuj stronę główną </a>";
                } ?>
            <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                <div class="m-4 m-lg-5">
                    <h1 class="display-5 fw-bold"><?php echo $firstHeader; ?></h1>
                    <p class="fs-4"><?php echo $firstContent; ?></p>
                    <a class="btn btn-primary btn-lg" href="oferta/index.php">Przejdź do oferty</a>
                </div>
            </div>
        </div>
</header>
        <!-- Page Content-->
        <div class="container px-lg-5 pb-4">
                    <div class="p-4 p-lg-5 bg-light rounded-3 text-center">
                        <div class="m-4 m-lg-5">
                        <h1 class="display-5 fw-bold"><?php echo $secondHeader; ?></h1>
                        <p class="fs-4"><?php echo $secondContent; ?></p>
                        </div>
                </div> 
        </div> 
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
                        
                        if ($_SESSION['rankID']==3 && !isset($_GET['info']) && !isset($_GET['status']))
                        {
                        echo "<a class=\"btn btn-primary\" href=\"list/addshop.php?mainpage=1\">Dodaj nową lokalizację</a>";
                        echo "<a class=\"btn btn-primary\" href=\"list/shop.php\">Zobacz listę lokalizacji</a>";
                        }
                        ?>                      
                    </div>
                </div>  
                </div>                
         