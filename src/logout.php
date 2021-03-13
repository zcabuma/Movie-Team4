<?php
   
   session_start();
   $_SESSION = Array();
   //unset($_SESSION['valid']);
   //session_unset();
   header('Refresh: 2; URL = login.php');
   echo 'You have cleaned session';
   
?>