<?php 
session_destroy();

header("Location: index.php?status=Pomyślnie wylogowano");
?>