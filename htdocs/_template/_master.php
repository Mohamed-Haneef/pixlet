<?php

Session::renderPage("_head");
Session::renderPage("_header", $data);
Session::renderPage("_welcomebox", $data);



var_dump(Session::get("session_token"));
var_dump($data["authenticated_token"]);
if(Session::isauthorized($data["authenticated_token"])) {
    echo "authorized user";
}
Session::renderPage("_pixlet");
