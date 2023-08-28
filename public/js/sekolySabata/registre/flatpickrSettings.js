document.addEventListener('DOMContentLoaded', function () {

    var currentDate = new Date();
    var dafaultDate = "";
    if (typeof $("#dateSessionRegistre").val() === 'undefined') {
        dafaultDate = null;
    } else {
        dafaultDate = new Date($("#dateSessionRegistre").val());
        getClassesWithoutRegistre($("#dateSessionRegistre").val());
    }
    flatpickr('#registre_createdAt', {
        enableTime: false, // Set to true if you want to include time selection
        dateFormat: 'd-m-Y',
        maxDate: currentDate,
        defaultDate: dafaultDate,
        // Date format
        // Additional configuration options...
        locale: {
            weekdays: {
                shorthand: [
                    'Dim',
                    'Lun',
                    'Mar',
                    'Mer',
                    'Jeu',
                    'Ven',
                    'Sam'
                ],
                longhand: [
                    'Dimanche',
                    'Lundi',
                    'Mardi',
                    'Mercredi',
                    'Jeudi',
                    'Vendredi',
                    'Samedi'
                ]
            },
            months: {
                shorthand: [
                    'Jan',
                    'Fév',
                    'Mar',
                    'Avr',
                    'Mai',
                    'Juin',
                    'Juil',
                    'Août',
                    'Sept',
                    'Oct',
                    'Nov',
                    'Déc'
                ],
                longhand: [
                    'Janvier',
                    'Février',
                    'Mars',
                    'Avril',
                    'Mai',
                    'Juin',
                    'Juillet',
                    'Août',
                    'Septembre',
                    'Octobre',
                    'Novembre',
                    'Décembre'
                ]
            }
        },
        disable: [function (date) { // Désactiver toutes les dates sauf les samedis
            return date.getDay() !== 6;
            // 6 représente le samedi(0 = dimanche, 1 = lundi, ..., 6 = samedi)
        }
        ],
        onChange: function (selectedDates, dateStr, instance) {
            console.log('Date sélectionnée : ' + dateStr);
            getClassesWithoutRegistre(dateStr);
            instance.close();
        }
    });

    function getClassesWithoutRegistre(date) {
        $.ajax({
            type: 'GET',
            url: '/sekoly-sabata/registre/kilasy-without-registre/' + date,
            Type: "json",
            success: function (data) {
                console.log(data);

                $('#registre_kilasy').empty();
                var option = "";
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        var nomKilasy = data[key];
                        var idKilasy = parseInt(key);
                        option += `<option value=${idKilasy}> ${nomKilasy} </option>`;
                    }
                }
                $('#registre_kilasy').html(option);

            },
            error: function (erreur) {
                // alert('La requête n\'a pas abouti' + erreur);
                console.log(erreur.responseText);
            }
        });
    }
});