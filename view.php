<?php
session_start();
?>
<html>
<head>
  <title>Automobile Tracker</title>
</head>
<body>
  <?php
  if (!isset($_SESSION['user'])) {
    echo '<p>Please <a href="login.php>log in</a>.</p>';
  } else { ?>
    <h1>Welcome!</h1>
    <p><a href="add.php">Add New</a> | <a href="logout.php">Log out</a></p>
  <?php } ?>
</body>
</html>
