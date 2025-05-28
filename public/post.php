<?php 
    if(!isset($_GET['id'])){ 
        header("Location: posts.php"); 
        exit();
    } else {
        include('../app/core/database.php'); 
        $db = Database::getInstance();
        $post_id = $_GET['id'] ?? 0;
        $post = $db->selectOne('posts',['id'=>$post_id]);

        if(!$post){
            $_SESSION['flash_messages'][]=['type'=>'danger','message'=>'Post not found.'];
            header("Location: posts.php");
            exit();
        } else {
            $fileType = strtolower(pathinfo($post['file'],PATHINFO_EXTENSION));
            
            $community = $db->selectOne('communities',['id'=>$post['community']]);
            
            $user = $db->selectOne('users',['id'=>$post['user_id']]);
            
            $postdate = date('F Y', strtotime($post['created_at']));
            
        }
} ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post - Home</title>
    <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php $searchfor = 'Topics, Posts, People, Communities'; ?>
<?php include('partials/navbar.php'); ?>
<?php include('partials/flash.php'); ?>

<style>

.user-sidebar {
        position: sticky;
        top: 50px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
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

.post-content {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 20px;

}
.expert-vote{
  background-color: rgb(92 230 168 / 27%);
  padding: 5px;
  font-size: 13px;
  font-weight: bold;
  border-radius:5px;
 }


</style>











<!-- Main Content -->
<div class="container mt-5 pt-5">
<div class="row">









    <!-- Left Section (Main Feed) -->
    <div class="col-md-9">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-2" style="position: sticky;top:50px;background-color:#fff;">
                <h1 class="post-title mb-3"><?= $post['title'];?></h1>
                <?php if(isset($_SESSION['user'])): ?>
                <button class="btn btn-outline-primary btn-sm">💾 Save Post</button>
                <?php endif;?>
        </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <span class="text-muted">by <a class="text-decoration-none" href="user.php?id=<?=$user['id']?>"><?= $user['first'].' '.$user['last'];?></a><span class="px-2">|</span>
                        <span class="text-muted">Posted in <a class="badge bg-secondary community-badge text-decoration-none" href="community.php?id=<?=$community['id']?>"><span><b>/</b></span><?=$community['name'];?></a></span>
                        <span class="text-muted mx-2">on <span class="text-dark"><?=date('F j, Y', strtotime($post['created_at']))?></span></span>
                    </div>    
                    <div>
                        <?php
                            $tag = explode(', ',$post['tags']);
                                foreach($tag as $k => $v){
                                echo "<span class='badge bg-primary tag-badge mx-2'>#$v </span>"; } ?>
                        <?php if ($fileType === 'pdf'):?>
                            <span class='badge bg-success file-badge' title='lamp_stack_guide.pdf'><a class="text-white text-decoration-none" href="uploads/userFiles/<?=$post['file'];?>">PDF File</a></span>
                        <?php elseif ($fileType === 'docx'):?>
                            <span class='badge bg-danger file-badge' title='php_mvc_tutorial.docx'><a class="text-white text-decoration-none" href="uploads/userFiles/<?=$post['file'];?>">DOC File</a></span>
                        <?php elseif ($fileType === 'ppt'):?>
                            <span class='badge bg-warning text-dark file-badge' title='presentation.pptx'><a class="text-white text-decoration-none" href="uploads/userFiles/<?=$post['file'];?>">PPT File</a></span>
                        <?php elseif ($fileType === 'zip'):?>
                        <span class='badge bg-dark file-badge' title='project_files.zip'><a class="text-white text-decoration-none" href="uploads/userFiles/<?=$post['file'];?>">ZIP File</a></span>
                        <?php endif;?>
                    </div>
                </div>
                <p></p>
                <div class="d-flex justify-content-between align-items-center mb-2 gap-3">
                    <div>
                        <span class='text-muted'>💬 <b><?=$post['comments']?></b> Comments</span>
                    </div>
                    <div>
                    <span class="text-success expert-vote">✔️ <b>5</b> Expert Votes</span>
                    </div>
                    <div>

                        <button class="btn btn-outline-success btn-sm me-2">▲ <?=$post['upvotes']?></button>
                        <button class="btn btn-outline-danger btn-sm">▼ <?=$post['downvotes']?></button>
                    </div>
                </div>

                
                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <img src="uploads/userPosts/<?=$post['postimg']?>" class="img-fluid mt-3 mb-3 rounded" height="300" width="300">
                </div>

                <p class="post-content"><?=$post['content']?><br></p>

                
    </div>

    


            <!-- Comments Section -->
            <div class="card p-4 mt-4" id="comments">
                <?php if(isset($_SESSION['user'])):?>
                <div>
                    <h5>Add a Comment..</h5><p></p>
                    <!-- <form action="" method="post"> -->
                        <form action="" method="post">
                            <input type="hidden" name="post_id" value="<?= $post_id ?>">
                            <textarea name="comment" class="form-control mb-3" placeholder="what are your thoughts on this?" required rows="3" id="comment-text"></textarea>
                            <button class="btn btn-primary btn-sm" type="submit">Post Comment</button>
                        </form>
                        <div>
                        <!-- </form> -->
                    </div>
                    <p></p>
                    <hr>
                </div>
                <?php endif;?>


                <h5>💬 10 Comments</h5><br>

                <!-- comment 1 -->
                <div class="mt-3">
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="uploads/avatars/default-avatar.jpg" class="rounded-circle me-3" width="60" height="60">
                        </div>
                        <div>
                            <strong>John Doe <small class="text-muted">(@johnDoe)</small></strong>
                            <p>
                                <small style="font-size: 16px;">Great post! Learned a lot about routing and controllers.</small><br>

                                <small class="text-muted">March 12, 2024</small>
                                <!-- <a class="text-muted px-2" href=""> 0 Likes</a> -->
                                <a class="text-primary px-2" href="">Like</a>
                            </p>
                        </div>
                    </div>
                 </div>

                 <!-- comment 2 -->
                <div class="mt-3">
                    <div class="d-flex align-items-center">
                        <div>
                            <img src="uploads/avatars/default-avatar.jpg" class="rounded-circle me-3" width="60" height="60">
                        </div>
                        <div>
                            <strong>John Doe <small class="text-muted">(@johnDoe)</small></strong>
                            <p>
                                <small style="font-size: 16px;">Great post! Learned a lot about routing and controllers.</small><br>

                                <small class="text-muted">March 12, 2024</small>
                                <!-- <a class="text-muted px-2" href=""> 0 Likes</a> -->
                                <a class="text-primary px-2" href="">Like</a>
                            </p>
                        </div>
                    </div>
                 </div>






            <!-- end of comment section -->
            </div>














      













    </div> <!-- end of  left (Main feed) -->



<!-- ajax for comment -->
<script>

function submitComment(postID,userID){

    const comment = document.getElementById('comment-text').value.trim();
    if(!comment) return;


    fetch('api/comment.php',{

        method:'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body:'post_id=${postID}&user_id${userID}&comment=${encodeURIComponent(comment)}'}).then(response=>Response.json()).then(data=>{
            if(data.status==='success') location.reload();  
        });
        
        

    }

</script>



    





















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
        <li class="list-group-item"><a href="" style="font-size:19px;"><b>/</b>Developers</a>  [<span><b>1250</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Java Developers</a>  [<span><b>1145</b></span> Members]</li> 
        <li class="list-group-item"><a href=""style="font-size:19px";><b>/</b>Machine Learning</a>  [<span><b>987</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Data Science</a>  [<span><b>874</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Mathematics</a>  [<span><b>576</b></span> Members]</li>
      </ul>

    </div>





    </div> <!-- end of right sidebar -->






  </div> <!-- end of row -->

</div><!-- end of main container -->
<br><br><br>


 <!-- Pagination -->
        <!-- <nav>
                <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
        </nav> -->
<br>

<?php include('partials/footer.php'); ?>

</body>
</html>