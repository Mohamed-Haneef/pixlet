<?php
include('src/load.php');

// echo(Session::get('session_token'));
echo $_SESSION["session_token"];
$authorized = Auth::authorize(session::get('session_token'));
if($authorized == true) {
    echo "authorization success";
} else {
    echo "fail";
}
?>

<!-- 	198mv2imj209vril069iqrnm0o -->