<?php
    include 'components/navbar.php';
    include './displayComments.php';

    require MODEL_DIR."posts.php";
    $posts = new Posts($conn);

    if(isset($_REQUEST["viewPost"])) {
        $postId = $_GET["id"];

        $query = "SELECT * FROM posts WHERE id=$postId";
        $post = $posts->getSinglePost($query);
        $comments = $posts->getComments($postId);
        
        if($post == NULL) { ?>
            <div class="container">
                <div class="alert alert-danger">
                    <b>Error: </b> Post could not be found. Be the first to create one 
                    <a href="<?php echo BASE_URL_USER;?>createpost.php"><strong>CREATE POST</strong></a>
                </div>
            </div>
        <?php }
        else { ?>

            <div class="container-sm w-50">
                <?php echo errorMessage(); echo successMessage(); ?>

                <!-- post content -->
                <div class="mx-auto p-3 border border-5 border-info border-rounded">
                    <h5>
                        <?php echo $post["post_title"]; ?>
                    </h5>

                    <div>
                        <?php echo nl2br($post['post_content']); ?>
                    </div>

                    <p class="my-1 text-grey">
                        Written by:
                        <span class="text-info">
                            <?php echo $post["user"]["username"];?>
                        </span>
                    </p>
                    
                    <p>
                        <?php 
                            $date = explode(" ", $post["created_at"])[0];
                            $date = str_replace("-", "/", $date);
                            echo $date; 
                        ?>
                    </p>
                </div>

                <!-- write comment form -->
                <form action="<?php echo BASE_URL;?>controllers/post.php?postId=<?php echo $post['id'];?>" method="post" class="my-4">
                    <textarea name="comment" id="comment" class="form-control" cols="30" rows="3" autofocus  placeholder="Write your comment here..."></textarea>
                    <br>
                    <button name="writeComment" class="btn btn-info">Send</button>
                </form>
                
                <!-- all comments -->
                <div>
                    <h6 >Comments (<?php echo $post["total_comments"] ?>)</h6>
                    <div>
                        <ul class="list-group">
                            <?php 
                                displayComments($comments, $utility);
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php }

    } else {
        header("location: ".BASE_URL_USER."dashboard.php");
        die;
    }
?>

