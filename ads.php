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
  $controller->printNavBar("ads.php");
  ?>

  <!-- Page Content -->
  <div class="container">
    <div class="main-content--small-margin">
      <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Hostinger</h5>
              <small>Liko 27 dienos</small>
            </div>
            <p class="mb-1">Firma Hostinger ieško Customer Success Agent pozicijos darbuotojų</p>
            <small>Alga 500 eurų</small>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Devbridge</h5>
              <small>Liko 27 dienos</small>
            </div>
            <p class="mb-1">Firma Hostinger ieško Java programuotojo pozicijos darbuotojo</p>
            <small>Alga 3000 eurų</small>
          </a>
          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Valymas24</h5>
              <small>Liko 27 dienos</small>
            </div>
            <p class="mb-1">Firma Valymas ieško valytojų.</p>
            <small>Alga 700 eurų</small>
          </a>
        </div>
      </div>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="includes/jquery/jquery.slim.min.js"></script>
  <script src="includes/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
