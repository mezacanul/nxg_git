function search_domain(){
    var send = $("#domain_search").serializeArray()
    console.log(send);
    // return

    $(".loading-search").removeClass("d-none")
    $(".domain-unavailable-notice").addClass("d-none")
    $(".domain-available-notice").addClass("d-none")
    
    $.post("https://eduardomeza.com/demos/namecheap_api/", send).then((data)=>{
        $(".loading-search").addClass("d-none")
        try {
            response = JSON.parse(data)
            if(response.available == "true"){
                $(".domain-available-notice").removeClass("d-none")
                $(".domain-unavailable-notice").addClass("d-none")
            } else {
                $(".domain-available-notice").addClass("d-none")
                $(".domain-unavailable-notice").removeClass("d-none")
            }
            // console.log("data");
            console.log(response);
        } catch (error) {
            console.log("error");
            console.log(data);
        }
    })
}

function get_suggested_domain() {
    var send = {
        niche: $("#niche").val()
    }
    
    $.post("../server/namecheap_helper.php", send).then((data)=>{
        try {
            var response = JSON.parse(data)
            $("#domain-search").val(response.domain)
            console.log(response.domain)
        } catch (error) {
            console.log("Error");
            console.log(data);
        }
    })
}

function addNamecheapAcct() {
    var form = document.getElementById("accountDetails")
    
    if(form.checkValidity()){
        $(".btn-add").attr("disabled", "disabled")
        var send = $(form).serializeArray()
        send.push({ name: "service", value: "add-account"})
        console.log(send);

        $.post("../server/namecheap.php", send).then((data)=>{
            // console.log(data);
            // return
            try {
                var response = JSON.parse(data)
                if(response.status == "OK"){
                    $(".status-info").removeClass("d-none")

                    setTimeout(() => {
                        location.assign("namecheap_acct.php")
                    }, 2000);
                }
            } catch (error) {
                alert("error")
                console.log("error: ");
                console.log(error);
                console.log(data);
            }
        })
    } else {
        form.reportValidity()
    }
}