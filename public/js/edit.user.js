$(document).ready(function () {
    // check if has children
    let children_number = $('#user_childNumber');
    children_number.prev().addClass('d-none');

    if (children_number.val() > 0){
        children_number.removeClass('d-none');
        children_number.prev().removeClass('d-none');
        children_number.attr("required",true)
        children_number.prev().removeClass('d-none');
        $("#customRadio10").prop("checked",true)
        $("#customRadio9").prop("checked",false)
    }
    $('input[name="childnumber"]').on("click", function () {
        if ($(this).val() == 0) {
            children_number.addClass('d-none');
            children_number.prev().addClass('d-none');
            children_number.attr("required",false)
        } else {
            children_number.removeClass('d-none');
            children_number.val(" ")
            children_number.prev().removeClass('d-none');
            children_number.attr("required",true)
        }
    })

})

