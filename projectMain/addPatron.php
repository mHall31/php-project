<?php
    require_once('startsession.php');
    require_once('connectvars.php');
       
        if (!isset($_SESSION['userId'])) {
            echo '<p class="login">Please <a href="index.php">log in</a> to access this page.</p>';
            exit();
        }
?>

<!DOCTYPE html>
<html>

<head>
    <!--   Author:  Michael Hall
                 Date:    12/04/2018
    -->
    <meta charset="UTF-8" />
    <link href="styleSheets/style.css"
                rel="stylesheet"
                type="text/css" />

        <title> Patron Registration
        </title>
</head>

<body>
    <div id="wrapper">
        
    <section id="response">
        
    <?php 
        require_once('navbar.php');
       
        if(isset($_POST['submit'])) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
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
        
        if(!empty($firstName) || !empty($lastName) || !empty($sex) || !empty($birthdate) || !empty($school) || !empty($city) || !empty($grade)
                    || !empty($phoneNumber) || !empty($email)) {
            $query = "insert into spplPatrons values ('', '$firstName', '$lastName', '$sex', '$birthdate', '$school', '$grade', '$city', '$phoneNumber', '$email');";
            mysqli_query($dbc, $query)
                    or die('Error adding patron to database.');
            echo "<h3>Thank you for adding a patron record for $firstName $lastName</h3><br/>";
            mysqli_close($dbc);
            
        } else {
            echo 'You must fill out patron record completely.';
        }
        
    }
        
    ?>
    </section>




    <header> 
                <h3>Register a Patron:</h3>
    </header>
    
    <section>
                <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <fieldset>
                        <legend>Patron Information</legend>
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
    </section>

</div>
</body>
</html>



