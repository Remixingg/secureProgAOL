<?php
    session_start();
    $_SESSION['is_login'] = false;
    session_destroy();
    header("Location: ../view/login.php");
?>