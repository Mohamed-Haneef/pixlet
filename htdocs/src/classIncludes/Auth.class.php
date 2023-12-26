<?php
// include("Database.class.php");
class Auth
{
    public $id;
    public $ip;
    public $credential;
    public $token;
    public $uid;
    public $conn;
    public $fingerprint;
    public $browser;
    public $user;

    public function __construct($token)
    {
        $this->token = $token;
        $this->conn = Database::getconnection();
        $this->credential = null;
        $query = "SELECT * FROM `session` WHERE `token` = '$token'";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            // echo "Data fetched";
            $this->credential = $row;
            $this->ip = $row["ip"];
            $this->browser = $row["browser"];
        // echo  $row["browser"];
        // echo $this->credential["fingerprint"];
        // var_dump($row);
        } else {
            echo "invalid session";
        }
    }

    public static function authenticate($emailAddress, $password, $fingerprint = null)
    {
        // setting fingerprint from cookie
        // echo "authentication page";
        $authenticated = false;
        if ($fingerprint == null) {
            // echo "fingerprint doesn't exists";
            $fingerprint = $_COOKIE['fingerprint'];
        }
        $userCred = new User($emailAddress);
        // var_dump($userCred);
        $authenticated = User::login($emailAddress, $password);
        // echo "after lgin";
        if ($authenticated == true) {
            // getting database connection
            echo "start";
            $conn = Database::getconnection();
            Session::start();
            $ip = $_SERVER["REMOTE_ADDR"];
            $browser = $_SERVER["HTTP_USER_AGENT"];
            $token = md5(rand(0, 99999) . $ip . $browser . $fingerprint);
            // echo "token generated";
            $sql_query = "INSERT INTO `session` (`uid`, `ip`, `browser`,`login_time`, `fingerprint`, `token`)
                          VALUES ('$userCred->id', '$ip', '$browser', now(), '$fingerprint', '$token')";
            $result = $conn->query($sql_query);
            // echo "result became true";
            if ($result) {
                Session::set("username", $userCred->user);
                // echo $_SESSION["username"];
                Session::set("id", $userCred->id);
                Session::set("session_token", $token);
                Session::set("fingerprint", $fingerprint);
                return true;
                // echo "session set";
        
            }
        }

    }
    // authorization
    public static function authorize($token)
    {
        try {
            $session = new Auth($token);
            // echo "class created";
            if($session->validateSession()) {
                Session::$user = Session::get("username");
                return Session::$user;
            } else {
                echo "validate session failed \n";
            }
            
            


        } catch (Exception $e) {
            echo "authorization fail \n";
        }
    }

    private function validateSession()
    {
        if (isset($_COOKIE['fingerprint']) && $this->credential["fingerprint"]) {
            if ($_COOKIE['fingerprint'] == $this->credential["fingerprint"]) {
                // echo "fingerprint matches \n <br>";
                $login_time = DateTime::createFromFormat('Y-m-d H:i:s', $this->credential['login_time']);
                // echo $login_time->getTimestamp();
                if (3600 > time() - $login_time->getTimestamp()) {
                    // echo time() - $login_time->getTimestamp();
                    // echo "time is less than 10 min";
                    if (isset($_SERVER['REMOTE_ADDR']) && isset($this->ip)) {
                        if ($this->ip == $_SERVER['REMOTE_ADDR']) {
                            // echo "same ip <br>";
                            if (isset($_SERVER['HTTP_USER_AGENT']) && isset($this->browser)) {
                                // echo "browser present <br>";
                                // echo $this->browser. "<br>";
                                // echo $_SERVER['HTTP_USER_AGENT']. "<br>";
                             
                                if ($this->browser == $_SERVER['HTTP_USER_AGENT']) {
                                    // echo "same browser";
                                    return true;
                                } else {
                                    throw new Exception('browser is different');
                                }
                            } else {
                                throw new Exception("browser doesn't exists");
                            }
                        } else {
                            throw new Exception("ip doesn't match");
                        }
                    } else {
                        throw new Exception("there is no ip present");
                    }
                } else {
                    throw new Exception("session expired");

                }
            } else {
                throw new Exception("fingerprint invalid");
            }
        } else {
            throw new Exception("fingerprint doesn't exist");
        }
    }


}
