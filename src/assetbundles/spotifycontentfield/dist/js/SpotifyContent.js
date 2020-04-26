function fetchUrl(fieldId, validateUrl, validationError) {

    var spotifyContentField = $("#" + fieldId);

    var data = {
        string: spotifyContentField.val()
    };


    loader('start', spotifyContentField, fieldId, true);

    $.ajax({
        type: "POST",
        url: validateUrl,
        data: data,
        dataType: 'json',
        success: function (response) {
            loader('stop', spotifyContentField, fieldId, true);
            removeErrors(spotifyContentField, fieldId);
            spotifyContentField.parents().find('iframe').remove();
            createEmbedPreview(response, spotifyContentField);
        },
        error: function () {
            loader('stop', spotifyContentField, fieldId, true);
            spotifyContentField.parents().find('iframe').remove();
            removeErrors(spotifyContentField, fieldId);
            spotifyContentField.parent().append('<ul class="errors"><li>' + validationError + '</li></ul>');
        }
    });

}

function createEmbedPreview(segments, spotifyContentField) {
    spotifyContentField.parent().append('<iframe class="spotify-content-embedded-player" src="https://open.spotify.com/' + segments.embed_type + '/' + segments.content_type + '/' + segments.content_id + '" width="100%" height="' + (segments.embed_type === 'embed' ? '80px' : '232px') + '" frameborder="0" allowtransparency="true"></iframe>');
}

function loader(action, spotifyContentField, fieldId, removeError) {
    spotifyContentField.parents().find('iframe').remove();
    if (action === 'start') {
        removeErrors(spotifyContentField, fieldId);
        spotifyContentField.addClass('spotify-content-blurred')
        spotifyContentField.parent().find('.spotify-content-loader-wrapper').remove();
        spotifyContentField.parent().append('<div class="spotify-content-loader-wrapper"><div class="spotify-content-loader"></div></div>');
    } else {
        spotifyContentField.removeClass('spotify-content-blurred')
        if (removeError) {
            removeErrors(spotifyContentField, fieldId);
        }
        spotifyContentField.parent().find('.spotify-content-loader-wrapper').remove();
    }
}

function removeErrors(spotifyContentField, fieldId) {
    $('#' + fieldId + '-field').find('ul.errors').remove();
    spotifyContentField.parent().find('ul.errors').remove();
}

/**
 * Spotify content plugin for Craft CMS
 *
 * SpotifyContent Field JS
 *
 * @author    Jorge Anzola
 * @copyright Copyright (c) 2020 Jorge Anzola
 * @link      anzola.nl
 * @package   SpotifyContent
 * @since     1.0.0SpotifyContentSpotifyContent
 */

;(function ($, window, document, undefined) {

    var pluginName = "SpotifyContentSpotifyContent",
        defaults = {};

    // Plugin constructor
    function Plugin(element, options) {
        this.element = element;

        this.options = $.extend({}, defaults, options);

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function (id) {
            var _this = this;

            $(function () {

                /* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */

            });
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                    new Plugin(this, options));
            }
        });
    };

})(jQuery, window, document);
