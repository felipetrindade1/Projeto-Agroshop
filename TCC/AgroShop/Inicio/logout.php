<?php

if(!isset($_SESSION)) {
    session_start();
}

session_destroy();

echo '<script type="text/javascript">
 window.location = "login.php";
 </script>';