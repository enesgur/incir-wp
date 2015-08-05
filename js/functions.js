(function ($) {

    isSmall = function () {
        return matchMedia(Foundation.media_queries['small']).matches && !matchMedia(Foundation.media_queries.medium).matches;
    };

    isMedium = function () {
        return matchMedia(Foundation.media_queries['medium']).matches && !matchMedia(Foundation.media_queries.large).matches;
    };

    isLarge = function () {
        return matchMedia(Foundation.media_queries['large']).matches;
    };


    $.fn.homeColumnSize = function () {
        var list = this;
        var size = Array();
        var columnSize = (isLarge()) ? 3 : (isMedium()) ? 2 : 1;
        var group = Array();

        if (columnSize === 1) {
            return false;
        }

        for (var i = 1; i <= columnSize; i = i + 1) {
            var forSize = i - 1;
            group[forSize] = Array();
        }

        $(list).each(function (index, value) {
            size[index] = {width: $(value).outerWidth(), height: $(value).outerHeight()};
        });

        var length = 0;
        $(list).each(function (index, value) {
            length = (length === columnSize) ? 0 : length;
            group[length][index] = value;
            length = length + 1;
        });

        $.each(group, function (index, value) {
            $.each(value, function (key, val) {
                if ($(val).length === 0) {
                    return;
                }
                var topPlus = 0;
                var leftPlus = 0;
                $.each(value, function (subKey, subVal) {
                    if (subVal == undefined) {
                        return;
                    }
                    if (subKey === key) {
                        return false;
                    }
                    topPlus = topPlus + size[subKey].height;
                });

                size[key].top = topPlus;
            });
        });

        var length = 0;
        $.each(list, function (index, value) {
            length = (length === columnSize) ? 0 : length;
            size[index].left = length * size[index].width;
            length = length + 1;
        });

        return size;
    }

    $.fn.homeStyle = function () {
        var homeColumn = this.homeColumnSize();
        this.each(function (index, value) {
            $(value).css({
                top: homeColumn[index].top,
                left: homeColumn[index].left
            });
        });
    };

    $.fn.sectionSize = function () {
        var size = isLarge() ? 3 : 2;

        var array = Array(), arrays = Array();
        this.find('div.column').each(function (index, value) {
            array[index] = value;
        });

        while (array.length > 0) {
            arrays.push(array.splice(0, size));
        }

        var total = [];

        $(arrays).each(function (index, value) {
            $(value).each(function (key, val) {
                var height = $(val).outerHeight(); 
                var _total = total[key] == undefined ? 0 : total[key];
                total[key] = _total + height;
            });
        });

        var top = Math.max.apply(Math, total);

        this.animate({
            height: top
        }, {
            step: function () {
                $(this).find('div.loader').fadeOut();
            },
            complete: function () {
                $(this).find('div.row').css('visibility', 'visible');
            }
        });

        //this.height(top);
    }
})(jQuery);
