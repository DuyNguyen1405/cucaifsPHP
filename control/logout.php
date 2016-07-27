<!DOCTYPE html>

<head>
<title>Củ cải fansub</title>
<meta  charset="utf-8">
<link rel="shortcut icon" href="../images/shortcut.png">
<link href="../style/default.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<div id="page">
  <div id="header"> <a href="../index.php"><img class="logo" src="../images/logo.png" alt=""></a>
  </div>

  <div id="body">
    <div class="login" align="center">
        <h2>
<?php
session_start();
session_destroy();
echo "Successfully logged out!</h2></div>
</div>
</div>
</body>
</html>";
header("refresh:1;url=loginform.php");
?>
