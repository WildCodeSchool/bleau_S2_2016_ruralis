$('.datepicker').pickadate({
//            selectMonths: true, // Creates a dropdown to control month
//            selectYears: 15 // Creates a dropdown of 15 years to control year
    format: 'dd mmmm yyyy',
    formatSubmit: 'mm/dd/yyyy'
});
$(document).ready(function() {
    $('select').material_select();
});
        var height_side_nav = $("header").height();
        var height_footer = $(".page-footer").height();
        $(".fixedSideNav").css("top", height_side_nav);
        $(".fixedSideNav").css("bottom", height_footer);
