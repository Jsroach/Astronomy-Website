<?php
include "top.php";
//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1 Initialize variables
//
// SECTION: 1a.
// variables for the classroom purposes to help find errors.

$debug = false;

// This if statement allows us in the classroom to see what our variables are
// This is NEVER done on a live site 
if (isset($_GET["debug"])) {
    $debug = true;
}

if ($debug) {
    print "<p>DEBUG MODE IS ON</p>";
}

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1b Security
//
// define security variable to be used in SECTION 2a.

$thisURL = $domain . $phpSelf;


//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1c form variables
//
// Initialize variables one for each form element
// in the order they appear on the form
$firstName = "";
$lastName = "";
$email = "youremail@uvm.edu";
$gender="Female";
$planet = true;
$star = false;
$relativity=false;
$explore=false;
$other=false;
$visit="Heterosexual";

//%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1d form error flags
//
// Initialize Error Flags one for each form element we validate
// in the order they appear in section 1c.

$firstNameERROR = false;
$lastNameERROR = false;
$emailERROR = false;
$genderERROR = false;
////%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
//
// SECTION: 1e misc variables
//
// create array to hold error messages filled (if any) in 2d displayed in 3c.

$errorMsg = array(); 
 
// array used to hold form values that will be written to a CSV file
$dataRecord = array();

// have we mailed the information to the user?
$mailed=false;

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//
// SECTION: 2 Process for when the form is submitted
//
if (isset($_POST["btnSubmit"])) {

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2a Security
    // 
    if (!securityCheck($thisURL)) {
        $msg = "<p>Sorry you cannot access this page. ";
        $msg.= "Security breach detected and reported</p>";
        die($msg);
    }

    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2b Sanitize (clean) data 
    // remove any potential JavaScript or html code from users input on the
    // form. Note it is best to follow the same order as declared in section 1c.

    $firstName = htmlentities($_POST["txtFirstName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstName;
    
    $lastName = htmlentities($_POST["txtLastName"],ENT_QUOTES,"UTF-8");
    $dataRecord[]=$lastName;
    
    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);    
    $dataRecord[] = $email;
    
    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $gender; 
    
if (isset($_POST["chkPlanet"])) {
    $planet = true;
} else {
    $planet = false;
}
$dataRecord[] = $planet;

if (isset($_POST["chkStars"])) {
    $star = true;
} else {
    $star = false;
}
$dataRecord[] = $star;

if (isset($_POST["chkRelativity"])) {
    $relativity = true;
} else {
    $relativity = false;
}
$dataRecord[] = $relativity;

if (isset($_POST["chkExplore"])) {
    $explore = true;
} else {
    $explore = false;
}
$dataRecord[] = $explore;

if (isset($_POST["chkOther"])) {
    $other = true;
} else {
    $other = false;
}
$dataRecord[] = $other;

     $visit = htmlentities($_POST["lstVisit"],ENT_QUOTES,"UTF-8");
$dataRecord[] = $visit;
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2c Validation
    //
    // Validation section. Check each value for possible errors, empty or
    // not what we expect. You will need an IF block for each element you will
    // check (see above section 1c and 1d). The if blocks should also be in the
    // order that the elements appear on your form so that the error messages
    // will be in the order they appear. errorMsg will be displayed on the form
    // see section 3b. The error flag ($emailERROR) will be used in section 3c.
    
    if ($firstName == "") {
        $errorMsg[] = "Please enter your first name";
        $firstNameERROR = true;
    } elseif (!verifyAlphaNum($firstName)) {
        $errorMsg[] = "Your first name appears to have extra character.";
        $firstNameERROR = true;
    }
    
    if ($lastName==""){
        $errorMsg[]="Please enter your last name";
        $lastNameERROR = true;
    } elseif(!verifyAlphaNum($lastName)){
        $errorMsg[]="Your last name appears to have extra character.";
        $lastNameERROR = true;
    }   
    
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be invalid.";
        $emailERROR = true;
    }
    
    
    //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    //
    // SECTION: 2d Process Form - Passed Validation
    //
    // Process for when the form passes validation (the errorMsg array is empty)
    //    
    if (!$errorMsg) {
        if ($debug)
            print "<p>Form is valid</p>";
             

        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2e Save Data
        //
        // This block saves the data to a CSV file.
        $fileExt = ".csv";
        $myFileName = "data/registration"; // NOTE YOU MUST MAKE THE FOLDER !!!

        $filename = $myFileName . $fileExt;

        if ($debug){
            print "\n\n<p>filename is " . $filename;
        }
    
        // now we just open the file for append
        $file = fopen($filename, 'a');
    
        // write the forms informations
        fputcsv($file, $dataRecord);
    
        // close the file
        fclose($file);
    
        
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2f Create message
        //
        // build a message to display on the screen in section 3a and to mail
        // to the person filling out the form (section 2g).

        $message = '<h2 class="sumbit">Thank you, your information has been submitted.</h2>';
    
        foreach ($_POST as $key => $value) {
            $message .= "<p class='submit'>";
            
            // breaks up the form names into words. for example
            // txtFirstName becomes First Name
            $camelCase = preg_split('/(?=[A-Z])/', substr($key, 3));
    
            foreach ($camelCase as $one) {
                $message .= $one . " ";
            }

            $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
        }
    
    
        //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        //
        // SECTION: 2g Mail to user
        //
        // Process for mailing a message which contains the forms data
        // the message was built in section 2f.
        $to = $email; // the person who filled out the form
        $cc = "";
        $bcc = "";

        $from = "Data Collection <noreply@DataCollection.com>";
    
        // subject of mail should make sense to your form
        $todaysDate = strftime("%x");   
        $subject = "Your form has been submitted: " . $todaysDate;

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    
    } // end form is valid

}    // ends if form was submitted.


