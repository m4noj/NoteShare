<?php include('../app/core/database.php');


$db = Database::getInstance();

$post = $db->selectOne('posts',['id'=>1]);

$user = $db->selectOne('users',['id'=>$post['user_id']]);


$myposts = $db->query('select * from posts order by created_at desc limit 10');








?>