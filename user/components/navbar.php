<?php
    require "../includes/constants.php";
    if(!isset($_SESSION['user_id'])) {
        header('location: '.BASE_URL.'login.php');
        exit;
    }
    
    require MODEL_DIR.'Users.php';
    $users = new Users($conn);

    $userId = $_SESSION['user_id'];
    $userInfo = $users->userInfo($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>My Dashboard</title>
</head>
<body>
    <?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>

    <div class="container-fluid p-0">
        <header class="mb-5">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3">
                <div class="container-fluid">
                    <a class="navbar-brand pe-10" href="<?php echo BASE_URL;?>index.php">My-App</a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse ms-4" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item me-4">
                                <a class="nav-link mr-5 <?php echo $activePage == 'dashboard' ? 'active': ''; ?> text-white" aria-current="page" href="<?php echo BASE_URL_USER;?>dashboard.php">Dashboard</a>
                            </li>

                            <li class="nav-item me-4">
                                <a class="nav-link <?php echo $activePage == 'createpost' ? 'active': ''; ?> text-white" href="<?php echo BASE_URL_USER;?>createpost.php">Create Post</a>
                            </li>
                            
                            <li class="nav-item me-4">
                                <a class="nav-link <?php echo $activePage == 'allposts' ? 'active': ''; ?> text-white" href="<?php echo BASE_URL_USER;?>allposts.php">All Posts</a>
                            </li>
                            
                            <li class="nav-item me-4">
                                <a class="nav-link <?php echo $activePage == 'myposts' ? 'active': ''; ?> text-white" href="<?php echo BASE_URL_USER;?>myposts.php">My Posts</a>
                            </li>

                            <li class="nav-item  me-4 dropdown">
                                <a class="nav-link dropdown-toggle <?php echo $activePage == 'myprofile' ? 'active': ''; ?> text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    My Profile
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?php echo BASE_URL_USER;?>logout.php">
                                            Logout<i class="bi bi-box-arrow-in-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item me-4">
                                <a class="nav-link text-white" href="<?php echo BASE_URL_USER;?>logout.php">
                                    Logout <strong class="text-white">(<?php echo $userInfo['initial'];?>)</strong>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>