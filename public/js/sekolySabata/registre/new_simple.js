$(document).ready(function () {
  $('#registre_mambraTonga').change(function () {
    fill();
  });

  $('#registre_mpamangy').change(function () {
    fill();
  });

  function fill() {
    var mambraTonga = $('#registre_mambraTonga').val();
    var mpamangy = $('#registre_mpamangy').val();

    if (typeof mambraTonga != 'undefined' && mambraTonga != '' && typeof mpamangy != 'undefined' && mpamangy != '') {
      $('#registre_tongaRehetra').val(parseInt(mambraTonga) + parseInt(mpamangy));
    } else {
      if (mpamangy != '' && typeof mpamangy != 'undefined') {
        $('#registre_tongaRehetra').val(mpamangy);
      } else if (mambraTonga != '' && typeof mambraTonga != 'undefined') {
        $('#registre_tongaRehetra').val(mambraTonga);
      }
    }
  }

  //on load 

  var idKilasy = $('#registre_kilasy').val();
  getKilasyData(idKilasy);

  //ajax for retrieving data
  $('#registre_kilasy').change(function () {

    var idKilasy = $('#registre_kilasy').val();
    idKilasy = parseInt(idKilasy);

    getKilasyData(idKilasy);

  });

  function getKilasyData(idKilasy) {

    $.ajax({
      type: 'GET',
      url: '/sekoly-sabata/kilasy/data-kilasy/' + idKilasy,
      Type: "json",
      success: function (data) {
        console.log(data);
        //renseigner les details d'une classe 
        $('#nomKilasy').text(data.nom);
        $('#type').text(data.nbrMambraUsed);
        $('#nbrRegistre').text(data.nbrMambraRegistre);
        $('#nbrCustom').text((data.nbrMambra === null) ? 0 : data.nbrMambra);
        $('#btnEditKilasy').attr('href', "/sekoly-sabata/kilasy/" + idKilasy + "/edit");
      },
      error: function (erreur) {
        // alert('La requête n\'a pas abouti' + erreur);
        console.log(erreur.responseText);
      }
    });

  }

});