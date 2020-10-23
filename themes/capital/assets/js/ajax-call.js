function userRequestFormData(){
    var error = false;
    var serialized = jQuery( '#user_request' ).serialize();
    //console.log(serialized);
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: ajax_user_request_object.ajaxurl,
        data: serialized,
        success: function(data){
            console.log(data);
            if(typeof(data['success']) != "undefined" &&  data['success'].length != 0){
                jQuery('.selectpicker').selectpicker('refresh');
                jQuery("#request_notes").val('');
                jQuery("#request_file").val('');
                jQuery("#choose_file").text('UPLOAD A FILE');
                jQuery('#message').html('<span class="re-success">'+data['success']+'</span>');
                
            }else{
                jQuery('#message').html('<span class="re-error">'+data['error']+'</span>');
            }
        }
    });

    return false
}