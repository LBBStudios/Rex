<?php
    //Get our list of movies from MySQL:
    include("../mysql.php");
    $conn = mysqli_connect($dbHost, $dbUser, $dbPwd,$dbName);

    $qry = "select * from movies order by name, year";
    $result = mysqli_query($conn, $qry);

    //Functions:
    function drawMovie($row) {
        echo 
        '
        <div class="col s6 m2">
            <div class="card hoverable">
                <div class="card-image">
                    <img src="/medialib/posters/movies/'.$row["id"].'.jpg">
                    <a href="/index.php?p=editMovie&id='.$row["id"].'" class="btn-floating halfway-fab waves-effect waves-light green darken-4">
                        <i class="material-icons">create</i>
                    </a>
                </div>
                <div class="card-content blue-grey darken-4">
                    <p class="truncate">'.$row["name"].'</p>
                </div>
            </div>
        </div>
        ';
    }
?>

<div id="container" style="margin: 2vw;">
    <div id="title">
        <h4>Manage Movies:</h4>
    </div>

    <div class="row">

        <!-- First one is a fake, a blank to "add" new movies: -->
        <div class="col s6 m2">
            <div class="card hoverable">
                <div class="card-image">
                    <img src="./img/posterBlank.jpg">
                    <a href="/index.php?p=addMovie" class="btn-floating halfway-fab waves-effect waves-light green darken-4">
                        <i class="material-icons">add</i>
                    </a>
                </div>
                <div class="card-content blue-grey darken-4">
                    <p>Add a new movie</p>
                </div>
            </div>
        </div>

        <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                   //echo "Name: " . $row["name"]. "<br>";
                   drawMovie($row);
                }
            }
        ?>
        
    </div>

</div>