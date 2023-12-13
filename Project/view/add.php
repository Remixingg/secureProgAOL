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
    <title>VaccMe | Add Document</title>
</head>

<body>
    <h1>Add vaccine document</h1>
    <div>
        <form action="../controller/documentController.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="description" placeholder="description">
            <input type="file" name="user_file" id="file">
            <input type="submit" name="submit" value="Add">
        </form>
    </div>
</body>

</html>