<?php
session_start();
require_once "pdo.php";
?>

<html>
<head>
  <title>Automobile Tracker</title>
</head>
<body>
  <?php
  if (!isset($_SESSION['user'])) {
    echo '<p>Please <a href="login.php">log in</a> first.</p>';
  } else { ?>
    <h1>Add a New Automobile</h1>
    <form method="post">
      <p>Make: <input type="text" name="make"></p>
      <p>Model: <input type="text" name="model"></p>
      <p>Year: <input type="text" name="year"></p>
      <p>Mileage: <input type="text" name="mileage"></p>
      <p><input type="submit" value="Add"> <input type="submit" value="Cancel"></p>
    </form>
  <?php
  } ?>
</body>
</html>
