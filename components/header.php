<?php 
    // print_r($_SESSION);
    
    $cwd = getcwd();
    try {
        if(str_contains($cwd, "panel")){ $main_dir = "../"; } 
        else { $main_dir = ""; }
    } catch (\Throwable $th) {
        print_r($th);
    }
?>

<style>
    .username {
        margin: 0;
    }
</style>


<header class="w-100 bg-primary">
    <div class="container-fluid d-flex py-4 px-5">
        <div class="col-3">
            <a class="text-white h3 text-decoration-none" href="<?php echo $main_dir ?>">NXG App</a>
        </div>
        <div class="col-9">
            <ul class="nav nav-pills justify-content-end">
                <a class="nav-item d-flex align-items-center" href="<?php echo $main_dir ?>panel/account.php">
                    <p class="nav-link text-white username"><?php echo $_SESSION["username"] ?></p>
                    <i class="bi bi-person fs-4 text-white border border-2 rounded-circle p-1"></i>
                </a>
            </ul>
        </div>
    </div>
    <input type="hidden" name="user_id" value="<?php echo $_SESSION["userid"] ?>">
</header>