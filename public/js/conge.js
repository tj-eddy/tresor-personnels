$(document).ready(function () {
    $('#id-conge-list').DataTable(
        {
            "language": {
                url: datatable_language
            },
            "aaSorting": [],
            "bProcessing": true,
            "bFilter": true,
            "bServerSide": true,
            "lengthMenu": [[10, 50, 100, 500, 1000, 5000, 10000], [10, 50, 100, 500, '1 000', '5 000', '10 000']],
            "iDisplayLength": 10,
            "ajax": {
                url: url_admin_conge_ajax_list,
                data: function (data) {
                    if (data.order[0])
                        data.order_by = data.columns[data.order[0].column].name + ' ' + data.order[0].dir;
                }
            },
            "columnDefs": [
                {
                    name: "dc.status", targets: 0, render: function (status, type, row) {
                        let color;
                        if (status == 0) {
                            color = 'danger';
                        } else if (status == 2) {
                            color = 'warning';
                        } else {
                            color = 'success';
                        }
                        let text;
                        if (status == 0) {
                            text = 'En attente';
                        } else if (status == 2) {
                            text = 'Annulé';
                        } else {
                            text = 'Validé';
                        }
                        let is_disabled = status == 1 || status == 2 ? 'disabled' : '';
                        return "<button " + is_disabled + " class='validate-btn btn btn-" + color + " btn-sm'>" + text + "</button>";
                    }
                },
                {name: "dc.num_demande", targets: 1},
                {name: "u.username", targets: 2},
                {name: "dc.nom_interim", targets: 3},
                {name: "dc.date_debut", targets: 4},
                {name: "dc.motif", targets: 5},
                {name: "dc.type_conge", targets: 6},
                {name: "dc.lieu_jouissance", targets: 7},
                {name: "dc.id", targets: 8, visible: false}
            ]
        }
    );
});