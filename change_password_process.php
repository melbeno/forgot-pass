<?php
if (isset($_GET['verify_token'])) {
    $code = $_GET['verify_token'];

    $conn = new mysqli('localhost', 'root', '', 'testing');
    if ($conn->connect_error) {
        die('Could not connect to the database');
    }

    $verifyQuery = $conn->query("SELECT * FROM admin WHERE verify_token = '$code'");

    if ($verifyQuery->num_rows == 0) {
        header("Location: change_password.php");
        exit();
    }

    if (isset($_POST['change'])) {
        $email = $_POST['email'];
        $new_password = $_POST['new_password'];

        $changeQuery = $conn->query("UPDATE admin SET ad_password = '$new_password' WHERE ad_email = '$email' AND verify_token = '$code'");

        if ($changeQuery) {
            header("Location: success_1.php");
            exit();
        } else {
            echo 'Password change failed';
        }
    }

    $conn->close();
} else {
    // If code is not set, redirect to change_password.php
    header("Location: reset-pass.php");
    exit();
}
?>
