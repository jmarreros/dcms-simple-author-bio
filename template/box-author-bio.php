<?php
/**
 * The template for displaying Author bio
 *
*/
?>

<div class="author-info">
	<h3 class="author-heading"><?php _e( 'Published by', 'dcms_sab' ); ?></h3>
	<div class="author-avatar">
		<?php
			echo get_avatar( get_the_author_meta( 'id' ) );
		?>
	</div>
</div>