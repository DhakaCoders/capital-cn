<?php
add_action( 'vc_before_init', 'redq_yobro_visual_composer_function' );
function redq_yobro_visual_composer_function(){
	vc_map(
		array(
			"name"       => esc_html__( "Yo Bro Chat Box", "yobro" ),
			"base"       => "yobro_chatbox",
			"class"      => "",
			"category"   => esc_html__( "Pages", "yobro"),
			"params" => array()
		)
	);
	// Yo Bro Notification Box Shortcode
	vc_map(
		array(
			'name'      => esc_html__('Yo Bro Chat Notification', 'yobro'),
			'base'      => 'yobro_chat_notification',
			'class'     => '',
			'category'  => esc_html__('Pages', 'yobro'),
			'params' => array()
		)
	);
}
