<?php
    session_start();
    require '../config/connect.php';

    function is_valid_password($password) {
        // 8 characters, 1 upper, 1 special
        return (strlen($password) >= 8 && preg_match('/[A-Z]/', $password) && preg_match('/[^a-zA-Z0-9]/', $password));
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (!is_valid_password($password)) {
            $_SESSION['error_message_register'] = "Invalid password. It must be at least 8 characters long and contain at least one uppercase letter and one special character.";
            header("Location: ../view/register.php?error=1");
            exit;
        }

        $checkQuery = $conn->prepare("SELECT * FROM users WHERE username = ?;");
        $checkQuery->bind_param("s", $username);
        $checkQuery->execute();
        $checkQuery->store_result();


        if ($checkQuery->num_rows > 0) {
            $_SESSION['error_message_register'] = "Username must be unique!";
            header("Location: ../view/register.php?error=1");
        } else {
            $query = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query->bind_param("ss", $username, $hashedPassword);

            if ($query->execute()) {
                $_SESSION['error_message'] = "Registration success!";
                header("Location: ../view/login.php");
            } else {
                $_SESSION['error_message_register'] = "Invalid Credentials!";
                header("Location: ../view/register.php?error=1");
            }
            $query->close();
        }

        $checkQuery->close();
    }
?>

