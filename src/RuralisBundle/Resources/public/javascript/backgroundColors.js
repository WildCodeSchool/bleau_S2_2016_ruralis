$(document).ready(function() {
    if ('{{ app.session.get("type") }}' == 'lecteur'){
        $('#abomodel').css('background-color', 'rgba(138,225,58,0.75)');
    }
    else if ('{{ app.session.get("type") }}' == 'donateur'){
        $(".abomodel").css('background-color', 'rgba(239,255,0,0.55)');
    }
    else if ('{{ app.session.get("type") }}' == 'ambassadeur'){
        $(".abomodel").css('background-color', 'rgba(247,113,24,0.75)');
    }
});