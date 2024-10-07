<?php 
    require_once("../server/main.php");
    $userid = $_SESSION["userid"];
    $query = getQueryObject();
    if(isset($query->id)){
        $domainId = $query->id;
    }
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php
                if(isset($domainId)){
                    include("../components/domainDetails.php");
                } elseif(isset($query->action)){
                    include("../components/domainForm.php");
                } else {
                    include("../components/domainsTable.php");
                }
            ?>
        </div>
    </main>
</body>

<script src='../assets/js/domain.js'></script>
<?php include("../components/footer.php") ?>