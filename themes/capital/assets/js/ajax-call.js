getConversationData();
function userConversationFormData(){
    var error = false;
    var serialized = jQuery( '#user_conversation' ).serialize();
    console.log(serialized);
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: ajax_user_conversation_object.ajaxurl,
        data: serialized,
        success: function(data){
            console.log(data);
            getConversationData();
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

function getConversationData(){
    var error = false;
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: ajax_get_conversation_date_object.ajaxurl,
        data:{
           action : 'get_conversation_date',
           none: 'none'
         },
        success: function(data){
            console.log(data);
            if(typeof(data['error']) != "undefined" &&  data['error'].length != 0){
                
                
            }else{ 

                var len = data.length;
                for(var i=0; i<len; i++){
                    console.log(data[i].message);
                    var tr_str = "<div>" +data[i].message+"</div>";

                    jQuery("#get_messages").append(tr_str);
                }
                
            }
        }
    });

    return false
}



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