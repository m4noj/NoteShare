<?php session_start();
header('Location: ../public/signup.php');
require_once 'core/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db = Database::getInstance();

  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  // Validate if passwords match
  if ($password !== $confirm_password) {
    // die("Passwords do not match.");
    $_SESSION['flash_messages'][] = ['type'=>'danger','message'=>'Passwords do not match.'];
      header('Location: ../public/signup.php');
      exit();
  }

//   // Insert into database
//   $result = $db->insert('users', [
//     'first' => $first_name,
//     'last' => $last_name,
//     'username' => $username,
//     'email' => $email,
//     'role' => $role,
//     'password' => password_hash($password, PASSWORD_BCRYPT)]);



// if ($result) {
//         session_start();
//         $_SESSION['flash_messages'][] = ['type' => 'success', 'message' => 'Account created successfully!'];
//         $_SESSION['flash_messages'][] = ['type' => 'info', 'message' => 'You can now log in.'];
//         header("Location: ../public/login.php");
//       exit();  
//   } else {

//     // this is not showing..need to check.
     
//             session_start();
//             $_SESSION['flash_messages'][] = ['type'=>'danger','message'=>'Failed to register user.'];
//             header('Location: ../public/signup.php');
//             exit();
//   }
// }


try { $db->insert('users', [
        'first' => $first_name,
        'last' => $last_name,
        'username' => $username,
        'email' => $email,
        'role' => $role,
        'password' => password_hash($password, PASSWORD_BCRYPT)]);
  
        $_SESSION['flash_messages'][] = ['type' => 'success', 'message' => 'Account created successfully!'];
                $_SESSION['flash_messages'][] = ['type' => 'info', 'message' => 'You can now log in.'];
                header("Location: ../public/login.php");
                exit();  

} catch (PDOException $e) {
  
        if($e->getCode()==='23000'){
          
          $_SESSION['flash_messages'][] = ['type'=>'danger','message'=>'Email or Username already Exists! try different email or username.'];
                      header('Location: ../public/signup.php');
          
        } else {
          
          $_SESSION['flash_messages'][] = ['type'=>'danger','message'=>'Failed to Register. something went wrong!'];
        }

        header('Location: ../public/signup.php');
        exit();



}


}

?>
