$(function () {
    $('.date-picker').datepicker({
        opens: 'top',
        autoclose: true,
        language: 'fr',
        format: 'dd-mm-yyyy',
        defaultDate: new Date()
    });
});