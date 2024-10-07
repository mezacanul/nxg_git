function proceed_website_builder() {
    var domain = $("#domain-search").val()
    var phone = $("#phone").val()
    var corp = $("#corp").val()
    var niche = $("#niche").val()
    if(domain == "" || phone == ""){
        alert("Enter a domain and a phone number to proceed")
    } else {
        location.assign(`website_builder.php?domain=${domain}&phone=${phone}&corp=${corp}&niche=${niche}`)
    }
}