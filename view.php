<?php
/*This file is no longer being used. It is from a previous implementation
*/
session_start();
require_once "pdo.php";
if (!isset($_SESSION['user'])) {
  die('You must be logged in to view this page.');
}
?>
<html>
<head>
  <title>Automobile Tracker</title>
</head>
<body>
  <h1>Welcome, <?php echo $_SESSION['user']; ?>!</h1>
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
  } ?>
</body>
</html>
