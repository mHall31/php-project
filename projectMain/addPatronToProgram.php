<?php
    require_once('startsession.php');
    require_once('connectvars.php');
    
        if (!isset($_SESSION['userId'])) {
            echo '<p>Please <a href="index.php">log in</a> to access this page.</p>';
            exit();
        }

    if (isset($_GET['patronId']) && is_numeric($_GET['patronId']) && isset($_GET['programId']) && is_numeric($_GET['programId'])) {

        $patronId = $_GET['patronId'];
        $programId = $_GET['programId'];
        
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Error connecting to the database');
      
        $query = "insert into patronProgramAttendance values ( $programId, $patronId, '')"; 
        
        mysqli_query($dbc, $query)
               or die ('Failed to Add Patron to Program');

        mysqli_close($dbc);
        
        header("Location: programPatronRefPage.php?id=$programId");
        
    } 
?>