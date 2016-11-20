<?php


class Dcms_Sab_Admin_Options{

	private $options;

	public function dcms_sab_create_admin_form(){

		$this->options = get_option( 'dcms_sab_bd_options' );

		?>
		<div class="wrap">

			
			<h2><?php _e('Simple Author Bio','dcms_sab') ?></h2>
			
			<form action="options.php" method="post">
				<?php
					
					settings_fields('dcms_sab_options_group');
					do_settings_sections('dcms_sab_options');

					submit_button();
				?>
			</form>
		</div>

		<?php

	}

	
	public function dcms_sab_admin_init(){

		register_setting('dcms_sab_options_group', 
							'dcms_sab_bd_options');
		
		add_settings_section('dcms_sab_main_section', 
								__('Basic Configuration','dcms_sab'), 
								[$this,'dcms_sab_section_callback'], 
								'dcms_sab_options' );

		add_settings_field('dcms_sab_fields_hide_author_id', 
							__('Hide author without description','dcms_sab'), 
							[$this,'dcms_sab_fields_hide_author'], 
							'dcms_sab_options', 
							'dcms_sab_main_section');

		add_settings_field('dcms_sab_fields_show_social_id', 
							__('Show social network','dcms_sab'), 
							[$this,'dcms_sab_fields_show_social'], 
							'dcms_sab_options', 
							'dcms_sab_main_section');


	}


	public function dcms_sab_fields_hide_author(){

		$hide_author 	= isset($this->options['chk_hide_author']);

		echo '<input id="chk_hide_author" name="dcms_sab_bd_options[chk_hide_author]" '.checked($hide_author, true, false).' type="checkbox" />';

	}

	public function dcms_sab_fields_show_social(){

		$chk_show_social	= isset($this->options['chk_show_social']);

		echo '<input id="chk_show_social" name="dcms_sab_bd_options[chk_show_social]" '.checked($chk_show_social, true, false).' type="checkbox" />';

	}

	
	public function dcms_sab_section_callback(){
		echo '<hr/>';
	}


	/*
	* Validacion de la data devuelta
	*/
	// public function retrive_value_option( $key , $default ){

	// 	$options 	= get_option('dcms_sab_bd_options');
	// 	$val 		= $default;		

	// 	if ( is_array($options) ){
	// 		$val 	= array_key_exists( $key, $options ) ? $options[$key] : $default;
	// 	}

	// 	return $val;
	// }


	function dcms_sab_options_validate( $input ){
		return $input;
	}

}


