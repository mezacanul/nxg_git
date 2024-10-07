<?php 
    require_once("credentials.php");
    require_once("db-routines.php");

    // echo "hi";
    // exit();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST["service"]) {
            case 'add-account':
                echo json_encode(addAccount($_POST));
                break;
            default: break;
        }
    }

    function addAccount($postData){
        $added = [];
        $notAdded = [];

        $new_nc_signer = $postData["signer"];
        $new_nc_account = $postData["account"];
        $new_nc_password = $postData["password"];
        $new_nc_api_key = $postData["api_key"];        
        $new_nc_api_ip = "162.241.62.202";
        // $new_nc_api_ip = $postData["api_ip"];
        // MYSQL Production error
        #1101 - BLOB, TEXT, GEOMETRY or JSON column 'api_ip' can't have a default value

        // $sql = "INSERT INTO namecheap_accounts (id, user, password, signer, api_key, api_ip) VALUES (UUID(), '$new_nc_account', '$new_nc_password', '$new_nc_signer', '$new_nc_api_key', '$new_nc_api_ip')";
        $sql = "INSERT INTO namecheap_accounts (id, user, password, api_key, api_ip) VALUES (UUID(), '$new_nc_account', '$new_nc_password', '$new_nc_api_key', '$new_nc_api_ip')";
        $queryResult = addQuery($sql);
        if($queryResult == "ok"){
            array_push($added, $new_nc_account);
            
            // Update signer namecheap account
            $namecheapAccID = getQuery("SELECT id FROM namecheap_accounts WHERE user = '$new_nc_account'")[0]["id"];
            $sql = "UPDATE signer SET namecheap_account = '$namecheapAccID' WHERE id = '$new_nc_signer'";
            $updateSigner = updateQuery($sql);
            if($updateSigner == 1){
                return $response = ["status"=>"OK", "added"=>$added, "notAdded"=>$notAdded];
            } else {
                return $response = ["status"=>"ERROR", "sql"=>$sql, "notAdded"=>1];
            }
            // return $response = ["status"=>"OK", "added"=>$added, "notAdded"=>$notAdded];
        } else {
            array_push($notAdded, $new_nc_account);
            return $response = ["status"=>"ERROR", "added"=>$added, "notAdded"=>$notAdded, "sql"=>$sql];
        }        
        // return $response = ["status"=>"OK", "added"=>$added, "notAdded"=>$notAdded];
    }

?>