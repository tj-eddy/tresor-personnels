$(document).ready(function () {

    $("#user_matricule").on("click",function () {
        $(this).val(generateMatricule(10000,100000))
    });
    $("#document_recrutement_num_doc").on("click",function () {
        $(this).val(generateNumDoc(10000,100000))
    });
    $(".select-2").select2();
});

function generateMatricule(min,max) {
    return "M"+Math.floor(Math.random() * (max - min + 1)) + min;
}

function generateNumDoc(min,max) {
    return "DOC-"+Math.floor(Math.random() * (max - min + 1)) + min;
}