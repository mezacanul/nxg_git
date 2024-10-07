<?php 
    require_once("credentials.php");
    require_once("db-routines.php");

    // echo "hi";
    // exit();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST["service"]) {
            case 'add-domains':
                echo json_encode(addDomains($_POST["domains"], $_POST["niche"]));
                break;
            default: break;
        }
    }

    function addDomains($domains, $niche){
        $added = [];
        $notAdded = [];

        foreach ($domains as $dmn) {
            $findDomain = getQuery("SELECT domain FROM domain WHERE domain = '$dmn'");
            if(count($findDomain) > 0){
                array_push($notAdded, $dmn);
            } else {
                $queryResult = addQuery("INSERT INTO domain (id, domain, status, lastChecked, niche) VALUES (UUID(), '$dmn', 1, CURRENT_TIMESTAMP(), '$niche')");
                if($queryResult == "ok"){
                    array_push($added, $dmn);
                }
            }
        }
        
        return $response = ["status"=>"OK", "added"=>$added, "notAdded"=>$notAdded];
    }

?>