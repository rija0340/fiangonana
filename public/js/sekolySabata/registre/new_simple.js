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

  //evenement ecoutant changement de select kilasy


  $('#registre_kilasy').change(function () {



    getDataKilasy();

  });


  function getDataKilasy(){
    var kilasy = $('#registre_kilasy').val();
    const currentDomain = window.location.hostname;
    console.log(currentDomain);
    //ajax getting all the data
    $.ajax({
      type: 'GET',
      url: currentDomain+':8000/sekoly-sabata/kilasy/data-mambra/'+kilasy,
      dataType: 'json',
      success: function (data) {
        console.log(data);
      }
    });
  }


  //evenement ecoutant changement de select kilasy

});