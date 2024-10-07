function validateNamecheapAccount() {
    var send = [
        { name: "api", value: "namecheap" },
        { name: "service", value: "validate_account" },
        { name: "signer", value: $("[name='signer']").val() },
    ]
    console.log(send);
    GUI_controlAll(0, "#signer_details")
    GUI_controlAll(0, "#new_domain_actions")
    $(".no-namecheap-account-info").addClass("d-none")
    $(".nc_check_warnings .status-loading").removeClass("d-none")
    
    $.post("https://eduardomeza.com/demos/namecheap_api/buy_domain.php", send).then((data)=>{
        $(".nc_check_warnings .status-loading").addClass("d-none")

        try {
            var response = JSON.parse(data)
            console.log(response);
            if(response.count == 1){
                GUI_controlAll(1, "#signer_details")
                GUI_controlAll(1, "#new_domain_actions")
                
                var signerCorps = response.signerCorps
                $("[name='corp']").html("<option value>Select Corp</option>")
                signerCorps.forEach(sc => {
                    $("[name='corp']").append(`<option value="${sc.id}">${sc.title}</option>`)
                });

                var nc_id = response.nc_account.id
                $(`[name='nc_account'] option[value='${nc_id}']`).attr("selected", "selected")

            } else if(response.count == 0){
                $(".no-namecheap-account-info").removeClass("d-none")
                $("[name='signer']").removeAttr("disabled")
            }
        } catch (error) {
            console.log(data);
        }
    })
}

function get_suggested_domain() {
    var form_signer_details = document.getElementById("signer_details")
    if(!form_signer_details.checkValidity()){
        form_signer_details.reportValidity()
        return
    }
    
    var form_new_domain_actions = document.getElementById("new_domain_actions")
    if(!form_new_domain_actions.checkValidity()){
        form_new_domain_actions.reportValidity()
        return
    }

    var send = {
        niche: $("#select-niche").val()
    }

    // GUI
    GUI_controlAll(0, "#signer_details")
    GUI_controlAll(0, "#new_domain_actions")
    // $(".nc_check_warnings .status-success").addClass("d-none")
    $(".nc_check_warnings .status-loading").removeClass("d-none")
    // return
    
    $.post("../server/namecheap_helper.php", send).then((data)=>{
        try {
            var response = JSON.parse(data)
            $("#signer_details [name='dba']").val(response.domain)
            // console.log(response.domain)

            // GUI
            $(".nc_check_warnings .status-loading").addClass("d-none")
            GUI_controlAll(1, "#signer_details")
            GUI_controlAll(1, "#new_domain_actions")
        } catch (error) {
            console.log("Error");
            console.log(data);
        }
    })
}

function namecheap_search_domain(){
    if($("#signer_details [name='dba']").attr("type") == "text"){
        var domain = $("#signer_details [name='dba']").val()
    } else {
        var domain = $("#signer_details [name='dba'] option:selected").attr("data-dba")
    }

    $("#namecheap_register [name='nc_account']").removeAttr("disabled")
    // var domain = 
    var send = [
        { name: "api", value: "namecheap" },
        { name: "service", value: "check_available" },
        { name: "nc_account", value: $("#namecheap_register [name='nc_account']").val() },
        { name: "domain", value: domain },
        { name: "websiteID", value: $("#signer_details [name='dba'] option:selected").val() },
    ]
    $("#namecheap_register [name='nc_account']").attr("disabled", "disabled")
    // console.log(send);
    // return
    
    // GUI
    $(".nc_check_warnings .status-success").addClass("d-none")
    $(".nc_check_warnings .status-unavailable").addClass("d-none")
    $(".nc_check_warnings .status-loading").removeClass("d-none")
    // $(".nc_btn-check").attr("disabled", "disabled")
    GUI_controlAll(0, "#signer_details")
    GUI_controlAll(0, "#new_domain_actions")
    
    $.post("https://eduardomeza.com/demos/namecheap_api/buy_domain.php", send).then((data)=>{
        try {
            console.log(data);
            response = JSON.parse(data)
            console.log(response);
            // return
            if(response.status == "ok"){
                $(".nc_check_warnings .status-loading").addClass("d-none")
                
                if(response.available == "true" && response.isPremiumName == "false"){
                    $(".nc_check_warnings .status-success").removeClass("d-none")
                    // $(".nc_btn-check").removeAttr("disabled")
                    bootstrapCollapse('#twilioSetup').show()
                    $("[data-text-target='dba']").html(`${domain}`)
                    
                    if($("[name='corp']").attr("type") == "hidden"){
                        var corpTitle = $("[name='corpTitle']").val()
                    } else {
                        var corpTitle = $("[name='corp'] option:selected").html()
                    }
                    $("[data-text-target='corp']").html(`"${corpTitle}"`)
                } else {
                    $(".nc_check_warnings .status-unavailable").removeClass("d-none")
                    // $(".nc_check_warnings .status-success").removeClass("d-none")
                    // $(".nc_check_warnings .status-loading").addClass("d-none")
                    // alert("domain is not available")
                }
                GUI_controlAll(1, "#signer_details")
                GUI_controlAll(1, "#new_domain_actions")
            }
        } catch (error) {
            console.log("error");
            console.log(data);
        }
    })
}

