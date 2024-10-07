<?php 
    require_once("main.php");
    

    // echo "hi"; exit();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST["service"]) {
            case 'add-domains':
                echo json_encode(addDomains($_POST["domains"], $_POST["niche"]));
                break;
            case 'add-signer':
                echo json_encode(addSigner());
                break;
            case 'add-corp':
                echo json_encode(addCorp());
                break;
            case 'add-website':
                echo json_encode(addWebsite());
                break;
            case 'add-hostinger-acct':
                echo json_encode(addHostingerAcct());
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

    function addSigner(){
        $added = 0;
        $exists = 0;

        $user_role = isset($_POST["role"]) ? $_POST["role"] : "";

        $signer_name = $_POST["name"]; 
        
        if($user_role == "app"){
            $signer_homeaddress = $_POST["homeaddress"];
            $dob = $_POST["dob"];
            $dob = explode("-", $dob);
            $signer_dob = $dob[2]."/".$dob[1]."/".$dob[0];
            $signer_phone = $_POST["phone"];
        }

        $findSigner = getQuery("SELECT name FROM signer WHERE name = '$signer_name'");
        if(count($findSigner) > 0){
            // array_push($notAdded, $signer_name);
            $exists++;
        } else {
            if($user_role == "app"){
                $queryResult = addQuery("INSERT INTO signer (id, name, homeaddress, dob, phone) VALUES (UUID(), '$signer_name', '$signer_homeaddress', '$signer_dob', '$signer_phone')");
            } else {
                $queryResult = addQuery("INSERT INTO signer (id, name) VALUES (UUID(), '$signer_name')");
            }
            if($queryResult == "ok"){
                // array_push($added, $signer_name);
                $added++;
            }
        }
        
        return $response = ["status"=>"OK", "added"=>$added, "exists"=>$exists];
    }

    function addCorp(){
        $added = 0;
        $exists = 0;

        $user_role = isset($_POST["role"]) ? $_POST["role"] : "";
        // testPost();
        // exit();

        $corp_name = $_POST["corpName"]; 
        $corp_address = $_POST["corpAddress"];
        $corp_signer = $_POST["signer"];
        $corp_priority = $_POST["priority"];

        if($user_role == "app"){
            $corp_campaign = $_POST["campaign"];
            $corp_bank = $_POST["bank"];
            $corp_started = $_POST["started"];
            $corp_notes = $_POST["notes"];
            $corp_ein = $_POST["ein"];
            $corp_dl = $_POST["dl"];
            $corp_issueexp = $_POST["issueexp"];
            $corp_routing = $_POST["routing"];
            $corp_account = $_POST["account"];
            $corp_loginplatform = $_POST["loginplatform"];
            $corp_email = $_POST["email"];
            $corp_password = $_POST["password"];
        }


        $findCorp = getQuery("SELECT title FROM corp WHERE title = '$corp_name'");
        if($user_role == "app"){
            $sql_query = "INSERT INTO corp (id, title, corpaddress, signer, priority, campaign, bank, corpstarted, notes, ein, dl, issueexp, routing, account, loginplatform, email, password) VALUES (UUID(), '$corp_name', '$corp_address', '$corp_signer', '$corp_priority', '$corp_campaign', '$corp_bank', '$corp_started', '$corp_notes', '$corp_ein', '$corp_dl', '$corp_issueexp', '$corp_routing', '$corp_account', '$corp_loginplatform', '$corp_email', '$corp_password')";
        } else {
            $sql_query = "INSERT INTO corp (id, title, corpaddress, signer, priority) VALUES (UUID(), '$corp_name', '$corp_address', '$corp_signer', '$corp_priority')";
        }
        
        if(count($findCorp) > 0){
            // array_push($notAdded, $signer_name);
            $exists++;
        } else {
            $queryResult = addQuery($sql_query);
            if($queryResult == "ok"){
                // array_push($added, $signer_name);
                $added++;
            }
        }
        
        return $response = ["status"=>"OK", "added"=>$added, "exists"=>$exists, "sql"=>$sql_query];
    }

    function addWebsite(){
        $added = 0;
        $exists = 0;

        // testPost();
        // exit();

        $website_corp = $_POST["corp"];
        $website_bank = $_POST["bank"];
        $website_niche = $_POST["niche"];
        $website_dba = $_POST["dba"]; 
        $website_phone = $_POST["phone"];
        $website_hostinger = $_POST["hostinger_account"];

        $findWebsite = getQuery("SELECT dba FROM website WHERE dba = '$website_dba'");
        $sql_query = "INSERT INTO website (id, corp, niche, bank_website, dba, phone, hostinger_account) VALUES (UUID(), '$website_corp', '$website_niche', '$website_bank', '$website_dba', '$website_phone', '$website_hostinger')";
        if(count($findWebsite) > 0){ 
            $exists++; 
        } else {
            $queryResult = addQuery($sql_query);
            if($queryResult == "ok"){ $added++; }
        }
        
        return $response = ["status"=>"OK", "added"=>$added, "exists"=>$exists, "sql"=>$sql_query];
    }

    function addHostingerAcct(){
        $added = 0;
        $exists = 0;

        // $user_role = isset($_POST["role"]) ? $_POST["role"] : "";

        $hostinger_account = $_POST["account"]; 
        $hostinger_password = $_POST["password"]; 

        $findAccount = getQuery("SELECT account FROM hostinger WHERE account = '$hostinger_account'");
        if(count($findAccount) > 0){
            // array_push($notAdded, $signer_name);
            $exists++;
        } else {
            $sql = "INSERT INTO hostinger (id, account, password, added) VALUES (UUID(), '$hostinger_account', '$hostinger_password', NOW())";
            $queryResult = addQuery($sql);
            if($queryResult == "ok"){
                // array_push($added, $signer_name);
                $added++;
            }
        }
        
        return $response = ["status"=>"OK", "added"=>$added, "exists"=>$exists, "sql"=>$sql];
    }

?>