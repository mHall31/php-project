<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    require_once('navbar.php');
    
        if (!isset($_SESSION['userId'])) {
            echo '<p>Please <a href="index.php">log in</a> to access this page.</p>';
            exit();
        }
        if (isset($_SESSION['adminPriv']) && $_SESSION['adminPriv'] =='F') {
            echo '<p>You do not have the privlages to access this page.</p>';
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

        <title> Create new program
        </title>
</head>

<body>


<div id="wrapper">

    <header> 
        <h3>Create new Program:</h3>
    </header>
        <?php 
    
       
        if(isset($_POST['submit'])) {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
            $startDate = mysqli_real_escape_string($dbc, trim($_POST['startdate']));
            $maxCapacity = mysqli_real_escape_string($dbc, trim($_POST['maxCapacity']));
            $typeId = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
            $error = false;
            
            if(!empty($name) || !empty($startDate) || !empty($maxCapacity) || !empty($typeId)) {
                $query = "insert into spplPrograms values ('', '$name', '$startDate', '$maxCapacity', '$typeId');";
                mysqli_query($dbc, $query)
                        or die('Error adding program to database.');
                echo '<h3>Thank you for adding a new program</h3><br/>';
                mysqli_close($dbc);
                
            } else {
                    echo 'You must fill out program record completely.';
            }
            
        }
        
        ?>
    <section>
            <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <fieldset>
                        <legend>Program Information</legend>
                        <label for="name">Program name:</label>
                        <input type="text" id="name" name="name" value="<?php if (!empty($name)) echo $name; ?>" /><br />
                        <label for="maxCapacity">Max Capacity:</label>
                        <input type="text" id="maxCapacity" name="maxCapacity" value="<?php if (!empty($maxCapacity)) echo $maxCapacity; ?>" /><br />
                        <label for="startdate">Start date:</label>
                        <input type="date" id="startdate" name="startdate" value="<?php if (!empty($startdate)) echo $startdate; else echo 'YYYY-MM-DD'; ?>" /><br />
                </fieldset>
                <input type="submit" value="Submit program Info" name="submit" />
        </form>
    </section>

</div>
</body>
</html>