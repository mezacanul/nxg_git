<?php 
    $websites = getQuery("SELECT website.*, niche.title as niche, corp.title as corp, signer.name as signer, campaign.title as campaign, priority.title as priority, campaign.color, bank_website.title as bank_website, hostinger.account as hostingerAccount FROM website LEFT JOIN niche ON website.niche = niche.id LEFT JOIN corp ON website.corp = corp.id LEFT JOIN campaign ON corp.campaign = campaign.id LEFT JOIN signer ON corp.signer = signer.id LEFT JOIN priority ON corp.priority = priority.id LEFT JOIN bank_website ON website.bank_website = bank_website.id LEFT JOIN hostinger ON website.hostinger_account = hostinger.id");
    // print_r($websites[0]);
?>

<div class="row mb-3">
    <div class="col d-flex justify-content-between align-items-center">
        <h2>Websites</h2>
        <div class="actions">
            <a href="website.php?action=add" class="btn btn-primary" onclick="addNew('website')">Add</a>
            <a href="pro.php?action=new" class="btn btn-dark">Pro Mode</a>
        </div>
    </div>
</div>

<div class="row">
    <table class="table" id="websites">
        <thead>
            <tr>
                <th>DBA</th>
                <th>Phone</th>
                <th>Niche</th>
                <th>Corp</th>
                <th>Signer</th>
                <th>Bank</th>
                <th>Priority</th>
                <th>Hostinger account</th>
                <th>Campaign</th>
                <th>Added</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($websites as $ws) { 
            $websiteID = $ws["id"] ?>
            <tr style='background-color: <?php echo $ws['color'] ?>' data-website-id="<?php echo $websiteID ?>">
                <td>
                    <i class="bi bi-clipboard-plus btn-copy" onclick="copy_website_row('<?php echo $websiteID ?>')"></i> 
                    &nbsp;&nbsp;<span class="td-dba"><?php echo $ws["dba"] ?></span>
                </td>
                <td class="td-phone"><?php echo str_contains($ws["phone"], "+1") ? formatPhone($ws["phone"]) : $ws["phone"] ?></td>
                <td><?php echo $ws['niche'] ?></td>
                <td><?php echo $ws['corp'] ?></td>
                <td><?php echo $ws['signer'] ?></td>
                <td><?php echo $ws['bank_website'] ?></td>
                <td><?php echo $ws['priority'] ?></td>
                <td class="td-hostinger"><?php echo ($ws['hostingerAccount'] != "" ? $ws['hostingerAccount'] : $ws['hostinger_account']) ?></td>
                <td><?php echo $ws['campaign'] ?></td>
                <td><?php echo $ws['added'] ?></td>
                <td>
                    <a class="bi bi-pencil-square text-primary me-2"  href='website.php?id=<?php echo $ws['id'] ?>' style="font-size: 1.4rem"></a>
                    <a class="bi bi-trash-fill text-secondary m-0 me-2" style="font-size: 1.4rem" href='website.php?id=<?php echo $ws['id'] ?>'></a>
                    <!-- <a class='btn btn-primary' href='website.php?id=<?php echo $ws['id'] ?>'>Edit</a> -->
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var websitesTable = new DataTable('#websites', {
        pageLength: 25,
        order: {
            idx: 9,
            dir: "dsc"
        }
    });
    $("#websites_wrapper .dt-layout-table").addClass("table-responsive")
</script>