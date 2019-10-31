<?php

class Controller {

    private $model;
    private $view;

    function __construct()
    {
        $this->model = new Model();
        $this->view = new View();
    }

    public function logout()
    {
        $this->model->logoutMe();
    }

    public function printNavBar($location)
    {
        $this->view->printNavbar($location);
    }

    public function redirect_to_another_page($urlDestination, $delay)
    {
        echo '<meta http-equiv="refresh" content="'.$delay.'; url='.$urlDestination.'" />';
    }

    public function printRegisterForm()
    {
        $this->view->printRegisterForm();
    }

    public function handleRegisterButton()
    {
        if(isset($_POST['register_btn']))
        {
            $canIRegister = true;

            if(empty($_POST['username']))
            {
                $this->view->printDanger("Vartotojo vardas neturi būti tuščias!");
                $canIRegister = false;
            }
            else
            {
                if(strlen($_POST['username']) < 5)
                {
                    $this->view->printDanger("Vartotojo vardas turi būti sudarytas iš 5 simbolių!");
                    $canIRegister = false;
                }
            }
            if(empty($_POST['email']))
            {
                $this->view->printDanger("Elektroninis paštas neturi būti tuščias!");
                $canIRegister = false;
            }
            if(empty($_POST['first_name']))
            {
                $this->view->printDanger("Vardas neturi būti tuščias!");
                $canIRegister = false;
            }
            if(empty($_POST['last_name']))
            {
                $this->view->printDanger("Pavardė neturi būti tuščia!");
                $canIRegister = false;
            }
            if(empty($_POST['password']))
            {
                $this->view->printDanger("Slaptažodis neturi būti tuščias!");
                $canIRegister = false;
            }

            if(empty($_POST['password_repeat']))
            {
                $this->view->printDanger("Pakartokite slaptažodį!");
                $canIRegister = false;
            }

            if($_POST['password_repeat'] != $_POST['password'])
            {
                $this->view->printDanger("Slaptažodžiai nesutampa!");
                $canIRegister = false;
            }

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            if($canIRegister)
            {
                $this->model->registerUser(strtolower ($_POST['username']), $_POST['email'], $password, $_POST['first_name'], $_POST['last_name']);
                $this->view->printSuccess("Registracija sėkminga!");
                $this->redirect_to_another_page("login.php", 2);
            }
            else
            {
                $this->view->printDanger("Registracija nesėkminga!");
            }
        }
    }

    public function printLoginForm()
    {
        $this->view->printLoginForm();
    }

    public function handleLoginButton()
    {
        if(isset($_POST['login_btn']))
        {
            if($this->model->loginMe($_POST['username'], $_POST['password']))
            {
                $this->view->printSuccess("Prisijungimas sėkmingas!");
                $this->redirect_to_another_page("ads.php", 1);
            }
            else
            {
                $this->view->printDanger("Toks naudotojas su tokiu slapyvardžiu arba slaptažodžiu neegzistuoja!");
            }
        }
    }

    public function canIShowLoginPage()
    {
        if($this->amILoggedIn())
        {
            $this->redirect_to_another_page("index.php", 0);
            return false;
        }
        return true;
    }

    public function canIShowRegisterPage()
    {
        if($this->amILoggedIn())
        {
            $this->redirect_to_another_page("index.php", 0);
            return false;
        }
        return true;
    }

    public function amILoggedIn()
    {
        if($_SESSION['id'] == "0")
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}