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
                url: url_admin_cv_ajax_list,
                data: function (data) {
                    if (data.order[0])
                        data.order_by = data.columns[data.order[0].column].name + ' ' + data.order[0].dir;
                }
            },
            "columnDefs": [
                {name: "u.username", targets: 0},
                {name: "u.prenom", targets: 1},
                {
                    name: "u.age", targets: 2, render: function (data) {
                        return data + ' ans';
                    }
                },
                {name: "u.child_number", targets: 3},
                {
                    name: "u.anciennete", targets: 4, render: function (data) {
                        return data + ' ans';
                    }
                },
                {name: "u.cin", targets: 5},
                {name: "dm.grade", targets: 6},
                {name: "dm.corps", targets: 7},
                {
                    name: "u.id",
                    targets: 8,
                    render: function (data, type, row) {
                        href_show = show_path.replace('0', data);
                        return '<a href="' + href_show + '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i>Tâche déjà occupés</a>'
                    },
                    orderable: false
                },

            ]
        }
    );
});

