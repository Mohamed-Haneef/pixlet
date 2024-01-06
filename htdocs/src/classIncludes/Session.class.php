<?php
class Session
{
    public static $user = null;
    public static $userSession = null;

    // Creates session
    public static function start()
    {
        session_start();
    }
    // Unsets session values
    public static function unset()
    {
        session_unset();
    }
    // Destroys session
    public static function destroy()
    {
        session_destroy();
    }
    // Setting up a session
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    //deleting keys
    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }
    //checking whether a session is present
    public static function isSet($key)
    {
        return isset($_SESSION[$key]);
    }
    //getting a key from session
    public static function get($key, $default = false)
    {
        if(Session::isSet($key)) {
            return $_SESSION[$key];
        } else {
            return $default;
        }
    }
    //static function for rendering pages
    public static function renderPage($pagename, $data = [])
    {
        extract($data);
        $page = $_SERVER["DOCUMENT_ROOT"]."/_template/$pagename.php";
        if(is_file($page)) {
            include $page;
        } else {
            Session::renderPage("_error");
            exit();
        }
    }
    public static function loadMaster($token)
    {
        Session::renderPage('_master', ["authenticated_token"=>$token]);
    }

    public static function isauthorized($token)
    {
        if(isset($token) && null !== Session::get("session_token")) {
            if($token == Session::get("session_token")) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
