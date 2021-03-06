(function($) {

/*Google Map Style*/
var CustomMapStyles  = [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]

var windowWidth = $(window).width();
$('.navbar-toggle').on('click', function(){
	$('#mobile-nav').slideToggle(300);
});
	
  
//matchHeightCol
if($('.mHc').length){
  $('.mHc').matchHeight();
};
if($('.mHc1').length){
  $('.mHc1').matchHeight();
};
if($('.mHc2').length){
  $('.mHc2').matchHeight();
};
if($('.mHc3').length){
  $('.mHc3').matchHeight();
};
if($('.mHc4').length){
  $('.mHc4').matchHeight();
};
if($('.mHc5').length){
  $('.mHc5').matchHeight();
};


//$('[data-toggle="tooltip"]').tooltip();

//banner animation
$(window).scroll(function() {
  var scroll = $(window).scrollTop();
  $('.page-banner-bg').css({
    '-webkit-transform' : 'scale(' + (1 + scroll/2000) + ')',
    '-moz-transform'    : 'scale(' + (1 + scroll/2000) + ')',
    '-ms-transform'     : 'scale(' + (1 + scroll/2000) + ')',
    '-o-transform'      : 'scale(' + (1 + scroll/2000) + ')',
    'transform'         : 'scale(' + (1 + scroll/2000) + ')'
  });
});


if($('.fancybox').length){
$('.fancybox').fancybox({
    //openEffect  : 'none',
    //closeEffect : 'none'
  });

}


/**
Responsive on 767px
*/

// if (windowWidth <= 767) {
  $('.toggle-btn').on('click', function(){
    $(this).toggleClass('menu-expend');
    $('.toggle-bar ul').slideToggle(500);
  });


// }



// http://codepen.io/norman_pixelkings/pen/NNbqgG
// https://stackoverflow.com/questions/38686650/slick-slides-on-pagination-hover


/**
Slick slider
*/
if( $('.responsive-slider').length ){
    $('.responsive-slider').slick({
      dots: true,
      infinite: false,
      autoplay: true,
      autoplaySpeed: 2000,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
}




if( $('#mapID').length ){
var latitude = $('#mapID').data('latitude');
var longitude = $('#mapID').data('longitude');

var myCenter= new google.maps.LatLng(latitude,  longitude);
function initialize(){
    var mapProp = {
      center:myCenter,
      mapTypeControl:true,
      scrollwheel: false,
      zoomControl: true,
      disableDefaultUI: true,
      zoom:7,
      streetViewControl: false,
      rotateControl: true,
      mapTypeId:google.maps.MapTypeId.ROADMAP,
      styles: CustomMapStyles
      };

    var map= new google.maps.Map(document.getElementById('mapID'),mapProp);
    var marker= new google.maps.Marker({
      position:myCenter,
        //icon:'map-marker.png'
      });
    marker.setMap(map);
}
google.maps.event.addDomListener(window, 'load', initialize);

}



$('.consultation-item-hdr').on('click', function(){
  $(this).parent().addClass('consultation-item-expend');
  $(this).next().slideDown(300);
});

$('.consultation-item-close').on('click', function(){
  $(this).parent().removeClass('consultation-item-expend');
  $(this).parent().find('.consultation-item-con-cntlr').slideUp(300);
});


$('.consultation-item-open').on('click', function(){
  $(this).parent().addClass('consultation-item-expend');
  $(this).parent().find('.consultation-item-con-cntlr').slideDown(300);
});




$('.humbergur-btn').on('click', function(e){
  $('nav.main-nav').addClass('opacity-1');
  $('.bdoverlay').addClass('active');
  $('body').addClass('active-scroll-off');
  $(this).addClass('active-collapse');
});
$('.closebtn').on('click', function(e){
  $('.bdoverlay').removeClass('active');
  $('nav.main-nav').removeClass('opacity-1');
  $('body').removeClass('active-scroll-off');
  $('.line-icon').removeClass('active-collapse');
});

$('li.menu-item-has-children > a').on('click', function(e){
  e.preventDefault();
  $('li.menu-item-has-children .sub-menu').slideUp(300);
  $(this).toggleClass('sub-menu-active');
  $(this).next().slideDown(300);

});



$('.hdr-user-toggle-btn').on('click', function(){
  $(this).toggleClass('hdr-user-toggle-btn-expend');
  $('.hdr-user-toggle-menu').slideToggle(300);
});



//on keypress 
$('#confpass').keyup(function(e){
  //get values 
  var pass = $('#newpass').val();
  var confpass = $(this).val();
  
  //check the strings
  if(pass == confpass){
    //if both are same remove the error and allow to submit
    $('.error').text('');
    allowsubmit = true;
  }else{
    //if not matching show error and not allow to submit
    $('.error').text('Password not matching');
    allowsubmit = false;
  }
});

//jquery form submit
$('#change_pass_form').submit(function(){

  var pass = $('#newpass').val();
  var confpass = $('#confpass').val();

  //just to make sure once again during submit
  //if both are true then only allow submit
  if(pass == confpass){
    allowsubmit = true;
  }
  if(allowsubmit){
    return true;
  }else{
    return false;
  }
});


new WOW().init();

$('#clientform').submit(function(e){
  e.preventDefault();
  var inputVal = $("#clientinput").val();
  var keyword = inputVal.toLowerCase()
  var value = keyword.trim();
  console.log(value);
  $("#clientlist li").show().filter(function() {
    return $(this).text().toLowerCase().trim().indexOf(value) == -1;
  }).hide();

});

if( $('#has-chat').length ){
  var did = $('#has-chat').data('ti');
  if( $('.wcUsersList .wcUsersListContainer a[data-wp-id="3"]').length ){
    //$('.wcUsersList .wcUsersListContainer a[data-wp-id="3"]').trigger('click');
    $('.wcUsersList .wcUsersListContainer a[data-wp-id="3"]').click();
    console.log('hello1');
  }
}
var counter = 0;
$(document).on('mouseover mouseout', 'body', function(){
  if( counter == 0 ){
  var did = $('#has-chat').data('ti');
  setTimeout(function(){ $('.wcUsersList .wcUsersListContainer a[data-wp-id="'+did+'"]').click(); }, 3000);
  counter++;
  }
});

})(jQuery);

function searchResources(){
    
}