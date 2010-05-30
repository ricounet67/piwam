<?php
/*
 * This file is part of the piwam package.
 * (c) Adrien Mogenet <adrien.mogenet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<tr>
  <td style="width: 20px; background-color: blue;">
    <?php echo $account->getId() ?>
  </td>
  <td>
    <?php echo $account->getLabel() ?>
  </td>
</tr>
<tr>
  <td  style="width: 20px; background-color: blue;">&nbsp;</td>
  <td>
    <table>
      <?php foreach($account->getChildAccounts() as $child): ?>
        <?php include_partial('accountRow', array('account' => $child)) ?>
      <?php endforeach ?>
    </table>
  </td>
</tr>