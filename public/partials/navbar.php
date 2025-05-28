<?php session_start();
include('partials/flash.php');


// auto logout disabled while development

// Auto logout after inactivity (15 minutes)
// $timeout_duration = 300; // 900 seconds = 15 minutes

// if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
//     session_unset();
//     session_destroy();
//     $_SESSION['flash_message'] = ['type' => 'warning', 'message' => 'Session expired. Please log in again.'];
//     header("Location: login.php");
//     exit();
// }
// $_SESSION['last_activity'] = time(); // Reset timestamp on activity

?>
  <!-- <div id="logoutWarning" class="modal" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); -->
  <!-- background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); text-align: center;"> -->
    <!-- <h5>Your session is about to expire</h5> -->
    <!-- <p>You will be logged out in <span id="countdown">60</span> seconds.</p> -->
    <!-- <button onclick="resetTimers(); document.getElementById('logoutWarning').style.display='none';" class="btn btn-primary">Stay Logged In</button> -->
  <!-- </div> -->


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="/home.php">NoteShare</a>
    <ul class="navbar-nav mx-auto">
      <li class="nav-item"><a class="nav-link btn btn-outline-success" href="home.php">Home</a></li>
      <li class="nav-item"><a class="nav-link btn btn-outline-success" href="posts.php">Top Posts</a></li>
      <li class="nav-item"><a class="nav-link btn btn-outline-success" href="communities.php">Communities</a></li>
      <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-item"><a class="nav-link btn btn-outline-success" href="profile.php#posts">My Posts</a></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-success" href="people.php">Friends</a></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-success" href="profile.php">Profile</a></li>
      <?php endif; ?>
    </ul>
<!-- Search Input Without Button -->
<input type="text" class="form-control w-25 me-3" placeholder="Search <?php echo $searchfor ?>...">


    <!-- User Dropdown -->
    <?php if (isset($_SESSION['user'])): ?>
      <div class="dropdown">
        <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?= $_SESSION['user']['username']; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="../app/logout.php">Logout</a></li>
        </ul>
      </div>
    <?php else: ?>
      <a href="login.php" class="btn btn-outline-light me-2">Login</a>
      <a href="signup.php" class="btn btn-primary">Sign Up</a>
    <?php endif; ?>
  </div>
</nav>




<!-- autologout script -->

<!-- <script>
  let timeoutDuration = 180000; // 15 minutes in milliseconds
  let warningDuration = 60000; // 2 minutes in milliseconds

  // let timeoutDuration = 900000; // 15 minutes in milliseconds
  // let warningDuration = 120000; // 2 minutes in milliseconds
  let logoutTimer, warningTimer;

  function resetTimers() {
    clearTimeout(logoutTimer);
    clearTimeout(warningTimer);

    warningTimer = setTimeout(showWarning, timeoutDuration - warningDuration);
    logoutTimer = setTimeout(autoLogout, timeoutDuration);
  }

  function showWarning() {
    document.getElementById('logoutWarning').style.display = 'block';
    startCountdown(5); // 120 seconds
  }

  function autoLogout() {
    window.location.href = "logout.php";
  }

  function startCountdown(seconds) {
    let counter = seconds;
    let countdownDisplay = document.getElementById('countdown');

    let countdownInterval = setInterval(() => {
      countdownDisplay.innerText = counter;
      counter--;

      if (counter < 0) {
        clearInterval(countdownInterval);
      }
    }, 1000);
  }

  document.addEventListener("mousemove", resetTimers);
  document.addEventListener("keydown", resetTimers);

  window.onload = resetTimers;
</script> -->

