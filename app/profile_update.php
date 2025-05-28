<?php

session_start();
require_once 'core/Database.php';

if (!isset($_SESSION['user'])) {
  header('Location: ../public/login.php');
  exit();
}

if($_SERVER['REQUEST_METHOD']==='POST'){

  $db = Database::getInstance();
  $user_id = $_SESSION['user']['id'];
  
  // Handle file upload
  if ($_FILES['avatar']['name']) {
    $avatar = 'avatar__'. $_FILES['avatar']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], "../public/uploads/avatars/$avatar");
  } else {
    $avatar = $_SESSION['user']['avatar'] ?? 'default-avatar.jpg';
  }
  try {
        // Update user data
        $db->update('users', [
          'first'=>$_POST['firstname'],
          'last'=>$_POST['lastname'],
          'email' => $_POST['email'],
          'bio' => $_POST['bio'],
          'avatar' => $avatar], 
          ['id' => $user_id]);
        
        // Update session data
        // $_SESSION['user']['username'] = $_POST['username'];
        // $_SESSION['user']['avatar'] = $avatar;
        
        $_SESSION['flash_messages'][]=['type'=>'success','message'=>'Profile updated Successfully!'];
        
        header('Location: ../public/profile.php');
        exit();
  } catch (\PDOException $e) {
        $_SESSION['flash_messages'][]=['type'=>'danger','message'=>'Failed to updated Profile. try again.'];
        header('Location: ../public/profile.php');
        exit();
  }
}
?>