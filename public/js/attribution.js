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
                {name: "a.username", targets: 5, visible: is_superadmin ? true : false},
                {
                    name: "u.id",
                    visible: is_superadmin ? true : false,
                    targets: 6,
                    render: function (old_employe, type, row) {
                        selectUser(old_employe, row[7]);
                        $('#id-attribution-list tbody').on('click', 'tr', function () {
                            let row_t = table.row(this).data();
                            $('.basic-data-select2').on('change', function () {
                                $.ajax({
                                    method: 'post',
                                    data: {
                                        nouveau_employe: $(this).val(),
                                        old_employe: old_employe,
                                        id_attribution: row_t[7]
                                    },
                                    datatype: 'json',
                                    url: change_attribution_ajax,
                                    beforeSend:function(){
                                        $('.attribution-wait').removeClass('d-none')
                                    },
                                    complete: function () {
                                        $(document).ajaxStop(function () {
                                            $('.attribution-wait').addClass('d-none')
                                            window.location.reload();
                                        })
                                    }
                                })
                            })
                        });

                        let action = '<select name="user_id"  class="form-control basic-data-select2"></select>'
                        return action;
                    }
                },
                {name: "id_attribution", targets: 7, visible: false},
            ]
        }
    );
});

function selectUser(old_employe, id_attribution) {
    $('.basic-data-select2').select2({
        placeholder: '-- Sélectionner --',
        ajax: {
            url: url_select_user_ajax,
            data: function (params) {
                var query = {
                    search: params.term,
                    type: 'public',
                };

                return query;
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        $('.basic-data-select2').val(obj.id);
                        return {id: obj.id, text: obj.username};
                    })
                };
            },
            minimumInputLength: 3,
        }
    });


}