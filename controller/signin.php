<div id="signin" style="color: white;" class="center-align">
    <br>
    <img src="./img/logo.png" width="400">
    <p><b>You need to be signed in to access Rex.</b></p>

    <?php
        if (isset($_GET["loginError"])) {
            echo "<p class='yellow darken-4'><b>".$_GET["loginError"]."</b></p>";
        }
    ?>

    <form name="frmLogin" method="post" action="/php/login.php" style="margin-left: 12vw; margin-right: 12vw;">
        <div class="input-field col s6">
          <i class="material-icons prefix">account_circle</i>
          <input id="icon_prefix" required="required" name="tfUsername" type="text" class="validate" style="color: white;">
          <label for="icon_prefix">Username</label>
        </div>

        <div class="input-field col s6">
          <i class="material-icons prefix">lock</i>
          <input type="password" required="required" id="icon_prefix" name="tfPassword" type="text" class="validate" style="color: white;">
          <label for="icon_prefix">Password</label>
        </div>

        <button class="btn waves-effect waves-light" type="submit" name="action">Log in
            <i class="material-icons right">send</i>
        </button>
    </form>
</div>