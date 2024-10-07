<?php 
    // $websites = getQuery("SELECT website.*, niche.title as niche, corp.title as corp, signer.name as signer, campaign.title as campaign, priority.title as priority, campaign.color, bank_website.title as bank_website, hostinger.account as hostingerAccount FROM website LEFT JOIN niche ON website.niche = niche.id LEFT JOIN corp ON website.corp = corp.id LEFT JOIN campaign ON corp.campaign = campaign.id LEFT JOIN signer ON corp.signer = signer.id LEFT JOIN priority ON corp.priority = priority.id LEFT JOIN bank_website ON website.bank_website = bank_website.id LEFT JOIN hostinger ON website.hostinger_account = hostinger.id");
    // print_r($websites[0]);
?>

<style>
    .product-image {
        width: 6rem;
        height: 6rem;
        object-fit: cover
    }
</style>

<div class="row table-continer d-none">
    <table class="table" id="products">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody></tbody>
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