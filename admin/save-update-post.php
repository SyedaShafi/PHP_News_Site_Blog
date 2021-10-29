<?php
include "config.php";

if (!empty($_FILES['new-image']['name'])) {

    if (isset($_POST['submit'])) {
        $errors = array();

        $file_name = $_FILES['new-image']['name'];
        $file_size = $_FILES['new-image']['size'];
        $file_type = $_FILES['new-image']['type'];
        $file_tmp_name = $_FILES['new-image']['tmp_name'];
        $file_end = end(explode('.', $file_name));
        $file_ext = strtolower($file_end);


        $extensions = array('jpeg', 'jpg', 'png');
        if (!in_array($file_ext, $extensions)) {
            $errors[] = "Please choose a jpg or png file.";
        }
        if ($file_size > 3000000) {
            $errors[] = "File size must be 2mb or lower";
        }

        $new_file_name = uniqid(" ", true) . "." . $file_ext;
        $target = "upload/$new_file_name";

        if (empty($errors)) {
            move_uploaded_file($file_tmp_name, $target);
        } else {
            print_r($errors);
            die();
        }
    }
} else {
    $new_file_name = $_POST['old_image'];
}



$id = $_POST['post_id'];

$title = $_POST['post_title'];
$description = $_POST['postdesc'];
$category = $_POST['category'];

$new_category = $_POST['category'];
$old_category = $_POST['old_category'];

$sql = "UPDATE post SET title = '{$title}', description = '{$description}', category = '{$category}', post_img = '{$new_file_name}' 
        WHERE post_id = '{$_POST['post_id']}';";
if ($new_category != $old_category) {

    $sql .= "UPDATE category SET post = post + 1 WHERE category_id = {$new_category};";
    $sql .= "UPDATE category SET post = post - 1 WHERE category_id = {$old_category}";
}

if (mysqli_multi_query($conn, $sql)) {
    header("Location: $hostname/admin/post.php");
} else {
    die("Query Failed.");
}
