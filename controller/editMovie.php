<?php
    //Make sure we have an ID:
    if (!isset($_GET["id"])) {
        header("Location: /index.php");
        exit;
    }

    //Get info about this movie:
    $id = $_GET["id"];
    $title = "TITLE";
    $desc = "DESCRIPTION";
    $year = "YEAR";
    $rating = "RATING";
    $imdb = "";

    $sql = "select * from rex.movies where id=$id limit 1";
    $statement = $db->prepare($sql);
    $statement->execute();

    $data = $statement->fetchObject();

    $title = $data->name;
    $desc = $data->description;
    $year = $data->year;
    $rating = $data->rating;
    $imdb = $data->imdb;

    $posterURL = "/medialib/posters/movies/".$id.".jpg";

    //Get file links:
    $stmtfl = $db->prepare("select * from rex.filelink where srcID=$id and srcType=0");
    $stmtfl->execute();
?>

<div class="center-align container" style="padding-top: 12px">
    <div class="card-panel blue-grey darken-2 left-align" style="margin-bottom: 1vh">
        <div class="col s12 m7">

            <div class="card horizontal" style="color:black;">
                <div class="card-image">
                    <img class="responsive-img"src="<?php echo $posterURL; ?>">
                </div><br>
                <div class="card-stacked">
                    <div class="card-content">
                        <ul>
                            <li><h5><b>Title:</b> <?php echo $title; ?></h5></li><br>
                            <li><b>Plot:</b> <?php echo $desc; ?></li>
                            <li><b>Release year:</b> <?php echo $year; ?></li>
                            <li><b>Rating:</b> <?php echo $rating; ?></li>
                        </ul>
                    </div>
                    <div class="card-action">
                        <a href="https://imdb.com/title/<?php echo $imdb; ?>">IMDb Page</a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="tabs tabs-fixed-width tab-demo z-depth-1 blue-grey darken-1" style="color: white;">
            <li class="tab"><a class="active" href="#attached" >Attached files</a></li>
            <li class="tab"><a href="#urlSection">Add URL</a></li>
            <li class="tab"><a href="#uploadForm">Upload file</a></li>
            <li class="tab"><a href="#delete">Delete Movie</a></li>
        </ul>

        <div id="attached">
            <br>
            <h5>Attached files:</h5>
            <table class="highlight responsive-table blue-grey darken-1">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Path</th>
                </tr>
                </thead>

                <tbody>
                <?php
                while ($row = $stmtfl->fetch()) {
                    $stmtf = $db->prepare("select path, type, dispname from rex.files where id=".$row[0]);
                    $stmtf->execute();
            
                    while ($frow = $stmtf->fetch()) {
                        echo '<tr><td>';
                        echo $frow[2];
                        echo '</td><td>';
                        echo $frow[1];
                        echo '</td><td>';
                        echo $frow[0];
                        echo '</td></tr>';
                    }
                }
                ?>

                </tbody>
            </table>
            <br>
        </div>
        
        <div id="urlSection">
            <h5>Add a URL to a file:</h5>
            <h7>(Must be publicly accessible)</h7>

            <div class="row" style="color: white;">
                <form id="addURL" class="col s12">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">insert_link</i>
                        <input id="insert_link" style="color: white;" required type="text" class="validate">
                        <label for="insert_link">URL to resource</label>
                    </div>

                    <div class="input-field col s6">
                        <i class="material-icons prefix">mode_comment</i>
                        <input id="mode_comment" style="color: white;" required type="tel" class="validate">
                        <label for="mode_comment">Display name ("720p", "English", etc)</label>
                    </div>

                    <div class="input-field col s6" style="color: white;">
                        <select>
                            <option value="" disabled selected>Choose your option</option>
                            <option value="1">video/mp4</option>
                            <option value="2">captions</option>
                            <option value="3">video/webm</option>
                        </select>
                        <label>MIME Type</label>
                    </div>

                    <center>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Add URL
                        <i class="material-icons right">insert_link</i>
                    </button>
                    </center>
                </div>
                </form>
            </div>
        </div>

        <div id="uploadForm">
            <h5>Upload a new file:</h5>
            <h7>Should be a mp4, webm, or WebVTT file. SRT files need conversion at the moment.</h7><br><br>

            <div class="row" style="color: white;">
                <form id="addFile" action="/php/upload.php" method="post" enctype="multipart/form-data">
                    <center>
                        Select a file to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload" accept="video/mp4, video/webm, text/plain, text/vtt"><br><br>
                        
                        <input type="text" name="description" required="required" placeholder="Display name (720p, English, etc)" id="description"><br><br>
                        
                        <input type="hidden" id="movieID" name="movieID" value="<?php echo $_GET["id"]; ?>">

                        <button class="btn waves-effect waves-light" type="submit" name="action">Add File
                            <i class="material-icons right">cloud_upload</i>
                        </button>
                    </center>
                </form>
            </div>
        </div>

        <div id="delete">
        <br>
        <center>
            <h5>Delete this movie</h5>
            <p>There is no undoing this.</p>

            <a href="/php/deleteMovie.php?id=<?php echo $_GET["id"]; ?>" class="waves-effect waves-light btn-large red darken-4">
                <i class="material-icons left">delete_forever</i>
                Delete Forever
            </a>
        </center>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
  });

  $(document).ready(function(){
    $('.tabs').tabs();
  });
</script>