function twilio_get_new_phone(){
    var send = [
        { name: "api", value: "twilio" },
        { name: "service", value: "get_new_phone" }
    ]

    // GUI
    $("#btn-twilio-register").attr("disabled", "disabled")
    $("#twilio [name='phone']").val("")
    $("#twilio [name='phone']").attr("disabled", "disabled")
    $(".twilio_available_warning .phone-available-notice").addClass("d-none")
    $(".twilio_available_warning .status-loading").removeClass("d-none")

    $.post("https://eduardomeza.com/demos/namecheap_api/buy_domain.php", send).then((data)=>{
        try {
            var response = JSON.parse(data)
            if(response.status == "ok"){
                $("#twilio [name='phone']").val(response.tollFreeRecord)

                // GUI
                $("#twilio [name='phone']").removeAttr("disabled")
                $(".twilio_available_warning .status-loading").addClass("d-none")
                $(".twilio_available_warning .phone-available-notice").removeClass("d-none")
                $("#btn-twilio-register").removeAttr("disabled")
                bootstrapCollapse("#twilio_info").show()
            }
        } catch (error) {
            alert("ERROR: check console")
            console.log(error);
            console.log(data);
        }
    })
}

function twilio_register(){
    var send = [
        { name: "api", value: "twilio" },
        { name: "service", value: "register" },
        { name: "record", value: $("#twilio [name='phone']").val() },
        // { name: "friendlyName", value: friendlyName },
        { name: "websiteID", value: $("#signer_details [name='dba'] option:selected").val() },
        { name: "action", value: $("#signer_details input[name='action']").val() },
        { name: "hostinger", value: $("[name='hostinger']").val() }
    ]
    // console.log(send);
    // return

    if($("#signer_details input[name='action']").val() == "new"){
        var friendlyName = $("#signer_details [name='dba']").val()
        send.push({ name: "corp", value: $("#signer_details [name='corp']").val() })
        send.push({ name: "niche", value: $("#new_domain_actions [name='niche']").val() })
        send.push({ name: "bank_website", value: $("#new_domain_actions [name='bank_website']").val() })
    } else {
        var friendlyName = $("#signer_details [name='dba'] option:selected").attr("data-dba")
    }
    send.push({ name: "friendlyName", value: friendlyName })
    console.log(send);
    // return

    // GUI
    // $("#btn-twilio-register").attr("disabled", "disabled")
    // $("#twilio [name='phone']").attr("disabled", "disabled")
    GUI_controlAll(0, "#signer_details")
    GUI_controlAll(0, "#new_domain_actions")
    GUI_controlAll(0, "#signer_details")
    GUI_controlAll(0, "#twilioSetup")

    $(".twilio_register_warning .status-success").addClass("d-none")
    $(".twilio_register_warning .status-loading").removeClass("d-none")

    $.post("https://eduardomeza.com/demos/namecheap_api/buy_domain.php", send).then((data)=>{
        console.log(data);
        // GUI_controlAll(1, "#signer_details")
        // GUI_controlAll(1, "#new_domain_actions")
        // GUI_controlAll(1, "#signer_details")
        // GUI_controlAll(1, "#twilioSetup")
        try {
            var response = JSON.parse(data)
            if(response.status == "ok"){
                $("#signer_details").append(`<input type="hidden" name="websiteID" value="${response.websiteID}">`)
                
                // GUI
                $(".twilio_register_warning .status-loading").addClass("d-none")
                $(".twilio_register_warning .status-success").removeClass("d-none")
                bootstrapCollapse("#namecheapSetup").show()
            }
        } catch (error) {
            alert("ERROR: check console")
            console.log(error);
            console.log(data);
        }
    })
}

function namecheap_register() {
    var send = [
        { name: "api", value: "namecheap" },
        { name: "service", value: "register" },
        { name: "nc_account", value: $("#namecheap_register [name='nc_account']").val() },
        // { name: "domain", value: $("#signer_details [name='dba'] option:selected").attr("data-dba") },
        // { name: "websiteID", value: $("#signer_details [name='dba'] option:selected").val() },
    ]

    if($("#signer_details input[name='action']").val() == "new"){
        send.push({ name: "domain", value: $("#signer_details [name='dba']").val() })
        send.push({ name: "websiteID", value: $("#signer_details [name='websiteID']").val() })
    } else {
        send.push({ name: "domain", value: $("#signer_details [name='dba'] option:selected").attr("data-dba") })
        send.push({ name: "websiteID", value: $("#signer_details [name='dba'] option:selected").val() })
    }

    // console.log(send);
    // return

    // $("#namecheap_register select").attr("disabled", "disabled")
    // $("#namecheap_register button").attr("disabled", "disabled")
    GUI_controlAll(0, "#namecheap_register")
    $(".nc_register_warnings .status-loading").removeClass("d-none")
    
    $.post("https://eduardomeza.com/demos/namecheap_api/buy_domain.php", send).then((data)=>{
        try {
            var response = JSON.parse(data)
            console.log(response);
            if(response.status == "ok"){
                $(".nc_register_warnings .status-loading").addClass("d-none")
                $(".nc_register_warnings .status-success").removeClass("d-none")
                bootstrapCollapse(".btn-website-builder-container").show()
                $(".btn-website-builder-container a").attr("href", `website_builder.php?websiteID=${response.websiteID}`)
            }
        } catch (error) {
            console.log("error");
            console.log(data);
        }
    })
}

// bootstrapCollapse("#namecheapSetup").show()
// bootstrapCollapse("#twilioSetup").show()
// bootstrapCollapse(".btn-website-builder-container").show()