<?php 
    require_once("../server/main.php");
    $query = getQueryObject();
    // if(isset($query->id)){
    //     $corpId = $query->id;
    // }
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php
                if(isset($query->id)){
                    include("../components/corpDetails.php");
                } elseif(isset($query->action) && $query->action == "add"){
                    include("../components/corpForm.php");
                } else {
                    include("../components/corpsTable.php");
                }
            ?>
        </div>
    </main>
</body>


<script src="../assets/js/corp.js"></script>
<?php include("../components/footer.php") ?>