$(document).ready(function () {


    function autocomplete(availableTags) {
        console.log("availableTags");
        console.log(availableTags);
        // Initialize the autocomplete widget

        $(".sheet-input").each(function () {

            $(this).autocomplete({
                source: availableTags,
                select: function (event, ui) { // Set the input's value
                    $(this).val(ui.item.nom);

                    alert(ui.item.nom);

                    // Set the data-id attribute of the input
                    $(this).attr('data-id', ui.item.id);

                    return false; // Prevent the default behavior of selecting the value
                },
                focus: function (event, ui) {
                    $(".ui-helper-hidden-accessible").hide();
                    event.preventDefault();
                }
            });
        });
    }
    autocomplete([{ id: 12, nom: 'rija', prenom: 'test' }]);


    $.ajax({
        type: 'GET',
        url: '/famille-mambra/data',
        success: function (data) {
            console.log("daeeta");
            console.log(data);
        },
        error: function (erreur) {
            // alert('La requête n\'a pas abouti' + erreur);
            console.log(erreur.responseText);
        }

    });
});