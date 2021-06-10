$(document).ready(function () {
    $('#id-btn-import').on('click', function (e) {
        var file_data = $('#customFileLang').prop('files')[0];
        var form_data = new FormData();
        form_data.append('filename', file_data);
        $.ajax({
            url: url_upload_file,
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            beforeSend: function () {
                $('#id-spinner').removeClass('d-none');
                $('.validation-exist-import').addClass('d-none');
                $('.validation-success-import').addClass('d-none');
            },
            success: function (data) {
                $('#id-btn-import').attr('disabled', 'disabled');
                if (data.status == false) {
                    $('.validation-success-import').addClass('d-none');
                    $('.validation-exist-import').removeClass('d-none');
                } else if (data.status == true) {
                    $(document).ajaxStop(function () {
                        $('.validation-success-import').removeClass('d-none');
                        $('#id-btn-import').removeAttr('disabled');
                    });
                }
            },
            complete: function () {
                $('#id-spinner').addClass('d-none');
            }
        });
    });


    $('#customFileLang').change(function (e) {
        var file = e.target.value;
        var extension = file.substr((file.lastIndexOf('.') + 1));
        if ($(this).val() && extension == 'xlsx') {
            $('#id-btn-import').removeAttr('disabled');
            $('.validation-excel-file').addClass('d-none');
        } else {
            $('#id-btn-import').attr('disabled', 'disabled');
            $('.validation-excel-file').removeClass('d-none');
            $('.validation-exist-import').addClass('d-none');
            $('.validation-success-import').addClass('d-none');
        }
    })


});
