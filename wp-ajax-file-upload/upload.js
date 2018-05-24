function savePhoto() {
    $(".button").on( 'click', function() {
        // Get file upload field
        var fileUpload = document.getElementById( '#fileFieldID' );
        // Get post id if required
        var post_id = $( '.post_id' ).val();
        // Setup form data object to pass into ajax request
        // Didn't have success using a standard object
        var formData = new FormData();
        // Add fields as required
        formData.append( 'post_id', post_id );
        formData.append( 'file', fileUpload.files[0]);
        // Action name to perform, you will need to capture this with php
        formData.append( 'action', 'upload_file' );
        $.ajax({
            type: 'POST',
            // custom_ajax is the name given when you register scripts with wp_enqueue_scripts
            url: custom_ajax.ajax_url,
            data: formData,
            cache: false,
            // These must be set to false
            processData: false,
            contentType: false,
            success: function( response ) {
                var response = JSON.parse(response);
            },
            error: function( errormessage ) {
                console.log( errormessage );
            }
        });
    });
}