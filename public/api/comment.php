<?php session_start(); 
require_once('../../app/core/database.php');

header('Content-Type: application/json');

$db = Database::getInstance();

$user_id = $_SESSION['user']['id'];

if($_POST['post_id'] && $_POST['comment']){
    $db->insert('comments',['post_id'=>$_POST['id'],'user_id'=>$user_id,'comment'=>$_POST['comment']]);
    $_SESSION['flash_messages'][]=['type'=>'success','message'=>'comment added!'];
}

echo json_encode(['status'=>'success','message'=>'comment added!']);











?>