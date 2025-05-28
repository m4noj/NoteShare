<?php session_start();


require_once('core/database.php');


if($_SERVER['REQUEST_METHOD']==='POST'){
    $db = Database::getInstance();

    $name = $_POST['name'];
    $description = $_POST['description'];
    $logo = 'default-logo.jpg';
        if(!empty($_FILES['logo']['name'])){
            // $logo = time(). '_'.$_FILES['logo']['name'];
            $logo = 'CommunityLogo__'.$_FILES['logo']['name'];
            move_uploaded_file($_FILES['logo']['tmp_name'],"../public/uploads/community-logos/$logo");
        }
    $user_id = $_SESSION['user']['id'];
    $type = $_POST['visibility'];
    try {
        $db->insert('communities',[
            'name' => $name,
            'description' => $description,
            'logo' => $logo,
            'creator_id' => $user_id,
            'type' => $type

        ]);

        $_SESSION['flash_messages'][] =['type' => 'success', 'message' => 'Community Created successfully!'];
        // header("Location: ../public/communities/community.php?id=".$db->lastInsertId());
        header("Location: ../public/communities.php");
        exit();

    } catch (PDOException $e) {

        if($e->getCode()==='23000'){
          
            $_SESSION['flash_messages'][] = ['type'=>'danger','message'=>'Community already Exist. use different Name'];
                        header('Location: ../public/create-community.php');
            
          } else {
            
            $_SESSION['flash_messages'][] = ['type'=>'danger','message'=>'Failed to create Community.'];
        }
        
        header("Location: ../public/create-community.php");
        exit();
    }





}






?>