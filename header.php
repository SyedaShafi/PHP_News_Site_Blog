<?php
include "admin/config.php";
$page = basename($_SERVER['PHP_SELF']);
switch ($page) {

  case "single.php":
    if (isset($_GET['id'])) {
      $sql_title = "SELECT * FROM post WHERE post_id = {$_GET['id']}";
      $result_title = mysqli_query($conn, $sql_title) or die("Query failed in header.php line 9");
      $row_title = mysqli_fetch_assoc($result_title);
      $page_title = $row_title['title'];
    } else {
      $page_title = "No post found";
    }
    break;

  case "category.php":
    if (isset($_GET['cid'])) {
      $sql_title = "SELECT * FROM category WHERE category_id = {$_GET['cid']}";
      $result_title = mysqli_query($conn, $sql_title) or die("Query failed in header.php line 20");
      $row_title = mysqli_fetch_assoc($result_title);
      $page_title = $row_title['category_name'] . " News";
    } else {
      $page_title = "No post found";
    }
    break;

  case "author.php":
    if (isset($_GET['aid'])) {
      $sql_title = "SELECT * FROM user WHERE user_id= {$_GET['aid']}";
      $result_title = mysqli_query($conn, $sql_title) or die("Query failed in header.php line 20");
      $row_title = mysqli_fetch_assoc($result_title);
      $page_title = "News by " . $row_title['username'];
    } else {
      $page_title = "No post found";
    }
    break;

  case "search.php":
    if (isset($_GET['search'])) {

      $page_title = $_GET['search'];
    } else {
      $page_title = "No search result found";
    }
    break;

  default:
    $page_title = "News Site";
    break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title><?php echo $page_title; ?></title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <!-- Font Awesome Icon -->
  <link rel="stylesheet" href="css/font-awesome.css">
  <!-- Custom stlylesheet -->
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- HEADER -->
  <div id="header">
    <!-- container -->
    <div class="container">
      <!-- row -->
      <div class="row">
        <!-- LOGO -->
        <div class=" col-md-offset-4 col-md-4">

          <?php
          $sql_logo = "SELECT * FROM settings";
          $result_logo = mysqli_query($conn, $sql_logo);
          if (mysqli_num_rows($result_logo)) {
            while ($row_logo = mysqli_fetch_assoc($result_logo)) {
              if (empty($row_logo['logo'])) {
                echo " <a href='index.php'><h1>{$row_logo['websitename']}</h1></a>";
              } else {
                echo "<a href='index.php' id='logo'><img src='admin/images/{$row_logo['logo']}'></a>";
              }
            }
          }

          ?>
        </div>
        <!-- /LOGO -->
      </div>
    </div>
  </div>
  <!-- /HEADER -->
  <!-- Menu Bar -->
  <div id="menu-bar">
    <div class="container">
      <div class="row">
        <div class="col-md-12">

          <?php
          include "admin/config.php";
          if (isset($_GET['cid'])) {
            $category_id = $_GET['cid'];
          }

          $sql = "SELECT * FROM category WHERE post > 0";
          $result = mysqli_query($conn, $sql) or die("Query Failed : in the header query for category menu");
          if (mysqli_num_rows($result) > 0) {

            echo "<ul class='menu'>";
            echo " <li><a href='{$hostname}'>Home</a></li>";
            while ($row = mysqli_fetch_assoc($result)) {

              if (((isset($_GET['cid'])) && $category_id == $row['category_id'])) {
                $active = "active";
              } else {
                $active = "";
              }
              echo "<li><a class = '{$active}' href='category.php?cid={$row['category_id']}'>{$row['category_name']}</a></li>";
            }
            echo " </ul>";
          }
          ?>

          <!-- <li><a href=''>Home</a></li>
            <li><a href=''>Sports</a></li>;
            <li><a href=''>Entertainment</a></li>;
            <li><a href=''>Health</a></li>; -->



        </div>
      </div>
    </div>
  </div>
  <!-- /Menu Bar -->