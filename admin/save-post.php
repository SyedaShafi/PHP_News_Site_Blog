<?php
include_once "config.php";

if (isset($_POST['submit'])) {

    $errors = array();

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_end = explode('.', $file_name);
    $file_ext = strtolower(end($file_end));
   

    $extensions = array('jpeg', 'jpg', 'png');

    if (!in_array($file_ext, $extensions)) {
        $errors[] = "This file is not allowed. Please choose a JPG or PNG file.";
    }
    if ($file_size > 3000000) {
        $errors[] = "File size must be 2MB or lower.";
    }

    $new_file_name = uniqid('',true). "." .$file_ext;
    $target = "upload/".$new_file_name;

    if (empty($errors)) {

        move_uploaded_file($file_tmp_name, $target);
    } else {
        print_r($errors);
        print_r( $_FILES['fileToUpload']);
        die();
    }
}

session_start();
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d M, Y");
$author = $_SESSION['user_id'];

$sql = "INSERT INTO post(title, description, category, post_date, author, post_img)
        VALUES('{$title}', '{$description}', '{$category}', '{$date}', '{$author}', '{$new_file_name}');";

$sql.="UPDATE category SET post=post+1 WHERE category_id = '{$category}'";

if(mysqli_multi_query($conn, $sql))
{
    header("Location: $hostname/admin/post.php");

}
else{
    echo "<p style='color:red; text-align:center; margin:10px 0px;'> Query Failed</p>";
}

?>