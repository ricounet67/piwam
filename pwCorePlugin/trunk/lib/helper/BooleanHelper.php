<?php
/**
 * All the following helpers are usefull to efficiently
 * display all boolean states.
 *
 * @since	r14
 */

/**
 * Transforms the boolean value to an icon
 *
 * @param   boolean	$state
 * @param   boolean $add_text_after true if add Yes/No text after boolean image (default false)
 * @return 	string
 * @since   r14
 */
function boolean2icon($state,$add_text_after = false)
{
  sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

  if ($state)
  {
    return image_tag('/pwCorePlugin/images/state_ok.png', array('alt' => 'Ok')).' '.($add_text_after ? 'Oui' : '');
  }
  else
  {
    return image_tag('/pwCorePlugin/images/state_ko.png', array('alt' => 'Ko')).' '.($add_text_after ? 'Non' : '');
  }
}
?>