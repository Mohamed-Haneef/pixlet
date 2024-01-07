<?php
include 'src/load.php';

$data = ["authenticated_token"=>$token_authenticated];

Session::renderPage("_head");
Session::renderPage("_header", $data);




var_dump(Session::get("session_token"));
var_dump($data["authenticated_token"]);
if(Session::isauthorized($data["authenticated_token"])) {
    Session::renderPage("_uploadpage");
} else {
    echo "You need to login to share your memories";
}
Session::renderPage("_footer");
