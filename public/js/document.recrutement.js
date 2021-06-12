$(document).ready(function () {
    $('#id-dm-list').DataTable(
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
                url: url_admin_dm_ajax_list,
                data: function (data) {
                    if (data.order[0])
                        data.order_by = data.columns[data.order[0].column].name + ' ' + data.order[0].dir;
                }
            },
            "columnDefs": [
                {name: "u.username", targets: 0},
                {name: "dm.num_doc", targets: 1},
                {name: "dm.type_doc", targets: 2},
                {name: "dm.date_doc", targets: 3},
                {name: "dm.corps", targets: 4},
                {name: "dm.indice", targets: 5},
                {name: "dm.categorie", targets: 6},
                {name: "dm.grade", targets: 7},
                {
                    name: "dm.id",
                    targets: 8,
                    render: function (data) {
                        href_edit = edit_path.replace('0', data);
                        href_show = show_path.replace('0', data);
                        return '<a href="' + href_edit + '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>' +
                            '<a href="' + href_show + '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>'
                    },
                    orderable: false
                }
            ]
        }
    );
});