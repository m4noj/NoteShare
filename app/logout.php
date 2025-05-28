<?php session_start();


$_SESSION['flash_messages'][] = ['type' => 'info', 'message' => 'You have been logged out.'];

session_unset();
session_destroy();
// this is not showing..need to fix

header("Location: ../public/login.php");
exit();
?>