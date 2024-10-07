<?php
    $userDetails = getQuery("SELECT * FROM user WHERE id = '$userid'")[0];
    // print_r($userDetails);
?>

<style>
    
</style>

<div class="row mb-4" id="corpTitle">
    <h2><?php echo $userDetails["name"] ?></h2>
    <p><?php echo ucfirst($userDetails["role"]) ?></p>
</div>

<div class="row mb-4 corpDetails">
    <?php foreach($userDetails as $k => $v) { 
        if($k == "id"){ ?>
            <input type='hidden' value='<?php echo $v ?>'>
        <?php } elseif ($k != "color") { ?> 
            <div class="col-3 mb-3">
                <label for="exampleFormControlInput1" class="form-label fw-bold"><?php echo ucfirst($k) ?></label>
                <input type="text" class="form-control" type='text' value='<?php echo $v ?>'>
            </div>    
        <?php } ?> 
    <?php } ?>
</div>

<div class="row justify-content-end userActions">
    <div class="col-4 d-flex justify-content-end">
        <button class="btn btn-primary me-2">
            Save Changes
        </button>
        <button class="btn btn-warning me-2" onclick="logout()">
            Log Out
        </button>
    </div>
</div>