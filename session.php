<?php 
session_start();

if(!isset($_SESSION['accountId']))
{
    $_SESSION['accountId'] = session_id();

}
?>