<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteShare - Home</title>
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
    <div class="col-md-8">















    
      

    </div> <!-- end of  left (Main feed) -->







    









    <!-- Right Sidebar -->
    <div class="col-md-4">

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

    </div> <!-- end of right sidebar -->

  </div> <!-- end of row -->

</div><!-- end of main container -->
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
