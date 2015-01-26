$( document ).ready(function() {
    $( "form.ajaxMail" ).submit(function( event ) {
        event.preventDefault();
        $(this).hide();
        $(this).parent().addClass('loading');

        $.ajax({
            async: 'true',
            url: 'index.php?type=666',
            type: 'POST',
            data : $(this).serialize(),
            success: function(result) {
                var el = $('.loading');
               $(el).removeClass('loading');
               $(el).html('<div class="alert alert-success">Thank you. Your mail was successfully sent.</div>');
            },
            error: function(error) {
                var el = $('.loading');
                $(el).removeClass('loading');
                $(el).prepend('<div class="alert alert-danger">An error occured. Please try again.</div>');
                $('form.ajaxMail').show();
            }
        });
    });

});