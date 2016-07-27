<!DOCTYPE html>

<head>
  <title>Củ Cải Fansub Official Website</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="images/shortcut.png">
  <link href="style/default.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div id="fb-root"></div>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
  <div id="page">
    <div id="header">
      <a href="index.php">
        <img class="logo" src="images/logo.png" alt="">
      </a>
      <ul class="navigation">
        <li> <a href="index.php">Mới Cập Nhật</a> </li>
        <li> <a href="ongoing.php">Đang Dịch</a> </li>
        <li> <a href="complete.php">Đã Hoàn Thành</a> </li>
        <li> <a href="list.php">List Phim</a> </li>
        <li> <a href="members.php" class="active">Các Thành Viên</a> </li>
      </ul>
    </div>
    <div id="body">
      <div class="featured">
        <a href="index.php">
          <img src="images/featured-home.png" alt="" width="920">
        </a>
      </div>
      <div id="content">
        <div class="content">
          <ul class="articles">
            <br>
            <?php
//Counter

session_start();
$counter_name = "counter.txt";

if (!file_exists($counter_name)) {
  $f = fopen($counter_name, "w");
  fwrite($f,"0");
  fclose($f);
}

$f = fopen($counter_name,"r");
$counterVal = fread($f, filesize($counter_name));
fclose($f);
// Has visitor been counted in this session?
// If not, increase counter value by one
if(!isset($_SESSION['hasVisited'])){
  $_SESSION['hasVisited']="yes";
  $counterVal++;
  $f = fopen($counter_name, "w");
  fwrite($f, $counterVal);
  fclose($f); 
}
//echo "This is visit number $counterVal to this site";

//End Counter
            $username="cucaivisitor";
            $password="visitor";
            $database="cucaibeta";
            $servername="166.62.10.137";

            $con = @new mysqli($servername, $username, $password, $database);
            if ($con->connect_errno) {
                die('Connect Error: ' . $con->connect_errno);
            }
            $sql = "SET character_set_results = 'utf8'";
            mysqli_query($con, $sql);

            if (isset($_GET["member"])&&!empty($_GET["member"])) {

            $stmt = $con->prepare("SELECT * from mems where memID= ?");
            $stmt->bind_param("i", $search);
            $search=$_GET["member"];
            $stmt->execute();
            $stmt->bind_result($col0,$col1,$col2,$col3,$col4);
            $stmt->fetch();
            $stmt->close();
            //$result = $stmt->get_result();
            //$row = $result->fetch_row();
            $sql="SELECT COUNT(seriesID) FROM trans WHERE memID=$col0";
            if($epresult=mysqli_query($con, $sql)){
            $numoep= $epresult->fetch_row();
            echo "<li><h2 class = \"member\"><a href=\"members.php?member=$col0\">$col1</a></h2>
            <table>
            <tr>
            <td class=\"profilepic\"><img class=\"profilepic\" src=\"$col2\"></td>
            <td class=\"info\"><div class=\"info\">$col3<br>Đã dịch: $numoep[0] phim.</div></td>
            </tr>
            </table>
            <br></li>";
            $sql = "SELECT * FROM series INNER JOIN trans on trans.seriesID = series.seriesID INNER JOIN mems on mems.memID = trans.memID WHERE mems.memID=$col0 ORDER BY series.lastupd DESC";
            $result = $con->query($sql); // Đây là cách thực hiện query trực tiếp bằng MySQLi không thông qua statement
            if ($result) // Nếu $result không rỗng
            $i=1;
            while($row = $result->fetch_row())
            {
              echo "<p class = \"entry\">$i. <a href=\"player.php?series=$row[0]\">$row[1]</a></p>";
              $i++;
            }
            }
            }
            else {

            $query="SELECT * FROM mems order by(name)";
            $result=mysqli_query($con, $query);

            $num=mysqli_num_rows($result);

            $i=1;
            while($row = $result->fetch_row())
            {
              $sql="SELECT COUNT(seriesID) FROM trans WHERE memID=$row[0]";
              $epresult=mysqli_query($con, $sql);
              $numoep= $epresult->fetch_row();
              echo "<li><h2 class=\"member\"><a href=\"members.php?member=$row[0]\">$row[1]</a></h2>
                <table>
                  <tr>
                    <td class=\"profilepic\"><img class=\"profilepic\" src=\"$row[2]\"></td>
                    <td class=\"info\"><div class=\"info\">$row[3]<br>Đã dịch: $numoep[0] phim.</div></td>
                  </tr>
                </table>
                <br></li>";
                $i++;
            }
          }
            $con->close();
            ?>
          </ul>

        </div>
        <div id="sidebar">
          <form method="get" id="search" action="result.php">
            <input type="text" name="search" placeholder="Search">
            <button type="submit">Submit</button>
          </form>
          <div class="break"></div>
          <div class="fb-page" data-href="https://www.facebook.com/CC.fansub" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true" style="margin-top:10px;">
            <div class="fb-xfbml-parse-ignore">
              <blockquote cite="https://www.facebook.com/CC.fansub">
                <a href="https://www.facebook.com/CC.fansub" style="text-decoration:none;">
                  <h1>
                    <span>Củ cải fansub</span>
                  </h1>
                </a>
              </blockquote>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="footer">
      <span>Thiết kế năm 2015 bởi <a href="https://www.facebook.com/p30.nvn">Cường M. Nguyễn</a> và nhóm <a href="https://www.facebook.com/CC.fansub">Củ Cải Fansub</a>.</span>
    </div>
  </div>
</body>

</html>
