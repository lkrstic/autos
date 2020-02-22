<?php
session_start();

//initializes PDO object called $pdo
require_once "pdo.php";

//email = lana@fake.com
//password = password
//stored password is hashed with this salt
$salt='XyZzy12*_';

if (isset($_POST['email']) && isset($_POST['pass'])) {
  if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
    $_SESSION['failure']="Email and password are required";
    header('Location: login.php');
    return;
  } elseif (strpos($_POST['email'], '@') === false) {
    $_SESSION['failure']="Please enter a valid email address";
    header('Location: login.php');
    return;
  } else {
    $check=hash('md5', $salt.$_POST['pass']);
    $sql="SELECT name FROM users WHERE email = :em AND password = :pw";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(array(
      ':em' => $_POST['email'],
      ':pw' => $check
      )
    );
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
      $_SESSION['failure'] = "Email or password is incorrect.";
      error_log("Login fail ".$_POST['email']." $check");
      header('Location: login.php');
      return;
    } else {
      $_SESSION['user'] = urlencode($row['name']);
      error_log("Login success ".$_POST['email']);
      header("Location: view.php");
      //old version with single page
      //header("Location: autos.php?user=".urlencode($row['name']));
      return;
    }
  }
}
?>
<html>
<head>
  <title>Auto Database Login</title>
</head>
<body>
  <h1>Please Log In</h1>
  <?php
  if (isset($_SESSION['failure'])) {
    echo '<p style="color:red;">'.htmlentities($_SESSION['failure']).'</p>';
    unset($_SESSION['failure']);
  }
  ?>
  <form method="post">
    <p>Email: <input type="text" name="email"></p>
    <p>Password: <input type="password" name="pass"></p>
    <p><input type="submit" value="Log in">
  </form>
</body>
</html>
