<!DOCTYPE html>
<?php
 session_start();

?>
<html>
<head>
  <title>Admin Login</title>
</head>
<body>
<a href="../index.php">Back to Home</a>
<form action="verify_admin.php" method="POST">
    <p>Please enter the Administrator Password</p>
      <?php

        if(isset($_SESSION['error_pop'])) {
          echo "<p style='color: red;'>".$_SESSION['error_pop']."</p>";
          unset($_SESSION['error_pop']);
        }
      ?>
    <input type="password" name="password">
    <button type="submit">Login</button>
</form>
</body>
</html>