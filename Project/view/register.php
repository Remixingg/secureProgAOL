<?php
    require '../config/connect.php';
    if(!empty($_SESSION["id"])){
        header("Location: index.php");
    }

    if(isset($_POST["submit"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if(mysqli_num_rows($duplicate) > 0){
            echo
            "<script> alert('Email or Username or Phone Number has already taken'); </script>";
        }
        else{
            $query = "INSERT INTO users VALUES (4, '$username', '$password')";
            mysqli_query($conn, $query);
            echo "<script> alert('Registration Success');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VaccMe | Register</title>
</head>

<body>
    <form method="POST" action="../controller/registerController.php">

        <div>
            <!-- <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" /> -->
            <div>
                <input type="text" name="username" placeholder="Username" id="username"><br>
            </div>
    
            <div>
                <input type="password" name="password" placeholder="Password" id="password"><br>
            </div>
            
            <div>
                <button type="submit" name="submit">Register</button>
            </div>
        </div>
            
        <div>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>

    </form>
</body>

</html>