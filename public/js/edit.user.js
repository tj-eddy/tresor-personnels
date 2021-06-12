$(document).ready(function () {
    // check if has children
    let children_number = $('#user_childNumber');
    children_number.prev().addClass('d-none');
    $('input[name="childnumber"]').on("click", function () {
        if ($(this).val() == 0) {
            children_number.addClass('d-none');
            children_number.prev().addClass('d-none');
            children_number.attr("required",false)
        } else {
            children_number.removeClass('d-none');
            children_number.prev().removeClass('d-none');
            children_number.attr("required",true)
        }
    })

})

