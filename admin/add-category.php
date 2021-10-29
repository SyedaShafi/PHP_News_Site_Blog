<?php include "header.php";
include_once "config.php";
if ($_SESSION['user_role'] == 0) {
    header("Location: $hostname/admin/post.php");
}

if (isset($_POST['save'])) {
    $categoryName = mysqli_real_escape_string($conn, $_POST['category']);
    $sql = "SELECT * FROM category WHERE category_name = '{$categoryName}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "<p style='color:red; text-align:center; margin: 10px 0px;'> Category already exists</p>";
    } else {
        $sql1 = "INSERT INTO category (category_name)
                VALUES('{$categoryName}')";


        if (mysqli_query($conn, $sql1)) {
            header("Location: $hostname/admin/category.php");

        } else {
            header("Location: $hostname/admin/add-category.php");
            echo "<p style='color:red; text-align:center; margin: 10px 0px;'>Query Failed</p>";
            
        }
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
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="category" class="form-control" placeholder="Category Name" required>
                    </div>

                    <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                </form>
                <!-- Form End-->
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>