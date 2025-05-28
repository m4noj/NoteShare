<?php
require_once 'core/database.php';
session_start();

$db = Database::getInstance();
$user_id = $_SESSION['user_id'] ?? 0;
$receiver_id = $_POST['receiver_id'] ?? 0;

if (!$user_id || !$receiver_id || $user_id == $receiver_id) {
    die("Invalid request.");
}

// Check if a request already exists
$existing = $db->query("SELECT * FROM friends WHERE user_id = ? AND friend_id = ? AND status = 'pending'", [$user_id, $receiver_id]);

if ($existing) {
    die("Friend request already sent.");
}

// Insert new friend request
$db->insert('friends', ['user_id' => $user_id, 'friend_id' => $receiver_id]);

header("Location: ../public/home.php?success=Request sent");
exit;