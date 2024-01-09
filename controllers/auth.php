<?php
error_reporting(E_ALL);
require "../includes/constants.php";
require MODEL_DIR."Users.php";
$users = new Users($conn);

if(isset($_POST['userRegistration'])) {
    $fullname = trim($_POST['fullname']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $username = trim($_POST['username']);
    $mobile = $utility->validateReformPhoneNumber(trim($_POST['mobile']));
    $password = trim($_POST['password']);
    
    if($fullname == "" OR $email == "" OR $username == "" OR $mobile == "" OR $password == "") {
        $_SESSION['error_message'] = "Please fill all fields";
    } else if(strlen($password) < 5) {
        $_SESSION['error_message'] = "Password is too short";
    } else if(!$email) {
        $_SESSION['error_message'] = "Invalid email address supplied";
    } else {
        
        if($users->countUsers("select * from users where email = '$email'") == 1) {
            $_SESSION['error_message'] = "Email address already registered";
        } else if($users->countUsers("select * from users where mobile = '$mobile'") == 1) {
            $_SESSION['error_message'] = "Mobile number already registered";
        } else if($users->countUsers("select * from users where username = '$username'") == 1) {
            $_SESSION['error_message'] = "Username already exists";
        } else {
            $hashPassword = $utility->hashPassword($password);
            
            $createQuery = "Insert ignore into users (name, username, email, mobile, password) values 
                ('$fullname', '$username', '$email', '$mobile', '$hashPassword')";

            $createUser = $users->createUser($createQuery);

            if($createUser) {
                $_SESSION['success_message'] = "User created successfully";
            }
            else {
                $_SESSION['error_message'] = "Error creating user";
            }
        }
    }
    header("location:".HTTP_REFERER);
    exit;
}

else if(isset($_POST['userLogin'])) {
    $userDetail = trim($_POST['userdetail']);
    $password = trim($_POST['password']);
    $checkIfEmail = $utility->validateEmail($userDetail);
    
    if($checkIfEmail) {
        $email = $checkIfEmail;
        $userExists = $users->retrieveUser("select * from users where email = '$email'");
    } else {
        $validateInfo = $utility->validateReformPhoneNumber($userDetail);
        $userExists = $users->retrieveUser("select * from users where (mobile = '$validateInfo' OR username = '$validateInfo')");
    }
    
    if($userExists != NULL) {
        $savedPassword = $userExists['password'];
        if($utility->checkPassword($password, $savedPassword)) {
            // echo "password is now hashed";
            $userId = $userExists['id'];
            $_SESSION['user_id'] = $userId;
            // Since user is logged, let's redirect the user to the dashboard
            header("location: ".BASE_URL_USER.'dashboard.php');
            exit;
        } else {
            $_SESSION['error_message'] = "Bad combination of user detail or password";
        }
    }
    else {
        $_SESSION['error_message'] = "Bad combination of user detail or password";
    }
    header("location:".HTTP_REFERER);
    exit;
}
else {
    header("location: ".BASE_URL);
    exit;
}
?>