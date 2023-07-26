$(document).ready(function () {

    $('#kilasy_nbrMambraUsed_1').attr('checked', 'checked');

    $('input[name="kilasy[nbrMambraUsed]"]').click(function () {
        const nbrInputEl = $('#kilasy_nbrMambra');
        var labelEl = $('label[for="kilasy_nbrMambra"]');
        if ($(this).val() == 'custom') {
            nbrInputEl.css('display', 'flex');
            nbrInputEl.attr('required', 'required');
            labelEl.css('display', 'flex');
        } else {
            nbrInputEl.css('display', 'none');
            nbrInputEl.removeAttr('required');
            nbrInputEl.val('');
            labelEl.css('display', 'none');
        }
    });
});