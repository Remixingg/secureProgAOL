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
        <ul>
            <li name="logout">
                <a href="../controller/logoutController.php">Logout</a>
            </li>
            <li name="add">
                <a href="add.php">Add</a>
            </li>
            <li name="view">
                <a href="view.php">View</a>
            </li>
            <!-- <li name="update">
                <a href="../controller/logoutController.php">Logout</a>
            </li> -->
            
        </ul>
        
    </ul>
</body>

</html>