$("#createUser").click(createUser);
$("#register").on("keyup", function(e){
    if (e.keyCode === 13) {
        createUser();
    }
})

function createUser(){
    // test M111111111
    var stdnum = $("#stdnum_r").val();
    var pwd = $("#pwd_r").val();
    var name = $("#name_r").val();
    var phone = $("#phone_r").val();
    var id = $("#id_r").val();
    var email = $("#email_r").val();

    if(stdnum == "" || pwd == "" || name == "" || phone == "" || id == "" || email == ""){
        alert("missing values !")
    }else{
        $.post("apis/register.php", {
            std: stdnum,
            pwd: pwd,
            name: name,
            phone: phone,
            id: id,
            email: email
        }, function (d) {
            if (d) {
                location.reload();
            } else {
                alert("Oops ! Something went wrong :(")
                location.reload();
            }
        });
    }
}