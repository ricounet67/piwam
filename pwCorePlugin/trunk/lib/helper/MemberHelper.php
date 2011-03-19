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
  // normal members can't see other member details
  $seeLinkUrl = $member->getState() == MemberTable::STATE_ENABLED && 
      $my_user != null && $my_user->hasPermission('show_member');
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
      $str .= $member->getFirstname() . ' ' .$member->getLastname();
    }

    if ($seeLinkUrl == true)
    {
      $str .= '</a>';
    }
    else if($member->getState() == MemberTable::STATE_DISABLED)
    {
      $str .= ' (<i>supprimé</i>)';
    }
  }

  return $str;
}
?>