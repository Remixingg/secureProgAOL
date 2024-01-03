<?php
    session_start();
    if(!$_SESSION['is_login']){
        header("Location: login.php");  
    }
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    // timeout
    $session_timeout = 2 * 60 * 60;
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
        session_unset();
        session_destroy();
        header("Location: login.php");
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header("Location: error.php");
            exit;
        }
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
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
            <input type="submit" name="submit" value="Add">
        </form>
    </div>
</body>

</html>