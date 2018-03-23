<nav>
    <ul>
        <?php
        //--------------------Home Page--------------------//
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="index.php">Home</a></li>';
        }
        //--------------------Explore Page--------------------//
        if ($path_parts['filename'] == "explore") {
            print '<li class="activePage">Explore</li>';
        } else {
            print '<li><a href="explore.php">Explore</a></li>';
        }
        //--------------------Picture Page--------------------//
        if ($path_parts['filename'] == "pictures") {
            print '<li class="activePage">Pictures</li>';
        } else {
            print '<li><a href="pictures.php">Pictures</a></li>';
        }
        //--------------------Fun Facts--------------------//
        if ($path_parts['filename'] == "facts") {
            print '<li class="activePage">Fun Facts</li>';
        } else {
            print '<li><a href="facts.php">Fun Facts</a></li>';
        }
        //--------------------Learn More--------------------//
        if ($path_parts['filename'] == "learn") {
            print '<li class="activePage">Learn More</li>';
        } else {
            print '<li><a href="learn.php">Learn More</a></li>';
        }
        //--------------------Form Page--------------------//
        if ($path_parts['filename'] == "form") {
            print '<li class="activePage">Sign Up</li>';
        } else {
            print '<li><a href="form.php">Sign Up</a></li>';
        }
        ?>
    </ul>
</nav>