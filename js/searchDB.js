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
        window.location.href = "http://localhost:9999/homePage.php";
    } else {
        window.location.href = "http://localhost:9999/homePage.php?keyword="+kw+"&category="+ct;
    }
}