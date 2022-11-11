<?php
include('../config/constants.php');
     //destory the session
     session_destroy();//unset $_session['user']
     //redirect to login page
     header('location:'.SITEURL.'admin/login.php');
?>