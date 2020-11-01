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
            if(typeof(data['success']) != "undefined" &&  data['success'].length != 0 &&  data['success'] == 'success'){
                jQuery("#get_messages").append(data['message']);
                jQuery("#message").val('');
            }else{
                
            }
        }
    });

    return false
}

function getConversationData1(){
    var error = false;
    var receiverid = jQuery("#receiverid").val();
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
                //console.log(data['success']);
                jQuery("#get_messages").html(data['success']);  
                jQuery("#unreadcount").html(data['unreadcount']);
            }
        }
    });

    return false
}

function getConversationCount1(){
    var error = false;
    var receiverid = jQuery("#receiverid").val();
    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        async: true,
        url: ajax_get_conversation_date_object.ajaxurl,
        data:{
           action : 'get_conversation_data_count',
           receiverid: receiverid,
           none: 'none'
         },
        success: function(data){
            console.log(data);
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
setInterval(function() {
    getConversationData();          // => hit...hit...etc (every second, stops after 10)
}, 5000);