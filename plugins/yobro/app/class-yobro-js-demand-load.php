<?php
namespace YoBro\App;
/**
* Class YoBro_Frontend_Scripts_Load_On_Demand
*/
class YoBro_Frontend_Scripts_Load_On_Demand{
	public function yobro_chat_box_js_load(){
		wp_enqueue_script( 'yobro-variables');
		wp_enqueue_script( 'app-frontend-vendor' );
		wp_enqueue_script( 'app-frontend');
	}
}
