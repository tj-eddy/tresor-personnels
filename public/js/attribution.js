$(document).ready(function () {
    let table = $('#id-attribution-list').DataTable(
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
                url: url_admin_attribution_ajax_list,
                data: function (data) {
                    data.id_user = user_id;
                    if (data.order[0])
                        data.order_by = data.columns[data.order[0].column].name + ' ' + data.order[0].dir;
                }
            },
            "columnDefs": [
                {
                    name: "a.status", targets: 0, render: function (data) {
                        let status = data == 1 ? 'Terminé' : 'En cours';
                        let color = data == 1 ? 'success' : 'danger';
                        return "<span class='badge badge-" + color + "' >" + status + "</span>"
                    }
                },
                {name: "a.numero_tache", targets: 1},
                {name: "a.nom_tache", targets: 2},
                {name: "a.date_debut", targets: 3},
                {name: "a.date_fin", targets: 4},
                {name: "u.username", targets: 5, orderable: false, visible: is_superadmin ? true : false},
                {
                    name: "id_attribution",
                    targets: 6,
                    visible: is_superadmin ? true:false,
                    render: function (data,type,row) {
                        href_edit = edit_path.replace('0', data);
                        href_delete = delete_path.replace('0', data);
                        let status_termine = row[0] === 1 ? 'd-none' : '';
                        return '<a  href="' + href_edit + '" class="btn btn-warning btn-sm ' + status_termine + '"><i class="fa fa-send"></i> Attribuer</a>'
                    },
                    orderable: false
                }
            ]
        }
    );
});