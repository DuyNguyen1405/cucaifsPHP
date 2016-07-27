<?php
session_start();
if(!isset($_SESSION['loguser'])||!isset($_SESSION['loguser'])){
  echo "<h2>Please log in!</h2>";
  header("refresh:1;url=loginform.php");
  die(1);
}

$username = "cucaiauthor";
$password = $_SESSION['logpass'];
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

$name=$_POST['name'];
$preview=$_POST['preview'];
$caption=$_POST['caption'];
$linkdl=$_POST['linkdl'];
$tags=$_POST['tags'];

$stmt = $con->prepare("INSERT INTO series VALUES ('',?,?,?,?,?,CURDATE(),0)");
$stmt->bind_param("sssss", $name, $preview,$caption,$linkdl,$tags);
$stmt->execute();

$stmt = $con->prepare("SELECT seriesID FROM series where name = ?");
$stmt->bind_param("s", $name);
$name=$_POST['name'];
$stmt->execute();
$stmt->bind_result($col01);
$stmt->fetch();
$seriesID=$col01;
$stmt->close();

$stmt = $con->prepare("SELECT memID FROM mems where username = ?");
$stmt->bind_param("s", $search);
$search = $_SESSION['loguser'];
$stmt->execute();
$stmt->bind_result($col02);
$stmt->fetch();
$userID=$col02;
$stmt->close();

$stmt = $con->prepare("INSERT INTO trans VALUES (?,?)");
$stmt->bind_param("ii", $userID, $seriesID);
$stmt->execute();
$stmt->close();

$con->close();
echo "Series ID $seriesID added by $search!";
header("refresh:2;url=index.php");
?>
