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
        $this->updateLoginStatus();
    }

    public function updateLoginStatus()
    {
        if($_SESSION['id'] != "0")
        {
            $username = $this->secureInput($_SESSION['username']);
            $password = $this->secureInput($_SESSION['password']);

            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    if($password == $row['password'])
                    {
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['password'] = $row['password'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['role'] = $row['role'];
                        $_SESSION['verified'] = $row['verified'];
                        return true;
                    }
                    else
                    {
                        $this->logoutMe();
                        return false;
                    }
                }
            }
            else
            {
                $this->logoutMe();
            }
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
        $role = 1;
        $verified = 0;
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, first_name, last_name, role, verified) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssii", $username, $email, $password, $first_name, $last_name, $role, $verified);
        $stmt->execute();
    }

    public function loginMe($username, $password)
    {
        $username = $this->secureInput($username);
        $password = $this->secureInput($password);

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                if(password_verify($password, $row['password']))
                {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['first_name'] = $row['first_name'];
                    $_SESSION['last_name'] = $row['last_name'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['verified'] = $row['verified'];
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
    }

    public function logoutMe()
    {
        $_SESSION['id'] = "0";
        $_SESSION['username'] = "0";
        $_SESSION['email'] = "0";
        $_SESSION['password'] = "0";
        $_SESSION['first_name'] = "0";
        $_SESSION['last_name'] = "0";
        $_SESSION['role'] = "0";
        $_SESSION['verified'] = "0";
    }

    public function getUserList()
    {
        $sql = "SELECT * FROM users WHERE role=1";
        return $this->conn->query($sql);
    }

    public function canIRegisterThisName($username)
    {
    	$username = $this->secureInput($username);

    	$stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
    	$stmt->bind_param('s', $username);
    	$stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function changeUserVerification($username)
    {
        $username = $this->secureInput($username);
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                if($row['verified'] == 0)
                {
                    $stmt = $this->conn->prepare("UPDATE users SET verified='1' WHERE username=?");
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                }
                else
                {
                    $stmt = $this->conn->prepare("UPDATE users SET verified='0' WHERE username=?");
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                }
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    public function getSearchJobList($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM ads WHERE fk_user=? AND type='1' AND hidden='0' AND valid_till>=NOW()");
        $stmt->bind_param("i", $id);
        $id = $this->secureInput($id);;
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getGivingJobList($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM ads WHERE fk_user=? AND type='2' AND hidden='0' AND valid_till>=NOW()");
        $stmt->bind_param("i", $id);
        $id = $this->secureInput($id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getSearchJobListGlobal()
    {
        $sql = "SELECT * FROM ads WHERE type='1' AND hidden='0' AND valid_till>=NOW()";
        return $this->conn->query($sql);
    }

    public function getGivingJobListGlobal()
    {
        $sql = "SELECT * FROM ads WHERE type='2' AND hidden='0' AND valid_till>=NOW()";
        return $this->conn->query($sql);
    }

    public function createNewAd($title, $type, $description, $text, $salary, $valid_till, $user_id)
    {
        $title = $this->secureInput($title);
        $type = $this->secureInput($type);
        $description = $this->secureInput($description);
        $text = $this->secureInput($text);
        $salary = $this->secureInput($salary);
        $valid_till = $this->secureInput($valid_till);
        $hidden = 0;

        $stmt = $this->conn->prepare("INSERT INTO ads 
            (title, type, description, text, salary, valid_till, fk_user, hidden) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissisii", $title, $type, $description, $text, $salary, $valid_till, $user_id, $hidden);

        return $stmt->execute();
    }

    public function hideAd($id)
    {
        $id = $this->secureInput($id);

        $stmt = $this->conn->prepare("UPDATE ads SET hidden='1' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function checkIfAdExistsById($id)
    {
        $id = $this->secureInput($id);

        $stmt = $this->conn->prepare("SELECT * FROM ads WHERE id=? AND hidden='0' AND valid_till>=NOW()");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0)
        {
            return true;
        }
        return false;
    }

    public function getAdContentById($id)
    {
        $id = $this->secureInput($id);

        $stmt = $this->conn->prepare("SELECT * FROM ads WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function getCommentsById($id)
    {
        $id = $this->secureInput($id);
        $stmt = $this->conn->prepare("SELECT * FROM `ad_comments`
                JOIN users ON users.id = ad_comments.fk_user
                WHERE fk_ad=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function createNewAdComment($commentText, $userId, $adId)
    {
        $commentText = $this->secureInput($commentText);
        $userId = $this->secureInput($userId);
        $adId = $this->secureInput($adId);
        $currentDate = date('Y-m-d');

        $stmt = $this->conn->prepare("INSERT INTO ad_comments (text, fk_ad, fk_user, date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siis", $commentText, $adId, $userId, $currentDate);
        $stmt->execute();
    }

    public function getCountOfAdVisits($adId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM ad_views WHERE fk_ad=?");
        $stmt->bind_param("i", $adId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows;
    }

    public function haveIViewedThisAd($userId, $adId)
    {
        $userId = $this->secureInput($userId);
        $adId = $this->secureInput($adId);

        $stmt = $this->conn->prepare("SELECT * FROM ad_views WHERE fk_ad=? AND fk_user=?");
        $stmt->bind_param("ii", $adId, $userId);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function viewThisAd($userId, $adId)
    {
        $stmt = $this->conn->prepare("INSERT INTO ad_views (fk_ad, fk_user) VALUES (?, ?)");
        $stmt->bind_param("ii", $adId, $userId);
        $stmt->execute();
    }
}