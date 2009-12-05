<?php
/**
 * Display the picture of a member
 *
 * Inputs :
 *
 * 		- $member  : Membre object
 *
 * @since 	r139
 * @author 	Adrien Mogenet
 */
?>
<div class="user_picture">
	<?php echo link_to(image_tag($membre->getPictureURI(), array('alt' => $member)), '@member_show?id=' . $membre->getId()); ?>

	<div class="name">
	    <?php echo $member ?>
	</div>
</div>