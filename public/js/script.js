$(document).ready(function () {

    $("#user_matricule").on("click",function () {
        $(this).val(generateMatricule(10000,100000))
    });
});

function generateMatricule(min,max) {
    return "M"+Math.floor(Math.random() * (max - min + 1)) + min;
}