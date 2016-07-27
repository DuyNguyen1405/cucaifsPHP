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

        <?php
        session_start();
        if(!isset($_SESSION['loguser'])||!isset($_SESSION['loguser'])){
          echo "<h2>Please log in!</h2>";
          header("refresh:1;url=loginform.php");
          die(1);
        }

        $username = $_SESSION['loguser'];
        $password = $_SESSION['logpass'];

        if($username=="usermanager"){
          echo "<h2><span style=\"color:crimson\">$username</span></h2>";
          header("refresh:1;url=userman.php");
          die(1);
        }
        echo "<h2>User <span style=\"color:crimson\">$username</span>'s control panel</h2>";
        ?>
          <form action="logout.php" method="post">
            <input type="submit" value="Log out">
          </form>
      </div>
      <br>
      <div id="content">
        <div class="content">
          <div id=menu>
            <ul id="menu">
              <li><a href="#Series">Series</a></li>
              <li><a href="#Ep">Episode</a></li>
              <li><a href="#YourInfo">Your Info</a></li>
            </ul>
          </div>
          <br>
          <a name="Series"></a>
          <h2>Add a new series</h2>
          <form action="addsr.php" method="post">
            <div class="row">
              <label>Series Name:</label>
              <input type="text" name="name">
              <br>
            </div>
            <div class="row">
              <label>Preview:</label>
              <input type="text" name="preview">
              <br>
            </div>
            <div class="row">
              <label>Caption:</label>
              <textarea type="text" name="caption"></textarea>
              <br>
            </div>
            <div class="row">
              <label>Link Download:</label>
              <input type="text" name="linkdl">
              <br>
            </div>
            <div class="row">
              <label>Tags:</label>
              <textarea type="text" name="tags"></textarea>
              <br>
            </div>
            <input type="Submit" value="Add">
          </form>

          <h2>Update a series's info</h2>
          <form action="updsr.php" method="post">
            <div class="row">
              <label>Series ID:</label>
              <input type="text" name="seriesID">
              <br>
            </div>
            <div class="row">
              <label>Series Name:</label>
              <input type="text" name="name">
              <br>
            </div>
            <div class="row">
              <label>Preview:</label>
              <input type="text" name="preview">
              <br>
            </div>
            <div class="row">
              <label>Caption:</label>
              <textarea type="text" name="caption"></textarea>
              <br>
            </div>
            <div class="row">
              <label>Link Download:</label>
              <input type="text" name="linkdl">
              <br>
            </div>
            <div class="row">
              <label>Tags:</label>
              <textarea type="text" name="tags"></textarea>
              <br>
            </div>
            <div class="row">
              <label>Finished:</label>
              <input type="radio" name="finished" value="1">Yes
              <input type="radio" name="finished" value="0">No
              <br>
            </div>
            <br>
            <!--<div class="row">
              <label>Add Mem ID:</label>
              <input type="text" name="newmemid">
              <br>
            </div>-->

            <input type="Submit" value="Update">
          </form>
          </form>

          <h2>Delete a series</h2>
          <form action="delsr.php" method="post">
            <div class="row">
              <label>Series ID:</label>
              <input type="text" name="seriesID">
              <br>
            </div>
            <input type="Submit" value="Delete">
          </form>
          <br>

          <a name="Ep"></a>
          <h2>Add/Update an episode</h2>
          <form action="updep.php" method="post">
            <div class="row">
              <label>Series ID:</label>
              <input type="text" name="seriesID">
              <br>
            </div>
            <div class="row">
              <label>Ep Number:</label>
              <input type="text" name="epnum">
              <br>
            </div>
            <div class="row">
              <label>Preview:</label>
              <input type="text" name="preview">
              <br>
            </div>
            <div class="row">
              <label>Caption:</label>
              <textarea type="text" name="caption"></textarea>
              <br>
            </div>
            <div class="row">
              <label>Link Download:</label>
              <input type="text" name="linkdl">
              <br>
            </div>
            <div class="row">
              <label>Link Stream:</label>
              <input type="text" name="linkstr">
              <br>
            </div>
            <input type="Submit" value="Add/Update">
          </form>
          </form>
          <h2>Delete an episode</h2>
          <form action="delep.php" method="post">
            <div class="row">
              <label>Series ID:</label>
              <input type="text" name="seriesID">
              <br>
            </div>
            <div class="row">
              <label>Ep Number:</label>
              <input type="text" name="epnum">
              <br>
            </div>
            <input type="Submit" value="Delete">
          </form>
          <br>
          <a name="YourInfo"></a>
          <h2 style="color:crimson">Update Your Info</h2>
          <h3>Leave it blank if you don't want to change!<h3>
          <form action="updmeminfo.php" method="post">
            <!--<div class="row">
              <label>New Password:</label>
              <input type="text" name="newpassword">
              <br>
            </div>-->
            <br>
            <div class="row">
              <label>Display Name:</label>
              <input type="text" name="name">
              <br>
            </div>
            <div class="row">
              <label>Profile Picture:</label>
              <input type="text" name="picture">
              <br>
            </div>
            <div class="row">
              <label>Infomation:</label>
              <textarea type="text" name="info"></textarea>
              <br>
            </div>
            <input type="Submit" value="Update">
          </form>
          </form>
          <br>
        </div>
        <div id="sidebar">
          <br>
          <h2>Series ID</h2>

          <div style="height:800px;overflow:auto;">
            <?php
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
            $memresult=$col01;
            $stmt->close();
            if($memresult){
            $userID=$memresult;
            //echo "USER $userID";
            $stmt = $con->prepare("SELECT series.seriesID, series.name FROM series JOIN trans ON series.seriesID=trans.seriesID WHERE trans.memID=? ORDER BY series.name");
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $stmt->bind_result($col02, $col12);
            echo "<table style=\"border:1px solid lightgrey\">";
            while ($stmt->fetch()) {

              echo "
              <tr>
                <td style=\"border:1px solid lightgrey; padding:2px; width:170px;\">$col12</td>
                <td style=\"border:1px solid lightgrey; padding:2px; font-weight: bold;width:20px; vertical-align: top; text-align:right\">$col02</td>
              </tr>";

            }
            echo "</table>";
            $stmt->close();

            /*echo "<h2>Member ID</h2>";
            $stmt = $con->prepare("SELECT * FROM mems ORDER BY username");
            $stmt->execute();
            $memresult=$stmt->get_result();
            if($memresult){
            echo "<table style=\"border:1px solid lightgrey\">";
            while($memrow = $memresult->fetch_row()){
                echo "
              <tr>
                <td style=\"border:1px solid lightgrey; padding:2px; width:80px;\">$memrow[4]</td>
                <td style=\"border:1px solid lightgrey; padding:2px; width:90px;text-align:center\">\"$memrow[1]\"</td>
                <td style=\"border:1px solid lightgrey; padding:2px; font-weight: bold;width:20px; vertical-align: top; text-align:right\">$memrow[0]</td>
              </tr>";
            }
            }*/
          }
            $con->close();
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>

</html>
