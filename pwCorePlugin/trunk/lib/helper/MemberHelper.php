<?php

/**
 * Format a member object to display it correctly with a link
 * to it.
 *
 * @param 	Member    $member
 * @param	  boolean	  $pseudo : display only the pseudo
 * @param   string    $target : link target
 * @return 	string
 * @since	  r8
 */
function format_member($member, $pseudo = false, $target='_blank')
{
  
  $my_user = sfContext::getInstance()->getUser();
  if ($member instanceof sfOutputEscaper)
  {
    $member = $member->getRawValue();
  }
  $stateEnabled = false;
  if($member instanceof  Member)
  {
    $stateEnabled = $member->getState() == MemberTable::STATE_ENABLED;
    $username = $member->getUsername();
    
  }
  // sfGuardUser as member
  else {
    $stateEnabled = $member->getIsActive();
  }
  // normal members can't see other member details
  $seeLinkUrl = $stateEnabled && $my_user != null && $my_user->hasPermission('show_member');
  $str ='';
  if (! $member->exists())
  {
    $str = '<i>Système</i>';
  }
  else
  {
    if ($seeLinkUrl == true)
    {
      $str = '<a href="' . url_for('@member_show?id=' . $member->getId()) . '" target="' . $target . '">';
    }

    if ($pseudo)
    {
      $str .= $member->getUsername();
    }
    else
    {
      $str .= $member->getName();
    }

    if ($seeLinkUrl == true)
    {
      $str .= '</a>';
    }
    else if($stateEnabled == false)
    {
      $str .= ' (<i>supprimé</i>)';
    }
  }

  return $str;
}
?>