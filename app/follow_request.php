<?php
require_once 'core/database.php';
session_start();

$db = Database::getInstance();
$user_id = $_SESSION['user_id'] ?? 0;
$expert_id = $_POST['expert_id'] ?? 0;

if (!$user_id || !$expert_id) {
    die("Invalid request.");
}

// Check if follow request already exists
$existing = $db->query("SELECT * FROM follow_requests WHERE follower_id = ? AND expert_id = ? AND status = 'pending'", [$user_id, $expert_id]);

if ($existing) {
    die("Follow request already sent.");
}

// Insert new follow request
$db->insert('follow_requests', ['follower_id' => $user_id, 'expert_id' => $expert_id]);

header("Location: ../public.experts.php?success=Request sent");
exit;