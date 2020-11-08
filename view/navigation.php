<nav class="blue-grey darken-4">
    <div class="nav-wrapper">
        <a href="/index.php?p=home" class="brand-logo"><img src="./img/logo.png" width="200" style="padding-top: 1vh"></a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>

        <ul class="right hide-on-med-and-down">
            <li><a href="sass.html"><i class="material-icons left">search</i>Search</a></li>

            <?php
            //Check in case we're admin
            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
              //echo "<li><a href="/index.php?p=manage"><i class="material-icons left">apps</i>Manage content</a></li>";
              echo "<li><a class='dropdown-trigger' href='#' data-target='dropdown1'><i class='material-icons left'>apps</i>Management</a></li>";

              echo "
                <ul id='dropdown1' class='dropdown-content'>
                    <li><a href='/index.php?p=manageMovies'><i class='material-icons left'>movie</i>Movies</a></li>
                    <li class='divider' tabindex='-1'></li>
                    <li><a href=''><i class='material-icons left'>view_carousel</i>Shows</a></li>
                    <li class='divider' tabindex='-1'></li>
                    <li><a href='#!'><i class='material-icons left'>person</i>Users</a></li>
                    <li class='divider' tabindex='-1'></li>
                </ul>
              ";
            }
            ?>
            
            <li><a href="collapsible.html"><i class="material-icons left">assignment_ind</i>Account</a></li>
            <li><a href="/php/logout.php"><i class="material-icons left">power_settings_new</i>Log out</a></li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    <li><a href="sass.html"><i class="material-icons left">search</i>Search</a></li>

    <?php
      //Check in case we're admin
      if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
        echo "<li><a class='dropdown-trigger2' href='#' data-target='dropdown2'><i class='material-icons left'>apps</i>Management</a></li>";

        echo "
        <ul id='dropdown2' class='dropdown-content'>
          <li><a href='/index.php?p=manageMovies'><i class='material-icons left'>movie</i>Movies</a></li>
          <li class='divider' tabindex='-1'></li>
          <li><a href=''><i class='material-icons left'>view_carousel</i>Shows</a></li>
          <li class='divider' tabindex='-1'></li>
          <li><a href='#!'><i class='material-icons left'>person</i>Users</a></li>
          <li class='divider' tabindex='-1'></li>
        </ul>
      ";
      }
    ?>

    <li><a href="collapsible.html"><i class="material-icons left">assignment_ind</i>Account</a></li>
    <li><a href="/php/logout.php"><i class="material-icons left">power_settings_new</i>Log out</a></li>
</ul>

<script>
  document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems);

        var trig = document.querySelectorAll('.dropdown-trigger');
        var trigs = M.Dropdown.init(trig);

        var trig2 = document.querySelectorAll('.dropdown-trigger2');
        var trigs2 = M.Dropdown.init(trig2);
  });
</script>