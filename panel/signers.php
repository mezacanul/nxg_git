<?php 
    require_once("../server/main.php");
    if(isset(parse_url($_SERVER['REQUEST_URI'])["query"]) == 1){
        $signerId = str_replace("id=", "", parse_url($_SERVER['REQUEST_URI'])["query"]);
    }
    // $signerId = str_replace("id=", "", parse_url($_SERVER['REQUEST_URI'])["query"]);
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php
            if(isset($signerId) != 1){
                include("../components/signersTable.php");
            } else {
                include("../components/signerDetails.php");
            }
            ?>
        </div>
    </main>
</body>


<?php include("../components/footer.php") ?>