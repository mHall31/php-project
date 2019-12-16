<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    
        if (!isset($_SESSION['userId'])) {
            echo '<p>Please <a href="index.php">log in</a> to access this page.</p>';
            exit();
        }
        if (isset($_SESSION['adminPriv']) && $_SESSION['adminPriv'] =='F') {
            echo '<p>You do not have the privlages to access this page.</p>';
            exit();
        }
    require_once('navbar.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Program - Edit Information</title>
    <link rel="stylesheet" type="text/css" href="styleSheets/style.css" />
</head>
<body>
    <div id="wrapper">
    <h3>Program - Edit Information</h3>

<?php

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connecting to the database');
    
    //retrive program id
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id =  mysqli_real_escape_string($dbc, trim($_GET['id']));
        //echo "$id";
    }
    
    // Submit data from post 
    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
        $startDate = mysqli_real_escape_string($dbc, trim($_POST['startdate']));
        $maxCapacity = mysqli_real_escape_string($dbc, trim($_POST['maxCapacity']));
        
        //$typeId = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
        $error = false;

        // Update the profile data in the database
        if (!$error) {
            if (!empty($name) || !empty($startDate) || !empty($maxCapacity)) {
                $query = "UPDATE spplPrograms SET name = '$name', startDate = '$startDate', maxCapacity = '$maxCapacity' WHERE Id = '" . $_POST['id'] . "'";
                mysqli_query($dbc, $query)
                        or die('Error editing program information');

                // Confirm success with the user
                echo '<p>Program information successfully updated. Would you like to <a href="searchProgram.php">return to Program Search?</a>?</p>';

                mysqli_close($dbc);
                exit();
            }
            else {
                echo '<p class="error">You must enter all of the Program data.</p>';
            }
        }
    } 
    
    else {
        // Grab the profile data from the database
        $query = "SELECT name, startDate, maxCapacity FROM spplPrograms WHERE Id = '" . $id . "'";
        $data = mysqli_query($dbc, $query)
                or die('Error grabbing program data');
        $row = mysqli_fetch_array($data);

        if ($row != NULL) {
            $name = mysqli_real_escape_string($dbc, trim($row['name']));
            $startDate = mysqli_real_escape_string($dbc, trim($row['startdate']));
            $maxCapacity = mysqli_real_escape_string($dbc, trim($row['maxCapacity']));
            //$typeId = mysqli_real_escape_string($dbc, trim($_POST['typeId']));
            $error = false;
        }
        else {
            echo '<p class="error">There was a problem accessing Program information.</p>';
        }
    }

    mysqli_close($dbc);
?>

                <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <fieldset>
                        <legend>Program Information</legend>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <label for="name">Program name:</label>
                        <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>" /><br />
                        <label for="maxCapacity">Max Capacity:</label>
                        <input type="text" id="maxCapacity" name="maxCapacity" value="<?php if (!empty($maxCapacity)) echo $maxCapacity; ?>" /><br />
                        <label for="startdate">Start date:</label>
                        <input type="date" id="startdate" name="startdate" value="<?php if (!empty($startDate)) echo $startDate; else echo 'YYYY-MM-DD'; ?>" /><br />
   
                </fieldset>
                <input type="submit" value="Submit Program edit" name="submit" />
        </form>
</div>
</body> 
</html>