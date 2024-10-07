<?php
    // $submissionDetails = getQuery("SELECT * FROM user WHERE id = '$userid'")[0];
    $query = getQueryObject();
    $nichesDetails = getQuery("SELECT * FROM niche WHERE status = 1");
    $templatesDetails = getQuery("SELECT id, preview, type FROM template WHERE status = 1 AND type = 'default'");
    $returnAddresses = getQuery("SELECT * FROM return_address");
    
    if(isset($query->websiteID)){
        $websiteDATA = getQuery("SELECT * FROM website WHERE id = '$query->websiteID'")[0];
        $corpID = $websiteDATA["corp"];
        $nicheId = $websiteDATA["niche"];
        
        $corpInfo = getQuery("SELECT * FROM corp WHERE id = '$corpID'")[0];
        // print_r($corpInfo);
        // print_r($websiteDATA);
        $templateID = $corpInfo["template"];
        // print_r($templateID);
        $query->domain = $websiteDATA["dba"];
        $phone = str_split(str_replace("+1", "", $websiteDATA["phone"]));
        $query->phone = "$phone[0]$phone[1]$phone[2] $phone[3]$phone[4]$phone[5] $phone[6]$phone[7]$phone[8]$phone[9]";

    } else {
        if(isset($query->corp)){
            $corpInfo = getQuery("SELECT * FROM corp WHERE id = '$query->corp'")[0];
        }
    
        if(isset($query->niche)){
            $nicheId = $query->niche;
        }
    }
    // print_r($query->websiteID);
?>

<style>
    .products_preview {
        display: none;
    }        
</style>

<div class="row mb-4" id="corpTitle">
    <h2 class="ps-0">Website Builder</h2>
    <button onclick="demo()" type="button" class="btn btn-primary me-2 col-1 py-1">Demo</button>
</div>


<form action="#" id="website_builder" class="d-flex justify-content-between px-0 mb-4 row needs-validation" novalidate enctype="multipart/form-data">
    <div class="site-configuration col">    
        <div id="input-options" class="d-flex row">
        
            <div class="col-5" id="site_details">
                <h3 class="mb-3">Site details</h3>
                <div class="sites">
                    <div class="site_details">
                        <input type="text" class="form-control" name="url" placeholder="URL" onkeyup="setDescriptor()" required 
                            value="<?php echo (isset($query->domain) ? $query->domain : "") ?>"
                        >

                        <br>
                        <input type="text" class="form-control" name="phone" placeholder="Phone" onkeyup="setDescriptor()" required
                            value="<?php echo (isset($query->phone) ? $query->phone : "") ?>"
                        >
                        
                        <br>
                        <label for="descriptor" class="mb-2 ms-1"><b>Descriptor:</b> </label>
                        <select id="descriptorType" name="descriptorType" class="form-select" onchange="setDescriptor()">
                            <option value="alphanumeric" selected>Alphanumeric</option>
                            <option value="dba">DBA</option>
                            <option value="url">URL</option>
                            <option value="dashed">Dashed</option>
                            <option value="spaced">Spaced</option>
                        </select>
                        <input type="hidden" name="descriptor">
                    </div>
                </div>
            </div>
    
            <div class="col-5" id="corp_details">
                <h3 class="mb-3">Corp Details</h3>
                <input type="text" class="form-control" name="corp" placeholder="Corp" required
                    value="<?php echo (isset($corpInfo) ? $corpInfo["title"] : "") ?>"
                    >

                <br>
                <input type="text" class="form-control" name="address" placeholder="Address" required
                    value="<?php echo (isset($corpInfo) ? str_replace("'", "\'", $corpInfo["corpaddress"]) : "") ?>"
                    >
                <br>
                <label for="return_address" class="mb-2 ms-1"><b>Return Address:</b></label>
                <select name="return_address" class="form-select" onchange="setReturnAddress()">
                    <?php  foreach ($returnAddresses as $ra) { ?>
                        <option <?php echo str_contains($ra['title'], "Brokerage") ? "selected" : "" ?> value="<?php echo $ra['id'] ?>" data-address="<?php echo $ra['address'] ?>"><?php echo $ra['title'] ?></option>
                    <?php } ?>
                </select>
            </div>

        </div>

        <div class="site-details-preview mt-4">
            <p><b style="text-decoration: underline;">Descriptor:</b> <span class="descTarget"></span></p>
            <p><b style="text-decoration: underline;">Return Address:</b> <span class="raTarget"></span></p>
        </div>
    </div>

    <div class="template-configuration col">
            <h3 class="mb-3">Template Configuration</h3>
            <select name="niche" class="form-select w-50 mb-3">
                <?php  foreach ($nichesDetails as $nd) { ?>
                    <option data-type="<?php echo $nd['type'] ?>" data-title="<?php echo $nd['title'] ?>" value="<?php echo $nd['id'] ?>" <?php echo ((isset($nicheId) && $nicheId == $nd["id"]) ? "selected" : "") ?>><?php echo $nd['title'] ?></option>
                <?php } ?>
            </select>

            <div class="template-container d-flex mb-3">
                <select name="template" class="form-select w-50 me-2" id="templateSelect" onchange="setPreviewBtn()">
                    <?php  foreach ($templatesDetails as $td) { ?>
                        <option 
                            value="<?php echo $td['id'] ?>" 
                            data-preview="<?php echo $td['preview'] ?>"
                            <?php echo ((isset($templateID) && $templateID == $td["id"]) ? "selected" : "") ?>
                        ><?php echo ucfirst(str_replace("https://yanaegorova.github.io/", "", $td['preview'])) ?></option>
                    <?php } ?>
                </select>
                <a class="btn btn-primary me-2 templatePreviewLink text-white text-decoration-none" type="button" target="_blank">Preview</a>
                <button onclick="selectRandomTemplate()" type="button" class="randBtn btn btn-primary">Random</button>
                
            </div>

            <div class="productOptions">
                <div class="productIncludeOptions">
                    <label for="products" class="mb-2 ms-1">
                        <b>Products: </b>
                    </label>
                    <select name="products" class="form-select  w-50" id="productsSelect" onchange='toggleProductsInput()'>
                        <option value="dont">Dont include</option>
                        <option value="upload">Upload</option>
                    </select>
                </div>  
                <br>
        
                <div class="uploadFiles productsDetails d-none" id='productsInput'>
                    <label for="productsFiles" class="mb-3">
                        <b>Select products folder: </b>
                    </label>
                    <br>
                    <!-- <input name="productsFiles" class="form-control w-50" type="file" webkitdirectory directory multiple/> -->
                    <input name="productsFiles" class="form-control w-50" type="file" onchange="getProductsFile()"/>
                </div>
            </div>
    </div>
</form>

<div class="products_preview">
    <div class="console">
        <h2>Console: </h2>
        <p></p>
    </div>
    <div class="results"></div>
    <div class="container"></div>
</div>


<script src="../assets/js/website_builder.js"></script>