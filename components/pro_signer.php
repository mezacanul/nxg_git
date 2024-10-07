<?php 
    $signerTBL = getQuery("SELECT * FROM signer ORDER BY name");
    $bank_websiteTBL = getQuery("SELECT * FROM bank_website ORDER BY added DESC");
    $nicheTBL = getQuery("SELECT * FROM niche WHERE status = 1");
    $hostingerTBL = getQuery("SELECT * FROM hostinger ORDER BY added DESC");
    // print_r($hostingerTBL);
    
    if(isset($website["corpID"])){
        $corpID = $website["corpID"];
    
        $corpTBL = getQuery("SELECT * FROM corp WHERE id = '$corpID' ORDER BY title");
        $websiteTBL = getQuery("SELECT * FROM website WHERE corp = '$corpID' ORDER BY dba");
        $currentSigner = getQuery("SELECT signer.* FROM corp LEFT JOIN signer ON corp.signer = signer.id WHERE corp.id = '$corpID'")[0];
    } elseif (isset($query->signer)) {
        $signerID = $query->signer;
        $signerDATA = getQuery("SELECT * FROM signer WHERE id = '$signerID'")[0];
        // print_r($signerID);
        // print_r($bank_websiteTBL);
        $corpsTBL = getQuery("SELECT * FROM corp WHERE signer = '$signerID' ORDER BY title");
    } elseif (isset($query->corp)) {
        $corpID = $query->corp;
        $corpDATA = getQuery("SELECT * FROM corp WHERE id = '$corpID'")[0];
        $signerID = $corpDATA["signer"];
        $signerDATA = getQuery("SELECT * FROM signer WHERE id = '$signerID'")[0];
    }
    // print_r($signerDATA["namecheap_account"]);

    // $namecheapTBL = getQuery("SELECT * FROM namecheap_accounts ORDER BY user");
    // $priorities = getQuery("SELECT * FROM priority");
    // print_r($query->action);
    // print_r($currentSigner);
?>

