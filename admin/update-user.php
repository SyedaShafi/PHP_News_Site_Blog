<?php include "header.php";
if ($_SESSION['user_role'] == 0) {
    header("Location: $hostname/admin/post.php");
}

include_once "config.php";
$userId = $_GET['id'];

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Modify User Details</h1>
            </div>
            <div class="col-md-offset-4 col-md-4">

                <?php

               
                $sql = "SELECT * FROM user WHERE user_id='{$userId}'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>
                        <!-- Form Start -->
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" class="form-control" value="<?php echo $row['user_id']; ?>">
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="f_name" class="form-control" value="<?php echo $row['first_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="l_name" class="form-control" value="<?php echo $row['last_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>User Role</label>
                                <select class="form-control" name="role" value="<?php echo $row['role']; ?>">
                                    <?php
                                    if ($row['role'] == 1) {
                                        echo "<option value='0'>Normal User</option>
                                        <option value='1' selected>Admin</option> ";
                                    } else {
                                        echo "<option value='0' selected>Normal User</option>
                                        <option value='1' >Admin</option> ";
                                    }
                                    ?>


                                </select>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                        </form>
                        <!-- /Form -->

                <?php

                    }
                }

                if (isset($_POST['submit'])) {
                   
                    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
                    $fname = mysqli_real_escape_string($conn, $_POST['f_name']);
                    $lname =  mysqli_real_escape_string($conn, $_POST['l_name']);
                    $userName =  mysqli_real_escape_string($conn, $_POST['username']);
                    $role = mysqli_real_escape_string($conn, $_POST['role']);

                    $sql1 = "UPDATE user SET first_name = '{$fname}', last_name = '{$lname}', username = '{$userName}', role = '{$role}' 
                            WHERE user_id = {$user_id}";
                    mysqli_query($conn, $sql1);

                    header("Location: $hostname/admin/users.php");
                }
                ?>

            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>