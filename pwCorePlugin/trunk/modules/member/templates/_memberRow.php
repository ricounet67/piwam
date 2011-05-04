<?php
/**
 * Partial which displays a Member object in a table row
 *
 * Input: Member $member
 */
?>

<?php if ($member->isActive() == false): ?>
  <tr class="memberDisabled" id="member_<?php echo $member->getId() ?>">
<?php elseif ($member->hasToPayDue()): ?>
  <tr class="hasToPayDue" id="member_<?php echo $member->getId() ?>">
<?php else: ?>
  <tr id="member_<?php echo $member->getId() ?>">
<?php endif ?>
    <td><?php echo $member->getLastname() ?></td>
    <td><?php echo $member->getFirstname() ?></td>
    <td><?php echo $member->getUsername() ?></td>
    <td><?php echo $member->getStatus() ?></td>
    <td><?php echo $member->getCity() ?></td>
    <td>
  
      <!-- Display validation icon only if the subscription is still pending -->
  
      <?php if ($member->getState() == MemberTable::STATE_PENDING): ?>
        <?php echo link_to(image_tag('/pwCorePlugin/images/state_ok.png', array('alt' => '[valider]')), '@member_validate?id=' . $member->getId()) ?>
      <?php endif ?>
  
      <!-- Display email icon if an email has been set -->
  
      <?php if ($member->hasEmail()) :?>
        <?php echo mail_to($member->getEmail(), image_tag('/pwCorePlugin/images/icons/email.png', array('alt' => '[e-mail]'))) ?>
      <?php else: ?>
        <?php echo image_tag('/pwCorePlugin/images/icons/no_email.png', array('alt' => '[pas d\'adresse]')) ?>
      <?php endif ?>
      
      <?php 
      if($sf_user->hasCredential('show_member'))
      {
         echo link_to(image_tag('/pwCorePlugin/images/icons/profile', array('alt' => '[détails]')),   '@member_show?id=' . $member->getId());
      } 
      if($member->isActive())
      {
        if($sf_user->hasCredential('edit_member'))
        {
          echo link_to(image_tag('/pwCorePlugin/images/icons/edit',    array('alt' => '[modifier]')),  '@member_edit?id=' . $member->getId());
        }
        if($sf_user->hasCredential('del_member'))
        {
           include_partial('global/deleteButton',  array('route' => '@member_delete', 'id' => $member->getId(), 'objectMessage' => 'désactiver ce membre')); 
        }
      }
      ?>
    </td>
</tr>