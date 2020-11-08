<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //Make sure we have an ID and a TYPE:
    if (!isset($_GET["id"]) || !isset($_GET["type"])) {
        header("Location: /index.php");
        exit;
    }

    //Get information about the thing we're viewing:
    $id = $_GET["id"];
    $title = "TITLE";
    $desc = "DESCRIPTION";
    $year = "YEAR";
    $rating = "RATING";
    $imdb = "";

    $sql = "";
    if ($_GET["type"] == "movie") $sql = "select * from rex.movies where id=$id limit 1";
    else $sql = "select * from rex.shows where id=$id limit 1";

    $statement = $db->prepare($sql);
    $statement->execute();

    $data = $statement->fetchObject();

    $title = $data->name;
    $desc = $data->description;
    $year = $data->year;
    $rating = $data->rating;
    $imdb = $data->imdb;

    $posterURL = "/medialib/posters/";
    if ($_GET["type"] == "movie") $posterURL = $posterURL."movies/".$id.".jpg";
    //else $posterURL = $posterURL."shows/".$id.".jpg";

    //Get associated file links:
    $srcType = 0;
    if ($_GET["type"] != "movie") $srcType = 1;

    $stmtfl = $db->prepare("select * from rex.filelink where srcID=$id and srcType=$srcType");
    $stmtfl->execute();
?>

<link rel="stylesheet" href="/plyr/dist/plyr.css" />

<!-- Override plyr's default styling: -->
<style>
    :root {
        --plyr-color-main: #1d631d;
        --plyr-control-icon-size: 20px;
        --plyr-range-thumb-height: 20px;
        --plyr-range-track-height: 10px;
        --plyr-font-family: "Ubuntu", "Segoe UI","Helvetica Neue",sans-serif;
        --plyr-font-size-menu: 16px;
        --plyr-font-weight-regular: 500;
    }

    body {
        margin: 0;
    }

    @media (max-width: 600px) {
        :root {
            --plyr-color-main: #1d631d;
            --plyr-control-icon-size: 12px;
            --plyr-range-thumb-height: 12px;
            --plyr-range-track-height: 6px;
            --plyr-font-family: "Ubuntu", "Segoe UI","Helvetica Neue",sans-serif;
            --plyr-font-size-menu: 12px;
            --plyr-font-weight-regular: 250;
        }
    }

    /*video::-webkit-media-controls-timeline {
        background-color: red !important;
    }*/

    video::-webkit-media-controls-panel {
        color: black;
    }
</style>

<div class="center-align container" style="padding-top: 12px">
    <div class="card-panel blue-grey darken-2 left-align">

        <!--video class="responsive-video" id="player" playsinline controls data-poster="<?php echo $posterURL; ?>">
            <?php
            /*while ($row = $stmtfl->fetch()) {
                $stmtf = $db->prepare("select path, type, dispname from rex.files where id=".$row[0]);
                $stmtf->execute();
        
                while ($frow = $stmtf->fetch()) {
                    if ($frow[1] == "video/mp4") {
                        echo "<source src=\"";
                        echo $frow[0];
                        echo "\" label=\"";
                        echo $frow[2];
                        echo "\" type=\"";
                        echo $frow[1];
                        echo "\">";
                    }
                    else if ($frow[1] == "captions") {
                        echo '<track kind="captions" label="';
                        echo $frow[2];
                        echo '" src="';
                        echo $frow[0];
                        echo '">';
                    }
                }
            }*/
            ?>
        </video-->

        <center><video class="responsive-video black center-align" controls poster="<?php echo $posterURL; ?>">
        <?php
            while ($row = $stmtfl->fetch()) {
                $stmtf = $db->prepare("select path, type, dispname from rex.files where id=".$row[0]);
                $stmtf->execute();
        
                while ($frow = $stmtf->fetch()) {
                    if ($frow[1] == "video/mp4") {
                        echo "<source src=\"";
                        echo $frow[0];
                        echo "\" label=\"";
                        echo $frow[2];
                        echo "\" type=\"";
                        echo $frow[1];
                        echo "\">";
                    }
                    else if ($frow[1] == "captions") {
                        echo '<track kind="captions" label="';
                        echo $frow[2];
                        echo '" src="';
                        echo $frow[0];
                        echo '">';
                    }
                }
            }
            ?>
        </video></center>

        <?php
            //Title:
            echo "<h3>".$title."</h3>";

            //Info:
            echo "<p>".$year." &bull; ".$rating;
            if ($imdb != "N/A") {
                echo " &bull; <a href='https://imdb.com/title/".$imdb."'>IMDb</a>";
            }
            echo "</p>";

            //Print desc:
            echo "<p>".$desc."</p>";
        ?>

    </div>
</div>

<script src="/plyr/dist/plyr.js"></script>
<script>
        const player = new Plyr('#player');

        // timing object
        //var to = new TIMINGSRC.TimingObject({provider:timingProvider});

        // set up video sync
        //var sync1 = MCorp.mediaSync(document.getElementById('player'), to);
</script>