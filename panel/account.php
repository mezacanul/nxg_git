<?php 
    require_once("../server/main.php");
    $userid = $_SESSION["userid"];
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <?php
            // if($corpId == ""){
                include("../components/userForm.php");
            // } else {
            //     include("../components/corpDetails.php");
            // }
            ?>
        </div>
    </main>
</body>


<?php include("../components/footer.php") ?>
<script src="../assets/js/login.js"></script>