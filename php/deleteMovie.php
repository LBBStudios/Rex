<?php
if (!isset($_GET["id"])) {
    header("Location: /index.php?p=manageMovies");
    exit;
}

include("../mysql.php");

$stmt = $db->prepare("delete from rex.movies where id=".$_GET['id']);
$stmt->execute();

$stmt2 = $db->prepare("delete from rex.filelink where srcID=".$_GET["id"]);
$stmt2->execute();

//We're done, go back to manage movies:
header("Location: /index.php?p=manageMovies");
?>