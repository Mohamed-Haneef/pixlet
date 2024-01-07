<?php
if((array_key_exists('logout', $_POST))) {

    Session::unset();
    Session::destroy();
    unset($_COOKIE['fingerprint']);
}
?>

<div class="container">
	<header class="p-3">
		<div class="container">
			<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

				<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
					<li><a href="/" class="nav-link px-2 text-white blue-nav-box">Home</a></li>
					<li><a href="/mypost" class="nav-link px-2 text-info white-nav-box">My posts</a></li>
					<li><a href="/uploadphoto" class="nav-link px-2 text-white blue-nav-box">Upload photo</a></li>
					<li><a href="/globalchat" class="nav-link px-2 text-info white-nav-box">Global chat</a></li>
					<li><a href="" class="nav-link px-2 text-white blue-nav-box">Review page</a></li>
				</ul>

				<div class="text-end" style="display: inline-block">
					<?php
                if(Session::isauthorized($data["authenticated_token"])) {
                    ?>
					<form method="post">
						<button class="btn btn-danger" name="logout">Logout</button>
					</form>

					<?php
                } else { ?>
					<a href="/login" class="btn btn-outline-light me-2">Login</a>
					<a href="/signup" class="btn btn-warning">Sign-up</a>
					<?php } ?>


				</div>
			</div>
		</div>
	</header>
</div>