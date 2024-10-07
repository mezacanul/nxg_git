function addNewDomains(){
    $(".valid-domains").html("")
    $(".invalid-domains").html("")
    $("#add-btn").attr("disabled", "disabled")

    if($("#domain").val() == ""){
        alert("Enter at least 1 domain")
        return
    }

    var domainsSrc = ($("#domain").val()).split("\n")
    var validDomains = domainsSrc.filter((d)=>{
        return (d.includes(".com")) && (d != "")
    })
    var invalidDomains = domainsSrc.filter((d)=>{
        return (!d.includes(".com")) && (d != "")
    })

    // validDomains.forEach(vdmn => {
    //     $(".valid-domains").append(`<p class="text-success mb-1">${vdmn}</p>`)
    // });
    
    $(".domains-added").removeClass("d-none")
    $(".domains-not-added").removeClass("d-none")

    var send = {
        domains: validDomains,
        service: "add-domains",
        niche: $("#niche").val()
    }

    if(validDomains.length > 0){
        $.post("../server/domain.php", send).then((data)=>{
            try {
                var response = JSON.parse(data)
                console.log(response);
    
                if(response.status == "OK"){
                    (response.added).forEach(dmn => {
                        $(".valid-domains").append(`<p class="text-success mb-1">${dmn}</p>`)
                    })
        
                    invalidDomains.forEach(ivdmn => {
                        $(".invalid-domains").append(`<p class="text-danger mb-1">${ivdmn} (invalid domain)</p>`)
                    });
                    (response.notAdded).forEach(dmn => {
                        $(".invalid-domains").append(`<p class="text-secondary mb-1">${dmn} (already exists)</p>`)
                    })
                }
            } catch (error) {
                console.log("Error: ", error);
                console.log(data);
            }
        })
    } else {
        invalidDomains.forEach(ivdmn => {
            $(".invalid-domains").append(`<p class="text-danger mb-1">${ivdmn} (invalid domain)</p>`)
        });
    }
}

function enableAddBtn() {
    $("#add-btn").removeAttr("disabled")
}