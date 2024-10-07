var newTemplateOptions
var templateOptions 

function bootstrapCollapse(cssID) {
    var elemObject = document.querySelector(cssID)
    return bootstrap.Collapse.getOrCreateInstance(elemObject)
}

function uniqueID() {
    return Math.random().toString(16).slice(2, 9)
}

function randNum (min, max) {
    return Math.floor(Math.random() * (max - min) ) + min;
}

function colorPickerElem(color, uid) {
    return `<div class="col-2 p-0 d-flex align-items-center me-3 color-picker-elem" data-id="${uid}" data-current="${color.custom}">
                <input type="color" style='height' class='form-control form-control-color me-2' data-type='${color.colorType}' value='${color.custom}' oninput='updateColorField(this, "${uid}")'>
                <input type="text" placeholder='HEX' class='form-control me-2' value='${color.custom}' oninput='updateColorField(this, "${uid}")'>
                <button class="btn btn-primary h-100" type="button" onclick="shuffleCustomValue('color', '${color.colorType}', '${uid}')">
                    <i class="bi bi-shuffle"></i>
                </button>
            </div>`
}

function imageElem(img, uid){
    return `<div class="col-2 p-0 d-flex align-items-center flex-column image-elem me-3" data-id="${uid}" data-original='${img.original}' data-custom="${img.custom}">
                <img src="../files/img/backgrounds/${img.custom}" class="rounded img-thumbnail mb-2" alt="...">
                <!--<input type="hidden" name="bg" value='${img.custom}'>-->
                <div class="row justify-content-between flex-nowrap w-100">
                    <!--<button class="btn btn-primary col-4">Switch</button>-->
                    <button class="btn btn-primary col-3" type="button" onclick="shuffleCustomValue('img', '', '${uid}')">
                        <i class="bi bi-shuffle"></i>
                    </button>
                    <!--<button class="btn btn-primary col-5">Upload</button>-->
                </div>
            </div>`
}

function resetWebsiteOptions(){
    $("#main-tagline").val("")
    $("#secondary-tagline").val("")
    $("#colors").html("")
    $("#images").html("")
}

function updateColorField(inputElem, uid){
    var newColor = $(inputElem).val()
    $(`[data-id="${uid}"] input`).val(newColor)
}

function create() {
    var formElem = document.getElementById("website_builder")
    var niche = $("[name='niche']").val()
    var user_id = $("[name='user_id']").val()
    // console.log(user_id);
    // return
    
    if(formElem.checkValidity()) {
        var formData = $("#website_builder").serializeArray()
        formData.push({ "name": "service", "value": "create"})
        formData.push({ "name": "user_id", "value": user_id})
        // console.log(formData);
        // debugger
        
        switch ($("#productsSelect").val()) {
            case "upload": formData.push(getProductsFile()); break;
            default: break;
        }
        
        var newFormData = new FormData();
        formData.forEach(fd => {
            // console.log(fd);
            newFormData.append(fd.name, fd.value)
        });
        // console.log(newFormData.entries());
        // entries = newFormData.entries()
        // entries.forEach(e => {
        //     console.log(e);
        // });
        // debugger
        
        $("#demoLink .target").html("")
        $("#wb_actions .spinner-border").removeClass("d-none")
        disableAll()
        
        var ajaxOptions = {
            url: '../server/website_builder.php',
            data: newFormData,
            processData: false,
            contentType: false,
            type: 'POST',
        }

        $.ajax(ajaxOptions).then((data)=>{
            // var niche = $("[name='niche']").val()
        // $.post("../server/website_builder.php", newFormData, (data)=>{
            // var type = $("[name='niche'] option:selected").attr("data-title")
            try {
                // console.log(data);
                response = JSON.parse(data)
                console.log(response);
                // return
                if(response.status == "OK"){
                    resetWebsiteOptions()
                    assignNewValues(response.params, niche, response.demoPath)
                    // $("#demoLinkTarget").html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>')

                    $("#demoLink").attr("href", `../files/tmp/${response.demoPath}`)
                    $("#demoLink").attr("data-path", `${response.demoPath}`)

                    $("#wb_actions .spinner-border").addClass("d-none")
                    enableAll()
                    $("#update-created-btn").attr("disabled", "disabled")

                    $("#demoLink .target").html(response.url)
                    bootstrapCollapse('#template-customization').show()
                    // Global var
                    newTemplateOptions = response.params
                    templateOptions = response.template_options
                    
                    setTimeout(() => {
                        // $("#downloadDemoBtn").removeAttr("disabled")
                    }, 1000);
                }
            } catch (error) { console.log(error, data) }
        })
    } else {
        formElem.reportValidity()
    }
}

