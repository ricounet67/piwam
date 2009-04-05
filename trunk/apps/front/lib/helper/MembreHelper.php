<?php 
/**
 * Format a Membre object to display it correctly with a link
 * to it.
 * 
 * @param 	Membre 	$membre
 * @param	boolean	$pseudo : display only the pseudo
 * @return 	string
 * @since	r8
 */
function format_membre(Membre $membre, $pseudo = false)
{
	$str = '<a href="' . url_for('membre/show?id=' . $membre->getId()) . '">';
	if ($pseudo) {
		$str .= $membre->getPseudo();
	}
	else {
		$str .= $membre->getPrenom() . ' ' .$membre->getNom();
	}
	$str .= '</a>';
	
	return $str;
}
?>