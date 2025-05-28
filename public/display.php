<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Communities - NoteShare</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script defer src="ajax-join-leave.js"></script>
</head>

<body>

<!-- Navbar -->
<?php include('partials/navbar.php'); ?>

<div class="container mt-5 pt-5">

  <h2 class="mb-4">Explore Communities</h2>

  <!-- Loop through all communities -->
  <?php foreach ($communities as $community): ?>
  <div class="card mb-3">
    <div class="card-body">
      <h5 class="card-title"><?= htmlspecialchars($community['name']); ?></h5>
      <p class="card-text"><?= htmlspecialchars($community['description']); ?></p>
      <span class="text-muted"><?= ucfirst($community['visibility']); ?> Community</span>
      <?php if (isset($_SESSION['user'])): ?>
        <!-- Join/Leave Button -->
        <button class="btn btn-sm 
          <?= in_array($community['id'], $joinedCommunityIds) ? 'btn-outline-secondary' : 'btn-outline-primary'; ?>" 
          onclick="handleJoinLeave(<?= $community['id']; ?>)">
          <?= in_array($community['id'], $joinedCommunityIds) ? 'Joined' : 'Join'; ?>
        </button>
      <?php endif; ?>
    </div>
  </div>
  <?php endforeach; ?>

</div>

<?php include('partials/footer.php'); ?>

</body>
</html>