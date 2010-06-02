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
 *    Account $account
 *    Integer $depth
 */

use_helper('Image');
?>
<tr id="account_<?php echo $account->getId() ?>">
  <td class="account_id numbers">
    <?php echo $account->getCode() ?>
  </td>
  <td>
    <?php echo $account->getLabel() ?>
  </td>
  <td>
    <?php echo clickable_image('/pwCorePlugin/images/icons/profile', '@bk_overview', '[détails]') ?>
    <?php echo clickable_image('/pwCorePlugin/images/icons/edit', '@bk_overview', '[modifier]') ?>

    <?php if (! $account->hasChilds()): ?>
      <?php echo clickable_image('/pwCorePlugin/images/add', '@account_new?parent_id=' . $account->getId(), '[nouveau compte]') ?>
    <?php endif ?>
  </td>
</tr>

<!-- And then, list childs -->

<?php foreach($account->getChildAccounts() as $child): ?>
  <?php include_partial('accountRow', array('account' => $child, 'depth' => $depth + 1)) ?>
<?php endforeach ?>
