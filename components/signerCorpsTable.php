<?php
    $signerCorps = getQuery("SELECT corp.id, corp.title as corp, priority.title as priority, corp.notes, campaign.title as campaign, corp.corpaddress, corp.corpstarted, corp.ein, corp.dl, corp.issueexp, bank.title as bank, corp.routing, corp.account, corp.loginplatform, corp.email, corp.password, campaign.color FROM corp LEFT JOIN priority ON corp.priority = priority.id LEFT JOIN campaign ON corp.campaign = campaign.id LEFT JOIN signer ON corp.signer = signer.id LEFT JOIN bank ON corp.bank = bank.id WHERE signer = '{$signer['id']}'");
    $tableWidth = $_SESSION["role"] == "dev" ? "w-75" : "";
    // print_r($signerCorps[0]);
    // print_r($signer["id"]);
?>

<div class="content-wrapper <?php echo $tableWidth ?>">
    <div class="row mb-4 d-inline-flex">
        <h2>Corps</h2>
        <a class="btn btn-primary w-auto ms-2" href="corp.php?action=add&signer=<?php echo $signer["id"] ?>">Add</a>
    </div>
    
    <div class="row mb-4">
        <table class="table" id="signerCorps">
            <thead>
                <tr>
                    <th>Corp</th>
                    <th>Address</th>
                    <th>Campaign</th>
                    <th>Priority</th>
                    <th>Notes</th>
                    <?php if($_SESSION["role"] == "app") { ?>
                        <th>Corp Started</th>
                        <th>EIN</th>
                        <th>DL</th>
                        <th>Issue / Exp</th>
                        <th>Bank</th>
                        <th>Routing</th>
                        <th>Account</th>
                        <th>Login Platform</th>
                        <th>Email</th>
                        <th>Password</th>
                    <?php } ?>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($signerCorps as $sgcr) { ?>
                    <tr style='background-color: <?php echo $sgcr['color'] ?>'>
                        <td class='col'><?php echo $sgcr["corp"] ?></td>
                        <td class='col'><?php echo $sgcr["corpaddress"] ?></td>
                        <td class='col'><?php echo $sgcr["campaign"] ?></td>
                        <td class='col'><?php echo $sgcr["priority"] ?></td>
                        <td class='col'><?php echo $sgcr["notes"] ?></td>
                        <?php if($_SESSION["role"] == "app") { ?>

                        <?php } ?>
                        <!-- <td class='col d-flex justify-content-center'>
                            <a class='btn btn-primary' href='corp.php?id=<?php echo $sgcr['id'] ?>'>Edit</a>
                        </td> -->
                        <td class="col d-flex justify-content-center">
                            <a class="bi bi-pencil-square text-primary me-2"  href='corp.php?id=<?php echo $sgcr['id'] ?>' style="font-size: 1.4rem"></a>
                            <a class="bi bi-trash-fill text-secondary m-0" style="font-size: 1.4rem" href='corp.php?id=<?php echo $sgcr['id'] ?>'></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    var signerCorpsTable = new DataTable('#signerCorps');
    $("#signerCorps_wrapper .dt-layout-table").addClass("table-responsive")
</script>