<div id="wrapper">
<p>
<?php
    //building the nav menu 
    echo '<hr />';
    
    if(isset($_SESSION['userId'])) {
        
        if($_SESSION['adminPriv'] == 'T') {
            echo '<a href="addPatron.php">Add new Patron</a>  ';
            echo '<a href="searchPatron.php">Edit Patrons</a> ';
            echo '<a href="addProgram.php">Add new Program</a>  ';
            echo '<a href="searchProgram.php">Edit Programs</a>  ';
            echo '<a href="addUser.php">Add new user</a>  ';
            echo '<a href="searchUser.php">Edit Users</a>  ';
            echo '<a href="programAttendance.php">Program Sign-up</a>  ';
            echo '<a href="logout.php">Logout</a>  ';
            
        } else if($_SESSION['adminPriv'] == 'F'){
            echo '<a href="addPatron.php">Add new patron</a>  ';
            echo '<a href="searchPatron.php">Edit patrons</a>  ';
            echo '<a href="programAttendance.php">Program Sign-up</a>  ';
            echo '<a href="logout.php">Logout</a>  ';
        }
        else {
            echo 'Please Log In to See options';
        }
        
    }
    echo '<hr />'; 

?>
</p>
</div>