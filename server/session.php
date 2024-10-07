<?php
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_SESSION["id"]) != 1){
        try {
            $cwd = getcwd();
            if(str_contains($cwd, "panel")){ 
                $main_dir = "../"; 
            }  else { 
                $main_dir = ""; 
            }
            header("Location: {$main_dir}login.php");
        } catch (\Throwable $th) {
            print_r($th);
        }
    }
}
?>