$(function () { // voir configuration daterangepicker


    // // Obtenez le premier samedi du mois
    // var start = moment().startOf('month').day(6);
    // if (start.month() !== moment().month()) {
    //     start.add(1, 'week');
    // }

    // // Obtenez le dernier samedi du mois
    // var end = moment().endOf('month').day(6);
    // if (end.month() !== moment().month()) {
    //     end.subtract(1, 'week');
    // }
    // function cb(start, end) {
    //     $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
    // }

    var start = moment().startOf('year').day(6);
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
    }
    $('#reportrange').daterangepicker({
        // changement de langue d'affichage des lables

        "locale": {
            "customRangeLabel": "Personnalisé",
            "applyLabel": "Appliquer",
            "cancelLabel": "Annuler"
        },
        applyButtonClasses: 'btn-danger',
        cancelButtonClasses: 'btn-dark',
        startDate: start,
        endDate: end,
        showDropdowns: true,
        // esoria le oe 1 mois fona ny intervalle
        linkedCalendars: false,
        // isInvalidDate: function (date) {
        //     // Vérifier si la date n'est pas un samedi
        //     return date.day() !== 6;
        // },

        ranges: {
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            '7 derniers jours': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            '1st Quarter': [moment().startOf('year'), moment().startOf('year').add(2, 'months').endOf('month')],
            '2nd Quarter': [moment().startOf('year').add(3, 'months'), moment().startOf('year').add(5, 'months').endOf('month')],
            '3rd Quarter': [moment().startOf('year').add(6, 'months'), moment().startOf('year').add(8, 'months').endOf('month')],
            '4th Quarter': [moment().startOf('year').add(9, 'months'), moment().endOf('year')],
            'First Bimester': [moment().startOf('year'), moment().startOf('year').add(5, 'months').endOf('month')],
            'Second Bimester': [moment().startOf('year').add(6, 'months'), moment().endOf('year')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        }
    }, cb);

    cb(start, end);

    //on load du fenetre, initialisation

    window.onload = function () {
    };

    $(document).ready(function (ev, picker) {
        statistique(start.format('DD-MM-YYYY'), end.format('DD-MM-YYYY'));
    });

    // fonction après evenement click bouton apply
    $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
        var dateDebut = picker.startDate.format('DD-MM-YYYY');
        var dateFin = picker.endDate.format('DD-MM-YYYY');

        statistique(dateDebut, dateFin);
    });


    //evement pour les boutons trimestres (année en cours )

    $('.btnTrimestre').click(function () {

        var element = $(this);
        var trimestre = element.attr('id');
        var dateDebut = "";
        var dateFin = "";
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        switch (trimestre) {
            case "trimestre1":
                dateDebut = "01-01-" + currentYear;
                dateFin = "31-03-" + currentYear;
                break;
            case "trimestre2":
                dateDebut = "01-04-" + currentYear;
                dateFin = "30-06-" + currentYear;
                break;
            case "trimestre3":
                dateDebut = "01-07-" + currentYear;
                dateFin = "30-09-" + currentYear;
                break;
            case "trimestre4":
                dateDebut = "01-10-" + currentYear;
                dateFin = "31-12-" + currentYear;
                break;

            default:
                break;
        }

        statistique(dateDebut, dateFin);

    })

    function statistique(dateDebut, dateFin) {

        $.ajax({
            type: 'GET',
            url: '/sekoly-sabata/stat/compose',
            data: {
                'dateDebut': dateDebut,
                'dateFin': dateFin
            },
            Type: "json",
            success: function (data) {
                $('#dateDebut').html(data['dateDebut']);
                $('#dateFin').html(data['dateFin']);
                $('#tatitraGeneral').html(data['tatitraGeneralParMois'] != '' ? data['tatitraGeneralParMois'] : data['tatitraGeneral']);

                $('#tatitraKilasyRehetra').html(data['tatitraRehetra']);
                initConfigCharts(data);

                console.log(data);
            },
            error: function (erreur) {
                // alert('La requête n\'a pas abouti' + erreur);
                console.log(erreur.responseText);
            }
        });

    }




    function initConfigCharts(data) {
        //tonga / mambra rejitra 
        var tongaMambraRejistraConfig = {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'tongaMambraRejistraConfig',
                        data: [],
                        backgroundColor: 'blue',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        //tonga / mambra rejitra 
        var impitoMambraTongaConfig = {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'impitoMambraTongaConfig',
                        data: [],
                        backgroundColor: 'red',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        //tonga / mambra rejitra 
        var impitoMambraRejistraConfig = {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'impitoMambraRejistraConfig',
                        data: [],
                        backgroundColor: 'green',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };
        //chart js 
        var ctx1 = document.getElementById('tongaMambraRejistraCanvas').getContext('2d');
        var tongaMambraRejitraChart = new Chart(ctx1, tongaMambraRejistraConfig);

        var ctx2 = document.getElementById('impitoMambraTongaCanvas').getContext('2d');
        var impitoMambraTongaChart = new Chart(ctx2, impitoMambraTongaConfig);

        var ctx3 = document.getElementById('impitoMambraRejistraCanvas').getContext('2d');
        var impitoMambraRejitraChart = new Chart(ctx3, impitoMambraRejistraConfig);

        updateChartData(data['labels'], data['tongaMambraRejitraData'], tongaMambraRejitraChart, tongaMambraRejistraConfig);
        updateChartData(data['labels'], data['impitoMambraTongaData'], impitoMambraTongaChart, impitoMambraTongaConfig);
        updateChartData(data['labels'], data['impitoMambraRejitraData'], impitoMambraRejitraChart, impitoMambraRejistraConfig);
    }

    function updateChartData(labels, dataJson, chartEl, chartConfig) {
        chartConfig.data.labels = labels;
        chartConfig.data.datasets[0].data = dataJson;
        chartEl.update();
    }

});