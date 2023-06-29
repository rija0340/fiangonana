
$('.btnAddHistorique').click(function () {
    var idSong = $(this).data('id');
    var titre = $('#titre_' + idSong).text();
    $('.modal-title-hira').text(titre);

    $('#formAddHistorique').attr('action', 'add-historique/' + idSong);
})