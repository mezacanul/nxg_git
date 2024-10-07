<?php 
    session_start();
    # -- Session Config
    require_once("session.php");

    # -- Init Config
    require_once("credentials.php");
    require_once("db-routines.php");


    $arrContextOptions= [
        "ssl"=> [
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ],
    ];

    function getQueryObject(){
        $URI = parse_url($_SERVER['REQUEST_URI']);
        if(isset($URI["query"])){
            $rq = explode("&", $URI["query"]);
            
            $object = new stdClass();
            foreach ($rq as $q) {
                $q = explode("=", $q);
                $object->{$q[0]} = "$q[1]";
            }   
            return $object;
        } else {
            return "empty";
        }
    }

    function testPost(){
        $_POST["from_server"] = "POST DATA RETURN - TEST";
        echo json_encode($_POST);
    }

    function formatPhone($phoneSource){
        if(str_contains($phoneSource, "+1")){
            $phone = str_replace("+1", "", $phoneSource);
            $phone = str_split($phone);
            return "$phone[0]$phone[1]$phone[2] $phone[3]$phone[4]$phone[5] $phone[6]$phone[7]$phone[8]$phone[9]";
        } else {
            return $phoneSource;
        }
    }
?>