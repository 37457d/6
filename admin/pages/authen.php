<?php 
   session_start();
    require_once __DIR__ . '/../php/connect.php';
   if( !isset($_SESSION['authen_id'] ) ){
      header('Location: ../../login.php');  
   }
?>