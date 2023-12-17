<?php
include 'src/classIncludes/Session.class.php';
include 'src/classIncludes/User.class.php';
$validation = false;

$userName = $_POST['userName'];
$emailAddress = $_POST['emailAddress'];
$mobileNumber = $_POST['mobileNumber'];
$password = $_POST['password'];
  //checking whether the required details are given
  if(isset($userName) && isset($emailAddress) && isset($mobileNumber) && isset($password))
  {
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
    if(preg_match('/^[a-zA-Z][0-9a-zA-Z_]{2,23}[0-9a-zA-Z]$/', $userName))
    {
        if(filter_var($emailAddress, FILTER_VALIDATE_EMAIL))
        {
            if(preg_match('/^[0-9]{10}+$/', $mobileNumber))
            {
                $validation = true;
            }
        }
    }
  }

  if($validation){
    User::updateCredentials($userName, $emailAddress, $mobileNumber, $password);
    
  }
?>
<!doctype html>

<html lang="en" data-bs-theme="auto">

<?php Session::renderPage("_signup")?>

<body class="d-flex align-items-center py-4 sign-in">


    <main class="form-signin w-100 m-auto">
        <form method="post" action="/signup.php">
            <img src="src/img/pixlet_logo.png" alt="Pixlet" width="70" height="70" style="margin-left: 30%;">
            <h1 class="h3 mb-3 fw-normal"> Welcome to world of <span class="text-info"
                    style="margin-left: 30%">PIXLET</span></h1>

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

            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                </label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>

        </form>
    </main>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>