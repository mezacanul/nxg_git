<?php
    $signerTBL = getQuery("SELECT * FROM signer ORDER BY name");
    $priorityTBL = getQuery("SELECT * FROM priority ORDER BY title");
    $campaignTBL = getQuery("SELECT * FROM campaign ORDER BY title");
    $bankTBL = getQuery("SELECT * FROM bank ORDER BY title");

    // if(isset($corpId)){
    if(isset($query->id)){
        $corp = getQuery("SELECT corp.*, signer.name as signerName, priority.title as priorityTitle, campaign.title as campaignTitle, bank.title as bank, campaign.color as campaignColor FROM corp LEFT JOIN priority ON corp.priority = priority.id LEFT JOIN campaign ON corp.campaign = campaign.id LEFT JOIN signer ON corp.signer = signer.id LEFT JOIN bank ON corp.bank = bank.id WHERE corp.id = '{$query->id}'")[0];
        // $corp = $corp[0];
    }
    // foreach ($corp as $k => $v) {
    //     echo("<b>".$k."</b>: ".$v." - ");
    //     // print_r("<br>");
    // }
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
</style>

<?php if(isset($corp)){ ?>
    <div class="row mb-4" id="corpTitle">
        <h2><?php echo $corp["title"] ?></h2>
        <div class="color-code" style="background-color: <?php echo $corp['campaignColor'] ?>">
            <p>
                <?php echo $corp['campaignTitle'] ?>
            </p>
        </div>
    </div>
    
    <div class="row mb-4">
        <input type='hidden' value='<?php echo $corp["id"] ?>'>
        
        <div class="col-3 mb-3">
            <label class="form-label fw-bold">Corp</label>
            <input class="form-control" type='text' value='<?php echo $corp["title"] ?>'>
        </div>

        <div class="col-3 mb-3">
            <label class="form-label fw-bold">Address</label>
            <input class="form-control" type='text' value='<?php echo $corp["corpaddress"] ?>'>
        </div>

        <div class="col-3 mb-3">
            <label class="form-label fw-bold">Signer</label>
            <select name="signer" id="signer" class="form-select">
                <option value>Select Signer</option>
                <?php foreach ($signerTBL as $sgnr) { ?>
                    <option 
                        value="<?php echo $sgnr["id"] ?>" 
                        <?php echo $sgnr["id"] == $corp["signer"] ? "selected" : "" ?>
                        >
                        <?php echo $sgnr["name"] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-3 mb-3">
            <label class="form-label fw-bold">Priority</label>
            <select name="priority" id="priority" class="form-select">
                <option value>Select Priority</option>
                <?php foreach ($priorityTBL as $prty) { ?>
                    <option 
                        value="<?php echo $prty["id"] ?>" 
                        <?php echo $prty["id"] == $corp["priority"] ? "selected" : "" ?>
                        >
                        <?php echo $prty["title"] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-3 mb-3">
            <label class="form-label fw-bold">Notes</label>
            <input 
                class="form-control" 
                type='text' 
                value=''
                <?php echo $_SESSION["role"] == "dev" ? "disabled" : "" ?>
                >
        </div>

        <?php if($_SESSION["role"] == "app"){ ?>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Campaign</label>
                <select name="campaign" id="campaign" class="form-select">
                    <option value>Select Campaign</option>
                    <?php foreach ($campaignTBL as $cpgn) { ?>
                        <option 
                            value="<?php echo $cpgn["id"] ?>" 
                            <?php echo $cpgn["id"] == $corp["campaign"] ? "selected" : "" ?>
                            >
                            <?php echo $cpgn["title"] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Bank</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Started</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">EIN</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">DL</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Issue / Exp.</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Routing</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Account</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Login Platform</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Email</label>
                <input class="form-control" type='text' value=''>
            </div>

            <div class="col-3 mb-3">
                <label class="form-label fw-bold">Password</label>
                <input class="form-control" type='text' value=''>
            </div>
        <?php } ?>

        <div class="col mb-3 d-flex align-items-end">
            <button class="btn btn-primary me-2" disabled>Save Changes</button>
            <button class="btn btn-secondary">Delete</button>
        </div>
    </div>

<?php } else { ?>
    <div class="row mb-4 signerName">
        <h2>New Corp Details</h2>
        <div class="color-code">
            <p class="text-secondary">Select a Campaign</p>
        </div>
    </div>

    <form class="row mb-4" id="corpDetails">
        <div class="col-3 mb-3">
            <select name="signer" class="form-select">
                <option value selected>Select Signer</option>
                <?php foreach($signerTBL as $s) { ?>
                    <option value="<?php echo $s["id"] ?>" <?php echo (isset($query->signer) && ($query->signer == $s["id"])) ? "selected" : "" ?>><?php echo $s["name"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-3 mb-3">
            <select name="priority" class="form-select">
                <option value selected>Select Priority</option>
                <?php foreach($priorityTBL as $p) { ?>
                    <option value="<?php echo $p["id"] ?>"><?php echo $p["title"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-3 mb-3">
            <input name="corpName" class="form-control" type='text' placeholder="Corp Name" required>
        </div>

        <div class="col-3 mb-3">
            <input name="corpAddress" class="form-control" type='text' placeholder="Address" required>
        </div>

        <?php if($_SESSION["role"] == "app") { ?>
            <div class="col-3 mb-3">
                <select name="campaign" class="form-select">
                    <option value selected>Select Campaign</option>
                    <?php foreach($campaignTBL as $c) { ?>
                        <option data-color="<?php echo $c["color"] ?>" value="<?php echo $c["id"] ?>"><?php echo $c["title"] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-3 mb-3">
                <select name="bank" class="form-select">
                    <option value selected>Select Bank</option>
                    <?php foreach($bankTBL as $b) { ?>
                        <option value="<?php echo $b["id"] ?>"><?php echo $b["title"] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-3 mb-3">
                <input name="started" class="form-control" type='text' placeholder="Started">
            </div>
    
            <div class="col-3 mb-3">
                <input name="notes" class="form-control" type='text' placeholder="Notes">
            </div>
    
            <div class="col-3 mb-3">
                <input name="ein" class="form-control" type='text' placeholder="EIN">
            </div>
    
            <div class="col-3 mb-3">
                <input name="dl" class="form-control" type='text' placeholder="DL">
            </div>
    
            <div class="col-3 mb-3">
                <input name="issueexp" class="form-control" type='text' placeholder="Issue / Exp">
            </div>
    
            <div class="col-3 mb-3">
                <input name="routing" class="form-control" type='text' placeholder="Routing">
            </div>
    
            <div class="col-3 mb-3">
                <input name="account" class="form-control" type='text' placeholder="Account">
            </div>
    
            <div class="col-3 mb-3">
                <input name="loginplatform" class="form-control" type='text' placeholder="Login Platform">
            </div>
    
            <div class="col-3 mb-3">
                <input name="email" class="form-control" type='text' placeholder="Email">
            </div>
    
            <div class="col-3 mb-3">
                <input name="password" class="form-control" type='password' placeholder="Password">
            </div>
        <?php } ?>
    </form>

    <div class="row mb-4 actions d-flex justify-content-end">
        <?php if (isset($query->signer)) { ?>
            <a class="btn btn-secondary w-auto me-2" href="signer.php?id=<?php echo $query->signer ?>">Cancel</a>
        <?php } else { ?>
            <a class="btn btn-secondary w-auto me-2" href="corp.php">Cancel</a>
        <?php } ?>
        <button class="btn btn-primary w-auto btn-add" onclick="addNewCorp()">Add new corp</button>
    </div>

    <div class="row mb-4 d-flex justify-content-end">
        <p class="text-end status-info d-none">
            <b>New Corp Added!</b>
        </p>
        <div class="spinner-border spinner-border-sm text-primary p-0 d-none status-loading" role="status"></div>
    </div>
<?php } ?>
