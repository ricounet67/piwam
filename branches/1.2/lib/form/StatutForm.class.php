<?php

/**
 * status form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class statusForm extends BasestatusForm
{
    /**
     * Customizes the status form. There is a lot of fields to unset in order
     * to re-create them from scratch with custom behaviour, especially the
     * hidden references (association, granted user id...)
     *
     * @since	r9
     */
    public function configure()
    {
        $associationId 	= sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user');
        $userId			= sfContext::getInstance()->getUser()->getAttribute('user_id', null, 'user');

        unset($this['created_at'], $this['updated_at']);
        unset($this['created_by'], 	$this['updated_by']);
        unset($this['state'], 			$this['association_id']);

        if ($this->getObject()->isNew()) {
            $this->widgetSchema['created_by'] = new sfWidgetFormInputHidden();
            $this->widgetSchema['association_id'] = new sfWidgetFormInputHidden();
            $this->setDefault('created_by', $userId);
            $this->setDefault('association_id', $associationId);
            $this->validatorSchema['association_id'] = new sfValidatorInteger();
            $this->validatorSchema['created_by'] = new sfValidatorInteger();
        }

        $this->widgetSchema['updated_by'] = new sfWidgetFormInputHidden();
        $this->widgetSchema['state'] = new sfWidgetFormInputHidden();
        $this->setDefault('state', 1);

        $this->validatorSchema['updated_by'] = new sfValidatorInteger();
        $this->validatorSchema['state'] = new sfValidatorBoolean();
        $this->validatorSchema['nom'] = new sfValidatorCustomUnique(array('class' => 'status', 'fields' => array('nom' => null, 'association_id' => $associationId)));
    }
}
