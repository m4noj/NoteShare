<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Post - NoteShare</title>
  <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
  <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
</head>

<body>
<?php $searchfor = 'Posts'; ?>

<!-- Navbar -->
<?php include('partials/navbar.php'); ?>
<?php include('partials/flash.php'); ?>

<!-- Main Content -->
<div class="container mt-5 pt-5">

  <div class="col-md-8">
    
    <h2 class="mb-4">Create a New Post</h2>
    <hr><br>
    
    <!-- Post Form -->
    <form action="../app/create-post-action.php" method="POST" enctype="multipart/form-data">
      
      <!-- Post Title -->
      <div class="mb-4">
        <label class="form-label post-labels">Post Title</label>
      <input type="text" class="form-control" name="title" required>
    </div>

    <!-- Select Community -->
    <div class="mb-4">
      <label class="form-label post-labels">Post in Community</label>
      <select class="form-select" name="community_id" required>
        <option value="" selected disabled>Select Community</option>
        
        <?php include('../app/core/database.php'); 
        $db = Database::getInstance();
        $communities = $db->select('communities');
        foreach($communities as $k =>$v){ echo "<option value=".$v['id'].">".$v['name']."</option>";}?>
      
    </select>
    </div>

    <!-- Tags -->
    <div class="mb-4">
      <label class="form-label post-labels">Tags (comma-separated)</label>
      <input type="text" class="form-control" name="tags" placeholder="e.g. PHP, MySQL, Backend">
    </div>

    <!-- Short Description -->
    <div class="mb-4">
      <label class="form-label post-labels">Short Description</label>
      <textarea class="form-control" name="description" rows="3" required></textarea>
    </div>
    <!-- post -->
    <div class="mb-4">
      <label class="form-label post-labels">Write Post..</label>
      <textarea class="form-control" name="postdata" rows="5" required></textarea>
    </div>
    
    <!-- Rich Text Editor -->
    <!-- <div class="mb-3">
      <label class="form-label">Post Content</label>
      <textarea name="content" id="editor" rows="10" required></textarea>
    </div> -->
    
    <!-- File Upload -->
    <div class="mb-4">
      <label class="form-label post-labels">Attach an image if you want (JPG, PNG)</label>
      <input type="file" class="form-control" name="postimg" accept=".jpg, .png">
    </div>
    <br>

    <div class="mb-4">
      <label class="form-label post-labels">Attach File (PDF, DOC, etc.)</label>
      <input type="file" class="form-control" name="file">
    </div>
    <br>
    
    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">Publish Post</button>

  </form>
</div>
  
</div>
<style>
  .post-labels{
    font-weight: bold;
    font-size: 16px;
  }
  </style>

<!-- <script>
  CKEDITOR.replace('editor');
</script> -->

<br><br><br><br><br>

<?php include('partials/footer.php'); ?>


</body>
</html>