<?php
session_start();
unset($_SESSION['name']);
unset($_SESSION['id']);
session_destroy();
header("Location: index.php");
?>