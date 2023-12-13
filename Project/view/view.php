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
    <title>VaccMe | View Document</title>
</head>

<body>
    <h1>View vaccine documents</h1>
    <?php
        include '../config/connect.php';
        $query = "SELECT * FROM document";
        $view = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($view))
        {
    ?>
        <tr style="display: flex; flex-direction: row;">
            <td>UserID: <?php echo $row['userID'] ?></td>
            <td>Description:<?php echo $row['description'] ?></td>
            <td>test--<?php echo $row['image'] ?></td>
            <td>Image:<img src="../storage/<?php echo $row['image']?>.png"></td>
        </tr>
    <?php
        }
    ?>
</body>

</html>