<?php
    include("mysql.php");

    //Includes our header etc
    include_once "page.php";
    
    if (isset($_GET["p"])) {
        $whichPage = $_GET["p"];

        if ($_GET["p"] != "video") { //Include our navigation if we're not on the video page
            include_once "view/navigation.php";
        }

        include_once "controller/$whichPage.php";
    } else {
        if (isset($_SESSION["userID"])) {
            header("Location: /index.php?p=home");
        } else {
            include_once "controller/signin.php";
        }
    }
?>

</body>
</html>