<?php include "header.php";
if ($_SESSION['user_role'] == 0) {
    header("Location: $hostname/admin/post.php");
}

include_once "config.php";



if (isset($_POST['save'])) {
    // $updated_category = mysqli_real_escape_string($conn, $_POST['category']);
    $sql = "UPDATE category SET category_name = '{$_POST['category']}' WHERE category_id = '{$_POST['categoryId']}'";
    if (mysqli_query($conn, $sql)) {

        header("Location:$hostname/admin/category.php");
    }
}

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="admin-heading">Add Category</h1>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <!-- Form Start -->
                <?php
                $id =  $_GET['id'];
                $sql1 = "SELECT * FROM category WHERE category_id = '{$id}'";
                $result1 = mysqli_query($conn, $sql1);

                if (mysqli_num_rows($result1) > 0) {
                    while ($row1 = mysqli_fetch_assoc($result1)) {

                ?>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off">

                            <div class="form-group">
                                <input type="hidden" name="categoryId" class="form-control" value="<?php echo $row1['category_id']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="category" class="form-control" value="<?php echo $row1['category_name']; ?>" placeholder="" required>
                            </div>

                            <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                        </form>
                <?php

                    }
                }

                ?>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>