<?php
    // $signerTBL = getQuery("SELECT * FROM signer ORDER BY name");
    // // $corpTBL = getQuery("SELECT * FROM corp ORDER BY title");
    // $nicheTBL = getQuery("SELECT * FROM niche WHERE status = 1 ORDER BY title");
    // $bankWebsiteTBL = getQuery("SELECT * FROM bank_website ORDER BY title");
    // $campaignTBL = getQuery("SELECT * FROM campaign ORDER BY title");
    // $hostingerTBL = getQuery("SELECT * FROM hostinger ORDER BY account");

    $nicheTBL = getQuery("SELECT * FROM niche WHERE status = 1 ORDER BY title");
    $signersTBL = getQuery("SELECT * FROM signer ORDER BY name");
    $bankWebsiteTBL = getQuery("SELECT * FROM bank_website ORDER BY title");
    $campaignsTBL = getQuery("SELECT * FROM campaign ORDER BY title");
    $hostingerTBL = getQuery("SELECT * FROM hostinger ORDER BY account");

    if(isset($query->id)){
        $websiteID = $query->id;
        $signerID = getQuery("SELECT signer.id FROM website LEFT JOIN corp ON website.corp = corp.id LEFT JOIN signer ON corp.signer = signer.id WHERE website.id = '$websiteID'")[0]["id"];
        
        $website = getQuery("SELECT website.*, niche.title as nicheTitle, corp.title as corpTitle, signer.name as signerName, campaign.title as campaignTitle, campaign.color as colorID FROM website LEFT JOIN niche ON website.niche = niche.id LEFT JOIN corp ON website.corp = corp.id LEFT JOIN signer ON corp.signer = signer.id LEFT JOIN campaign ON corp.campaign = campaign.id WHERE website.id = '{$websiteID}'")[0];
        $corpsTBL = getQuery("SELECT * FROM corp WHERE signer = '$signerID' ORDER BY title");
        $corpID = $website["corp"];
        
        $campaignID = getQuery("SELECT campaign.id FROM website LEFT JOIN corp ON website.corp = corp.id LEFT JOIN campaign ON corp.campaign = campaign.id WHERE website.id = '$websiteID'")[0]["id"];
        // print_r($campaignID);
        // print_r($website);
    }

    if(isset($query->signer)){
        $signerID = $query->signer;
        $corpsTBL = getQuery("SELECT * FROM corp WHERE signer = '$signerID' ORDER BY title");
    }

    if(isset($query->corp)){
        $corpID = $query->corp;
        $signerID = getQuery("SELECT signer FROM corp WHERE id = '$corpID'")[0]["signer"];
        $corpsTBL = getQuery("SELECT id, title FROM corp WHERE signer = '$signerID'");
        // $corpsTBL = getQuery("SELECT * FROM corp WHERE signer = '$signerID' ORDER BY title");
    }
?>

<style>
    .color-code {
        border: 2px solid #a1a1a1;
        border-radius: 0.3rem;
        margin-left: 0.5rem;
        width: 17rem;
        height: 2rem;
        display: flex; justify-content: center; align-items: center;
    }

    .color-code p {
        margin: 0;
    }

    /* IFRAME  */
    #wrap {
        width: 50rem;
        height: 32rem;
        padding: 0;
        overflow: hidden;
      }
      #scaled-frame {
        width: 100rem;
        height: 64rem;
        /* width: 1000px;
        height: 2000px; */
        border: 0px;
      }
      #scaled-frame {
        zoom: 0.5;
        -moz-transform: scale(0.5);
        -moz-transform-origin: 0 0;
        -o-transform: scale(0.5);
        -o-transform-origin: 0 0;
        -webkit-transform: scale(0.5);
        -webkit-transform-origin: 0 0;
      }
      @media screen and (-webkit-min-device-pixel-ratio:0) {
        #scaled-frame {
          zoom: 1;
        }
      }
</style>

