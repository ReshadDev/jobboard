<?php 

session_start();

session_unset();
session_destroy();

header("Location:  http://localhost/jobboard/admin-panel/admins/login-admins.php ");
