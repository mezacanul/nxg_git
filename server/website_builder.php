<?php
    # -- Init Config
    require_once("credentials.php");
    require_once("db-routines.php");
    
    date_default_timezone_set("America/New_York");
    // date_default_timezone_set("America/Mexico_City");

    $arrContextOptions= [
        "ssl"=> [
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ],
    ];  

    $prefix = "https://github.com/YanaEgorova/";
    $suffix = "/zipball/master/";

    $tmpFolder = "../files/tmp/";
    $zipFolder = "../files/zip/";
    $ignore = [".", "..", ".DS_Store"];
    $img_delete = [
        "products.js",
        "img0.png", "img1.png", "img2.png", "img3.png", "img4.png", "img5.png", "img6.png", "img7.png", "img8.png", "img9.png", "img10.png", "img11.png", "img12.png", "img13.png",
    ];

    // STATUS: DEV 
    // TO DO: 
    // - Add Service: Zip and download
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST["service"]) {
            case 'create':
                // echo "hi";
                // print_r($_FILES);
                // exit();
                echo json_encode(createWebsite(
                    $_POST['template'], 
                    $_POST['niche'], 
                    $_POST["url"],
                    $_POST["products"]
                ));
                break;
            case "shuffle":
                echo json_encode(shuffleData(
                    $_POST['template'], 
                    $_POST['niche']
                ));
                break;
            case "shuffleCustom":
                echo json_encode(shuffleCustom(
                    $_POST["input_name"],
                    $_POST["input_type"],
                    $_POST["niche"],
                ));
                break;
            case "updateCreated":
                echo json_encode(updateCreated($_POST));
                break;
            case "zip_download":
                echo json_encode(zipForDownload(
                    $_POST["demoPath"]
                ));
                break;
            default: break;
        }
    }

    function zipForDownload($demoPath){
        try {
            $zipFolder = "../files/zip/";
            $zipFileName = str_replace(".com", "", $demoPath).".zip";
            $pathToNewZipFile = $zipFolder.$zipFileName;
            $pathToSrcFolder = realpath("../files/tmp/".$demoPath);
    
            $zip = new ZipArchive();
            $zip->open($pathToNewZipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    
            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $srcFiles = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($pathToSrcFolder),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($srcFiles as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($pathToSrcFolder) + 1);
    
                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }
            // Zip archive will be created only after closing object
            $zip->close();
            
            $response = ["status"=>"OK", "zip_file"=>$zipFileName];
            return $response;
        } catch (\Throwable $th) {
            $response = ["status"=>"ERROR", "ERROR"=>$th];
            return $response;
        }
    }

    function copy_template_to_tmp_folder($templateFolder, $dba){
        try {
            $src = "../files/templates/{$templateFolder}";
            $dst = "../files/tmp/{$dba}";
            custom_copy($src, $dst);
            return "OK";
        } catch (\Throwable $th) { return "ERROR"; }
    }

    # -----------------------------
    # -- Update data on website_data.js
    # -----------------------------
    function updateWebsiteDataJS($pathToTemplateJS, $mainTgln, $subTgln, $nicheTitle = "", $postdata, $updateCreated = 0){
        $pathToWebsiteDataJS = $pathToTemplateJS."website-data.js";
        $newWebsiteDataTxt = '';

        $originalJSFile = fopen($pathToWebsiteDataJS, "r") or die("Unable to open JS 1 file!");
        $originalWebsiteDataTxt = fread($originalJSFile, filesize($pathToWebsiteDataJS));
        fclose($originalJSFile);
        
        $txtArray = explode("\n", $originalWebsiteDataTxt);
        
        // - Replace taglines on website-data.js
        foreach ($txtArray as $i => $ln) {
            switch (true) {
                case str_contains($ln, "MAIN_TAGLINE ="):
                    $mainTgln = str_replace("'", "\'", $mainTgln);
                    $txtArray[$i] = "const MAIN_TAGLINE = '{$mainTgln}'";
                    break;
                case str_contains($ln, "SECONDARY_TAGLINE ="): 
                    $subTgln = str_replace("[TYPE]", ucfirst($nicheTitle), $subTgln);
                    $subTgln = str_replace("'", "\'", $subTgln);
                    $txtArray[$i] = "const SECONDARY_TAGLINE = '{$subTgln}'";
                    break;
                default: break;
            }
        }
        
        // - Delete first 9 lines
        if($updateCreated == 0){
            for ($i=0; $i < 9; $i++) { 
                unset($txtArray[$i]);
            }
        }

        // - Turn from array to string
        foreach ($txtArray as $ln) {
            $newWebsiteDataTxt .= $ln."\n";
        }

        // - Add signer info
        if($updateCreated == 0){
            $newJsSignerData = createJSValues($postdata);
            $newWebsiteDataTxt = $newJsSignerData.$newWebsiteDataTxt;
        }
        
        $websiteDataFile = fopen($pathToWebsiteDataJS, "w") or die("Unable to open JS 2 file!");
        fwrite($websiteDataFile, $newWebsiteDataTxt);
        fclose($websiteDataFile);
        // $newTemplateOptions["newWebsiteDataTxt"] = $newWebsiteDataTxt;
        return $newWebsiteDataTxt;
    }

    # -----------------------------
    # -- Replace colors on CSS file
    # -----------------------------
    function updateVarsCss($pathToTemplateCSS, $newColors, $template_installed_folder, $updateCreated = 0){
        try {
            $pathToVarsCssFile = $pathToTemplateCSS."vars.css";
            unlink($pathToVarsCssFile);
            copy("../files/templates/".$template_installed_folder."css/vars.css", $pathToVarsCssFile);
            $originalVarsCssFile = fopen($pathToVarsCssFile, "r") or die("Unable to open CSS 1 file!");
            $originalVarsCssTxt = fread($originalVarsCssFile, filesize($pathToVarsCssFile));
            fclose($originalVarsCssFile);
    
            // if($updateCreated == 1){
            //     $colorsArr = $newColors;
            // } elseif ($updateCreated == 0) {
            $colorsArr = json_decode(json_encode($newColors), true);
            // }
            $debug = [];
            $newVarsCssTxt = $originalVarsCssTxt;
            foreach ($colorsArr as $c) {
                $newVarsCssTxt = str_replace("brand-color: ".$c["color"], "brand-color: ".$c["custom"], $newVarsCssTxt);
                array_push($debug, $c);
            }
    
            $originalVarsCssFile = fopen($pathToVarsCssFile, "w") or die("Unable to open CSS 2 file!");
            fwrite($originalVarsCssFile, $newVarsCssTxt);
            fclose($originalVarsCssFile);
    
            // $newTemplateOptions["newVarsCss"] = $newVarsCssTxt;
            return $colorsArr;
        } catch (\Throwable $th) {
            return $th;
            print_r($th);
        }
    }

    # -----------------------------
    # -- Replace background images
    # -----------------------------
    function replaceBgs($pathToTemplateImages, $newBgs, $updateCreated = 0){
        $bgsArr = json_decode(json_encode($newBgs), true);
        $bgsFolder = "../files/img/backgrounds/";

        foreach ($bgsArr as $bg) {
            try {
                @unlink($pathToTemplateImages.$bg["original"]);
            } catch (\Throwable $th) {
                $a = $th;
            }
            copy($bgsFolder.$bg["custom"], $pathToTemplateImages.$bg["original"]);
        }
        // return $pathToTemplateImages.$bg["original"];
    }

    // STATUS: OK
    // TO DO:
    // * Create JS website_data.js
    //     * Add website and signer info
    //     * Add taglines
    // * Add colors to CSS file 
    // * Replace background images
    // * Send link of demo website
    function createWebsite($templateId, $nicheId, $url, $products){
        $time = date("Y-m-d H:i:s", substr(time(), 0, 10));
        $ip = $_SERVER['REMOTE_ADDR'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        
        try {
            $templateOptions = getQuery("SELECT * FROM template WHERE id = '{$templateId}' AND status = 1")[0];
            $newTemplateOptions = getCustomizationData($templateOptions, $nicheId);
            
            $nicheTitle = getQuery("SELECT title FROM niche WHERE id = '{$nicheId}'")[0]["title"];

            $uid = substr(uniqid(), 6);
            $newSiteFolder = str_replace(".com", "", $url)."_".$uid.".com";
            // $newSiteFolder = "MySite_c3a3439.com";
            $pathToTemplateImages = "../files/tmp/{$newSiteFolder}/img/";
            $pathToTemplateJS = "../files/tmp/{$newSiteFolder}/js/";
            $pathToTemplateCSS = "../files/tmp/{$newSiteFolder}/css/";

            // // - Copy template folder to new site folder: "( url + uniqid() )"
            copy_template_to_tmp_folder($templateOptions["installation_folder"], $newSiteFolder);

            updateWebsiteDataJS($pathToTemplateJS, $newTemplateOptions["mainTgln"], $newTemplateOptions["subTgln"], $nicheTitle, $_POST);

            updateVarsCss($pathToTemplateCSS, $newTemplateOptions["colors"], $templateOptions["installation_folder"]);

            replaceBgs($pathToTemplateImages, $newTemplateOptions["bgs"]);
            
            if($products == "upload"){
                $uploaded = uploadProductsFiles($pathToTemplateImages, $pathToTemplateJS, $uid);
            }

            $sql = "INSERT INTO log_website_builder (id, user, time, ip, browser, url, type, products, action) VALUES (UUID(), '{$_POST["user_id"]}', '$time', '$ip', '$browser', '{$_POST['url']}', '{$_POST['niche']}', '{$_POST['products']}', 'create')";
            addQuery($sql);
            $response = ["status"=>"OK", "params"=>$newTemplateOptions, "demoPath"=>$newSiteFolder, "url"=>$url];
            return $response;
        } catch (\Throwable $th) {
            $error = json_encode($th);
            $sql = "INSERT INTO log_website_builder (id, user, time, ip, browser, url, type, products, action, error) VALUES (UUID(), '{$_POST["user_id"]}', '$time', '$ip', '$browser', '{$_POST['url']}', '{$_POST['niche']}', '{$_POST['products']}', 'create', '$error')";
            addQuery($sql);
            print_r($th);
        }
    }

    # -----------------------------
    # -- Add products to website 
    # -----------------------------
    function uploadProductsFiles($pathToTemplateImages, $pathToTemplateJS, $uid){
        // - Delete product imgs from new site folder
        $scanImgsFolder = scandir($pathToTemplateImages);
        foreach ($scanImgsFolder as $f) {
            if(str_contains($f, "img")){
                unlink($pathToTemplateImages.$f);
            }
        }
        // - Delete products.js from new site folder
        unlink($pathToTemplateJS."data/products.js");

        // Upload products zip
        $uploadsDir = "../files/uploads/";
        $newZipName = str_replace(".zip", "", $_FILES["productsFile"]["name"])."_".$uid.".zip";
        $newFolderName = str_replace(".zip", "", $newZipName);
        move_uploaded_file($_FILES["productsFile"]["tmp_name"], $uploadsDir.$newZipName);

        // Uncompress products zip
        // foreach ($uploaded as $u) {
        $productsZip = new ZipArchive;
        $zipRes = $productsZip->open($uploadsDir.$newZipName);
        if ($zipRes === TRUE) {
            $productsZip->extractTo($uploadsDir.$newFolderName);
            $productsZip->close();
        }
        // }

        // Move images and products.js to new site folder
        $newFiles = scandir($uploadsDir.$newFolderName);
        $imgs = [];
        foreach ($newFiles as $nf) {
            if(str_contains($nf, "img")){
                copy($uploadsDir.$newFolderName."/".$nf, $pathToTemplateImages.$nf);
                array_push($imgs, $uploadsDir.$newFolderName."/".$nf);
            } elseif (str_contains($nf, "products.js")) {
                copy($uploadsDir.$newFolderName."/".$nf, $pathToTemplateJS."data/".$nf);
            }
        }

        // Edit produtcs.js priceMessages syntax
        fixPriceMessages($pathToTemplateJS."data/products.js");
        return $newZipName;
    }

    function fixPriceMessages($pathToNewProductsJs){
        $oldFile = fopen($pathToNewProductsJs, "r") or die("Unable to open file!");
        $oldText = fread($oldFile, filesize($pathToNewProductsJs));
        fclose($oldFile);
    
        $newText = str_replace('"priceMessages', "priceMessages", $oldText);
        $newText = str_replace('.price"', ".price", $newText);
        $newText = str_replace('.incog"', ".incog", $newText);
        $newText = str_replace('.mdog"', ".mdog", $newText);
        $newText = str_replace('.j9"', ".j9", $newText);
        $newText = str_replace('.discount', '.discount + " ', $newText);
    
        $newFile = fopen($pathToNewProductsJs, "w") or die("Unable to open file!");
        fwrite($newFile, $newText);
        fclose($newFile);
    }

    function createJSValues($post){
        // create dba name
        $website_name = preg_split('/(?=[A-Z])/', $post['url'], -1, PREG_SPLIT_NO_EMPTY);
        $name_txt = "";
        foreach ($website_name as $str) {
            if(str_contains($str, ".com")){
                $name_txt .= str_replace(".com", "", $str);
            } else {
                $name_txt .= $str." ";
            }
        }

        // $js = "export const WEBSITE_NAME = '{$post['url']}';\n";
        $js = "export const WEBSITE_NAME = '{$name_txt}';\n";

        $js .= "export const WEBSITE_URL = '{$post['url']}';\n";
        $js .= "export const WEBSITE_PHONE = '{$post['phone']}';\n";
        $js .= "export const WEBSITE_DESCRIPTOR = '{$post['descriptor']}';\n";
        $js .= "export const WEBSITE_EMAIL = 'support@{$post['url']}';\n";
        // $js .= "export const WEBSITE_CORP = '{$post['corp']}';\n";
        $js .= 'export const WEBSITE_CORP = "'.$post['corp']."\";\n";
        $js .= "export const WEBSITE_ADDRESS = '{$post['address']}, USA';\n";

        // get return address data
        $returnAddress = getQuery("SELECT title, address FROM return_address WHERE id = '{$post['return_address']}'")[0];
        $js .= "export const WEBSITE_RETURN_ADDRESS = '{$returnAddress['address']}';\n";
        $js .= "export const WEBSITE_FULFILLMENT = '{$returnAddress['title']}';\n";
        return $js;
    }

    function shuffleData($templateId, $niche){
        try {
            $templateOptions = getQuery("SELECT * FROM template WHERE id = '{$templateId}'")[0];
            $newTemplateOptions = getCustomizationData($templateOptions, $niche);
    
            $response = ["status"=>"OK", "params"=>$newTemplateOptions];
            return $response;
        } catch (\Throwable $th) {
            print_r($th);
        }
    }

    function getCustomizationData($templateOptions, $niche){
        // GET niche title 
        // $templateOptions["nicheTitle"] = getQuery("SELECT title FROM niche WHERE id = '{$niche}'")[0]["title"];
        // DEFAULT niche for subtagline
        $subTgln = getQuery("SELECT tagline FROM tagline WHERE niche = '316ad966-fd09-11ee-886a-acde48001122' ORDER BY RAND() LIMIT 1")[0]["tagline"];
        $mainTgln = getQuery("SELECT tagline FROM tagline WHERE niche = '{$niche}' ORDER BY RAND() LIMIT 1")[0]["tagline"];

        // array_map()
        $templateOptions["colors"] = array_map(function($color){
            $colorData = getQuery("SELECT color, type FROM color WHERE type = '$color->colorType' ORDER BY RAND() LIMIT 1")[0];
            $color->custom = $colorData["color"];
            return $color;
        }, json_decode($templateOptions["colors"]));

        // print_r($templateOptions["bgs"]);
        $templateOptions["bgs"] = array_map(function($bg) use ($niche){
            $bgData = getQuery("SELECT fileId FROM background WHERE niche = '{$niche}' ORDER BY RAND()")[0];
            $bgObj = new stdClass();
            $bgObj->custom = $bgData["fileId"];
            $bgObj->original = $bg;
            return $bgObj;
        }, json_decode($templateOptions["bgs"]));
        
        $templateOptions["mainTgln"] = $mainTgln;
        $templateOptions["subTgln"] = $subTgln;
        return $templateOptions;
    }

    function custom_copy($src, $dst) {  
        // open the source directory 
        $dir = opendir($src);  
        // Make the destination directory if not exist 
        @mkdir($dst);  
        // Loop through the files in source directory 
        foreach (scandir($src) as $file) {  
            if (( $file != '.' ) && ( $file != '..' )) {  
                // Recursively calling custom copy function for sub directory  
                if ( is_dir($src . '/' . $file) ) { custom_copy($src . '/' . $file, $dst . '/' . $file); }
                else { copy($src . '/' . $file, $dst . '/' . $file); }
            }  
        }  
        closedir($dir); 
    }   

    function shuffleCustom($input_name, $input_type, $niche){
        switch ($input_name) {
            case 'mainTgln':
                $v = getQuery("SELECT tagline FROM tagline WHERE niche = '$niche' ORDER BY RAND() LIMIT 1")[0];
                break;
            case 'subTgln':
                $v = getQuery("SELECT tagline FROM tagline WHERE niche = '316ad966-fd09-11ee-886a-acde48001122' ORDER BY RAND() LIMIT 1")[0];
                break;
            case 'color':
                $v = getQuery("SELECT color FROM color WHERE type = '$input_type' ORDER BY RAND() LIMIT 1")[0];
                break;
            case 'img':
                $v = getQuery("SELECT fileId FROM background WHERE niche = '$niche' ORDER BY RAND() LIMIT 1")[0];
                break;
            default: break;
        }
        $response = ["status"=>"OK", "value"=>$v];
        return $response;
    }

    function updateCreated($postdata){
        $folderName = $postdata["demoPath"];
        $pathToTemplateJS = "../files/tmp/$folderName/js/";
        $pathToTemplateCSS = "../files/tmp/$folderName/css/";
        $pathToTemplateImages = "../files/tmp/$folderName/img/";
        
        updateWebsiteDataJS($pathToTemplateJS, $postdata["mainTgln"], $postdata["subTgln"], "", "", 1);
        
        $colors = json_decode($postdata["colors"]);
        $colorsUpdate = updateVarsCss($pathToTemplateCSS, $colors, $postdata["installation_folder"], 1);

        $bgs = json_decode($postdata["bgs"]);
        replaceBgs($pathToTemplateImages, $bgs);

        $response = ["status"=>"OK", "updated"=>"count updated", "colors"=>$colorsUpdate];
        return $response;
    }
?>