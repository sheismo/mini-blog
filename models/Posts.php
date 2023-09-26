<?php 
    require_once MODEL_DIR."Users.php";
    require_once MODEL_DIR."Categories.php";
    require_once MODEL_DIR."CommentLikes.php";

    class Posts extends CommentLikes {
        protected $conn, $users, $categories;

        public function __construct($conn) {
            $this->conn = $conn;

            $this->users = new Users($this->conn);
            $this->categories = new Categories($this->conn);
        }

        public function createPost ($query) {
            return $this->conn->insertRecord($query);
        }

        public function deletePost ($query) {
            return $this->conn->deleteRecord($query);
        }

        public function updatePost ($query) {
            return $this->conn->updateRecord($query);
        }

        public function getSinglePost ($query) {
            $post = $this->conn->getRecord($query);
            if($post) {
                $userData = $this->users->userInfo($post['user_id']);
                unset($userData['password']);
    
                $post['user'] = $userData;
                $post['category'] =  $this->categories->getCategory($post['category_id']);
                $post['total_comments'] = self::getNoOfComments($post['id']);
                
                return $post;
            }
            return false;
        }
        
        public function getAllPosts ($userId = "") {
            if($userId == "") {
                $query= 'SELECT * FROM posts';
            } else {
                $query= 'SELECT * FROM posts WHERE user_id='.$userId;
            }
            $postResults = $this->conn->getAllRecords($query);

            if($postResults != NULL) {
                foreach($postResults as $postIndex => $post) {
                    $userData = $this->users->userInfo($post['user_id']);

                    $postResults[$postIndex]['user'] = $userData;
                    $postResults[$postIndex]['total_comments'] = self::getNoOfComments($post['id']);
                    $postResults[$postIndex]['category'] =  $this->categories->getCategory($post['category_id']);
                    
                    unset($postResults[$postIndex]['user']['password']);
                }
                return $postResults;
            }
            return false;
        }

        public function writeComment ($query) {
            return $this->conn->insertRecord($query);
        }
        
        public function getComments ($postId) {
            $query = 'SELECT * FROM comments WHERE post_id='.$postId.' ORDER BY created_at DESC';
            $comments = $this->conn->getAllRecords($query);

            if($comments != NULL) {
                foreach($comments as $index => $comment) {
                    $commentId = $comment['id'];
                    $commentLikes = self::totalCommentLikes($commentId);

                    $loggedInUserId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

                    $userName = $this->users->userInfo($comment['user_id'])['username'];
                    $comments[$index]['username'] = $userName;
                    $comments[$index]['total_comment_like'] = $commentLikes['likes'];
                    $comments[$index]['total_comment_dislike'] = $commentLikes['dislike'];
                    $comments[$index]['user_like_activity'] = self::checkUserReactionComment($commentId, $loggedInUserId);
                } 
                return $comments;
            }
            return false;
        }

        private function getNoOfComments($postId) {
            $query = 'SELECT * FROM comments WHERE post_id='.$postId;
            $result = $this->conn->countRecord($query);
            return $result;
        }

        public function formatNoOfComments($noOfComments) {
            if  ($noOfComments < 1000) {
                return $noOfComments;
            }
            else if ($noOfComments < 1000000) { //for comments in their thousands
                if ($noOfComments % 1000 == 0) {
                    $noOfComments = number_format($noOfComments / 1000).'K';
                } else {
                    $noOfComments = number_format($noOfComments / 1000).'K+';
                }
            } 
            else if ($noOfComments < 1000000000) { // for comments in their millions
                if ($noOfComments % 1000000 == 0) {
                    $noOfComments = number_format($noOfComments / 1000000).'M';
                } else {
                    $noOfComments = number_format($noOfComments / 1000000).'M+';
                }
            }
            else { // At least a billion             
                $noOfComments = number_format($noOfComments / 1000000000, 1).'B';
            }
            return $noOfComments;
        }

        public function reactToComment($query) {
            return $this->conn->insertRecord($query);
        }

        public function getNoOfReactions($commentId, $use_case) {
            $query = 'SELECT * FROM comment_likes WHERE comment_id='.$commentId.'AND use_case='.$use_case;
            $result = $this->conn->countRecord($query);
            return $result;
        }
    }
?>