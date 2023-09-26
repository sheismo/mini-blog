<?php
    include 'components/navbar.php';
    require_once MODEL_DIR."Categories.php";
    $categories = new Categories($conn);
    $allCategories = $categories->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a post</title>
    <style>
        form {
            max-width: 60%;
            margin: 20px auto;
        }

        @media screen and (min-width: 567px) and (max-width: 768px) {
            form {
                max-width: 75%;
            }
        }

        @media screen and (max-width: 567px) {
            form {
                max-width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="container-sm">
        <?php echo errorMessage(); echo successMessage(); ?>
     
        <form method="post" action="<?php echo BASE_URL;?>controllers/post.php"  enctype="multipart/form-data">
            <h2 class="mb-3">Write a post..</h2>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Title</label>
                <input name="postTitle" type="text" class="form-control" id="exampleFormControlInput1" autofocus required placeholder="Your Post Title">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Select a category</label>
                <select name="postCategory" class="form-select" aria-label="Default select example" id="exampleFormControlInput2" autofocus required>
                    <?php 
                        foreach($allCategories as $category) { ?>                       
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo $category['category_name']; ?>
                                </option>        
                    <?php } ?>   
                </select>
            </div>
        
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                <textarea name="postContent" class="form-control" id="exampleFormControlTextarea1" rows="10" placeholder="Write post"></textarea>
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Choose an Image: </label>
                <input name="image" type="file" class="form-control" id="exampleFormControlInput3">
            </div>

            <button class="btn btn-warning" name="createPost" type="submit">Post</button>
        </form>

    </div>
</body>
</html>