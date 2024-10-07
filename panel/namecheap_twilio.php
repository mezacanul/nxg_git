<?php 
    require_once("../server/main.php");
    $corps = getQuery("SELECT * FROM corp ORDER BY title");
    // print_r($corps[0]);
    // $submissionId = str_replace("id=", "", parse_url($_SERVER['REQUEST_URI'])["query"]);
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php
                include("../components/namecheapSetup.php");
                include("../components/twilioSetup.php");
            ?>

            <div class="row mb-4">
                <div class="col-3">
                    <p><b>Select Corp</b></p>
                    <select name="corp" id="corp" class="form-select">
                        <?php foreach ($corps as $crp) { ?>
                            <option value="<?php echo $crp["id"]?>"><?php echo $crp["title"]?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>        

            <div class="row">
                <div class="col-3 d-flex align-items-end">
                    <button class="btn btn-primary me-3" onclick="proceed_website_builder()" type="button">Proceed to Website Builder</button>
                </div>
            </div>        

        </div>
    </main>
</body>


<?php include("../components/footer.php") ?>
<script src="../assets/js/namecheap_twilio.js"></script>