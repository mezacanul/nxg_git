<?php 
    require_once("../server/main.php");
    $userid = $_SESSION["userid"];
    $queryParams = getQueryObject();
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php if(isset($queryParams->action) && $queryParams->action == "add" ){ 
                include("../components/hostingerForm.php");
            } else { 
                include("../components/hostingerAcctsTable.php");
            } ?>
        </div>
    </main>
</body>


<?php include("../components/footer.php") ?>