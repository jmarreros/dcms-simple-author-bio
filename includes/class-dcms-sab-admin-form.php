<?php


class Dcms_Sab_Admin_Form{

	private $options;


	public function dcms_sab_create_admin_form(){

		$this->options = get_option( 'dcms_sab_bd_options' );

		?>
		<div class="wrap">

			<h2><?php _e('Simple Author Bio','dcms-simple-author-bio') ?></h2>
			
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
							__('Basic Configuration','dcms-simple-author-bio'), 
							[$this,'dcms_sab_section_callback_basic'], 
							'dcms_sab_options' );

		// Advanced
		add_settings_section('dcms_sab_advanced_section', 
							__('Advanced Configuration','dcms-simple-author-bio'), 
							[$this, 'dcms_sab_section_callback_advanced'], 
							'dcms_sab_options' );

		// Fields
		$this->dcms_sab_add_setting_field( __('Hide author without description','dcms-simple-author-bio'), 
											'dcms_sab_chk_hide_author', 
											'dcms_sab_basic_section',
											__('You can fill this info in your profile','dcms-simple-author-bio'));

		$this->dcms_sab_add_setting_field( __('Show social network box','dcms-simple-author-bio'), 
											'dcms_sab_chk_show_social', 
											'dcms_sab_basic_section',
											__('Show/hide social icons in front-end','dcms-simple-author-bio'));

		$this->dcms_sab_add_setting_field( __('Show link view all posts','dcms-simple-author-bio'), 
											'dcms_sab_chk_show_view_all', 
											'dcms_sab_basic_section',
											__('It shows/hide a link in the front-end','dcms-simple-author-bio'));
		
		$this->dcms_sab_add_setting_field( __('Load FontAwesome','dcms-simple-author-bio'), 
											'dcms_sab_chk_load_fontawesome', 
											'dcms_sab_advanced_section',
											__('If your theme load FontAwesome uncheck this','dcms-simple-author-bio'));
		
		$this->dcms_sab_add_setting_field( __('Load Default CSS','dcms-simple-author-bio'), 
											'dcms_sab_chk_load_css', 
											'dcms_sab_advanced_section',
											__('Default CSS plugin','dcms-simple-author-bio'));
		
		$this->dcms_sab_add_setting_field( __('Custom CSS','dcms-simple-author-bio'), 
											'dcms_sab_txtarea_customcss', 
											'dcms_sab_advanced_section',
											'',	
											'textarea');
	}


	public function dcms_sab_check_fields( $args ){

		$field 		 = $args[0];
		$msg		 = $args[1];

		$field_value = isset($this->options[$field]);

		echo '<input id="'.$field.'" name="dcms_sab_bd_options['.$field.']" '.checked($field_value, true, false).' type="checkbox" />';
		
		if ( !empty($msg) ) echo ' <i>'.$msg.'</i>';

	}


	public function dcms_sab_textarea_fields( $args ){

		$field 		 = $args[0];
		$field_value = $this->options[$field];

		echo '<textarea cols="80" rows="8" id="'.$field.'" name="dcms_sab_bd_options['.$field.']" >'.$field_value.'</textarea>';
	}


	public function dcms_sab_add_setting_field( $field_text , $field_name , $section , $message = '', $type = 'check'){

		add_settings_field('dcms_sab_fields_'.$field_name, 

							__( $field_text ,'dcms-simple-author-bio'), 

							[$this,'dcms_sab_'.$type.'_fields'], 
							'dcms_sab_options', 
							$section,
							[ $field_name, $message ]);
	}


	public function dcms_sab_section_callback_advanced(){
		echo '<hr/>';
	}

	public function dcms_sab_section_callback_basic(){
		echo '<hr/>';
		echo '<span>'.__('You can see additional social networks in your profile', 'dcms-simple-author-bio').'</span>';
	}

}

