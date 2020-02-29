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
if(isset($_SESSION['success'])) {
  echo '<p style="color:green;">'.$_SESSION['success']."</p>";
  unset($_SESSION['success']);
}
if(isset($_SESSION['error'])) {
  echo '<p style="color:red;">'.$_SESSION['error']."</p>";
  unset($_SESSION['error']);
}

if (!isset($_SESSION['user'])) {
  echo '<h1>Welcome!</h1>';
  echo '<p>Please <a href="login.php">Login</a></p>';
  echo '<p>Go to <a href="add.php">add.php</a> without logging in - this should fail.</p>';
} else {
  echo '<h1>Welcome, '.$_SESSION['user'].'</h1>';
  echo '<h2>Saved Automobiles</h2>';
  $stmt=$pdo->query("SELECT * FROM autos");
  $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
  if($rows !== false) {
    echo '<table border="1">';
      echo "<tr>";
        echo "<td>Make</td>";
        echo "<td>Model</td>";
        echo "<td>Year</td>";
        echo "<td>Mileage</td>";
        echo "<td>Action</td>";
      echo "</tr>";
      foreach($rows as $row) {
        echo "<tr>";
          echo "<td>".$row['make']."</td>";
          echo "<td>".$row['model']."</td>";
          echo "<td>".$row['year']."</td>";
          echo "<td>".$row['mileage']."</td>";
          echo '<td><a href="edit.php?auto='.$row['autoID'].'">Edit</a> / ';
          echo '<a href="delete.php?auto='.$row['autoID'].'">Delete</a> </td>';
        echo "</tr>";
      }
    echo "</table>";
  } else {
    echo "<p>No automobiles saved yet. Try adding some.</p>";
  }
  echo '<p><a href="add.php">Add New Entry</a></p>';
  echo '<p><a href="logout.php">Logout</a></p>';
}
?>
</body>
</html>
