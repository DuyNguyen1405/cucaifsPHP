<!DOCTYPE html>

<head>
  <title>Củ cải fansub</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="../images/shortcut.png">
  <link href="../style/default.css" rel="stylesheet" type="text/css" />
</head>

<body>

  <div id="page">
    <div id="header">
      <a href="../index.php">
        <img class="logo" src="../images/logo.png" alt="">
      </a>
    </div>

    <div id="body">
      <div class="login" align="center">
        <h2>
<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if (empty($_POST['username']) || empty($_POST['password'])){
  echo "Invalid Username or Password!";
  header("refresh:1;url=loginform.php");
}
else{
  $servername="166.62.10.137"; // Host name
  $username=("cucaiauthor");
  $password=test_input($_POST['password']);
  $database="cucaibeta";
  
  $con = @new mysqli($servername, $username, $password, $database);
  if ($con->connect_errno) {
    echo "Wrong Username or Password!</h2>
    </div>
    </div>
    </div>
    </body>
    </html>";
    header("refresh:1;url=loginform.php");
  }
  else{
    echo "Successfully logged in!</div>
    </div>
    </div>
    </body>
    </html>";
    session_start();
    $_SESSION["loguser"] = $_POST['username'];
    $_SESSION["logpass"] = $password;
    header("refresh:1;url=index.php");
  }
  }
?>
