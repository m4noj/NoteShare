<?php session_start();
require_once('core/database.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
    $db = Database::getInstance();
    $user = $_SESSION['user']['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $community  = $_POST['community_id'];
    $tags = $_POST['tags'];
    $content = $_POST['postdata'];

    $postimg = null;
    if(!empty($_FILES['postimg']['name'])){
        $postimg = 'userPost__'.$_FILES['postimg']['name'];
        move_uploaded_file($_FILES['postimg']['tmp_name'],"../public/uploads/userPosts/$postimg"); 
    }

    $file = null;
    if(!empty($_FILES['file']['name'])){
        $file = 'userFile__'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'],"../public/uploads/userFiles/$file"); 
    }
    
    try {
        $db->insert('posts',[
                'user_id' => $user,
                'title' => $title,
                'description' => $desc,
                'community' => $community,
                'tags' => $tags,
                'content' => $content,
                'postimg' => $postimg,
                'file' => $file]);

                $_SESSION['flash_messages'][] = ['type'=>'success','message'=>'Post created successfully!'];
                header("Location: ../public/home.php");
                exit();
    } catch (PDOException $e) {
        $_SESSION['flash_messsages'][]= ['type'=>'danger','message'=>'failed to create post.'];
        header("Location: ../public/create-post.php");
        exit();
    }
    

}





























?>