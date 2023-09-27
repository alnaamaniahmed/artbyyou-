<?php 
session_start();
if (isset($_GET['signout'])) {

    $_SESSION['signed_in'] = false;
    // Destroy the session
    session_destroy();

    // Redirect to the sign-in page
    header('Location: signin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Art by You</title>
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
            <!-- About Our Story section-->
            <section class="py-5 bg-light" id="scroll-target">
            
            <?php
    // Connect to the database
    include('serverlogin.php');
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get artist's data from the database- https://www.w3schools.com/php/default.asp
    $name1 = $_GET['name'];
    $sql = "SELECT * FROM artists WHERE Name = '$name1'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row, fetch_assoc idea taken from  both https://www.php.net/manual/en/mysqli-result.fetch-assoc.php and https://www.w3schools.com/php/default.asp
        while($row = $result->fetch_assoc()) {
            $text = $row['Name'];
            $img = $row['ArtistImage'];
            $profession = $row['Type'];
            $description = $row['Description'];
            $output = <<<HTML
                <div class="container px-5 my-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="$img" alt="..." /></div>
                        <div class="col-lg-6">
                            <h2 class="fw-bolder">$text - $profession</h2>
                            <p class="lead fw-normal text-muted mb-0">$description</p>
                        </div>
                    </div>
                </div> 
            HTML;
            echo $output;
        }
    } else {
        echo "There are no results";
    }
    $conn->close();
?>

    <section class="py-5">
        <div class="container px-5 my-5">
            <div class="row gx-5">
            <?php
// Connect to the database
include('serverlogin.php');
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get artist's data from the database
$name1 = $_GET['name'];
$sql = "SELECT Title, ArtImage FROM artwork JOIN artists ON artwork.ArtistID = artists.ArtistID WHERE Name = '$name1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row, fetch_assoc idea idea taken from  both https://www.php.net/manual/en/mysqli-result.fetch-assoc.php and https://www.w3schools.com/php/default.asp
    while($row = $result->fetch_assoc()) {
        $text = $row['Title'];
        $img = $row['ArtImage'];
        $output = <<<HTML
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <img class="card-img-top" src="$img" alt="..." />
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bolder mb-3">$text</h5>
                    </div>
                </div>
            </div>
        HTML;
        echo $output;
    }
} else {
    echo "There are no results";
}
$conn->close();
?>
</div>
</div>
            </section> 
        </main>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>