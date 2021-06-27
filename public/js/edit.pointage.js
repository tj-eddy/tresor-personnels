$(document).ready(function () {
    let current_time = (new moment()).format('HH:mm');
    $('input').on('click', function () {
        let current_field = $(this).val(current_time)
        calculRetard();
        $('input').not(current_field).val('')
    })

    checkValInput();
    var table = $('#id-pointage-list').DataTable();
    $('#ptg-btn').on('click', function () {
        $.ajax({
            method: 'post',
            url: url_pointage,
            data: {
                ham: $("#ptg-ham").val(),
                haa: $("#ptg-haa").val(),
                hsm: $("#ptg-hsm").val(),
                hsa: $("#ptg-hsa").val(),
                hrtr: calculRetard()
            },
            success: function (response) {
                if (response.status == true) {
                    table.ajax.reload(null, false);
                    $('input').val("");
                }
            }, complete: function () {
                $(document).ajaxStop(function () {
                    window.location.reload();
                })

            }
        });
    });

});

/**
 * function checkValInput
 */
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

/**
 * calcul heure de retard
 * @returns {number}
 */
function calculRetard() {
    let timepick = (new moment()).format('H');
    // retart valeur negatif  = avance
    let retart = 0;
    if (timepick < 8) {
        retart = timepick - 8;
    } else if (timepick >= 8 && timepick <= 12) {
        if (has_ham) {
            retart = timepick - 12;
        } else {
            retart = timepick - 8;
        }
    } else if (timepick > 12 && timepick <= 16) {
        if (has_hsm) {
            retart = timepick - 12.5;
        } else if (has_haa) {
            retart = timepick - 16;
        }
    } else if (timepick > 16) {
        retart = timepick - 16;
    }

    return retart;
}