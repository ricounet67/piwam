<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Input : SentMail $email
 */
?>
<tr>
  <td><?php echo format_datetime($email->getCreatedAt(), 'dd/MM/yyyy à HH:mm') ?></td>
  <td><?php echo $email->getObject() ?></td>
  <td class="numbers"><?php echo $email->getSuccess() ?></td>
  <td class="numbers"><?php echo $email->getErrors() ?></td>
  <td><?php echo link_to(image_tag('/pwCorePlugin/images/icons/show', array('alt' => '[détails]')),   '@mailing_show?id=' . $email->getId()) ?></td>
</tr>