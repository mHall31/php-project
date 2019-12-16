<?php
    session_start();
    
    //if no setr vars, set with cookie
    if(!isset($_SESSION['userId'])) {
        if(isset($_COOKIE['userId']) && isset ($_COOKIE['username'])) {
            $_SESSION['username'] = $_COOKIE['username'];
            $_SESSION['userId'] = $_COOKIE['userId'];
            $_SESSION['adminPriv'] = $COOKIE['adminPriv'];
            
        }
    }
?>