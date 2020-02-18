<?php
//contains PDO object called $pdo
require_once "pdo.php";

//email = lana@fake.com
//password = password
//stored password is hashed with this salt
$salt='XyZzy12*_';
$failure=false;

if (isset($_POST['email']) && isset($_POST['pass'])) {
  if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
    $failure="Email and password are required";
  } elseif (strpos($_POST['email'], '@') === false) {
    $failure="Please enter a valid email address";
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
      $failure = "Email or password is incorrect.";
      error_log("Login fail ".$_POST['email']." $check");
    } else {
      error_log("Login success ".$_POST['email']);
      header("Location: autos.php?user=".urlencode($row['name']));
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
  if ($failure !== false) {
    echo '<p style="color:red;">'.htmlentities($failure).'</p>';
  }
  ?>
  <form method="post">
    <p>Email: <input type="text" name="email"></p>
    <p>Password: <input type="password" name="pass"></p>
    <p><input type="submit" value="Log in">
  </form>
</body>
</html>
