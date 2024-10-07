function addNewSigner() {
    var form = document.getElementById("signerDetails")
    
    // setTimeout(() => {
    //     $(".status-loading").addClass("d-none")
    //     $(".status-info").removeClass("d-none")
    // }, 2000);
    // return
    if(form.checkValidity()){
        var send = $(form).serializeArray()
        send.push({ name: "service", value: "add-signer"})
        console.log(send);

        // GUI flow
        $(".btn-add").attr("disabled", "disabled")
        $("input").attr("disabled", "disabled")
        $(".status-loading").removeClass("d-none")

        $.post("../server/add-services.php", send).then((data)=>{
            try {
                var response = JSON.parse(data)
                console.log(response);
                // GUI flow
                $(".status-loading").addClass("d-none")

                if(response.status == "OK"){
                    if(response.added == 1){
                        // GUI flow
                        $(".status-info").removeClass("text-secondary")
                        $(".status-info").addClass("text-success")
                        $(".status-info b").html("New Signer Added!")
                        $(".status-info").removeClass("d-none")

                        setTimeout(() => {
                            location.assign("signer.php")
                        }, 2000);
                    } else if(response.added == 0 && response.exists == 1){
                        // GUI flow
                        $(".status-info").removeClass("text-success")
                        $(".status-info").addClass("text-secondary")
                        $(".status-info b").html("Signer already exists...")
                        $(".status-info").removeClass("d-none")
                        $(".btn-add").removeAttr("disabled")
                        $("input").removeAttr("disabled")
                    }
                }
            } catch (error) {
                console.log("error: ");
                console.log(error);
                console.log(data);
            }
        })
    } else {
        form.reportValidity()
    }
}