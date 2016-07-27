<?php
session_start();

if(!isset($_SESSION['loguser'])||!isset($_SESSION['loguser'])){
  echo "<h2>Please log in!</h2>";
  header("refresh:1;url=loginform.php");
  die(1);
}

$username="cucaiauthor";
$password=$_SESSION['logpass'];
$database="cucaibeta";
$servername="166.62.10.137";

$con = @new mysqli($servername, $username, $password, $database);
if ($con->connect_errno) {
  die('Connect Error: ' . $mysqli->connect_errno);
}
/*$sql = "SET character_set_results = 'utf8';";
mysqli_query($con, $sql);*/
mysqli_query($con,"SET NAMES 'utf8'");
mysqli_query($con,"SET CHARACTER SET utf8");
mysqli_query($con,"SET COLLATION_CONNECTION = 'utf8_unicode_ci'");

$stmt = $con->prepare("SELECT memID FROM mems where username = ?");
$stmt->bind_param("s", $search);
$search = $_SESSION['loguser'];
$stmt->execute();
$stmt->bind_result($col0);
$stmt->fetch();
if(empty($col0))
{
  echo "You are not currently a member!";
  header("refresh:1;url=index.php");
  die(1);
}
else {
  $userID=$col0;
  echo "User ID No. $userID ";
}
$stmt->close();

//$newpassword = $_POST['newpassword'];
$name = $_POST['name'];
$picture = $_POST['picture'];
$info = $_POST['info'];

if(!empty($name)){
  $stmt = $con->prepare("UPDATE mems set name = ? WHERE username = ?");
  $stmt->bind_param("ss", $name, $_SESSION['loguser']);
  $stmt->execute();
  $stmt->close();
}
if(!empty($picture)){
  $stmt = $con->prepare("UPDATE mems set picture = ? WHERE username = ?");
  $stmt->bind_param("ss", $picture, $_SESSION['loguser']);
  $stmt->execute();
  $stmt->close();
}
if(!empty($info)){
  $stmt = $con->prepare("UPDATE mems set info = ? WHERE username = ?");
  $stmt->bind_param("ss", $info, $_SESSION['loguser']);
  $stmt->execute();
  $stmt->close();
}
/*if (!empty($_POST['newpassword'])){
  echo "Setting new password...<br>";
  $sql = "SET PASSWORD FOR '$username'@'localhost' = PASSWORD('$newpassword')";
  $res = mysqli_query($con, $sql);
  if ($res) {
    echo "Set!<br>";
    session_destroy();
    header("refresh:1;url=loginform.php");
  }
  else {
    echo "Failed to set new password!";
  }
}*/
echo "Updated!<br>";
$con->close();
header("refresh:2;url=index.php");

?>
