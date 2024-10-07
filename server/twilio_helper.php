<?php
    require_once '../assets/lib/Twilio/autoload.php';
    use Twilio\Rest\Client;
    
    try {
        // Find your Account SID and Auth Token at twilio.com/console
        // and set the environment variables. See http://twil.io/secure
        $sid = "Twilio SID";
        $token = "Twilio Token";
        $twilio = new Client($sid, $token);

        $tollFreeRecord = $twilio->availablePhoneNumbers("US")
            ->tollFree
            ->read(["contains" => "844*******"], 1)[0]->phoneNumber;

        $phone = str_replace(["+1"], '', $tollFreeRecord);
        $response = [ "status"=>"OK", "phone"=>$phone];
        echo json_encode($response);
        exit();
        
        // // CREATE NEW RECORD AND UPDATE FRIENDLY NAME
        // $twilio_data = [];
        // foreach ($websites as $ws) {
        //     $tollFreeRecord = $twilio->availablePhoneNumbers("US")
        //         ->tollFree
        //         ->read(["contains" => "844*******"], 1)[0]->friendlyName;
    
        //     $phoneN = str_replace([" ", "(", ")", "-"], '', $tollFreeRecord);
        //     print_r($phoneN);
        //     echo "<br>";
        //     $incoming_phone_number = $twilio->incomingPhoneNumbers->create(["phoneNumber" => $phoneN]);
        //     $phoneSID = $incoming_phone_number->sid;
        //     print_r($phoneSID);
        //     echo "<br>";
        //     $incoming_phone_number = $twilio->incomingPhoneNumbers($phoneSID)->update([ "friendlyName" => $ws ]);

        //     array_push($twilio_data, [ "url"=>$ws, "phone"=>$phoneN, "sid"=>$phoneSID ]);
        //     print_r($ws);
        //     echo "<br>";
        //     echo "<br>";
        // }

        // foreach ($twilio_data as $td) {
        //     print_r($td);
        //     echo "<br>";
        // }

        // echo "<br>";

        // foreach ($twilio_data as $td) {
        //     echo json_encode($td);
        //     echo "<br>";
        // }
        // echo(json_encode($twilio_data));
    
        // // print_r($message->sid);

        
        
        // // GET INFO FROM RECORDS BASED ON SID
        
        // $s = "PN**********";
        // $incoming_phone_number = $twilio->incomingPhoneNumbers($s)->fetch();
        // $friendlyName = $incoming_phone_number->friendlyName;
        // $sid = $incoming_phone_number->sid;
        // $phone = $incoming_phone_number->phoneNumber;
        // print_r([$friendlyName, $sid, $phone]);

        

        // echo($friendlyName, $phone, $sid);
        // foreach ($websites as $s) {
        //     $incoming_phone_number = $twilio->incomingPhoneNumbers($s)->fetch();
            
        //     $friendlyName = $incoming_phone_number->friendlyName;
        //     $r = str_replace("+1", "", $incoming_phone_number->phoneNumber);
        //     $phone = "{$r[0]}{$r[1]}{$r[2]} {$r[3]}{$r[4]}{$r[5]} {$r[6]}{$r[7]}{$r[8]}{$r[9]}";
        //     $sid = $incoming_phone_number->sid;
        //     // print_r($incoming_phone_number);
        //     echo "INSERT INTO website (id, corp, dba, phone, twilio_sid, files_account) VALUES (UUID(), '11372ddc-0279-11ef-981f-acde48001122', '{$friendlyName}', '{$phone}', '{$sid}', 'admin@spectralightinccorp.com');";
        //     echo "<br>";
        // }
    } catch (\Throwable $th) {
        print_r($th);
    }


?>