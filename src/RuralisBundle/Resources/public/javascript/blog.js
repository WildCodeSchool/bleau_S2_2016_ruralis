$('.datepicker').pickadate({
//            selectMonths: true, // Creates a dropdown to control month
//            selectYears: 15 // Creates a dropdown of 15 years to control year
    format: 'dd mmmm yyyy',
    formatSubmit: 'mm/dd/yyyy'
});
$(document).ready(function() {
    $('select').material_select();
});


/* MISE EN FORME DES IMAGES CARREES */
$(document).ready(function() {

    if ($(window).width() > 739) {
        var heightDiv = $('.colCustom').css('width');
        $('.colCustom').css("height", heightDiv);
        $('.imgDamier').css("height", heightDiv).css("width", heightDiv);
        $(window).resize(function() {
            var heightDiv = $('.colCustom').css('width');
// console.log(heightDiv);
            $('.colCustom').css("height", heightDiv);
            $('.imgDamier').css("height", heightDiv).css("width", heightDiv);
        });
    }

    else {
//Add your javascript for small screens here
        var heightDiv = $('.colCustom').css('width');
        $('.colCustom').css("height", heightDiv/2);
        $('.notForSmall').addClass('hide-on-small-only');
        $('.imgDamier').css("height", heightDiv).css("width", heightDiv);
        $(window).resize(function() {
            var heightDiv = $('.colCustom').css('width');
            $('.colCustom').css("height", heightDiv/2);
            $('.imgDamier').css("height", heightDiv).css("width", heightDiv);
        });
    }
});
