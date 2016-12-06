<?php

require_once plugin_dir_path( __FILE__ ).'class-dcms-sab-admin-form.php';
require_once 'simple_html_dom.php';


class Dcms_Simple_Author_Bio{

	const PATH_TEMPLATE = '../template/box-author-bio.txt'; 
	const PATH_LANGUAGE = 'dcms-Simple-Author-Bio/languages';

	private $dcms_admin_form;
	private $dcms_options;

	public function __construct(){

		$this->dcms_admin_form  = new Dcms_Sab_Admin_Form();
		$this->dcms_options 	= get_option( 'dcms_sab_bd_options' );

		add_action('init',[$this,'dcms_sab_tranlation']);
		add_action('admin_menu',[$this,'dcms_sab_add_menu']);
		add_action('admin_init',[$this->dcms_admin_form,'dcms_sab_admin_init']);
		add_filter( 'the_content', [$this,'dcms_sab_add_content_bio'] );

		add_action( 'wp_enqueue_scripts', [$this,'dcms_sab_load_scripts_css'] );
	}


	/*
	*  Para cargar los estilos CSS
	*/
    public function dcms_sab_load_scripts_css() {

    	if ( isset( $this->dcms_options['chk_load_fontawesome'] ) ){
        	wp_enqueue_style( 'sab_font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
    	}

    	if ( isset( $this->dcms_options['chk_load_css'] ) ){
        	wp_enqueue_style( 'sab_custom_css', plugins_url( '../css/style.css', __FILE__ )  );
    	}
    
    }


	/*
	*  Creación del item de menú.
	*/
	public function dcms_sab_add_menu(){

		add_options_page(__('Author Biography Options','dcms-simple-author-bio'), 
							__('Author Bio','dcms-simple-author-bio'), 
							'manage_options', 
							'dcms_sab_options', 
							[$this, 'dcms_sab_settings_page'] 
							);
	}


	/*
	*  Creamos los controles del plugin
	*/
	public function dcms_sab_settings_page(){
		$this->dcms_admin_form->dcms_sab_create_admin_form();	
	}

	
	/*
	*  Agregamos la información del autor al contenido
	*/
	public function dcms_sab_add_content_bio( $content ){

		if ( is_single() ){

			$hide_author	= isset( $this->dcms_options['chk_hide_author'] );

			$show_all_posts	= isset( $this->dcms_options['chk_show_view_all'] );
			$show_social 	= isset( $this->dcms_options['chk_show_social'] );

			
			if ( get_the_author_meta('description') == '' &&  $hide_author ){
				return $content;
			}

			return $content.$this->get_author_bio( $show_social, $show_all_posts );

		}

	}


	/*
	*  Para reemplazar las cadenas de la plantilla en el archivo box-author-bio.txt
	*/
	private function get_author_bio( $show_social, $show_all_posts ){
		
		$template = file_get_html( plugin_dir_path( __FILE__ ).self::PATH_TEMPLATE );

		// Validaciones generales
		if ( empty($template) ) 	return;

		if ( ! $show_social ) 		$template->find('.author-social')[0]->outertext = '';
		if ( ! $show_all_posts )	$template->find('.author-show-all')[0]->outertext = '';


		// Validaciones para mostrar/ocultar las redes sociales individualmente
		$web		= get_the_author_meta('url');
		$twitter 	= get_the_author_meta('twitter');
		$facebook	= get_the_author_meta('facebook');
		$googleplus	= get_the_author_meta('googleplus');

		if ( empty($web) ) 			$template->find('.author-web')[0]->outertext = '';
		if ( empty($twitter) ) 		$template->find('.author-twitter')[0]->outertext = '';
		if ( empty($facebook) ) 	$template->find('.author-facebook')[0]->outertext = '';
		if ( empty($googleplus) ) 	$template->find('.author-googleplus')[0]->outertext = '';


		// Buscar y reemplazar en la plantilla
		$search		= ['{title}','{avatar}','{description}',
						'{web}','{twitter}','{googleplus}','{facebook}',
						'{show-all-author-url}','{show-all-author-text}'];

		$replace 	= [];
		$replace[] 	= get_the_author();
		$replace[] 	= get_avatar( get_the_author_meta( 'user_email' ) );
		$replace[] 	= get_the_author_meta( 'description');
		$replace[]	= $web;
		$replace[]	= filter_var( $twitter  , FILTER_VALIDATE_URL) ? $twitter : 'https://twitter.com/'.$twitter;
		$replace[]	= $googleplus;
		$replace[]	= $facebook;
		$replace[]	= esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
		$replace[]	= __('View all posts','dcms_simple_author_bio');


		return str_replace( $search, $replace, $template );
	}


	/*
	*  Para cargar los archivos de traducción Traducciones
	*/
	public function dcms_sab_tranlation(){

		load_plugin_textdomain('dcms-simple-author-bio', false, self::PATH_LANGUAGE );

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
			 				'chk_show_view_all'=> 'on',
☺☻			 				];

				update_option('dcms_sab_bd_options',$options);

			}
	}


}

