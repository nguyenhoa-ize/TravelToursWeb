<?php
session_start();
session_unset();
session_destroy();
header("Location: " . SITE_URL . "index.php");
exit();
?>
