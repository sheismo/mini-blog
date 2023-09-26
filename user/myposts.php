<?php 
    include 'components/navbar.php'; 
    
    require MODEL_DIR."Posts.php";
    $posts = new Posts($conn);

    $userId = $_SESSION['user_id'];
    $myPosts = $posts->getAllPosts($userId);
?>

<div class="container overflow-hidden">
    <?php echo errorMessage(); echo successMessage(); ?>

    <h2 class="mb-5">Timeline</h2>
    <div class="row g-5 mb-3 justify-content-center align-items-start">
        <?php 
            if(count($myPosts) > 0) {
                foreach ($myPosts as $post) { ?>
                    <div class="p-1 mx-4 col-xs-12 col-sm-6 col-md-4 col-lg-3 card">
                        <img src="<?php echo "../assets/postimages/".$post["post_image"]?>" class="card-img-top" alt="Post Image">

                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $post["post_title"]; ?>
                            </h5>

                            <p class="mb-1 text-grey">
                                Written by:
                                <span class="text-info">
                                    <?php echo $post["user"]["username"];?>
                                </span>
                            </p>

                            <div class="row">
                                <div class="col">
                                    <span class="text-warning">
                                        [<?php echo $post["category"]["category_name"]; ?>]
                                    </span>
                                </div>
                                <div class="col">
                                    <p>
                                        <span>
                                            <?php 
                                                $date = explode(" ", $post["created_at"])[0];
                                                $date = str_replace("-", "/", $date);
                                                echo $date; 
                                            ?>
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <a href="<?php echo BASE_URL_USER;?>viewpost.php?viewPost&id=<?php echo $post['id'];?>" class="btn btn-primary">View Post</a>
                            <a href="<?php echo BASE_URL;?>controllers/post.php?deletePost&id=<?php echo $post['id'];?>" class="btn btn-danger">Delete Post</a>
                        </div>
                    </div>
                <?php }       
            } else { ?>
                <div class="alert alert-info px-4">
                    <p class="mb-1"><strong>You do not have any posts yet!</strong></p>
                    <span>Click the create post tab to start posting..</span>
                </div>
            <?php }
        ?>
    </div>
</div>
