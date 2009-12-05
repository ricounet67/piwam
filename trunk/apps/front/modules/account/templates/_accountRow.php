<?php
/*
 * Partial to display a Account object in a row
 * Input : Account $account
 */
?>

<tr id="account_<?php echo $account->getId() ?>">
    <td><?php echo $account->getLabel() ?></td>
    <td><?php echo $account->getReference() ?></td>
    <td><?php echo format_date($account->getCreatedAt()) ?></td>
    <td>
      <a href="<?php echo url_for('@account_by_id?id='.$account->getId()) ?>"><?php echo image_tag('icons/show.png', array('alt' => '[details]')); ?></a>
      <a href="<?php echo url_for('@account_edit?id='.$account->getId()) ?>"><?php echo image_tag('icons/edit.png', array('alt' => '[modifier]')); ?></a>
      <?php echo link_to(image_tag('icons/delete', array('alt' => '[supprimer]')), '@account_delete?id=' . $account->getId(), array('method' => 'delete', 'confirm' => 'Ètes vous sûr ?')); ?>
    </td>
</tr>