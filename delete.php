<?php
session_start();
require_once "pdo.php";

if(!isset($_SESSION['user'])) {
  die('You must be logged in to view this page.');
}

//Find the auto to delete or redirect to index if it doesn't exist
$stmt=$pdo->prepare("SELECT * FROM autos WHERE autoID = :autoid");
$stmt->execute(array(':autoid' => $_GET['auto']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if($row === false) {
  $_SESSION['error'] = "Invalid autoID.";
  header("Location: index.php");
  return;
} else {
  $autoToDelete = $row['year']." ".$row['make']." ".$row['model']." with ".$row['mileage']." miles";
}

//Data validation from form submission (Delete confirmation)
if(isset($_POST['delete']) && isset($_POST['autoid'])) {
  $stmt=$pdo->prepare("DELETE FROM autos WHERE autoID = :autoid");
  $stmt->execute(array(':autoid' => $_POST['autoid']));
  $_SESSION['success'] = "Record deleted";
  header("Location: index.php");
  return;
}

//Data validation from redirect
if(!isset($_GET['auto'])) {
  $_SESSION['error']="Invalid autoID.";
  header("Location: index.php");
  return;
}
?>
<html>
<head>
  <title>Automobile Tracker</title>
</head>
<body>
  <h1>Delete Automobile</h1>
  <p>Are you sure you want to delete: <?=htmlentities($autoToDelete)?>?</p>
  <form method="post">
    <input type="hidden" name="autoid" value="<?=htmlentities($row['autoID'])?>">
    <p><input type="submit" name="delete" value="Delete">
      <a href="index.php">Cancel</a>
    </p>
  </form>
</body>
</html>
