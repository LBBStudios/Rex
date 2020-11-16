<?php
    include("../mysql.php");

    $fileID = $_GET["id"];
    $srcID = $_GET["srcID"];

    $sql = "delete from rex.filelink where fileID=$fileID and srcID=$srcID limit 1";
    $statement = $db->prepare($sql);
    $statement->execute();

    header("Location: /index.php?p=editMovie&id=".$srcID);
?>