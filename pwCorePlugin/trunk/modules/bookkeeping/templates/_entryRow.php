<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Input :
 *
 *  Entry $entry
 */
use_helper('Image');
?>
<tr>
  <td class="center"><?php echo format_date($entry->getDate()) ?></td>
  <td><?php echo $entry->getLabel() ?></td>
  <td class="numbers"><?php echo format_currency($entry->getAmount()) ?></td>
  <td><?php echo clickable_image('/pwCorePlugin/images/icons/edit.png', 'bookkeeping/editEntry?id=' . $entry->getId()) ?></td>
</tr>