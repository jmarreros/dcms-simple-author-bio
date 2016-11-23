<?php

require_once plugin_dir_path( __FILE__ ).'class-dcms-sab-admin-options.php';


class Dcms_Simple_Author_Bio{

	const PATH_TEMPLATE =  '../template/box-author-bio.txt'; 

	private $dcms_options;


	public function __construct(){

		$this->dcms_options = new Dcms_Sab_Admin_Options();

		add_action('init',[$this,'dcms_sab_tranlation']);
		add_action('admin_menu',[$this,'dcms_sab_add_menu']);
		add_action('admin_init',[$this->dcms_options,'dcms_sab_admin_init']);
		add_filter( 'the_content', [$this,'dcms_sab_add_content_bio'] );

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
	*  Agregamos la información del autor al contenido
	*/
	public function dcms_sab_add_content_bio( $content ){

		if ( is_single() ){

			return $content.$this->get_author_bio();
		}

	}


	/*
	*  Para reemplazar las cadenas de la plantilla en el archivo box-author-bio.txt
	*/
	private function get_author_bio(){
		
		$template 	= file_get_contents( plugin_dir_path( __FILE__ ).self::PATH_TEMPLATE );

		if ( is_bool($template) ){
			return '';
		}

		$search		= ['{title}','{avatar}','{description}','{web}','{twitter}','{google}','{facebook}'];
		$twitter 	= get_the_author_meta( 'twitter' );

		$replace 	= [];
		$replace[] 	= get_the_author();
		$replace[] 	= get_avatar( get_the_author_meta( 'user_email' ) );
		$replace[] 	= get_the_author_meta( 'description');
		$replace[]	= get_the_author_meta( 'url' );
		$replace[]	= filter_var( $twitter  , FILTER_VALIDATE_URL) ? $twitter : 'https://twitter.com/'.$twitter;
		$replace[]	= get_the_author_meta( 'googleplus' );
		$replace[]	= get_the_author_meta( 'facebook' );

		return str_replace( $search, $replace, $template );

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
			if ( is_bool($options) && ! $options ){

			 	$options = [
			 				'chk_show_social' => 'on',
			 				'chk_new_window' => 'on' 
			 				];

				update_option('dcms_sab_bd_options',$options);

			}
	}


}

