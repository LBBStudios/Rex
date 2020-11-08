<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../mysql.php");

$target_dir = "../medialib/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.<br>";
  echo $target_file;
  echo "<br>";
  echo $_FILES["fileToUpload"];
  echo basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 0;
  exit;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000000) { //5GB limit
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "mp4" && $imageFileType != "srt" && $imageFileType != "webm" && $imageFileType != "vtt" ) {
  echo "Sorry, only mp4, srt, webm & vtt files are allowed.";
  $uploadOk = 0;
}

//Get our type:
$type = "video/mp4";

if ($imageFileType == "srt" || $imageFileType == "vtt") {
    $type = "captions";
} 
else if ($imageFileType == "webm") {
    $type = "video/webm";
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

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
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>