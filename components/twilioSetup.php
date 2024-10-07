<?php
    $nc_accounts = getQuery("SELECT * FROM namecheap_accounts");
    $niches = getQuery("SELECT * FROM niche WHERE status = 1");
    // $domains = getQuery("SELECT * FROM domain WHERE status = 1");
    // $nc = $signer[0];
    // print_r($niches[0]);
?>

<section class="mb-4" id="template-customization">
    <div class="row" id="corpTitle" type="button" data-bs-toggle="collapse" data-bs-target="#website-params" aria-expanded="false" aria-controls="website-params">
        <h2 class="ps-0 mt-3 mb-3" style="color: #F22F46">Twilio
            <!-- <i class="bi bi-arrow-down-square-fill"></i> -->
        </h2>
    </div>
    
    <form action="#" class="row mb-4 mt-4" id="domain_search">
        
        <div class="col-12 mb-4">
            
            <div class="row mb-4">
                
                <div class="col-3 d-flex align-items-end">
                    <input type="text" class="form-control" placeholder="Phone Number" id="phone" name="phone">
                </div>

                <div class="col-5 d-flex align-items-end">
                    <button class="btn btn-primary me-3" onclick="get_suggested_phone()" type="button" id="get-phone">Get Suggested Phone Number</button>
                    <div class="spinner-border spinner-border-sm text-primary d-none phone-search" style="margin-bottom: 0.6rem" role="status"></div>
                    <b class="text-success mb-2 phone-available-notice d-none">Toll-Free Number is available!</b>
                    <!-- <b class="text-secondary mb-2 domain-unavailable-notice d-none">Domain is not available...</b> -->
                </div>

            </div>

            <div class="row">

                <div class="col d-flex align-items-end">
                    <button class="btn btn-primary me-3" onclick="" type="button" disabled>Register Phone</button>
                    <!-- <button class="btn btn-primary me-3" onclick="" type="button" disabled>Update Friendly Name</button>
                    <button class="btn btn-primary me-3" onclick="" type="button" disabled>Update Voice Redirect</button> -->
                </div>

                <!-- <div class="col-3 d-flex align-items-end">
                    <input type="text" class="form-control" placeholder="Domain" id="domain-search" name="url">
                </div> -->

                <!-- <div class="col-4 d-flex align-items-end">
                    <button class="btn btn-primary me-3" onclick="get_suggested_phone()" type="button">Search</button>
                    <div class="spinner-border spinner-border-sm text-primary d-none loading-search" style="margin-bottom: 0.6rem" role="status"></div>
                    <b class="text-success mb-2 domain-available-notice d-none">Domain is available!</b>
                    <b class="text-secondary mb-2 domain-unavailable-notice d-none">Domain is not available...</b>
                </div> -->
                
            </div>

        </div>

        <div class="col-12 mb-4 d-none">
            <div class="row d-flex justify-content-start">
                <div class="col-2">
                    <p><b>Options</b></p>
                    <button class="btn btn-primary">Register Domain</button>
                    <!-- <button class="btn btn-primary me-1">Update DNS</button>
                    <button class="btn btn-primary me-1">Update Registrar</button> -->
                </div>

                <div class="col-4 d-flex align-items-end">
                    <!-- <select name="corp" id="corp" class="form-select">
                        <option value="test">My Corp Inc.</option>
                        <option value="test">test</option>
                    </select> -->
                    <!-- <button class="btn btn-primary me-1">Update DNS</button>
                    <button class="btn btn-primary me-1">Update Registrar</button> -->
                </div>

                <!-- <div class="col-3 d-flex align-items-end">
                    <input type="text" class="form-control" placeholder="Domain" id="domain-search" name="mainTgln">
                </div>

                <div class="col-4 d-flex align-items-end">
                    <div class="btn btn-primary me-4">Search</div>
                    <b class="text-success mb-2">Domain is available!</b>
                </div> -->
            </div>
        </div>

        <!-- <div class='p-0 mt-4'>
            <button class="btn btn-primary mb-3 me-1" id="shuffle-all-btn" onclick="" type="button">Register Domain</button>
            <button class="btn btn-primary mb-3 me-1" id="update-created-btn" onclick="" type="button">Update DNS</button>
        </div> -->
    </form>
</section>

<script src="../assets/js/twilio_helper.js"></script>