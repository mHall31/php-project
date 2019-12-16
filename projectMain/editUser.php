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
            $firstName = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
            $lastName = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
            $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
            $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
            $passwordTwo = mysqli_real_escape_string($dbc, trim($_POST['passwordTwo']));
            $adminPriv = mysqli_real_escape_string($dbc, trim($_POST['adminPriv']));
            $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
            $error = false;
    
        // Update the profile data in the database
        if (!$error) {
            if((!empty($firstName) || !empty($lastName) || !empty($username) || !empty($adminPriv)) && ($password == $passwordTwo)) {
                
                $hashPassword = SHA1($password);
                
                $query = "UPDATE spplUsers SET firstName = '$firstName', lastName = '$lastName', username = '$username', password = '$hashpassword'"
                 . " adminPriv = '$adminPriv', email = '$email' WHERE Id = '" . $_POST['id'] . "'";
                mysqli_query($dbc, $query)
                        or die('Error editing program information');

                // Confirm success with the user
                echo '<p>Program information successfully updated. Would you like to <a href="searchProgram.php">return to Program Search?</a>?</p>';

                mysqli_close($dbc);
                exit();
            }
            else {
                echo '<p class="error">You must enter all required User data.</p>';
            }
        }
    } 
    
    else {
        // Grab the profile data from the database
        $query = "SELECT firstName, lastName, username, adminPriv, email FROM spplUsers WHERE userId = '" . $id . "'";
        $data = mysqli_query($dbc, $query)
                or die('Error grabbing User data');
        $row = mysqli_fetch_array($data);

        if ($row != NULL) {
            $firstName = mysqli_real_escape_string($dbc, trim($row['firstName']));
            $lastName = mysqli_real_escape_string($dbc, trim($row['lastName']));
            $username = mysqli_real_escape_string($dbc, trim($row['username']));
            $adminPriv = mysqli_real_escape_string($dbc, trim($row['adminPriv']));
            $email = mysqli_real_escape_string($dbc, trim($row['email']));
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
                        <legend>User Information</legend>
                        <label for="firstname">First name:</label>
                        <input type="text" id="firstname" name="firstname" value="<?php if (!empty($firstName)) echo $firstName; ?>" /><br />
                        <label for="lastname">Last name:</label>
                        <input type="text" id="lastname" name="lastname" value="<?php if (!empty($lastName)) echo $lastName; ?>" /><br />
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
                        <label for="password">password:</label>
                        <input type="password" id="password" name="password" value="<?php if (!empty($password)) echo $password; ?>" /><br />
                        <label for="password">Re-enter password:</label>
                        <input type="password" id="passwordTwo" name="passwordTwo" value="<?php if (!empty($passwordTwo)) echo $passwordTwo; ?>" /><br />
                        <label for="type">Grant admin Privlages:</label>
                        <select id="adminPriv" name="adminPriv">
                                <option value="T" <?php if (!empty($adminPriv) && $adminPriv == 'T') echo 'selected = "selected"'; ?>>Yes</option>
                                <option value="F" <?php if (!empty($adminPriv) && $adminPriv == 'F') echo 'selected = "selected"'; ?>>No</option>
                        </select><br />
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" /><br />
                        
                </fieldset>
                <input type="submit" value="Submit user edit" name="submit" />
        </form>
</div>
</body> 
</html>