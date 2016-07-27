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
$stmt->bind_result($col01);
$stmt->fetch();
$userID=$col01;
$stmt->close();

$seriesID = $_POST['seriesID'];

$stmt = $con->prepare("SELECT * FROM trans WHERE memID = ? AND seriesID = ?");
$stmt->bind_param("ii", $userID, $seriesID);
$stmt->execute();
$stmt->bind_result($col02,$col12);
$stmt->fetch();
if(empty($col02)&&empty($col12))
{
  echo "You can't modify this series!";
  header("refresh:1;url=index.php");
  die(1);
}
$stmt->close();

$stmt = $con->prepare("DELETE FROM series WHERE seriesID = ?");
$stmt->bind_param("i", $seriesID);
$stmt->execute();
$stmt->close();
$stmt = $con->prepare("DELETE FROM ep WHERE seriesID = ?");
$stmt->bind_param("i", $seriesID);
$stmt->execute();
$stmt->close();
echo "Series ID $seriesID<br>Successfully Deleted!";
mysqli_close($con);
header("refresh: 1; url=index.php");
?>
