<?php session_start();if(!isset($_SESSION['user'])){header("Location: login.php");exit();}?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteShare - Home</title>
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <script src="assets/dist//js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <style>
  /* Fixed user sidebar */
  .user-sidebar {
    position: sticky;
  top: 80px;
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Section buttons */
.section-buttons {
  position: sticky;
  top: 80px;
  background-color: #fff;
  z-index: 999;
  padding: 10px 0;
}

.section-buttons button {
  margin-right: 10px;
}

.section-buttons .active {
  background-color: #007bff;
  color: white;
}

/* Profile content (scrollable) */
.profile-content {
  max-height: calc(100vh - 180px);
  overflow-y: auto;
  padding-top: 10px;
}

/* Content sections */
.content-section {
  display: none;
}

.content-section.active {
  display: block;
}

.community-badge {
  font-size: 12px;
  padding: 5px 7px;
  margin-left: 1px;
  color: white;
}


</style>

<?php $searchfor = 'People, Posts, Communities';?>
<?php include('partials/navbar.php'); ?>
<?php include('partials/flash.php'); ?>
<?php require_once '../app/core/Database.php';

$user_id = $_GET['id'] ?? $_SESSION['user']['id'];
$db = Database::getInstance();

// Fetch user details
$user = $db->selectOne('users', ['id' => $user_id]);
?>



<div class="container mt-5 pt-4">
  <div class="row">
    <!-- Left Section: User Info (Fixed Sidebar) -->

    <div class="col-md-4">

      <div class="user-sidebar">


              <div>
                <img src="uploads/avatars/<?= $user['avatar'] ?>" class="rounded-circle mb-3" width="100" height="100">
              </div><p></p>
              <h2><?php echo $user['first'].' '.$user['last'];?><span class="text-muted"> (me)</span></h2>
              <h5><span class="text-secondary">@</span><?= htmlspecialchars($user['username']) ?></h5>
              
              <small class="badge bg-secondary text-white" style="font-size: 12px;"><?= htmlspecialchars($user['role']); ?></small>
              <hr>

                <blockquote class="blockquote">
                    <p class="text-dark"><?= htmlspecialchars($user['bio'] ?? 'No bio added') ?></p>
              </blockquote>
              <p class="text-dark"><b>Email</b>  <?= htmlspecialchars($user['email']); ?></p>
              <p><b>Joined</b> <?= date('F Y', strtotime($user['joined'])) ?></p>
             
            </div>

          </div>

          

  
      <!-- Right Section: Section Buttons & Scrollable Content -->
      <div class="col-md-8">
        <!-- Fixed Buttons for Switching Sections -->
       
        <h3 class="text-secondary">Edit Profile</h3>
        <hr>

      <!-- Scrollable Content -->
      <div class="profile-content">



    <form method="POST" action="../app/profile_update.php" enctype="multipart/form-data">
      
    <div class="mb-3">
        <label class="bold">First Name</label>
        <input type="text" name="firstname" class="form-control" value="<?= htmlspecialchars($user['first']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Last Name</label>
        <input type="text" name="lastname" class="form-control" value="<?= htmlspecialchars($user['last']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
      </div>

      <div class="mb-3">
        <label>Bio</label>
        <textarea name="bio" class="form-control"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
      </div>

      <div class="mb-3">
        <label>Profile Picture</label>
        <input type="file" name="avatar" class="form-control">
      </div>
        <br>
      <button class="btn btn-primary" type="submit">Update Profile</button>
    </form>
      </div>

    </div>
  </div>
</div>
</body>
</html>
