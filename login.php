<?php 
    // if( isset($_COOKIE["current_session"]) ){ 
    //     $base_dir = pathinfo(getcwd())["basename"];
    //     header("Location: ../$base_dir");
    // } 

    session_start();
    // print_r($_COOKIE);
    // exit();
    // print_r($_SESSION);
    if( isset($_SESSION["userid"]) ){ 
        $base_dir = pathinfo(getcwd())["basename"];
        header("Location: ../$base_dir");
    } 
?>

<head>
    <title>NXG App</title>
    <link href="assets/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="assets/lib/bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/lib/jquery/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        #togglePassword {
            cursor: pointer;
            top: 0.75rem;
            right: 1rem;
        }

        #login {
            /* border: 2px solid black; */
            border-radius: 1rem;
            padding: 2rem;
            /* box-shadow: 5px 10px #888888; */

        }

        .fade-anim {
            /* transition: opacity 0.5s; */
        }

        .login-success, .login-fail {
            /* opacity: 0; */
        }
    </style>
</head>


<body class="container h-100 bg-light">
    <section class="login d-flex flex-column justify-content-center h-100" style="margin-top: -7rem">
        <div class="row justify-content-center">
            <div class="col-4 shadow rounded-3 pt-4 bg-white">
                <div class="title row mb-4">
                    <h1 class="dba text-center text-primary">NXG Media</h1>
                </div>

                <form id="login" action="#" class="row pt-2">
                    <input type="hidden" name="service" value="login">
                    <div class="col-10 mx-auto pt-2">
                        <div class="mb-3 mt-3 sm">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <i class="bi bi-eye-slash position-absolute" id="togglePassword"></i>
                        </div>
                        <div class="form-check mb-3 ms-1">
                            <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember"> Remember me
                            </label>
                        </div>

                        <div class="alert alert-success login-success fade-anim d-none">
                            <span><strong>Login Successful!</strong></span>
                        </div>

                        <div class="alert alert-danger login-fail fade-anim d-none">
                            <span><strong>Login Failed...</strong></span>
                        </div>
                        
                        <button type="button" class="btn btn-primary me-2" onclick="login()" id="btn-login">Submit</button>
                        <div class="spinner-border spinner-border-sm text-primary p-0 status-loading d-none" role="status"></div>
                    </div> 
                </form>
            </div>
        </div>
    </section>
    
</body>

<script src="assets/main.js"></script>
<script src="assets/js/login.js"></script>