<?php
    session_start();
    require '../config/connect.php';

    if ($_SERVER["REQUEST_METHOD"]==="POST"){

        $username = $_POST["username"];
        $password = $_POST["password"];
    
        $checkQuery = $conn->prepare("SELECT * FROM users WHERE username = ?;");
        $checkQuery->bind_param("s", $username);
        $checkQuery->execute();
        $checkQuery->store_result();
    
        if ($checkQuery->num_rows > 0) {
            echo "<div>Username must be unique</div>";
        } else {
            $query = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query->bind_param("ss", $username, $hashedPassword);
    
            if ($query->execute()) {
                echo "Registration success!";
                header("Location: ../view/login.php");
            } else {
                echo "Registration error!";
                $_SESSION['error_message'] = "Invalid Credentials!";
                header("Location: ../view/register.php?error=1");
            }
            $query->close();
        }

        $checkQuery->close();
    }


?>