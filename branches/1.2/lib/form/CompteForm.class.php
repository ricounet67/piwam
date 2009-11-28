<?php

/**
 * account form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class accountForm extends BaseaccountForm
{
    /**
     * Customizes the account form. There is a lot of fields to unset in order
     * to re-create them from scratch with custom behaviour, especially the
     * hidden references (association, granted user id...)
     *
     * @since	r9
     */
    public function configure()
    {
        $associationId = $this->getOption('associationId');
        unset($this['created_at'], $this['updated_at']);
        unset($this['created_by'], $this['updated_by']);
        unset($this['state'], $this['association_id']);

        if ($this->getObject()->isNew())
        {
            $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
            $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
            $this->validatorSchema['association_id'] = new sfValidatorInteger();
            $this->validatorSchema['created_by'] = new sfValidatorInteger();
        }
        else
        {
            $this->widgetSchema['updated_by'] = new sfWidgetFormInputHidden();
            $this->validatorSchema['updated_by'] = new sfValidatorInteger();
        }

        $this->widgetSchema['state'] = new sfWidgetFormInputHidden();
        $this->setDefault('state', 1);

        $this->validatorSchema['state'] = new sfValidatorBoolean();
        $this->validatorSchema['reference'] = new sfValidatorCustomUnique(array('class' => 'account', 'fields' => array('reference' => null, 'association_id' => $associationId)));
        $this->validatorSchema['label'] = new sfValidatorCustomUnique(array('class' => 'account', 'fields' => array('label' => null, 'association_id' => $associationId)));

        $this->widgetSchema['label']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['reference']->setAttribute('class', 'formInputNormal');
        $this->setLabels();
    }

    /**
     * Set the label of the different fields
     */
    protected function setLabels()
    {
        $this->widgetSchema->setLabels(array(
            'label'   => 'Libellé',
            'reference' => 'Référence',
        ));
    }
}
