function get_suggested_phone() {
    $("#phone").attr("disabled", "disabled")
    $("#get-phone").attr("disabled", "disabled")
    $(".phone-search").removeClass("d-none")
    $(".phone-available-notice").addClass("d-none")

    $.post("../server/twilio_helper.php").then((data)=>{
        try {
            var response = JSON.parse(data)
            $("#phone").val(response.phone)

            $("#get-phone").removeAttr("disabled")
            $("#phone").removeAttr("disabled")
            $(".phone-search").addClass("d-none")
            $(".phone-available-notice").removeClass("d-none")
            console.log(response)
        } catch (error) {
            console.log("Error")
            console.log(data)
        }
    })
}