<div id="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <?php
        include "admin/config.php";
        $sql = "SELECT * FROM settings";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<span>{$row['footer']}</span>";
          }
        }
        ?>

        <!-- © Copyright 2019 News | Powered by <a href='http://yahoobaba.net/'>Yahoo Baba</a> -->

      </div>
    </div>
  </div>
</div>
</body>