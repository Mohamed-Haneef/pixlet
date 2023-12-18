<?php
use Monolog\Handler\FingersCrossedHandler;

// include $_SERVER['DOCUMENT_ROOT']. "/src/classIncludes/Database.class.php";
// include $_SERVER['DOCUMENT_ROOT']. "/src/classIncludes/User.class.php";
// include $_SERVER['DOCUMENT_ROOT']. "/src/classIncludes/Session.class.php";
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

    public function __construct($token)
    {
        $this->token = $token;
        $this->conn = Database::getconnection();
        $this->credential = null;
        $query = "SELECT * FROM `session` WHERE `token` = '$token' LIMIT 1";
        $result = $this->conn->query($query);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            $this->credential = $row;
            $this->id = $row["id"];
        } else {
            echo "invalid session";
        }
    }

    public static function authenticate($emailAddress, $password, $fingerprint = NULL)
    {
        // setting fingerprint from cookie
        echo "authentication page";
        $authenticated = false;
        if ($fingerprint == NULL) {
            echo "fingerprint doesn't exists";
            $fingerprint = $_COOKIE['fingerprint'];
        }
        $userCred = new User($emailAddress);
        $authenticated = User::login($emailAddress, $password);
        echo "after lgin";
        if ($authenticated == true) {
            // getting database connection
            echo "start";
            $conn = Database::getconnection();
            Session::start();
            $ip = $_SERVER["REMOTE_ADDR"];
            $browser = $_SERVER["HTTP_USER_AGENT"];
            $token = md5(rand(0, 99999) . $ip . $browser . $fingerprint);
            echo "token generated";
            $sql_query = "INSERT INTO `session` (`uid`, `ip`, `browser`,`login_time`, `fingerprint`, `token`)
                          VALUES ('$userCred->id', '$ip', '$browser', now(), '$fingerprint', '$token')";
            $result = $conn->query($sql_query);
            echo "result became true";
            if ($result) {
                Session::set("session_token", $token);
                Session::set("fingerprint", $fingerprint);
                echo "session set";
            }
        }

    }
    // authorization
    public static function authorize($token)
    {
        try {
            $session = new Auth($token);
            if($session->validateSession()){
                Session::$user = Session::get("user");
            }
            
            


        } catch (Exception $e) {

        }
    }

    private function validateSession()
    {
        if (isset($_COOKIE['fingerprint']) && $this->credential["fingerprint"]) {
            if ($_COOKIE['fingerprint'] == $this->credential["fingerprint"]) {
                $login_time = DateTime::createFromFormat('Y-m-d H:i:s', $this->credential['login_time']);
                if (3600 > time() - $login_time->getTimestamp()) {
                    if (isset($_SERVER['REMOTE_ADDR']) && isset($this->ip)) {
                        if ($this->ip == $_SERVER['REMOTE_ADDR']) {
                            if (isset($_SERVER['HTTP_AGENT']) && isset($this->browser)) {
                                if ($this->browser == $_SERVER['HTTP_AGENT']) {
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