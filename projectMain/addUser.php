
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

        <title>Adding new user
        </title>
</head>

<body>
     <?php 
                if(isset($_POST['submit'])) {
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                
                $firstName = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
                $lastName = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
                $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
                $password = mysqli_real_escape_string($dbc, trim($_POST['password']));
                $passwordTwo = mysqli_real_escape_string($dbc, trim($_POST['passwordTwo']));
                $adminPriv = mysqli_real_escape_string($dbc, trim($_POST['adminPriv']));
                $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
                $error = false;
                
                if((!empty($firstName) || !empty($lastName) || !empty($username) || !empty($adminPriv)) && ($password == $passwordTwo) ) {
                        
                        $hashPassword = SHA1($password);
                        $query = "insert into spplUsers values ('', '$username', '$hashPassword', '$adminPriv', '$firstName', '$lastName', '$email');";
                        mysqli_query($dbc, $query)
                                        or die('Error adding new user to database.');
                        echo 'Thank you for adding a new user<br/>';
                        mysqli_close($dbc);
                        
                } else {
                        echo 'You must fill out user form completely. Make sure your passwords are matching';
                }
                
        }
                
        ?>

<div id="wrapper">

    <header> 
                <h3>Add a New User to the Application:</h3>
    </header>
    
    <section>
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
                <input type="submit" value="Submit new user" name="submit" />
        </form>
    </section>

</div>
</body>
</html>