<div class="col mb-5">
    <div class="row mb-4">
        <div class="col">
            <h1 class="fw-bold">Pro Mode</h1>
            <b><span class="text-namecheap">Namecheap</span> + <span class="text-twilio">Twilio</span></b>
            <!-- <a href="websites.php?action=add" class="btn btn-primary">Add new priority</a> -->
        </div>
    </div>
    
    <div class="row w-50 mb-3 d-none">
        <div class="col d-flex justify-content-between align-items-center">
            <h3>Website Setup</h3>
            <!-- <a href="websites.php?action=add" class="btn btn-primary">Add new priority</a> -->
        </div>
    </div>
    
    <form class="row mb-4" id="signer_details">
        <?php if(isset($query->action) && $query->action == "new") { ?>
            <input type="hidden" name="action" value="new">
        <?php } ?>
        
        <!-- <div class="col-3">
            <p><b>Corp</b></p>
            <input name="corp" class="form-control" type='text' placeholder="Corp" required readonly value="<?php echo $website["corp"] ?>">
        </div> -->
        
        <!-- <div class="col-3">
            <p><b>Signer</b></p>
            <input name="signer" class="form-control" type='text' placeholder="Signer" required readonly value="<?php echo $website["signer"] ?>">
        </div> -->
        <div class="col-3">
            <p><b>Signer</b></p>
            <?php if(isset($query->signer) || isset($query->corp)) { ?>
                <input type="hidden" name="signer" required class="form-control" readonly value="<?php echo $signerDATA["id"] ?>">
                <input type="text" name="signerTitle" required class="form-control" readonly value="<?php echo $signerDATA["name"] ?>">
            <?php } else { ?>
                <select name="signer" class="form-select" required onchange="validateNamecheapAccount()">
                    <option value selected>Select Signer</option>
                    <?php foreach($signerTBL as $s) { ?>
                        <option 
                            value="<?php echo $s["id"] ?>" 
                            <?php echo ((isset($website["signerID"]) && (($website["signerID"] == $s["id"])) || (isset($signerID) && ($signerID == $s["id"])))) ? "selected" : "" ?>
                            >
                            <?php echo $s["name"] ?>
                        </option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>

        <div class="col-3">
            <p><b>Corp</b></p>
            <?php if(isset($query->corp)) { ?>
                <input type="hidden" name="corp" required class="form-control" readonly value="<?php echo $corpDATA["id"] ?>">
                <input type="text" name="corpTitle" required class="form-control" readonly value="<?php echo $corpDATA["title"] ?>">
            <?php } else { ?>
                <select name="corp" class="form-select" required>
                    <option value selected>Select Corp</option>
                    <?php if(isset($corpTBL)){ ?>
                        <?php foreach($corpTBL as $crp) { ?>
                            <option value="<?php echo $crp["id"] ?>" <?php echo (isset($website["corpID"]) && ($website["corpID"] == $crp["id"])) ? "selected" : "" ?>><?php echo $crp["title"] ?></option>
                        <?php } ?>
                    <?php } elseif (isset($corpsTBL)) { ?>
                        <?php foreach($corpsTBL as $crp) { ?>
                            <option value="<?php echo $crp["id"] ?>" <?php echo (isset($website["corpID"]) && ($website["corpID"] == $crp["id"])) ? "selected" : "" ?>><?php echo $crp["title"] ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>   

        <div class="col-3">
            <p><b>DBA</b></p>
            <?php if(isset($website)){ ?>
                <select name="dba" class="form-select border border-primary border-3">
                    <!-- <option value>Select DBA</option> -->
                    <?php foreach($websiteTBL as $wbs) { ?>
                        <option value="<?php echo $wbs["id"] ?>" data-dba="<?php echo $wbs["dba"] ?>" <?php echo (isset($website["id"]) && ($website["id"] == $wbs["id"])) ? "selected" : "" ?>><?php echo $wbs["dba"] ?></option>
                    <?php } ?>
                </select>
            <?php } else { ?>
                <input type="text" class="form-control me-2 border border-primary border-2" placeholder="Domain" name="dba">
            <?php } ?>
        </div>

        <div class="w-auto nc_check_warnings d-flex align-items-end mb-2">
            <div class="spinner-border spinner-border-sm text-primary p-0 d-none status-loading loading-search mb-1" role="status"></div>
            <b class="text-success w-auto p-0 d-none status-success">Domain is available!</b>
            <b class="text-secondary w-auto p-0 d-none status-unavailable">Domain is not available...</b>
        </div>
    </form>
    
    <form class="row mb-2 ms-1 d-flex align-items-center" id="new_domain_actions">
        <?php if(!isset($website)){ ?>
            <select class="form-select me-2 w-auto" name="niche" id="select-niche" required>
                <option value>Select a niche</option>
                <?php foreach ($nicheTBL as $nch) { ?>
                    <option value="<?php echo $nch["id"] ?>"><?php echo $nch["title"] ?></option>
                <?php } ?>
            </select>

            <select class="form-select me-2 w-auto" name="bank_website" id="select-bank-website" required>
                <option value>Select a bank</option>
                <?php foreach ($bank_websiteTBL as $bnws) { ?>
                    <option value="<?php echo $bnws["id"] ?>"><?php echo $bnws["title"] ?></option>
                <?php } ?>
            </select>

            <select class="form-select me-2 w-auto" name="hostinger" id="select-hostinger" required>
                <option value>Select a hostinger account</option>
                <?php foreach ($hostingerTBL as $hstg) { ?>
                    <option value="<?php echo $hstg["id"] ?>"><?php echo $hstg["account"] ?></option>
                <?php } ?>
            </select>

            <button class="btn btn-primary w-auto me-2 nc_btn-check" onclick="get_suggested_domain()" type="button">Get Suggested Domain</button>
        <?php } ?>
        <button 
            class="btn btn-primary w-auto me-2 nc_btn-check" 
            onclick="namecheap_search_domain()" 
            type="button"
            <?php echo !isset($website) ? "disabled" : "" ?>
            >
            Check Domain Availability
        </button>
    </form>
    <p class="ms-1 mt-3 no-namecheap-account-info d-none">* Setup a <b class="text-namecheap">Namecheap</b> account for this signer to enable <b>Pro Mode</b></p>
</div>