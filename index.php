<?php 
    require_once("server/main.php");
    // $accountId = str_replace("id=", "", parse_url($_SERVER['REQUEST_URI'])["query"]);
?>

<?php //include("components/head.php") ?>

<head>
    <title>NXG App</title>
    <link href="assets/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="assets/lib/bootstrap/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/style.css">
    <script src="assets/lib/jquery/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        #panelMenu .row {
            margin-bottom: 1.2rem;
        }
    </style>
</head>

<body class="bg-light">
    <?php include("components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5 my-5" id="panelMenu">
            <?php if($_SESSION["role"] == "app"){ ?>
                <div class="row">
                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/product_check.php">
                        <span class="h5">Product Check</span>
                    </a>
                    <!-- <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/signer.php">
                        <span class="h5">Signers</span>
                    </a>

                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/corp.php">
                        <span class="h5">Corps</span>
                    </a>

                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/website.php">
                        <span class="h5">Websites</span>
                    </a> -->
                </div>
            <?php } elseif ($_SESSION["role"] == "dev") { ?>    
                <div class="row d-flex justify-content-between">
                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/signer.php">
                        <span class="h5">Signers</span>
                    </a>

                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/website.php">
                        <span class="h5">Websites</span>
                    </a>

                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/namecheap_acct.php">
                        <span class="h5">Namecheap Accts.</span>
                    </a>

                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/domain.php">
                        <span class="h5">Domains</span>
                    </a>

                    <!-- <a class="col-2 btn btn-outline-primary border-3 me-3 py-3 api-title-container" href="panel/namecheap_twilio.php">
                        <h5 class="m-0">
                            <span class="api-title-span text-namecheap">Namecheap</span>  + <span class="api-title-span text-twilio">Twilio</span>
                        </h5>
                    </a> -->

                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/website_builder.php">
                        <span class="h5">Website Builder</span>
                    </a>
                </div>

                <div class="row d-flex justify-content-start">
                    <a class="col-2 btn btn-outline-primary border-3 me-5 py-3" href="panel/hostinger_acct.php">
                        <span class="h5">Hostinger Accts.</span>
                    </a>

                    <a class="col-2 btn btn-outline-primary border-3 me-3 py-3" href="panel/product_check.php">
                        <span class="h5">Product Check</span>
                    </a>
                </div>
            <?php } ?>
        
            <?php
            // if($corpId == ""){
            //     include("../components/corpsTable.php");
            // } else {
            //     include("../components/corpDetails.php");
            // }
            ?>
        </div>
    </main>
</body>

<script src="assets/on-load.js"></script>
<script src="assets/main.js"></script>
<?php //include("components/footer.php") ?>