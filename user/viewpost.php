<?php
    include 'components/navbar.php';
    include './displayComments.php';

    require MODEL_DIR."posts.php";
    $posts = new Posts($conn);

    if(isset($_REQUEST["viewPost"])) {
        $postId = $_GET["id"];

        $query = "SELECT * FROM posts WHERE id=$postId";
        $post = $posts->getSinglePost($query);
        
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
                <form class="my-4">
                    <textarea name="comment" id="comment" class="form-control mb-2" cols="30" rows="3" autofocus  placeholder="Write your comment here..."></textarea>
                    <button type="submit" class="btn btn-info mb-2 writeComment">Send</button>
                </form>

                <div class="response_display"></div>
                
                <!-- all comments -->
                <div>
                    <div class="display_comments"></div>
                </div>
            </div>
        <?php }

    } else {
        header("location: ".BASE_URL_USER."dashboard.php");
        die;
    }
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    const postId = <?php echo $postId;?>;
    const userId = <?php echo $post['user']['id'] ?>

    $(".writeComment").on('click', function(e) {
        e.preventDefault();
        button = $(".writeComment");
        let comment = $("#comment").val();
        const responseField = $('.response_display');

        responseField.removeClass('alert alert-danger').removeClass('alert alert-success').html('');

        $.ajax({
            url: '<?php echo BASE_URL;?>api/comments.php',
            type: 'post',
            data: {'writeComment': true, 'postId': postId, 'user_id': userId, 'comment': comment},
            beforeSend:function() {
                button.html("Processing").attr('disabled', true)
            },
            success:function(result) {
                decodeResponse = JSON.parse(result);
                let responseMessage = decodeResponse.message;
                button.html("Send").attr('disabled', false)
                
                responseField.addClass('alert alert-success').html(responseMessage);
                displayComment(postId);
            },
            error: function (xhr, status, error) {
                // console.log(xhr.responseText)
                button.html("Send").attr('disabled', false)

                decodeResponse = JSON.parse(xhr.responseText);
                responseField.addClass('alert alert-danger').html(decodeResponse.message)
            }
        })
    });

    // setInterval(function() {
    function displayComment(postId) {
        $.ajax({
            url: '<?php echo BASE_URL;?>api/comments.php',
            type: 'get',
            data: {'fetchComment': true, 'postId': postId},
            beforeSend: function() {
                $(".display_comments").html("Loading comments...");
            },
            success:function(result) {
                $(".display_comments").html(result);
            }
        })
    }
    displayComment(postId);
</script>

