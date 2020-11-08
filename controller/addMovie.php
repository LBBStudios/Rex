<div class="center-align container" style="padding-top: 12px">
    <div class="card-panel blue-grey darken-2 left-align">
        <h5 style="padding-bottom: 12px"><i class="material-icons">mode_edit</i> Add A New Movie:</h5>
        <br>

        <?php
            if (isset($_GET["e"])) {
                echo "<p class='center-align' style='font-size: 24px;color:red;'>".$_GET["e"]."</p>";
            }
        ?>

        <form name="frmAddMovie" method="post" action="/php/addMovie.php" class="center-align" style="margin-left: 12vw; margin-right: 12vw;">
            <div class="input-field col s6">
            <i class="material-icons prefix">camera_roll</i>
            <input id="icon_prefix" required="required" name="tfTitle" type="text" class="validate" style="color: white;">
            <label for="icon_prefix">Movie Title</label>
            </div>

            <div class="input-field col s6">
            <i class="material-icons prefix">date_range</i>
            <input id="icon_prefix" name="tfYear" type="text" class="validate" style="color: white;">
            <label for="icon_prefix">Year (optional, but recommended)</label>
            </div>

            <button class="btn waves-effect waves-light" type="submit" name="action">SEARCH
                <i class="material-icons right">search</i>
            </button>
        </form>
    </div>
</div>