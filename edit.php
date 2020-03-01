<?php
session_start();
require_once "pdo.php";

if(!isset($_SESSION['user'])) {
  die('You must be logged in to view this page.');
}

//Find the auto to edit or redirect to index if it doesn't exist
$stmt=$pdo->prepare("SELECT * FROM autos WHERE autoID = :autoid");
$stmt->execute(array(":autoid" => $_GET['auto']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
  $_SESSION['error'] = "Invalid autoID";
  header("Location: index.php");
  return;
}

//Data validation from form submission
if(isset($_POST['make']) && isset($_POST['model']) &&
   isset($_POST['year']) && isset($_POST['mileage'])) {
  echo "test";
  if(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: edit.php?auto=".$row['autoID']);
    return;
  }
  if(!is_numeric($_POST['year'])) {
    $_SESSION['error'] = "Year must be numeric.";
    header("Location: edit.php?auto=".$row['autoID']);
    return;
  }
  if(!is_numeric($_POST['mileage'])) {
    $_SESSION['error'] = "Mileage must be numeric.";
    header("Location: edit.php?auto=".$row['autoID']);
    return;
  }

  $sql="UPDATE autos SET make=:make, model=:model, year=:year, mileage=:mileage
        WHERE autoID = :autoID";
  $stmt=$pdo->prepare($sql);
  $stmt->execute(array(
    ':make' => $_POST['make'],
    ':model' => $_POST['model'],
    ':year' => $_POST['year'],
    ':mileage' => $_POST['mileage'],
    ':autoID' => $_POST['autoid']
    )
  );
  $_SESSION['success'] = "Record updated.";
  header("Location: index.php");
  return;
}

//Data validation from redirect
if(!isset($_GET['auto'])) {
  $_SESSION['error'] = "Invalid autoID";
  header("Location: index.php");
  return;
}
?>
<html>
<head>
  <title>Automobile Tracker</title>
</head>
<body>
  <?php
  if (isset($_SESSION['error'])) {
    echo '<p style="color: red;">'.$_SESSION['error'];
    unset($_SESSION['error']);
  }
  ?>
  <h1>Edit Automobile</h1>
  <form method="post">
    <p>Make: <input type="text" name="make" value="<?=$row['make']?>"></p>
    <p>Model: <input type="text" name="model" value="<?=$row['model']?>"></p>
    <p>Year: <input type="text" name="year" value="<?=$row['year']?>"></p>
    <p>Mileage: <input type="text" name="mileage" value="<?=$row['mileage']?>"></p>
    <input type="hidden" name="autoid" value="<?=$row['autoID']?>">
    <p><input type="submit" value="Save Changes"> <a href="index.php">Cancel</a></p>
  </form>
</body>
</html>
