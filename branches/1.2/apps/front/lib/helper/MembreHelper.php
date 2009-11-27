<?php
/**
 * Format a member object to display it correctly with a link
 * to it.
 *
 * @param 	Member    $member
 * @param	  boolean	  $pseudo : display only the pseudo
 * @return 	string
 * @since	  r8
 */
function format_member($member, $pseudo = false)
{
    if (! $member->getRawValue()->exists())
    {
        $str = '<i>Système</i>';
    }
    else
    {
        $str = '<a href="' . url_for('member/show?id=' . $member->getId()) . '">';

        if ($pseudo)
        {
            $str .= $member->getUsername();
        }
        else
        {
            $str .= $member->getFirstname() . ' ' .$member->getLastname();
        }
        $str .= '</a>';
    }

    return $str;
}
?>