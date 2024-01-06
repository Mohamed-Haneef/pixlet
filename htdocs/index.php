<?php
include_once 'src/load.php';

// Logout instruction - removing session and reloading the page
if((array_key_exists('logout', $_POST))) {

    Session::unset();
    Session::destroy();
    unset($_COOKIE['fingerprint']);
    ?>
<script>
	console.log("logout")
</script>
<?php
    header('Location: /');
} else {
    Session::loadMaster($token_authenticated);
}
?>