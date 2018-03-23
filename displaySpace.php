<?php include "topBack.php";?>
 <article id='pictures'>
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

// Lines 44-46 are lab7 code    

    while(!feof($file)){
        $records[]=fgetcsv($file);
        if ($records[count($records) - 1][0] == $personId) {
        $record = end($records);
    }
    }
    
    //closes the file
    fclose($file);
    
    if($debug) {
        print "<p>Finished reading data. File closed.</p>\n";
        print "<p>My data array<p><pre> "; print_r($records); print "</pre></p>";
    }
} // ends if file was opened

//----------------lab7 code----------//
print"<p>Get Array <pre>";
print_r($GET);
print"</pre></p>";
$personId=$_GET["pid"];
//----------------lab7 code----------//

print "<ol class='pictures'>";
foreach ($records as $oneRecord) {
    if ($oneRecord[0] == $personId) {  //the eof would be a "" 
        print "\n<li>";
        //print out values
        print '<figure class="pictures">';
        print '<img class="pictures" src="images/' . $oneRecord[4] . '" alt="' . $oneRecord[1] . '">';
        print '</figure>';
        print '<h2 class="picture">' . $oneRecord[1] . '</h2>';
        print '<p class="pictures">' . $oneRecord[2] . '</p>';
        print '<h3 class="pictures">Source: <a href="' . $oneRecord[3] . '" target="_blank">Here</a></h3>';
print "\n</ui>";
    }
}

print "</ol>";

if ($debug)
    print "<p>End of processing.</p>\n";
?>
 </article>
<aside>
    
</aside>
<?php include ("footer.php"); ?>
</body>
</html>