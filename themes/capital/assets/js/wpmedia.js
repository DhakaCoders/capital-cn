jQuery(document).ready( function($){
  if($('#choose_file').length){
      var logoMediaUploader;
    $('#choose_file').on('click', function(e){
       e.preventDefault();
        if(logoMediaUploader){
            logoMediaUploader.open();
            return;
        }
        
        logoMediaUploader = wp.media.frames.file_frame = wp.media({
           title: 'Choose a File',
           button: {
             text: 'Choose File'  
           },
            multiple: false
        });
        
        logoMediaUploader.on('select', function(){
          attachment = logoMediaUploader.state().get('selection').first().toJSON(); 
          console.log(attachment.filename);
          $('#request_file').val(attachment.id);
          $('#choose_file').text(attachment.filename);
        })
        
        logoMediaUploader.open();
    });
  }

});

function DeleteGalleryImage(id){
      var answer = confirm("Are you sure you want to remove gallery image?");
      if( answer == true ){
        jQuery('#myplugin-image-li'+id).remove('#myplugin-image-li'+id);
      }
      return;
}