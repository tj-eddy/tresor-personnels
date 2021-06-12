$(document).ready(function () {
    //tester si avoir enfant
    checkHasChildNumber();
    // tester si avoir num matricule
    checkhasMatricule();
    $("#user_cin").on('click', function () {
        setValueMatricule();
    })
})

function setValueMatricule() {
    // set cin  if has not matricule
    let cin = $('#user_cin').val();
    if ($("#customRadio11").is(":checked")) {
        $("#user_matricule").val(cin);
    }
}

function checkHasChildNumber() {
    // check if has children
    let children_number = $('#user_childNumber');
    children_number.prev().addClass('d-none');
    if (children_number.val() > 0) {
        children_number.removeClass('d-none');
        children_number.prev().removeClass('d-none');
        children_number.attr("required", true)
        children_number.prev().removeClass('d-none');
        $("#customRadio10").prop("checked", true)
        $("#customRadio9").prop("checked", false)
    }
    $('input[name="childnumber"]').on("click", function () {
        if ($(this).val() == 0) {
            children_number.addClass('d-none');
            children_number.prev().addClass('d-none');
            children_number.attr("required", false)
        } else {
            children_number.removeClass('d-none');
            children_number.val() > 0 ? children_number.val() : children_number.val(" ")
            children_number.prev().removeClass('d-none');
            children_number.attr("required", true)
        }
    });
}

function checkhasMatricule() {
    // check if has matricule
    let hasmatricule = $('#user_matricule');
    hasmatricule.prev().addClass('d-none');

    if (hasmatricule.val() !== null) {
        hasmatricule.removeClass('d-none');
        hasmatricule.prev().removeClass('d-none');
        hasmatricule.attr("required", true)
        hasmatricule.prev().removeClass('d-none');
        $("#customRadio12").prop("checked", true)
        $("#customRadio11").prop("checked", false)
    }
    $('input[name="hasmatricule"]').on("click", function () {
        if ($(this).val() == 0) {
            hasmatricule.addClass('d-none');
            hasmatricule.prev().addClass('d-none');
            hasmatricule.attr("required", false)
        } else {
            hasmatricule.removeClass('d-none');
            hasmatricule.val() !== null ? hasmatricule.val() : hasmatricule.val(" ")
            hasmatricule.prev().removeClass('d-none');
            hasmatricule.attr("required", true)
        }
        setValueMatricule();
    })
}