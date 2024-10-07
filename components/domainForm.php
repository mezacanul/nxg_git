<?php
    $niches = getQuery("SELECT * FROM niche WHERE status = 1");
    // print_r($niches[0]);
    if(isset($domainId)){
        $domain = getQuery("SELECT * FROM domain WHERE id = '{$domainId}'")[0];
        // print_r($domain);
    }
?>

<?php if(isset($domainId)) { ?>
    <div class="row mb-4 signerName">
        <h2><?php echo $signer["name"] ?></h2>
    </div>

    <div class="row mb-4 signerDetails">
        <?php foreach($signer as $k => $v) { 
            if($k == "id"){ ?>
                <input type='hidden' value='<?php echo $v ?>'>
            <?php } else { ?> 
                <div class="col-3 mb-3">
                    <label for="exampleFormControlInput1" class="form-label fw-bold"><?php echo ucfirst($k) ?></label>
                    <input type="text" class="form-control" type='text' value='<?php echo $v ?>'>
                </div>    
            <?php } ?> 
        <?php } ?>
    </div>
<?php } elseif (isset($query->action) & $query->action == "add") { ?>
    <div class="row mb-4 signerName">
        <h2>Add new domain(s)</h2>
    </div>

    <div class="row mb-4 signerDetails">
        <div class="col-4 mb-3">
            <select name="niche" id="niche" class="form-select mb-3">
                <?php foreach ($niches as $nch) { ?>
                    <option value="<?php echo $nch["id"] ?>"><?php echo $nch["title"] ?></option>
                <?php } ?>
            </select>

            <textarea class="form-control" rows="6" name="domain" id="domain" oninput="enableAddBtn()" required></textarea>
            <p class="mt-3 mb-0">* You can add multiple domains</p>
            <p class="mt-3 mb-0">* Separate each domain with a line jump</p>
            <p class="mt-3 mb-0">* Domains should have uppercase letters</p>

            <div class="row mt-5 actions d-flex justify-content-start ms-1">
                <a class="btn btn-secondary w-auto me-2" href="domain.php">Cancel</a>
                <button class="btn btn-primary w-auto" onclick="addNewDomains()" id="add-btn">Add new domain(s)</button>
            </div>
        </div>

        <div class="col-3 mb-3 d-none domains-added">
            <h4 class="mb-3">Domains Added</h4>
            <div class="valid-domains"></div>
        </div>

        <div class="col-4 mb-3 d-none domains-not-added">
            <h4 class="mb-3">Domains Not Added</h4>
            <div class="invalid-domains"></div>
        </div>

        <!-- <div class="col-3 mb-3">
            <input type="text" class="form-control" type='text' placeholder="DOB">
        </div>

        <div class="col-3 mb-3">
            <input type="text" class="form-control" type='text' placeholder="Phone">
        </div> -->
    </div>

    <!-- <div class="row mb-4 actions d-flex justify-content-end">
        <a class="btn btn-secondary w-auto me-2" href="signers.php">Cancel</a>
        <button class="btn btn-primary w-auto" onclick="addNewDomains()" id="add-btn">Add new domain(s)</button>
    </div> -->
<?php } ?>