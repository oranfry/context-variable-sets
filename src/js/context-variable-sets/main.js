(function(){
    const $form = $('#cvs-form');

    window.cvsApply = function() {
        window.location.href = getRefreshLink();
    };

    window.softCvsApply = function() {
        window.history.replaceState({}, document.title, getRefreshLink());
    };

    var getFiltersQuery = function() {
        var queryParams = getQueryParams();

        delete queryParams._returnurl;
        delete queryParams.back;

        return $.param(queryParams);
    };

    var getJsonFromUrl = function(url)
    {
        var question = url.indexOf("?");
        var hash = url.indexOf("#");

        if (hash==-1 && question==-1) {
            return {};
        }

        if (hash==-1) {
            hash = url.length;
        }

        var query = question == -1 || hash == question + 1 ? url.substring(hash) : url.substring(question + 1, hash);
        var result = {};

        query.split("&").forEach(function(part) {
            if (!part) {
                return;
            }

            part = part.split("+").join(" "); // replace every + with space, regexp-free version

            var eq = part.indexOf("=");
            var key = eq > -1 ? part.substr(0, eq) : part;
            var val = eq > -1 ? decodeURIComponent(part.substr(eq + 1)) : "";
            var from = key.indexOf("[");

            if (from==-1) {
                result[decodeURIComponent(key)] = val;
            } else {
                var to = key.indexOf("]", from);
                var index = decodeURIComponent(key.substring(from + 1,to));
                key = decodeURIComponent(key.substring(0, from));

                if (!result[key]) {
                    result[key] = [];
                }

                if (!index) {
                    result[key].push(val);
                } else {
                    result[key][index] = val;
                }
            }
        });

        return result;
    };

    var getQueryParams = function() {
        var existingData = getJsonFromUrl(location.href);
        var data = $.extend(existingData, Object.fromEntries(new FormData($form[0])));

        // remove nullish
        for (var prop in data) {
            if (Object.prototype.hasOwnProperty.call(data, prop)) {
                if (!data[prop]) {
                    delete data[prop];
                }
            }
        }

        return data;
    };

    var getRefreshLink = function () {
        var data = Object.fromEntries(new FormData($form[0]));

        // remove nullish
        for (var prop in data) {
            if (Object.prototype.hasOwnProperty.call(data, prop)) {
                if (!data[prop]) {
                    delete data[prop];
                }
            }
        }

        delete data.back;
        delete data._returnurl;

        var query = $.param(data);
        return window.location.pathname + (query && '?' || '') + query;
    }

    var manip = function() {
        var manips_string = $(this).data('manips');

        if (!manips_string) {
            return;
        }

        var manips = manips_string.split('&');

        for (var i = 0; i < manips.length; i++) {
            var cv_name = manips[i].split('=')[0];
            var cv_value = manips[i].split('=')[1];
            var matches = cv_value.match(/^base64:(.*)/);
            var value;

            if (matches !== null) {
                value = atob(matches[1]);
            } else {
                value = cv_value;
            }

            $('[name="' + cv_name + '"]').val(value);
        }
    }

    $('a.cv-manip').on('click', function(e) {
        e.preventDefault();

        if ($(this).hasClass('cv-disabled')) {
            return;
        }

        manip.call(this);
        cvsApply();
    });

    $('input.cv-manip:not(.cv-surrogate), select.cv-manip:not(.cv-surrogate)').on('change', function(e) {
        if ($(this).hasClass('cv-disabled')) {
            return;
        }

        manip.call(this);
        cvsApply();
    });

    $('.cv-surrogate').on('change', function(e) {
        e.preventDefault();

        if ($(this).hasClass('cv-disabled')) {
            return;
        }

        var for_cv = $(this).data('for');
        var value = $(this).is('[type="checkbox"]') && $(this).is(':checked') || $(this).val() || null;
        var $for = $form.find('[name="' + for_cv + '"]');

        $for.val(value);

        if ($(this).is('.cv-manip')) {
            manip.call(this);
        }

        if (!$(this).is('.no-autosubmit')) {
            cvsApply();
        }
    });

    $('.cv').on('change', function(e){
        cvsApply();
    });
})();
