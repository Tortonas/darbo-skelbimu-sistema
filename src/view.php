<?php
class View {
    function __construct()
    {

    }

    public function printNavbar($location)
    {
        echo '
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
            <div class="container">
              <a class="navbar-brand" href="index.php">Darbo skelbimai</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">';
                $this->printNavbarItem("Namai", "index.php", $location);
                $this->printNavbarItem("Skelbimai", "ads.php", $location);
                if($_SESSION['role'] == "0")
                {
                    $this->printNavbarItem("Registruotis", "register.php", $location);
                    $this->printNavbarItem("Prisijungti", "login.php", $location);
                }
                else
                {
                    $this->printNavbarItem("Mano skelbimai", "myads.php", $location);
                    $this->printNavbarItem("Atsijungti", "logout.php", $location);
                }
                echo '</ul>
              </div>
            </div>
          </nav>
        ';
    }

    function printNavbarItem($name, $location, $globalLocation)
    {
        if($globalLocation == $location)
        {
            echo '
                  <li class="nav-item active">
                    <a class="nav-link" href="'.$location.'">'.$name.'</a>
                  </li>';
        }
        else
        {
            echo '
                  <li class="nav-item">
                    <a class="nav-link" href="'.$location.'">'.$name.'</a>
                  </li>';
        }
    }

    function printRegisterForm()
    {
        echo '
              <div class="main-content--small-margin">
        <form method="POST">
          <div class="form-group">
              <label for="inputEmail">Naudotojo vardas</label>
              <input name="username" type="text" class="form-control" id="inputEmail" placeholder="Naudotojo vardas">
          </div>
          <div class="form-group">
              <label for="inputEmail">Elektroninis paštas</label>
              <input name="email" type="text" class="form-control" id="inputEmail" placeholder="El. Paštas">
          </div>
          <div class="form-group">
              <label for="inputEmail">Vardas</label>
              <input name="first_name" type="text" class="form-control" id="inputEmail" placeholder="Vardas">
          </div>
          <div class="form-group">
              <label for="inputEmail">Pavardė</label>
              <input name="last_name" type="text" class="form-control" id="inputEmail" placeholder="Pavardė">
          </div>
          <div class="form-group">
              <label for="inputPassword">Slaptažodis</label>
              <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Slaptažodis">
          </div>
          <div class="form-group">
              <label for="inputPassword">Pakartokite slaptažodį</label>
              <input name="password_repeat" type="password" class="form-control" id="inputPassword" placeholder="Pakartokite slaptažodį">
          </div>
          <button type="submit" name="register_btn" class="btn btn-primary">Registruotis</button>
      </form>
    </div>
        ';
    }

    function printSuccess($text)
    {
        echo '<div class="alert alert-success" role="alert">'.$text.'</div>';
    }

    function printDanger($text)
    {
        echo '<div class="alert alert-danger" role="alert">'.$text.'</div>';
    }
}