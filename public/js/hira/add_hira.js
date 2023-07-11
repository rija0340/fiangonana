$(document).ready(function () {

    $('#add-tononkira').click(function () {
        //ej recupere le numero des champs que je veux recuperer

        const index = $('#hira_tononkiras div.form_tononkira').length;

        console.log('index :' + index);

        //je recupere le prototype des entrées
        //remplacer plusieurs fois __name__ par index
        const tmpl = $('#hira_tononkiras').data('prototype').replace(/__name__/g, index);

        //j'injecte ce code au sein de la div
        $('#hira_tononkiras').append(tmpl);
    });
});