<?php
error_reporting(0);
    require "../includes/constants.php";
    require MODEL_DIR."posts.php";
    $posts = new Posts($conn);

    require '../user/displayComments.php';

    if(isset($_GET['fetchComment'])) {
        $postId = $_GET['postId'];
        $comments = $posts->getComments($postId);
        
        echo displayComments($comments);
        
    }
    else if (isset($_POST['writeComment'])) {
        $comment = trim($_POST['comment']);
        $userId = $_POST['user_id'];
        $postId = $_POST['postId'];

        if ($comment == "" ) {
            http_response_code(400);
            $response = ['message' => "Write something to comment on the post!", 'status' => 400];
        } 
        else if(!isset($userId)) {
            http_response_code(400);
            $response = ['message' => "User ID is required", 'status' => 400];
        } 
        else if(!isset($postId) ) {
            http_response_code(400);
            $response = ['message' => "Post ID is required", 'status' => 400];
        } else {
            $query = "INSERT INTO comments (content,  user_id, post_id) VALUES ('$comment', '$userId', '$postId' )";
            $commentSent = $posts->writeComment($query);
        
            if($commentSent) {
                $response = ['message' => "Your comment has been uploaded successfully!", 'status' => 200];
            } else {
                http_response_code(400);
                $response = ['message' => "An error occurred, we could not upload your comment!", 'status' => 400];
            }
        }
        echo json_encode($response);
    }
?>