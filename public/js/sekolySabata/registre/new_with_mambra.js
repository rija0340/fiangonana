$(document).ready(function () {

  $('#registre_kilasy').change(function () {
    getMambraKilasy($('#registre_kilasy').val());
  });


  function getMambraKilasy(kilasy_id) {

    var url = '/sekoly-sabata/kilasy/data-mambra/' + kilasy_id;
    $.ajax({
      type: 'GET',
      url: url,
      Type: "json",
      success: function (data) {
        $("#liste_mambra").empty();
        var ul = document.querySelector('#liste_mambra');
        for (let i = 0; i < data.length; i++) {

          var id = data[i].id;
          var nom = "";
          var prenom = "";
          if (data[i].nom != null) {
            var nom = data[i].nom;
          }
          if (data[i].prenom != null) {
            var prenom = data[i].prenom;
          }
          var nom_prenom = nom + " " + prenom;

          $("#liste_mambra").append(`
              <tr>
                <td>
                  ${nom_prenom}
                </td>
                <td>
                  <div class="icheck-primary d-inline">
                  <input type="checkbox" id="presence_${id}" name=" mambra[presence_${id}]" class="checkbox_presence" >
                  <label for="presence_${id}">
                  </label>
                  </div>
                </td>
                <td>
                <input type="number" class="form-control input_impito" id="impito_${id}" name="mambra[impito_${id}]">
                </div>
              </td>
              </tr>
                    `
          );
          remplissagePresence();
        }
      },
      error: function (erreur) {
        // alert('La requête n\'a pas abouti' + erreur);
        console.log(erreur.responseText);
      }
    });
  }

  function remplissagePresence() {

    $('.input_impito').each(function () {
      $(this).attr('readonly');
    });

    var mambraTongaEl = $('#registre_mambraTonga');
    $('.checkbox_presence').click(test());

  }

  function test() {
    var mT = 0;
    $('.checkbox_presence').each(function () {
      console.log('ato za');
      if ($(this).is(':checked')) {
        mT = mT++;
        console.log(mT);
      }
    });
  }

});