function userRequestFormData(){
    var error = false;
    var serialized = jQuery( '#user_request' ).serialize();
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: ajax_user_request_object.ajaxurl,
        data: serialized,
        success: function(data){
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
            if(typeof(data['success']) != "undefined" &&  data['success'].length != 0 &&  data['success'] == 'success'){
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
    var status_check = jQuery("#status_check").val();
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        url: ajax_get_conversation_date_object.ajaxurl,
        data:{
           action : 'get_conversation_date',
           status_check: status_check,
           receiverid: receiverid,
           none: 'none'
         },
        success: function(data){
            if(typeof(data['error']) != "undefined" &&  data['error'].length != 0){  
                
            }else{ 
                jQuery("#get_messages").html(data['success']);  
                jQuery("#unreadcount").html(data['unreadcount']);
            }
        }
    });

    return false
}

function getConversationCount(id){
    var error = false;
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        url: ajax_get_conversation_count_object.ajaxurl,
        data:{
           action : 'get_conversation_data_count',
           receiver_id: id,
           none: 'none'
         },
        success: function(data){
            if(typeof(data['error']) != "undefined" &&  data['error'].length != 0){  
                
            }else{ 
                jQuery("#unreadcount").html(data['unreadcount']); 
            }
        }
    });

    return false
}

// Definition
/*function setIntervalLimited(callback, interval, x) {

    for (var i = 0; i < x; i++) {
        setTimeout(callback, i * interval);
    }

}*/
// Usage
if( jQuery( "#check_chat" ).length ){
    setInterval(function() {
        getConversationData();
    }, 5000);
}else{
    if( jQuery( "#user_unread_data" ).length ){
        var receiverID = jQuery( "#user_unread_data" ).data('receiver');
        setInterval(function() {
            getConversationCount(receiverID);
        }, 5000);
    }  
}


