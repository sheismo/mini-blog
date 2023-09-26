<?php include 'includes/constants.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Blog App</title>
</head>
<body>
    <!-- Header -->
    <div class="container-fluid p-0">
        <header class="mb-5">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container p-3 row justify-content-between">
                    <div class="col">
                        <a class="navbar-brand pe-10" href="<?php echo BASE_URL;?>index.php">My-Blogsite</a>
                    </div>
                    <div class="col">
                        <a class="text-white" href="<?php echo BASE_URL;?>login.php">
                            <button class="btn btn-warning">Login</button>
                        </a>
                    </div>
                </div>
            </nav>
        </header>
    </div>

    <!-- Sign up form -->
    <div class="container mt-5">

        <?php echo errorMessage(); echo successMessage(); ?>

        <form method="post" action="<?php echo BASE_URL;?>controllers/auth.php">
            <h2>Sign Up</h2>
            
            <div class="col mb-3">
                <label for="name" class="form-label">Full Name:</label>
                <input name="fullname"type="text" class="form-control" id="name">
            </div>

            <div class="row g3">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address:</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>

                <div class="col mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input name="username" type="text" class="form-control" id="username">
                </div>
            </div>

            <div class="row g3">
                <div class="col mb-3">
                    <label for="mobile" class="form-label">Phone no:</label>
                    <input name="mobile" inputmode="numeric" class="form-control" id="exampleCheck1">
                    
                </div>

                <div class="col mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                </div>
            </div>
            
            <button name="userRegistration" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</body>
</html>