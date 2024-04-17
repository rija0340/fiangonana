document.addEventListener('DOMContentLoaded', function () {
    flatpickr('#datepickerSabataTest', {
        enableTime: false, // Set to true if you want to include time selection
        dateFormat: 'd-m-Y',
        mode: "multiple",
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
            return date.getDay() !== 6 && date.getDay() !== 3 && date.getDay() !== 5;
            // 6 représente le samedi(0 = dimanche, 1 = lundi, ..., 6 = samedi)
        }
        ],
        onChange: function (selectedDates, dateStr, instance) {
            console.log('Date sélectionnée : ' + dateStr);
            instance.close();
        }
    });
});