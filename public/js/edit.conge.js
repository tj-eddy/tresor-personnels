$(document).ready(function () {
    validateConge();
});

function validateConge() {
    var table = $('#id-conge-list').DataTable();
    $('#id-conge-list tbody').on('click', 'tr', function () {
        let row = table.row(this).data();
        if (row[0] == false && confirm('Voulez-vous vraiment validé ce congé ? ')) {
            $.ajax({
                method: 'post',
                data: {
                    conge_id: row[8]
                },
                datatype: 'json',
                url: validate_conge,
                success: function (data) {
                    table.ajax.reload(null, false);
                }
            })
        }
    });
}