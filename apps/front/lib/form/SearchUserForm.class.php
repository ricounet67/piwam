<?php
/**
 * Represents the search form to search members
 *
 * @author adrien
 */
class SearchUserForm extends sfForm
{
    public function configure()
    {
        $this->setWidgets(array(
          'magic'           => new sfWidgetFormInput(),
          'associationId'   => new sfWidgetFormInputHidden(),
        ));

        $this->widgetSchema->setNameFormat('search[%s]');

        $this->setValidators(array(
          'magic'           => new sfValidatorString(array('required' => true)),
          'associationId'   => new sfValidatorInteger(array('required' => true)),
        ));

        $this->setDefault('associationId', $this->getOption('associationId'));
    }
}
?>