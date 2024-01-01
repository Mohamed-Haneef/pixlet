<?php
include_once 'src/load.php';
?>
<html>
<?php Session::renderPage("_head");

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
}


?>


<body>

	<!-- Checking whether the given session is an authorized one -->
	<?php
if(isset($session_authenticated) && null !== Session::get("username")) {
    if($session_authenticated == Session::get("username")) {
    
        ?>
	<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog"
		id="modalSheet">
		<div class="modal-dialog" role="document">
			<div class="modal-content rounded-4 shadow">
				<div class="modal-header border-bottom-0">
					<h1 class="modal-title fs-5">Hello <span
							class="text-info"><?php echo Session::get("username"); ?></span>
					</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body py-0">
					<p>Hello mate, you have successfully logged in.. welcome to Pixlet where <strong>pixels speak up
							stories..<strong></p>
				</div>
				<div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
					<form method="post">
						<button class="btn btn-danger" name="logout" value="logout">Logout</button>
					</form>




				</div>
			</div>
		</div>

		<?php } else {
		    ?>
		<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog"
			id="modalSheet">
			<div class="modal-dialog" role="document">
				<div class="modal-content rounded-4 shadow">
					<div class="modal-header border-bottom-0">
						<h1 class="modal-title fs-5">Hello <span
								class="text-info"><?php echo Session::get("username"); ?></span>
						</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body py-0">
						<p>Login success !!
							You may leave now.. Logout!!
						</p>
					</div>
					<div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
						<form method="post">
							<button class="btn btn-danger" name="logout" value="logout">Logout</button>
						</form>




					</div>
				</div>
			</div>

			<?php }
		//  If not authorized session make them to login or signup again
} else {
    ?>

			<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1"
				role="dialog" id="modalSheet">
				<div class="modal-dialog" role="document">
					<div class="modal-content rounded-4 shadow">
						<div class="modal-header border-bottom-0">
							<h1 class="modal-title fs-5">Hello</h1>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body py-0">
							<p>Hello Welcome to this page... Login to continue... If you are new please signup</p>
						</div>
						<div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
							<a href="/login.php" class="btn btn-primary">Login</a>
							<a href="/signup.php" class="btn btn-secondary">Signup</a>
						</div>
					</div>
				</div>
				<?php
}
?>



</body>

</div>

</html>