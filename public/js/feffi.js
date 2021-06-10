$(document).ready(function () {
    $('#id-feffi-list').DataTable(
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
                url: url_admin_feffi_ajax_list,
                data: function (data) {
                    if (data.order[0])
                        data.order_by = data.columns[data.order[0].column].name + ' ' + data.order[0].dir;
                }
            },
            "columnDefs": [
                {name: "president", targets: 0},
                {name: "director", targets: 1},
                {name: "treasurer", targets: 2},
                {
                    name: "pvconst", targets: 3, render: function (data) {
                        return data == true ? 1 : 0
                    }
                },
                {
                    name: "pvordi", targets: 4, render: function (data) {
                        return data == true ? 1 : 0
                    }
                },
                {
                    name: "recepconst", targets: 5, render: function (data) {
                        return data == true ? 1 : 0
                    }
                },
                {name: "cisco", targets: 6},
                {name: "dreen", targets: 7},
                {name: "zap", targets: 8},
                {name: "etab", targets: 9},
                {
                    name: "id_feffi",
                    targets: 10,
                    render: function (data) {
                        href_show = show_path.replace('0', data);
                        return '<a href="' + href_show + '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>'
                    },
                    orderable: false
                },
            ]
        }
    );
});