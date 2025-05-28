<?php session_start(); if(!isset($_SESSION['user'])){ header("Location: login.php"); exit();}?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - NoteShare</title>
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
<?php require_once '../app/core/Database.php';?>
<?php
$user_id = $_SESSION['user']['id'];
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
              <h2><?php echo $user['first'].' '.$user['last'];?><?php if (($user_id)===isset($_SESSION['user']['id'])): ?><span class="text-muted"> (me)</span><?php endif;?></h2>
              <h5><span class="text-secondary">@</span><?= htmlspecialchars($user['username']) ?></h5>
              
              <small class="badge bg-secondary text-white" style="font-size: 12px;"><?= htmlspecialchars($user['role']); ?></small>
              <hr>

                <blockquote class="blockquote">
                    <p class="text-dark"><?= htmlspecialchars($user['bio'] ?? 'No bio added') ?></p>
              </blockquote>
              <p class="text-dark"><b>Email</b>  <?= htmlspecialchars($user['email']); ?></p>
              <p><b>Joined</b> <?= date('F Y', strtotime($user['joined'])) ?></p>
              
              <?php if ($_SESSION['user']['id'] === $user_id): ?>
                <a href="profile_edit.php" class="btn btn-primary btn-sm">Edit Profile</a>
              <?php endif; ?>
            </div>





          </div>

    
    <script>

  function showSection(sectionId, btn) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
      section.classList.remove('active');
    });
    
    // communities button need to fix.

    // Show the selected section
    document.getElementById(sectionId).classList.add('active');
    
    // Remove active class from all buttons
    document.querySelectorAll('.section-buttons button').forEach(button => {
      button.classList.remove('active');
    });
    
    
    // Add active class to the clicked button
    btn.classList.add('active');
  }


  showSection('posts',document.getElementById('btnpost'));



</script>




      <!-- Right Section: Section Buttons & Scrollable Content -->
      <div class="col-md-8">
        <!-- Fixed Buttons for Switching Sections -->
       
        <h3 class="text-secondary">Overview</h3>
        <div class="section-buttons mb-3">

        <button class="btn btn-outline-primary active" onclick="showSection('posts', this)" id="btnpost"><?php if ($_SESSION['user']['id'] === $user_id): ?>My<?php endif;?> Posts</button>
        <button class="btn btn-outline-primary" onclick="showSection('comments', this)"><?php if ($_SESSION['user']['id'] === $user_id): ?>My<?php endif;?> Comments</button>
        <!-- <button class="btn btn-outline-primary" onclick="showSection('communities', this)">< ?php if ($_SESSION['user']['id'] === $user_id): ?>My< ?php endif;?> Communities</button> -->
          <button class="btn btn-outline-primary" onclick="showSection('friends', this)"><?php if ($_SESSION['user']['id'] === $user_id): ?>My<?php endif;?> Friends</button>
            <button class="btn btn-outline-primary" onclick="showSection('stats', this)"><?php if ($_SESSION['user']['id'] === $user_id): ?>My<?php endif;?> Reputation</button>




      </div>

      <hr>






      <!-- Scrollable Content -->
      <div class="profile-content">

