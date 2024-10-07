<?php //print_r($_SESSION) ?>

<?php if(isset($signer)) { ?>
    <div class="row mb-4 signerName">
        <h2><?php echo $signer["name"] ?></h2>
    </div>

    <form class="row mb-4" id="signerDetails">
        <input type='hidden' name="id" value='<?php echo $signer["id"] ?>'>

        <div class="col-3 mb-3">
            <input type="text" class="form-control" type='text' required placeholder="Name" name="name" value="<?php echo $signer["name"]?>">
        </div>

        <div class="col-3 mb-3 d-flex align-items-center">
            <select class="form-select" name="status">
                <option value>Select Signer Status</option>
                <option value="1" <?php echo $signer["status"] == 1 ? "selected" : "" ?>>Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="col-1 w-auto mb-3 d-flex align-items-center">
            <i class="bi bi-circle-fill text-success"></i>
        </div>

        <div class="col">
            <button class="btn btn-primary" disabled>Save Changes</button>
            <button class="btn btn-secondary">Delete</button>
        </div>

        <?php if($_SESSION["role"] == "app") { ?>
            <div class="col-3 mb-3">
                <input type="text" class="form-control" type='text' required placeholder="Home Address" name="homeaddress">
            </div>
    
            <div class="col-3 mb-3">
                <input type="date" class="form-control" type='text' required placeholder="DOB" name="dob">
            </div>
    
            <div class="col-3 mb-3">
                <input type="text" class="form-control" type='text' required placeholder="Phone" name="phone">
            </div>
        <?php } ?>
    </form>
<?php } elseif (isset($query->action) & $query->action == "add") { ?>
    <div class="row mb-4 signerName">
        <h2>New signer Details</h2>
    </div>

    <form class="row mb-4" id="signerDetails">
        <div class="col-3 mb-3">
            <input type="text" class="form-control" type='text' required placeholder="Name" name="name">
        </div>

        <?php if($_SESSION["role"] == "app") { ?>
            <div class="col-3 mb-3">
                <input type="text" class="form-control" type='text' required placeholder="Home Address" name="homeaddress">
            </div>
    
            <div class="col-3 mb-3">
                <input type="date" class="form-control" type='text' required placeholder="DOB" name="dob">
            </div>
    
            <div class="col-3 mb-3">
                <input type="text" class="form-control" type='text' required placeholder="Phone" name="phone">
            </div>
        <?php } ?>
    </form>

    <div class="row mb-4 actions d-flex justify-content-end">
        <a class="btn btn-secondary w-auto me-2" href="signer.php">Cancel</a>
        <button class="btn btn-primary w-auto btn-add" onclick="addNewSigner()">Add new signer</button>
    </div>

    <div class="row mb-4 d-flex justify-content-end">
        <p class="text-end status-info d-none">
            <b>New Signer Added!</b>
        </p>
        <div class="spinner-border spinner-border-sm text-primary p-0 d-none status-loading" role="status"></div>
    </div>
<?php } ?>