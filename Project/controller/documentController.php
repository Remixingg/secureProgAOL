<?php
    session_start();
    require("../config/connect.php");
    
    if(!$_SESSION['is_login']){
        header("Location: login.php");  
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            header("Location: error.php");
            exit;
        }
    }

    if($_SERVER['REQUEST_METHOD']==="POST"){
        if (isset($_POST['submit'])) {
            $userID = $_SESSION['userID'];
            $description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);

            // echo $target_directory . $new_file_name;

            // if (move_uploaded_file($user_file['tmp_name'], $target_directory . $new_file_name)) {
            //     echo "Document uploaded!";
            // }
            // else echo "Document failed to upload!";

            // if($user_file['size'] > 5*1000*1000){
            //     echo "File size exceeded limit!";
            //     $_SESSION['error_message'] = "File size exceeded limit";
            // }
            
            // $query = "INSERT INTO vaccineDocument (userID, user_file) VALUES ('$userID','$new_file_name')";
            

            //////////////////
            // VALIDATION
            //////////////////

            // DESCRIPTION
            if(strlen($description)>=50){
                // $msg_error = "desc must be < 50 char";  
                // echo $msg_error;
                $_SESSION['document_error'] = "Description Must Be Less Than 50 Characters!";
                header("Location: ../view/add.php?error=1");
                exit();
            }
            $description_trim = trim($description);
            if ($description == '' || empty($description) || empty($description_trim)) {
                // $msg_error = "desc mustn't be empty!";
                // echo $msg_error;
                $_SESSION['document_error'] = "Description Must Not Be Empty!";
                header("Location: ../view/add.php?error=1");
                exit();
            }

            
            // IMAGE
            if (is_uploaded_file($_FILES['user_file']['tmp_name'])) {
                $user_attachment = $_FILES['user_file'];
                var_dump($user_attachment);
    
                $fileinfo = pathinfo($user_attachment['name']);
                $filename = $fileinfo['filename'];
                $fileExtension = strtolower($fileinfo['extension']);
                
                // size
                $maxSize = 7 * 1024 * 1024;
                if($user_attachment['size'] <= 0 || $user_attachment['size'] > $maxSize){
                    // echo "document too small/big";
                    // exit;
                    $_SESSION['document_error'] = "Document Size Is Too Small/Big!";
                    header("Location: ../view/add.php?error=1");
                    exit();
                }
        
                // extension
                $allowed_extension = array("jpeg", "png", ".jpg");
                if(!in_array($fileExtension, $allowed_extension)){
                    // echo "document invalid extension";
                    $_SESSION['document_error'] = "Invalid Document Extension!";
                    header("Location: ../view/add.php?error=1");
                    exit();
                }
        
                $time = time();
                $image_name = $time . $user_attachment['name'];
                $image_tmp_name = $user_attachment['tmp_name'];

                $image_path = "../storage/" . $image_name;
                $image_upload_path = "./storage/" . $image_name;
                // $new_file_name = $target_directory . $filename;

                if(!is_dir('../storage')){
                    mkdir('../storage');
                }
                
                // if (move_uploaded_file($user_attachment['tmp_name'],$new_file_name)) {
                //     echo "document upload success";
                // }
                // else {
                //     echo "document upload failed";
                // }
                // $query = "insert into document(userID,description,image) values('$userID','$description','$new_file_name')";

                move_uploaded_file($image_tmp_name, $image_path);
                $insert_data = $conn->prepare("INSERT INTO document (userID, description, image) VALUES (?, ?, ?);");
                $insert_data->bind_param("sss", $userID, $description, $image_upload_path);
                $insert_data->execute();

                header("Location: ../view/home.php");  
                die();
            }

            else {
                $_SESSION['document_error'] = "Error!";
                header("Location: ../view/add.php?error=1");
                exit();
            }

            // $result = $conn->query($query);
            $conn->close();
        }

    }


?>

