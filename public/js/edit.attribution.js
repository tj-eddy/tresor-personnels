$(function () {
    checkSelectionTaskNameMax();
});


function checkSelectionTaskNameMax() {
    var last_valid_selection = null;
    $('#attribution_nom_tache').on('change', function (e) {
        let count_select = $('.select2-selection__rendered li').length
        if (count_select > 4) {
            $(this).val(last_valid_selection);
        } else {
            last_valid_selection = $(this).val();
        }
    })
}