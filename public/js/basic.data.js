$(document).ready(function () {
    $('#id-basic-data-list').DataTable(
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
                url: url_ajax_basic_data,
                data: function (data) {
                    if (data.order[0])
                        data.order_by = data.columns[data.order[0].column].name + ' ' + data.order[0].dir;
                }
            },
            "columnDefs": [
                {name: "data.code_etablissement", targets: 0},
                {name: "data.nom_etablissement", targets: 1},
                {name: "data.fokontany", targets: 2},
                {name: "data.zap", targets: 3},
                {name: "data.commune", targets: 4},
                {name: "data.categorie_commune", targets: 5},
                {name: "data.cisco", targets: 6},
                {name: "data.dreen", targets: 7},
            ]
        }
    );
});