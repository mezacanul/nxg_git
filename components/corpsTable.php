<?php 
    $corps = getQuery("SELECT corp.id, corp.title, corp.corpaddress, signer.name as signerName, campaign.title as campaign, priority.title as priority, corp.notes, bank.title as bank, corp.loginplatform, corp.email, corp.password, campaign.color FROM corp LEFT JOIN priority ON corp.priority = priority.id LEFT JOIN campaign ON corp.campaign = campaign.id LEFT JOIN bank ON corp.bank = bank.id LEFT JOIN signer ON corp.signer = signer.id");
    // print_r($corps[0]);
?>

<div class="row mb-3">
    <div class="col d-flex justify-content-between align-items-center">
        <h2>Corps</h2>
        <a href="corps.php?action=add" class="btn btn-primary" onclick="addNew('corp')">Add new corp</a>
    </div>
</div>

<div class="row">
    <table class="table" id="corps">
        <thead>
            <tr>
                <th>Corp</th>
                <th>Corp Address</th>
                <th>Signer</th>
                <th>Campaign</th>
                <th>Priority</th>
                <th>Notes</th>
                <th>Bank</th>
                <th>Login Platform</th>
                <th>Email</th>
                <th>Password</th> 
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ($corps as $c) {
                echo("<tr style='background-color: {$c['color']}'>");
                foreach ($c as $k => $v) {
                    if($k != "color" and $k != "id"){
                        echo("<td class='col-1'>");
                        // if($k == "")
                        switch ($v) {
                            case 'high_risk': echo("High Risk"); break;
                            case 'low_risk':  echo("Low Risk"); break;
                            default: echo($v); break;
                        }
                        echo("</td>");
                    }
                }
                echo("<td>");
                    echo("<a class='btn btn-primary' href='corps.php?id={$c['id']}'>Edit</a>");
                echo("</td>");
                echo("</tr>");
            }
        ?>
        </tbody>
    </table>
</div>

<script>
    var corpsTable = new DataTable('#corps');
    $("#corps_wrapper .dt-layout-table").addClass("table-responsive")
</script>