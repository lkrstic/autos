<?php
session_start();
require_once "pdo.php";

if (!isset($_SESSION['user'])) {
  die('You must be logged in to use this page.');
}

if (isset($_POST['cancel'])) {
  header("Location: index.php");
  return;
}

if (isset($_POST['make']) && isset($_POST['model']) &&
    isset($_POST['year']) && isset($_POST['mileage']) ) {
  if (strlen($_POST['make']) < 1) {
    $_SESSION['error'] = "Make is required.";
    header("Location: add.php");
    return;
  } elseif (strlen($_POST['model']) < 1) {
    $_SESSION['error'] = "Model is required.";
    header("Location: add.php");
    return;
  } elseif (!is_numeric($_POST['year'])) {
    $_SESSION['error'] = "Year must be numeric.";
    header("Location: add.php");
    return;
  } elseif (!is_numeric($_POST['mileage'])) {
    $_SESSION['error'] = "Mileage must be numeric.";
    header("Location: add.php");
    return;
  } else {
    $sql = "INSERT INTO autos (make, model, year, mileage)
            VALUES (:make, :model, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':make' => $_POST['make'],
      ':model' => $_POST['model'],
      ':year' => $_POST['year'],
      ':mileage' => $_POST['mileage']
      )
    );
    $_SESSION['success'] = "Record Added.";
    header("Location: index.php");
    return;
  }
}
?>
<html>
<head>
  <title>Automobile Tracker</title>
</head>
<body>
  <h1>Add a New Automobile</h1>
  <?php
  if (isset($_SESSION['error'])) {
    echo '<p style="color:red;">'.$_SESSION['error']."</p>";
    unset($_SESSION['error']);
  }
  ?>
  <form method="post">
    <p>Make: <input type="text" name="make"></p>
    <p>Model: <input type="text" name="model"></p>
    <p>Year: <input type="text" name="year"></p>
    <p>Mileage: <input type="text" name="mileage"></p>
    <p><input type="submit" value="Add">
      <input type="submit" value="Cancel" name="cancel">
    </p>
  </form>
</body>
</html>
