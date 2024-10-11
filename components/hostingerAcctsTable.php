<?php 
    $hostingerAccts = getQuery("SELECT * FROM hostinger");
    // print_r($banks[0]);
?>

<div class="row w-75 mb-3">
    <div class="col d-flex justify-content-between align-items-center">
        <h2>Hostinger Accounts</h2>
        <a href="hostinger_acct.php?action=add" class="btn btn-primary" onclick="addNew('hostinger')">Add new account</a>
    </div>
</div>

<div class="row w-75">
    <table class="table" id="hostinger">
        <thead>
            <tr>
                <th>Account</th>
                <th>Created</th>
                <!-- <th>Password</th> -->

                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hostingerAccts as $ha) { ?>
                <tr>
                    <td class='col-1'>
                        <?php echo $ha["account"] ?>
                    </td>

                    <td class='col-1'>
                        <?php echo $ha["added"] ?>
                    </td>

                    <!-- <td class='col-1'>
                        <?php echo $ha["password"] ?>
                    </td> -->

                    <td class="d-flex justify-content-end">
                        <a class='btn btn-primary me-3' href='hostinger_acct.php?id=<?php echo $ha['id'] ?>'>Edit</a>
                        <a class='btn btn-secondary' href='hostinger_acct.php?id=<?php echo $ha['id'] ?>'>Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var hostingerTable = new DataTable('#hostinger');
    $("#hostinger_wrapper .dt-layout-table").addClass("table-responsive")
</script>