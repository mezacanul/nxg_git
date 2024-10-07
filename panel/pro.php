<?php 
    require_once("../server/main.php");
    $hostingerTBL = getQuery("SELECT * FROM hostinger");
    $query = getQueryObject();

    // print_r($query);
    
    if(isset($query->id)){
        $website = getQuery("SELECT website.*, signer.name as signer, signer.id as signerID, corp.id as corpID, corp.title as corp FROM website LEFT JOIN corp ON website.corp = corp.id LEFT JOIN signer ON corp.signer = signer.id WHERE website.id = '{$query->id}'")[0];
        // print_r($website);
    } elseif (isset($query->signer)) {
        # code...
    }
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php
                include("../components/pro_signer.php");
                include("../components/pro_twilio.php");
                include("../components/pro_namecheap.php");
            ?>
            <div class="row btn-website-builder-container ms-1 collapse">
                <!-- <select name="hostinger" class="form-select w-auto me-2">
                    <option value>Select a Hostinger Account</option>
                    <?php foreach($hostingerTBL as $htgr) { ?>
                        <option 
                            value="<?php echo $htgr["id"] ?>"
                            >
                            <?php echo $htgr["account"] ?>
                        </option>
                    <?php } ?>
                </select> -->
                <a class="btn btn-dark w-auto">Proceed to Website Builder</a>
            </div>
        </div>
    </main>
</body>


<script src="../assets/js/namecheap_helper.js"></script>
<script src="../assets/js/pro.js"></script>
<?php include("../components/footer.php") ?>