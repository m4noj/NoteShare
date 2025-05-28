<?php
session_start();
require_once '../app/core/Database.php';

$db = Database::getInstance();
$posts = $db->select('posts', [], 'ORDER BY created_at DESC');
?>

<?php include('../partials/navbar.php'); ?>

<div class="container mt-5 pt-5">
  <h3>📄 All Posts</h3>
  <select id="sortPosts" class="form-select mb-3 w-50">
    <option value="newest" selected>Newest First</option>
    <option value="most_upvotes">Most Upvoted</option>
    <option value="most_comments">Most Commented</option>
  </select>

  <?php foreach ($posts as $post): ?>
    <div class="card mb-3 p-3">
      <h5><a href="/posts/post.php?id=<?= $post['id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($post['title']) ?></a></h5>
      <p><?= htmlspecialchars($post['short_description']) ?></p>
      <small>🗓️ <?= date('F j, Y', strtotime($post['created_at'])) ?> | 💬 <?= $post['comment_count'] ?> | 👍 <?= $post['upvotes'] ?></small>
      <div>
        <span class="badge bg-info"><?= $post['community'] ?></span>
        <span class="badge bg-secondary"><?= $post['tag'] ?></span>
        <?php if (isset($_SESSION['user'])): ?>
          <a href="/app/save-post.php?post_id=<?= $post['id'] ?>" class="btn btn-outline-primary btn-sm">Save for Later</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>