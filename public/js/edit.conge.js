$(document).ready(function () {
    demandeConge();
    validateConge();
});

function validateConge() {
    var table = $('#id-conge-list').DataTable();
    $('#id-conge-list tbody').on('click', 'tr', function () {
        let row = table.row(this).data();

        if (row[0] == 0 && confirm('Voulez-vous vraiment validé ce congé ? ')) {
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
        } else {
            if (row[0] == 0) {
                $.ajax({
                    method: 'post',
                    data: {
                        conge_id: row[8]
                    },
                    datatype: 'json',
                    url: annulation_conge,
                    success: function (data) {
                        table.ajax.reload(null, false);
                    }
                });
            }
        }
    });
}


function emptyInput() {
    $('#date-debut').val("")
    $('#lieu-jouissance').val("")
    $('#conge-type').val("")
    $('#nom-interim').val("")
    $('#motif').val("")
    $('#nombre_jour').val("")
}

function demandeConge() {
    $('.send-conge').on('click', function (ev) {
        if (
            $('#date-debut').val() !== "" &&
            $('#lieu-jouissance').val() !== "" &&
            $('#conge-type').val() !== "" &&
            $('#nom-interim').val() !== "" &&
            $('#motif').val() !== "" &&
            $('#nombre_jour').val() !== ""
        ) {
            $.ajax({
                method: 'post',
                data: {
                    date_debut: $('#date-debut').val(),
                    lieu_jouissance: $('#lieu-jouissance').val(),
                    type_conge: $('#conge-type').val(),
                    nom_interim: $('#nom-interim').val(),
                    user_id: $('#user_id').val(),
                    motif: $('#motif').val(),
                    nombre_jour: $('#nombre_jour').val(),
                    num_demande: generateNumDemandeConge(last_id)
                },
                datatype: 'json',
                url: url_demande_conge_ajax,
                success: function (response) {
                    if (response.status == true && response.has_conge_attente == false && response.nombre_jour_restant > 0) {
                        $('.message-success').modal('show')
                        emptyInput()
                    } else if (
                        response.status == true && response.has_conge_attente == false &&
                        response.nombre_jour_restant <= 0) {
                        $('.message-erreur').modal('show')
                    } else {
                        $('.solde-restant').html(response.nombre_jour_restant);
                        $('.message-has-validation-inprogress').modal('show');
                    }
                },
                error: function (err) {
                }
            })
        } else {
            $('.message-validation').modal('show')
        }
    })
}

function generateNumDemandeConge(conge_id) {
    let current_date = new Date();
    return conge_id + "/" + current_date.getFullYear();
}