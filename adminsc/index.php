<?php
require(__DIR__ . "/inc/head_operations.php");

if ($_SESSION['m3cms']["user_id"] > 0) { 
    mysqli_close($sqlConn);
    header("Location: main.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="dark">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Bootstrap css -->
    <link href="css\bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- App css -->
    <link href="css\app.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="authentication-bg authentication-bg-pattern">
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card bg-pattern">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <div class="auth-brand">
                                <a href="index.html" class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <img src="images/statehouse_crest.jpg" alt="" height="70">
                                    </span>
                                </a>
                                <a href="index.html" class="logo logo-light text-center">
                                    <span class="logo-lg">
                                        <img src="images/statehouse_crest.jpg" alt="" height="70">
                                    </span>
                                </a>
                            </div>
                            <p class="text-muted mb-4 mt-3">Enter your username  and password to access admin panel.</p>
                        </div>
                        <form action="index.php" method="post">
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Username</label>
                                <input class="form-control" type="text" name="user" value="" placeholder="Enter your username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="passwd" class="form-control" placeholder="Enter your password">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?php echo $_SESSION['m3cms']['token']; ?>">
                            <div class="mb-3">
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn btn-primary" type="submit"> Log In </button>
                            </div>
                        </form>
                       




                        