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
    <title>Users - Edit Information</title>
    <link rel="stylesheet" type="text/css" href="styleSheets/style.css" />
</head>
<body>
    <div>
    <h3>Users - Edit Information</h3>
        <div id="wrapper">
        <table>
        <tr><td>First Name:    </td>
            <td>Last Name:    </td>
            <td>Username:    </td></tr>
        <?php
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or die('Error connecting to the database');
            $query = "select userId, firstName, lastName, username from spplUsers";
            $data = mysqli_query($dbc, $query)
                    or die('Error retreving user data');
            while ($row = mysqli_fetch_array($data)) { 
                echo '<tr><td>' . $row['firstName']. '    </td>';
                echo '<td>' . $row['lastName']. '    </td>';
                echo '<td>' . $row['username']. '    </td>';
                echo '<td><a href="editUser.php?id=' . $row['userId'] . '">Edit User<a>    </td>';
                echo '<td><a href="removeUser.php?id=' . $row['userId'] . '">Remove User<a>    </td>';
            }
        ?>
        </table>
        </div>
    </div>
</body>
</html>