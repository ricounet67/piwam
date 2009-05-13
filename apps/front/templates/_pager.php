<?php 
/*
 * This partial displays a page list according to the
 * sfPropelPager object given as argument
 */
?>

<?php 
/*
 * Perform the 'params' parameter and build a string
 * to add within our paging links
 */

if (isset($params))
{
    $urlParams = '';
    foreach ($params as $key => $value) {
        $urlParams .= '&' . $key . '=' . $value;
    }
}
?>

<div id="pager">
<ul id="pagination">

	<?php
	if ($pager->haveToPaginate())
	{
		// Display `previous` link
		if ($pager->getPage() > 1) {
			echo  '<li class="previous">' . link_to('&laquo; Précédent', $module . '/' . $action . '?page=' . $pager->getPreviousPage() . $urlParams) .  '</li>';
		}
		else {
			echo '<li class="previous-off">&laquo; Précédent</li>';
		}
		
		$links = $pager->getLinks();
		
		// Generate page list. Apply a special style if
		// this is the current page
		foreach ($links as $page) {
			if ($page == $pager->getPage()) { 
				echo '<li class="active">' . $page . '</li>';
			}
			else {
				echo '<li>' . link_to($page, $module . '/' . $action . '?page=' . $page . $urlParams) . '</li>';
			}
		}
		
		// Display `next` link
		if ($pager->getPage() == $pager->getCurrentMaxLink()) {
			echo '<li class="next-off">Suivant &raquo;</li>';	
		}
		else {
			echo '<li class="next">' . link_to('Suivant &raquo;', $module . '/' . $action . '?page=' . $pager->getNextPage() . $urlParams) . '</li>';
		}
	}
	?>

</ul>
</div>