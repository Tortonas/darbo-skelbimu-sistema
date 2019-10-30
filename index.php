<?php
session_start();
foreach (glob("src/*.php") as $filename)
{
    include $filename;
}
$controller = new Controller();
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
    $controller->printNavBar("index.php");
  ?>

  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h1 class="mt-5">Darbo paieškos pasiūlos per internetą sistemą</h1>
        <p class="lead">Čia galite ieškotis darbo skelbimų bei juos skelbti, nemokamai!</p>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="includes/jquery/jquery.slim.min.js"></script>
  <script src="includes/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
