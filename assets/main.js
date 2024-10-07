function GUI_controlAll(state, target) {
    switch (state) {
        case 1:
            $(`${target} input`).removeAttr("disabled")
            $(`${target} button`).removeAttr("disabled")
            $(`${target} select`).removeAttr("disabled")
            break;
        case 0:
            $(`${target} input`).attr("disabled", "disabled")
            $(`${target} button`).attr("disabled", "disabled")
            $(`${target} select`).attr("disabled", "disabled")
            break;
        default:
            break;
    }
}

function bootstrapCollapse(cssID) {
    var elemObject = document.querySelector(cssID)
    return bootstrap.Collapse.getOrCreateInstance(elemObject)
}

function copy_website_row(websiteID) {
    var websiteDATA = {
        dba: $(`[data-website-id='${websiteID}'] .td-dba`).html(),
        hostinger: $(`[data-website-id='${websiteID}'] .td-hostinger`).html(),
        phone: $(`[data-website-id='${websiteID}'] .td-phone`).html()
    }
    var text = `${websiteDATA.dba}\t${websiteDATA.hostinger}\t${websiteDATA.phone}\thostinger: support@${websiteDATA.dba} pw: YoozHP0304!`
    navigator.clipboard.writeText(text)
    $(`[data-website-id='${websiteID}'] .btn-copy`).removeClass("bi-clipboard-plus")
    $(`[data-website-id='${websiteID}'] .btn-copy`).addClass("text-success")
    $(`[data-website-id='${websiteID}'] .btn-copy`).addClass("bi-clipboard-check")
}