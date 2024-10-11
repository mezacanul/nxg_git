<?php 
    // $namecheapAccounts = getQuery("SELECT namecheap_accounts.*, signer.name as signerName FROM namecheap_accounts LEFT JOIN signer ON namecheap_accounts.signer = signer.id");
    $namecheapAccounts = getQuery("SELECT namecheap_accounts.*, signer.name as signerName FROM namecheap_accounts LEFT JOIN signer ON namecheap_accounts.id = signer.namecheap_account");
    // $namecheapAccounts = getQuery("SELECT namecheap_accounts.*, signer.name as signerName FROM signer LEFT JOIN namecheap_accounts ON signer.namecheap_account = namecheap_accounts.id");
    // $namecheapDATA = getQuery("SELECT namecheap_accounts.* FROM signer LEFT JOIN namecheap_accounts ON signer.namecheap_account = namecheap_accounts.id WHERE signer.id = '$signerID';");
?>

<div class="content-wrapper w-max-content">
    <div class="row mb-3">
        <div class="col d-flex justify-content-between align-items-center">
            <h2>Namecheap Accounts</h2>
            <a href="namecheap_acct.php?action=add" class="btn btn-primary">Add new account</a>
        </div>
    </div>
    
    <div class="row">
        <table class="table w-auto" id="return_addresses">
            <thead>
                <tr>
                    <th>Account</th>
                    <!-- <th>Password</th> -->
                    <th>Signer</th>
                    <th>Created</th>
                    <!-- <th>API Key</th> -->
                    <!-- <th>API Registered IP</th> -->
    
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($namecheapAccounts as $na) { ?>
                    <tr>
                        <td class='col-1'>
                            <?php echo $na["user"] ?>
                        </td>
    
                        <!-- <td class='col-1'>
                            <?php echo $na["password"] ?>
                        </td> -->
    
                        <td class='col-1'>
                            <?php echo $na["signerName"] ?>
                        </td>

                        <td class='col-1'>
                            <?php echo $na["created"] ?>
                        </td>
    
                        <!-- <td class='col-1'>
                            <?php echo $na["api_key"] ?>
                        </td> -->
    
                        <!-- <td class='col-1'>
                            <?php echo $na["api_ip"] ?>
                        </td> -->
    
                        <td class="col d-flex justify-content-center">
                            <!-- <a class='btn btn-primary me-3' href='namecheap_acct.php?id=<?php echo $na['id'] ?>'>Edit</a>
                            <a class='btn btn-secondary d-flex align-items-center' href='namecheap_acct.php?id=<?php echo $na['id'] ?>'><i class="bi bi-trash-fill m-0" style="font-size: 1.4rem"></i></a> -->
                            <a class="bi bi-pencil-square text-primary me-2"  href='namecheap_acct.php?id=<?php echo $na['id'] ?>' style="font-size: 1.4rem"></a>
                            <a class="bi bi-trash-fill text-secondary m-0" style="font-size: 1.4rem" href='namecheap_acct.php?id=<?php echo $na['id'] ?>'></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    var returnAddressesTable = new DataTable('#return_addresses', {
        //     order: {
        //     idx: 0,
        //     dir: 'asc'
        // }
    });
    
    
    $("#return_addresses_wrapper .dt-layout-table").addClass("table-responsive")
</script>