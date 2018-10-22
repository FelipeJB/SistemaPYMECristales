//Medidas

function tomarMedidas(){
    $('.formMedidasNegativas').hide(300);
    $('.formMedidasPositivas').show(300);
}

function noTomarMedidas(){
    $('.formMedidasPositivas').hide(300);
    $('.formMedidasNegativas').show(300);
}

function cancelarMedidas(){
  $('.formMedidasPositivas').hide(300);
  $('.formMedidasNegativas').hide(300);
}

function programarInstalacion(){
    $('.formProgramacionNegativa').hide(300);
    $('.formProgramacionPositiva').show(300);
}

function noProgramarInstalacion(){
    $('#fecha').val("");
    $('.formProgramacionPositiva').hide(300);
    $('.formProgramacionNegativa').show(300);
}

function cancelarProgramarInstalacion(){
  $('#fecha').val("");
  $('.formProgramacionPositiva').hide(300);
  $('.formProgramacionNegativa').hide(300);
}
