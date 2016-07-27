<!DOCTYPE html>

<head>
  <title>Củ Cải Fansub Official Website</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="images/shortcut.png">
  <link href="style/default.css" rel="stylesheet" type="text/css"/>
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
        <li> <a href="members.php">Các Thành Viên</a> </li>
      </ul>
    </div>
    <div id="body">
      <div class="featured">
        <a href="index.html">
          <img src="images/featured-home.png" alt="" width="920">
        </a>
      </div>
      <div id="content">
        <div class="content">
          <ul class="articles">
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

            $stmt = $con->prepare("SELECT * FROM series WHERE name LIKE ? OR tags LIKE ?");
            $stmt->bind_param("ss", $search, $search);
            $search="%{$_GET['search']}%";
            $stmt->execute();
            $stmt->bind_result($col0,$col1,$col2,$col3,$col4,$col5,$col6,$col7);
            //$result=$stmt->get_result();
            //$num = mysqli_num_rows ($result);

            $i=0;
            while ($stmt->fetch()){
              $i++;
              $rcol0[$i] = $col0;
              $rcol1[$i] = $col1;
              $rcol2[$i] = $col2;
              $rcol3[$i] = $col3;
              $rcol5[$i] = $col5;
              $rcol6[$i] = $col6;
              //echo "$i $col0 $rcol0[$i]<br>";
            }
            //echo "$i <br>";
            $stmt->close();
            $maxi=$i;
            $i=0;
            while ($i<$maxi) {
              //$stmt->close();
            //$row = $result->fetch_row();
            $i++;
            {
              $sql = "SELECT mems.memID, mems.name,mems.picture FROM mems JOIN trans ON mems.memID=trans.memID JOIN series ON trans.seriesID=series.seriesID WHERE series.seriesID=$rcol0[$i]";
              if (!mysqli_query($con, $sql)) echo "failed!";
              $memsresult = mysqli_query($con, $sql);
              $token = strtok($rcol5[$i], ",");

              echo "<li>
                      <h2><a href=\"player.php?series=$rcol0[$i]\">$rcol1[$i]</a> <span>$rcol6[$i]</span> </h2>
                      <table>
                      <tr><td><a href=\"player.php?series=$rcol0[$i]\"><img class=\"preimg\" src=\"".$rcol2[$i]."\" alt=\"error\"></a></td></tr>
                      <tr><td class=\"caption\"><p>$rcol3[$i]</p><p class=\"mems\">Trans: ";
              while($mems = $memsresult->fetch_row()){
                    echo   "<span class=\"mems\"><a href=\"members.php?member=$mems[0]\"><img src=\"$mems[2]\" style=\"width:28px; height:28px;border-radius:5px;margin-right:7px;\">$mems[1]&nbsp;</a></span>";
              }
            }
            echo "</p></td></tr>
          </table><p class=\"tags\">";
            while ($token !== false){
                  echo "<span class=\"tags\"><a class=\"tags\" href=\"result.php?search=$token\">$token</a></span> ";
                  $token = strtok(",");
            }
            echo   "</p>
                  </li>";
            //$i++;
            }

            //$result->free();
            $con->close();
            ?>

          </ul>

        </div>
        <div id="sidebar">
          <form method="get" id="search" action="result.php">
            <input type="text" name="search" placeholder="<?php $search=$_GET['search']; echo $search; ?>">
            <button type="submit">Submit</button>
          </form>
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
