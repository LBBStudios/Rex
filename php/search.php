<?php
    $query = $_POST["search"];
    header("Location: http://localhost/index.php?p=search&query=".$query);
?>