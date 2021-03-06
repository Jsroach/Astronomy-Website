<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Explore the Universe</title>
        <meta charset="utf-8">
        <meta name="author" content="Jack Roach">
        <meta name="description" content="This is a website dedicated to shining light on the universe and amazing world of astronomy">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keyords" content="jack roach, john roach, jack r, astronomy, astro, cosmology, universe, space, world, star, planet, galaxy, explore, science, learning, education">
        <meta name="category" content="Education">
        <meta name="copyright" content="by John Roach">
        <meta name="contact" content="jsroach@uvm.edu">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="style.css" type="text/css" media="screen">

        <?php
        $debug = false;

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// PATH SETUP
//

        $domain = "//";

        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

        $domain .= $server;

        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

        $path_parts = pathinfo($phpSelf);

        if ($debug) {
            print "<p>Domain: " . $domain;
            print "<p>php Self: " . $phpSelf;
            print "<p>Path Parts<pre>";
            print_r($path_parts);
            print "</pre></p>";
        }

// %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// inlcude all libraries. 
// 
// Common mistake: not have the lib folder with these files.
// Google the difference between require and include
//
        print "<!-- include libraries -->";

        require_once('lib/security.php');

        // notice this if statemtent only includes the functions if it is 
        // form page. A common mistake is to make a form and call the page
        // join.php which means you need to change it below (or delete the if)
        if ($path_parts['filename'] == "form") {
            print "<!-- include form libraries -->";
            include "lib/validation-functions.php";
            include "lib/mail-message.php";
        }

        print "<!-- finished including libraries -->";
        ?>	

    </head>
    <!-- ################ body section ######################### -->

    <?php
    print '<body id="' . $path_parts['filename'] . '">';

    include "header.php";
    include "nav.php";
    ?>