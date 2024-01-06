<?php
include 'src/load.php';

// variable for validation
$validation = false;  //complete validation
$mobile_fail = false; // mobile number
$name_fail = false;	  // username
$email_fail = false;  // email id

//User details
$userName = htmlspecialchars($_POST['userName']);
$emailAddress = $_POST['emailAddress'];
$mobileNumber = htmlspecialchars($_POST['mobileNumber']);
$password = htmlspecialchars($_POST['password']);

//checking whether the required details are given
if (isset($userName) && isset($emailAddress) && isset($mobileNumber) && isset($password)) {
    // credentials validation before uploading into database

    /*
    Validation Info:
     userName{
        # Can only start with letters. Either small or capital letter.
        # Allowed length between 2 and 23. Why? Because of two characters to start with and to end I subtracted them from the start and end of the requirement.
        # Can only end with a number and a letter.
     }
     mobileNumber{
        # 10 digits
        # from 0-9
     }
    */
    if (preg_match('/^[a-zA-Z0-9\s]+$/', $userName)) {
        if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            if (preg_match('/^[0-9]{10}+$/', $mobileNumber)) {
                $validation = true;
            } else {
                $mobile_fail = true;
            }
        } else {
            $email_fail = true;
        }
    } else {
        $name_fail = true;
    }
}

// Update values into database if validation becomes true
if ($validation) {
    
    User::updateCredentials($userName, $emailAddress, $mobileNumber, $password);
    // return true
    header('Location: /');
}
?>
<!doctype html>

<html lang="en" data-bs-theme="auto">

<?php Session::renderPage("_head") ?>

<body class="d-flex align-items-center py-4 sign-in">


	<main class="form-signin w-100 m-auto">
		<form method="post" action="/signup.php">
			<img src="src/img/pixlet_logo.png" alt="Pixlet" width="70" height="70" style="margin-left: 30%;">
			<h1 class="h3 mb-3 fw-normal text-white welcome-font"> Welcome to world of <span
					class="text-info welcome-font-logo" style="margin-left: 17%">PIXLET</span></h1>

			<div class="form-floating mt-5">
				<input type="text" class="form-control" id="floatingInput" placeholder="Username" name="userName">
				<label for="floatingInput">Username</label>
			</div>
			<div class="form-floating">
				<input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
					name="emailAddress">
				<label for="floatingInput">Email address</label>
			</div>
			<div class="form-floating">
				<input type="text" class="form-control" id="floatingInput" placeholder="Mobile Number"
					name="mobileNumber">
				<label for="floatingInput">Mobile Number</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control" id="floatingPassword" placeholder="Password"
					name="password">
				<label for="floatingPassword">Password</label>
			</div>
			<?php
            if($name_fail) {?>

			<div class="danger my-3">
				<p><strong>Warning! :</strong> Name should not contain special characters</p>
			</div>
			<?php }
            if($mobile_fail) {?>

			<div class="danger my-3">
				<p><strong>Warning! : </strong>Name should not contain special characters</p>
			</div>
			<?php }
            if($email_fail) {?>

			<div class="danger my-3">
				<p><strong>Warning! : </strong> Name should not contain special characters</p>
			</div>
			<?php }
            ?>
			<button class="btn btn-primary w-100 py-2 my-5" type="submit">Sign in</button>
		</form>
	</main>
	<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>