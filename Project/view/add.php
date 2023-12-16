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

<?php
    // var_dump($_SESSION['error_message_register']);
    // die();
    if(isset($_SESSION['document_error'])) {
        // if($_GET['error']) {
            $error_message = $_SESSION['document_error'];
            echo "<div>$error_message</div>";
            unset($_SESSION['document_error']);
        // }
    }
?>

<body>
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
    </ul>

    <h1>Add vaccine document</h1>
    <div>
        <form action="../controller/documentController.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="description" placeholder="description">
            <input type="file" name="user_file" accept=".jpg, .jpeg, .png" id="file">
            <input type="submit" name="submit" value="Add">
        </form>
    </div>
</body>

</html>