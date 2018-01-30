(function ($) {
    var methods = {
        init: function () {
            new CardJs(this);
        }
    };
    $.fn.CardJs = function (methodOrOptions) {
        if (methods[methodOrOptions]) {
            return methods[methodOrOptions].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof methodOrOptions === "object" || !methodOrOptions) {
            return methods.init.apply(this, arguments);
        } else {
            $.error("Method " + methodOrOptions + " does not exist on jQuery.CardJs");
        }
    };
}(jQuery));
$(function () {
    $(".card-js").each(function (i, obj) {
        $(obj).CardJs();
    });
});
