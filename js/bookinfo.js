$(".display").on('click', ".col", function() {
    var bkid = $(this).attr("id");
    window.location.href = "http://localhost:8888/bookInfo.php?bkid="+bkid;
})
