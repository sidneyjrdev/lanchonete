//adm

$(document).ready(function(){

$.datepicker.setDefaults( $.datepicker.regional[ "pt-BR" ] );


$("#dataDestaque").datepicker({
    minDate: '+1d'
});

$(".btnMenuCelular").click(function(){
   $(".menu-adm-celular").toggle(); 
});

$("#txtPreco").maskMoney({symbol:"R$",decimal:",",thousands:"."});

$("#txtPrecoCad").maskMoney({symbol:"R$",decimal:",",thousands:"."});

$(".alert").delay(2000).fadeOut("slow");

});