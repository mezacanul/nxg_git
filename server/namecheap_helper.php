<?php 
    # -- Init Config
    require_once("credentials.php");
    require_once("db-routines.php");


    $arrContextOptions= [
        "ssl"=> [
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ],
    ];

    $niche = $_POST["niche"];
    $domain = getQuery("SELECT * FROM domain WHERE status = 1 AND niche = '$niche' ORDER BY RAND() LIMIT 1")[0];
    echo json_encode($domain);
?>