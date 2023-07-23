
$(document).ready(function () {


    var status = $('#kilasy_nbrMambraUsed_1').is(':checked');
    const nbrInputEl = $('#kilasy_nbrMambra');
    var labelEl = $('label[for="kilasy_nbrMambra"]');

    if (status) {
        nbrInputEl.css('display', 'flex');
        labelEl.css('display', 'flex');
    } else {
        nbrInputEl.css('display', 'none');
        labelEl.css('display', 'none');
    }

    $('input[name="kilasy[nbrMambraUsed]"]').click(function () {
        // const nbrInputEl = $('#kilasy_nbrMambra');
        // var labelEl = $('label[for="kilasy_nbrMambra"]');
        if ($(this).val() == 'custom') {
            nbrInputEl.css('display', 'flex');
            labelEl.css('display', 'flex');
        } else {
            nbrInputEl.css('display', 'none');
            nbrInputEl.val('');
            labelEl.css('display', 'none');
        }
    });


    // form check
    $('form[name="kilasy"]').on('submit', function (event) { // Check if the radio button with id kilasy_nbrMambraUsed_1 is checked
        var isRadioChecked = $('#kilasy_nbrMambraUsed_1').is(':checked');

        // Get the value of kilasy_nbrMambra
        var kilasyNbrMambraValue = $('#kilasy_nbrMambra').val();

        // Check your conditions here
        if (isRadioChecked && kilasyNbrMambraValue !== '') { // Allow form submission
        } else { // Prevent form submission
            event.preventDefault();
            alert('Veuillez renseigner le nombre');
        }
    });

});