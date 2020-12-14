

let Page = {
    locale: $.cookie('locale') || 'de',
    setLocale: function(locale) {
        $.cookie('locale', locale);
        this.locale = locale;
    },
    getLocale: function() {
        return this.locale;
    }
};

let LocaleContent = {
    switchLocale: function(locale) {

    }
};

$(document).ready(function(){

});