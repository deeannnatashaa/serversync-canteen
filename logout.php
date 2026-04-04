<?php
session_start();
session_destroy();
header("Location: /serversync-canteen/student/login.php");
exit();
?>