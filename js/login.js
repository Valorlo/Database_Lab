$("#login").click(verify);
$("#staticBackdrop").on("keyup", function(e){
    if (e.keyCode === 13) {
        verify();
    }
})

function verify(){
    var stdnum = $("#stdnum").val();
    var pwd = $("#pwd").val();

    if(stdnum == "" || pwd == ""){
        alert("missing student number or password !")
    }else{
        $.post("apis/login.php", {
            std: stdnum,
            pwd: pwd
        }, function (d) {
            if (d) {
                location.reload();
            } else {
                alert("查無帳號，請先註冊!")
                location.reload();
            }
        });
    }
}