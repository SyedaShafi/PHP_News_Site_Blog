<?php
include_once "config.php";
$userId = $_GET['id'];

$sql = "DELETE FROM user WHERE user_id = '{$userId}'";
if(mysqli_query($conn, $sql)){
    header("Location: $hostname/admin/users.php");
}
else{
    echo "<p class='alert alert-danger'> Can't delete the user</p>";
}


?>