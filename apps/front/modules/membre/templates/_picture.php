<?php
/**
 * Display the picture of a member
 *
 * Inputs :
 *
 * 		- $picture  : URI of picture to display
 * 		- $name		: name of the member
 *
 * @since 	r139
 * @author 	Adrien Mogenet
 */
?>
<div class="user_picture">
	<?php echo image_tag($picture); ?>

	<div class="name">
	    <?php echo $name ?>
	</div>
</div>