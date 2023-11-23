<?php

    function checkData($string, $max_length){
        if(empty($string) || $string=="" || $string==null || strlen($string > $max_length)){
            return false;
        }
        return true;
    }

    if($_SERVER['REQUEST_METHOD']==="POST"){
        if (isset($_POST['send'])) {
            $userID = $_SESSION['userID'];
            $user_attachment = $_FILES['user_attachment'];

            $target_directory = "../storage/";
            $new_file_name = uniqid() . "_" . $user_attachment['name'];

            echo $target_directory . $new_file_name;

            if (move_uploaded_file($user_attachment['tmp_name'], $target_directory . $new_file_name)) {
                echo "Document uploaded!";
            }
            else echo "Document failed to upload!";

            if($user_attachment['size'] > 5*1000*1000){
                echo "File size exceeded limit!";
                $_SESSION['error_message'] = "File size exceeded limit";
            }
            
            $query = "INSERT INTO vaccineDocument (userID, user_file) VALUES ('$userID','$new_file_path')";
            $result = $db->query($query);
            $db->close();
        }

    }


?>

