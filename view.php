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
    <h1>Welcome!</h1>
    <p><a href="add.php">Add New</a> | <a href="logout.php">Log out</a></p>
    <h2>Saved Automobiles</h2>
    <?php
    $stmt=$pdo->query("SELECT * FROM autos");
    $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows == false) {
      echo "<p>No automobiles saved yet. Try adding some.</p>";
    } else {
      echo "<ul>";
      foreach ($rows as $row) {
        echo "<li>".$row['year']." ".$row['make']." ".$row['model']." - ".$row['mileage']." miles</li>";
      }
      echo "</ul>";
    }
  } ?>
</body>
</html>
