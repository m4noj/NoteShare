<?php 
include('partials/flash.php');
// Check if user is logged in
// if (!isset($_SESSION['user'])) {
//   header('Location: login.php');
//   exit();
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Community - NoteShare</title>
  <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
</head>

<body>
<?php $searchfor = 'Communities'; ?>
<?php require_once('partials/navbar.php'); ?>
<?php require_once('partials/flash.php'); ?>


<!-- Main Container -->
<div class="container mt-5 pt-5">
  
  <h2 class="mb-4">Create a New Community</h2>
  <hr><br>
  
  <!-- Community Creation Form -->
  <form action="../app/create-community-action.php" method="POST" enctype="multipart/form-data">
    
    <div class="mb-4">
      <label for="communityName" class="form-label post-labels">Community Name</label>
      <input type="text" class="form-control" id="communityName" name="name" required>
    </div>
    
    <div class="mb-4">
      <label for="description" class="form-label post-labels">Description</label>
      <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
    </div>
    
    <div class="mb-4">
      <label for="logo" class="form-label post-labels">Logo</label>
      <input type="file" class="form-control" id="communityLogo" name="logo">
    </div>
    
    <div class="mb-4">
      <label for="visibility" class="form-label post-labels">Visibility</label>
      <select class="form-select" id="visibility" name="visibility">
        <option value="public" selected>Public (Anyone can join)</option>
        <option value="private">Private (Only members can see)</option>
        <option value="invite-only">Invite-Only (Join by invitation)</option>
      </select>
    </div>
    <br>    
    <button type="submit" class="btn btn-primary">Create Community</button>
  </form>
</div>
<br><br><br>

<style>
  .post-labels{
    font-weight: bold;
    font-size: 16px;
  }
  </style>
<?php include('partials/footer.php'); ?>
</body>
</html>
