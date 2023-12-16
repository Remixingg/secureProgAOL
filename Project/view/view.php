<?php
    session_start();
    require '../config/connect.php';
    if(!$_SESSION['is_login']){
        header("Location: login.php");  
    }

    // update
    if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['update'])){
        $idToUpdate = $_POST['id'];
        $newDescription = $_POST['newDescription'];

        if (!empty($newDescription) && strlen($newDescription) <= 50) {
            $updateQuery = "UPDATE document SET description = ? WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("ss", $newDescription, $idToUpdate);
            $stmt->execute();
            $stmt->close();

            $_SESSION['update_error'] = "Update success!";
            header("Location: view.php");
        } else {
            $_SESSION['update_error'] = "Description Must Be Less Than 50 Characters!";
            header("Location: ../view/view.php?error=1");
        }
    }


    // delete
    if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['delete'])){
        $idToDelete = $_POST['id'];
    
        $deleteQuery = "DELETE FROM document WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("s", $idToDelete);
        $stmt->execute();
        $stmt->close();
    
        $_SESSION['delete_message'] = "Document deleted successfully!";
        header("Location: view.php");
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VaccMe | View Document</title>
</head>

<?php
    // var_dump($_SESSION['error_message_register']);
    // die();
    if(isset($_SESSION['update_error'])) {
        // if($_GET['error']) {
            $error_message = $_SESSION['update_error'];
            echo "<div>$error_message</div>";
            unset($_SESSION['update_error']);
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

    <h1>View vaccine documents</h1>
    <?php
        include '../config/connect.php';
        $query = "SELECT * FROM document";
        $view = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($view))
        {
    ?>
        <tr>
        <div style="display: flex; flex-direction: row;">
            <div style="display: flex; flex-direction: row;">
                <td>UserID: <?php echo $row['userID'] ?></td>
                <td>Description:<?php echo $row['description'] ?></td>
                <td>Image:<img style="width: 11vw;" src=".<?php echo $row['image']?>"></td>
            </div>
            <form action="view.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <label for="newDescription">New Description:</label>
                <input type="text" name="newDescription" required>
                <input type="submit" name="update" value="Update">
                <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete this document?')">
            </form>
        </div>
        </tr>
    <?php
        }
    ?>
</body>

</html>