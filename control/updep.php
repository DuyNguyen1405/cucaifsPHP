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

$epnum=$_POST['epnum'];
$preview=$_POST['preview'];
$caption=$_POST['caption'];
$linkdl=$_POST['linkdl'];
$linkstr=$_POST['linkstr'];

$stmt = $con->prepare("SELECT epID FROM ep WHERE seriesID = ? and epnum = ?");
$stmt->bind_param("ii", $seriesID, $epnum);
$stmt->execute();
$stmt->bind_result($col03);
$stmt->fetch();
$exist=$col03;
$stmt->close();
//echo "<h1>Exist($exist)</h1>";
if(!empty($exist))
{
  echo "Ep existed! Updating info...<br>";

  if (!empty($preview)){
  $stmt = $con->prepare("UPDATE ep SET preview =  ?  WHERE seriesID= ? AND epnum= ? ");
  $stmt->bind_param("sii", $preview ,$seriesID, $epnum);
  $stmt->execute();
  $stmt->close();
  }
  if (!empty($caption)){
  $stmt = $con->prepare("UPDATE ep SET caption =  ?  WHERE seriesID= ? AND epnum= ? ");
  $stmt->bind_param("sii", $caption ,$seriesID, $epnum);
  $stmt->execute();
  $stmt->close();
  }
  if (!empty($linkdl)){
  $stmt = $con->prepare("UPDATE ep SET linkdl =  ?  WHERE seriesID= ? AND epnum= ? ");
  $stmt->bind_param("sii", $linkdl ,$seriesID, $epnum);
  $stmt->execute();
  $stmt->close();
  }
  if (!empty($linkstr)){
  $stmt = $con->prepare("UPDATE ep SET linkstr =  ?  WHERE seriesID= ? AND epnum= ? ");
  $stmt->bind_param("sii", $linkstr ,$seriesID, $epnum);
  $stmt->execute();
  $stmt->close();
  }
  echo "Successfully Updated!";
}
else
{
  echo "Creating new Ep...<br>";
  $stmt = $con->prepare("INSERT INTO ep VALUES ('',?,?,?,?,?,?)");
  $stmt->bind_param("ssssss", $seriesID, $epnum, $preview, $caption, $linkstr, $linkdl);
  $stmt->execute();
  $stmt->close();
  echo "Series ID $seriesID Ep number $epnum added by $search!";
}

$stmt = $con->prepare("UPDATE series SET lastupd = CURDATE() WHERE seriesID = ?");
$stmt->bind_param("s", $seriesID);
$stmt->execute();
$stmt->close();

$con->close();
header("refresh:2;url=index.php");
?>
