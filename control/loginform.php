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
      if(isset($_SESSION['loguser'])||isset($_SESSION['loguser'])){
        echo "<h2>You have logged in!</h2>";
        header("refresh:1;url=index.php");
        die(1);
      }
      ?>
          <h2>Please log in!</h2>
          <form action="login.php" method="post">
            <div class="row">
              <label>Username:</label>
              <input type="text" name="username" autocomplete="off">
              <br>
            </div>
            <div class="row">
              <label>Password:</label>
              <input type="Password" name="password">
              <br>
            </div>
            <input type="submit" value="Log in">
          </form>

      </div>
    </div>
  </div>
</body>

</html>
