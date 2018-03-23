<?php
include ("top.php");
?>
 <article>
            <h1 class="page">Take a look at some of the defining aspects of our universe</h1>
            <p class='intro'>The universe has so many things to explore, research, and experience. Everything from galaxies billions
                 of miles away, or even the large floating ball of white gass we decide to call the Sun are parts of our universe. 
                 There are people who dedicate their entire lives to trying to uncover the endless amount of mysteries and aspects to
                 this seemingly endless spectrum of existence, and it is amazing how small it can make you feel.</p>
        <?php
// Sample code to open a plain text file

$debug = false;

if(isset($_GET["debug"])){
    $debug = true;
}

$myFileName="explore";

$fileExt=".csv";

$filename = $myFileName . $fileExt;

if ($debug) print "\n\n<p>filename is " . $filename;

$file=fopen($filename, "r");

// the variable $file will be empty or false if the file does not open
if($file){
    if($debug) print "<p>File Opened</p>\n";
    if($debug) print "<p>Begin reading data into an array.</p>\n";

    // This reads the first row, which in our case is the column headers
    $headers[]=fgetcsv($file);
    
    if($debug) {
        print "<p>Finished reading headers.</p>\n";
        print "<p>My header array<p><pre> "; print_r($headers); print "</pre></p>";
    }
    // the while (similar to a for loop) loop keeps executing until we reach 
// the end of the file at which point it stops. the resulting variable 
// $records is an array with all our data.

    while(!feof($file)){
        $records[]=fgetcsv($file);
    }
    
    //closes the file
    fclose($file);
    
    if($debug) {
        print "<p>Finished reading data. File closed.</p>\n";
        print "<p>My data array<p><pre> "; print_r($records); print "</pre></p>";
    }
} // ends if file was opened
print '<ol class="explore">';
foreach ($records as $oneRecord) {
    if ($oneRecord[0] != "") {  //the eof would be a "" 
        print "\n<li class=explore>";
        //print out values
        print '<h2 class="explore">' . $oneRecord[1] . '</h2>';
        print '<a href="' . $oneRecord[3] . '" target="_blank" ' . 'class="explore">';
        print '<img class="explore" src="images/' . $oneRecord[4] . '" alt="' . $oneRecord[1] . '">';
        print '</a>';
        print '<p class="explore">' . $oneRecord[2] . '<p>';
print "\n</li>";
    }
}

print "</ol>";

if ($debug)
    print "<p>End of processing.</p>\n";
?>
 </article>
<aside>
    <p>
        
    </p>
</aside>
<?php include ("footer.php"); ?>
</body>
</html>