$("#borrower").click(function(){
    $("#layoutSidenav_content h1").text("Borrower");
    $(".card-header").text("Borrower Table");
    $.get("borrowerData.php", function(result){
        $("#datatablesSimple").html(result);
    })
})