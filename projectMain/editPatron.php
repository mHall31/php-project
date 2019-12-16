<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    
        if (!isset($_SESSION['userId'])) {
            echo '<p>Please <a href="index.php">log in</a> to access this page.</p>';
            exit();
        }
    
    require_once('navbar.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Patron - Edit Information</title>
    <link rel="stylesheet" type="text/css" href="styleSheets/style.css" />
</head>
<body>
    <div id="wrapper">
    <h3>Patron - Edit Information</h3>

<?php
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connecting to the database');
    //Retrive Patron id
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id =  mysqli_real_escape_string($dbc, trim($_GET['id']));
    }
    
    if (isset($_POST['submit'])) {
        // Update data from post 
        
        $firstName = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
        $lastName = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
        $sex = mysqli_real_escape_string($dbc, trim($_POST['sex']));
        $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
        $school = mysqli_real_escape_string($dbc, trim($_POST['school']));
        $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
        $grade = mysqli_real_escape_string($dbc, trim($_POST['grade']));
        $phoneNumber = mysqli_real_escape_string($dbc, trim($_POST['phoneNumber']));
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        $error = false;
        

        // Update the profile data in the database
        if (!$error) {
            if (!empty($firstName) && !empty($lastName) && !empty($sex) && !empty($birthdate) && !empty($school) && !empty($city) && !empty($grade)
                    && !empty($phoneNumber)) {

                $query = "UPDATE spplPatrons SET firstName = '$firstName', lastName = '$lastName', sex = '$sex', grade = '$grade', " .
                    " birthdate = '$birthdate', schoolAttending = '$school', city = '$city', phoneNumber = '$phoneNumber', email = '$email' WHERE Id = '" . $_POST['id'] . "'";
                
                //debug relic
                //echo "$query";
                    
                mysqli_query($dbc, $query)
                        or die('Error editing patron information');

                // Confirm success with the user
                echo '<p>Patron information successfully updated. Would you like to <a href="searchPatron.php">return to Patron Search?</a>?</p>';

                mysqli_close($dbc);
                exit();
            }
            else {
                echo '<p class="error">You must enter all of the patron data.</p>';
            }
        }
    } // End of check for form submission
    else {
        // Grab the profile data from the database
        $query = "SELECT firstName, lastName, sex, birthdate, schoolAttending, grade, city, phoneNumber, email FROM spplPatrons WHERE Id = '" . $id . "'";
        //relic from testing
        //echo "$query";
        $data = mysqli_query($dbc, $query)
                or die('Error grabbing patron data');
        
        
        $row = mysqli_fetch_array($data);
        

        if ($row != NULL) {
            $firstName = $row['firstName'];
            $lastName = $row['lastName'];
            $sex = $row['sex'];
            $birthdate = $row['birthdate'];
            $school = $row['schoolAttending'];
            $city = $row['city'];
            $grade = $row['grade'];
            $phoneNumber = $row['phoneNumber'];
            $email = $row['email'];
        }
        else {
            echo '<p class="error">There was a problem accessing patron information.</p>';
        }
    }

    mysqli_close($dbc);
?>

                <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <fieldset>
                        <legend>Patron Information</legend>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <label for="firstname">First name:</label>
                        <input type="text" id="firstname" name="firstname" value="<?php if (!empty($firstName)) echo $firstName; ?>" /><br />
                        <label for="lastname">Last name:</label>
                        <input type="text" id="lastname" name="lastname" value="<?php if (!empty($lastName)) echo $lastName; ?>" /><br />
                        <label for="sex">Sex:</label>
                        <select id="sex" name="sex">
                            <option value="M" <?php if (!empty($sex) && $sex == 'M') echo 'selected = "selected"'; ?>>Male</option>
                            <option value="F" <?php if (!empty($sex) && $sex == 'F') echo 'selected = "selected"'; ?>>Female</option>
                        </select><br />
                        <label for="birthdate">Birthdate:</label>
                        <input type="date" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" /><br />
                        <label for="school">School:</label>
                        <input type="text" id="school" name="school" value="<?php if (!empty($school)) echo $school; ?>" placeholder="School attending in fall." /><br />
                        <label for="grade">Grade:</label>
                        <input type="text" id="grade" name="grade" value="<?php if (!empty($grade)) echo $grade; ?>" placeholder="Grade in fall." /><br />
                        <label for="city">City of Residence:</label>
                        <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" /><br />
                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php if (!empty($phoneNumber)) echo $phoneNumber; ?>" placeholder="(xxx)xxx-xxxx" /><br />
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" placeholder="Optional for program updates" /><br />
                        
                </fieldset>
                <input type="submit" value="Submit Patron Info" name="submit" />
        </form>
</div>
</body> 
</html>