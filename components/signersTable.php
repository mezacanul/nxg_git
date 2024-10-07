<?php
    // $signers = getQuery("SELECT * FROM signer");
    $signers = getQuery("SELECT count(website.id) as websiteCount, signer.* FROM signer LEFT JOIN corp ON signer.id = corp.signer LEFT JOIN website ON corp.id = website.corp GROUP BY signer.id");
    // $tableWIDTH = $_SESSION["role"] == "dev" ? "w-75" : "";
    // print_r($tableWIDTH);
?>

<style>
    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="content-wrapper <?php echo $_SESSION["role"] == "dev" ? "w-max-content" : "" ?>">
    <div class="row mb-3">
        <div class="col d-flex justify-content-between align-items-center">
            <h2>Signers</h2>
            <a href="signer.php?action=add" class="btn btn-primary" onclick="addNew('signer')">Add</a>
        </div>
    </div>
    
    <div class="row">
        <table class="table" id="signers">
            <thead>
                <tr>
                    <th>Name</th>
                    <?php if ($_SESSION["role"] == "app") { ?>
                        <th>Home Address</th>
                        <th>DOB</th>
                        <th>Phone</th>
                    <?php } ?>
                    <th>Websites</th>
                    <th>Status</th>
                    <th>Added</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($signers as $sgnr) { ?>
                    <tr data-signer-id="<?php echo $sgnr["id"]?>">
                        <td class="col"><?php echo $sgnr["name"]?></td>
                        <?php if ($_SESSION["role"] == "app") { ?>
                            <td class="col"><?php echo $sgnr["homeaddress"]?></td>
                            <td class="col"><?php echo $sgnr["dob"]?></td>
                            <td class="col"><?php echo $sgnr["phone"]?></td>
                        <?php } ?>
                        <td class="col text-center"><?php echo $sgnr["websiteCount"]?></td>
                        <td class="col <?php echo ($sgnr["status"] == 1 ? "text-success" : "text-secondary") ?>"><?php echo ($sgnr["status"] == 1 ? "Active" : "Inactive") ?></td>
                        <td class="col"><?php echo $sgnr["added"]?></td>
                        <td class='col d-flex justify-content-end'>
                            <!-- <a class='btn btn-primary me-2' href='signer.php?id=<?php echo $sgnr['id'] ?>'>Edit</a>
                            <a class='btn btn-secondary' href='signer.php?id=<?php echo $sgnr['id'] ?>'>Delete</a> -->
                            
                            <a class="bi bi-pencil-square text-primary me-2"  href='signer.php?id=<?php echo $sgnr['id'] ?>' style="font-size: 1.4rem"></a>
                            <a class="bi bi-trash-fill text-secondary m-0 me-2" style="font-size: 1.4rem" href='signer.php?id=<?php echo $sgnr['id'] ?>'></a>
                        </td>
                    </tr>
                <?php } ?>    
            </tbody>
        </table>
    </div>
</div>

<script>
    var table = new DataTable('#signers', {
            order: {
            idx: 3,
            dir: 'dsc'
        }
    });
    $(".dt-layout-table").addClass("table-responsive")
</script>