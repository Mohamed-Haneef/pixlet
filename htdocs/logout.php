<?php

include("src/load.php");

Session::unset();
Session::destroy();
unset($_COOKIE['fingerprint']);
header('Location: /');
