$("#returned").click(returnBooks)

function returnBooks() {
    var idx = [];
    var checkboxes = $("#datatablesSimple > tbody input:checkbox")
    checkboxes = Array.from(checkboxes)
    checkboxes.forEach((ckb, value) => {
        if ($(ckb).prop("checked")) {
            idx.push($(ckb).attr("id"))
        }
    })
    $.post("apis/returnBook.php", {ids: idx}, function (d) {
        if (d) {
            location.reload();
        } else {
            alert("error !")
        }
    })
}