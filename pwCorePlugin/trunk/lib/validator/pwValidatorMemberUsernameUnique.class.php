<?php
/**
 * pwValidatorMemberUsername validates username unique in association
 *
 * @package    piwam
 * @subpackage validator
 * @author     Jerome Fouilloy
 * @version    SVN: $Rev$
 */
class pwValidatorMemberUsernameUnique extends sfValidatorString
{
    /**
     * Configures the current validator.
     *
     * Available options:
     *
     *  * member_id: the member id current editing, 
     *
     * Available error codes:
     *
     *  * already_exist: error if already exist in base
     *
     * @param array $options   An array of options
     * @param array $messages  An array of error messages
     *
     * @see sfValidatorBase
     */
    protected function configure($options = array(), $messages = array())
    {
        $this->addMessage('already_exist', 'Le pseudo %value% existe déjà en base.');

        $this->addOption('member_id');
        $this->setMessage('invalid', 'Invalide');
    }

    /**
     * @see sfValidatorBase
     */
    protected function doClean($value)
    {
      if($value == '')
      {
        return $value;
      }
      $result = sfGuardUserTable::getInstance()->findByUsername($value);
      foreach($result as $user)
      {
        if ($this->getOption('member_id') != $user->getId())
        {
            throw new sfValidatorError($this, 'already_exist', array('value' => $value));
        }
      }
      return $value;
    }
}