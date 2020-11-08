<?php
    require("../mysql.php");

    if (isset($_SESSION['userID'])) { 
        session_destroy();
    } 

    header('Location: /index.php');
    mysqli_close();
?>