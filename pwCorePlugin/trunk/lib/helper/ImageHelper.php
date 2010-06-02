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
 * @param string  $img         Image URI
 * @param string  $link        Route link
 * @param mixed   $img_params  Add a 'alt' if it's a string, array of multiple
 *                             attributes otherwise
 * @since 1.2
 */
function clickable_image($img, $link, $img_params = array())
{
  if (is_string($img_params))
  {
    $img_params = array('alt' => $img_params);
  }

  return link_to(image_tag($img, $img_params), $link);
}
?>
