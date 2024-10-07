<?php
    if(isset($namecheapAcctID)){
        $namecheapAcct = getQuery("SELECT * FROM namecheap_accounts WHERE id = '{$namecheapAcctID}'")[0];
        // print_r($namecheapAcct);
    }
    $signersTBL = getQuery("SELECT * FROM signer ORDER BY added DESC");
    // print_r($signersTBL[0]);
?>

<div class="row mb-4 signerName">
    <h2>Namecheap Account Details</h2>
    <div class="color-code">
        <p class="text-secondary"></p>
    </div>
</div>

<?php if(isset($namecheapAcctID)){ ?>
    <form class="row mb-2" id="accountDetails">
        <div class="col-3 mb-3">
            <p class="mb-2"><b>Username</b></p>
            <input class="form-control" type='text' placeholder="Account" name="account" required value="<?php echo $namecheapAcct["user"] ?>">
        </div>

        <div class="col-3 mb-3">
            <p class="mb-2"><b>Password</b></p>
            <input class="form-control" type='text' placeholder="Password" name="password" required  value="<?php echo $namecheapAcct["password"] ?>">
        </div>

        <div class="col-3 mb-3">
            <p class="mb-2"><b>API Key</b></p>
            <input class="form-control" type='text' placeholder="API Key" name="api_key" required  value="<?php echo $namecheapAcct["api_key"] ?>">
        </div>

        <div class="col-3 mb-3">
            <p class="mb-2"><b>API Registered IP</b></p>
            <input class="form-control" type='text' placeholder="API Registered IP" name="api_ip" required  value="<?php echo $namecheapAcct["api_ip"] ?>">
        </div>
    </form>

    <div class="row mb-4 actions d-flex justify-content-end">
        <a class="btn btn-secondary w-auto me-2" href="namecheap_acct.php">Cancel</a>
        <button class="btn btn-primary w-auto" type="button" onclick="" disabled>Save Changes</button>
    </div>
<?php } elseif(isset($query->action) && $query->action == "add"){ ?>
    <form class="row mb-4" id="accountDetails">
        <div class="col-3 mb-3">
            <input class="form-control" type='text' placeholder="Account" name="account" required>
        </div>

        <div class="col-3 mb-3">
            <input class="form-control" type='text' placeholder="Password" name="password" required>
        </div>

        <div class="col-3 mb-3">
            <input class="form-control" type='text' placeholder="API Key" name="api_key" required>
        </div>

        

        <div class="col-3 mb-3">
            <select name="signer" id="signer" class="form-select" required>
                <option value>Select a signer</option>
                <?php foreach ($signersTBL as $sgnr) { ?>
                    <option value="<?php echo $sgnr["id"] ?>"><?php echo $sgnr["name"] ?></option>
                <?php } ?>
            </select>
        </div>
    </form>

    <div class="row mb-4">
        <div class="col-3 mb-3 ms-2">
            <p>IP: 162.241.62.202</p>
        </div>
    </div>

    <div class="row mb-4 actions d-flex justify-content-end">
        <a class="btn btn-secondary w-auto me-2" href="namecheap_acct.php">Cancel</a>
        <button class="btn btn-primary w-auto btn-add" type="button" onclick="addNamecheapAcct()">Add new account</button>
    </div>

    <div class="row mb-4">
        <p class="text-success text-end status-info d-none">New Account Added!</p>
    </div>
<?php } ?>

<script src="../assets/js/namecheap_helper.js"></script>