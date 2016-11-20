<?php

require_once plugin_dir_path( __FILE__ ).'options.php';


class Dcms_Simple_Author_Bio{

	private $dcms_options;

	public function __construct(){

		$this->dcms_options = new Dcms_Sab_Admin_Options();

		add_action('init',[$this,'dcms_sab_tranlation']);
		add_action('admin_menu',[$this,'dcms_sab_add_menu']);
		add_action('admin_init',[$this->dcms_options,'dcms_sab_admin_init']);

	}


	/*
	*  Creación del item de menú.
	*/
	public function dcms_sab_add_menu(){

		add_options_page(__('Author Biography Options','dcms_sab'), 
							__('Author Bio','dcms_sab'), 
							'manage_options', 
							'dcms_sab_options', 
							[$this, 'dcms_sab_settings_page'] 
							);
	}



	/*
	*  Creamos los controles del plugin
	*/
	public function dcms_sab_settings_page(){
		$this->dcms_options->dcms_sab_create_admin_form();	
	}



	/*
	*  Para cargar los archivos de traducción Traducciones
	*/
	public function dcms_sab_tranlation(){
		load_plugin_textdomain('dcms_sab', false, plugin_dir_path( __FILE__ ).'/languages' );
	}


	/*
	*  Activación del plugin
	*/
	public function dcms_sab_activate(){

			delete_option('dcms_sab_bd_options');
			
			$options 	= get_option('dcms_sab_bd_options');

			// Retorna false cuando no existe, en otros casos siempre retorna un valor asi sea vacío ''
			if ( is_bool($options) ){

			 	$options = ['chk_show_social' => 'on'];

				update_option('dcms_sab_bd_options',$options);
			
			}

	}


	// }

	/*
	*  Desactivación del plugin
	*/
	// public function dcms_sab_desactivate(){
	// }


}

