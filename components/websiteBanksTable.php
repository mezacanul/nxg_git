<?php 
    $websiteBanks = getQuery("SELECT * FROM bank_website");
    // print_r($banks[0]);
?>

<div class="row w-50 mb-3">
    <div class="col d-flex justify-content-between align-items-center">
        <h2>Website Banks</h2>
        <a href="websites.php?action=add" class="btn btn-primary" onclick="addNew('website')">Add new website bank</a>
    </div>
</div>

<div class="row w-50">
    <table class="table" id="website_banks">
        <thead>
            <tr>
                <th>Title</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($websiteBanks as $wbb) { ?>
                <tr>
                    <td class='col-1'>
                        <?php echo $wbb["title"] ?>
                    </td>
                    <td class="d-flex justify-content-end">
                        <a class='btn btn-primary me-3' href='priority.php?id=<?php echo $wbb['id'] ?>'>Edit</a>
                        <a class='btn btn-secondary' href='priority.php?id=<?php echo $wbb['id'] ?>'>Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var websiteBanksTable = new DataTable('#website_banks');
    $("#website_banks_wrapper .dt-layout-table").addClass("table-responsive")
</script>