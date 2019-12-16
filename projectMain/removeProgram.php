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


    if (isset($_GET['id']) && is_numeric($_GET['id'])) {

        $id = $_GET['id'];
        
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connecting to the database');
      
        $query = "DELETE FROM spplPrograms WHERE Id=$id "; 
        
        mysqli_query($dbc, $query)
               or die ('Failed to remove Program');

        mysqli_close($dbc);
        
        header("Location: searchProgram.php");
        
    } 
?>