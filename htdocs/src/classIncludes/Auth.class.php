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
        $query = "SELECT * FROM `session` WHERE `token` = ?";
        $bind = $this->conn->prepare($query);
        $bind -> bind_param("s", $token);
        $bind -> execute();
        $result = $bind -> get_result();
        
        if ($result) {
            $row = $result->fetch_assoc();
            $this->credential = $row;
            $this->ip = $row["ip"];
            $this->browser = $row["browser"];
        } else {
            echo "invalid session";
        }
    }

    public static function authenticate($emailAddress, $password, $fingerprint = null)
    {
        $authenticated = false;
        if ($fingerprint == null) {

            // obtains fingerprint from cookie
            $fingerprint = $_COOKIE['fingerprint'];
            $userCred = new User($emailAddress);
            if(isset($userCred->id)) {
                if($authenticated = User::login($emailAddress, $password)) {
                    if ($authenticated == true) {

                        // If Login is success then add session token into variables
                        $conn = Database::getconnection();
                        Session::start();
                        $ip = $_SERVER["REMOTE_ADDR"];
                        $browser = $_SERVER["HTTP_USER_AGENT"];
                        $token = md5(rand(0, 99999) . $ip . $browser . $fingerprint);
                        $sql_query = "INSERT INTO `session` (`uid`, `ip`, `browser`, `fingerprint`, `token`, `login_time`)
                        VALUES (?, ?, ?, ?, ?, now())";
                        $bind = $conn -> prepare($sql_query);
                        $bind -> bind_param("sssss", $userCred->id, $ip, $browser, $fingerprint, $token);
                        if ($bind -> execute()) {

                            // Once authenticated.. Sets the session variables
                            Session::set("username", $userCred->user);
                            Session::set("id", $userCred->id);
                            Session::set("session_token", $token);
                            Session::set("fingerprint", $fingerprint);
                            $conn = Database::closeConnection();
                            return 4;
        
                        } else {
                            echo "Session not set";
                        }

                    } else {
                        return 3; //email and password mismatch
                    }
                
                } else {
                    return 3; //email and password mismatch
                }
            
            } else {
                return 2; //Email doesn't exists
            }
        
        } else {

        }

    }
    // authorization
    public static function authorize($token)
    {
        try {
            $session = new Auth($token);

            // If session gets validated returns the username from session
            if($session->validateSession()) {
                // validateSession returns true
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
        // Fingerprint JS validation
        if (isset($_COOKIE['fingerprint']) && $this->credential["fingerprint"]) {
            if ($_COOKIE['fingerprint'] == $this->credential["fingerprint"]) {
                
                // Login time validation (should be less than 1 hr)
                $login_time = DateTime::createFromFormat('Y-m-d H:i:s', $this->credential['login_time']);
                if (3600 > time() - $login_time->getTimestamp()) {
                    
                    // Validates whether it is same ip
                    if (isset($_SERVER['REMOTE_ADDR']) && isset($this->ip)) {
                        if ($this->ip == $_SERVER['REMOTE_ADDR']) {
                            
                            // Validates whether it is from same browser
                            if (isset($_SERVER['HTTP_USER_AGENT']) && isset($this->browser)) {
                                if ($this->browser == $_SERVER['HTTP_USER_AGENT']) {
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
