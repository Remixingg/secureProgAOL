<?php
    session_start();
    require '../config/connect.php';
    
    // if(isset($_POST["submit"])){
    //     $email = $_POST["email"];
    //     $password = $_POST["password"];
    //     $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    //     if(mysqli_num_rows($duplicate) > 0){
    //         echo
    //         "<script> alert('Email or Username or Phone Number has already taken'); </script>";
    //     }
    //     else{
    //         $query = "INSERT INTO users VALUES (4, '$username', '$password')";
    //         mysqli_query($conn, $query);
    //         echo "<script> alert('Registration Success');</script>";
    //     }
    // }

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
            $insertQuery->bind_param("ss", $username, $hashedPassword);
    
            if ($insertQuery->execute()) {
                echo "Registration success!";
            } else {
                echo "Registration error!";
            }
        }

        $checkQuery->close();
        $insertQuery->close();
    }


?>