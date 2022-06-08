/*$(document).ready(function () {
    var somethingChanged = true;

    $('.unsaved').change(function() {
        somethingChanged = true; 
    });

    $('#save').on("click", function() {
        somethingChanged = true; 
    });

    if (somethingChanged == true) {
        $(window).on('beforeunload', function() {
            return "You made some changes and it's not saved?";
        }
    } else {
        $(window).off('beforeunload');
    }
});*/