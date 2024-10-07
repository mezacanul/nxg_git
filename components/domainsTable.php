<?php 
    $domains = getQuery("SELECT domain.*, niche.title as niche FROM domain LEFT JOIN niche ON domain.niche = niche.id ORDER BY domain.lastChecked DESC");
    // print_r($domains[0]);
?>

<div class="row w-75 mb-3">
    <div class="col d-flex justify-content-between align-items-center">
        <h2>Domains</h2>
        <a href="domain.php?action=add" class="btn btn-primary">Add new domain</a>
    </div>
</div>

<div class="row w-75">
    <table class="table" id="return_addresses">
        <thead>
            <tr>
                <th>Domain</th>
                <th>Niche</th>
                <th>Status</th>
                <th>Last Checked</th>

                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($domains as $dn) { ?>
                <tr>
                    <td class='col-1'>
                        <a href="https://<?php echo $dn["domain"] ?>" target="_blank"><?php echo $dn["domain"] ?></a>
                    </td>

                    <td class='col-1'>
                        <?php echo $dn["niche"] ?>
                    </td>

                    <td class='col-1'>
                        <?php if($dn["status"] == 1) { ?>
                            <span class="text-success">Available</span>
                        <?php } else { ?>
                            <span class="text-danger">Unavailable</span>
                        <?php } ?>
                    </td>

                    <td class='col-1'>
                        <?php echo $dn["lastChecked"] ?>
                    </td>

                    <td class="d-flex justify-content-end">
                        <a class='btn btn-primary me-3' href='priority.php?id=<?php echo $dn['id'] ?>'>Edit</a>
                        <a class='btn btn-secondary' href='priority.php?id=<?php echo $dn['id'] ?>'>Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var returnAddressesTable = new DataTable('#return_addresses');
    $("#return_addresses_wrapper .dt-layout-table").addClass("table-responsive")
</script>