<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Posts - NoteShare</title>
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php $searchfor = 'Topics, Posts, People, Communities'; ?>
<?php include('partials/navbar.php'); ?>
<?php include('partials/flash.php'); ?>

<!-- Main Content -->
<div class="container mt-5 pt-5">


  <div class="row">

  

    <!-- Left Section (Main Feed) -->
    <div class="col-md-9">

      <!-- Create Post Button for Logged-in Users -->
      <?php if (isset($_SESSION['user'])): ?>
        <div class="d-flex justify-content-between mb-4">
          <h2>Welcome <span class="text-primary"><?= $_SESSION['user']['first']; ?>!</span></h2>
        </div>
        <div>
          <a href="create-post.php" class="px-2 btn btn-primary mb-4">Create a Post</a><hr>
          </div>
      <?php else: ?>
        <div class="alert alert-info text-center">
          <p>Join the community to create and share notes.</p>
          <a href="login.php" class="btn btn-outline-primary">Login</a>
          <a href="signup.php" class="btn btn-primary ms-2">Sign Up</a>
        </div>
      <?php endif; ?>

      <!-- Top Posts Section -->
      <br>
      <!-- Sort Filter -->
      <div class="d-flex justify-content-between mb-4">
          <h4>🔥 Top Posts</h4>
          <select class="form-select w-25" id="sortPosts">
              <option selected>Sort By</option>
              <option value="most_upvotes">Most Upvotes</option>
              <option value="most_comments">Most Comments</option>
              <option value="most_expert_votes">Most Expert Votes</option>
              <option value="newest">Newest</option>
            </select>
        </div>
        
        <br>


    <br>

    



    <?php include('../app/core/database.php'); 
    $db = Database::getInstance();
    $posts = $db->select('posts');
    foreach($posts as $k =>$v){ 
               
        $fileType = strtolower(pathinfo($v['file'],PATHINFO_EXTENSION));

        $community = $db->select('communities',['id'=>$v['community']]);
        $user = $db->select('users',['id'=>$v['user_id']]);
        $postdate = date('F Y', strtotime($v['created_at']));



        $postimg = $v['postimg'];
        $title = $v['title'];
        $postid = $v['id'];
        $commName = $community[0]['name'];
        $tags = $v['tags'];
        $description = $v['description'];
        $user_id = $v['user_id'];
        $userName = $user[0]['first'].' '.$user[0]['last'];
        $comments = $v['comments'];
        $upvotes = $v['upvotes'];
        $downvotes = $v['downvotes'];
        $file=$v['file'];





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
                    <small><span class="badge bg-secondary community-badge"><span><b>/</b></span>$commName</span></small>
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
                    By <a href="user.php?id=$user_id" class="text-dark"><b>$userName</b></a><span class="px-3">|</span>
                    💬 <b><a class='text-muted text-decoration-none' href='post.php?id=$postid#comments'>$comments Comments</a></b><span class="px-2">|</span>
                    🗓️ <b>$postdate</b>
                    </small>
                    <div class="">
                    <span class="text-success expert-vote mx-2">✔️ <b>5</b> Expert Votes</span>
                    <button class="btn btn-outline-success btn-sm me-2">▲ $upvotes</button>
                    <button class="btn btn-outline-danger btn-sm">▼ $downvotes</button>
                    </div>


                    </div>

                    <!-- Voting System (Below Expert Votes) -->

                    </div>
                    </div>
                    </div>
                    </div>
POST_CARD;

                    
echo $post_card;

   
}?>









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





</div>
<!-- end of  trending posts -->

    
    <!-- Right Sidebar -->
    <div class="col-md-3">

    <div class="user-sidebar">

      <!-- Trending Topics -->
      <h5>🔥 Trending Topics</h5><p></p>
      <div class="d-flex flex-wrap mb-4">
        <span class="badge bg-primary m-1 topics-badge">#PHP</span>
        <span class="badge bg-secondary m-1 topics-badge">#MySQL</span>
        <span class="badge bg-success m-1 topics-badge">#Backend</span>
        <span class="badge bg-danger m-1 topics-badge">#AI</span>
        <span class="badge bg-warning text-dark m-1 topics-badge">#DataScience</span>
        <span class="badge bg-info m-1 topics-badge">#Laravel</span>
      </div>
      <p></p><hr>

      <!-- Trending Posts -->
      <h5>🔥 Trending Posts</h5><p></p>
      <ul class="list-group mb-4">
        <li class="list-group-item"><span><b>▲ 75  </b></span>Building a Voting System in PHP</li>
        <li class="list-group-item"><span><b>▲ 58  </b></span>Core PHP MVC Explained</li>
        <li class="list-group-item"><span><b>▲ 50  </b></span>MySQL Indexing Tips</li>
      </ul>
      <p></p><hr>

      <!-- Trending Communities -->
      <h5>📚 Trending Communities</h5><p></p>
      <ul class="list-group">
        <li class="list-group-item"><a href="" style="font-size:20px;"><b>/</b>Developers</a>  [<span><b>1250</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Java Developers</a>  [<span><b>1145</b></span> Members]</li> 
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Machine Learning</a>  [<span><b>987</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Data Science</a>  [<span><b>874</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Mathematics</a>  [<span><b>576</b></span> Members]</li>
      </ul>

    </div>

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
