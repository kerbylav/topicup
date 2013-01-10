var ls = ls ||
{};

ls.topicup = (function ($) {
    this.up = function (topicId) {
        ls.ajax(aRouter.ajax + 'topicup-up/', {'id':topicId}, function (result) {
            if (result.bStateError) {
                ls.msg.error(null, result.sMsg);
            } else {
                ls.msg.notice(null, result.sMsg);
            }
        }.bind(this));
        return false;
    };

    this.exclude = function (topicId, obj) {
        ls.ajax(aRouter.ajax + 'topicup-exclude/', {'id':topicId}, function (result) {
            if (result.bStateError) {
                ls.msg.error(null, result.sMsg);
            } else {
                ls.msg.notice(null, result.sMsg);
                var cnt=$('#excludedTopicsCount');
                if (cnt.length)
                {
                    var nn=cnt.text();
                    cnt.text(--nn);
                }
                var art = $(obj).parents('article.topic');
                if (art.length) {
                    art.slideUp();
                    $.scrollTo(art, 500);
                }
            }
        }.bind(this));
        return false;
    };

    this.init = function () {
    };

    return this;
}).call(ls.topicup ||
{}, jQuery);

jQuery(document).ready(function () {
    ls.topicup.init();
});
