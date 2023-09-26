<?php
function errorMessage() {
    if(isset($_SESSION['error_message'])) { ?>
        <div class="alert alert-danger">
            <strong>Error: </strong> <?php echo $_SESSION['error_message'];?>
        </div>
    <?php
        unset($_SESSION['error_message']);
    }
}

function successMessage() {
    if(isset($_SESSION['success_message'])) { ?>
        <div class="alert alert-success">
            <strong>Success: </strong> <?php echo $_SESSION['success_message'];?>
        </div>
    <?php
        unset($_SESSION['success_message']);
    }
}
?>