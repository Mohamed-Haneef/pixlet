<?php
include 'Session.class.php';
include 'Auth.class.php';
class WebAPI
{

    public function initiateSession()
    {
        Session::start();
        if (Session::isset("session_token")) {
            try {
                Session::$userSession = Auth::authorize(Session::get('session_token'));
                if(Session::$userSession) {
                    echo"success";
                }
            } catch (Exception $e) {
                
            }
        }
        // $__base_path = get_config('base_path');
    }
}