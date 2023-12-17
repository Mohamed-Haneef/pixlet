<?php
// include $_SERVER['DOCUMENT_ROOT']. "/src/classIncludes/Database.class.php";
// include $_SERVER['DOCUMENT_ROOT']. "/src/classIncludes/User.class.php";
// include $_SERVER['DOCUMENT_ROOT']. "/src/classIncludes/Session.class.php";
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
        echo "authentication page";
        $login = false;
        if($fingerprint == NULL){
            echo"fingerprint doesn't exists";
            $fingerprint = $_COOKIE['fingerprint'];
        }
        User::login($emailAddress, $password);
        echo "after lgin";
        if($login == true){
            // getting database connection
            echo "start";
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