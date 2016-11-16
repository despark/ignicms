(function ($) {
    var IgniValidation = {
        rules: {}
    };

    IgniValidation.rules.required = function (element, message) {
        var $el = $(element);
        var check = $el.val() !== '';
        if (!check) {
            if (!$el.hasClass('validate-required-failed')) {
                $el.closest('.form-group').addClass('has-error');
                $('<div class="text-red">' + message + '</div>').insertAfter($el);
                $el.addClass('validate-required-failed')
            }
        } else {
            $el.removeClass('validate-required-failed');
            $el.closest('.form-group').removeClass('has-error');
            $el.next().remove();

        }
        return check;
    };

    var validationRules = {
        'validate-required': {
            callback: IgniValidation.rules.required,
            message: 'The field is required.'
        }
    };

    $(function () {
        $('body').on('submit', 'form', function (e) {
            var that = $(this);
            var hasErrors = false;

            $.each(validationRules, function (i, value) {
                // fetch element
                var elements = $('.' + i, that);
                $.each(elements, function (idx, element) {
                    if (!value.callback(element, value.message)) {
                        hasErrors = true;
                    }
                });
            });
            if (hasErrors) {
                e.preventDefault();
                e.stopImmediatePropagation();
            }
        });

    });
})(jQuery);