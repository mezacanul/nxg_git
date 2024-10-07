<?php
    $corpID = $query->id;
    $signerID = getQuery("SELECT signer.id FROM corp LEFT JOIN signer ON corp.signer = signer.id WHERE corp.id = '$corpID'")[0]["id"];
    $websites = getQuery("SELECT website.*, niche.title as niche, bank_website.title as bank_website, hostinger.account as hostinger_account FROM website LEFT JOIN niche ON website.niche = niche.id LEFT JOIN bank_website ON website.bank_website = bank_website.id LEFT JOIN hostinger ON website.hostinger_account = hostinger.id WHERE corp = '$corpID' ORDER BY website.added");

    // $namecheapAccount = getQuery("SELECT * FROM namecheap_accounts WHERE signer = '$signerID'");
    $namecheapAccountID = getQuery("SELECT namecheap_account FROM signer WHERE id = '$signerID'")[0]["namecheap_account"];
    $namecheapAccount = getQuery("SELECT * FROM namecheap_accounts WHERE id = '$namecheapAccountID'");
    $proSTATUS = count($namecheapAccount) == 1 ? "" : "disabled";
?>

<div class="row mb-4 d-inline-flex align-items-center">
    <h2>Websites</h2>
    <a class="btn btn-primary ms-2 w-auto" href="website.php?action=add&corp=<?php echo $corpID ?>">Add</a>
    <a class="btn btn-dark <?php echo $proSTATUS ?> ms-2 w-auto" href="pro.php?action=new&corp=<?php echo $corpID ?>">Pro Mode</a>
    <?php if($proSTATUS == "disabled"){ ?>
        <span class="w-auto">
            Setup a <b>Namecheap</b> account for this signer to enable <b>Pro Mode</b>
            &nbsp;
            <a class="bi bi-info-circle text-primary" style="font-size: 1.2rem" href="namecheap_acct.php?action=info"></a>
        </span>
    <?php } ?>
</div>

<div class="row mb-4">
    <table class="table" id="websites">
        <thead>
            <tr>
                <th>DBA</th>
                <th>Phone</th>
                <th>Niche</th>
                <th>Bank Assigned</th>
                <th>Hostinger Account</th>
                <th>Added</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // print_r($websites);
            foreach ($websites as $ws) { 
                $websiteID = $ws["id"]; 
            ?>
                <tr data-website-id="<?php echo $websiteID ?>">
                    <?php 
                        if(str_contains($ws["phone"], "+1")){
                            $phone = str_replace("+1", "", $ws["phone"]);
                            $phone = str_split($phone);
                            $ws["phone"] = "$phone[0]$phone[1]$phone[2] $phone[3]$phone[4]$phone[5] $phone[6]$phone[7]$phone[8]$phone[9]";
                        }
                    ?>
                    <td class='col-1'>
                        <i class="bi bi-clipboard-plus btn-copy" onclick="copy_website_row('<?php echo $websiteID ?>')"></i> 
                        &nbsp;&nbsp;<span class="td-dba"><?php echo $ws["dba"] ?></span>
                    </td>
                    <td class='col-1 td-phone'><?php echo $ws["phone"] ?></td>
                    <td class='col-1'><?php echo $ws["niche"] ?></td>
                    <td class='col-1'><?php echo $ws["bank_website"] ?></td>
                    <td class='col-1 td-hostinger'><?php echo $ws["hostinger_account"] ?></td>
                    <td class='col-1'><?php echo $ws["added"] ?></td>
                    <!-- <td class='col d-flex justify-content-center'>
                        <a class='btn btn-dark me-2 <?php echo $proSTATUS ?>' href='pro.php?id=<?php echo $ws['id'] ?>'>Pro Mode</a>
                        <a class='btn btn-primary me-2' target="_blank" href='website_builder.php?websiteID=<?php echo $ws['id'] ?>'>Builder</a>
                        <a class='btn btn-primary me-2' href='website.php?id=<?php echo $ws['id'] ?>'>Edit</a>
                    </td> -->

                    <td class='col d-flex justify-content-center align-items-center'>
                        <a class="bi bi-pencil-square text-primary me-2"  href='website.php?id=<?php echo $ws['id'] ?>&from=corp' style="font-size: 1.4rem"></a>
                        <a class="bi bi-trash-fill text-secondary m-0 me-2" style="font-size: 1.4rem" href='website.php?id=<?php echo $ws['id'] ?>'></a>

                        <a class='btn btn-primary me-2' target="_blank" href='website_builder.php?websiteID=<?php echo $ws['id'] ?>'>Builder</a>
                        <a class='btn btn-dark me-2 <?php echo $proSTATUS ?>' href='pro.php?id=<?php echo $ws['id'] ?>'>Pro Mode</a>
                        <!-- <a class='btn btn-primary me-2' href='website.php?id=<?php echo $ws['id'] ?>'>Edit</a> -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var signerWebsitesTable = new DataTable('#websites');
    $("#websites_wrapper .dt-layout-table").addClass("table-responsive")
</script>