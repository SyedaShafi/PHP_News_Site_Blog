<?php include 'header.php'; ?>
<div id="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php
                    if (isset($_GET['cid'])) {
                        $category_id = $_GET['cid'];
                        include "admin/config.php";
                        $sql1 = "SELECT * FROM category WHERE category_id = $category_id";
                        $result1 = mysqli_query($conn, $sql1) or die("Query failed in line 13");
                        $row1 = mysqli_fetch_assoc($result1);

                        echo "<h2 class='page-heading'>{$row1['category_name']}" . " " . " News</h2>";

                        $limit = 3;
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $offset = ($page - 1) * $limit;

                        $sql = "SELECT post.post_id, post.post_img, post.title, post.author, category.category_name, post.category, user.username, post.post_date, post.description FROM post
                            LEFT JOIN category ON category.category_id = post.category
                            LEFT JOIN user ON user.user_id = post.author
                            WHERE post.category = {$category_id}
                            ORDER BY post.post_id DESC LIMIT {$offset},{$limit}";

                        $result = mysqli_query($conn, $sql) or die("Query Failed:  In the category.");
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                                <div class="post-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <a class="post-img" href='single.php?id=<?php echo $row['post_id']; ?>'><img src="admin/upload/<?php echo $row['post_img']; ?>" alt="" /></a>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="inner-content clearfix">
                                                <h3><a href='single.php?id=<?php echo $row['post_id']; ?>'><?php echo $row['title']; ?></a></h3>
                                                <div class="post-information">
                                                    <span>
                                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                                        <a href='category.php?cid=<?php echo $row['category'] ?>'><?php echo $row['category_name']; ?></a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row['username']; ?></a>
                                                    </span>
                                                    <span>
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        <?php echo $row['post_date']; ?>
                                                    </span>
                                                </div>
                                                <p class="description">
                                                    <?php echo substr($row['description'], 0, 100) . "..."; ?>
                                                </p>
                                                <a class='read-more pull-right' href='single.php?id=<?php echo $row['post_id']; ?>'>read more</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php

                            }
                        }
                        ?>


                        <!--show pagination -->
                    <?php
                        echo "<ul class='pagination admin-pagination'>";


                        $total_records = $row1['post'];
                        $total_pages = ceil($total_records / $limit);

                        if ($page > 1) {
                            echo "<li><a href='category.php?page=" . ($page - 1) . "&cid={$category_id}'>Prev</a></li>";
                        }
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                $active = "active";
                            } else {
                                $active = "";
                            }
                            echo "<li class = '{$active}'><a href='category.php?page={$i}&cid={$category_id}'>$i</a></li>";
                        }
                        if ($page < $total_pages) {
                            echo "<li><a href='category.php?page=" . ($page + 1) . "&cid={$category_id}'>Next</a></li>";
                        }


                        echo "</ul>";
                    } else {
                        echo "<h2>No record found</h2>";
                    }
                    ?>


                    <!-- <ul class="pagination admin-pagination">
                        <li><a href="">Prev</a></li>
                        <li><a href="">1</a></li>
                        <li><a href="">Next</a></li>
                    </ul> -->


                </div>
                <!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>