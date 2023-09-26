<?php
    function displayComments($comments) {
        global $utility;
        
        if (!$comments) { ?>
            <div class="container">
                <div class="alert alert-danger">
                    <b>Error: </b> No comments on this post yet
                </div>
            </div>
        <?php } else {           
            foreach($comments as $comment) { ?>           
                <?php 
                    $isUserLiked = $comment["user_like_activity"]["user_likes_count"];
                    $isUserDisliked = $comment["user_like_activity"]["user_dislikes_count"];
                ?>
                <li class="list-group-item list-group-item-light mb-3">
                    <p>
                        <?php echo $comment['content']; ?>
                    </p>
                    <div class="row flex justify-content-between align-items-center">
                        <div class="col">
                            @<span class="text-warning"><?php echo $comment['username']; ?></span>
                            <span class="text-danger">[<?php echo $utility->niceDateFormat($comment['created_at']); ?>]</span>
                        </div>
                        <div class="col">
                            <?php if ($isUserLiked > 0) {
                                $likeLink = $disLikeLink = 'javascript:void(0)';
                            } else {
                                $likeLink = BASE_URL."controllers/post.php?reactToComment&reaction=like&commentId=".$comment['id'];
                            }  
                            if ($isUserDisliked > 0) {
                                $disLikeLink = 'javascript:void(0)';
                            } else {
                                $disLikeLink = BASE_URL."controllers/post.php?reactToComment&reaction=dislike&commentId=".$comment['id'];
                            } ?>
                            
                            <a href="<?php echo $likeLink; ?>"
                                class="btn btn-outline-primary py-0 px-1 <?php echo ($isUserLiked > 0) ?'active':'';?>">
                                <i class="bi bi-hand-thumbs-up-fill"></i> <?php echo $comment['total_comment_like']; ?></a>
                            <a href="<?php echo $disLikeLink;?>" 
                                class="btn btn-outline-danger py-0 px-1  <?php echo ($isUserDisliked > 0) ?'active':'';?>">
                                <i class="bi bi-hand-thumbs-down"></i> <?php echo $comment['total_comment_dislike']; ?></a>
                            <!-- <a href="#" class="btn btn-success py-0 px-1"><i class="bi bi-link"></i></a> -->
                        </div>
                    </div>
                </li>
            <?php }
        }
    }
?>