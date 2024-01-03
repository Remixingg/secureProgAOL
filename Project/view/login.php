<?php
    session_start();
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    
    <head>
        <meta charset="utf-8">
        <title>VaccMe | Login</title>
    </head>

    <?php
        if(isset($_SESSION['error_message'])) {
            // if($_GET['error']) {
                $error_message = $_SESSION['error_message'];
                echo "<div>$error_message</div>";
                unset($_SESSION['error_message']);
            // }
        }
    ?>

    <body>
        <form method="POST" action="../controller/loginController.php">
            <div>
                <!-- <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" /> -->
                <div>
                    <input type="text" name="username" placeholder="Username" id="username"><br>
                </div>

                <div>
                    <input type="password" name="password" placeholder="Password" id="password"><br>
                </div>
                
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                <div>
                    <button type="submit" name="submit">LOGIN</button>
                </div>
            </div>

            <div>
                <p>Don't have any account?<a href="register.php">Register</a></p>
            </div>
            
        </form>
  </body>
</html>