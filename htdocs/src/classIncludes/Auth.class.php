<?php
include $_SERVER['DOCUMENT_ROOT']. "/src/classIncludes/Database.class.php";
class Auth{
    public $id;
    public $ip;
    public $credential;
    public $token;
    public $uid;
    public $conn;
    public $fingerprint;

    public static function authenticate($emailAddress, $password, $fingerprint = NULL){
        // setting fingerprint from cookie
        $login = false;
        if($fingerprint == NULL){
            echo"fingerprint doesn't exists";
            $fingerprint = $_COOKIE['fingerprint'];
        }
        User::login($emailAddress, $password);
        if($login == true){
            // getting database connection
            $conn = Database::getconnection();
            $ip = $_SERVER["REMOTE_ADDR"];
            $browser = $_SERVER["HTTP_USER_AGENT"];
            $token = md5(rand(0,99999).$ip.$browser.$fingerprint);
            $sql_query = "INSERT INTO `session` (`uid`, `ip`, `browser`,`login_time`, `fingerprint`, `token`)
                          VALUES ('$emailAddress->id', '$ip', '$browser', now(), '$fingerprint', '$token')";
            $result = $conn->query($sql_query);
            if($result){
                Session::set("session_token", $token);
                Session::set("fingerprint", $fingerprint);
            }
        }
        
    }

}