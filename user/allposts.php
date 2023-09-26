<?php
    include 'components/navbar.php';
    
    require MODEL_DIR."Posts.php";
    $posts = new Posts($conn);
    $allPosts = $posts->getAllPosts();

    
?>

<div class="container overflow-hidden">
    <?php echo errorMessage(); echo successMessage(); ?>

    <h2 class="mb-5">Timeline</h2>
    <div class="row g-5 mb-3 justify-content-center align-items-start">
        <?php if(count($allPosts) == 0) { ?>
            <div class='alert alert-danger'><strong>Error: </strong> No content created yet! Be the first to do so!</div>
        <?php } else {    
            foreach ($allPosts as $post) { ?>
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

                        <span class="btn btn-dark disabled">
                            <?php echo $posts->formatNoOfComments($post["total_comments"]); ?> Replies
                        </span>

                        <a href="<?php echo BASE_URL_USER;?>viewpost.php?viewPost&id=<?php echo $post['id'];?>" class="btn btn-primary">View Post</a>
                    </div>
                </div>
            <?php }   
        }
        ?>
    </div>
</div>