<?php
include("../mysql.php");

$target_file = $_POST['link'];

//Deduce the MIME type
$type = "video/mp4";
$extension = substr ($target_file, -4);
if ($extension == ".webm") {
    $type = "video/webm";
} else if ($extension == ".srt" || $extension == ".vtt") {
    $type = "captions";
}

//Insert into files
$sql = "insert into files(path, type, dispname) values ('".$target_file."', '".$type."', '".$_POST["description"]."')";
$statement = $db->prepare($sql);
$statement->execute();

//Get file ID:
$stmtID = $db->prepare("select id from files where path = '".$target_file."' order by added desc");
$stmtID->execute();
$dataID = $stmtID->fetchObject();
$fileID = $dataID->id;

//Insert into filelink
$srcID = 0;
$srcType = 0;

if (!isset($_POST["movieID"])) {
    $srcID = $_POST["showID"];
    $srcType = 1;
} else {
    $srcID = $_POST["movieID"];
}

$sqlFL = "insert into filelink(fileID, srcID, srcType) values (".$fileID.", ".$srcID.", ".$srcType.")";
$stmtFL = $db->prepare($sqlFL);
$stmtFL->execute();
echo $sqlFL;

//Redirect to management page of this movie
header("Location: /index.php?p=editMovie&id=".$srcID);

?>