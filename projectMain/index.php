<?php
         require_once('connectvars.php');
                
            // start the session
            session_start();
        
            // clear the error message
            $error_msg = "";
        
            // if the user isn't logged in, try to log them in
            if (!isset($_SESSION['userId'])) {
                    if (isset($_POST['submit'])) {
                            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
                            $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
                            $userPassword = mysqli_real_escape_string($dbc, trim($_POST['password']));
                        
                            if (!empty($username) && !empty($userPassword)) {
                                $query = "SELECT userId, username, adminPriv FROM spplUsers WHERE username = '$username' AND password = SHA('$userPassword')";
                                $data = mysqli_query($dbc, $query)
                                                or die('Error getting profile');
                        
                                if (mysqli_num_rows($data) == 1) {
                                    //set the Id, username, adminPriv session and cookies, redirect to the application mainPage
                                    $row = mysqli_fetch_array($data);
                                    $_SESSION['userId'] = $row['userId'];
                                    $_SESSION['username'] = $row['username'];
                                    $_SESSION['adminPriv'] = $row['adminPriv'];
                                    setcookie('userId', $row['userId'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
                                    setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  
                                    setcookie('adminPriv', $row['adminPriv'], time() + (60 * 60 * 24 * 30)); 
                                    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
                                    header('Location: mainPage.php');
                                }
                                else {
                                    // incorrect user/pw 
                                    $error_msg = 'Sorry, you must enter a valid username and password to log in.';
                                }
                            }
                            else {
                                // nothing entered message
                                $error_msg = 'Sorry, you must enter your username and password to log in.';
                            }
                        }
                    }
                ?>
                
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>SPPL Children's Desk - Log In</title>
                    <link rel="stylesheet" type="text/css" href="styleSheets/style.css" />
                </head>
                <body>
                    <img id="spLogo" src="images/sunPrairieLogo.png" alt="Sun Prairie Public Library Logo">
                    <h3>SPPL Children's Desk -- Log In</h3>
                    
                    <div id="wrapper">
                    
                <?php
                        if (empty($_SESSION['userId'])) {
                        echo '<p class="error">' . $error_msg . '</p>';
                ?>
                
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <fieldset>
                            <legend>Log In</legend>
                            <label for="username">Username:</label>
                            <input type="text" name="username" value="<?php if (!empty($username)) echo $username; ?>" /><br />
                            <label for="password">Password:</label>
                            <input type="password" name="password" />
                        </fieldset>
                        <input type="submit" value="Log In" name="submit" />
                    </form>
                </div>
                <?php
                        }
                           
                    
                        
                ?>
                
        </body>
</html>