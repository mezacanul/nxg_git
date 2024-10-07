<?php 
    require_once("../server/main.php");
    $userid = $_SESSION["userid"];
    $query = getQueryObject();

    if(isset($query->id)){
        $namecheapAcctID = $query->id;
    }
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php 
                if((isset($query->action) && $query->action == "add") || isset($namecheapAcctID)){
                    include("../components/namecheapAcctsForm.php");
                } else {
                    include("../components/namecheapAcctsTable.php");
                }
            ?>
        </div>
    </main>
</body>


<?php include("../components/footer.php") ?>