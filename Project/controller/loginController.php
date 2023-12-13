<?php
    session_start();
    require '../config/connect.php';

    function loginHandler($username, $password){
        global $conn;
        $query = "SELECT * FROM users WHERE username=?;";
        $stmt = $conn->prepare($query);
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("s", $username);

        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    if($_SERVER['REQUEST_METHOD']==="POST"){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $login_result = loginHandler($username, $password);

        if ($login_result->num_rows == 1) {
            $data = $login_result->fetch_assoc();
            if(password_verify($password, $data['password'])){
                $_SESSION["success_message"] = "Hello, $username";
                $_SESSION['is_login'] = true;
                $_SESSION['userID'] = $data["userID"];
                $_SESSION['username'] = $data["username"];
                header("Location: ../view/home.php");
            }
            else {
                $_SESSION['error_message'] = "Invalid Credentials!";
                header("Location: ../view/login.php?error=1");
            }
        }
        else {
            $_SESSION["error_message"] = "Invalid Credentials!";
            header("Location: ../view/login.php?error=1");
        }

    }

?>

