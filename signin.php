<?php 
// Check if the user is signing out
// Start a session
session_start();
$err = '';

//session_unset(), exit() functions -https://www.simplilearn.com/tutorials/php-tutorial/php-login-form
if (isset($_GET['signout'])) {

    $_SESSION['signed_in'] = false;
    $_SESSION = array();
    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to the sign-in page
    header('Location: signin.php');
    exit();
}
// Check if the user is already signed in - idea taken from - https://www.eggslab.net/php-login-script/
if (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
    // Redirect to post.php if the user is already signed in
    header('Location: post.php');
    exit();
}
// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Get the input fields from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    

    //create connection
    include('serverlogin.php');
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);

    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   // Query the database for the user
   //mysqli_fetch_array idea retrived from https://www.php.net/manual/en/mysqli-result.fetch-assoc.php and https://www.eggslab.net/php-login-script/
   $sql = "SELECT * FROM signin WHERE Username=?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("s", $username);
   $stmt->execute();
   $result = $stmt->get_result();
   $row = $result->fetch_assoc();
   $count = $result->num_rows;

   if ($count == 1) {
    $password_inDB = $row['Password'];
    if (password_verify($password, $password_inDB)) {
    // Set session variables
    $_SESSION['signed_in'] = true;
    $_SESSION['UserID'] = $row['UserID'];
    $_SESSION['ArtistID'] = $row['ArtistID'];
    header('Location:post.php');
    exit;
  } else {
    $err = "Sorry, password is incorrect, try again";
  }
}
// if both are incorrect, display a message
else{
    $err = "Invalid username and password";
}

    // Close the database connection
    $stmt->close();
    $conn->close();

}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content />
        <meta name="author" content />
        <title>Art by you</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column"> 
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.php">Art by You</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="post.php">Post</a></li>
                            <li class="nav-item"><a class="nav-link" href="artists.php">Artists</a></li>
                            <li class="nav-item"><a class="nav-link" href="collections_T.php">Collections</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sign In</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="signin.php">Sign In</a></li>
                                    <li><a class="dropdown-item" href="signin.php?signout=true">Sign Out</a></li>
                                </ul>
                            </li>                                    
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Page content-->
            <section class="py-5">
                <div class="container px-5">
                    <!-- Contact form-->
                    <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                        <div class="text-center mb-5">
                            <h1 class="fw-bolder">Sign In</h1>
                        </div>
                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                                <!-- * * * * * * * * * * * * * * *-->
                                <!-- * * SB Forms Contact Form * *-->
                                <!-- * * * * * * * * * * * * * * *-->
                                <!-- This form is pre-integrated with SB Forms.-->
                                <!-- To make this form functional, sign up at-->
                                <!-- https://startbootstrap.com/solution/contact-forms-->
                                <!-- to get an API token!-->
                                <form id="contactForm" method="POST" action ="signin.php" data-sb-form-api-token="API_TOKEN">
                                    <!-- Username input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="username" name="username" type="text" placeholder="Enter your username..." data-sb-validations="required" />
                                        <label for="username">Username</label>
                                        <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
                                    </div>
                                    <!-- Password input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" data-sb-validations="required,email" />
                                        <label for="password">Password</label>
                                        <div class="invalid-feedback" data-sb-feedback="password:required">A password is required.</div>
                                    </div>
                                    <!-- Submit success message-->
                                    <!---->
                                    <!-- This is what your users will see when the form-->
                                    <!-- has successfully submitted-->
                                    <div class="d-none" id="submitSuccessMessage">
                                        <div class="text-center mb-3">
                                            <div class="fw-bolder">Form submission successful!</div>
                                            To activate this form, sign up at
                                            <br />
                                            <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                        </div>
                                    </div>
                                    <!-- Submit error message-->
                                    <!---->
                                    <!-- This is what your users will see when there is-->
                                    <!-- an error submitting the form-->
                                    <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                                    <!-- Submit Button-->
                                    <div class="d-grid"><input type="submit" class="btn btn-primary" name="submit"></div>
                                    <p> <br> <?php echo $err ?> </p>
                                     <div class="text-center my-3">
                                         <h5>Don't have an account?</h5>
                                        <h5>Join now and start posting your artwork</h5>
                                        </div>
                                </form>
                                <div class="d-grid"><button class="btn btn-primary" onclick="window.location.href = 'createAccount.php';">Create Account</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- Footer-->
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Your Website 2022</div></div>
                    <div class="col-auto">
                        <a class="link-light small" href="#!">Privacy</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="#!">Terms</a>
                        <span class="text-white mx-1">&middot;</span>
                        <a class="link-light small" href="#!">Contact</a>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>