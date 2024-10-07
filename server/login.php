<?php
    session_start();
    require_once("credentials.php");
    require_once("db-routines.php");

    date_default_timezone_set("America/New_York");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        switch ($_POST["service"]) {
            case 'login':
                try {
                    $email = $_POST["email"];
                    $password = getQuery("SELECT password FROM user WHERE email = '$email';")[0]["password"];
                    if($password == $_POST["password"]){
                        $_SESSION["id"] = session_id();
                        init_login($email);
                        echo json_encode(["status"=>"OK", "session_id"=>session_id()]);
                    } else {
                        // echo json_encode(["status"=>"DENIED"]);
                        echo json_encode(["status"=>"DENIED", "title"=>"Server Error"]);
                    }
                } catch (\Throwable $th) {
                    echo json_encode(["status"=>"ERROR", "title"=>"Server Error", "error"=>$th,]);
                    // print_r($th);
                }
                break;
            case 'logout':
                $time = date("Y-m-d H:i:s", substr(time(), 0, 10));
                updateQuery("UPDATE log_session SET status = 0, closed = '$time' WHERE id = '{$_SESSION["id"]}'");
                session_destroy();
                echo json_encode(["status"=>"OUT"]);
                break;
            default: break;
        }
    }

    function init_login($email){
        $user = getQuery("SELECT id, name, role FROM user WHERE email = '$email'")[0];
        $_SESSION["username"] = $user["name"];
        $_SESSION["userid"] = $user["id"];
        $_SESSION["role"] = $user["role"];

        $ip = $_SERVER['REMOTE_ADDR'];
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $time = date("Y-m-d H:i:s", substr(time(), 0, 10));
        
        $session_id = $_SESSION["id"];
        $user_id = $user["id"];

        addQuery("INSERT INTO log_session (id, user, status, created, ip, browser) VALUES ('$session_id', '$user_id', 1, '$time', '$ip', '$browser')");
        // echo json_encode($user);
    }
?>