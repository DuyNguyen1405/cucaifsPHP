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

            if (isset($_GET["series"])&&!empty($_GET["series"])&&isset($_GET["ep"])&&!empty($_GET["ep"])) {

              $stmt = $con->prepare( "SELECT series.name, ep.epnum, ep.preview, ep.caption, ep.linkdl, series.tags, series.preview, series.caption, series.lastupd FROM series JOIN ep ON series.seriesid = ep.seriesid WHERE ep.epnum= ? AND series.seriesid= ?");

              $stmt->bind_param("ii", $search1,$search2);
              $search1=$_GET["ep"];
              $search2=$_GET["series"];
              $stmt->execute();


              //$result = $stmt->get_result();
              $stmt->bind_result($col0,$col1,$col2,$col3,$col4,$col5,$col6,$col7,$col8);
              $stmt->fetch();

              $stmt->close();
              //$row = $result->fetch_row();

              echo "<li>
                      <h2><a href=\"player.php?series=$search2\">$col0</a><span>$col8</span></h2>";
              echo "<table>
                <tr><td><a><img class=\"preimg\" src=\"".$col2."\" alt=\"Preview Image\"></a></td></tr>
                <tr><td class=\"caption\"><p>$col3</p><p>Link <a href=\"$col4\">Download!</a></p>";
              $search2=$_GET["series"];
              $sql = "SELECT mems.memID, mems.name,mems.picture FROM mems JOIN trans ON mems.memID=trans.memID JOIN series ON trans.seriesID=series.seriesID WHERE series.seriesID=$search2";
              $memsresult = mysqli_query($con, $sql);
              echo "<p class=\"mems\">Trans: ";
                while($mems = $memsresult->fetch_row()){
                  echo "<span class=\"mems\"><a href=\"members.php?member=$mems[0]\"><img src=\"$mems[2]\" style=\"width:28px; height:28px;border-radius:5px;margin-right:7px;\">$mems[1]&nbsp;</a></span>";
                }
              echo "</p><br><br></td></tr></table>";

              $sql = "SELECT epnum FROM ep WHERE seriesID = $search2 ORDER BY epnum";
              $epresult = mysqli_query($con, $sql);

              echo "<p class=\"episode\">
              <span class=\"epnum\"> Tập số: </span>";
              while($epnum = $epresult->fetch_row()){
                if($epnum[0]==$search1){
                  echo "<span class=\"epnum\"> <a href=\"player.php?series=$search2&ep=$epnum[0]\" class=\"active\">$epnum[0]</a> </span>";
                }
                else{
                  echo "<span class=\"epnum\"> <a href=\"player.php?series=$search2&ep=$epnum[0]\">$epnum[0]</a> </span>";
                }
              }
              echo "</p><br>";
              $token = strtok($col5, ",");
              echo "<p class=\"tags\">";
                while ($token !== false){
                      echo "<span class=\"tags\"><a class=\"tags\" href=\"result.php?search=$token\">$token</a></span> ";
                      $token = strtok(",");
                }
                echo   "</p>";
                echo"<div style=\"background-color:white;margin:25px;padding:10px;\"><div class=\"fb-comments\" data-href=\"player.php?series=$search2\" data-width=\"580\" data-numposts=\"5\"></div></div>";
              echo "</li>";
            }
            elseif (isset($_GET["series"])&&!empty($_GET["series"])&&(!isset($_GET["ep"])||empty($_GET["ep"]))) {
              $stmt = $con->prepare( "SELECT * FROM series WHERE seriesID = ?");
              $stmt->bind_param("i", $search);
              $search=$_GET["series"];
              $stmt->execute();
              //$result = $stmt->get_result();
              $stmt->bind_result($col0,$col1,$col2,$col3,$col4,$col5,$col6,$col7);
              $stmt->fetch();
              $stmt->close();
              //$row = $result->fetch_row();
              $sql = "SELECT mems.memID, mems.name,mems.picture FROM mems JOIN trans ON mems.memID=trans.memID JOIN series ON trans.seriesID=series.seriesID WHERE series.seriesID=$col0";
              $memsresult = mysqli_query($con, $sql);
              $token = strtok($col5, ",");
              $sql = "SELECT MAX(epnum), preview, caption FROM ep WHERE seriesID = $col0";
              $epresult = mysqli_query($con, $sql);
              $latestep = $epresult->fetch_row();
              echo "<li>
                      <h2><a>$col1</a> <span>$col6</span> </h2>
                      <table>
                      <tr><td><img class=\"preimg\" src=\"".$col2."\" alt=\"Preview Image\"></td></tr>
                      <tr><td class=\"caption\"><p>$col3</p><p>Link <a href=\"$col4\">Download!</a></p><p class=\"mems\">Trans: ";
              while($mems = $memsresult->fetch_row()){
                    echo   "<span class=\"mems\"><a href=\"members.php?member=$mems[0]\"><img src=\"$mems[2]\" style=\"width:28px; height:28px;border-radius:5px;margin-right:7px;\">$mems[1]&nbsp;</a></span>";
              }

              echo "</p></td></tr>
              </table>";
              $sql = "SELECT epnum FROM ep WHERE seriesID = $col0 ORDER BY epnum";
              $epresult = mysqli_query($con, $sql);

              echo "<p class=\"episode\">
              <span class=\"epnum\"> Tập số: </span>";
              while($epnum = $epresult->fetch_row()){
              echo "<span class=\"epnum\"> <a href=\"player.php?series=$col0&ep=$epnum[0]\">$epnum[0]</a> </span>";
              }
              echo "</p><br>";
              echo "<br><p class=\"tags\">";
              while ($token !== false){
                    echo "<span class=\"tags\"><a class=\"tags\" href=\"result.php?search=$token\">$token</a></span> ";
                    $token = strtok(",");
              }
              echo   "</p>";
              echo"<div style=\"background-color:white;margin:25px;padding:10px;\"><div class=\"fb-comments\" data-href=\"http://cucaifs.com/player.php?series=$search2\" data-width=\"580\" data-numposts=\"5\"></div></div>";
              echo  "</li>";
            }
            else header('Location: index.php');

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
