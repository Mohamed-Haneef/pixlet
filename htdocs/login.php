<?php
include 'src/load.php';

// Validation
$Email_error = false; // email id
$Login_authenticated = false; //complete validation

if (isset($_POST['emailAddress']) && isset($_POST['password'])) {

    // User details
    $emailAddress = $_POST['emailAddress'];
    $password = htmlspecialchars($_POST['password']);
    $redirect= Auth::authenticate($emailAddress, $password);

    // $redirect returns integer values as return value upon their success
    /*
        4 - full success
        3 - email and password mismatch
        2 - email doesn't exist needs to signup
    */
    if ($redirect == 4) {
        header('Location: /');
        exit();
    } elseif ($redirect == 2) {
        $Email_error = true;
    } elseif ($redirect == 3) {
        $Login_authenticated = true;
    }
}
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<?php Session::renderPage("_head")?>

<body class="d-flex align-items-center py-4 sign-in">
	<main class="form-login w-100 m-auto">
		<form method="POST" action="/login.php">
			<img src="src/img/pixlet_logo.png" alt="Pixlet" width="70" height="70" style="margin-left: 30%;">
			<h1 class="h3 mb-3 fw-normal"> Welcome to world of <span class="text-info"
					style="margin-left: 30%">PIXLET</span></h1>

			<div class="form-floating mt-5">
				<input type="email" class="form-control" id="floatingInput" placeholder="Email" name="emailAddress">
				<label for="floatingInput">Email</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password"
					name="password">
				<label for="floatingPassword">Password</label>
			</div>
			<?php
            if($Email_error) {?>

			<div class="danger my-3">
				<p><strong>Warning! : </strong> Email doesn't exists</p>
			</div>
			<?php }
            if($Login_authenticated) {?>

			<div class="danger my-3">
				<p><strong>Warning! : </strong> Email and password didn't match</p>
			</div>
			<?php } ?>

			<button class="btn btn-primary w-100 py-2 my-4" type="submit">Login</button>

		</form>
	</main>
	<script src="/assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>