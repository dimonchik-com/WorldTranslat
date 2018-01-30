jQuery.noConflict();
(function ($) {
    $(window).load(function () {
        worldone = $("#worldone").clone();
        $("#worldone").remove();
        $("body").prepend(worldone);
        $(".worldcont_two").hover(

        function () {
            $(".worldcont_three").fadeIn("slow");
        });
        $(".worldcont_three").hover(

        function () {}, function () {
            $(".worldcont_three").fadeOut("slow");
        });
    });
})(jQuery);