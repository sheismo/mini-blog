<?php
 error_reporting();
 require "../includes/constants.php";
 require MODEL_DIR."Posts.php";
 $posts = new Posts($conn);

if(isset($_POST['createPost'])) {
    $postTitle = trim($_POST['postTitle']);
    $postContent = trim($_POST['postContent']);
    $categoryId = trim($_POST["postCategory"]);
    $userId = $_SESSION['user_id'];
    
    if ($postTitle == "" OR $postContent == "" OR $categoryId == "") {
        $_SESSION['error_message'] = "Please fill all fields";
    } 
    else if(!isset($userId) ) {
        $_SESSION['error_message'] = "You have to be logged in to write a post!";
    } 
    else {
        $imageUploaded = uploadImage($_FILES['image']);

        if($imageUploaded) {

            $query = "INSERT INTO posts (post_title, post_content, category_id, user_id, post_image) 
            VALUES ('$postTitle', '$postContent', '$categoryId', '$userId', '".$_SESSION['post_image_name']."')";
            $postCreated = $posts->createPost($query);
    
            if($postCreated) {
                $_SESSION['success_message'] = "Post created successfully!";
                // Redirect user to their posts page
                header("location:".BASE_URL_USER."myposts.php");
                exit;
            } else {
                $_SESSION['error_message'] = "An error occurred, we could not upload your post!";
            }
        } 
        else {
            $_SESSION['error_message'] = "Something went wrong with your image";
        }
    }
    header("location: ".HTTP_REFERER);
    exit;
 }
 else if(isset($_GET['deletePost'])) {
    $postId = $_GET['id'];
    $getPost = $posts->getSinglePost("select * from posts where id = '$postId'"); 
    $fileImageName = $getPost['post_image'];

    $deletePost = $posts->deletePost("delete from posts where id = '$postId'");

    if($deletePost) {   
        if(!empty($fileImageName)) {
            deletePostImage($fileImageName);
        }  
        $_SESSION['success_message'] = "Post deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Something went wrong!";
    }
    // Redirect user to their posts page
    header("location:".HTTP_REFERER);
    exit;
 }
 else if (isset($_GET['reactToComment'])) {
    $userId = $_SESSION['user_id'];
    $commentId = $_GET['commentId'];
    $reaction = $_GET['reaction'];
    
    if (!$commentId) {
        header("location: ".HTTP_REFERER);
        exit;
    } else {
        switch ($reaction) {
            case 'like':
                $query = "INSERT INTO comment_likes (comment_id,  user_id, use_case) VALUES ('$commentId', '$userId', 'likes' )";
                $reactionRecorded = $posts->reactToComment($query);
                if ($reactionRecorded) {
                    $_SESSION['success_message'] = "Liked successfully";
                } else {                    
                    $_SESSION['error_message'] = "Unable to create a like";
                }
            break;
            case 'dislike':
                $query = $query = "INSERT INTO comment_likes (comment_id,  user_id, use_case) VALUES ('$commentId', '$userId', 'dislike' )";
                $reactionRecorded = $posts->reactToComment($query);
                if ($reactionRecorded) {
                    $_SESSION['success_message'] = "Disliked successfully";
                } else {                    
                    $_SESSION['error_message'] = "Unable to create a dislike";
                }
            break;
            default:
                $_SESSION['error_message'] = "Invalid request";
        }
    }
    header("location: ".HTTP_REFERER);
    exit;
 }
 else {   
    header("location: ".BASE_URL);
    exit;
}
?>