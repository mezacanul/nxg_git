<?php
    $nc_accounts = getQuery("SELECT * FROM namecheap_accounts");
    $niches = getQuery("SELECT * FROM niche WHERE status = 1");
    // $domains = getQuery("SELECT * FROM domain WHERE status = 1");
    // $nc = $signer[0];
    // print_r($niches[0]);
?>

<section class=" mb-4" id="template-customization">
    <div class="row" id="corpTitle" type="button" data-bs-toggle="collapse" data-bs-target="#website-params" aria-expanded="false" aria-controls="website-params">
        <h2 class="ps-0 mt-3 mb-3" style="color: #FF8C44">Namecheap
            <!-- <i class="bi bi-arrow-down-square-fill"></i> -->
        </h2>
    </div>
    
    <form action="#" class="row mb-4 mt-4" id="domain_search">
        
        <div class="col-12 mb-4">
            
            <div class="row mb-4">
               
                <div class="col-3">
                    <p><b>Select Namecheap Account</b></p>
                    <select name="nc_account" id="nc_account" class="form-select">
                        <?php foreach ($nc_accounts as $nc_acc) { ?>
                            <option value="<?php echo $nc_acc["id"] ?>"><?php echo $nc_acc["user"] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-3">
                    <p><b>Select Niche</b></p>
                    <select name="niche" id="niche" class="form-select">
                        <?php foreach ($niches as $nc) { ?>
                            <option value="<?php echo $nc["id"] ?>"><?php echo $nc["title"] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="col-3 d-flex align-items-end">
                    <button class="btn btn-primary me-3" onclick="get_suggested_domain()" type="button">Get Suggested Domain</button>
                </div>

            </div>

            <div class="row mb-4">

                <div class="col-3 d-flex align-items-end">
                    <input type="text" class="form-control" placeholder="Domain" id="domain-search" name="url">
                </div>

                <div class="col-4 d-flex align-items-end">
                    <button class="btn btn-primary me-3" onclick="search_domain()" type="button">Check availability</button>
                    <div class="spinner-border spinner-border-sm text-primary d-none loading-search" style="margin-bottom: 0.6rem" role="status"></div>
                    <b class="text-success mb-2 domain-available-notice d-none">Domain is available!</b>
                    <b class="text-secondary mb-2 domain-unavailable-notice d-none">Domain is not available...</b>
                </div>
                
            </div>

            <div class="col d-flex align-items-end">
                <button class="btn btn-primary me-3" onclick="" type="button" disabled>Register Domain</button>
                <!-- <button class="btn btn-primary me-3" onclick="" type="button" disabled>Update DNS</button>
                <button class="btn btn-primary me-3" onclick="" type="button" disabled>Turn off Domain Privacy</button>
                <button class="btn btn-primary me-3" onclick="" type="button" disabled>Update Registrar Info</button> -->
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

<script src="../assets/js/namecheap_helper.js"></script>