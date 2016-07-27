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

if ($_SESSION['loguser']!="usermanager"){
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

$name=$_POST['name'];
$preview=$_POST['preview'];
$caption=$_POST['caption'];
$linkdl=$_POST['linkdl'];
$tags=$_POST['tags'];

}
$seriesID=$_POST['seriesID'];
//$newmem=$_POST['newmemid'];
if (!empty($name)){
$stmt = $con->prepare("UPDATE series SET name =  ?  WHERE seriesID=?");
$stmt->bind_param("si", $name, $seriesID);
$stmt->execute();
$stmt->close();
}
if (!empty($preview)){
$stmt = $con->prepare("UPDATE series SET preview = ? WHERE seriesID= ?");
$stmt->bind_param("si", $preview,$seriesID);
$stmt->execute();
$stmt->close();
}
if (!empty($caption)){
$stmt = $con->prepare("UPDATE series SET caption = ? WHERE seriesID= ?");
$stmt->bind_param("si", $caption,$seriesID);
$stmt->execute();
$stmt->close();
}
if (!empty($linkdl)){
$stmt = $con->prepare("UPDATE series SET linkdl = ? WHERE seriesID= ?");
$stmt->bind_param("si", $linkdl,$seriesID);
$stmt->execute();
$stmt->close();
}
if (!empty($tags)){
$stmt = $con->prepare("UPDATE series SET tags = ? WHERE seriesID= ?");
$stmt->bind_param("si", $tags,$seriesID);
$stmt->execute();
$stmt->close();
}
if (isset($_POST['finished'])){
  $stmt = $con->prepare("UPDATE series SET finished = ? WHERE seriesID= ?");
  $stmt->bind_param("ii", $finished,$seriesID);
  $finished=$_POST['finished'];
  $stmt->execute();
  $stmt->close();
}
/*if (!empty($newmem)){
  $stmt = $con->prepare("SELECT * FROM mems where memID = ?");
  $stmt->bind_param("s", $newmem);
  $stmt->execute();
  $result=$stmt->get_result();
  $row = $result->fetch_row();
  if(empty($row[0]))
  {
    header("refresh:0; url=index.php");
    die(1);
  }

  $stmt = $con->prepare("SELECT * FROM trans WHERE memID = ? AND seriesID = ?");
  $stmt->bind_param("ii", $newmem, $seriesID);
  $stmt->execute();
  $result=$stmt->get_result();
  $row = $result->fetch_row();
  if(empty($row[0]))
  {
    $stmt = $con->prepare("INSERT INTO trans VALUE (?,?)");
    $stmt->bind_param("ii", $newmem, $seriesID);
    $stmt->execute();
  }
}*/

echo "Series ID $seriesID<br>Successfully Updated!";
mysqli_close($con);
header("refresh: 1; url=index.php");
?>
