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
