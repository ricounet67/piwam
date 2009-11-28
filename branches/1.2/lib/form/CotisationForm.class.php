<?php

/**
 * Cotisation form.
 *
 * @package    piwam
 * @subpackage form
 * @author     Adrien Mogenet
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CotisationForm extends BaseCotisationForm
{
    /**
     * Customizes the Cotisation form. There is a lot of fields to unset in
     * order to re-create them from scratch with custom behaviour, especially
     * the hidden references (association, granted user id...)
     *
     * @since	r9
     */
    public function configure()
    {
        unset($this['created_at'], $this['updated_at']);
        unset($this['created_by'], $this['updated_by']);
        unset($this['state'], $this['association_id']);
        unset($this['date']);

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

        // select only Membre, CotisationType and account which
        // belong to the association id

        $id = sfContext::getInstance()->getUser()->getAttribute('association_id', null, 'user');
        $this->widgetSchema['membre_id']->setOption('criteria', MembrePeer::getCriteriaForAssociationId($id));
        $this->widgetSchema['cotisation_type_id']->setOption('criteria', CotisationTypePeer::getCriteriaForAssociationId($id));
        $this->widgetSchema['cotisation_type_id']->setOption('add_empty', true);
        $this->widgetSchema['account_id']->setOption('criteria', accountPeer::getCriteriaForAssociationId($id));

        $this->widgetSchema['account_id']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['cotisation_type_id']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['membre_id']->setAttribute('class', 'formInputLarge');
        $this->widgetSchema['amount']->setAttribute('class', 'formInputShort');

        $this->validatorSchema['state'] = new sfValidatorBoolean();
        $this->validatorSchema['amount'] = new sfValidatorAmount(array('min' => 0), array('min' => 'ne peut être négatif'));

        sfContext::getInstance()->getConfiguration()->loadHelpers("Asset");
        $this->widgetSchema['date'] = new sfWidgetFormJQueryDate(array(
			'image'		=> image_path('calendar.gif'),
  			'config' 	=> '{}',
			'culture'	=> 'fr_FR',
			'format'	=> '%day%.%month%.%year%',
        ));

        $this->setDefault('date', date('y-m-d'));
        $this->validatorSchema['date'] = new sfValidatorDate();
    }
}