function shuffleCustomAll() {
    var niche = $("[name='niche']").val()
    var formData = $("#website_builder").serializeArray()
    formData.push({ "name": "service", "value": "shuffle"})
    
    $.post("../server/website_builder.php", formData, (data)=>{
        // type = $("[name='niche'] option:selected").attr("data-title")
        try {
            // console.log(data);
            var response = JSON.parse(data)
            // console.log(response);
            // return
            if(response.status == "OK"){
                resetWebsiteOptions()
                assignNewValues(response.params, niche)
                $("#update-created-btn").removeAttr("disabled")
            }
        } catch (error) { console.log(error, data) }
    })
}

function assignNewValues(params, niche, demoPath = "none", updateCreated = 0) {
    var type = $("[name='niche'] option:selected").attr("data-title")
    if(demoPath != "none"){ $('[name="demoPath"]').val(demoPath) }
    $("#main-tagline").val(params.mainTgln)
    $("#secondary-tagline").val((params.subTgln).replace("[TYPE]", type))

    if(newTemplateOptions){
        newTemplateOptions["bgs"] = []
        newTemplateOptions["colors"] = []
    }

    var colors = params.colors
    colors.forEach(c => {
        $("#colors").append(colorPickerElem(c, uniqueID()))
        // console.log(c);
        if(newTemplateOptions){
            (newTemplateOptions["colors"]).push(c)
        }
    });

    // if(newTemplateOptions){
    //     newTemplateOptions["colors"] = (newTemplateOptions["colors"]).map((c, i) => {
    //         var templateColor = newTemplateOptions["colors"][i]["color"]
    //         // console.log(templateColor);
    //         // console.log({ colorType: c.colorType, custom: c.custom, color: templateColor});
    //         // return { colorType: c.colorType, custom: c.custom, color: templateColor}
    //         // return { colorType: colors[i].colorType, custom: colors[i].custom, color: templateColor}
    //         // return { colorType: c.colorType, custom: c.custom, color: templateColor}
    //         // console.log("type 1: "+colors[i].colorType)
    //         // console.log("type 2: "+c.colorType)
    //         colorType = colors[i].colorType ? colors[i].colorType : c.colorType
    //         custom = colors[i].custom ? colors[i].custom : c.custom
    //         // console.log({ colorType, custom, color: templateColor});
    //         return { colorType, custom, color: templateColor}
    //     });
    // }

    var bgs = params.bgs
    bgs.forEach(bg => {
        var uid = uniqueID()
        $("#images").append(imageElem(bg, uid))
        // console.log(bg);

        if(newTemplateOptions){
            var original = $(`.image-elem[data-id='${uid}']`).attr("data-original");
            (newTemplateOptions["bgs"]).push({ original, custom: bg.custom})
        }
    });

    // if(newTemplateOptions){
    //     console.log(newTemplateOptions["bgs"]);
    //     console.log(newTemplateOptions["colors"]);
    // }
}

function demo() {
    $("[name='url']").val("MySite.com")
    $("[name='phone']").val("123 456 7890")
    $("[name='corp']").val("My Corporation Inc.")
    $("[name='address']").val("123 North St, South St, My Address, LA 12345")
    setDescriptor()
    setReturnAddress()
}

function setDescriptor() {
    var url = $("input[name='url']").val()
    var phone = $("input[name='phone']").val()
    var descriptorType = $("select[name='descriptorType']").val()
    var descriptor = ""
    
    switch (descriptorType) {
        case "alphanumeric":
            nPhone = phone.replaceAll(" ", "")
            
            descriptor = (nPhone + url).substr(0, 22)
            break;
        case "dba":
            nUrl = url.replace(".com", "")
            
            descriptor = (nUrl).substr(0, 22)
            break;
        case "url":
            descriptor = (url).substr(0, 22)
            break;
        case "dashed":
            nPhone = phone.replaceAll(" ", "-")
            
            descriptor = (nPhone + url).substr(0, 22)
            break;
        case "spaced":
            nUrl = url.split(/(?=[A-Z])/)
            spaced = ""

            nUrl.forEach(l => { spaced += (l + " ") })
            spaced = spaced.replace(".com", "")
            spaced = spaced.substr(0, 22)

            descriptor = spaced
            break;
        default: break;
    }

    $(".descTarget").html(descriptor)
    $("input[name='descriptor']").val(descriptor)
}

function setReturnAddress() {
    returnAddress = $("select[name='return_address'] option:selected").attr("data-address")

    $("input[name='returnAddress']").val(returnAddress)
    $(".raTarget").html(returnAddress)
}

function download() {
    demoPath = $("#demoLink").attr("data-path")
    formData = [
        { "name": "service", "value": "zip_download"},
        { "name": "demoPath", "value": demoPath},
    ]

    disableAll()
    // $("#demoLink .target").adClass("d-none")
    $("#wb_actions .spinner-border").removeClass("d-none")
    $.post("../server/website_builder.php", formData, (data)=>{
        try {
            // console.log(data);
            response = JSON.parse(data)
            console.log(response);
            
            $("#wb_actions .spinner-border").addClass("d-none")
            enableAll()
            $("#zipLinkTarget").attr("href", `../files/zip/${response.zip_file}`)
            document.getElementById("zipLinkTarget").click()
            // $("#zipLinkTarget").click()
        } catch (error) {
            console.log(error, data);
        }
    })
}

