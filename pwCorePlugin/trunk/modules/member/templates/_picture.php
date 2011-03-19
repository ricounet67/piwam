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
<div class="user_picture" style="width:120px">
	<?php echo link_to(image_tag($member->getPictureURI(), array('alt' => $member,'width'=>'98%')), '@member_show?id=' . $member->getId()); ?>

	<div class="name">
	    <?php echo $member ?>
	</div>
</div>