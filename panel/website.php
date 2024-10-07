<?php 
    require_once("../server/main.php");
    $query = getQueryObject();
    // if(isset($query->id)){
    //     $websiteId = $query->id;
    //     // $websiteId = str_replace("id=", "", parse_url($_SERVER['REQUEST_URI'])["query"]);
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
                include("../components/websiteDetails.php");
            } elseif (isset($query->action)) {
                include("../components/websiteForm.php");
            } else {
                include("../components/websitesTable.php");
            }
            ?>
        </div>
    </main>
</body>


<script src="../assets/js/website.js"></script>
<?php include("../components/footer.php") ?>