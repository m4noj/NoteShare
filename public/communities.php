<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Communities - NoteShare</title>
  <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<?php $searchfor = 'Communities';?>

<?php include('partials/navbar.php'); ?>



<!-- Main Content -->
<div class="container mt-5 pt-5">
  <div class="row">

    <!-- Left Section: Community List -->
    <div class="col-md-8">

      <!-- Create Community Button -->
      <div class="d-flex justify-content-between mb-4">
        <h4>📚 Explore Communities</h4>
        <?php if(isset($_SESSION['user'])):?>
        <a href="create-community.php" class="btn btn-primary btn-sm">+ Create Community</a>
        <?php endif;?>
      </div>

      <!-- Sort Filter -->
    <div class="d-flex justify-content-between mb-4">
      <select class="form-select w-25" id="sortCommunities">
      <option selected>Sort By</option>
      <option value="most_active">Most Active</option>
      <option value="most_members">Most Members</option>
      <option value="most_experts">Most Experts</option>
      <option value="newest">Newest</option>
    </select>
  </div>

  <?php include('../app/core/database.php'); 
    $db = Database::getInstance();
    $communities = $db->select('communities');
    foreach($communities as $k =>$v){ 
        $date = date('F Y', strtotime($v['created_at']));
        $logo = $v['logo'];
        $name = $v['name'];
        $id = $v['id'];
        $description = $v['description'];
        $type = $v['type'];
        
        $members_count = $db->count('community_members',['community_id'=>$id]);
        if($members_count==1){ $string_member_count = 'Member';} else {$string_member_count = 'Members';}
        $posts_count = $db->count('posts',['community'=>$id]);
        $experts_count = $v['experts'];



       $card = <<<CARD
              <!-- Community Card 1 -->
              <div class="card mb-3">
              <div class="row g-0">

              <!-- Community Thumbnail -->
              <div class="col-md-3">
              <img src="uploads/community-logos/$logo" class="img-fluid rounded-start" alt="Community Banner">
              </div>

              <!-- Community Info -->
              <div class="col-md-8">
              <div class="card-body">

              <!-- Community Name & Tags -->
              <div class="d-flex justify-content-between align-items-center mb-2">
              <h5 class="card-title">
              <a href="community.php?id=$id" class="text-dark text-decoration-none">$name</a>
              </h5>
              CARD;


              if ($type === 'public'):
                $card.="<span class='badge bg-success file-badge' title='Public Community (for everyone)'>$type</span>";
              elseif ($type === 'private'):
                  $card.="<span class='badge bg-danger file-badge' title='Private Community (Only Members)'>$type</span>";
              elseif ($type === 'invite-only'):
                  $card.="<span class='badge bg-dark file-badge' title='Invite-only Community (Only invited Members)'>$type</span>";
              endif;

                   
        $card .= <<<CARD
              </div>
              <p class='card-text text-muted'>$description</p>
                    <div class='d-flex justify-content-between align-items-center mb-3'>
                      <small class=''>
                      <span class='text-dark community-stats'>👥 $members_count $string_member_count</span>
                      <span class='text-dark community-stats mx-2'>📝 $posts_count Posts</span>
                      <span class='text-success community-stats mx-2'>🎓 $experts_count Experts</span>
                      <span class='community-stats mx-2 text-dark'>📅 $date</span>
                      </small>
                    </div>
        CARD;


        if(isset($_SESSION['user'])){
          if($is_member = $db->selectOne('community_members',['user_id'=>$_SESSION['user']['id'],'community_id'=>$id])){
            $role= $is_member['role'];
          }

        if(!$is_member){


        $card.="
        <div class='mt-3'>
        <button class='btn btn-outline-primary btn-sm'>Join</button>
        </div>";
        
      } else{

        if ($role === 'member'):
          $card.="<span class='badge bg-secondary file-badge' title='Member'>Member</span>";
        elseif ($role === 'moderator'):
            $card.="<span class='badge bg-warning file-badge' title='Moderator'>Moderator</span>";
        elseif ($role === 'admin'):
            $card.="<span class='badge bg-primary file-badge' title='Admin'>Admin</span>";
        endif;


        // $card.="
        // <div class='mt-3'>
        // <span class='badge bg-success btn-sm'>$role</span>
        // </div>";
        
          
        }
        }

        $card.="
        </div>
        </div>
        </div>
        </div>";


    echo $card;
          
          
          
          
          
          
  }
          ?>
  
  
          <!--end of left seciton col-md -->
          </div>
          
          <!-- Right Sidebar: Trending Communities -->
          <div class="col-md-4">
          <h5>📚 Trending Communities</h5><p></p>
          <ul class="list-group">
          <li class="list-group-item"><a href="" style="font-size:20px;"><b>/</b>Developers</a>  [<span><b>1250</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Java Developers</a>  [<span><b>1145</b></span> Members]</li> 
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Machine Learning</a>  [<span><b>987</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Data Science</a>  [<span><b>874</b></span> Members]</li>
        <li class="list-group-item"><a href=""style="font-size:20px";><b>/</b>Mathematics</a>  [<span><b>576</b></span> Members]</li>
      </ul>
      <br><hr><br>
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>📚 My Communities</h5><span class="badge bg-success m-1 topics-badge">JOINED</span><p></p></div>
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
  <br>
  <br><br>




  
  <!-- Pagination -->
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
          <li class="page-item disabled"><a class="page-link">Previous</a></li>
          <li class="page-item active"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Next</a></li>
        </ul>
      </nav>
      <br>
      <br><br>
      <!-- Footer -->
      <!-- <footer class="bg-dark text-light py-3 mt-5">
  <div class="container text-center">
    <small>&copy; 2025 NoteShare | Privacy Policy | Terms of Service | Contact Us</small>
  </div>
</footer> -->
<?php include('partials/footer.php'); ?>

<style>
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
.community-stats {
  font-weight: bold;
  font-size: 13px;
  background-color: #e9ffe5;
  padding: 4px 8px;
  border-radius: 8px;
}
</style>

</body>
</html>