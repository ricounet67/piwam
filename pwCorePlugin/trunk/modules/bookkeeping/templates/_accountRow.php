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
?>
<tr id="account_<?php echo $account->getId() ?>">
  <td class="account_id numbers">
    <?php echo $account->getId() ?>
  </td>
  <td>
    <?php echo $account->getLabel() ?>
  </td>
  <td>
    <?php echo link_to(image_tag('/pwCorePlugin/images/icons/profile', array('alt' => '[détails]')),   '@bk_overview') ?>
    <?php echo link_to(image_tag('/pwCorePlugin/images/icons/edit',    array('alt' => '[modifier]')),  '@bk_overview') ?>

    <?php if (! $account->hasChilds()): ?>
      <?php echo link_to(image_tag('/pwCorePlugin/images/add', array('alt' => '[modifier]')),  '@bk_new_account?parent_id=' . $account->getId()) ?>
    <?php endif ?>
  </td>
</tr>

<!-- And then, list childs -->

<?php foreach($account->getChildAccounts() as $child): ?>
  <?php include_partial('accountRow', array('account' => $child, 'depth' => $depth + 1)) ?>
<?php endforeach ?>
