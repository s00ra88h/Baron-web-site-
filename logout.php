<?php
session_start();

/* delete ses*/
session_unset();
session_destroy();

/* delete co */
setcookie("admin_name", "", time() - 3600, "/");

header("Location: login.php");
exit();
?>