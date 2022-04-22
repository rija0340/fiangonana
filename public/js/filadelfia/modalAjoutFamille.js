$(document).ready(function () {

    var btn = document.querySelectorAll('#btn_modal_ajout_famille');
    console.log(btn);
    for (let i = 0; i < btn.length; i++) {
        btn[i].addEventListener('click', loadModal, false);

    }

    function loadModal(e) {

        e.preventDefault();
        //recuperaton de l'element cliqué (unique car chacun a son href)
        var $a = $(this);

        //recuperation valeur  data-target
        var url = $a.attr('href');

        //recuperation valeur text dans a
        // var title = $a.html();

        // $a.children().removeClass('hide');

        //recuperer classe sans .
        var id = url.slice(1, url.length);

        // var include = "{% include 'pages/tarifs/tarif_visite/"+ id +".html.twig' %}" ;

        // console.log(include);

        var url = '/' + id;

        console.log(url);
        // var url = '/tarif_consta';
        //ceci permet de recuperer un element html et le met dans le div main-wrapper de la page fille
        //bouton clické -> ce code ci dessous active url dans controle et recupere element html dans render
        $('#btn-launch-modal').trigger('click');
        $('.modal-body').load(url, function () {
            // $('.modal-title').html(title);
            // $a.children().addClass('hide');
        });
    }
});
