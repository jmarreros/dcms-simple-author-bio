<?php

require_once plugin_dir_path( __FILE__ ).'class-dcms-sab-admin-form.php';


class Dcms_Simple_Author_Bio{

	const PATH_TEMPLATE = '../template/box-author-bio.txt'; 
	const PATH_LANGUAGE = 'dcms-Simple-Author-Bio/languages';

	private $dcms_admin_form;
	private $dcms_options;

	public function __construct(){

		$this->dcms_admin_form  = new Dcms_Sab_Admin_Form();
		$this->dcms_options 	= get_option( 'dcms_sab_bd_options' );

		//add_action('init',[$this,'dcms_sab_tranlation']);
		add_action('admin_menu',[$this,'dcms_sab_add_menu']);
		add_action('admin_init',[$this->dcms_admin_form,'dcms_sab_admin_init']);
		add_filter( 'the_content', [$this,'dcms_sab_add_content_bio'] );

		add_action( 'wp_enqueue_scripts', [$this,'dcms_sab_load_font_awesome_css'] );
	}


	/*
	*  Para cargar los estilos CSS
	*/
    public function dcms_sab_load_font_awesome_css() {

    	if ( isset( $this->dcms_options['chk_load_fontawesome'] ) ){
        	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
    	}
    
    }



	/*
	*  Creación del item de menú.
	*/
	public function dcms_sab_add_menu(){

<<<<<<< HEAD
		add_options_page(__('Author Biography Options','dcms-simple-author-bio'), 
							__('Author Bio','dcms-simple-author-bio'), 
>>>>>>> 4fb71641226caf19becca553ab81a5913af6cce9
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

			$show_social 	= isset( $this->dcms_options['chk_show_social'] );
			$hide_author	= isset( $this->dcms_options['chk_hide_author'] );


			if ( get_the_author_meta('description') == '' &&  $hide_author ){
				return $content;
			}

			return $content.$this->get_author_bio( $show_social );
		}

	}


	/*
	*  Para reemplazar las cadenas de la plantilla en el archivo box-author-bio.txt
	*/
	private function get_author_bio( $show_social ){
		
		$template 	= file_get_contents( plugin_dir_path( __FILE__ ).self::PATH_TEMPLATE );

		if ( is_bool($template) ){
			return '';
		}

		$search		= ['{title}','{avatar}','{description}',
						'{web}','{twitter}','{google}','{facebook}',
						'{show-all-author}','{show-all-author-text}','{hide}'];

		$twitter 	= get_the_author_meta( 'twitter' );

		$replace 	= [];
		$replace[] 	= get_the_author();
		$replace[] 	= get_avatar( get_the_author_meta( 'user_email' ) );
		$replace[] 	= get_the_author_meta( 'description');
		$replace[]	= get_the_author_meta( 'url' );
		$replace[]	= filter_var( $twitter  , FILTER_VALIDATE_URL) ? $twitter : 'https://twitter.com/'.$twitter;
		$replace[]	= get_the_author_meta( 'googleplus' );
		$replace[]	= get_the_author_meta( 'facebook' );
		$replace[]	= esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
<<<<<<< HEAD

		$replace[]	= __('View all posts','dcms_simple_author_bio');
		$replace[]	= $show_social ? '' : 'style="display:none"';
>>>>>>> 4fb71641226caf19becca553ab81a5913af6cce9

		return str_replace( $search, $replace, $template );

	}


	/*
	*  Para cargar los archivos de traducción Traducciones
	*/
	public function dcms_sab_tranlation(){
<<<<<<< HEAD

		load_plugin_textdomain('dcms-simple-author-bio', false, self::PATH_LANGUAGE );

>>>>>>> 4fb71641226caf19becca553ab81a5913af6cce9
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
			 				];

				update_option('dcms_sab_bd_options',$options);

			}
	}


}

