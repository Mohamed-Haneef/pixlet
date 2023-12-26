<?php

class WebAPI
{

    public function initiateSession()
    {
        Session::start();
        if (Session::isset("session_token")) {
            try {
                Session::$userSession = Auth::authorize(Session::get('session_token'));
                if(Session::$userSession) {
                    // echo"success";
                    return Session::$userSession;
                }
            } catch (Exception $e) {
                
            }
        }
        
    }
}
