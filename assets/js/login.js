// function login() {
//     loginData = $("#login").serializeArray();
//     $.post("server/login.php", loginData, (data)=>{
//         // console.log(data); return;
//         response = JSON.parse(data)
//         if(response.status == "OK"){
//             location.assign((window.location.pathname).replace("login.php", ""))
//         } else {
//             console.log(response.status);
//         }
//     })
// }

function login() {
    loginData = $("#login").serializeArray();
    
    // GUI
    GUI_controlAll(0, ".login")
    $(".status-loading").removeClass("d-none")
    $(".login-success").addClass("d-none")
    $(".login-fail").addClass("d-none")

    $.post("server/login.php", loginData, (data)=>{
        console.log(data);
        response = JSON.parse(data)
        if(response.status == "OK"){
            $(".status-loading").addClass("d-none")
            $(".login-success").removeClass("d-none")
            setTimeout(() => {
                location.assign((window.location.pathname).replace("login.php", ""))
            }, 1000);
        } else {
            GUI_controlAll(1, ".login")
            $(".status-loading").addClass("d-none")
            $(".login-fail").removeClass("d-none")
            console.log(response.status);
        }
    })
}

function logout() {
    $.post("../server/login.php", {"service": "logout"}, (data)=>{
        try {
            response = JSON.parse(data)
            if(response.status == "OUT"){
                location.reload()
            }    
        } catch (error) { console.log(data, error); }
    })
    
}

$("#togglePassword").click(()=>{
    password_toggle = $("#togglePassword")
    inputType = $("#password").attr("type")

    $("#togglePassword").toggleClass("bi-eye-slash")
    $("#togglePassword").toggleClass("bi-eye")
    switch (inputType) {
        case "password":
            $("#password").attr("type", "text")
            break;
        case "text":
            $("#password").attr("type", "password")
            break;
        default: break;
    }
})