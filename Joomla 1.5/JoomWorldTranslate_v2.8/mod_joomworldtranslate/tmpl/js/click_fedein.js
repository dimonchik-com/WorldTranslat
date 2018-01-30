jQuery.noConflict();
(function ($) {
    $(window).load(function () {
        offset = $("#translate_translate").offset();
        height = $("#translate_translate").height();
        translate_translate_width = $("#translate_translate").width();
        max_width = $(window).width();
        curent_left = offset.left;
        width_translate_popup = $("#translate_popup").width();
        rezultat = max_width - curent_left;
        if (rezultat < width_translate_popup) {
            leftofset = offset.left - width_translate_popup + translate_translate_width-15;
            $("#translate_popup").css({
                "display": "none",
                "top": offset.top + height + "px",
                "left": leftofset + "px"
            });
        } else {
            $("#translate_popup").css({
                "display": "none",
                "top": offset.top + height + "px",
                "left": offset.left + "px"
            });
        }
        text_to_insert = $("#translate_popup").clone();
        $("#translate_popup").remove();
        $("body").append(text_to_insert);
        $("#translate_translate").toggle(function () {
            $("#translate_popup").fadeIn();
        }, function () {
            $("#translate_popup").fadeOut();
        });
    });
})(jQuery);