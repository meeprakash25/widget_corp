<?php require_once "../includes/session.php";?>
<?php require_once "../includes/functions.php";?>
<?php

    // v1: simple logout
    // session_start(); which is already included in session.php
    $_SESSION["admin_id"] = null;
    $_SESSION["username"] = null;
    redirect_to("login.php");    
?>

<?php 
    //v2: destroy session
    // assumes nothing else in session to keep
    // session_start();
    // $_SESSION = array(); // sets session to empty array
    // if(isset($_COOKIE[session_name()])){
    //     setcookie(session_name(), time()-4200, '/');
    // }
    // session_destroy();
    // redirect_to("login.php");
?>