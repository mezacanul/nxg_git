<?php 
    require_once("../server/main.php");
    $query = getQueryObject();

    if(isset($query->id)){
        $signer = getQuery("SELECT * FROM signer WHERE id = '{$query->id}'")[0];
    }
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php
                if(isset($query->id)){
                    include("../components/signerDetails.php");
                } elseif (isset($query->action) && $query->action == "add") {
                    include("../components/signerForm.php");
                } else {
                    include("../components/signersTable.php");
                }
            ?>
        </div>
    </main>
</body>


<script src="../assets/js/signer.js"></script>
<?php include("../components/footer.php") ?>