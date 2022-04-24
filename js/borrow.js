$(".d-flex").on('click', ".operations", function() {
    var url = new URL(location.href);
    var bkid = url.searchParams.get("bkid");

    if($(".operations").text().search("借閱")>0) {
        $.post("apis/borrowBook.php", {bkid: bkid}, function(data) {
            if (data) {
                window.location.href = "http://localhost:9999/bookslip.php";
            } else {
                alert("Failed to borrow!");
            }
        })
    }
})