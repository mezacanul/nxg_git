<?php 
    require_once("../server/main.php");
    if(isset(parse_url($_SERVER['REQUEST_URI'])["query"]) == 1){
        $submissionId = str_replace("id=", "", parse_url($_SERVER['REQUEST_URI'])["query"]);
    }
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <!-- APP -->
    <main class="container py-5 my-3">
        <?php include("../components/builderForm.php"); ?>

        <?php include("../components/websiteOptions.php"); ?>
        <hr>

        <!-- <div class="options container d-flex flex-column p-0 mt-4"> -->
            <div class="buttons mb-3 p-0 mt-4 mb-4 d-flex align-items-center" id="wb_actions">
                <button onclick="create()" type="button" class="btn btn-primary createDemoBtn me-2">
                    <p class='m-0'>Create Website</p>
                    <!-- <p class="statusAnim m-0">
                        Creating site...
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </p> -->
                </button>
                <!-- <button onclick="demo()" type="button" class="btn btn-primary me-2">Demo</button> -->
                <button onclick="download()" type="button" disabled class="btn btn-primary me-3" id="downloadDemoBtn">Download</button>
                <div class="spinner-border spinner-border-sm text-primary me-3 d-none" role="status"></div>
                <a id="demoLink" target="_blank">
                    <span class="target"></span>
                </a>
                <a id="zipLinkTarget" target="_blank"></a>
            </div>
        <!-- </div> -->

        <hr>
    </main>
</body>


<?php include("../components/footer.php") ?>