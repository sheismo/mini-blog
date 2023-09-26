<?php
class CommentLikes {
    protected $conn;

    public function totalCommentLikes($commentId) {
        $dislikeQuery = "SELECT * FROM `comment_likes` WHERE use_case = 'dislike' AND comment_id = '$commentId'";
        $likeQuery = "SELECT * FROM `comment_likes` WHERE use_case = 'likes' AND comment_id = '$commentId'";
        
        return ['likes' => $this->conn->countRecord($likeQuery), 'dislike' => $this->conn->countRecord($dislikeQuery)];
        
    }

    public function checkUserReactionComment($commentId, $userId) {
        $dislikeQuery = "SELECT * FROM `comment_likes` WHERE use_case = 'dislike' AND user_id = '$userId' AND comment_id = '$commentId'";
        $likeQuery = "SELECT * FROM `comment_likes` WHERE use_case = 'likes' AND user_id = '$userId' AND comment_id = '$commentId'";

        return ['user_likes_count' => $this->conn->countRecord($likeQuery), 'user_dislikes_count' => $this->conn->countRecord($dislikeQuery)];
    }
}
?>