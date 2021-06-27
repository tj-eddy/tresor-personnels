$(document).ready(function () {
    $('#id-pointage-list').DataTable(
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
                url: url_pointage_ajax_list,
                data: function (data) {
                    if (data.order[0])
                        data.order_by = data.columns[data.order[0].column].name + ' ' + data.order[0].dir;
                }
            },
            "columnDefs": [
                {name: "usr.username", targets: 0, visible: is_admin ? true : false},
                {name: "date_auj", targets: 1},
                {name: "ptg.date_arrive_matinee", targets: 2},
                {name: "ptg.heure_sortie_matinee", targets: 3},
                {name: "ptg.heure_arrivee_ap", targets: 4},
                {name: "ptg.heure_sortie_ap", targets: 5},
                {name: "ptg.heure_retart", targets: 6},
            ]
        }
    );
});