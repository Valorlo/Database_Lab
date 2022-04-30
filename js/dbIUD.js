$("#newBook").click(addBooks);
$("#eBtn").click(editInfo);
$("#changeBook").click(editBooks);
$("#warningDelete").click(warnDelete);
$("#delete").click(deleteBooks);
$("#bookNotify").click(notifyBooks);


function addBooks() {
    var isbn = $("#ISBN").val()
    var pub = $("#pub").val()
    var author = $("#author").val()
    var bookname = $("#bookname").val()
    var cate = $(".cate").val()
    var img = $("#img").val()
    if (author == "" || bookname == "" || pub == "") {
        alert("missing values !")
    } else {
        $.post("apis/addBook.php", {
            isbn: isbn,
            pub: pub,
            author: author,
            bookname: bookname,
            cate: cate,
            img: img,
        }, function (d) {
            if (d) {
                location.reload();
            } else {
                alert("error !")
            }
        });
        $("#ISBN").val("")
        $("#pub").val("")
        $("#author").val("")
        $("#bookname").val("")
        $(".cate").val("")
        $("#img").val("")
    }
}

function editInfo() {
    var edits = {};
    var checkboxes = $("#datatablesSimple > tbody input:checkbox")
    checkboxes = Array.from(checkboxes)
    checkboxes.forEach((ckb, value) => {
        if ($(ckb).prop("checked")) {
            var temp = [];
            var tds = $(ckb).parent().parent().find("td")
            for (var i = 1; i < tds.length; i++) {
                temp.push($(tds[i]).text())
            }
            edits[value] = temp;
        }
    })
    for (const [key, value] of Object.entries(edits)) {
        $("#bkid_e").text(value[0])
        $("#ISBN_e").val(value[1])
        $("#pub_e").val(value[2])
        $("#author_e").val(value[3])
        $("#bookname_e").val(value[4])
        $(".cate_e").val(value[5])
        $(".status_e").val(value[6])
        $("#img_e").val(value[7])
    }
}

function editBooks() {
    var bkid = $("#bkid_e").text()
    var isbn = $("#ISBN_e").val()
    var pub = $("#pub_e").val()
    var author = $("#author_e").val()
    var bookname = $("#bookname_e").val()
    var cate = $(".cate_e").val()
    var status = $(".status_e").val()
    var img = $("#img_e").val()
    if (author == "" || bookname == "" || pub == "") {
        alert("missing values !")
    } else {
        $.post("apis/editBook.php", {
            bkid: bkid,
            isbn: isbn,
            pub: pub,
            author: author,
            bookname: bookname,
            cate: cate,
            status: status,
            img: img
        }, function (d) {
            if (d) {
                location.reload();
            } else {
                alert("error !")
            }
        })
    }
}

function warnDelete() {
    var idx = [];
    var checkboxes = $("#datatablesSimple > tbody input:checkbox")
    checkboxes = Array.from(checkboxes)
    checkboxes.forEach((ckb, value) => {
        if ($(ckb).prop("checked")) {
            idx.push($(ckb).id)
        }
    })
    $(".warning_content").text("Are you sure to delete {" + idx.length + "} books ?")
}

function deleteBooks() {
    var idx = [];
    var checkboxes = $("#datatablesSimple > tbody input:checkbox")
    checkboxes = Array.from(checkboxes)
    checkboxes.forEach((ckb, value) => {
        if ($(ckb).prop("checked")) {
            idx.push($(ckb).attr("id"))
        }
    })
    $.post("apis/deleteBook.php", {
        ids: idx
    }, function (d) {
        if (d) {
            location.reload();
        } else {
            alert("error !")
        }
    })
}

function notifyBooks() {
    var len = $(".bookLength").text();
    if (len == "0") {
        alert("no books to notify !")
        $("#notify").modal('toggle');
    } else {
        alert("mailing!")

        // 取得所有使用者的資料
        $.get("apis/borrowerData.php", function (d) {
            var allMails = "";
            var bns = "<ul>";
            var data = JSON.parse(d);
            for (var i = 0; i < data.length; i++) {
                if (i < data.length - 1) {
                    allMails += data[i].email + ",";
                } else {
                    allMails += data[i].email
                }
            }
            // 取得所有新書的資料
            $.get("apis/newbookInfo.php", function (d) {
                var data = JSON.parse(d);
                for (var i = 0; i < data.length; i++) {
                    bns += "<li>" + data[i].bookname + "</li>";
                }
                bns += "</ul>";

                // 寄送郵件
                var templateParams = {
                    to_mail: allMails,
                    to_name: 'users',
                    my_html: bns
                };

                emailjs.send('service_a52o9ye', 'template_btq7qa9', templateParams)
                    .then(function (response) {
                        console.log('SUCCESS!', response.status, response.text);
                        $("#notify").modal('toggle');
                    }, function (error) {
                        console.log('FAILED...', error);
                    });
            })
        })

    }
}