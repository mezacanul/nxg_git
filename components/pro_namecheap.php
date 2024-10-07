<?php 
    // $corpID = $website["corpID"];

    // $corpTBL = getQuery("SELECT * FROM corp WHERE id = '$corpID' ORDER BY title");
    // $websiteTBL = getQuery("SELECT * FROM website WHERE corp = '$corpID' ORDER BY dba");

    $namecheapTBL = getQuery("SELECT * FROM namecheap_accounts ORDER BY user");
    // // $priorities = getQuery("SELECT * FROM priority");
    // print_r($website["signerID"]);
    // print_r($currentSigner);
?>

<div class="col mb-5 collapse" id="namecheapSetup">
    <div class="row w-50 mb-3">
        <div class="col d-flex justify-content-between align-items-center">
            <h3 class="fw-bold text-namecheap">Namecheap Setup</h3>
            <!-- <a href="websites.php?action=add" class="btn btn-primary">Add new priority</a> -->
        </div>
    </div>

    <form class="row mb-3" id="namecheap_register" action="#">
        <p><b>Account</b></p>
        
        <div class="col-12 mb-3 d-flex align-items-center">
            <input type="hidden" name="url" value="<?php echo $website["dba"] ?>">
            <select name="nc_account" class="form-select w-auto me-2" disabled>
                <option value>Select a Namecheap Account</option>
                <?php foreach($namecheapTBL as $ncp) { ?>
                    <option 
                        value="<?php echo $ncp["id"] ?>" 
                        <?php // echo ((isset($website["signerID"]) && ($website["signerID"] == $ncp["signer"])) || (isset($signerID) && ($signerID == $ncp["signer"]))) ? "selected" : "" ?>
                        <?php echo isset($signerDATA["namecheap_account"]) && $signerDATA["namecheap_account"] == $ncp["id"] ? "selected" : "" ?>
                        >
                        <?php echo $ncp["user"] ?>
                    </option>
                <?php } ?>
            </select>

            <button class="btn btn-primary w-auto btn-buy me-3" type="button" onclick="namecheap_register()">Register Domain</button>
            <!-- <button class="btn btn-primary w-auto btn-add me-3" onclick="search_domain()" type="button">Check Domain Availability</button> -->
            <div class="nc_register_warnings">
                <div class="spinner-border spinner-border-sm text-primary p-0 status-loading d-none loading-search" role="status"></div>
                <b class="text-success w-auto p-0 d-none status-success">Domain registered and Database updated!</b>
            </div>
        </div>
    </form>

    <div class="row mb-3">
        <b>* Phone number will be set to newly acquired <span class="text-twilio fw-bold">Twilio</span> number.</b>
        <!-- <b>* Admin, Tech, Billing and Auxiliar contacts on <span class="text-primary fw-bold" data-text-target="dba"><?php echo $website["dba"] ?></span> will be set to <span class="text-primary fw-bold" data-text-target="corp"><?php echo $website["corp"] ?></span> contact details.</b> -->
        <b>* Admin, Tech, Billing and Auxiliar contacts will be set to <span class="text-primary fw-bold" data-text-target="corp"><?php echo $website["corp"] ?></span> contact details.</b>
        <b>* <span class="text-primary">Nameservers</span> will be updated to <span class="text-hostinger">Hostinger</span> DNS.</b>
        <b>* <span class="text-primary">Free Domain Privacy</span> will be bought but it will be <span class="text-primary">turned off</span> immediately.</b>
    </div>
</div>