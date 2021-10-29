<?php
include "config.php";
// echo "file name : ". $_FILES['logo']['name'];
// die();

if (!empty($_FILES['logo']['name'])) {

    if (isset($_POST['submit'])) {
        $errors = array();

        $file_name = $_FILES['logo']['name'];
        $file_size = $_FILES['logo']['size'];
        $file_type = $_FILES['logo']['type'];
        $file_tmp_name = $_FILES['logo']['tmp_name'];
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
        $target = "images/$new_file_name";

        if (empty($errors)) {
            move_uploaded_file($file_tmp_name, $target);
        } else {
            print_r($errors);
            die();
        }
    }
} else {
    $new_file_name = $_POST['old_logo'];
}

$website_name = $_POST['website_name'];
$footer = $_POST['footer_desc'];


$sql = "UPDATE settings SET websitename='{$website_name}', logo='{$new_file_name}', footer='{$footer}'";


if (mysqli_query($conn, $sql)) {
    header("Location: $hostname/admin/settings.php");
} else {
    die("Query Failed.");
}
