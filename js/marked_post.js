(function ($) {

    $.fn.incirRender = function (data) {
        var input = '<input type="hidden" name="posts[]" value="{0}" />';
        var li = '<li name="{0}" class="incir-marked-post">{1}</li>';
    };

    $.fn.incirSelectRender = function (data) {
        var li = '<li name="{0}" class="incir-marked-post">{1}</li>';
        var text = '';

        $.each(data, function (key, value) {
            text = text + String.format(li, value.id, value.post_title);
        });
        this.fadeOut('slow', function () {
            $(this).html(text).fadeIn();
        });
    };

    String.format = function () {
        var theString = arguments[0];
        for (var i = 1; i < arguments.length; i++) {

            var regEx = new RegExp("\\{" + (i - 1) + "\\}", "gm");
            theString = theString.replace(regEx, arguments[i]);
        }

        return theString;
    };

    // Array Remove - By John Resig (MIT Licensed)
    Array.prototype.remove = function (from, to) {
        var rest = this.slice((to || from) + 1 || this.length);
        this.length = from < 0 ? this.length + from : from;
        return this.push.apply(this, rest);
    };

    $.fn.incirSelectPost = function (input, selected) {
        input.incirAddVal(this.attr('name'));
        this.appendTo(selected);
    };

    $.fn.incirAddVal = function (value) {
        var val = this.val();
        val = val.split(',');

        if (val[0] == '') {
            val.remove(0);
        }
        val.push(value);
        val = val.join();
        this.val(val);
    };

    $.fn.incirRemoveVal = function (value) {
        var values = this.val().split(',');
        $.each(values, function (key, val) {
            if (val === value) {
                values.remove(key);
            }
        });
        values = values.join();
        this.val(values);
    };

    $.fn.incirUnSelect = function (input) {
        var val = this.attr('name');
        $(input).incirRemoveVal(val);
        this.remove();
    };

}(jQuery));

jQuery(document).ready(function ($) {
    var timer, delay = 600;
    $(document).on('keyup', "input[type='text'].incir-marked-post", function () {
        var input = this;
        clearTimeout($.data(this, 'timer'));

        var wait = setTimeout(function () {
            var url = $(input).parent().find('.incir-marked-post-url').val();
            var value = $(input).val();
            var notIn = $(input).parent().find('input[type="hidden"].incir-marked-post').val();
            var listClass = '.incir-marked-list';
            var list = $(input).parent().parent().find(listClass);

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    title: value,
                    not_in: notIn
                },
                beforeSend: function () {
                    $('<span class="input spinner"></span>').insertAfter($(input));
                },
                success: function (data) {
                    if (data.success == true) {
                        list.incirSelectRender(data.data);
                    } else {
                        list.fadeOut('slow', function () {
                            $(this).html('');
                        });
                    }
                },
                complete: function () {
                    $(input).next().remove();
                }
            });
        }, 600);

        $(this).data('timer', wait);
    });

    $('body').on('click', function (event) {
        if (event.target.className == 'incir-marked-list') {
            return;
        }

        if (event.target.className == 'incir-marked-post') {
            return;
        }

        if ($('div.incir-marked-post').find(event.target).length == 1) {
            return;
        }

        if ($('div.incir-marked-list').find(event.target).length == 0) {
            $('div.incir-marked-list').hide('slow');
        }
    });

    $('body').on('click', 'div.incir-marked-list li', function (e) {
        var input = $(this).parent().parent().find('input[type="hidden"].incir-marked-post');
        var moveDiv = $(this).parent().parent().find('div.incir-marked-post');
        $(this).incirSelectPost(input, moveDiv);
    });

    $('body').on('click', 'div.incir-marked-post li', function () {
        var input = $(this).parent().parent().find('input[type="hidden"].incir-marked-post');
        $(this).incirUnSelect(input);
    });

});