function toggleProductsInput(){
    switch ($("#productsSelect").val()) {
        case "upload": $("#productsInput").removeClass("d-none"); break;
        case "dont": $("#productsInput").addClass("d-none"); break;
        default: break;
    }
}

function disableAll() {
    $("button").attr("disabled", "disabled")
    $("input").attr("disabled", "disabled")
    $("select").attr("disabled", "disabled")
    $(".templatePreviewLink").addClass("disabled")
}

function enableAll() {
    $("button").removeAttr("disabled")
    $("input").removeAttr("disabled")
    $("select").removeAttr("disabled")
    $(".templatePreviewLink").removeClass("disabled")
}

function setPreviewBtn() {
    if(templateOptions){
        if(newTemplateOptions["id"] != $("#templateSelect").val()){
            $("#update-created-btn").attr("disabled", "disabled")
            $("#shuffle-all-btn").attr("disabled", "disabled")
        } else {
            $("#update-created-btn").removeAttr("disabled")
            $("#shuffle-all-btn").removeAttr("disabled")
        }
    }
    previewLink = $("#templateSelect").find(":selected").attr("data-preview")
    $(".templatePreviewLink").attr("href", previewLink)
}

function selectRandomTemplate() {
    templatesRef = $("select[name='template']").children()
    templatesRef[randNum(templatesRef.length, 0)].setAttribute("selected", "selected")
    setPreviewBtn()
}

function getProductsFile() {
    files = $("input[name='productsFiles']").prop('files')
    files = Array.from(files)
    productsFile = { "name": "productsFile", "value": files[0]}
    // console.log(files[0]);
    return productsFile
}

function shuffleCustomValue(input_name, input_type = "none", uid = "none") {
    var niche = $("[name='niche']").val()
    var options = {
        service: "shuffleCustom",
        input_name, input_type, niche
    }
    
    $.post("../server/website_builder.php", options).then((data)=>{
        try {
            response = JSON.parse(data)
            assignValue(input_name, response.value, uid)
            $("#update-created-btn").removeAttr("disabled")
        } catch (error) {
            console.log(error, data);
        }
    })
    // console.log(input_name, input_type, niche)
}

function assignValue(input_name, value, uid){
    var type = $("[name='niche'] option:selected").attr("data-title")
    switch (input_name) {
        case "mainTgln":
            $("#main-tagline").val(value.tagline)
            break;
        case "subTgln":
            $("#secondary-tagline").val((value.tagline).replace("[TYPE]", type))
            break;
        case "color":
            $(`.color-picker-elem[data-id='${uid}'] input[type='text']`).val(value.color)
            $(`[data-id="${uid}"] input[type='color']`).val(value.color)

            var current = $(`.color-picker-elem[data-id='${uid}']`).attr("data-current")
            newTemplateOptions["colors"] = newTemplateOptions["colors"].map((ce)=>{
                if(ce.custom == current){ ce.custom = value.color }
                return ce
            })
            break;
        case "img":
            $(`.image-elem[data-id='${uid}'] img`).attr("src", `../files/img/backgrounds/${value.fileId}`)
            
            var original = $(`.image-elem[data-id='${uid}']`).attr("data-original");
            newTemplateOptions["bgs"] = newTemplateOptions["bgs"].map((bg)=>{
                if(bg.original == original){ bg.custom = value.fileId }
                return bg
            })
            break;
        default: break;
    }
}

function updateCreated() {
    var options = $("#website-params").serializeArray()
    options.push({ name: "service", value: "updateCreated" })
    options.push({ name: "installation_folder", value: newTemplateOptions["installation_folder"] })
    options.push({ name: "bgs", value: JSON.stringify(newTemplateOptions["bgs"]) })

    newTemplateOptions["colors"] = (newTemplateOptions["colors"]).map((c, i) => {
        var templateColor = newTemplateOptions["colors"][i]["color"]
        // console.log({ colorType: c.colorType, custom: c.custom, color: templateColor});
        // console.log(c.color);
        return { colorType: c.colorType, custom: c.custom, color: templateColor}
    });
    options.push({ name: "colors", value: JSON.stringify(newTemplateOptions["colors"]) })
    
    // return 
    $.post("../server/website_builder.php", options).then((data)=>{
        try {
            response = JSON.parse(data)
            // console.log(response);
        } catch (error) {
            console.log(error, data);
        }
    })
}

setPreviewBtn()
setDescriptor()
setReturnAddress()