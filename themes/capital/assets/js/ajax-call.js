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

function userConversationFormData(){
    var error = false;
    var serialized = jQuery( '#user_conversation' ).serialize();
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: ajax_user_conversation_object.ajaxurl,
        data: serialized,
        success: function(data){
            console.log(data);
            if(typeof(data['success']) != "undefined" &&  data['success'].length != 0){
                jQuery("#get_messages").append(data['message']);
                jQuery("#message").val('');
            }else{
                
            }
        }
    });

    return false
}

function getConversationData(){
    var error = false;
    var receiverid = jQuery("#receiverid").val();
    console.log(receiverid);
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        url: ajax_get_conversation_date_object.ajaxurl,
        data:{
           action : 'get_conversation_date',
           receiverid: receiverid,
           none: 'none'
         },
        success: function(data){
            console.log(data);
            if(typeof(data['error']) != "undefined" &&  data['error'].length != 0){
                
                
            }else{ 
                var len = data.length;
                for(var i=0; i<len; i++){
                    
                    if(receiverid == data[i].sender ){
                        var tr_str = "<div class='message-receiver'><span class='chatavatar'></span><span class='receiver'>" +data[i].message+"</span></div>";
                    }else{
                       var tr_str = "<div class='message-sender'><span class='sender'>" +data[i].message+"</div>"; 
                    }
                    jQuery("#get_messages").append(tr_str);
                }
                
            }
        }
    });

    return false
}