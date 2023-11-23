<?php
    session_start();
    if(!$_SESSION['is_login']){
        header("Location: login.php");  
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VaccMe | Home</title>
</head>

<body>
    <h1>Welcome</h1>
    <ul>
        <a href="../controller/logoutController.php">Logout</a>
        
    </ul>
</body>

</html>