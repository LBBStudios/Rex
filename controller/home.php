<?php
    //Get our list of movies from MySQL:
    include("../mysql.php");
    $conn = mysqli_connect($dbHost, $dbUser, $dbPwd,$dbName);

    $resultMovies = mysqli_query($conn, "select * from movies order by name, year");

    //Functions:
    function drawMovie($row) {
        echo 
        '
        <div class="col s6 m2">
            <div class="card hoverable">
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

<!--div id="highlighted" style="margin: 2vw;">
    <h5>New Releases</h5>

    <div class="carousel carousel-slider center">

    <div class="carousel-item red white-text" href="#one!" style="background-image: url('./img/background.jpg'); background-size: cover; background-position: center;">
        
      <h2>Ratatouile</h2>
      <p class="white-text">rat chef rat chef rat chef rat chef rat chef rat chef rat chef rat chef rat chef </p>
      <a class="btn waves-effect white grey-text darken-text-2">Watch now</a>
    </div>
    <div class="carousel-item amber white-text" href="#two!" style="background-image: url('/medialib/posters/movies/1.jpg'); filter: blur(12px); background-size: cover; background-position: center;">
      <h2>Second Panel</h2>
      <p class="white-text">This is your second panel</p>
    </div>
    <div class="carousel-item green white-text" href="#three!">
      <h2>Third Panel</h2>
      <p class="white-text">This is your third panel</p>
    </div>
    <div class="carousel-item blue white-text" href="#four!">
      <h2>Fourth Panel</h2>
      <p class="white-text">This is your fourth panel</p>
    </div>
  </div>
</div-->

<script>
$('.carousel.carousel-slider').carousel({
    fullWidth: true,
    indicators: true
  });

  setTimeout(autoplay, 6000);

function autoplay() {
    $('.carousel').carousel('next');
    setTimeout(autoplay, 6000);
}
</script>

<div id="continueWatching" style="margin: 2vw;">
    <h5>Continue Watching</h5>
</div>

<div id="shows" style="margin: 2vw;">
    <h5>Shows</h5>

    <div class="row">

        <div class="col s6 m2">
            <div class="card hoverable">
                <div class="card-image">
                    <img src="./img/poster.jpg">
                    <a class="btn-floating halfway-fab waves-effect waves-light green darken-4"><i class="material-icons">play_arrow</i></a>
                </div>
                <div class="card-content blue-grey darken-4">
                    <p>Over The Garden Wall</p>
                </div>
            </div>
        </div>
        
    </div>

</div>

<div id="movies" style="margin: 2vw;">
    <h5>Movies</h5>

    <div class="row">
        <?php
            if (mysqli_num_rows($resultMovies) > 0) {
                while ($row = mysqli_fetch_assoc($resultMovies)) {
                   drawMovie($row);
                }
            }
        ?>
        
    </div>
</div>