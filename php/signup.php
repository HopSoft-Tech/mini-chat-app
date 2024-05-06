<?php
session_start();
include 'config.php';

// mysqli_real_escape_string is used to prevent sql injection by escaping special characters in a string
// Extract the data from the posted form
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
// Check if the fields are not empty
if (!empty($fname) and !empty($lname) and  !empty($email) and  !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if the email already exist in the database
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' ");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email - This email already exist!";
        } else {
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                // Use pathinfo() to extract the filename and extension
                $img_info = pathinfo($img_name);
                $img_ext = strtolower($img_info['extension']);
                // get the base name of the image
                $img_base_name = $img_info['filename'];

                $extensions = ["jpeg", "png", "jpg", "gif"];

                if (in_array($img_ext, $extensions)) {
                    $types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];

                    if (in_array($img_type, $types)) {
                        $time = time();
                        $new_img_name = $time . '_img.' . $img_ext;
                        if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                            // the code below generates a unique id for each user
                            // would generate a random number between the current Unix timestamp (or the time at which the code is executed) and 100,000,000.
                            $ran_id = rand(time(), 100000000);
                            $status = "Active now"; // set the status to active by default
                            // Encrypt the password using md5 function and store it in the database
                            $encrypt_pass = md5($password);
                            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
							VALUES ($ran_id, '{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                            if ($insert_query) {
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if (mysqli_num_rows($select_sql2) > 0) {
                                    $result = mysqli_fetch_assoc($select_sql2);
                                    // Store the unique id in the session
                                    $_SESSION['unique_id'] = $result['unique_id'];
                                    echo "success";
                                } else {
                                    echo "This email address does not Exist!";
                                }
                            } else {
                                echo "Something went wrong. Please try again!";
                            }
                        }
                    } else {
                        echo "Please upload the correct image filetype - jpeg, png, jpg, gif";
                    }
                } else {
                    echo "Please upload a correct image file extension - jpeg, png, jpg gif";
                }
            }
        }
    } else {
        echo "$email is not a valid email!";
    }
} else {
    echo "All inputs fields are required!";
}
