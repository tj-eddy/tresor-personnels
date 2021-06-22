$(document).ready(function () {
    $('#id-user-list').DataTable(
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
                url: url_admin_user_ajax_list,
                data: function (data) {
                    if (data.order[0])
                        data.order_by = data.columns[data.order[0].column].name + ' ' + data.order[0].dir;
                }
            },
            "columnDefs": [
                {
                    name: "user.profil", targets: 0,
                    render: function (data) {
                        var img_src = '/uploads/' + data;
                        var profil_pic = data ? img_src : path_default_image;
                        return "<span class='avatar avatar-sm rounded-circle'><img  src='" + profil_pic + "' /></span>"
                    },
                    orderable: false
                },
                {name: "user.matricule", targets: 1},
                {name: "user.username", targets: 2},
                {name: "user.prenom", targets: 3},
                {name: "user.cin", targets: 4},
                {name: "user.date_start_service", targets: 5},
                {
                    name: "user.id",
                    targets: 6,
                    render: function (data) {
                        href_edit = edit_path.replace('0', data);
                        href_delete = delete_path.replace('0', data);
                        return id_current_user == data ? '' : '<a href="' + href_edit + '" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Modifier</a>' +
                            '<a onclick="return confirm(confirm_delete)"  href="' + href_delete + '" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Supprimer</a>'
                    },
                    orderable: false
                },
            ]
        }
    );
});