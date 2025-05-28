<?php session_start();
require_once 'core/Database.php';
include('../public/partials/flash.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $db = Database::getInstance();
  $email = $_POST['email'];
  $password = $_POST['password'];
  $user = $db->selectOne('users', ['email' => $email]);
  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = [
      'id' => $user['id'],
      'first'=>$user['first'],
      'last'=>$user['last'],
      'username' => $user['username'],
      'email'=>$user['email'],
      'role' => $user['role']
    ];
    $_SESSION['flash_messages'][] = ['type' => 'success', 'message' => 'Login Successful! Welcome back.'];
        header("Location: ../public/home.php");
        exit();
  } else {
        $_SESSION['flash_messages'][] = ['type'=>'danger','message'=>'Invalid email or password.'];
            header('Location: ../public/login.php');
            exit();
  }
}

?>