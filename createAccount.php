<?php
// Start the session 
session_start();
if (isset($_GET['signout'])) {

    $_SESSION['signed_in'] = false;
    // Destroy the session
    session_destroy();

    // Redirect to the sign-in page
    header('Location: signin.php');
    exit();
}

//create connection
include('serverlogin.php');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$username = '';
$password = '';
$name = '';
$artistType = '';
$aboutYou = '';
$uploadImage = '';
$err = '';

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $uploadImage = $_POST['uploadImage'];
    $artistType = $_POST['artistType'];
    $aboutYou = $_POST['aboutYou'];
    $err = '';

      
    //check for missing inputs
    if (empty($name)){
     $err .= "Name is required. ";
    }
    if (empty($artistType)){
    $err .= "Type of Artist is required. ";
    }
    if (empty($aboutYou)){ 
    $err .= "About you is required. ";
    }
    if (empty($uploadImage)){

     $err .= "Image is required. ";
    }
    if (empty($username)){

     $err .= "Username is required. ";
    }
    if (empty($password)){
     $err .= "Password is required. ";
    }elseif(!preg_match('/\w{7,}/', $password)){
        $err .= "Password must be at least 7 characters long.";
    }elseif(!preg_match('/\d/', $password)){
        $err .= "Password must contain at least one number.";
    }elseif(!preg_match('/[^A-Za-z0-9]+/', $password)){
        $err .= "Password must contain at least one special character and it should be non digital and non alpha .";
    }
    elseif(!preg_match('/[A-Z]/', $password)){
        $err .= "Password must contain at least one Capital letter.";
    }
   

    //if there are no errors
    if($err === ''){

    // Check if the username already exists in the database
    $sql = "SELECT * FROM signin WHERE Username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        // Username already exists
        $err = "Username already exists. Please try again.";
    } else {
        // Insert the new user into the database
        // First, insert into the Artists table
        $sql1 = "INSERT INTO artists (Name, Type, ArtistImage, Description) VALUES (?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("ssss", $name, $artistType, $uploadImage, $aboutYou);
        $stmt1->execute();
        $ArtistID = $stmt1->insert_id; // Get the newly created ArtistID

        // Then, insert into the Signin table using the ArtistID
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql2 = "INSERT INTO signin (Username, Password, ArtistID) VALUES (?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ssi", $username, $hashedPassword, $ArtistID);
        $stmt2->execute();

        // Set the session variables
        $_SESSION['signed_in'] = true;
        $_SESSION['UserID'] = mysqli_insert_id($conn); // Get the newly created UserID
        $_SESSION['ArtistID'] = $ArtistID;
        header('Location:post.php');
        exit;
    }   
        $stmt->close();
        $stmt1->close();
        $stmt2->close();
    }
}
    
    // Close the database connection
    $conn->close();

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
                            <h1 class="fw-bolder">Create New Account</h1>
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

                                <form id="contactForm" method="POST" action="createAccount.php" data-sb-form-api-token="API_TOKEN">
                                    <!-- name input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="name" type="text" name='name' placeholder="Enter your name..." data-sb-validations="required" />
                                        <label for="name">Name</label>
                                        <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                                    </div>
                                    <!-- art-title input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="artistType" type="text" name="artistType" placeholder="Enter your type..." data-sb-validations="required" />
                                        <label for="artistType">Type of Artist</label>
                                        <div class="invalid-feedback" data-sb-feedback="artistType:required">A type is required.</div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="aboutYou" type="text" name="aboutYou"placeholder="Enter your about You..." data-sb-validations="required" />
                                        <label for="aboutYou">Tell us about you</label>
                                        <div class="invalid-feedback" data-sb-feedback="aboutYou:required">About you is required.</div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="uploadImage" type="text" name="uploadImage" placeholder="Enter your image..." data-sb-validations="required" />
                                        <label for="uploadImage">Upload an image of yourself</label>
                                        <div class="invalid-feedback" data-sb-feedback="uploadImage:required">An image is required.</div>
                                    </div>
                                    <!-- Username input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="username" name="username" type="text" placeholder="Enter your username..." data-sb-validations="required" />
                                        <label for="username">Create a Username</label>
                                        <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
                                    </div>
                                    <!-- Password input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" data-sb-validations="required,email" />
                                        <label for="password">Create a Password</label>
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
                                    <div class="d-grid">
                                        <input type="submit" class="btn btn-primary" name="submit">

                                </div>
                                <p> <br> <?php echo $err ?> </p>
                                </form>
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
