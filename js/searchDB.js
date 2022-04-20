$("#search").click(searchBook);
$(".keyword").on("keyup", function(e){
    if (e.keyCode === 13) {
        searchBook();
    }
})

function searchBook(){
    var kw = $(".keyword").val()
    var ct = $("#bookCate").val()
    if (kw == "") {
        window.location.href = "http://localhost:8888/homePage.php";
    } else {
        window.location.href = "http://localhost:8888/homePage.php?keyword="+kw+"&category="+ct;
        // $.post("apis/search.php", {
        //     keyword: kw,
        //     cate: ct
        // }, function (d) {
        //     if (d.length == 2) {
        //         $(".display").empty();
        //         var title = `<h4>查無資料</h4>`
        //         $(".display").append(title);
        //     } else {
        //         $(".display").empty();
        //         d = JSON.parse(d);
        //         d.forEach(b => {
        //             var row = `<div class="col mb-5" id = ${b.bkid}>
        //             <div class="card h-100">
        //                 <!-- Product image-->
        //                 <img class="card-img-top" src=${b.img} alt="..." />
        //                 <!-- Product details-->
        //                 <div class="card-body p-4">
        //                     <div class="text-center">
        //                         <!-- Product name-->
        //                         <h5 class="fw-bolder">${b.bookname}</h5>
        //                         <!-- Product price-->
        //                         ${b.author}
        //                     </div>
        //                 </div>
        //             </div>
        //         </div>`
        //             $(".display").append(row);
        //         });
        //     }
        // });
        // $(".keyword").val("")
    }
}