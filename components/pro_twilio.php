<?php 
    // $twilioUSER = getQuery("SELECT * FROM namecheap_accounts ORDER BY user");
    // print_r($twilioUSER);
?>

<div class="col-12 mb-5 collapse" id="twilioSetup">
    <div class="row w-50 mb-3">
        <div class="col d-flex justify-content-between align-items-center">
            <h3 class="fw-bold text-twilio">Twilio Setup</h3>
        </div>
    </div>

    <form class="row mb-4" id="twilio">
        <!-- <p><b>Account</b></p> -->
        <div class="col d-flex align-items-center">
            <!-- <select name="DBA" class="form-select w-auto me-2">
                <?php foreach($namecheapTBL as $ncp) { ?>
                    <option value="<?php echo $ncp["id"] ?>" <?php echo (isset($website["signerID"]) && ($website["signerID"] == $ncp["signer"])) ? "selected" : "" ?>><?php echo $ncp["user"] ?></option>
                <?php } ?>
            </select> -->

            <input type="text" class="form-control w-auto me-2" placeholder="Phone Number" name="phone">
            
            <button class="btn btn-primary w-auto btn-add me-3" type="button" onclick="twilio_get_new_phone()">Get New Phone Number</button>
            
            
            <div class="twilio_available_warning">
                <div class="spinner-border spinner-border-sm text-primary p-0 status-loading d-none" role="status"></div>
                <b class="text-success w-auto p-0 d-none phone-available-notice">Toll-Free Phone Number is available!</b>
            </div>
            <!-- <div class="spinner-border spinner-border-sm text-primary p-0 status-loading" role="status"></div>
            <b class="text-success w-auto p-0">Toll-Free Phone Number is available!</b> -->
        </div>
    </form>

    <div class="row mb-4 d-flex align-items-center">
        <button class="btn btn-primary me-2 ms-2 w-auto" type="button" onclick="twilio_register()" id="btn-twilio-register" disabled>Register</button>
        <div class="twilio_register_warning w-auto">
            <div class="spinner-border spinner-border-sm text-primary p-0 status-loading d-none" role="status"></div>
            <b class="text-success w-auto p-0 d-none status-success">Number registered on Twilio and Database updated!</b>
        </div>
    </div>

    <div class="row mb-3 collapse" id="twilio_info">
        <b>* Friendly name will be set to <span class="text-primary" data-text-target="dba">"<?php echo isset($website["dba"]) ? $website["dba"] : "" ?>"</span>.</b>
        <b>* Redirection calls will be set to <span class="text-primary">+1 925-633-4352</span>.</b>
    </div>
</div>