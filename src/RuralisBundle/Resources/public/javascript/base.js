//Theme Name: Ruralis
//Authors: Marielle Lautrou and Aurore David


$(document).ready(function(){
    var offset2 = $(document).height();
    var lineHF = offset2 - $("#bottommark").position().top;
    $(window).scroll(function(){
        var offset1 = $(document).height() - window.screen.availHeight;
        var offset = $(window).scrollTop();
        var lineH = offset1 - $("#bottommark").position().top - offset;
        var lineHpart = lineHF/15;
        $("iconeanime").html(lineH);
        if (lineH > lineHpart*15) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre1.png");
        }
        if ((lineH < lineHpart*14) && (lineH > lineHpart*13)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre2.png");
        }
        if ((lineH < lineHpart*13) && (lineH > lineHpart*12)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre3.png");
        }
        if ((lineH < lineHpart*12) && (lineH > lineHpart*11)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre4.png");
        }
        if ((lineH < lineHpart*11) && (lineH > lineHpart*10)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre5.png");
        }
        if ((lineH < lineHpart*10) && (lineH > lineHpart*9)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre6.png");
        }
        if ((lineH < lineHpart*9) && (lineH > lineHpart*8)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre7.png");
        }
        if ((lineH < lineHpart*8) && (lineH > lineHpart*7)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre8.png");
        }
        if ((lineH < lineHpart*7) && (lineH > lineHpart*6)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre9.png");
        }
        if ((lineH < lineHpart*6) && (lineH > lineHpart*5)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre10.png");
        }
        if ((lineH < lineHpart*5) && (lineH > lineHpart*4)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre11.png");
        }
        if ((lineH < lineHpart*4) && (lineH > lineHpart*3)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre12.png");
        }
        if ((lineH < lineHpart*3) && (lineH > lineHpart*2)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre13.png");
        }
        if ((lineH < lineHpart*2) && (lineH > lineHpart*1)) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre14.png");
        }
        if (lineH < lineHpart) {
            $("#animation").attr("src", asset + "bundles/ruralis/images/logoarbre15.png");
        }
    });
    var height_img_header = $("#image_header").height();
    $("header").css("height", height_img_header + 30);
});