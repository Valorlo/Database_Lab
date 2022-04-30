$(".d-flex").on('click', ".operations", function () {
    var url = new URL(location.href);
    var bkid = url.searchParams.get("bkid");

    if ($(".operations").text().search("借閱") > 0) {
        $.post("apis/borrowBook.php", {
            bkid: bkid
        }, function (data) {
            if (data) {
                window.location.href = "http://localhost:9999/bookslip.php";
            } else {
                alert("Failed to borrow!");
            }
        })
    } else {
        //預約
        var bkname = $("h1").text();
        $.get("apis/notifyReturn.php", {
            bkid: bkid
        }, function (d) {
            var d = JSON.parse(d);
            if (d) {
                // 新增預約紀錄
                $.get("apis/reserveRecord.php", {
                    bkid: bkid
                }, function (data) {
                    console.log(data);
                    if (data) {
                        console.log("預約成功!");
                        // // 寄送郵件
                        // var templateParams = {
                        //     to_mail: d[0].email,
                        //     to_name: d[0].name,
                        //     book_name: bkname
                        // };

                        // emailjs.send('service_a52o9ye', 'template_vqrnr27', templateParams)
                        //     .then(function (response) {
                        //         console.log('SUCCESS!', response.status, response.text);
                        //         alert("預約成功！請於 7 天後回來查看~")
                        //     }, function (error) {
                        //         console.log('FAILED...', error);
                        //     });
                    } else {
                        alert("預約失敗!");
                    }
                })
            } else {
                alert("Failed to notify!");
            }
        })
    }
})