<?php if(isset($websiteID)){ ?>
    <div id="website-form-container">
        <div class="row mb-4 signerName">
            <h2><?php echo $website["dba"] ?> <span></span></h2>
            <p>Added: <?php echo $website["added"] ?></p>
            
            <!-- <div class="color-code" style="background-color: <?php echo $website['color'] ?>">
                <p>
                    <?php echo isset($website['campaign']) ? $website['campaign'] : "Campaign"?>
                </p>
            </div> -->
        </div>

        <div class="row">
            <div class="col">
                <div id="wrap" class=' border-3 rounded border-primary shadow-lg'>
                    <iframe id="scaled-frame" src="https://<?php echo $website["dba"] ?>"></iframe>
                </div>
            </div>

            <div class="col">
                <h3 class="mb-3">Details</h3>

                <input type="text" class="form-control mb-2" value="<?php echo $website["dba"] ?>">

                <input type="text" class="form-control mb-2" value="<?php echo formatPhone($website["phone"]) ?>">

                <select name="niche" class="form-select mb-2" required>
                    <option value>Select Niche</option>
                    <?php foreach($nicheTBL as $n) { ?>
                        <option 
                            value="<?php echo $n["id"] ?>" 
                            <?php echo ($website["niche"] == $n["id"] ? "selected" : "") ?>
                            >
                                <?php echo $n["title"] ?>
                        </option>
                    <?php } ?>
                </select>

                <select name="corp" class="form-select mb-2" required>
                    <option value>Select Corp</option>
                    <?php foreach($corpsTBL as $crp) { ?>
                        <option 
                            value="<?php echo $crp["id"] ?>"
                            <?php echo ($website["corp"] == $crp["id"] ? "selected" : "") ?>
                            >
                            <?php echo $crp["title"] ?>
                        </option>
                    <?php } ?>
                </select>

                <select name="signer" class="form-select mb-2" required>
                    <option value>Select Signer</option>
                    <?php foreach($signersTBL as $s) { ?>
                        <option 
                            value="<?php echo $s["id"] ?>" 
                            <?php echo ($signerID == $s["id"] ? "selected" : "") ?>
                        >
                            <?php echo $s["name"] ?>
                        </option>
                    <?php } ?>
                </select>

                <select name="bank" class="form-select mb-2">
                    <option value>Select Bank</option>
                    <?php foreach($bankWebsiteTBL as $bw) { ?>
                        <option 
                            value="<?php echo $bw["id"] ?>"
                            <?php echo ($website["bank_website"] == $bw["id"] ? "selected" : "") ?>
                        >
                            <?php echo $bw["title"] ?>
                        </option>
                    <?php } ?>
                </select>

                <!-- <select name="campaign" class="form-select mb-2">
                    <option value>Select Campaign</option>
                    <?php foreach($campaignsTBL as $c) { ?>
                        <option 
                            data-color="<?php echo $c["color"] ?>" 
                            value="<?php echo $c["id"] ?>"
                            <?php echo ($campaignID == $c["id"] ? "selected" : "") ?>
                            >
                                <?php echo $c["title"] ?>
                        </option>
                    <?php } ?>
                </select> -->

                <select name="hostinger_account" class="form-select mb-2" required>
                    <option value>Select Hostinger Account</option>
                    <?php foreach($hostingerTBL as $htg) { ?>
                        <option 
                            value="<?php echo $htg["id"] ?>"
                            <?php echo ($website["hostinger_account"] == $htg["id"] ? "selected" : "") ?>
                            >
                                <?php echo $htg["account"] ?>
                        </option>
                    <?php } ?>
                </select>
            
                <div class="d-flex justify-content-end mt-5">
                    <!-- <button class="btn btn-secondary me-2">Cancel</button> -->
                    <button class="btn btn-primary me-2" disabled>Save Changes</button>

                    <?php if(isset($query->from) && $query->from == "signer") { ?>
                        <a class="btn btn-secondary w-auto me-2" href="signer.php?id=<?php echo $signerID ?>">Cancel</a>
                        <?php } elseif(isset($query->from) && $query->from == "corp") { ?>
                        <a class="btn btn-secondary w-auto me-2" href="corp.php?id=<?php echo $corpID ?>">Cancel</a>
                    <?php } else { ?>
                        <a class="btn btn-secondary w-auto me-2" href="website.php">Cancel</a>
                    <?php } ?>
                    <!-- <a class="bi bi-trash-fill text-secondary m-0 me-2" style="font-size: 1.4rem" href='website.php?id=<?php echo $ws['id'] ?>'></a> -->
                    <button class="btn btn-secondary" disabled>
                        <a class="bi bi-trash-fill text-white m-0" style="font-size: 1.3rem" href='website.php?id=<?php echo $ws['id'] ?>'></a>
                    </button>
                    <!-- <button class="btn btn-secondary">Delete</button> -->
                </div>
                <!-- <div class="mb-4 actions d-flex justify-content-end mt-5">
                    <a class="btn btn-secondary w-auto me-2" href="webiste.php">Cancel</a>
                    <button class="btn btn-primary w-auto btn-add" onclick="addNewWebsite()">Add new website</button>
                </div> -->
            </div>
        </div>
    </div>
<?php } elseif (isset($query->action) && isset($query->action) == "add") { ?>
    <div class="row mb-4">
        <h2>Website Details</h2>
        <!-- <div class="color-code">
            <p class="text-secondary"></p>
        </div> -->
    </div>

    <form class="row mb-4" id="websiteDetails">
        <div class="col-3 mb-3">
            <select name="signer" class="form-select" required>
                <option value>Select Signer</option>
                <?php foreach($signersTBL as $s) { ?>
                    <option 
                        value="<?php echo $s["id"] ?>" 
                        <?php echo (isset($signerID) && $signerID == $s["id"]) ? "selected" : "" ?>
                    >
                        <?php echo $s["name"] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-3 mb-3">
            <select name="corp" class="form-select" required>
                <option value>Select Corp</option>
                <?php foreach($corpsTBL as $crp) { ?>
                    <option 
                        value="<?php echo $crp["id"] ?>"
                        <?php echo (isset($corpID) && $corpID == $crp["id"]) ? "selected" : "" ?>
                        >
                        <?php echo $crp["title"] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- <div class="col-3 mb-3">
            <select name="campaign" class="form-select">
                <option value>Select Campaign</option>
                <?php foreach($campaignsTBL as $c) { ?>
                    <option data-color="<?php echo $c["color"] ?>" value="<?php echo $c["id"] ?>"><?php echo $c["title"] ?></option>
                <?php } ?>
            </select>
        </div> -->

        <div class="col-3 mb-3">
            <select name="bank" class="form-select" required>
                <option value>Select Bank</option>
                <?php foreach($bankWebsiteTBL as $bw) { ?>
                    <option value="<?php echo $bw["id"] ?>"><?php echo $bw["title"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-3 mb-3">
            <select name="hostinger_account" class="form-select" required>
                <option value>Select Hostinger Account</option>
                <?php foreach($hostingerTBL as $htg) { ?>
                    <option value="<?php echo $htg["id"] ?>"><?php echo $htg["account"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-3 mb-3">
            <input name="dba" class="form-control" type='text' placeholder="DBA" required>
        </div>

        <div class="col-3 mb-3">
            <input name="phone"  class="form-control" type='text' placeholder="Phone">
        </div>

        <div class="col-3 mb-3">
            <select name="niche" class="form-select" required>
                <option value>Select Niche</option>
                <?php foreach($nicheTBL as $n) { ?>
                    <option value="<?php echo $n["id"] ?>"><?php echo $n["title"] ?></option>
                <?php } ?>
            </select>
        </div>
    </form>

    <div class="row mb-4 actions d-flex justify-content-end">
        <?php if(isset($query->signer)) { ?>
            <a class="btn btn-secondary w-auto me-2" href="signer.php?id=<?php echo $signerID ?>">Cancel</a>
        <?php } elseif (isset($query->corp)) { ?>
            <a class="btn btn-secondary w-auto me-2" href="corp.php?id=<?php echo $corpID ?>">Cancel</a>
        <?php } else { ?>
            <a class="btn btn-secondary w-auto me-2" href="website.php">Cancel</a>
        <?php } ?>
        <button class="btn btn-primary w-auto btn-add" onclick="addNewWebsite()">Add new website</button>
    </div>

    <div class="row mb-4 d-flex justify-content-end">
        <p class="text-end status-info d-none">
            <b>New Website Added!</b>
        </p>
        <div class="spinner-border spinner-border-sm text-primary p-0 d-none status-loading" role="status"></div>
    </div>
<?php } ?>