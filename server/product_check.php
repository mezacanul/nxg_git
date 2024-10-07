<?php 
    require_once("main.php");
    ini_set('user_agent', 'My-Application/2.5');


    $arrContextOptions= [
        "ssl"=> [
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ],
    ];

    $products_js_path = "/js/data/products.js";
    $images_path = "/img/";

    $online_products_js_URL = "http://".$_POST["url"].$products_js_path;
    // $online_products_js_URL = "http://www.".$_POST["url"];
    // $online_products_js_URL = "http://"."QualityToyAccessories.com".$products_js_path;
    // // echo $online_products_js_URL;

    // $online_products_js_DATA = file_get_contents($online_products_js_URL, NULL, stream_context_create($arrContextOptions));
    // echo($online_products_js_DATA);

    // echo file_get_contents("http://qualitytoyaccessories.com/js/data/products.js");


    function getCurlDATA($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    
        // if(curl_exec($ch) === FALSE) {
        //      echo "Error: " . curl_error($ch);
        // } else {
        //     $data = curl_exec($ch);
        // }
    
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_URL, $online_products_js_URL);
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // if(curl_exec($ch) === FALSE) {
    //      echo "Error: " . curl_error($ch);
    // } else {
    //     $online_products_js_DATA = curl_exec($ch);
    // }

    // curl_close($ch);

    $online_products_js_DATA = str_replace("export const ", "", getCurlDATA($online_products_js_URL));
    // $online_products_js_DATA = str_replace("export const ", "", $online_products_js_DATA);
    
    // echo $online_products_js_DATA;
    $file = fopen ($online_products_js_URL, "r");
    print_r($file);
    fclose($file);
    // print_r(ini_get('allow_url_fopen'));


?>