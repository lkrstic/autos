<?php
/*This file is no longer being used. It is from a previous implementation.
It can be accessed using a query string ?user=<someone>
*/

//contains PDO object called $pdo
require_once "pdo.php";

$failure = false;

if (isset($_POST['logout'])) {
  header('location: index.php');
  return;
}

if (!isset($_GET['user'])) {
  die('You must log in first');
}

if (isset($_POST['make']) && isset($_POST['model']) &&
    isset($_POST['year']) && isset($_POST['mileage'])) {
  if (strlen($_POST['make']) < 1) {
    $failure="Make is required.<br>";
  } elseif (strlen($_POST['model']) < 1) {
    $failure="Model is required.<br>";
  } elseif (!is_numeric($_POST['year'])) {
    $failure="Year must be numeric.<br>";
  } elseif (!is_numeric($_POST['mileage'])) {
    $failure="Mileage must be numeric.<br>";
  } else {
    $sql="INSERT INTO autos (make, model, year, mileage)
          VALUES (:make, :model, :year, :mileage)";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(
      array(
      ':make' => $_POST['make'],
      ':model' => $_POST['model'],
      ':year' => $_POST['year'],
      ':mileage' => $_POST['mileage']
      )
    );
  }
}

?>
<html>
<head>
  <title>Automobile Tracker</title>
</head>
<body>
  <h1>Automobile Tracker</h1>
  <?php
  if ($failure !== false) {
    echo '<p style="color:red;">'.$failure."</p>";
  }
  ?>
  <p>Please insert auto details.</p>
  <form method="post">
    <p>Make: <input type="text" name="make"></p>
    <p>Model: <input type="text" name="model"></p>
    <p>Year: <input type="text" name="year"></p>
    <p>Mileage: <input type="text" name="mileage"></p>
    <p><input type="submit" value="Add Automobile">
      <input type="submit" value="Logout" name="logout">
    </p>
  </form>
  <h1>Saved Automobiles</h1>
  <?php
  $stmt=$pdo->query("SELECT * FROM autos");
  $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($rows !== false) {
    echo '<table border="1">';
    echo "<tr>";
    echo "<td>Make</td>";
    echo "<td>Model</td>";
    echo "<td>Year</td>";
    echo "<td>Mileage</td>";
    echo "<td>Delete (coming soon)</td>";
    echo "</tr>";
    foreach($rows as $row) {
      echo "<tr><td>";
      echo $row['make'];
      echo "</td><td>";
      echo $row['model'];
      echo "</td><td>";
      echo $row['year'];
      echo "</td><td>";
      echo $row['mileage'];
      echo "</td><td>";
      //delete doesn't do anything yet
      echo '<form method="post"><input type="hidden" name="autoid" value='.$row['autoID'].'>';
      echo '<input type="submit" value="Delete" name="delete">';
      echo "</td></tr>";
    }
  } else {
    echo "There are no automobiles in the database yet. Try adding some.";
  }
  ?>
</body>
</html>
