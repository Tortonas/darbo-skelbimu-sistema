<?php
class Model {
    private $server;
    private $dbName;
    private $dbUser;
    private $dbPassword;

    private $conn;

    function __construct()
    {

        $this->setDefaultSessions();
        date_default_timezone_set("Europe/Vilnius");
        $dbConfigFile = fopen("./src/database.config", "r") or die("Unable to open file!");
        $dbConfigFileString =  fgets($dbConfigFile);
        $dbConfigLines = explode(":", $dbConfigFileString);
        fclose($dbConfigFile);
        $this->server = $dbConfigLines[0];
        $this->dbUser = $dbConfigLines[1];
        $this->dbPassword = $dbConfigLines[2];
        $this->dbName = $dbConfigLines[3];
        $this->conn = new mysqli($this->server, $this->dbUser, $this->dbPassword, $this->dbName);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function setDefaultSessions()
    {
        if(!isset($_SESSION['id']) && empty($_SESSION['id']))
        {
            $_SESSION['id'] = "0";
        }
        if(!isset($_SESSION['username']) && empty($_SESSION['username']))
        {
            $_SESSION['username'] = "0";
        }
        if(!isset($_SESSION['email']) && empty($_SESSION['email']))
        {
            $_SESSION['email'] = "0";
        }
        if(!isset($_SESSION['password']) && empty($_SESSION['password']))
        {
            $_SESSION['password'] = "0";
        }
        if(!isset($_SESSION['first_name']) && empty($_SESSION['first_name']))
        {
            $_SESSION['first_name'] = "0";
        }
        if(!isset($_SESSION['last_name']) && empty($_SESSION['last_name']))
        {
            $_SESSION['last_name'] = "0";
        }
        if(!isset($_SESSION['role']) && empty($_SESSION['role']))
        {
            $_SESSION['role'] = "0";
        }
        if(!isset($_SESSION['verified']) && empty($_SESSION['verified']))
        {
            $_SESSION['verified'] = "0";
        }
    }

    function secureInput($input)
    {
        $input = mysqli_real_escape_string($this->conn, $input);
        $input = htmlspecialchars($input);
        return $input;
    }

    public function registerUser($username, $email, $password, $first_name, $last_name)
    {
        $username = $this->secureInput($username);
        $email = $this->secureInput($email);
        $password = $this->secureInput($password);
        $first_name = $this->secureInput($first_name);
        $last_name = $this->secureInput($last_name);
        $sql = "INSERT INTO users (username, email, password, first_name, last_name, role, verified) VALUES ('$username', '$email', '$password', '$first_name', '$last_name', '1', '0');";
        mysqli_query($this->conn, $sql);
    }

}