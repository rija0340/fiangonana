$(function () {
    $("#statKilasyRehetra").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "sort": false,
        "info": false,
        "searching": false,
        "paginate": false,
        "buttons": [
            "copy",
            "csv",
            "excel",
            "pdf",
            "print",
            "colvis"
        ]
    }).buttons().container().appendTo('#statKilasyRehetra_wrapper .col-md-6:eq(0)');

    $("#statKilasyRehetra2").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "sort": false,
        'info': false,
        "searching": false,
        "paginate": false,
        "buttons": [
            "copy",
            "csv",
            "excel",
            "pdf",
            "print",
            "colvis"
        ]
    }).buttons().container().appendTo('#statKilasyRehetra2_wrapper .col-md-6:eq(0)');

    $("#asafiParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })


    $("#asaSoaParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })


    $("#fampianaranaBaibolyParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })

    $("#bokyNaTraktaParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })

    $("#semineraKaoferansaParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })

    $("#nahavitaFampianaranaParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })

    $("#batisaParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })
    $("#fanatitraParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })

    $("#fahatongavanaParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })

    $("#impitoTongaParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })

    $("#impitoRejistraParClasse").DataTable({
        "responsive": true,
        "lengthChange": false,
        "searching": false,
        "autoWidth": false,
        "info": false,
        "sort": true,
        "order": [
            [1, 'desc']
        ],
        "paginate": false

    })
});