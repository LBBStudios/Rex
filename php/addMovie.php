<?php
    //Our helper function:
    function resize_image($file, $w, $h, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }
        $src = imagecreatefromjpeg($file);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
        return $dst;
    }

    //Make sure we actually have form input:
    $title;
    $year = "";

    if (isset($_POST["tfTitle"])) {
        $title = $_POST["tfTitle"];
        if (isset($_POST["tfYear"])) $year = $_POST["tfYear"];
    } else { 
        header("Location: /index.php?p=addMovie&e=Invalid form!");
        exit;
    }

    //Setup OMDb & MySQL:
    include("../omdb.php");
    include("../mysql.php");

    //Sanitize URL:
    $title = str_replace(" ", "%20", $title);

    //Build a query for OMDb
    $request = "http://www.omdbapi.com/?apikey=".$omdbKey."&type=movie&t=".$title;
    if ($year != "") $request = $request."&y=".$year;
    //echo $request;

    //Get their response & decode the json
    $response  = file_get_contents($request);
    $jsonobj  = json_decode($response, TRUE);

    //Prepping data:
    $oTitle = ($jsonobj["Title"]);
    $oPlot = ($jsonobj["Plot"]);

    $oPlot = str_replace("'", "\\'", $oPlot);
    $oPlot = str_replace('\"', '\\"', $oPlot);

    $oYear = (int)$jsonobj["Year"];
    $oRated = ($jsonobj["Rated"]);
    $oImdb = ($jsonobj["imdbID"]);

    if ($oTitle == "") {
        header("Location: /index.php?p=addMovie&e=Couldn't find that movie, try again.");
        exit;
    }

    //Insert into MySQL:
    $sql = "insert into movies (name, description, year, rating, imdb) values ('".$oTitle."', '".$oPlot."', ".$oYear.", '".$oRated."', '".$oImdb."')";
    //echo $sql;

    $stmt = $db->prepare($sql);
    $stmt->execute();

    //Get from MySQL:
    $getID = $db->prepare("select id from movies order by id desc limit 1;");
    $getID->execute();
    $data = $getID->fetchObject();

    //Save the poster:
    if ($jsonobj["Poster"] != "N/A") {
        $url = "../medialib/posters/movies/".$data->id.".jpg";

        //For some reason, after doing file_put_contents, the php script doesn't let me send headers anymore.
        //So I do it here, the php script will run till end anyway.
        header("Location: /index.php?p=editMovie&id=".$data->id);

        file_put_contents($url, file_get_contents($jsonobj["Poster"]));

        //Resize to be sure:
        $img = resize_image($url, 300, 450, true);
        file_put_contents($url, $img);
    }

    //We're done, send us back to the manage page:
    header("Location: /index.php?p=editMovie&id=".$data->id);
?>