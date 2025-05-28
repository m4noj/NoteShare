<?php if(!isset($_GET['id'])){ 
  header("Location: communities.php"); 
  exit();
} 

// $community_id = $_GET['id'] ?? null;
// $db = Database::getInstance();

// // Fetch community details
// $community = $db->selectOne('communities', ['id' => $community_id]);
// if (!$community) {
//     die("Community not found.");
// }

// Fetch posts within the community

// Check if user is a member of the community
// $is_member = false;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Community - NoteShare</title>
  <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php $searchfor = 'Communities';?>
<?php include('partials/navbar.php'); ?>
<?php include('partials/flash.php'); ?>

<style>

.user-sidebar {
        position: sticky;
        top: 80px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
.card {
  border: 1px solid #e0e0e0;
  transition: all 0.2s ease-in-out;
}

.card:hover {
  background-color: #f9f9f9;
}

.card-title a {
  font-size: 18px;
  font-weight: bold;
}

.card-body small {
  font-size: 12px;
}

.card img {
  height: 100px;
  object-fit: cover;
}

.btn-sm {
  font-size: 12px;
}

/* Community Badge - Smaller Size */
.community-badge {
  font-size: 12px;
  padding: 5px 7px;
  margin-left: 1px;
}

.card-shadow{
    box-shadow: 0.1px 0.1px;
}
/* Tag Badge */
.tag-badge {
  font-size: 12px;
  padding: 5px 7px;
}

/* File Badge */
.file-badge {
  font-size: 12px;
  padding: 5px 7px;
  cursor: pointer;
  margin-left: 8px;
}

/* Expert Votes Styling */

 .expert-vote{
  background-color: rgb(92 230 168 / 27%);
  padding: 5px;
  font-size: 13px;
  font-weight: bold;
  border-radius:5px;
 }

/* Adjust small text */
small {
  font-size: 13px;
}

.topics-badge{
  font-size: 14px;
}
</style>

<div class="container mt-5 pt-5">
<div class="row">

<!-- Main Content -->
<div class="col-md-9">
<?php
    if(isset($_GET['id'])){
      include('../app/core/database.php'); 
      $db = Database::getInstance();
      $community_id = $_GET['id'] ?? 0;
      $community = $db->selectOne('communities',['id'=>$community_id]);
      if(!$community){
          $_SESSION['flash_messages'][]=['type'=>'danger','message'=>'Community not found.'];
          header("Location: communities.php");
          exit();
      } else {
          
          $is_member = false;
          if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user']['id'];
              if($is_member = $db->selectOne('community_members', ['community_id' => $community_id,'user_id' => $user_id])){
                $role = $is_member['role']; }
                else $role = false;
          }
        
          $type = $community['type'];
          $logo = $community['logo'];
          $members_count = $db->count('community_members',['community_id'=>$community_id]);
          $post_count = $db->count('posts',['community'=>$community_id]);
          $posts = $db->select('posts', ['community' => $community_id]);
          $creator = $db->selectOne('users',['id'=>$community['creator_id']]);
          $creator_name = $creator['first']." ".$creator['last']; 
          $experts = $community['experts'];

       }
    } ?>

      <!-- community card -->
      <div class="card mb-4 p-4">
          
        <div class="d-flex justify-content-between align-items-center mb-2">
          <img src="uploads/community-logos/<?=$logo?>" class="img-fluid rounded-start" alt="Community Banner">
          <h2 style="position: sticky;top:70px;"><?= htmlspecialchars($community['name']); ?></h2>
          <div>
            <?php if ($type === 'public'):?>
              <span class='badge bg-success file-badge' title='Public Community (for everyone)'>Public</span>
              <?php elseif ($type === 'private'):?>
                <span class='badge bg-danger file-badge' title='Private Community (Only Members)'>Private</span>
                <?php elseif ($type === 'invite-only'):?>
                  <span class='badge bg-dark file-badge' title='Invite-only Community (Only invited Members)'>Invite-Only</span>
                  <?php endif;?>
                  
            <?php if (isset($_SESSION['user'])): ?>
                <?php if ($role === 'member'):?>
                  <span class='badge bg-secondary file-badge' title='you are a Member'>Member</span>
                  <?php elseif ($role === 'moderator'):?>
                    <span class='badge bg-warning file-badge' title='you are a Moderator'>Moderator</span>
                    <?php elseif ($role === 'admin'):?>
                      <span class='badge bg-primary file-badge' title='you are an Admin'>Admin</span>
                      <?php endif;?>
            <?php endif;?>
              </div>
            
            </div>
          
          <p><span class="text-muted" style="font-size: 18px;"><?= htmlspecialchars($community['description']) ?></span></p>
          <div class="d-flex justify-content-between align-items-center mb-2">
              <div>
                  <span class="text-muted stats">📄 <b><?=$post_count?></b> Posts</span>
                  <span class="px-3 text-muted stats">🎓 <b><?=$experts?></b> Experts</span>
                  <span class="px-3 text-muted stats">👥 <b><?=$members_count?></b> Members </span>
                </div>
               <div>
                 <span class="px-2 text-muted stats">👤 Created By <strong><a class="text-decoration-none" href="user.php?id=<?=$creator['id']?>"><?=$creator_name?></a></strong></span>
                 <span class="px-3 text-muted stats">📅 on <b><?= date('F j, Y', strtotime($community['created_at']));?></b> </span>
                </div>
          </div><br>              
              <?php if (isset($_SESSION['user'])): ?>
                <?php if ($is_member): ?>
                  <div>
                    <a href="../app/leave-community?id=<?=$community_id?>" class="btn btn-sm btn-outline-danger">Leave</a>
                  </div>
                    <?php else: ?>
                      <div>
                        <a href="../app/leave-community?id=<?=$community_id?>" class="btn btn-sm btn-primary">Join</a>
                      </div>
                        <?php endif; ?>
                        <?php endif; ?>


        <!-- end of community card -->
    </div><br>

          <div class="sort-box">
            <!-- Posts in this Community -->
            <div class="d-flex justify-content-between mb-4">
              <h5>📄 Posts in this Community</h5>
              <select id="sortPosts" class="form-select mb-3 w-50">
                <option selected disabled>Sort By</option>
                <option value="newest">Newest First</option>
                <option value="most_upvotes">Most Upvoted</option>
                <option value="most_comments">Most Commented</option>
              </select>
            </div>
          </div>
    
        <?php foreach ($posts as $post){

                    $fileType = strtolower(pathinfo($post['file'],PATHINFO_EXTENSION));
                    $author = $db->selectOne('users',['id'=>$post['user_id']]);
                    $author_id = $author['id'];
                    $author_name = $author['first']." ".$author['last'];
                    $postdate = date('F Y', strtotime($post['created_at']));
                    $tags = $post['tags'];
                    $file = $post['file'];
                    $postimg = $post['postimg'];
                    $title = $post['title'];
                    $postid = $post['id'];
                    $community_name = $community['name'];
                    $description = $post['description'];
                    $comments = $post['comments'];
                    $upvotes = $post['upvotes'];
                    $downvotes = $post['downvotes'];
                    $post_card = <<<POST_CARD
                    <div class="card mb-3 card-shadow">
                    <div class="row g-0">
                    <div class="col-md-3">
                    <img src="uploads/userPosts/$postimg" class="img-fluid rounded-start" alt="Post Image" height='400' width='300'>
                    </div>
                    <!-- Post Content -->
                    <div class="col-md-9">
                    <div class="card-body">

                    <!-- Title and Community Badge -->
                    <div class="d-flex justify-content-between">
                    <h5 class="card-title">
                    <a href="post.php?id=$postid" class="text-dark text-decoration-none">$title</a>
                    </h5>
                    
                    </div>

                    <!-- Tags and File Badge -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                    <small><span class="badge bg-secondary community-badge"><span><b>/</b></span>$community_name</span></small>
                    POST_CARD;

                    $tag = explode(', ',$tags,);

                    foreach($tag as $k => $v){
                    $post_card.="<span class='badge bg-primary tag-badge mx-2'>#$v </span>"; }
                    $post_card.="</div>";

                    if ($fileType === 'pdf'):
                        $post_card.="<span class='badge bg-success file-badge' title='$file'><a class='text-white text-decoration-none' href='uploads/userFiles/$file'>PDF File</a></span>";
                    elseif ($fileType === 'docx'):
                        $post_card.="<span class='badge bg-danger file-badge' title='$file'><a class='text-white text-decoration-none' href='uploads/userFiles/$file'>DOC File</a></span>";
                    elseif ($fileType === 'ppt'):
                        $post_card.="<span class='badge bg-warning text-dark file-badge' title='$file'><a class='text-white text-decoration-none' href='uploads/userFiles/$file'>PPT File</a></span>";
                    elseif ($fileType === 'zip'):
                        $post_card.="<span class='badge bg-dark file-badge' title='$file'><a class='text-white text-decoration-none' href='uploads/userFiles/$file'>ZIP File</a></span>";
                    endif;
                    $post_card.="</div>";
                    $post_card.=<<<POST_CARD
                    <p class="card-text text-muted">$description</p>

                    <div class="d-flex justify-content-between">
                    <small class="text-muted">
                    By <a href="user.php?id=$author_id" class="text-dark"><b>$author_name</b></a><span class="px-3">|</span>
                    💬 <b><a class='text-muted text-decoration-none' href='post.php?id=$postid#comments'>$comments Comments</a></b><span class="px-2">|</span>
                    🗓️ <b>$postdate</b>
                    </small>
                    <div class="">
                    <span class="text-success expert-vote mx-2">✔️ <b>5</b> Expert Votes</span>
                    <button class="btn btn-outline-success btn-sm me-2">▲ $upvotes</button>
                    <button class="btn btn-outline-danger btn-sm">▼ $downvotes</button>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
POST_CARD;

                    
        echo $post_card;

   
}?>
 
 
</div>        
</div>
</div>
<br><br>

<!-- Pagination -->
<nav>
  <ul class="pagination justify-content-center">
    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item active"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
<br>

<?php include('partials/footer.php'); ?>

</body>
</html>