<!-- My Posts Section -->
<div class="content-section active" id="posts">
  <p></p>
        <?php
              $posts = $db->select('posts',['user_id'=>$user_id]);
              
          foreach($posts as $post){

            $post_id = $post['id'];
            $post_title = $post['title'];
            $post_community = $db->selectOne('communities',['id'=>$post['community']])['name'];
            $post_date = date('F j, Y',strtotime($post['created_at']));
            $post_upvotes = $post['upvotes'];
            $post_downvotes = $post['downvotes'];
            $post_comments = $post['comments'];
            $post_img  = $post['postimg'];




$post_card = <<<POSTS
          <div class="card mb-3 p-3">
          <div class="d-flex justify-content-between mb-3">
          <div>
          <img src="uploads/pic1.jpg" height="50" width="50">
          <a href="post.php?id=$post_id" class="text-dark text-decoration-none">$post_title</a>
          </div>
            <small><span class="badge bg-secondary community-badge"><span><b>/</b></span>$post_community</span></small>
          </div>
          <div class="d-flex justify-content-between">
            <small class="text-muted">
              <span>🗓️ $post_date</span> <span class="px-2">|</span>
              <span>👍 $post_upvotes Upvotes</span><span class="px-2">|</span>
              <span>💬 $post_comments Comments</span>
            </small>
            <span class="text-success expert-vote">✔️ <b>5</b> Expert Votes</span>
            <a href="app/delete_post.php?id=$post_id" class="btn btn-outline-danger text-decoration-none" style="font-size: 10px;">delete post</a> 
          </div>
          </div> 
POSTS;

echo $post_card;
  }

