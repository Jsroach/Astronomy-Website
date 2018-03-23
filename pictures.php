<?php include "top.php";?>
 <article id='Main'>
            <h1 class='page'>Get a feel for how truly amazing the universe can be</h1>
        <?php
// Sample code to open a plain text file

$debug = false;

if(isset($_GET["debug"])){
    $debug = true;
}

$myFileName="pictures";

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
print "<ol class=pictures>";
foreach ($records as $oneRecord) {
    if ($oneRecord[0] != "") {  //the eof would be a "" 
        print "\n<li class=pictures>";
        //print out values
        print '<a href="displaySpace.php?pid='. $oneRecord[0] . '" target="_self"' . ' class="pictures">';
        print '<img class="pictures" src="images/' . $oneRecord[4] . '" alt ="' . $oneRecord[1] . '">';
        print '</a>';
        print '<h2 class="pictures">' . $oneRecord[1] . '</h2>';
print "\n</li>";
    }
}

print "</ol>";

if ($debug)
    print "<p>End of processing.</p>\n";
?>
 </article>
<aside></aside>
<?php include ("footer.php"); ?>
</body>
</html>