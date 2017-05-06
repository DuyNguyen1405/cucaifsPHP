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
        <li> <a href="index.php" class="active">Mới cập nhật</a> </li>
        <li> <a href="ongoing.php">Đang Dịch</a> </li>
        <li> <a href="complete.php">Đã Hoàn Thành</a> </li>
        <li> <a href="list.php">List Phim</a> </li>
        <li> <a href="members.php">Các Thành Viên</a> </li>
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

            $rec_limit = 5;
            $sql = "SELECT count(\"seriesID\") FROM series ";
            $retval = mysqli_query($con,$sql);
            $row = mysqli_fetch_array($retval, MYSQL_NUM );
            $rec_count = $row[0];
            if(isset($_GET{'page'}))
            {
              if(!empty($_GET['page'])&&($_GET['page'])>=0){
              $page = $_GET{'page'} + 1;
              $offset = $rec_limit * ($_GET{'page'}) ;
              }
            else{
              $page = 1;
              $offset = 0;
            }
            }
            else{
            $page = 1;
            $offset = 0;
            }

            $left_rec = $rec_count - ($page * $rec_limit);
            $sql = "SELECT * FROM series ORDER BY lastupd DESC LIMIT $rec_limit OFFSET $offset";

            $result= mysqli_query($con, $sql);

            $title = $_SERVER['PHP_SELF'];
            while($row = $result->fetch_row())
            {
              $sql = "SELECT mems.memID, mems.name,mems.picture FROM mems JOIN trans ON mems.memID=trans.memID JOIN series ON trans.seriesID=series.seriesID WHERE series.seriesID=$row[0]";
              $memsresult = mysqli_query($con, $sql);
              $token = strtok($row[5], ",");
              $sql = "SELECT epnum, preview, caption FROM ep WHERE seriesID = $row[0] AND ep.epnum = (SELECT MAX(epnum) FROM ep WHERE seriesID = $row[0])";
              $epresult = mysqli_query($con, $sql);
              $latestep = $epresult->fetch_row();
              if (!empty($latestep[0])){

              echo "<li>
                      <h2><a href=\"player.php?series=$row[0]&ep=$latestep[0]\">$row[1] - Ep $latestep[0]</a> <span>$row[6]</span> </h2>
                      <table>
                      <tr><td><a href=\"player.php?series=$row[0]&ep=$latestep[0]\"><img class=\"preimg\" src=\"".$latestep[1]."\" alt=\"error\"></a></td></tr>
                      <tr><td class=\"caption\"><p>$latestep[2]</p><p class=\"mems\">Trans: ";
              while($mems = $memsresult->fetch_row()){
                    echo   "<span class=\"mems\"><a href=\"members.php?member=$mems[0]\"><img src=\"$mems[2]\" style=\"width:28px; height:28px;border-radius:5px;margin-right:7px;\">$mems[1]&nbsp;</a></span>";
              }
              echo "</p></td></tr>
            </table><p class=\"tags\">";
              while ($token !== false){
                    echo "<span class=\"tags\"><a class=\"tags\" href=\"result.php?search=$token\">$token</a></span> ";
                    $token = strtok(",");
              }
              echo   "</p>
                    </li>";
              }
            }
            echo "</ul>
            <ul class=\"paging\">";
            if( $page > 1)
            {

            $last = $page - 2;
            echo "<li class=\"first\"><a href=\"$title?page=$last\">‹‹ ".$rec_limit." bài mới hơn</a></li>";
            }

            if( $left_rec > 0 )
            {
            echo "<li class=\"last\"><a href=\"$title?page=".($page)."\">".$rec_limit." bài cũ hơn ››</a></li>";
            }
            echo "</ul>";
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
