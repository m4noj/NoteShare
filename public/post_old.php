<?php
session_start();
require_once '../app/core/Database.php';

$post_id = $_GET['id'] ?? null;
$db = Database::getInstance();

// Fetch post details
$post = $db->selectOne('posts', ['id' => $post_id]);
if (!$post) {
    die("Post not found.");
}

// Fetch comments
$comments = $db->select('comments', ['post_id' => $post_id], 'ORDER BY created_at DESC');

// Check if post is saved
$is_saved = false;
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $is_saved = $db->selectOne('saved_posts', [
        'post_id' => $post_id,
        'user_id' => $user_id
    ]);
}
?>

<?php include('../partials/navbar.php'); ?>

<div class="container mt-5 pt-5">
  <div class="row">
    <!-- Main Post Content -->
    <div class="col-md-8">
      <h2><?= htmlspecialchars($post['title']) ?></h2>
      <p class="text-muted"><?= htmlspecialchars($post['description']) ?></p>
      <img src="/uploads/posts/<?= $post['thumbnail'] ?>" class="img-fluid mb-4">

      <p>📅 <?= date('F j, Y', strtotime($post['created_at'])) ?> | 💬 <?= $post['comment_count'] ?> Comments | 👍 <?= $post['upvotes'] ?> Upvotes | ❌ <?= $post['downvotes'] ?></p>
      <span class="badge bg-info"><?= $post['community'] ?></span>
      <span class="badge bg-secondary"><?= $post['tag'] ?></span>

      <!-- Upvote/Downvote Buttons -->
      <?php if (isset($_SESSION['user'])): ?>
        <a href="/app/upvote.php?post_id=<?= $post_id ?>" class="btn btn-outline-success btn-sm">👍 Upvote</a>
        <a href="/app/downvote.php?post_id=<?= $post_id ?>" class="btn btn-outline-danger btn-sm">❌ Downvote</a>
        <?php if ($is_saved): ?>
          <a href="/app/save-post.php?post_id=<?= $post_id ?>&action=remove" class="btn btn-outline-warning btn-sm">Remove from Saved</a>
        <?php else: ?>
          <a href="/app/save-post.php?post_id=<?= $post_id ?>&action=save" class="btn btn-outline-primary btn-sm">Save for Later</a>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Comment Form -->
      <h5 class="mt-4">💬 Comments</h5>
      <?php if (isset($_SESSION['user'])): ?>
        <form method="POST" action="/app/comment.php">
          <input type="hidden" name="post_id" value="<?= $post_id ?>">
          <textarea name="comment" class="form-control mb-3" placeholder="Add a comment..." required></textarea>
          <button class="btn btn-primary btn-sm" type="submit">Comment</button>
        </form>
      <?php else: ?>
        <p class="text-muted">Log in to comment.</p>
      <?php endif; ?>

      <!-- Show Comments -->
      <hr>
      <?php foreach ($comments as $comment): ?>
        <div class="mb-3">
          <strong><?= htmlspecialchars($comment['username']) ?></strong>
          <p><?= htmlspecialchars($comment['content']) ?></p>
          <small class="text-muted"><?= date('F j, Y H:i', strtotime($comment['created_at'])) ?></small>
        </div>
        <hr>
      <?php endforeach; ?>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
      <?php include('../partials/post-sidebar.php'); ?>
    </div>
  </div>
</div>