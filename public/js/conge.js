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
                {name: "dc.id", targets: 0},
                {name: "dc.status", targets: 1},
                {name: "dc.num_demande", targets: 2},
                {name: "u.username", targets: 3},
                {name: "dc.nom_interim", targets: 4},
                {name: "dc.date_debut", targets: 5},
                {name: "dc.motif", targets: 6},
                {name: "dc.type_conge", targets: 7},
                {name: "dc.lieu_jouissance", targets: 8}
            ]
        }
    );
});