?>


          

          <!-- end of posts -->
        </div>



          <div class="content-section" id="comments">
            <p></p>

            <?php
                $comments = $db->select('comments',['user_id'=>$user_id]);
                
            foreach($comments as $comment){
              
              $comment_post_id = $comment['post_id'];
              $comment_post_title = $db->selectOne('posts',['id'=>$comment_post_id])['title'];
              $comment_id = $comment['id'];
              $comment_date = date('F j, Y',strtotime($comment['created_at']));
              $comment_likes = $comment['likes'];
              $comment_content = $comment['comment'];




  $comment_card = <<<COMMENTS
  <div class="card mb-3 p-3">
  <div class="d-flex justify-content-between mb-2">
    <a href="post.php?id="$comment_post_id#comments_$comment_id" class="text-dark text-decoration-none">$comment_content</a>
    <a href="../app/delete_comment.php?id=$comment_id" class="btn btn-outline-danger text-decoration-none" style="font-size: 10px;">X</a> 
  </div>
  <div class="d-flex justify-content-between">
    <small class="text-muted">
      On <a href="/posts/post.php?id=$comment_post_id" class="text-dark text-decoration-none">$comment_post_title</a><span class="px-2">|</span>
      <span>🗓️ $comment_date</span> <span class="px-2">|</span>
    <span>👍 $comment_likes</span>
  </small>
  </div>
  </div> 
  COMMENTS;

  echo $comment_card;
    }

  ?>

          
         
      <!-- end of comments -->
        </div>
          
          



        <div class="content-section" id="communities">
          <!-- <h5>📄 My Posts</h5> -->
          <p></p>

            <?php
                $member_communities = $db->select('community_members',['user_id'=>$user_id]);
                
              foreach($member_communities as $community){
              
                $community_id = $community['id'];
                $community_role = $community['role'];
                $date_joined = date('F j, Y',strtotime($community['joined_at']));
                $community_member_count = $db->count('community_members',['community_id'=>$community_id]);

                $community_data = $db->selectOne('communities',['id'=>$community_id]);
                $community_title = $community_data['name'];
                $experts = $community_data['experts'];
                

              $comm_card = <<<CMNT
                <div class="card mb-3 p-3">
                <div class="d-flex justify-content-between mb-2">
                <a href="community.php?id=$community_id" class="badge bg-secondary community-badge text-white text-decoration-none" style="font-size: 15px;"><b>/</b>$community_title</a>
                CMNT;
                if($community_role==='member'):
                  $comm_card.="<small><span class='badge bg-success' style='font-size:12px;'><span></span>Member</span></small>";
                  elseif($community_role==='moderator'):
                    $comm_card.="<small><span class='badge bg-warning' style='font-size:12px;''><span></span>Moderator</span></small>";
                  elseif($community_role==='admin'):
                    $comm_card.="<small><span class='badge bg-primary' style='font-size:12px;'><span></span>Admin</span></small>";
                  endif;
                  $comm_card.="</div>";
            

                  $comm_card.=<<<CMNT
                  <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">
                      <span>🗓️ $date_joined</span> <span class="px-2">|</span>
                      <span>👍 $community_member_count Members</span><span class="px-2">|</span>
                      <span>💬 $experts Experts</span>
                    </small>
                    <a href="../app/leave_community?id=$community_id"><span class="badge bg-danger text-decoration-none"><span></span>Leave?</span></a>          
                </div>
                  </div>
          CMNT;

          echo $comm_card;
            }




  ?>
        </div>
















        
        <div class="content-section" id="friends">
          <!-- <h5>📄 My Posts</h5> -->
          <p></p>

          <div class="card mb-3 p-3">
          <div class="d-flex justify-content-between mb-2">
            <div>
                <img src="public/uploads/pic(1).jpg" alt="" srcset="" height="50px" width="50px">
                <a href="/posts/post.php?id=2" class="text-dark text-decoration-none" style="font-size: 17px;"> John Doe</a>
            </div>
            <span class="" style="font-size:20px;">✔️</span>        
          </div>
          <div class="d-flex justify-content-between">
            <small class="text-muted">
              <span>🗓️ <i>Friends Since,</i> March, 2025</span> <span class="px-2">|</span>
              <span>💬 Message</span><span class="px-2"></span>
            </small>
            <a class="btn btn-outline-danger" style="font-size: 13px;">X</a>
        </div>
          </div>
          <div class="card mb-3 p-3">
          <div class="d-flex justify-content-between mb-2">
            <div>
                <img src="public/uploads/pic(1).jpg" alt="" srcset="" height="50px" width="50px">
                <a href="/posts/post.php?id=2" class="text-dark text-decoration-none" style="font-size: 17px;"> John Doe</a>
            </div>
            <span class="" style="font-size:20px;">✔️</span>        
          </div>
          <div class="d-flex justify-content-between">
            <small class="text-muted">
              <span>🗓️ <i>Friends Since,</i> March, 2025</span> <span class="px-2">|</span>
              <span>💬 Message</span><span class="px-2"></span>
            </small>
            <a class="btn btn-outline-danger" style="font-size: 13px;">X</a>
        </div>
          </div>
          <div class="card mb-3 p-3">
          <div class="d-flex justify-content-between mb-2">
            <div>
                <img src="public/uploads/pic(1).jpg" alt="" srcset="" height="50px" width="50px">
                <a href="/posts/post.php?id=2" class="text-dark text-decoration-none" style="font-size: 17px;"> John Doe</a>
            </div>
            <span class="" style="font-size:20px;">✔️</span>        
          </div>
          <div class="d-flex justify-content-between">
            <small class="text-muted">
              <span>🗓️ <i>Friends Since,</i> March, 2025</span> <span class="px-2">|</span>
              <span>💬 Message</span><span class="px-2"></span>
            </small>
            <a class="btn btn-outline-danger" style="font-size: 13px;">X</a>
        </div>
          </div>
          
          

          
          <!-- end of friends  -->
          </div>
          
          

          

        <div class="content-section" id="stats">
          <p></p>

          <div class="card mb-3 p-3">
          <div class="d-flex justify-content-between mb-2">
            <h5><b>👍 Upvotes : <span>100 </span></b></h5>
          </div>
          <div class="d-flex justify-content-between">
            <small class="text-muted">
            <span class="ml-5">Gained +20</span>
            <span class="px-2">|</span>
            <span>Lost -5</span>
          </small>
        </div>
          </div>

          <div class="card mb-3 p-3">
          <div class="d-flex justify-content-between mb-2">
            <h5><b>🌟 Points : <span>100</span></b></h5>
          </div>
          <div class="d-flex justify-content-between">
            <small class="text-muted">
            <span class="ml-5">Gained +20</span>
            <span class="px-2">|</span>
            <span>Lost -5</span>
          </small>
        </div>
          </div> 
          
          
          

          
        <!-- end of stats -->
        </div>
        
       
        
      </div>

    </div>
  </div>
</div>












</body>
</html>
