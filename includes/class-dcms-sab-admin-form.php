<?php


class Dcms_Sab_Admin_Form{

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
		
		// Basic
		add_settings_section('dcms_sab_basic_section', 
							__('Basic Configuration','dcms_sab'), 
							[$this,'dcms_sab_section_callback'], 
							'dcms_sab_options' );

		// Advanced
		add_settings_section('dcms_sab_advanced_section', 
							__('Advanced Configuration','dcms_sab'), 
							[$this,'dcms_sab_section_callback'], 
							'dcms_sab_options' );

		// Fields
		$this->dcms_sab_add_setting_field( 'Hide author without description', 'chk_hide_author', 'dcms_sab_basic_section');
		$this->dcms_sab_add_setting_field( 'Show social network', 'chk_show_social', 'dcms_sab_basic_section');
		$this->dcms_sab_add_setting_field( 'Load FontAwesome', 'chk_load_fontawesome', 'dcms_sab_advanced_section');
		$this->dcms_sab_add_setting_field( 'Load Default CSS', 'chk_load_css', 'dcms_sab_advanced_section');
		$this->dcms_sab_add_setting_field( 'Custom CSS', 'txtarea_customcss', 'dcms_sab_advanced_section','textarea');

	}


	public function dcms_sab_check_fields( $args ){

		$field 		 = $args[0];
		$field_value = isset($this->options[$field]);

		echo '<input id="'.$field.'" name="dcms_sab_bd_options['.$field.']" '.checked($field_value, true, false).' type="checkbox" />';
	}


	public function dcms_sab_textarea_fields( $args ){

		$field 		 = $args[0];
		$field_value = $this->options[$field];

		echo '<textarea cols="80" rows="8" id="'.$field.'" name="dcms_sab_bd_options['.$field.']" >'.$field_value.'</textarea>';
	}


	public function dcms_sab_add_setting_field( $field_text , $field_name , $section ,$type = 'check'){

		add_settings_field('dcms_sab_fields_'.$field_name, 
							__( $field_text ,'dcms_sab'), 
							[$this,'dcms_sab_'.$type.'_fields'], 
							'dcms_sab_options', 
							$section,
							[$field_name]);
	}


	public function dcms_sab_section_callback(){
		echo '<hr/>';
	}


}

