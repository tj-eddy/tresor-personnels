$(document).ready(function () {
    let current_time = (new moment()).format('hh:mm');
    $('input').on('click', function () {
        let current_field = $(this).val(current_time)
        $('input').not(current_field).val('')
    })

    if (has_hsa){
        $('input').not($('#ptg-ham')).prop('disabled',true)
    }
    var table = $('#id-pointage-list').DataTable();
    $('#ptg-btn').on('click', function () {
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
            },
            complete: function () {

            }
        });
    });
});