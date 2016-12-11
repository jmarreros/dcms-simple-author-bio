<?php

class Dcms_Contact_Methods{

	private $dcms_sab_social =[
        'twitter'       => 'Twitter',
        'googleplus'    => 'Google Plus',
        'facebook'      => 'Facebook',
        'github'        => 'Github',
        'linkedin'      => 'Linkedin',
        'pinterest'     => 'Pinterest',   
      	'youtube'		=> 'YouTube',
        'instagram'     => 'Instagram'
	];


	/*
	* Additional social networks
	*/
	public function dcms_sab_add_social_fields( $user_contact ){
		
		foreach ( $this->dcms_sab_social as $key => $value ) {
			$user_contact[$key] = $value;
		}
		
		return $user_contact;
	}


}