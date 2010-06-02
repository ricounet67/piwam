<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Display an image with a HTML link to the route $link
 *
 * @param string  $img  : Image URI
 * @param string  $link : Route link
 * @since 1.2
 */
function clickable_image($img, $link, $img_params = array())
{
  return link_to(image_tag($img, $img_params), $link);
}
?>
