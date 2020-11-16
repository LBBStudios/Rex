<?php
include("../mysql.php");

function drawMovie($row) {
    echo 
    '
    <div class="col s6 m2" style="margin-right: 3vw;">
        <div class="card hoverable" style="width: 13vw;">
            <div class="card-image">
                <img class="activator" src="/medialib/posters/movies/'.$row["id"].'.jpg">
                <a href="/index.php?p=player&id='.$row["id"].'&type=movie" class="btn-floating halfway-fab waves-effect waves-light green darken-4">
                    <i class="material-icons">play_arrow</i>
                </a>
            </div>
            <div class="card-content blue-grey darken-4 activator">
                <p class="truncate">'.$row["name"].'</p>
                <p><a class="activator" style="font-size: 12px">Click for more info</a></p>
            </div>
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                <span class="card-title grey-text text-darken-4"><h5><b>'.$row["name"].'</b></h5></span>
                <p style="color: black;">
                '.$row["year"].'
                </p>
                <p style="color: black;">
                '.$row["description"].'
                </p>
            </div>
        </div>
    </div>
    ';
}
?>

<div class="center-align container" style="padding-top: 12px">
    <div class="card-panel blue-grey darken-2 left-align" style="margin-bottom: 1vh">
        <div class="col s12 m7">
        <center>

            <h3>Search for a movie or show</h3>

            <div class="row" style="color: white; !important">
                <form id="search" action="/php/search.php" method="post" enctype="multipart/form-data">
                    <input style="color: white;" type="text" name="search" required="required" placeholder="ie: Back To The Future" id="search"><br><br>

                    <button class="btn waves-effect waves-light" type="submit" name="action">Search
                        <i class="material-icons right">search</i>
                    </button>
                </form>
            </div>

        </center>
        </div>

        <div id="results">
            <?php
                //TODO: add show searching when that's added:
                if (isset($_GET["query"])) {
                    $query = $_GET["query"];
                    echo "<h4>Results for: '".$_GET["query"]."'</h4>";
                    $conn = mysqli_connect($dbHost, $dbUser, $dbPwd,$dbName);

                    $sql = "select * from rex.movies where name like '%".$query."%' or description like '%".$query."%'";
                    $resultMovies = mysqli_query($conn, $sql);
                    //echo $sql;

                    if (mysqli_num_rows($resultMovies) > 0) {
                        echo "Found: ".mysqli_num_rows($resultMovies)." results.";
                        echo '<div id="movies">
                            <div class="row">';

                        while ($row = mysqli_fetch_assoc($resultMovies)) {
                           drawMovie($row);
                        }

                        echo '</div></div>';
                    } else {
                        echo "No results found. Try a different search term.";
                    }
                }
            ?>
        </div>
    </div>
</div>