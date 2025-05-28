<?php
require_once 'core/database.php';
session_start();

$db = Database::getInstance();
$user_id = $_SESSION['user_id'] ?? 0;
$request_id = $_POST['request_id'] ?? 0;

if (!$user_id || !$request_id) {
    die("Invalid request.");
}

// Get friend request details
$request = $db->selectOne('friends', ['id' => $request_id, 'user_id' => $user_id, 'status' => 'pending']);

if (!$request) {
    die("Request not found or already accepted.");
}

// Insert into friends table
$db->insert('friends', ['user_id' => $request['sender_id'], 'friend_id' => $user_id]);

// Update friend request status
$db->update('friends', ['status' => 'accepted'], ['id' => $request_id]);

header("Location: ../public/home.php");
exit;
