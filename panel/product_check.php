<?php 
    require_once("../server/main.php");
    $query = getQueryObject();
    // print_r($query);
?>

<?php include("../components/head.php") ?>

<body class="bg-light">
    <?php include("../components/header.php") ?>
    
    <main class="my-3">
        <!-- APP -->
        <div class="container py-5">
            <section class='mb-5'>
                <h2 class="mb-5">Product Check</h2>
                <div class="row">
                    <input type="text" class="form-control w-auto me-2" placeholder="URL" name="url">
                    <button type="button" class="btn btn-primary w-auto me-2 btn-search" onclick="checkProducts()">Search</button>
                    <button class="btn btn-primary w-auto me-2 btn-copy-table" onclick="copyTable()" disabled>Copy Table</button>
                </div>
            </section>

            <div class="spinner-border spinner-border text-primary p-0 status-loading mb-1 d-none" role="status"></div>
            <p class="error-text d-none">No products available...</p>
            <?php include("../components/productsCheckTable.php"); ?>
        </div>
    </main>
</body>

<script type="text/javascript" src="https://thebestproductmanager.com/products/prices-nxg-object"></script>
<script src="../assets/js/website.js"></script>
<?php include("../components/footer.php") ?>


<script>
    function makeProductHTML (product){
        var str = "<tr>"
        str += `<td>${product.name}</td>`
        str += `<td>${product.price}</td>`
        // str += `<td>${product.image}</td>`
        str += "</tr>"
        return str
    }

    function checkProducts() {
        $(".table-continer").addClass("d-none")
        $(".error-text").addClass("d-none")
        $(".btn").attr("disabled", "disabled")
        $("input").attr("disabled", "disabled")
        $(".status-loading").removeClass("d-none")
        var url = $("[name='url']").val()

        var send = {
            url
        }
        productsTable.clear().draw()

        $.post("../server/product_check.php", send).then((data)=>{
            try {
                eval(data)    
            } catch (error) {
                $(".status-loading").addClass("d-none")
                $(".error-text").removeClass("d-none")
                $("input").removeAttr("disabled")
                $(".btn-search").removeAttr("disabled")
                console.log(error);
                console.log(data);
                return
            }
            // eval(data)
            console.log(products);
            // console.log(data);
            
            products.forEach(prd => {
                console.log(prd);
                if(prd.name[0] == " "){
                    var productName = removeExtraSpace(prd.name)
                    // prdRow = prdRow.substr(2, prdRow.length)
                } else if((prd.name).search("OFF") > -1){
                    var productName = removeDisscountVerb(prd.name)
                    // prdRow = prdRow.substr(21, prdRow.length)
                } else {
                    productName = prd.name
                }

                var prdImageSRC = "http://www."+url+"/"+prd.image
                productsTable.row.add([
                    // prd.name,
                    productName,
                    `$${(prd.price).toFixed(2)}`,
                    `<img class="product-image" src='${prdImageSRC}'/>`
                    // prd.image,
                ]).draw(false);
                
                // var productHTML = makeProductHTML(prd)
                // $("#products tbody").append(productHTML)
            });

            var tableRows = $("#products tbody tr")
            tableRows.each((idx, tr) => {
                var id = makeID()
                $(tr).attr("data-id", id)
                var copyIcon = `<i class="bi bi-clipboard-plus btn-copy" onclick="copy_product('${id}')"></i>\t\t`
                $(`[data-id='${id}'] td:first-child`).prepend(copyIcon)
                // console.log($(`[data-id='${id}'] td:first-child`).html());
                console.log(tr);
            });

            $(".status-loading").addClass("d-none")
            $(".table-continer").removeClass("d-none")
            $(".btn").removeAttr("disabled")
            $("input").removeAttr("disabled")
            // $(".dt-empty").css("display", "none")
        })
    }

    function copy_product(id){
        var productName = ($(`[data-id='${id}'] td:first-child`).text()).replaceAll("\t", "") 
        var productTXT = productName + "\t" + $(`[data-id='${id}'] td:nth-child(2)`).html()
        navigator.clipboard.writeText(productTXT)

        $(`[data-id='${id}'] .btn-copy`).removeClass("bi-clipboard-plus")
        $(`[data-id='${id}'] .btn-copy`).addClass("text-success")
        $(`[data-id='${id}'] .btn-copy`).addClass("bi-clipboard-check")
    }

    function removeDisscountVerb(str){
        var newStr = str.substr(21, str.length)
        return newStr
    }

    function removeExtraSpace(str){
        var newStr = str.substr(2, str.length)
        return newStr
    }

    function copyTable() {
        var str = `${$("[name='url']").val()}\n\n`
        
        products.forEach(prd => {
            prdRow = `${prd.name}\t$${(prd.price).toFixed(2)}\n`
            // console.log(prdRow[0]);
            if(prdRow[0] == " "){
                prdRow = removeExtraSpace(prdRow)
                // prdRow = prdRow.substr(2, prdRow.length)
            } else if(prdRow.search("OFF") > -1){
                prdRow = removeDisscountVerb(prdRow)
                // prdRow = prdRow.substr(21, prdRow.length)
            }
            str += prdRow
            
            // spreadSheetRow = new Blob([prd.name, `$${(prd.price).toFixed(2)}`], {type: 'text/html'});
            // navigator.clipboard.write([new ClipboardItem({'text/html': spreadSheetRow})])
        });
        console.log(str);

        navigator.clipboard.writeText(str);
    }

    function makeID(){
        return "id" + Math.random().toString(16).slice(2)
    }


    var productsTable = new DataTable('#products', {
        pageLength: 25,
        order: {
            idx: 9,
            dir: "dsc"
        }
    });
    $("#products_wrapper .dt-layout-table").addClass("table-responsive")
</script>