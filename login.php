<?php include 'includes/constants.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Project 1</title>
</head>
<body>
    <!-- Header -->
    <div class="container-fluid p-0">
        <header class="mb-5">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container row justify-content-end p-3">
                    <div class="col">
                        <a class="navbar-brand" href="<?php echo BASE_URL;?>index.php">My-Blogsite</a>
                    </div>
                    <div class="col">
                        <a class="text-white" href="<?php echo BASE_URL;?>index.php">
                            <button class="btn btn-info">Sign Up</button>
                        </a>
                    </div>
                </div>
            </nav>
        </header>
    </div>

    <!-- Login Form -->
    <div class="container-sm mt-5">

        <?php echo errorMessage(); echo successMessage(); ?>

        <form method="post" action="<?php echo BASE_URL;?>controllers/auth.php">
            <h2 class="mb-2">Login</h2>

            <div class="mb-3">
                <label for="mobile" class="form-label">Phone no./Username/Email</label>
                <input name="userdetail" class="form-control" placeholder="Enter Phone no./Username/Email">
                
            </div>

            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password:</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            
            <button name="userLogin" type="submit" class="btn btn-success">Login</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>