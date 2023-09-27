<?php
session_start();

// Check if the user is signed in
if (!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] !== true) {
    // Redirect the user to the sign-in page if not signed in
    header('Location: signin.php');
    exit();
}
?>
<?php
//create connection
include('serverlogin.php');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['signout'])) {

    $_SESSION['signed_in'] = false;
    // Destroy the session
    session_destroy();

    // Redirect to the sign-in page
    header('Location: signin.php');
    exit();
}
//session artistID
$artistID = $_SESSION['ArtistID'];
//initialize error message and form fields - idea taken from  https://www.w3schools.com/php/default.asp and https://www.webslesson.info/2017/09/how-to-store-form-data-in-csv-file-using-php.html.
$err = '';
$artTitle = '';
$theme = '';
$fileName = '';
$artistName = '';

$sql = "SELECT Name FROM artists WHERE ArtistID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $artistID);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query was successful
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $artistName = $row["Name"];
    }
}
$stmt->close();

//check if the form is submitted
if(isset($_POST['submit'])){
    

    $name = $_POST['name'];
    $artTitle = $_POST['artTitle'];
    $theme = $_POST['theme'];
    $fileName = $_POST['fileName'];

    // Check for missing inputs
    if (empty($artTitle)){
        $err .= "Art title is required. ";
       }
       if (empty($theme)){
        $err .= "Theme is required. ";
       }
       if (empty($fileName)){
        $err .= "File name is required. ";
       }
    
    //If there are no errors
    if($err === ''){
    // retrieve the theme ID based on the theme name - idea taken from https://phpdelusions.net/mysqli_examples/select 
    $themeStmt = $conn->prepare("SELECT ThemeID FROM themes WHERE Theme = ?");
    $themeStmt->bind_param("s", $theme);
    $themeStmt->execute();
    $themeResult = $themeStmt->get_result();

    if($themeResult->num_rows > 0){
        //theme exists, get the  themeID
        $themeRow = $themeResult->fetch_assoc();
        $themeID = $themeRow['ThemeID'];
    }else {
        //Theme does not exist, create new theme
        $themeInsertStmt = $conn->prepare("INSERT INTO themes (Theme, ThemeImage) VALUES (?, ?)");
        $themeInsertStmt->bind_param("ss", $theme, $fileName);
        $themeInsertStmt->execute();

        //get the new theme ID
        $themeID = $conn->insert_id;
        
        //close the insert statement
        $themeInsertStmt->close();
    }
    $themeStmt->close();
    // prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO artwork (Title, ArtImage, ThemeID, ArtistID) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii",$artTitle, $fileName, $themeID, $artistID);
    
    // execute the SQL statement
    $stmt->execute();

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();

        // Clear form fields
        $name = '';
        $artTitle = '';
        $theme = '';
        $fileName = '';
    }
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
                            <h1 class="fw-bolder"><?php echo $artistName ?> Upload New Art</h1>
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

                                <form id="contactForm" method="POST" action="post.php" data-sb-form-api-token="API_TOKEN">
                                    <!-- art-title input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="artTitle" type="text" name="artTitle" placeholder="Enter your art title..." data-sb-validations="required" />
                                        <label for="artTitle">Art Title</label>
                                        <div class="invalid-feedback" data-sb-feedback="artTitle:required">An Art title is required.</div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="theme" type="text" name="theme"placeholder="Enter your theme..." data-sb-validations="required" />
                                        <label for="theme">Theme</label>
                                        <div class="invalid-feedback" data-sb-feedback="theme:required">A theme is required.</div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="fileName" type="text" name="fileName" placeholder="Enter your file name..." data-sb-validations="required" />
                                        <label for="fileName">File Name</label>
                                        <div class="invalid-feedback" data-sb-feedback="fileName:required">A file name is required.</div>
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
