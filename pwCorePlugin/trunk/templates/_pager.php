<?php
/**
 * This partial displays a page list according to the
 * sfDoctrine object given as argument
 * Arguments required
 * - route : string route name to create link
 * - params : array with optionnal arguments
 * - pager : pager object
 */


/*
 * Perform the 'params' parameter and build a string
 * to add within our paging links
 */
if (isset($params))
{
    $urlParams = '';

    foreach ($params as $key => $value)
    {
        $urlParams .= '&' . $key . '=' . $value;
    }
}
?>

<?php if ($pager->haveToPaginate()): ?>
    <div id="pager">
        <ul id="pagination">

            <!-- Display 'previous' link, disabled if there is no previous page -->

            <?php if ($pager->getPage() > 1): ?>
                <li class="previous"><?php echo link_to('Page 1', $route . '?page=1' . $urlParams) ?></li>

            <?php else: ?>
                <li class="active">Page 1</li>
                <li class="next"><?php echo link_to('&raquo;', $route . '?page=2' . $urlParams) ?></li>
            <?php endif ?>
            
            <?php $links = $pager->getLinks(); ?>
            
            <?php if ($links[0] > 2): ?>
              <li class="previous-off">...</li>
            <?php endif ?>
            
            <!--  Generate page list. Apply a special style if this
                  is the current page  -->

            <?php foreach ($links as $page): ?>
                <?php if ($page == $pager->getLastPage() || $page == 1): ?>
                <?php elseif ($page == $pager->getPage()): ?>
                  <?php if($page > 2): ?>
                    <li class="previous"><?php echo link_to('&laquo;', $route . '?page=' . $pager->getPreviousPage() . $urlParams) ?></li>
                  <?php endif ?>
                  
                  <li class="active"><?php echo $page ?></li>
                  
                  <?php if($page < $pager->getLastPage() -1): ?>
                    <li class="next"><?php echo link_to('&raquo;', $route . '?page=' . $pager->getNextPage() . $urlParams) ?></li>
                  <?php endif ?>
                <?php else: ?>
                    <li><?php echo link_to($page, $route . '?page=' . $page . $urlParams) ?></li>
                <?php endif ?>
            <?php endforeach ?>


            <!-- Display 'next' link, disabled if there is no next page -->

            <?php if ($pager->getCurrentMaxLink() < $pager->getLastPage()-1): ?>
              <li class="next-off">...</li>
            <?php endif ?>
            
            <?php if ($pager->getPage() == $pager->getLastPage()): ?>
              <li class="previous"><?php echo link_to('&laquo;', $route . '?page=' . ($pager->getLastPage()-1) . $urlParams) ?></li>
              <li class="active">Page <?php echo $pager->getLastPage() ?></li>
            <?php else: ?>
              <li class="next"><?php echo link_to('Page '.$pager->getLastPage(), $route . '?page=' . $pager->getLastPage() . $urlParams) ?></li>
            <?php endif ?>
        </ul>
    </div>
<?php endif ?>
