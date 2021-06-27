$(document).ready(function () {
    let current_time = (new moment()).format('hh:mm');
    $('input').on('click', function () {
        let current_field = $(this).val(current_time)
        $('input').not(current_field).val('')
    })

    checkValInput();
    var table = $('#id-pointage-list').DataTable();
    $('#ptg-btn').on('click', function () {
        checkValInput();
        $.ajax({
            method: 'post',
            url: url_pointage,
            data: {
                ham: $("#ptg-ham").val(),
                haa: $("#ptg-haa").val(),
                hsm: $("#ptg-hsm").val(),
                hsa: $("#ptg-hsa").val()
            },
            beforeSend: function () {

            },
            success: function (response) {
                if (response.status == true) {
                    table.ajax.reload(null, false);
                    $('input').val("");
                }

            }
        });
    });
});

function checkValInput() {
    if (has_ham && has_hsm && has_haa && has_hsa) {
        $('#ptg-ham').prop('disabled', false);
        $('#ptg-hsm').prop('disabled', true);
        $('#ptg-haa').prop('disabled', true);
        $('#ptg-hsa').prop('disabled', true);
    } else if (has_hsa) {
        $('#ptg-ham').prop('disabled', false);
        $('#ptg-hsm').prop('disabled', true);
        $('#ptg-haa').prop('disabled', true);
        $('#ptg-hsa').prop('disabled', true);
    } else if (has_ham && has_hsm && has_haa) {
        $('#ptg-ham').prop('disabled', true);
        $('#ptg-hsm').prop('disabled', true);
        $('#ptg-haa').prop('disabled', true);
    } else if (has_ham && has_hsm) {
        $('#ptg-ham').prop('disabled', true);
        $('#ptg-hsm').prop('disabled', true);
    } else if (has_ham) {
        $('#ptg-ham').prop('disabled', true);
    }
}