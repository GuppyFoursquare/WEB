<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("prepend.php");
$_SESSION['is_most_popular'] = 0;
if(isset($_SESSION['user_id']))
{
    session_unset();
    session_destroy(); 
}
header('location:index.php');
?>
