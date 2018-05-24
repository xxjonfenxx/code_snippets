<?php 
function upload_media($posted_data, $files) 
{

    // Response array to send back to function
    $response = [];

    // Capture post id if submitted in the posted data
    $post_id = $posted_data['post_id'];

    // Loop through files
    foreach( $files as $key => $value ) {
        
        // Upload file, $key is the form field name
        // Post id is used to attach image to post
        $attachment_id = media_handle_upload( $key, $post_id );

        // Check for error, if is error, set error response
        if( is_wp_error( $attachment_id ) ) {
            $response['response'] = 'error';
            $response['error'] = $attachment_id;
        } else {
            // Else set successful response
            $response['response'] = 'success';
        }
    }
    return $response;
    die();
}

function do_upload_file() 
{

    // Check for autosave and return if doing autosave
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Set $_POST data to variable 
    $posted_data = isset( $_POST ) ? $_POST : array();

    // Files passed in get put in the $_FILES array
    $files = isset( $_FILES ) ? $_FILES : array();
    $result = [];

    // Only do upload_media if files isn't empty
    if( !empty( $files ) ) {
        // Get response from function
        $result = upload_media( $posted_data, $files );
    }
    
    // Output the response to javascript so actions can be performed
    if( $result ) {
        exit( json_encode( $result ) );
    }
    die();
}
add_action('wp_ajax_upload_file', 'do_upload_file');