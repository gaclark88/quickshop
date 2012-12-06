<?php 
/* Starts a new session and stores the session id in a cookie */
session_start();

/* If the user is not logged in, set the account id to the session id */
if(!isset($_SESSION['accountId']))
{
    $_SESSION['accountId'] = session_id();

}
?>