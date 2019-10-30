<?php
session_start();
foreach (glob("src/*.php") as $filename)
{
    include $filename;
}
$controller = new Controller();
$view = new View();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Darbo skelbimų portalas">
  <meta name="author" content="Valentinas Kasteckis IFF-7/14">

  <title>Darbo skelbimai</title>

  <!-- Bootstrap core CSS -->
  <link href="includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style/stylesheet.css">

</head>

<body>

  <!-- Navigation -->
  <?php
  $controller->printNavBar("login.php");
  ?>

  <!-- Page Content -->
  <div class="container">
      <div class="main-content--small-margin">
        <form method="POST">
          <div class="form-group">
              <label for="inputEmail">Naudotojo vardas</label>
              <input type="email" class="form-control" id="inputEmail" placeholder="Naudotojo vardas">
          </div>
          <div class="form-group">
              <label for="inputPassword">Slaptažodis</label>
              <input type="password" class="form-control" id="inputPassword" placeholder="Slaptažodis">
          </div>
          <button type="submit" class="btn btn-primary">Prisijungti</button>
      </form>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="includes/jquery/jquery.slim.min.js"></script>
  <script src="includes/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
