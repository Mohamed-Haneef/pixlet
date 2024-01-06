<?php
if((array_key_exists('logout', $_POST))) {

    Session::unset();
    Session::destroy();
    unset($_COOKIE['fingerprint']);
}
?>

<div class="container">
	<header class="p-3 text-bg-dark">
		<div class="container">
			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
				<a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
					<svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
						<use xlink:href="#bootstrap" />
					</svg>
				</a>

				<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
					<li><a href="#" class="nav-link px-2 text-secondary">Home</a></li>
					<li><a href="#" class="nav-link px-2 text-white">Features</a></li>
					<li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
					<li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
					<li><a href="#" class="nav-link px-2 text-white">About</a></li>
				</ul>

				<div class="text-end" style="display: inline-block">
					<?php
                if(Session::isauthorized($data["authenticated_token"])) {
                    ?>
					<form method="post">
						<button class="btn btn-danger mx-3 align-items-center" name="logout" id="logout">Logout</button>
					</form>

					<?php
                } else { ?>
					<a href="/login.php" class="btn btn-outline-light me-2">Login</a>
					<a href="/signup.php" class="btn btn-warning">Sign-up</a>
					<?php } ?>


				</div>
			</div>
		</div>
	</header>
</div>