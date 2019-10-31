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
                    if($_SESSION['role'] == 3)
                    {
                        $this->printNavbarItem("Narių sąrašas", "users.php", $location);
                    }
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

    function printLoginForm()
    {
        echo '      <div class="main-content--small-margin">
        <form method="POST">
          <div class="form-group">
              <label for="inputEmail">Naudotojo vardas</label>
              <input type="text" class="form-control" id="inputEmail" name="username" placeholder="Naudotojo vardas">
          </div>
          <div class="form-group">
              <label for="inputPassword">Slaptažodis</label>
              <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Slaptažodis">
          </div>
          <button type="submit" name="login_btn" class="btn btn-primary">Prisijungti</button>
      </form>
    </div>';
    }

    function printSuccess($text)
    {
        echo '<div class="alert alert-success" role="alert">'.$text.'</div>';
    }

    function printDanger($text)
    {
        echo '<div class="alert alert-danger" role="alert">'.$text.'</div>';
    }

    function printUsersPage($array)
    {
        echo '        <div class="main-content--small-margin">
            <h1>Naudotojų sąrašas:</h1>
            <ul class="list-group">';

        if ($array->num_rows > 0)
        {
            // output data of each row
            while($row = $array->fetch_assoc())
            {
                if($row['verified'] == "0")
                {
                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">'.$row['username'].'<span class="badge badge-danger badge-pill">Nepatvirtintas</span></li>';
                }
                else
                {
                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">'.$row['username'].'<span class="badge badge-primary badge-pill">Patvirtintas</span></li>';
                }
            }
        }
        else
        {
            $this->printSuccess("Sistemoje nėra paprasto tipo naudotojų!");
        }
        echo '</ul>
        </div>';
    }

    function printUsersPageDeleteForm()
    {
        echo '
        <form method="POST" class="main-content--small-margin">
          <div class="form-group">
              <label for="inputEmail">Įveskite naudotojo vardą statusą norite pakeisti.</label>
              <input type="text" class="form-control" id="inputEmail" name="username" placeholder="Naudotojo vardas">
          </div>
          <button type="submit" name="verify_btn" class="btn btn-primary">Pakeisti</button>
      </form>';
    }

    function printMyAdsContent($searchJobArr, $giveJobArr)
    {
        echo '      <div class="main-content--small-margin">
      <div class="list-group">
          <h1>"Ieškau darbo" - skelbimai</h1>';

        if ($searchJobArr->num_rows > 0)
        {
            while($row = $searchJobArr->fetch_assoc())
            {
               echo '          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">'.$row['title'].'</h5>
              <small>Galioja iki '.$row['valid_till'].'</small>
            </div>
            <p class="mb-1">'.$row['description'].'</p>
            <small>Alga '.$row['salary'].' eurų</small>
          </a>';
            }
        }
        else
        {
            echo "<h5>Neturite tokio tipo skelbimų.</h5>";
        }

        echo '<div class="list-group">
            <h1>"Siūlau darbą" - skelbimai</h1>';

        if ($giveJobArr->num_rows > 0)
        {
            while($row = $giveJobArr->fetch_assoc())
            {
                echo '          <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">'.$row['title'].'</h5>
              <small>Galioja iki '.$row['valid_till'].'</small>
            </div>
            <p class="mb-1">'.$row['description'].'</p>
            <small>Alga '.$row['salary'].' eurų</small>
          </a>';
            }
        }
        else
        {
            echo "<h5>Neturite tokio tipo skelbimų.</h5>";
        }

        echo  '</div>
        </div>
      </div>';

    }

    function printSubmitNewAdButton($isActiveButton)
    {
        if($isActiveButton)
        {
            echo '<a href="createad.php"> <button type="submit" class="btn btn-primary main-content--small-margin">Sukurti naują skelbimą</button> </a>';
        }
        else
        {
            echo ' <button type="submit" class="btn btn-primary main-content--small-margin disabled">Sukurti naują skelbimą</button> <h5 style="color:red">Kaip administratorius patvirtins jūsų paskyrą, galėsite kelti skelbimus.</h5>';
        }
    }

    function printCreateNewAdForm()
    {
        //title, short description, text, salary, validtill, type

        echo '<form method="POST" class="main-content--small-margin">
              <div class="form-group">
                <label for="exampleFormControlInput1">Vardas pavardė arba firmos pavadinimas</label>
                <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="Petras Petraitis arba UAB `UAB` ">
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Skelbimo tipas</label>
                <select name="type" class="form-control" id="exampleFormControlSelect1">
                  <option value="1">Ieškau darbo</option>
                  <option value="2">Siūlau darbą</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Trumpas pristatymas</label>
                <input name="description" type="text" class="form-control" id="exampleFormControlInput1" placeholder="UAB `UAB` ieško darbuotojų. ">
              </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Pilnas skelbimo tekstas</label>
                <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Alga</label>
                <input name="salary" type="text" class="form-control" id="exampleFormControlInput1" placeholder="555">
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Iki kada galios skelbimas</label>
                <input name="valid_till" type="text" class="form-control" id="exampleFormControlInput1" placeholder="2019-12-01">
              </div>
              <button type="submit" name="createad_btn" class="btn btn-primary">Sukurti naują skelbimą</button>
            </form>';
    }
}