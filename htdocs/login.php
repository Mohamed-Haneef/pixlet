<?php
include 'src/load.php';

if (isset($_POST['emailAddress']) && isset($_POST['password'])) {
    $emailAddress = $_POST['emailAddress'];
    $password = $_POST['password'];
    $redirect= Auth::authenticate($emailAddress, $password);
    if ($redirect) {
        header('Location: /');
        exit();
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

			<div class="form-floating">
				<input type="email" class="form-control" id="floatingInput" placeholder="Email" name="emailAddress">
				<label for="floatingInput">Email</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password"
					name="password">
				<label for="floatingPassword">Password</label>
			</div>

			<div class="form-check text-start my-3">
				<input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
				<label class="form-check-label" for="flexCheckDefault">
					Remember me
				</label>
			</div>
			<button class="btn btn-primary w-100 py-2" type="submit">Login</button>
			<p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>
		</form>
	</main>
	<script src="/assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>