$(document).ready(function () {

    function autocomplete(availableTags) {
        console.log("availableTags");
        console.log(availableTags);
        // Initialize the autocomplete widget

        $(".sheet-input").each(function () {

            $(this).autocomplete({
                source: availableTags.map((item) => ({
                    label: `${item.prenom}`,
                    value: item.id,
                })),
                select: function (event, ui) { // Set the input's value
                    $(this).val(ui.item.label);
                    var name = $(this).attr('name');
                    name  = name+'_data';

                    var selectedElement = $('[name="' + name + '"]');

                    selectedElement.val(ui.item.value);

                    // Set the data-id attribute of the input
                    $(this).attr('data-id', ui.item.value);

                    return false; // Prevent the default behavior of selecting the value
                },
                focus: function (event, ui) {
                    $(".ui-helper-hidden-accessible").hide();
                    event.preventDefault();
                }
            });
        });
    }

    $.ajax({
        type: 'GET',
        url: '/famille-mambra/data',
        success: function (data) {
            console.log("data");
            console.log(data);
            autocomplete(data);
        },
        error: function (erreur) {
            // alert('La requête n\'a pas abouti' + erreur);
            console.log(erreur.responseText);
        }

    });
});