//#############################################################################
//
// SECTION 3 Display Form
//
?>

<article id="main">

    <?php
    //####################################
    //
    // SECTION 3a. 
    // 
    // If its the first time coming to the form or there are errors we are going
    // to display the form.
    if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) { // closing of if marked with: end body submit 
        print "<h1 class='submit'>Your Request has ";
    
        if (!$mailed) {
            print "not ";
        }
    
        print "been processed</h1>";
    
        print "<p class='submit'>A copy of this message has ";
    
        if (!$mailed) {
            print "not ";
        }
        print "been sent</p>";
        print "<p class='submit'>To: " . $email . "</p>";
    
        print "<p class='submit'>Mail Message:</p>";
    
        print '<div class="submit">' . $message . '</div>' ;
    } else {
    
     
        //####################################
        //
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form
   
    if ($errorMsg) {
        print '<div id="errors">' . "\n";
        print "<h2 class='submit'>Your form has the following mistakes that need to be fixed</h2>\n";
        print "<ol>\n";
        
        foreach ($errorMsg as $err) {
            print "<li>" . $err . "</li>\n";
        }
        
        print "</ol>\n";
        print "</div>\n";
    }
    
        //####################################
        //
        // SECTION 3c html Form
        //
        /* Display the HTML form. note that the action is to this same page. $phpSelf
            is defined in top.php
            NOTE the line:
            value="<?php print $email; ?>
            this makes the form sticky by displaying either the initial default value (line ??)
            or the value they typed in (line ??)
            NOTE this line:
            <?php if($emailERROR) print 'class="mistake"'; ?>
            this prints out a css class so that we can highlight the background etc. to
            make it stand out that a mistake happened here.
       */
    ?>

    <form action="<?php print $phpSelf; ?>"
          method="post"
          id="frmRegister">

        <fieldset class="wrapper">
            <legend class="wrapper">Help us make this web site better for you.</legend>
            <p>As people visit this site, they may want to learn more about astronomy or see more of certain concepts pertaining 
                to Astronomy. Because of this, we ask that you take sixty seconds to fill out our survey. All information is confidential 
                and is collected for the sole purposes of improving this web site, and notifying you if anything significant is added.
                <br> We will <b>Never</b> sell, disclose, or distribute the information collected 
                from our users.</p>

            <fieldset class="wrapperTwo">
                <legend>Please fill out the survey below</legend>

                <fieldset class="contact">
                    <legend>Contact Information</legend>

                    <label for="txtFirstName" class="required">First Name
                        <input type="text" 
                               id="txtFirstName" 
                               name="txtFirstName"
                               value="<?php print $firstName; ?>"
                               tabindex="100" 
                               maxlength="45" 
                               placeholder="Enter your first name"
                               <?php if ($firstNameERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"
                               >
                    </label>    
                    <label for="txtLastName" class="required">Last Name
                        <input type="text" 
                               id="txtLastName" 
                               name="txtLastName"
                               value="<?php print $lastName; ?>"
                               tabindex="100" 
                               maxlength="45" 
                               placeholder="Enter your last name"
                               <?php if ($lastNameERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"
                               >
                    </label>    
                    <label for="txtEmail" class="required">Email
                        <input type="text" 
                               id="txtEmail" 
                               name="txtEmail"
                               value="<?php print $email; ?>"
                               tabindex="120" 
                               maxlength="45" 
                               placeholder="Enter a valid email address"
                               <?php if ($emailERROR) print 'class="mistake"'; ?>
                               onfocus="this.select()"
                               >
                    </label>                    
                </fieldset> <!-- ends contact -->
                <!--<figure><img class="at" src="images/at.png" alt="@ Symbol" width="60" height="60"</figure>-->
                <fieldset class="radio">
                    <legend>Select your gender</legend>
                    <label><input type="radio"
                           id="radGenderMale"
                           name="radGender"
                           value="Male"
                           <?php if($gender=="Male") print 'checked'?>
                           tabindex="330">Male</label>
                    <label><input type="radio"
                           id="radGenderFemale" 
                           name="radGender"
                           value="Female"
                           <?php if($gender=="Female") print 'checked'?>
                           tabindex="340">Female</label>
                    <label><input type="radio"
                           id="radGenderOther" 
                           name="radGender"
                           value="Other"
                           <?php if($gender=="Other") print 'checked'?>
                           tabindex="340">Other</label>
                    <label><input type="radio"
                           id="radGenderNone" 
                           name="radGender"
                           value="None"
                           <?php if($gender=="None") print 'checked'?>
                           tabindex="340">Prefer not to answer</label>
                </fieldset>
                <fieldset class="checkbox">
    <legend>What is your favorite aspect of Astronomy?</legend>
    <label><input type="checkbox" 
                  id="chkPlanet" 
                  name="chkPlanet" 
                  value="Planets"
                  <?php if ($planet) print " checked "; ?>
                  tabindex="420">Planets and Life</label>
    <label><input type="checkbox" 
                  id="chkStars" 
                  name="chkStars" 
                  value="Stars"
                  <?php if ($star)  print " checked "; ?>
                  tabindex="430">Stars and Black holes</label>
    <label><input type="checkbox" 
                  id="chkRelativity" 
                  name="chkRelativity" 
                  value="Relativity"
                  <?php if ($relativity) print " checked "; ?>
                  tabindex="420">Theory of Relativity (time, gravity)</label>
    <label><input type="checkbox" 
                  id="chkExplore" 
                  name="chkExplore" 
                  value="Explore"
                  <?php if ($explore)  print " checked "; ?>
                  tabindex="430">Space Exploration</label>
    <label><input type="checkbox" 
                  id="chkOther" 
                  name="chkOther" 
                  value="Other"
                  <?php if ($other)  print " checked "; ?>
                  tabindex="430">Other</label>
</fieldset>              
                <fieldset  class="listbox">	
    <label for="lstVisit">What is your reason for visiting?</label>
    <select id="lstVisit" 
            name="lstVisit" 
            tabindex="520" >
        <option <?php if($visit=="New to Astronomy") print " selected "; ?>
            value="New">New to Astronomy</option>
        <option <?php if($visit=="Want to learn more") print " selected "; ?>
            value="Learn">Want to learn more</option>
        <option <?php if($visit=="Curious") print " selected "; ?>
            value="Curious">Curious about our Universe</option>
        <option <?php if($visit=="School related") print " selected "; ?>
            value="School">School related</option>
        <option <?php if($visit=="Bored") print " selected "; ?>
            value="Bored">Bored</option>
        <option <?php if($visit=="Other") print " selected "; ?>
            value="Other">Other</option>
    </select>
                </fieldset>
                    
                

            </fieldset> <!-- ends wrapper Two -->

            <fieldset class="buttons">
                <legend></legend>
                <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" tabindex="900" class="button">
            </fieldset> <!-- ends buttons -->

        </fieldset> <!-- Ends Wrapper -->
    </form>

    <?php 
    } // end body submit
    ?>

</article>

<?php include "footer.php"; ?>

</body>
</html>